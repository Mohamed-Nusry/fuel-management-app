<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class FuelRequest extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'fuel_requests';

    protected $fillable = [
        'customer_id',
        'fuel_station_id',
        'vehicle_registration_id',
        'vehicle_id',
        'requested_quota',
        'expected_date_time',
        'status',
        'created_by',
        'updated_by',
    ];

}
