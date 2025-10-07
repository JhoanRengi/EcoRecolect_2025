<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollectionSchedule;
use App\Models\CollectorCompany;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;

class DashboardAdmin extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();

        $totalUsers = User::count();
        $activeCompanies = CollectorCompany::where('status', 'active')->count();
        $scheduledToday = CollectionSchedule::forDate($today)->count();
        $completedToday = CollectionSchedule::forDate($today)
            ->where('status', CollectionSchedule::STATUS_COMPLETED)
            ->count();

        $schedules = CollectionSchedule::with('company')
            ->orderByDesc('scheduled_for')
            ->limit(10)
            ->get();

        $companies = CollectorCompany::orderBy('name')->get();
        $recentUsers = User::orderByDesc('created_at')->limit(10)->get();

        return view('admin.dashboard', [
            'metrics' => [
                'totalUsers' => $totalUsers,
                'activeCompanies' => $activeCompanies,
                'scheduledToday' => $scheduledToday,
                'completedToday' => $completedToday,
            ],
            'schedules' => $schedules,
            'companies' => $companies,
            'recentUsers' => $recentUsers,
        ]);
    }
}
