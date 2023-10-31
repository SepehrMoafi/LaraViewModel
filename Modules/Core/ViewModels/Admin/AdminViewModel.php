<?php

namespace Modules\Core\ViewModels\Admin;

use Illuminate\Support\Facades\DB;
use Modules\Core\Entities\ErrorLog;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Order;
use Modules\Shop\Entities\Product;
use Modules\Shop\ViewModels\Admin\Order\OrderViewModel;
use Modules\User\Entities\VisitorStatistics;

class AdminViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function index()
    {
        $totalUniqueIPCount = DB::table('visitor_statistics')
            ->select(DB::raw('count(DISTINCT ip_address) as count'))
            ->value('count');

        $lastMonthUniqueIPCount = DB::table('visitor_statistics')
            ->select(DB::raw('count(DISTINCT ip_address) as count'))
            ->where('created_at', '>=', now()->subMonth())
            ->value('count');

        $percentage = ($lastMonthUniqueIPCount / $totalUniqueIPCount) * 100;

        $errors_log = ErrorLog::query()->latest()->paginate(10);

//        { year: 'فروردین', count: 10 },
//        { year: '', count: 20 },
//        { year: '', count: 15 },
//        { year: '', count: 25 },
//        { year: '', count: 220 },
//        { year: '', count: 30 },
//        { year: '', count: 28 },
//        { year: '', count: 28 },
//        { year: '', count: 28 },
//        { year: , count: 28 },
//        { year: '', count: 28 },
//        { year: '', count: 28 },

        $order_viewmodel = new OrderViewModel();
        $orders =  $order_viewmodel->setGridData(true)->rows;

        $order_data = [];
        $curent_year = jdate()->getYear();
        $time_array = [
            (object) [
                'title' => 'فروردین',
                'date' => $curent_year.'-01-01',
            ],
            (object) [
                'title' => 'اردیبهشت',
                'date' => $curent_year.'-02-01',
            ],
            (object) [
                'title' => 'خرداد',
                'date' => $curent_year.'-03-01',
            ],
            (object) [
                'title' => 'تیر',
                'date' => $curent_year.'-04-01',
            ],
            (object) [
                'title' => 'مرداد',
                'date' => $curent_year.'-05-01',
            ],
            (object) [
                'title' => 'شهریور',
                'date' => $curent_year.'-06-01',
            ],
            (object) [
                'title' => 'مهر',
                'date' => $curent_year.'-07-01',
            ],
            (object) [
                'title' => 'آبان',
                'date' => $curent_year.'-08-01',
            ],
            (object) [
                'title' => 'آذر',
                'date' => $curent_year.'-09-01',
            ],
            (object) [
                'title' => 'دی',
                'date' => $curent_year.'-10-01',
            ],
            (object) [
                'title' => 'یهمن',
                'date' => $curent_year.'-11-01',
            ],
            (object) [
                'title' => 'اسفند',
                'date' => $curent_year.'-12-01',
            ],
        ];

        foreach ($time_array as $item) {
            $item_order_clone = clone $orders ;
            $s_date_carbon =  \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y-m-d', $item->date )->format('Y-m-d');
            $end_day = carbon(strtotime($s_date_carbon))->addMonth()->format('Y-m-d');

            $item_order_clone->whereBetween('created_at' , [$s_date_carbon , $end_day] );

            $order_data[] =  (object) [
                'year' => $item->title,
                'count' => $item_order_clone->count(),
            ];
        }
        $data = [
            'totalUniqueIPCount' => $totalUniqueIPCount,
            'percentage' => $percentage,
            'errors_log' => $errors_log,
            'order_data' => $order_data,

        ];
        return $this->renderView('core::index', $data);
    }

    public function fileManager()
    {
        $data = [
        ];
        return $this->renderView('core::file_manager', $data);
    }

}
