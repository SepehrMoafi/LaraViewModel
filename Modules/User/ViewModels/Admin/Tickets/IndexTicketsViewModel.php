<?php

namespace Modules\User\ViewModels\Admin\Tickets;

use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\User\Entities\Ticket;

class IndexTicketsViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData()
    {
        $query = Ticket::with(['user', 'department'])->orderByDesc('created_at');
        $this->rows = $query->paginate(40);
        return $this;
    }

    public function showGrid()
    {
        return $this->setGridData()->setColumns()->renderGridView();
    }

    public function setColumns()
    {
        $this->addColumn([
            'name'=>'title',
            'title'=>'عنوان',
        ]);

        $this->addColumn([
            'name'=>'status',
            'title'=>'وضعیت',
        ]);

        $this->addColumn([
            'name'=>'user_id',
            'title'=>'کاربر',
        ]);
        $this->addColumn([
            'name'=>'department_id',
            'title'=>'دپارتمان',
        ]);

        $this->addAction([
            'name'=>'show',
            'title'=>'مشاهده',
            'url'=>array(
                'name' => 'admin.user.tickets.show',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class'=>'btn-warning',
        ]);


        return $this;
    }

    public function getRowUpdate($row)
    {
        $row->department_id = $row->department->name ?? '';
        $row->user_id = $row->user->name ?? '';
        $statusValue = match ($row->status) {
            'open' => 'باز',
            'closed' => 'بسته',
            'read' => 'خوانده شده',
            'unread' => 'خوانده نشده',
            'answered' => 'پاسخ داده شده',
            default => 'باز'
        };
        $row->status = $statusValue;
        return $row;
    }
}
