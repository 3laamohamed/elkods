<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class procurementBorrow extends Model
{
    use HasFactory;
    protected $table = 'procurement_borrows';
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
}
