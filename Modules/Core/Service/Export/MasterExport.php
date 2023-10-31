<?php

namespace Modules\Core\Service\Export;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

//WithHeadings
class MasterExport implements FromCollection
{
    use Exportable;
    public $items = [];
    public $view_model;
    public function __construct($items , $view_model)
    {
        $this->items = $items ;
        $this->view_model = $view_model ;
    }

    public function collection()
    {

        return $this->items->map(function ($item) {
            $item = $this->view_model->getRowExportUpdate($item);
            return $item->toArray() ;
        });

    }

//    public function headings(): array
//    {
//        return [
//           ''=>'',
//        ];
//    }
}
