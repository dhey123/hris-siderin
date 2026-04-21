<?php

namespace App\Http\Controllers\Labour;

use App\Http\Controllers\Controller;
use App\Models\IndustrialStructure;
use App\Models\IndustrialRelation;
use App\Models\EmployeeCase;
use App\Models\GovernmentRelation;
use Illuminate\Support\Carbon;

class LabourDashboardController extends Controller
{
    public function index()
    {
        // TOTAL COUNT
        $structures = IndustrialStructure::count();
        $relations = IndustrialRelation::count();
        $cases = EmployeeCase::count();
        $governments = GovernmentRelation::count();

        // LATEST 5
        $latestCases = EmployeeCase::with('structure')->latest()->take(5)->get();
        $latestGovernment = GovernmentRelation::with('structure')->latest()->take(5)->get();

        // STATISTIK TAMBAHAN
        $casesPending = EmployeeCase::where('status', 'Pending')->count();
        $casesOngoing = EmployeeCase::where('status', 'Ongoing')->count();
        $relationsActive = IndustrialRelation::where('status', 'Aktif')->count();
        $relationsExpired = IndustrialRelation::where('status', 'Expired')->count();
        $upcomingAgenda = GovernmentRelation::whereBetween('tanggal', [Carbon::now(), Carbon::now()->addWeek()])->count();

        // ALERT / WARNING
        $alertCases = EmployeeCase::whereIn('status', ['Pending', 'Ongoing'])->get();
        $alertRelations = IndustrialRelation::where('status', 'Hampir Expired')->get();
        $alertAgenda = GovernmentRelation::whereBetween('tanggal', [Carbon::now(), Carbon::now()->addDays(2)])->get();

        return view('labour.dashboard', compact(
            'structures',
            'relations',
            'cases',
            'governments',
            'latestCases',
            'latestGovernment',
            'casesPending',
            'casesOngoing',
            'relationsActive',
            'relationsExpired',
            'upcomingAgenda',
            'alertCases',
            'alertRelations',
            'alertAgenda'
        ));
    }
}