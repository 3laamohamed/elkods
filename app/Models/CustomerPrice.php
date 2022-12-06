<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPrice extends Model
{
    use HasFactory;
    protected $table= 'customer_prices';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded =[];
    public function pricequantity(){
        return $this->hasMany(milkSupply::class ,'type','type_id');
    }
}
