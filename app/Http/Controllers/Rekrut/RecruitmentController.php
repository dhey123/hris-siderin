<?php

namespace App\Http\Controllers\Rekrut;

use App\Http\Controllers\Controller;

use App\Models\Job;
use App\Models\RecruitmentApplicant;
use App\Models\RecruitmentNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;

class RecruitmentController extends Controller
{
    
    public function index()
    {
        
        // Ambil semua lowongan yang masih open
        $jobs = Job::where('status', 'open')
            ->latest()
            ->get();

        return view('career.index', compact('jobs'));
    }

    public function createOffline()
    {
        $jobs = Job::where('status', 'open')->get();
        return view('recruitment.offline.create', compact('jobs'));
    }

    public function storeOffline(Request $request)
    {
        $request->validate([
            'nik'   => 'required|string|max:20',
            'job_id' => 'required|exists:jobs,id',
            'name'   => 'required|string|max:255',
            'phone'  => 'required|string|max:50',
            'cv'     => 'required|file|mimes:pdf,doc,docx|max:2048',
            'referral_name' => 'nullable|string|max:255',
            'referral_relation' => 'nullable|string|max:50',
        ]);

        // 🚫 Cek NIK yang sudah pernah final
        $exists = RecruitmentApplicant::where('nik', $request->nik)
            ->whereIn('status', ['approved', 'rejected'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['nik' => 'NIK ini sudah pernah melamar dan tidak bisa mendaftar lagi.']);
        }

        // EMAIL DUMMY (BIAR GAPTEK AMAN)
        $email = $request->email ?: 'offline_' . uniqid() . '@internal.local';

        // UPLOAD CV
        $cvPath = $request->file('cv')->store('recruitment/cv', 'public');

        $job = Job::findOrFail($request->job_id);

        $applicant = RecruitmentApplicant::create([
            'nik' => $request->nik,
            'job_id' => $job->id,
            'name' => $request->name,
            'email' => $email,
            'phone' => $request->phone,
            'position' => $job->title,
            'cv' => $cvPath,
            'application_type' => 'offline',
            'referral_name' => $request->referral_name,
            'referral_relation' => $request->referral_relation,
            'status' => 'pending',
        ]);

        RecruitmentNote::create([
            'recruitment_applicant_id' => $applicant->id,
            'stage' => 'screening',
            'note' => 'Lamaran offline / titipan',
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('recruitment.applicants.index')
            ->with('success', 'Pelamar offline berhasil disimpan');
    }

    // =========================
    // HALAMAN APPLY ONLINE
    // =========================
    public function apply(Job $job)
    {
        abort_if($job->status !== 'open', 404);
        return view('career.apply', compact('job'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'nik'    => 'required|string|max:20',
        'job_id' => 'required|exists:jobs,id',
        'name'   => 'required|string|max:255',
        'email'  => 'required|email|max:255',
        'phone'  => 'nullable|string|max:50',
        'cv'     => 'required|file|mimes:pdf,doc,docx|max:2048',
    ]);

    // 🚫 SOFT BLACKLIST (FINAL BLOCK)
    $blacklisted = RecruitmentApplicant::where('nik', $data['nik'])
        ->where('is_blacklisted', true)
        ->exists();

    if ($blacklisted) {
        return back()->withErrors([
            'nik' => 'NIK ini tidak dapat melakukan pendaftaran.'
        ]);
    }

    // 🚫 Cek NIK masih punya lamaran aktif
    $exists = RecruitmentApplicant::where('nik', $data['nik'])
        ->whereIn('status', ['pending', 'approved'])
        ->exists();

    if ($exists) {
        return back()->withErrors([
            'nik' => 'NIK ini masih memiliki proses lamaran aktif.'
        ]);
    }

    $job = Job::findOrFail($data['job_id']);

    $data['cv'] = $request->file('cv')->store('recruitment/cv', 'public');
    $data['position'] = $job->title;
    $data['application_type'] = 'online';
    $data['status'] = 'pending';

    $applicant = RecruitmentApplicant::create($data);

    RecruitmentNote::create([
        'recruitment_applicant_id' => $applicant->id,
        'stage' => 'screening',
        'note' => 'Lamaran masuk dari career page',
        'user_id' => null,
    ]);

    return redirect()
        ->route('career.index')
        ->with('success', 'Lamaran online berhasil dikirim');
}


    public function toggleBlacklist(Request $request, $id)
    {
        $applicant = RecruitmentApplicant::findOrFail($id);

        $request->validate([
            'blacklist_reason' => 'nullable|string|max:255',
        ]);

        if ($applicant->is_blacklisted) {
            // UNBLACKLIST
            $applicant->update([
                'is_blacklisted' => false,
                'blacklist_reason' => null,
            ]);

            return back()->with('success', 'Pelamar dikeluarkan dari blacklist');
        }

        // BLACKLIST
        $applicant->update([
            'is_blacklisted' => true,
            'blacklist_reason' => $request->blacklist_reason,
        ]);

        return back()->with('success', 'Pelamar berhasil di-blacklist');
    }

    public function applicants(Request $request)
    {
        $query = RecruitmentApplicant::with(['job', 'latestNote'])
            ->latest();

        // FILTER TAB (ONLINE / OFFLINE)
        if ($request->filled('tab')) {
            if ($request->tab === 'online') {
                $query->where('application_type', 'online');
            }

            if ($request->tab === 'offline') {
                $query->where('application_type', 'offline');
            }
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // FILTER BLACKLIST
        if ($request->filled('blacklist')) {
            $query->where('is_blacklisted', $request->blacklist);
        }

        // Ambil semua untuk hitung badge
        $allApplicants = $query->get();

        // HITUNG BADGE berdasarkan hasil filter
        $totalPending = $allApplicants->where('status','pending')->count();
        $totalApproved  = $allApplicants->where('status','approved')->count();
        $totalRejected  = $allApplicants->where('status','rejected')->count();
        $totalBlacklist = $allApplicants->where('is_blacklisted',1)->count();

        // ================================
// GROUP PER NIK → gabung semua referral
// ================================
$groupedApplicants = $allApplicants->groupBy('nik')->map(function($group){
    $first = $group->first();

    $referrals = $group->map(function($item){
        return [
            'name' => $item->referral_name ?? '-',
            'relation' => $item->referral_relation ?? 'Internal',
            'email' => $item->email,
            'phone' => $item->phone,
            'job_title' => $item->job->title ?? '-',
            'cv' => $item->cv,
            'status' => $item->status,
            'latestNote' => $item->latestNote->note ?? '-',
            'stage' => $item->latestNote->stage ?? null,
            'is_blacklisted' => $item->is_blacklisted,
        ];
    });

    $first->referralsMerged = $referrals;
    return $first;
})->values(); // pastikan ini tetap $groupedApplicants

// PAGINATE setelah group → supaya tetap bisa navigasi
$perPage = 10;
$currentPage = request()->get('page', 1);
$paginated = new LengthAwarePaginator(
    $groupedApplicants->forPage($currentPage, $perPage),
    $groupedApplicants->count(),
    $perPage,
    $currentPage,
    ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('recruitment.applicants.index', [
            'applicants' => $paginated,
            'totalPending' => $totalPending,
            'totalApproved' => $totalApproved,
            'totalRejected' => $totalRejected,
            'totalBlacklist' => $totalBlacklist,
        ]);
    }

    public function show(RecruitmentApplicant $applicant)
    {
        $applicant->load(['job', 'notes.user']);
        return view('recruitment.applicants.show', compact('applicant'));
    }

    public function updateStatus(Request $request, RecruitmentApplicant $applicant)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($request->status === 'approved') {
            $approvedCount = RecruitmentApplicant::where('job_id', $applicant->job_id)
                ->where('status', 'approved')
                ->count();

            if ($applicant->job->quota !== null && $approvedCount >= $applicant->job->quota) {
                return back()->with('error', 'Kuota penerimaan sudah terpenuhi.');
            }
        }

        $applicant->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pelamar berhasil diperbarui.');
    }

    public function updateStage(Request $request, RecruitmentApplicant $applicant)
    {
        $request->validate([
            'stage' => 'required|in:screening,interview,psikotes,test_kerja,mcu,komitmen',
            'note' => 'nullable|string|max:500',
        ]);

        RecruitmentNote::create([
            'recruitment_applicant_id' => $applicant->id,
            'stage' => $request->stage,
            'note' => $request->note ?? 'Update tahapan',
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Tahapan pelamar berhasil diperbarui.');
    }

    public function downloadCV(RecruitmentApplicant $applicant)
    {
        if (
            !$applicant->cv ||
            !Storage::disk('public')->exists($applicant->cv)
        ) {
            abort(404, 'CV tidak ditemukan');
        }

        return Storage::disk('public')->download($applicant->cv);
    }
}
