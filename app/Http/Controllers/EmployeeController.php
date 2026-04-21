<?php

namespace App\Http\Controllers;
use App\Imports\EmployeesImport;
use Barryvdh\DomPDF\Facade\Pdf; 
use App\Exports\EmployeeTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeesDataExport;

use App\Models\EmployeeHistory;
use App\Models\RecruitmentApplicant;
use App\Models\Employee;
use App\Models\Company;
use App\Models\Department;
use App\Models\Position;
use App\Models\Religion;
use App\Models\MaritalStatus;
use App\Models\Education;
use App\Models\EmploymentStatus;
use App\Models\EmploymentType;
use App\Models\Bank;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class EmployeeController extends Controller
{
    // ============================
    // INDEX + SEARCH + FILTER + TOTAL
    // ============================
    public function index(Request $request)
    {
        $employees = Employee::with([
            'company',
            'department',
            'position',
            'religion',
            'maritalStatus',
            'education',
            'employmentStatus',
            'employmentType',
            'bank',
            'familyMembers'
        ]);

        // SEARCH
       // ================= SEARCH =================
if ($request->filled('search')) {
    $search = $request->search;

    $employees->where(function ($q) use ($search) {
        $q->where('full_name', 'like', "%{$search}%")
          ->orWhere('nik', 'like', "%{$search}%")
          ->orWhere('id_karyawan', 'like', "%{$search}%")

          ->orWhereHas('company', function ($c) use ($search) {
              $c->where('company_name', 'like', "%{$search}%");
          })

          ->orWhereHas('department', function ($d) use ($search) {
              $d->where('department_name', 'like', "%{$search}%");
          });
    });
}

// ================= FILTER =================
if ($request->company && $request->company !== 'all') {
    $employees->whereHas('company', function ($q) use ($request) {
        $q->where('company_name', $request->company);
    });
}

if ($request->type && $request->type !== 'all') {
    $employees->whereHas('employmentType', function ($q) use ($request) {
        $q->where('type_name', $request->type);
    });
}

if ($request->department && $request->department !== 'all') {
    $employees->where('department_id', $request->department);
}

if ($request->status && $request->status !== 'all') {
    $employees->where('employment_status_id', $request->status);
}
 $employees->where('status', 'Active');
 
        // PAGINATION
        $employees = $employees
        ->orderBy('company_id')   // ini buat urut company dulu
        ->orderBy('full_name')    // baru urut nama
        ->paginate(10)
        ->withQueryString();

        // ===============================
// TOTAL GLOBAL UNTUK HEADER
// ===============================
$totalStaff = Employee::where('status', 'Active')
    ->whereHas('employmentType', fn($q) => $q->where('type_name', 'Staff'))
    ->count();

$totalProduksi = Employee::where('status', 'Active')
    ->whereHas('employmentType', fn($q) => $q->where('type_name', 'Produksi'))
    ->count();

$totalBorongan = Employee::where('status', 'Active')
    ->whereHas('employmentType', fn($q) => $q->where('type_name', 'Borongan'))
    ->count();


// ===============================
// AMBIL COMPANY ID (AMAN NULL)
// ===============================
$quantumId = Company::where('company_name', 'Quantum')->value('id');
$unilandId = Company::where('company_name', 'Uniland')->value('id');


// ===============================
// QUANTUM TOTAL
// ===============================
$totalQuantumStaff = Employee::where('status', 'Active')
    ->where('company_id', $quantumId)
    ->whereHas('employmentType', fn($q) => $q->where('type_name', 'Staff'))
    ->count();

$totalQuantumProduksi = Employee::where('status', 'Active')
    ->where('company_id', $quantumId)
    ->whereHas('employmentType', fn($q) => $q->where('type_name', 'Produksi'))
    ->count();

$totalQuantumBorongan = Employee::where('status', 'Active')
    ->where('company_id', $quantumId)
    ->whereHas('employmentType', fn($q) => $q->where('type_name', 'Borongan'))
    ->count();


// ===============================
// UNILAND TOTAL
// ===============================
$totalUnilandStaff = Employee::where('status', 'Active')
    ->where('company_id', $unilandId)
    ->whereHas('employmentType', fn($q) => $q->where('type_name', 'Staff'))
    ->count();

$totalUnilandProduksi = Employee::where('status', 'Active')
    ->where('company_id', $unilandId)
    ->whereHas('employmentType', fn($q) => $q->where('type_name', 'Produksi'))
    ->count();

$totalUnilandBorongan = Employee::where('status', 'Active')
    ->where('company_id', $unilandId)
    ->whereHas('employmentType', fn($q) => $q->where('type_name', 'Borongan'))
    ->count();


// ===============================
// BORONGAN GLOBAL SIDEBAR
// ===============================
$totalBoronganSidebar = Employee::where('status', 'Active')
    ->whereHas('employmentType', fn($q) => $q->where('type_name', 'Borongan'))
    ->count();
        
$kontrakHabis = Employee::kontrakAkanHabis()
    ->where('status', 'Active')
    ->get();

        return view('hr.karyawan.index', [
        'employees'            => $employees,
        'companies'            => Company::all(),
        'departments'          => Department::all(),
        'types'                => EmploymentType::all(),
        'statuses'             => EmploymentStatus::all(),
        'selectedCompany'      => $request->company,
        'selectedType'         => $request->type,
        'selectedDept'         => $request->department,
        'selectedStatus'       => $request->status,
        'search'               => $request->search,
        'kontrakHabis' => $kontrakHabis,

        // TOTALS GLOBAL (HEADER)
    'totalStaff'           => $totalStaff,
    'totalProduksi'        => $totalProduksi,
    'totalBoronganGlobal'  => $totalBorongan, // kasih nama beda supaya nggak tabrakan

    // TOTALS PER COMPANY/TYPE (SIDEBAR)
    'totalQuantumStaff'    => $totalQuantumStaff,
    'totalQuantumProduksi' => $totalQuantumProduksi,
    'totalUnilandStaff'    => $totalUnilandStaff,
    'totalUnilandProduksi' => $totalUnilandProduksi,
     'totalBoronganSidebar'  => $totalBoronganSidebar,
]);

    }

    // ============================
    // CREATE
    // ============================
    public function create()
    {
        return view('hr.karyawan.create', [
            'companies'           => Company::all(),
            'departments'         => Department::all(),
            'positions'           => Position::all(),
            'religions'           => Religion::all(),
            'marital_statuses'    => MaritalStatus::all(),
            'educations'          => Education::all(),
            'employment_statuses' => EmploymentStatus::all(),
            'employment_types'    => EmploymentType::all(),
            'banks'               => Bank::all(),
        ]);
    }

    // ============================
    // STORE
    // ============================
    public function store(Request $request)
    {
        $validated = $this->validatedData($request);
// Upload foto
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employee_photos', 'public');
        }
        $employee = Employee::create($validated);
// STORE FAMILY MEMBERS
        if($request->filled('family_name')){
            foreach($request->family_name as $index => $name){
                if($name){
                    $employee->familyMembers()->create([
                        'name'         => $name,
                        'relationship' => $request->family_relation[$index] ?? null,
                        'birth_date'   => $request->family_birth_date[$index] ?: null,
                        'is_dependent' => $request->family_is_dependent[$index] ?? 0,
                    ]);
                }
            }
        }
// ============================
    // HISTORY MASUK
    // ============================
    EmployeeHistory::create([
        'employee_id'     => $employee->id,
        'full_name' => $employee->full_name,
        'type'            => 'Masuk',
        'status'          => 'Active',
        'employment_type' => optional($employee->employmentStatus)->status_name,
        'start_date'      => $employee->join_date ?? now(),
        'end_date'        => $employee->tanggal_akhir_kontrak,
        'notes'           => 'Karyawan baru masuk',
    ]);

    return redirect()->route('hr.data_karyawan')
        ->with('success', 'Karyawan berhasil ditambahkan');
}
        

    // ============================
    // EDIT
    // ============================
    public function edit(Employee $employee)
{
    // Load relasi familyMembers 
    $employee->load('familyMembers');

    return view('hr.karyawan.edit', [
        'employee'            => $employee,
        'companies'           => Company::all(),
        'departments'         => Department::all(),
        'positions'           => Position::all(),
        'religions'           => Religion::all(),
        'marital_statuses'    => MaritalStatus::all(),
        'educations'          => Education::all(),
        'employment_statuses' => EmploymentStatus::all(),
        'employment_types'    => EmploymentType::all(),
        'banks'               => Bank::all(),
    ]);
}


