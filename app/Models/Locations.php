<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;
    protected $table = 'locations';
    protected $guarded = [];
    public function startperiod(){
        return $this->belongsTo(PeriodWeek::class,'s_period','id');
    }
    public function endperiod(){
        return $this->belongsTo(PeriodWeek::class,'e_period','id');
    }
}
