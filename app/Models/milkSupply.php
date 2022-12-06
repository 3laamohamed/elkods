<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class milkSupply extends Model
{
    use HasFactory;
    protected $table = 'milk_supplies';
    protected $guarded = [];
}