public function update(Request $request, Employee $employee)
{
    // VALIDASI RELATIONSHIP FAMILY
    $request->validate([
        'family.*.relation'       => 'required|in:anak,istri,suami,orang_tua,kakak,adik',
        'family.*.name'           => 'required|string|max:255',
        'family.*.birth_date'     => 'nullable|date',
        'family.*.tax_dependent'  => 'required|boolean',
    ]);

    // VALIDASI DATA EMPLOYEE
    $validated = $this->validatedData($request, $employee->id);

    // HANDLE PHOTO
    if ($request->hasFile('photo')) {
        if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
            Storage::disk('public')->delete($employee->photo);
        }
        $validated['photo'] = $request->file('photo')->store('employee_photos', 'public');
    }

    // =========================
    // AMBIL DATA LAMA
    // =========================
    $oldEndDate = $employee->tanggal_akhir_kontrak;
    $oldStatus  = $employee->employment_status_id;

    $newEndDate = $validated['tanggal_akhir_kontrak'] ?? $oldEndDate;
    $newStatus  = $validated['employment_status_id'] ?? $oldStatus;

    // FLAG: apakah ini pertama kali isi kontrak
    $isFirstFill = empty($oldEndDate) && !empty($newEndDate);

    // FLAG: benar-benar berubah
    $isContractChanged = $oldEndDate != $newEndDate;

    $isStatusChanged = $oldStatus != $newStatus;

    // =========================
    // UPDATE EMPLOYEE
    // =========================
    $employee->update($validated);

    // =========================
    // RESIGN
    // =========================
    if ($request->exit_date) {
        EmployeeHistory::create([
            'employee_id'     => $employee->id,
            'full_name'       => $employee->full_name,
            'type'            => 'Resign',
            'status'          => 'Inactive',
            'employment_type' => optional($employee->employmentStatus)->status_name,
            'start_date'      => $employee->join_date,
            'end_date'        => $request->exit_date,
            'notes'           => $request->reason_resign,
        ]);
    }

    // =========================
    // HISTORY PERPANJANG / UPDATE (FIXED)
    // =========================
    if (
        !$isFirstFill &&              // ❌ jangan masuk kalau baru pertama isi
        ($isContractChanged || $isStatusChanged) // ✅ hanya kalau beneran berubah
    ) {
        EmployeeHistory::create([
            'employee_id'     => $employee->id,
            'full_name'       => $employee->full_name,
            'type'            => $isContractChanged ? 'Perpanjang Kontrak' : 'Update Data',
            'status'          => 'Active',
            'employment_type' => optional($employee->employmentStatus)->status_name,
            'start_date'      => $oldEndDate ?? now(),
            'end_date'        => $newEndDate,
            'notes'           => 'Auto generated update',
        ]);
    }


    // ===== FAMILY =====
    $families = $request->input('family', []);
    $dependentCount = 0;

    $status = strtolower($employee->maritalStatus->marital_status_name ?? '');

    foreach ($families as $row) {

        // DELETE
        if (($row['delete'] ?? 0) == 1) {
            if (!empty($row['id'])) {
                FamilyMember::where('id', $row['id'])->delete();
            }
            continue;
        }

        $relation = strtolower($row['relation'] ?? '');
        $isDependent = ($row['tax_dependent'] ?? 0) == 1;

        // LOGIKA PAJAK
        if ($relation === 'anak') {
            if ($isDependent) {
                $dependentCount++;
                if ($dependentCount > 3) {
                    $isDependent = false;
                }
            }
        } elseif (in_array($relation, ['istri', 'suami'])) {
            if (!in_array($status, ['menikah', 'married'])) {
                $isDependent = false;
            }
        }

        $data = [
            'employee_id'  => $employee->id,
            'name'         => $row['name'] ?? null,
            'relationship' => $row['relation'],
            'birth_date'   => !empty($row['birth_date']) ? $row['birth_date'] : null,
            'is_dependent' => $isDependent,
        ];

        if (!empty($row['id'])) {
            FamilyMember::where('id', $row['id'])->update($data);
        } else {
            $employee->familyMembers()->create($data);
        }
    }

    // AUTO SYNC MARITAL (dipindah ke atas sebelum return)
    if (!in_array($status, ['menikah','married','cerai','duda','janda'])) {
        $employee->familyMembers()->update(['is_dependent' => 0]);
    }

    // Reload relasi
    $employee->load('maritalStatus', 'familyMembers');

    $taxStatus = $this->calculateTaxStatus($employee);

    return redirect()
        ->route('hr.data_karyawan.show', $employee->id)
        ->with('taxStatus', $taxStatus)
        ->with('success', 'Data karyawan berhasil diperbarui');
}


    // ============================
    // DELETE
    // ============================
    public function destroy(Employee $employee)
    {
        if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
            Storage::disk('public')->delete($employee->photo);
        }

        // Delete family members
        $employee->familyMembers()->delete();

        $employee->delete();

        return redirect()->route('hr.data_karyawan')
            ->with('success', 'Data karyawan berhasil dihapus');
    }

 // ============================
