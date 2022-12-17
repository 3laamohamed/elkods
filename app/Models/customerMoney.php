<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customerMoney extends Model
{
    use HasFactory;
    protected $table= 'customer_money';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded =[];
    public function customers(){
        return $this->belongsTo(Customers::class,'customer_id','id');
    }
}

