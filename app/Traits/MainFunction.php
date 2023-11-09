<?php
namespace App\Traits;

use App\Models\customerClosePeriod;
use App\Models\Customers;
use App\Models\Locations;
use App\Models\milkSupply;
use App\Models\pendingPeriods;
use App\Models\PeriodWeek;
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
    public function endPeriodLocations(){
        $day =  Carbon::yesterday('Africa/Cairo')->format('l');
        $dayIn = PeriodWeek::where(['name_en'=>$day])->first();
        $locations = Locations::where(['e_period'=>$dayIn->id])->get();
        foreach ($locations as $location){
            $customers = Customers::with('suppliers_periods','suppliers_day')->where(['location'=>$location->id])->get();
            foreach ($customers as $customer){
                foreach ($customer->suppliers_periods as $row){
                    if(pendingPeriods::where(['customer'=>$row->customer,'day'=>$row->day,'shift'=>$row->shift,'type'=>$row->type])->count() == 0){
                        $save = pendingPeriods::create([
                            'customer'=>$row->customer,
                            'date'=>$row->date,
                            'day'=>$row->day,
                            'shift'=>$row->shift,
                            'type'=>$row->type,
                            'type_name'=>$row->type_name,
                            'price'=>$row->price,
                            'quantity'=>$row->quantity,
                        ]);
                    }else{
                        $update = pendingPeriods::limit(1)->where(['customer'=>$row->customer,'day'=>$row->day,'shift'=>$row->shift,'type'=>$row->type])->first();
                        $total =  ($row->quantity * $row->price) + ($update->quantity * $update->price);
                        $update->quantity += $row->quantity;
                        $update->price = ($total)/($row->quantity + $update->quantity);
                        $update->date = $row->date;
                        $update->save();
                    }
                    supplyPeriod::find($row->id)->delete();
                }
//                foreach ($customer->suppliers_day as $row){
//                    if(pendingPeriods::where(['customer'=>$row->customer,'day'=>$row->day,'shift'=>$row->shift,'type'=>$row->type])->count() == 0){
//                        $save = pendingPeriods::create([
//                            'customer'=>$row->customer,
//                            'date'=>$row->date,
//                            'day'=>$row->day,
//                            'shift'=>$row->shift,
//                            'type'=>$row->type,
//                            'type_name'=>$row->type_name,
//                            'price'=>$row->price,
//                            'quantity'=>$row->quantity,
//                        ]);
//                    }else{
//                        $update = pendingPeriods::limit(1)->where(['customer'=>$row->customer,'day'=>$row->day,'shift'=>$row->shift,'type'=>$row->type])->first();
//                        $total =  ($row->quantity * $row->price) + ($update->quantity * $update->price);
//                        $totalQty = $row->quantity + $update->quantity;
//                        $update->price = $total / $totalQty;
//                        $update->quantity += $row->quantity;
//                        $update->save();
//                    }
//                    milkSupply::find($row->id)->delete();
//                }
            }
        }
    }
    public function deleteCustomerClosePeriods(){
        $date = $this->getDate();
        $del = customerClosePeriod::where('date','!=',$date)->delete();
    }
}
?>
