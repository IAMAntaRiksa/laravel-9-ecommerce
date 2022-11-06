<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $hidden = [
        'password',
        'remember_token'
    ];
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token'
    ];


    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
