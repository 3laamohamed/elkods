<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pendingPeriods extends Model
{
    use HasFactory;
    protected $table = 'pending_periods';
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
}
