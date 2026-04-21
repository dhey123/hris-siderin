<?php

namespace App\Http\Controllers\GA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Maintenance;
use App\Models\RequestItem;
use Carbon\Carbon;

class GaDashboardController extends Controller
{
    public function index(Request $request)
    {
        // 🔥 FILTER BULAN
        $month = $request->month ?? now()->format('Y-m');

        $start = Carbon::parse($month)->startOfMonth();
        $end   = Carbon::parse($month)->endOfMonth();

        // =====================
        // 🔥 ASSET (TIDAK PER BULAN)
        // =====================
        $totalAsset = Asset::count();

        $assetBaik = Asset::where('condition', 'baik')->count();
        $assetRusak = Asset::where('condition', 'rusak')->count();
        $assetMaintenance = Asset::where('condition', 'maintenance')->count();

        // =====================
        // 🔥 MAINTENANCE (FILTER BULAN)
        // =====================
        $maintenanceQuery = Maintenance::whereBetween('report_date', [$start, $end]);

        $totalMaintenance = (clone $maintenanceQuery)->count();
        $maintenancePending = (clone $maintenanceQuery)->where('status', 'pending')->count();
        $maintenanceProcess = (clone $maintenanceQuery)->where('status', 'process')->count();
        $maintenanceDone = (clone $maintenanceQuery)->where('status', 'done')->count();

        // =====================
        // 🔥 REQUEST (FILTER BULAN)
        // =====================
        $requestQuery = RequestItem::whereBetween('request_date', [$start, $end]);

        $totalRequest = (clone $requestQuery)->count();
        $requestPending = (clone $requestQuery)->where('status', 'pending')->count();
        $requestApproved = (clone $requestQuery)->where('status', 'approved')->count();
        $requestRejected = (clone $requestQuery)->where('status', 'rejected')->count();

        // =====================
        // 🔥 CHART (RINGAN)
        // =====================

        // Maintenance per bulan (1 tahun)
        $maintenanceChart = Maintenance::selectRaw('MONTH(report_date) as month, COUNT(*) as total')
            ->whereYear('report_date', Carbon::parse($month)->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        // Request per status (bulan ini)
        $requestChart = $requestQuery
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // =====================
        // 🔥 RECENT (LIMIT BIAR RINGAN)
        // =====================
        $recentMaintenances = Maintenance::with('asset')
            ->latest()
            ->limit(5)
            ->get();

        $recentRequests = RequestItem::latest()
            ->limit(5)
            ->get();

        return view('ga.index', compact(
            'month',

            'totalAsset',
            'assetBaik',
            'assetRusak',
            'assetMaintenance',

            'totalMaintenance',
            'maintenancePending',
            'maintenanceProcess',
            'maintenanceDone',

            'totalRequest',
            'requestPending',
            'requestApproved',
            'requestRejected',

            'maintenanceChart',
            'requestChart',

            'recentMaintenances',
            'recentRequests'
        ));
    }
}