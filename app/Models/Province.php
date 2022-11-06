<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'title',
        'slug',
        'category_id',
        'content',
        'weight',
        'price',
        'discount'
    ];
}