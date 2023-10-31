<?php

namespace Modules\User\ViewModels\Admin\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\User\Entities\VisitorStatistics;

class VisitorStatisticsViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function index()
    {
        $visitorsToday = DB::table('visitor_statistics')
            ->whereDate('created_at', today())
            ->distinct('ip_address')
            ->count('ip_address');

        $visitorsThisWeek = DB::table('visitor_statistics')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->distinct('ip_address')
            ->count('ip_address');

        $visitorsThisMonth = DB::table('visitor_statistics')
            ->whereMonth('created_at', now()->month)
            ->distinct('ip_address')
            ->count('ip_address');

        $visitorsThisYear = DB::table('visitor_statistics')
            ->whereYear('created_at', now()->year)
            ->distinct('ip_address')
            ->count('ip_address');

        $totalVisitors = DB::table('visitor_statistics')
            ->distinct('ip_address')
            ->count('ip_address');

        $data = [
            'visitorsToday' => $visitorsToday,
            'visitorsThisWeek' => $visitorsThisWeek,
            'visitorsThisMonth' => $visitorsThisMonth,
            'visitorsThisYear' => $visitorsThisYear,
            'totalVisitors' => $totalVisitors,
        ];
        return $this->renderView('user::user.visitorStatistics', $data);
    }
}
