<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Payment::select("id", "user_id", "id_order", "status")->get();
    }

    public function headings(): array
    {
        return ["ID", "User", "Order", "Status"];
    }
}
