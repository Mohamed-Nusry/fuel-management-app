<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class VehicleRegistration extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'vehicle_registrations';

    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'vehicle_registration_number',
        'chassis_no',
        'total_quota',
        'available_quota',
        'created_by',
        'updated_by',
    ];

    public function customer() {
        return $this->belongsTo('App\Models\User', 'customer_id', 'id');
    }

    public function vehicle() {
        return $this->belongsTo('App\Models\Vehicle', 'vehicle_id', 'id');
    }

}
