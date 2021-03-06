<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Kyslik\ColumnSortable\Sortable;
use Carbon\Carbon;

class Task extends Model
{
    use Notifiable, Uuid32ModelTrait, Sortable;
    
    protected $table = 'task';
    protected $appends = [];
}
