<?php

namespace Modules\Core\Service\Export;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

//WithHeadings
class MasterImport implements ToCollection
{
    use Exportable;
    public $items = [];
    public $view_model;
    public function __construct($items , $view_model)
    {
        $this->items = $items ;
        $this->view_model = $view_model ;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $this->view_model->getRowImportUpdate($row);
        }
    }

}
