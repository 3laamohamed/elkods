<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customerPeriods extends Model
{
    use HasFactory;
    protected $table = 'customer_periods';
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
}

