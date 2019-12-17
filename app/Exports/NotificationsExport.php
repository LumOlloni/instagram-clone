<?php

namespace App\Exports;

use App\Notification;
use Maatwebsite\Excel\Concerns\FromCollection;

class NotificationsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Notification::all();
    }
}