// SHOW DETAIL KARYAWAN
// ============================
public function show(Employee $employee)
{
    $employee->load([
        'company','department','position',
        'employmentType','employmentStatus',
        'religion','education','maritalStatus',
        'bank','familyMembers'
    ]);

    $taxStatus = $this->calculateTaxStatus($employee);

    $displayStatus = match (true) {
        str_starts_with($taxStatus, 'K')  => 'Married – ' . $taxStatus,
        str_starts_with($taxStatus, 'TK') => 'Single – ' . $taxStatus,
        default => $taxStatus,
    };

    return view('hr.karyawan.show', compact(
        'employee',
        'taxStatus',
        'displayStatus'
    ));

}

// ============================
// PRINT / DOWNLOAD PDF
// ============================
public function print(Employee $employee)
{
    // Reload relasi untuk data terbaru
    $employee->load([
        'company','department','position',
        'employmentType','employmentStatus',
        'religion','education','maritalStatus',
        'bank','familyMembers'
    ]);

    // Hitung status pajak pakai helper
    $taxStatus = $this->calculateTaxStatus($employee);




    // Tentukan logo berdasarkan perusahaan
    $companyName = strtolower($employee->company->company_name);

    if ($companyName == 'quantum') {
        $logo = public_path('images/logo-quantum.png');
    } elseif ($companyName == 'uniland') {
        $logo = public_path('images/logo-uniland.png');
    } else {
        $logo = public_path('images/logo-default.png'); // opsional, buat perusahaan baru
    }

    // Load view PDF, kirim data employee, taxStatus, dan logo
    $pdf = Pdf::loadView('hr.karyawan.print', [
        'employee' => $employee,
        'taxStatus' => $taxStatus,
        'logo' => $logo
    ])->setPaper('a4', 'portrait');

    return $pdf->download($employee->full_name.'_detail.pdf');
}

    // ============================
    // VALIDATION
    // ============================
    private function validatedData(Request $request, $employeeId = null)
{
    return $request->validate([

        'id_karyawan' => 'nullable|string|min:1',
        'full_name'            => 'required|string|max:255',
        'company_id'           => 'nullable|exists:companies,id',
        'employment_type_id'   => 'nullable|exists:employment_types,id',
        'employment_status_id' => 'nullable|exists:employment_statuses,id',
        'nik'                  => 'nullable|string|max:50',
        'npwp'                 => 'nullable|string|max:50',
        'kk_number'            => 'nullable|string|max:50',
        'mother_name'          => 'nullable|string|max:255',
        'gender'               => 'nullable',
        'birth_place'          => 'nullable|string|max:255',
        'birth_date'           => 'nullable|date',
        'blood_type'           => 'nullable',
        'religion_id'          => 'nullable|exists:religions,id',
        'education_id'         => 'nullable|exists:educations,id',
        'marital_status_id'    => 'nullable|exists:marital_statuses,id',
        'email'                => 'nullable|email|unique:employees,email,' . $employeeId,
        'phone'                => 'nullable|string|max:20',
        'address_ktp'          => 'nullable|string',
        'address_domisili'     => 'nullable|string',
        'department_id'        => 'nullable|exists:departments,id',
        'position_id'          => 'nullable|exists:positions,id',
        'join_date'            => 'nullable|date',
        'tanggal_akhir_kontrak' => 'nullable|date',
        'exit_date'      => 'nullable|date',
        'reason_resign' => 'nullable|string',
        'rekomendasi' => 'nullable|string|max:255',
        'bpjs_tk'              => 'nullable|string',
        'bpjs_kes'             => 'nullable|string',
        'bank_id'              => 'nullable|exists:banks,id',
        'bank_account'         => 'nullable|string|max:100',
        'emergency_name'       => 'nullable|string|max:255',
        'emergency_relation'   => 'nullable|string|max:100',
        'emergency_phone'      => 'nullable|string|max:20',
        'photo'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);
}



    // ============================
    // STORE FAMILY MEMBER (optional endpoint)
    // ============================
    public function storeFamily(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'name'        => 'required|string',
            'relationship'=> 'required|in:anak,istri,suami,orangtua,kakak,adik',
            'birth_date'  => 'nullable|date',
            'is_dependent'=> 'nullable|boolean',
        ]);

        FamilyMember::create($request->all());

        return back()->with('success', 'Data keluarga berhasil ditambahkan');
    }

