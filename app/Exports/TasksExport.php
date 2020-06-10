<?php

namespace App\Exports;

use App\Task;
use Maatwebsite\Excel\Concerns\FromCollection;

class TasksExport implements FromCollection
{

    protected $from;
    protected $to;

    function __construct($request)
    {
        $this->from = $request->from;
        $this->to = $request->to;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Task::where('date','<=','to')->orWhere('date','>=','from')->get();
    }
}
