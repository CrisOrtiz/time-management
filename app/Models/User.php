<?php

namespace App\Models;

use App\Utils\LiquidationPeriod;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Kyslik\ColumnSortable\Sortable;
use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, Uuid32ModelTrait, Sortable;

    const ADMIN = 1;
    const MANAGER = 2;
    const WORKER = 3;

    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'username', 'password', 'user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /*public function tasks()
    {
        return $this->hasMany(Tasks::class, 'assigned_to', 'id');
    }*/

    public function isAdmin()
    {
        return $this->user_type === User::ADMIN;
    }

    public function isManager()
    {
        return $this->user_type === User::MANAGER;
    }

    public function isWorker()
    {
        return $this->user_type === User::WORKER;
    }

    /*public function permissions()
    {
        return $this->belongstoMany(Permission::class, 'permission_user', 'user_id', 'permission_id');
    }*/
}
