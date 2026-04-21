<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GA\GaDashboardController;
use App\Http\Controllers\GA\AssetController;
use App\Http\Controllers\GA\MaintenanceController;
use App\Http\Controllers\GA\RequestController;
use App\Http\Controllers\Labour\BpjsController;
use App\Http\Controllers\Labour\LabourDashboardController;
use App\Http\Controllers\Labour\IndustrialStructureController;
use App\Http\Controllers\Labour\IndustrialRelationController;
use App\Http\Controllers\Labour\EmployeeCaseController;
use App\Http\Controllers\Labour\GovernmentRelationController;
use App\Http\Controllers\Legal\LegalDashboardController;
use App\Http\Controllers\Legal\LegalComplianceController;
use App\Http\Controllers\Legal\LegalPermitController;
use App\Http\Controllers\Legal\LegalDocumentController;
use App\Http\Controllers\Legal\LegalVendorController;
use App\Http\Controllers\Legal\LegalContractController;
use App\Http\Controllers\SHE\AuditChecklistController;
use App\Http\Controllers\SHE\AuditController;
use App\Http\Controllers\SHE\InspectionChecklistController;
use App\Http\Controllers\SHE\InspectionController;
use App\Http\Controllers\SHE\WasteController;
use App\Http\Controllers\SHE\HealthReportController;
use App\Http\Controllers\SHE\SuratDokterController;
use App\Http\Controllers\SHE\McuController;
use App\Http\Controllers\SHE\PelatihanEvaluasiController;
use App\Http\Controllers\SHE\PelatihanRescheduleController;
use App\Http\Controllers\SHE\ApdLogController;
use App\Http\Controllers\SHE\ApkController;
use App\Http\Controllers\SHE\RiskController;
use App\Http\Controllers\SHE\SheController;
use App\Http\Controllers\SHE\SafetyController;
use App\Http\Controllers\SHE\HealthController;
use App\Http\Controllers\SHE\EnvironmentController;
use App\Http\Controllers\SetController;
use App\Http\Controllers\Settings\CompanyController;
use App\Http\Controllers\Settings\EmploymentStatusController;
use App\Http\Controllers\Settings\BankController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Rekrut\RecruitmentController;
use App\Http\Controllers\Rekrut\JobController;
use App\Http\Controllers\DashboardController;




/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login-process', [AuthController::class, 'loginProcess'])->name('login.process');

