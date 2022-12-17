<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customersBorrow extends Model
{
    use HasFactory;
    protected $table= 'customers_borrows';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded =[];
    public function customers(){
        return $this->belongsTo(Customers::class,'customer_id','id');
    }
}
