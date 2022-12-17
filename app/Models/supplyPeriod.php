<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplyPeriod extends Model
{
    use HasFactory;
    protected $table = 'supply_periods';
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
}
