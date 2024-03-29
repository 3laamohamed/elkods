<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    public function locations(){
        return $this->belongsTo(Locations::class,'location','id');
    }
    public function price(){
        return $this->hasMany(CustomerPrice::class , 'customer','id');
    }
    public function pricequantity(){
        return $this->hasMany(milkSupply::class ,'customer','id');
    }
    public function suppliers_periods(){
        return $this->hasMany(supplyPeriod::class , 'customer','id');
    }
    public function suppliers_day(){
        return $this->hasMany(milkSupply::class , 'customer','id');
    }
    public function pending_periods(){
        return $this->hasMany(pendingPeriods::class , 'customer','id');
    }
}