/*
|--------------------------------------------------------------------------
| LOGOUT (WAJIB POST)
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // DASHBOARD
    //Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // PROFILE (ADMIN & HR)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // ADMIN ONLY
    Route::middleware('role:admin')->group(function () {
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle',[UserController::class, 'toggleStatus'])->name('users.toggle');
});

    // ===========================================================================
    // HR MODULE
    // ===========================================================================
     Route::middleware('role:admin,hr') ->prefix('hr') ->name('hr.') ->group(function () {

        // =========================
        // DATA KARYAWAN
        // =========================
        Route::get('/data-karyawan', [EmployeeController::class, 'index'])->name('data_karyawan');
        Route::get('/data-karyawan/create', [EmployeeController::class, 'create'])->name('data_karyawan.create');
        Route::post('/data-karyawan/store', [EmployeeController::class, 'store'])->name('data_karyawan.store');
        Route::get('/data-karyawan/edit/{employee}', [EmployeeController::class, 'edit']) ->name('data_karyawan.edit');
        Route::put('/data-karyawan/update/{employee}', [EmployeeController::class, 'update'])->name('data_karyawan.update');
        Route::delete('/data-karyawan/delete/{employee}', [EmployeeController::class, 'destroy'])->name('data_karyawan.destroy');
        Route::get('/data-karyawan/{employee}/show', [EmployeeController::class, 'show'])->name('data_karyawan.show');
        Route::get('/data-karyawan/kontrak-habis', [EmployeeController::class, 'kontrakHabis'])->name('data_karyawan.kontrak.habis');
        Route::post('/data-karyawan/{employee}/perpanjang', [EmployeeController::class, 'perpanjang'])->name('data_karyawan.perpanjang');
        Route::post('/data-karyawan/{employee}/action', [EmployeeController::class, 'action'])->name('data_karyawan.action');
        Route::get('/data-karyawan/history', [EmployeeController::class, 'history'])->name('data_karyawan.history');
        Route::get('/data-karyawan/arsip', [EmployeeController::class, 'arsip'])->name('data_karyawan.arsip');
        // =========================
        // IMPORT & DOWNLOAD TEMPLATE
        // =========================
        Route::post('/data-karyawan/import', [EmployeeController::class, 'import'])
            ->name('data_karyawan.import');


    });

    // =========================
    // FAMILY MEMBER
    // =========================
    Route::prefix('employees/{employee}/family')->group(function () {
        Route::get('/', [FamilyMemberController::class, 'index'])->name('family.index');
        Route::get('/create', [FamilyMemberController::class, 'create'])->name('family.create');
        Route::post('/', [FamilyMemberController::class, 'store'])->name('family.store');
        Route::get('/{id}/edit', [FamilyMemberController::class, 'edit'])->name('family.edit');
        Route::put('/{id}', [FamilyMemberController::class, 'update'])->name('family.update');
        Route::delete('/{id}', [FamilyMemberController::class, 'destroy'])->name('family.destroy');
    });

// ===========================================================================
//                       RECRUITMENT MODULE
// ===========================================================================

/// PUBLIK (TANPA LOGIN)
Route::get('/career', [RecruitmentController::class, 'index'])->name('career.index');
Route::get('/career/{job}/apply', [RecruitmentController::class, 'apply'])->name('career.apply');
Route::post('/career', [RecruitmentController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('career.store');


//--------------------------------------------------------------------------
//                 RECRUITMENT MODULE (ADMIN & HR)
//--------------------------------------------------------------------------

Route::middleware(['auth', 'role:admin,hr'])
    ->prefix('recruitment')
    ->name('recruitment.')
    ->group(function () {

        
        // LOKER //
        Route::resource('jobs', JobController::class);
        Route::patch('jobs/{job}/toggle-status',[JobController::class, 'toggleStatus'])->name('jobs.toggle-status');
        Route::get('/', fn () => view('recruitment.index'))->name('index');

        
        // LAMARAN //
        Route::get('/applicants', [RecruitmentController::class, 'applicants'])->name('applicants.index');
        Route::get('/applicants/{applicant}', [RecruitmentController::class, 'show'])->name('applicants.show');
        Route::put('/applicants/{applicant}/status', [RecruitmentController::class, 'updateStatus'])->name('applicants.update-status'); 
        Route::put('/applicants/{applicant}/update-stage', [RecruitmentController::class, 'updateStage'])->name('applicants.update-stage');

        // DOWNLOAD CV //
        Route::get('/applicants/{applicant}/download-cv',[RecruitmentController::class, 'downloadCv'])->name('applicants.download-cv');

        // =========================
        // INPUT OFFLINE / TITIPAN
        // =========================
        Route::get('/offline/create', [RecruitmentController::class, 'createOffline'])->name('offline.create');
        Route::post('/offline/store', [RecruitmentController::class, 'storeOffline']) ->name('offline.store');   
        Route::patch('/applicants/{id}/blacklist',[RecruitmentController::class, 'toggleBlacklist'])->name('applicants.blacklist');

});

    Route::prefix('employees')
        ->middleware(['auth', 'role:admin,hr'])
        ->group(function () {

        // INDEX / Daftar karyawan
        Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');

        // Form convert dari pelamar
        Route::get('/create-from-applicant/{applicant}', [EmployeeController::class, 'createFromApplicant'])
            ->name('employees.createFromApplicant');

        // SIMPAN hasil convert
        Route::post('/store-from-applicant/{applicant}', [EmployeeController::class, 'storeFromApplicant'])
            ->name('employees.storeFromApplicant');
});


//--------------------------------------------------------------------------
//                CUTI
//--------------------------------------------------------------------------

Route::prefix('cuti')->name('cuti.')->middleware(['auth'])->group(function () {

    // Dashboard Cuti (opsional)
    Route::get('/', [CutiController::class, 'index'])->name('index');

    // Jenis Cuti / Izin
    Route::get('/types', [CutiController::class, 'types'])->name('types');
    Route::post('/types', [CutiController::class, 'storeType'])->name('types.store');
    Route::put('/types/{id}', [CutiController::class, 'updateType'])->name('types.update');

    // Request Cuti (oleh admin untuk karyawan)
    Route::get('/request', [CutiController::class, 'requests'])->name('request');
    Route::post('/request', [CutiController::class, 'storeRequest'])->name('request.store');

    // Approval Cuti (HR / Manager)
    Route::get('/approval', [CutiController::class, 'approvals'])->name('approval');
    Route::post('/approval/{leaveRequest}/approve', [CutiController::class, 'approve'])->name('approve');
    Route::post('/approval/{leaveRequest}/reject', [CutiController::class, 'reject'])->name('reject');

    // Riwayat Cuti
    Route::get('/history', [CutiController::class, 'history'])->name('history');

    // Sisa Cuti / Balance
    Route::get('/balance', [CutiController::class, 'balance'])->name('balance');
    Route::get('/export', [CutiController::class, 'export'])->name('export');
    Route::get('/employee/{id}', [CutiController::class, 'employeeDetail'])->name('employee.detail');
});

//--------------------------------------------------------------------------
//   SHE(SAFETY, HEALTH, ENVIRONMENT)
//--------------------------------------------------------------------------

Route::prefix('she')->name('she.')->group(function () {
    Route::resource('inspection-checklists', InspectionChecklistController::class);

    // ===== SHE DASHBOARD =====
    Route::get('/', [SafetyController::class, 'dashboard'])->name('index');

// ================= SAFETY =================
        Route::prefix('safety')->name('safety.')->group(function () {
        
        // Safety Dashboard (pilihan modul)
        Route::get('/', [SafetyController::class, 'index'])->name('index');

        // ----- INSIDEN -----
        Route::prefix('insiden')->name('insiden.')->group(function () {
            Route::get('/pdf', [SafetyController::class, 'downloadAllPdf'])->name('pdf.all'); //Pdf semua insiden
            Route::get('/', [SafetyController::class, 'insiden'])->name('index');           // Daftar insiden
            Route::get('/create', [SafetyController::class, 'createInsiden'])->name('create'); // Form tambah
            Route::post('/', [SafetyController::class, 'insidenStore'])->name('store');       // Simpan
            Route::get('/{id}', [SafetyController::class, 'insidenShow'])->name('show');      // Detail
            Route::get('/{id}/edit', [SafetyController::class, 'insidenEdit'])->name('edit'); 
            Route::put('/{id}', [SafetyController::class, 'insidenUpdate'])->name('update');  // Update status
            Route::delete('/{id}', [SafetyController::class, 'insidenDestroy'])->name('destroy'); 
            Route::get('/{id}/pdf', [SafetyController::class, 'downloadPdf']) ->name('pdf'); //pdf perinsiden
        });

       // ----- APD -----
        Route::prefix('apd')->name('apd.')->group(function () {
            Route::get('/', [SafetyController::class, 'apd'])->name('index');             // Dashboard APD
            Route::get('/list', [SafetyController::class, 'apdList'])->name('list');      // Daftar APD
            Route::get('/create', [SafetyController::class, 'apdCreate'])->name('create'); // Form tambah
            Route::post('/', [SafetyController::class, 'apdStore'])->name('store');       // Simpan
            Route::get('/{id}/edit', [SafetyController::class, 'apdEdit'])->name('edit'); // Edit
            Route::put('/{id}', [SafetyController::class, 'apdUpdate'])->name('update');  // Update
            Route::delete('/{id}', [SafetyController::class, 'apdDestroy'])->name('destroy'); // Delete
            Route::get('/print', [SafetyController::class, 'apdPrint'])->name('print');
        // ===== APD LOGS =====
            Route::get('{apd}/logs', [ApdLogController::class, 'index'])->name('logs.index');
            Route::get('{apd}/logs/create', [ApdLogController::class, 'create']) ->name('logs.create');
            Route::post('{apd}/logs', [ApdLogController::class, 'store']) ->name('logs.store');
        });


        // ----- PELATIHAN K3 -----
        Route::prefix('pelatihan')->name('pelatihan.')->group(function () {
            Route::get('{id}/print-detail', [SafetyController::class, 'pelatihanPrintDetail'])->whereNumber('id') ->name('print.detail');
            Route::get('/', [SafetyController::class, 'pelatihanIndex'])->name('index');       // Dashboard Pelatihan
            Route::get('/create', [SafetyController::class, 'pelatihanCreate'])->name('create'); // Form tambah
            Route::post('/', [SafetyController::class, 'pelatihanStore'])->name('store');       // Simpan
            Route::get('/{id}/edit', [SafetyController::class, 'pelatihanEdit'])->name('edit'); // Edit
            Route::put('/{id}', [SafetyController::class, 'pelatihanUpdate'])->name('update');  // Update
            Route::delete('/{id}', [SafetyController::class, 'pelatihanDestroy'])->name('destroy'); // Hapus
            Route::get('/materi', [SafetyController::class, 'pelatihanMateri'])->name('materi'); // Materi
            Route::get('/print', [SafetyController::class, 'pelatihanPrint'])->name('print');
      // reschedule          
            Route::post('{pelatihan}/reschedule', [PelatihanRescheduleController::class, 'store'])->name('reschedule.store');
            Route::get('{id}', [SafetyController::class, 'pelatihanShow']) ->whereNumber('id') ->name('show');
            Route::get('{pelatihan}/evaluasi/create', [PelatihanEvaluasiController::class, 'create'])->name('evaluasi.create');
    // simpan evaluasi
            Route::post('{pelatihan}/evaluasi', [PelatihanEvaluasiController::class, 'store'])->name('evaluasi.store');
     });

        // ----- APK -----
        Route::prefix('apk')->name('apk.')->group(function () {
            Route::get('/pdf', [ApkController::class, 'downloadPdf'])->name('pdf');
            Route::get('/', [ApkController::class, 'index'])->name('index');
            Route::get('/create', [ApkController::class, 'create'])->name('create');
            Route::post('/', [ApkController::class, 'store'])->name('store');
            Route::get('/{id}', [ApkController::class, 'show'])->name('show'); // 
            Route::get('/{id}/edit', [ApkController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ApkController::class, 'update'])->name('update');
            Route::delete('/{id}', [ApkController::class, 'destroy'])->name('destroy');
            });
});


// ================= HEALTH =================
Route::prefix('health')->name('health.')->group(function () {
    Route::get('/', [HealthController::class, 'index'])->name('index');
        Route::prefix('mcu')->name('mcu.')->group(function () {
            Route::get('/', [McuController::class, 'index'])->name('index');
            Route::get('/create', [McuController::class, 'create'])->name('create');
            Route::post('/', [McuController::class, 'store'])->name('store');
            Route::get('/{mcu}', [McuController::class, 'show'])->name('show');
        });

        // ===== SURAT DOKTER =====
        Route::prefix('surat-dokter')->name('surat-dokter.')->group(function () {
            Route::get('/', [SuratDokterController::class, 'index'])->name('index');
            Route::get('/create', [SuratDokterController::class, 'create'])->name('create');
            Route::post('/', [SuratDokterController::class, 'store'])->name('store');
            Route::get('/{suratDokter}', [SuratDokterController::class, 'show'])->name('show');
            Route::get('/{suratDokter}/edit', [SuratDokterController::class, 'edit'])->name('edit');
            Route::put('/{suratDokter}', [SuratDokterController::class, 'update'])->name('update');
            Route::delete('/{suratDokter}', [SuratDokterController::class, 'destroy'])->name('destroy');
        });
        
        // ===== RIWAYAT KESEHATAN =====
            Route::get('/riwayat-kesehatan', [HealthReportController::class, 'index'] )->name('riwayat.index');
            Route::get('riwayat-kesehatan/export', [HealthReportController::class, 'export'])->name('riwayat.export');
});

Route::prefix('environment')->name('environment.')->group(function () {

    Route::get('/', [EnvironmentController::class, 'index'])->name('index');

    Route::prefix('limbah')->name('limbah.')->group(function () {

        // EXPORT
        Route::get('/export-excel', [WasteController::class, 'downloadExcel'])->name('export-excel');

        // MASTER
        Route::get('/', [WasteController::class, 'index'])->name('index');
        Route::get('/create', [WasteController::class, 'create'])->name('create');
        Route::post('/', [WasteController::class, 'store'])->name('store');
        Route::get('/{id}', [WasteController::class, 'show'])->name('show');
        Route::delete('/{id}', [WasteController::class, 'destroy'])->name('destroy');

        // LOGBOOK TAB
        Route::get('/logbook', function () {
            return redirect()->route('environment.limbah.index', ['tab' => 'logbook']);
        })->name('logbook');

        // 🔥 LOG KELUAR (INI FIX NYA)
        Route::get('{id}/keluar', [WasteController::class, 'createKeluar'])->name('keluar.create');
        Route::post('{id}/keluar', [WasteController::class, 'storeKeluar'])->name('keluar.store');

});
// ===== INSPEKSI =====
        Route::prefix('inspeksi')->name('inspeksi.')->group(function () {
            Route::get('/', [InspectionController::class, 'index'])->name('index');
            Route::get('/create', [InspectionController::class, 'create'])->name('create');
            Route::post('/', [InspectionController::class, 'store'])->name('store');
            Route::get('/{id}', [InspectionController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [InspectionController::class, 'edit'])->name('edit');
            Route::put('/{id}', [InspectionController::class, 'update'])->name('update');
            Route::delete('/{id}', [InspectionController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/pdf',[InspectionController::class, 'downloadPdf'])->name('pdf');
});
           
// ===== AUDIT =====
         Route::prefix('audit')->name('audit.')->group(function () {
            Route::get('/', [AuditController::class, 'index'])->name('index');
            Route::get('/create', [AuditController::class, 'create'])->name('create');
            Route::post('/', [AuditController::class, 'store'])->name('store');
            Route::get('/{id}', [AuditController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AuditController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AuditController::class, 'update'])->name('update');
            Route::delete('/{id}', [AuditController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/update-hasil', [AuditController::class, 'updateHasil'])->name('updateHasil');
            Route::get('/{id}/pdf', [AuditController::class, 'downloadPdf'])->name('pdf');
});
});

// ================= MANAGEMENT RISIKO =================//
Route::prefix('risk')->name('risk.')->group(function () {
// DASHBOARD
    Route::get('/', [RiskController::class, 'dashboard'])->name('dashboard');

// IDENTIFIKASI
    Route::prefix('identifikasi')->name('identifikasi.')->group(function () {
        Route::get('/', [RiskController::class, 'index'])->name('index');
        Route::get('/create', [RiskController::class, 'create'])->name('create');
        Route::post('/', [RiskController::class, 'store'])->name('store');
        Route::get('/{id}', [RiskController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [RiskController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RiskController::class, 'update'])->name('update');
        Route::delete('/{id}', [RiskController::class, 'destroy'])->name('destroy');
});

// PER-RISK PENILAIAN
    Route::prefix('{id}/penilaian')->name('penilaian.')->group(function () {
        Route::get('/', [RiskController::class, 'penilaian'])->name('index');
        Route::post('/', [RiskController::class, 'storePenilaian'])->name('store');
});

// PER-RISK MITIGASI
    Route::prefix('{id}/mitigasi')->name('mitigasi.')->group(function () {
        Route::get('/', [RiskController::class, 'mitigasi'])->name('index');          // form per-risk
        Route::post('/', [RiskController::class, 'storeMitigasi'])->name('store');    // submit per-risk
});

// PER-RISK TANGGAP DARURAT
    // PER RISK
    Route::prefix('{id}/tanggap-darurat')->name('tanggap-darurat.')->group(function () {

        Route::get('/', [RiskController::class, 'tanggapDarurat'])->name('index');
        Route::post('/', [RiskController::class, 'storeTanggapDarurat'])->name('store');
        Route::get('/edit', [RiskController::class, 'editTanggapDarurat'])->name('edit');
        Route::put('/', [RiskController::class, 'updateTanggapDarurat'])->name('update');
        Route::delete('/', [RiskController::class, 'destroyTanggapDarurat'])->name('destroy');
});

    // GLOBAL MODULES
    Route::get('tanggap-darurat', [RiskController::class, 'tanggapDaruratGlobal'])->name('tanggap-darurat.global');
    Route::get('tanggap-darurat/export-pdf',[RiskController::class, 'exportTanggapDarurat'])->name('tanggap-darurat.export');
    Route::get('penilaian', [RiskController::class, 'penilaianGlobal'])->name('penilaian.global');
    Route::get('penilaian/export', [RiskController::class, 'exportPenilaian'])->name('penilaian.export');
    Route::get('mitigasi', [RiskController::class, 'mitigasiGlobal'])->name('mitigasi.global'); // form global
    Route::post('mitigasi/store', [RiskController::class, 'storeMitigasiGlobal'])->name('mitigasi.store.global'); // submit global
    Route::get('mitigasi/{mitigasi}/edit',[RiskController::class, 'editMitigasiGlobal'])->name('mitigasi.edit.global');
    Route::put('mitigasi/{mitigasi}',[RiskController::class, 'updateMitigasiGlobal']) ->name('mitigasi.update.global');
    Route::get('mitigasi/export', [RiskController::class, 'exportMitigasi']) ->name('mitigasi.export');
  
    // ================= REFERENSI =================
    Route::prefix('referensi')->name('referensi.')->group(function () {
    Route::get('referensi', function () {return view('she.risk.referensi.index');})->name('referensi.index');    
    Route::get('struktur-organisasi', [RiskController::class, 'struktur'])->name('struktur');
    Route::get('job-description', [RiskController::class, 'job'])->name('job');
    });

});
});



/*
|--------------------------------------------------------------------------
| SETTING/PENGATURAN //MASTER DATA
|--------------------------------------------------------------------------
*/
 Route::prefix('settings')->name('settings.')->middleware(['auth','role:admin'])->group(function () {
    Route::resource('audit-checklist', AuditChecklistController::class);

    // Departments
    Route::get('departments', [DepartmentController::class,'index'])->name('departments.index');
    Route::get('departments/create', [DepartmentController::class,'create'])->name('departments.create');
    Route::post('departments', [DepartmentController::class,'store'])->name('departments.store');
    Route::get('departments/{department}/edit',[DepartmentController::class,'edit'])->name('departments.edit');
    Route::put('departments/{department}', [DepartmentController::class,'update'])->name('departments.update');
    Route::delete('departments/{department}', [DepartmentController::class,'destroy'])->name('departments.destroy');

    // Positions
    Route::get('positions', [PositionController::class,'index'])->name('positions.index');
    Route::get('positions/create', [PositionController::class,'create'])->name('positions.create');
    Route::post('positions', [PositionController::class,'store'])->name('positions.store');
    Route::get('positions/{position}/edit',[PositionController::class,'edit'])->name('positions.edit');
    Route::put('positions/{position}', [PositionController::class,'update'])->name('positions.update');
    Route::delete('positions/{position}', [PositionController::class,'destroy'])->name('positions.destroy');

    // Jenis Cuti
    Route::get('jeniscuti', [CutiController::class,'types'])->name('jeniscuti.index');
    Route::get('jeniscuti/create', [CutiController::class,'createType'])->name('jeniscuti.create');
    Route::post('jeniscuti', [CutiController::class,'storeType'])->name('jeniscuti.store');
    Route::get('jeniscuti/{type}/edit',[CutiController::class,'editType'])->name('jeniscuti.edit');
    Route::put('jeniscuti/{type}', [CutiController::class,'updateType'])->name('jeniscuti.update');
    Route::delete('jeniscuti/{type}', [CutiController::class,'destroyType'])->name('jeniscuti.destroy');

    // employment_status
    Route::get('employment_status', [SetController::class, 'employmentStatusIndex'])->name('employment_status.index');
    Route::get('employment_status/create', [SetController::class, 'employmentStatusCreate'])->name('employment_status.create');
    Route::post('employment_status/store', [SetController::class, 'employmentStatusStore'])->name('employment_status.store');
    Route::get('employment_status/{employmentStatus}/edit', [SetController::class, 'employmentStatusEdit'])->name('employment_status.edit');
    Route::put('employment_status/{employmentStatus}', [SetController::class, 'employmentStatusUpdate'])->name('employment_status.update');
    Route::delete('employment_status/{employmentStatus}', [SetController::class, 'employmentStatusDestroy'])->name('employment_status.destroy');

    // Banks
    Route::get('banks', [SetController::class, 'banksIndex'])->name('banks.index');
    Route::get('banks/create', [SetController::class, 'banksCreate'])->name('banks.create');
    Route::post('banks/store', [SetController::class, 'banksStore'])->name('banks.store');
    Route::delete('banks/{bank}', [SetController::class, 'banksDestroy'])->name('banks.destroy');

    
});



