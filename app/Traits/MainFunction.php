<?php
namespace App\Traits;

use App\Models\Customers;
use App\Models\milkSupply;
use App\Models\supplyPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

Trait MainFunction {
    public function saveImage($data){
        $file = $data['logo'] -> getClientOriginalExtension();
        $no_rand = rand(10,1000);
        $file_name = time() . $no_rand .  '.' . $file;
        $data['logo'] -> move($data['url'] , $file_name);
        return asset() . 'assets/info/' . $file_name;
    }
    public function endDay(){
        $date =  $this->getDate();
        $data = milkSupply::where('date','!=',$date)->get();
        foreach ($data as $row){
            supplyPeriod::create([
                'customer'=>$row->customer,
                'date'=>$row->date,
                'day'=>$row ->day,
                'shift'=>$row->shift,
                'type'=>$row->type,
                'type_name'=>$row->type_name,
                'price'=>$row->price,
                'quantity'=>$row->quantity,
            ]);
            $row->delete();
        }
    }
    public function increaseMoney($customer,$money){
        $customer = Customers::find($customer);
        $customer->money = $customer->money + $money;
        $customer->save();
    }
    public function decreaseMoney($customer,$money){
        $customer = Customers::find($customer);
        $customer->money = $customer->money - $money;
        $customer->save();
    }
    public function getDate(){
        return Carbon::today()->toDateString();
    }
    public function getTime(){
        return Carbon::now('Africa/Cairo')->toTimeString();
    }
    public function getUser(){
        return Auth::user()->id;
    }
}
?>
