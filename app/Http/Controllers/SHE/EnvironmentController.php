<?php

namespace App\Http\Controllers\SHE;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Waste;
use App\Models\Inspection;
use App\Models\Audit;
class EnvironmentController extends Controller
{
    public function index()
    {
        // ======================
        // LIMBAH
        // ======================
       $limbahDisimpan = Waste::whereRaw("LOWER(status_pengelolaan) = 'disimpan'")->count();
        $limbahSelesai  = Waste::whereRaw("LOWER(status_pengelolaan) = 'selesai'")->count();
                // ======================
        // INSPEKSI
        // ======================
        $inspeksiOpen   = Inspection::whereRaw("LOWER(status) = 'open'")->count();
        $inspeksiClose  = Inspection::whereRaw("LOWER(status) = 'closed'")->count();

        // ======================
        // AUDIT
        // ======================
        $auditDraft     = Audit::where('status', 'draft')->count();
        $auditFollowup  = Audit::where('status', 'followup')->count();
        $auditSelesai   = Audit::where('status', 'selesai')->count();

        return view('she.environment.index', compact(
            'limbahDisimpan',
            'limbahSelesai',
            'inspeksiOpen',
            'inspeksiClose',
            'auditDraft',
            'auditFollowup',
            'auditSelesai'
        ));
    }
    // ================= INSPEKSI =================
    public function inspeksiIndex()
    {
        return view('she.environment.inspeksi.index');
    }

    // ================= AUDIT =================
    public function auditIndex()
    {
        return view('she.environment.audit.index');
    }
}
