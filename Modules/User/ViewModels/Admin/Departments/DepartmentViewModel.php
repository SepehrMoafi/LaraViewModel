<?php

namespace Modules\User\ViewModels\Admin\Departments;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\User\Entities\Department;
use Modules\User\Entities\Ticket;

class DepartmentViewModel extends BaseViewModel
{
    use GridTrait;

    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData()
    {
        $query = Department::with('user')->orderByDesc('created_at');
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
            'name' => 'name',
            'title' => 'نام',
        ]);

        $this->addColumn([
            'name' => 'user_id',
            'title' => 'سازنده',
        ]);

        $this->addAction([
            'name' => 'delete',
            'title' => 'حذف',
            'url' => array(
                'name' => 'admin.user.departments.destroy',
                'parameter' => ['id'],
                'method' => 'delete',
            ),
            'class' => 'btn-danger',
        ]);
        $this->addAction([
            'name' => 'show',
            'title' => 'مشاهده',
            'url' => array(
                'name' => 'admin.user.departments.show',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class' => 'btn-warning',
        ]);
        /*** buttons ***/
        $this->addButton([
            'name'=>'addNew',
            'title'=>'افزودن جدید',
            'url'=>route('admin.user.departments.create'),
            'class'=>'btn-primary',
        ]);

        return $this;
    }

    public function getRowUpdate($row)
    {
        $row->user_id = $row->user->name ?? '';

        return $row;
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();
            Department::query()->findOrFail(request()->model_id)->delete();
        } catch (\Exception $exception) {
            DB::rollBack();
            alert()->error('مشکلی پیش آمده است');
            Log::critical('Department error is: ' . $exception->getMessage());
            return redirect()->back();
        }
        DB::commit();
        alert()->success('با موفقیت انجام شد');
        return to_route('admin.user.departments.index');
    }

    public function show()
    {
        $department = Department::query()->findOrFail(request()->model_id);
        $data = [
            'department' => $department
        ];
        return $this->renderView('user::departments.show',$data);
    }

    public function create()
    {
        return $this->renderView('user::departments.create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string|max:75',
        ]);
        try {
            DB::beginTransaction();
            $department = new Department();
            $department->name = $data['name'];
            $department->user_id =  \Auth::id();
            $department->save();
        } catch (\Exception $exception) {
            DB::rollBack();
            alert()->error('مشکلی پیش آمده است');
            Log::critical('Department error is: ' . $exception->getMessage());
            return redirect()->back();
        }
        DB::commit();
        alert()->success('با موفقیت انجام شد');
        return to_route('admin.user.departments.index');
    }

    public function update()
    {
        try {
            DB::beginTransaction();
            Department::query()->findOrFail(request()->model_id)->update(['name' => request()->name]);
        } catch (\Exception $exception) {
            DB::rollBack();
            alert()->error('مشکلی پیش آمده است');
            Log::critical('Department error is: ' . $exception->getMessage());
            return redirect()->back();
        }
        DB::commit();
        alert()->success('با موفقیت انجام شد');
        return to_route('admin.user.departments.index');
    }
}