// ============================
// HELPER HITUNG STATUS PAJAK (FINAL)
// ============================
private function calculateTaxStatus(Employee $employee)
{
    // Ambil status perkawinan (huruf kecil biar aman)
    $status = strtolower($employee->maritalStatus->marital_status_name ?? '');

    // Hitung anak tanggungan (is_dependent = 1), maksimal 3 anak
    $childrenCount = $employee->familyMembers
        ->filter(function ($member) {
            $rel = strtolower($member->relationship ?? '');
            return $rel === 'anak' && $member->is_dependent;
        })
        ->count();
    $childrenCount = min($childrenCount, 3);

    // Cek ada istri/suami yang dihitung sebagai tanggungan
    $spouseDependent = 0;
    if (in_array($status, ['menikah', 'married'])) {
        $spouseDependent = $employee->familyMembers
            ->contains(function ($member) {
                $rel = strtolower($member->relationship ?? '');
                return in_array($rel, ['istri', 'suami']) && $member->is_dependent;
            }) ? 1 : 0;
    }

    // ===========================
    // LOGIKA STATUS PAJAK
    // ===========================
    if (in_array($status, ['menikah', 'married'])) {
        // Married → K0/K1/K2/K3
        $totalDependents = $childrenCount + $spouseDependent;
        if ($totalDependents > 0) {
            return 'K' . $childrenCount; // Hanya anak dihitung untuk K1/K2/K3
        }
        return 'K0';
    }

    
    if (in_array($status, ['cerai', 'duda', 'janda'])) {
    // Cerai tapi punya anak → TETAP K1/K2/K3
    if ($childrenCount > 0) {
        return 'K' . $childrenCount;
    }

    // Cerai tanpa anak
    return 'TK0';
    }

    // Single / belum menikah → TK0
    return 'TK0';
}



