<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class periodsData extends Model
{
    use HasFactory;
    protected $table = 'periods_data';
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
}
