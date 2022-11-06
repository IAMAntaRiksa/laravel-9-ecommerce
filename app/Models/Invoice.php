<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice',
        'customer_id',
        'courier',
        'service',
        'cost_courier',
        'weight',
        'name',
        'phone',
        'province_id',
        'city_id',
        'address',
        'status',
        'snap_token',
        'grand_total'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}