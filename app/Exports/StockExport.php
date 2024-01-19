<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StockExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */


    use Exportable;

    protected $sales;

    public function __construct($sales)
    {
        $this->sales = $sales;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->sales;
    }

    public function headings(): array
    {
        return [
            "Part Name",
            "Box",
            "WareHouse",
            "Previous Unit Value",
            "Current Unit Value"
        ];
    }

}