public function createFromApplicant(RecruitmentApplicant $applicant)
    {
        // kalau udah pernah dijadikan karyawan, redirect aja
        if ($applicant->employee) {
            return redirect()->route('recruitment.applicants.show', $applicant->id)
                ->with('info', 'Pelamar ini sudah menjadi karyawan');
        }

        return view('employees.create-from-applicant', [
            'applicant'       => $applicant,
            'companies'       => Company::all(),
            'employmentTypes' => EmploymentStatus::all(), // Tetap / Kontrak / Harian
            'types'           => EmploymentType::all(),   // Staff / Produksi / Borongan
            'positions'       => Position::all(),
            'departments'     => Department::all(),
        ]);
    }

    // ============================
    // SIMPAN HASIL CONVERT
    // ============================
    public function storeFromApplicant(Request $request, RecruitmentApplicant $applicant)
    {
        // kalau udah pernah dijadikan karyawan, redirect aja
        if ($applicant->employee) {
            return redirect()->route('recruitment.applicants.show', $applicant->id)
                ->with('info', 'Pelamar ini sudah menjadi karyawan');
        }

        // VALIDASI FORM
        $validated = $request->validate([
            'company_id'      => 'required|exists:companies,id',
            'department_id'   => 'required|exists:departments,id',
            'position_id'     => 'required|exists:positions,id',
            'employment_type' => 'required|in:Staff,Produksi,Borongan',
            'join_date'       => 'required|date',
            'birth_place'     => 'nullable|string|max:255',
            'birth_date'      => 'nullable|date',
            'nik'             => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($validated, $applicant) {

            Employee::create([
                'full_name'           => $applicant->name,
                'email'               => $applicant->email,
                'phone'               => $applicant->phone,
                'status'              => 'Active', // default saat convert
                'company_id'          => $validated['company_id'],
                'department_id'       => $validated['department_id'],
                'position_id'         => $validated['position_id'],
                'employment_type'     => $validated['employment_type'],
                'join_date'           => $validated['join_date'],
                'birth_place'         => $validated['birth_place'] ?? null,
                'birth_date'          => $validated['birth_date'] ?? null,
                'nik'                 => $validated['nik'] ?? null,
                'source_applicant_id' => $applicant->id,
            ]);

            // UPDATE STATUS PELAMAR
            $applicant->update([
                'status' => 'approved', // enum di recruitment_applicants: pending/approved/rejected
            ]);
        });

        return redirect()->route('employees.createFromApplicant', $applicant->id)
            ->with('success', 'Pelamar berhasil dijadikan karyawan');
    }



    

 // ================= IMPORT DATA =================
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new EmployeesImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data berhasil diimport!');
    }

    public function exportAll(Request $request)
{
    return Excel::download(
        new EmployeesDataExport($request->kategori),
        'data-karyawan-' . now()->format('Y-m-d') . '.xlsx'
    );
}

