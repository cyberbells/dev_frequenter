<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    use HasFactory;

    // Allow these fields for mass assignment
    protected $fillable = [
        'customer_id',
        'business_id',
        'check_in_time',
    ];
}
