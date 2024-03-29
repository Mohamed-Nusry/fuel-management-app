<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ScheduleDistribution extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'schedule_distributions';

    protected $fillable = [
        'fuel_station_id',
        'scheduled_date_time',
        'quota',
        'status',
        'created_by',
        'updated_by',
    ];

    public function fuelStation() {
        return $this->belongsTo('App\Models\FuelStation', 'fuel_station_id', 'id');
    }

}
