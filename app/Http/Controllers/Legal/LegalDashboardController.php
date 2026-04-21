<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;
use App\Models\LegalVendor;
use App\Models\LegalDocument;
use App\Models\LegalContract;
use App\Models\LegalCompliance;
use App\Models\LegalPermit;
use Illuminate\Support\Carbon;

class LegalDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $h30 = Carbon::today()->addDays(30);
        $h7 = Carbon::today()->addDays(7);

        // STATISTIK TOTAL

        $totalVendor = LegalVendor::count();
        $totalDokumen = LegalDocument::count();
        $totalKontrak = LegalContract::count();
        $totalCompliance = LegalCompliance::count();
        $totalPermit = LegalPermit::count();

         // EXPIRED
        $dokumenExpired = LegalDocument::whereDate('tanggal_berakhir','<',$today)->count();
        $kontrakExpired = LegalContract::whereDate('tanggal_berakhir','<',$today)->count();
        $complianceExpired = LegalCompliance::whereDate('tanggal_berakhir','<',$today)->count();
        $permitExpired = LegalPermit::whereDate('tanggal_berakhir','<',$today)->count();

        // H-30
        $dokumenSoon = LegalDocument::whereBetween('tanggal_berakhir', [$today, $h30])->count();
        $kontrakSoon = LegalContract::whereBetween('tanggal_berakhir', [$today, $h30])->count();
        $complianceSoon = LegalCompliance::whereBetween('tanggal_berakhir', [$today, $h30])->count();
        $permitSoon = LegalPermit::whereBetween('tanggal_berakhir', [$today, $h30])->count();

        // CRITICAL ALERT (H-7)
        $criticalDokumen = LegalDocument::whereBetween('tanggal_berakhir', [$today, $h7])->count();
        $criticalKontrak = LegalContract::whereBetween('tanggal_berakhir', [$today, $h7])->count();
        $criticalCompliance = LegalCompliance::whereBetween('tanggal_berakhir', [$today, $h7])->count();
        $criticalPermit = LegalPermit::whereBetween('tanggal_berakhir', [$today, $h7])->count();
        // ALERT LIST (max 5 saja supaya ringan)
        $alertDokumen = LegalDocument::whereDate('tanggal_berakhir','<=',$h30)
    ->orderBy('tanggal_berakhir')
    ->take(5)
    ->get();

           $alertKontrak = LegalContract::whereDate('tanggal_berakhir','<=',$h30)
    ->orderBy('tanggal_berakhir')
    ->take(5)
    ->get();

            $alertCompliance = LegalCompliance::whereDate('tanggal_berakhir','<=',$h30)
    ->orderBy('tanggal_berakhir')
    ->take(5)
    ->get();

           $alertPermit = LegalPermit::whereDate('tanggal_berakhir','<=',$h30)
    ->orderBy('tanggal_berakhir')
    ->take(5)
    ->get();
       // ALERT COUNT TOTAL (untuk bunyi/kelap-kelip)
           $totalAlerts = $criticalDokumen
             + $criticalKontrak
             + $criticalCompliance
             + $criticalPermit;
        // EXPIRY TIMELINE (calendar ringan)
        $timelineDokumen = LegalDocument::whereDate('tanggal_berakhir','<=',$h30)
                        ->orderBy('tanggal_berakhir')
                        ->take(10)
                        ->get();

        $timelineKontrak = LegalContract::whereDate('tanggal_berakhir','<=',$h30)
                        ->orderBy('tanggal_berakhir')
                        ->take(10)
                        ->get();

        $timelinePermit = LegalPermit::whereDate('tanggal_berakhir','<=',$h30)
                        ->orderBy('tanggal_berakhir')
                        ->take(10)
                        ->get();

 
        // RECENT ACTIVITY (simulasi dari created_at)
        $recentDokumen = LegalDocument::latest()->take(3)->get();
        $recentKontrak = LegalContract::latest()->take(3)->get();
        $recentVendor = LegalVendor::latest()->take(3)->get();
        $documents = $alertDokumen;
$contracts = $alertKontrak;
$permits = $alertPermit;
$compliances = $alertCompliance;

        return view('legal.index', compact(
            // total
            'totalVendor',
            'totalDokumen',
            'totalKontrak',
            'totalCompliance',
            'totalPermit',
            // expired
            'dokumenExpired',
            'kontrakExpired',
            'complianceExpired',
            'permitExpired',
            // h30
            'dokumenSoon',
            'kontrakSoon',
            'complianceSoon',
            'permitSoon',
            // alert
            'alertDokumen',
            'alertKontrak',
            'alertCompliance',
            'alertPermit',
            'totalAlerts',
              // CRITICAL ALERT 
            'criticalDokumen',
            'criticalKontrak',
            'criticalPermit',
            'criticalCompliance',

            // timeline
            'timelineDokumen',
            'timelineKontrak',
            'timelinePermit',
            // activity
            'recentDokumen',
            'recentKontrak',
            'recentVendor',
            'documents', 'contracts', 'permits', 'compliances'

            
        ));
    }
}
