<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodWeek extends Model
{
    use HasFactory;
    protected $table = 'period_weeks';
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
}
