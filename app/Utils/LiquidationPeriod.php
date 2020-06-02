<?php

namespace App\Utils;

use Carbon\Carbon;

class LiquidationPeriod {
    public $start_date;

    public $end_date;

    public function __construct(Carbon $startDate, Carbon $endDate)
    {
        $this->start_date = $startDate;
        $this->end_date = $endDate;
    }
}
