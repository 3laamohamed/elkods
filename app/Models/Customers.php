<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    public function location(){
        return $this->belongsTo(Locations::class,'location','id');
    }
    public function price(){
        return $this->hasMany(CustomerPrice::class , 'customer','id');
    }
}
