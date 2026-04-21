<?php

namespace App\Http\Controllers\Rekrut;

use App\Http\Controllers\Controller;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * =========================
     * LIST LOKER
     * =========================
     */
    public function index()
{
   $jobs = Job::with(['departmentRel', 'locationRel'])
    ->withCount('applicants')
    ->latest()
    ->paginate(10);

    return view('recruitment.jobs.index', compact('jobs'));
}


    /**
     * =========================
     * FORM CREATE LOKER
     * =========================
     */
    public function create()
    {
        return view('recruitment.jobs.create');
    }

    /**
     * =========================
     * SIMPAN LOKER BARU
     * =========================
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'department'  => 'nullable|string|max:255',
            'location'    => 'nullable|string|max:255',
            'status'      => 'required|in:open,closed',
        ]);

        Job::create($data);

        return redirect()
            ->route('recruitment.jobs.index')
            ->with('success', 'Lowongan berhasil dibuat!');
    }

    /**
     * =========================
     * FORM EDIT LOKER
     * =========================
     */
    public function edit(Job $job)
    {
        return view('recruitment.jobs.edit', compact('job'));
    }

    /**
     * =========================
     * UPDATE LOKER
     * =========================
     */
    public function update(Request $request, Job $job)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'department'  => 'nullable|string|max:255',
            'location'    => 'nullable|string|max:255',
            'status'      => 'required|in:open,closed',
        ]);

        $job->update($data);

        return redirect()
            ->route('recruitment.jobs.index')
            ->with('success', 'Lowongan berhasil diperbarui!');
    }

    /**
     * =========================
     * HAPUS LOKER
     * =========================
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()
            ->route('recruitment.jobs.index')
            ->with('success', 'Lowongan berhasil dihapus!');
    }

    public function toggleStatus(Job $job)
{
    $job->update([
        'status' => $job->status === 'open' ? 'closed' : 'open'
    ]);

    return back()->with('success', 'Status lowongan berhasil diubah');
}


    /**
     * =========================
     * DETAIL LOKER
     * =========================
     */
    public function show(Job $job)
    {
        return view('recruitment.jobs.show', compact('job'));
    }
}