/*
|--------------------------------------------------------------------------
|       LEGAL
|--------------------------------------------------------------------------
*/
Route::prefix('legal')->name('legal.')->group(function () {

    // Dashboard Legal (PAKAI CONTROLLER)
    Route::get('/', [LegalDashboardController::class, 'index'])->name('index');

    // Master Data
    Route::resource('permits', LegalPermitController::class);
    Route::resource('vendors', LegalVendorController::class);
    Route::resource('documents', LegalDocumentController::class);
    Route::resource('contracts', LegalContractController::class)->except(['show']);
    Route::get('contracts/export/pdf',[LegalContractController::class,'exportPdf'])->name('contracts.export.pdf');
    Route::get('contracts/export/excel',[LegalContractController::class,'exportExcel'])->name('contracts.export.excel');

     // Compliance
    Route::resource('compliance', LegalComplianceController::class);
});

     
/*
|--------------------------------------------------------------------------
| LABOUR AND GOVERMENTS
|--------------------------------------------------------------------------
*/
   Route::prefix('labour')->name('labour.')->group(function(){
    Route::get('/', [LabourDashboardController::class, 'index'])->name('index');
    Route::post('/bpjs/bulk', [BpjsController::class, 'bulkUpdate'])->name('bpjs.bulk');
    Route::get('/bpjs/export', [BpjsController::class, 'export'])->name('bpjs.export');
    Route::post('/bpjs/import', [BpjsController::class, 'import'])->name('bpjs.import');
    Route::get('/bpjs/template', [BpjsController::class, 'template'])->name('bpjs.template');

    Route::resource('structures', IndustrialStructureController::class);
    Route::resource('relations', IndustrialRelationController::class);
    Route::resource('cases', EmployeeCaseController::class);
    Route::resource('government', GovernmentRelationController::class);
    Route::resource('bpjs', BpjsController::class);
});

    
/*
|--------------------------------------------------------------------------
| GENERAL AFFAIR
|--------------------------------------------------------------------------
*/
Route::prefix('ga')->name('ga.')->group(function(){

    // Dashboard
    Route::get('/', [GaDashboardController::class, 'index'])->name('index');

    // Asset
    Route::resource('assets', AssetController::class);

    // Maintenance
    Route::resource('maintenance', MaintenanceController::class);

    // Request Barang
    Route::resource('requests', RequestController::class);
    Route::get('assets/{id}/stock-in', [AssetController::class, 'stockIn'])->name('assets.stock.in');
    Route::post('assets/{id}/stock-in', [AssetController::class, 'storeStockIn'])->name('assets.stock.in.store');
    Route::get('assets/{id}/stock-out', [AssetController::class, 'stockOut'])->name('assets.stock.out');
    Route::post('assets/{id}/stock-out', [AssetController::class, 'storeStockOut'])->name('assets.stock.out.store');
    Route::get('/assets/export', [AssetController::class, 'export'])->name('assets.export');
//Route::post('/assets/import', [AssetController::class, 'import'])->name('assets.import');

});

    // Download PDF Karyawan
    Route::get('/hr/data-karyawan/{employee}/print', [EmployeeController::class, 'print']) ->name('hr.data_karyawan.print');
    
    // Download Template
    Route::get('hr/data-karyawan/download-template', [EmployeeController::class, 'downloadTemplate'])->name('data-karyawan.download-template');
    Route::get('/hr/data-karyawan/export-all', [EmployeeController::class, 'exportAll'])->name('hr.data_karyawan.exportAll');


});
 