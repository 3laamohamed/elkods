<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customerClosePeriod extends Model
{
    use HasFactory;
    protected $table= 'customer_close_periods';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded =[];
}
