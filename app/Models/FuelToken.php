<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class FuelToken extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'fuel_tokens';

    protected $fillable = [
        'token_ref',
        'customer_id',
        'fuel_request_id',
        'payment_reference',
        'status',
        'created_by',
        'updated_by',
    ];

    public function customer() {
        return $this->belongsTo('App\Models\User', 'customer_id', 'id');
    }

    public function fuelRequest() {
        return $this->belongsTo('App\Models\FuelRequest', 'fuel_request_id', 'id');
    }

}