// ============================
// DOWNLOAD TEMPLATE (DYNAMIC)
// ============================
    public function downloadTemplate()
    {
    return Excel::download(
        new EmployeeTemplateExport,
        'Template_Karyawan.xlsx'
    );
    }
    public function kontrakHabis()
{
    $employees = Employee::kontrakAkanHabis()
        ->orderBy('tanggal_akhir_kontrak', 'asc')
        ->paginate(10);

    return view('hr.karyawan.kontrak-habis', compact('employees'));
}
public function action(Request $request, Employee $employee)
{
    $request->validate([
        'action' => 'required|in:perpanjang,habis,resign,phk',
        'tanggal_akhir_kontrak' => 'nullable|date',
        'exit_date' => 'nullable|date',
        'reason' => 'nullable|string|max:255'
    ]);

    $action = $request->action;

    // =========================
    // PERPANJANG
    // =========================
    if ($action == 'perpanjang') {

        $oldDate = $employee->tanggal_akhir_kontrak;

        $employee->update([
            'tanggal_akhir_kontrak' => $request->tanggal_akhir_kontrak,
            'status' => 'Active'
        ]);

        EmployeeHistory::create([
            'employee_id' => $employee->id,
            'full_name' => $employee->full_name,
            'type' => 'Perpanjang Kontrak',
            'status' => 'Active',
            'employment_type' => optional($employee->employmentStatus)->status_name,
            'start_date' => $oldDate,
            'end_date' => $request->tanggal_akhir_kontrak,
            'notes' => $request->reason,
        ]);
    }

    // =========================
    // HABIS KONTRAK
    // =========================
    elseif ($action == 'habis') {

    if ($employee->status === 'Inactive') {
        return back()->with('info', 'Karyawan sudah berstatus Inactive');
    }

    $endDate = $employee->tanggal_akhir_kontrak;

    $employee->update([
        'status' => 'Inactive',
        'exit_date' => $endDate,
        'reason_resign' => 'Kontrak Selesai'
    ]);

    EmployeeHistory::create([
        'employee_id' => $employee->id,
        'full_name' => $employee->full_name,
        'type' => 'Kontrak Habis',
        'status' => 'Inactive',
        'employment_type' => optional($employee->employmentStatus)->status_name,
        'start_date' => $employee->join_date,
        'end_date' => $endDate,
    ]);

    }

    // =========================
    // RESIGN
    // =========================
    elseif ($action == 'resign') {

        $employee->update([
            'status' => 'Inactive',
            'exit_date' => $request->exit_date,
            'reason_resign' => $request->reason
        ]);

        EmployeeHistory::create([
            'employee_id' => $employee->id,
            'full_name' => $employee->full_name,
            'type' => 'Resign',
            'status' => 'Inactive',
            'employment_type' => optional($employee->employmentStatus)->status_name,
            'start_date' => $employee->join_date,
            'end_date' => $request->exit_date,
            'notes' => $request->reason,
        ]);
    }

    // =========================
    // PHK
    // =========================
    elseif ($action == 'phk') {

        $employee->update([
            'status' => 'Inactive',
            'exit_date' => $request->exit_date,
            'reason_resign' => 'PHK - ' . $request->reason
        ]);

        EmployeeHistory::create([
            'employee_id' => $employee->id,
            'full_name' => $employee->full_name,
            'type' => 'PHK',
            'status' => 'Inactive',
            'employment_type' => optional($employee->employmentStatus)->status_name,
            'start_date' => $employee->join_date,
            'end_date' => $request->exit_date,
            'notes' => $request->reason,
        ]);
    }

    return back()->with('success', 'Aksi berhasil diproses');
}
public function history()
{
    $histories = EmployeeHistory::with(['employee'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('hr.karyawan.history', compact('histories'));
}
public function arsip(Request $request)
{
    $employees = Employee::with([
        'company',
        'department',
        'position',
        'employmentType',
        'employmentStatus'
    ]);

    // 🔥 INI YANG BENAR (simple & aman)
    $employees->where('status', '!=', 'Active');

    if ($request->filled('search')) {
        $search = $request->search;

        $employees->where(function ($q) use ($search) {
            $q->where('full_name', 'like', "%{$search}%")
              ->orWhere('id_karyawan', 'like', "%{$search}%");
        });
    }

    $employees = $employees->paginate(10);

    return view('hr.karyawan.arsip', compact('employees'));
}
}
