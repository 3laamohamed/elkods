<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Locations;
use App\Models\milkSupply;
use App\Models\PeriodWeek;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MilkSupplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('milk_supply');
    }

    public function getSupplyMilk(){
        $locations = Locations::get()->all();
        $products = ProductType::get()->all();
        $customers =  Customers::with('price','price.pricequantity')->get();
        $customersNew = [];
        $priceNew = [];
        $counterCus = 0;
        $priceCus = 0;
        foreach ($customers as $customer) {
            $customersNew[$counterCus]['id']=$customer->id;
            $customersNew[$counterCus]['name']=$customer->name;
            $customersNew[$counterCus]['type']=$customer->type;
            foreach ($customer->price as $price){
                $priceNew[$priceCus]['id']=$price->id;
                $priceNew[$priceCus]['type_id']=$price->type_id;
                $priceNew[$priceCus]['type_name']=$price->type_name;
                $priceNew[$priceCus]['price']=$price->price;
                $priceNew[$priceCus]['quantity']=0;
                foreach ($price->pricequantity as $quan){
                    if($customer->id == $quan->customer && $quan->shift == 'صباحي'){
                        if($quan->type == $price->type_id){
                            $priceNew[$priceCus]['row']=$quan->id;
                            $priceNew[$priceCus]['price']=$quan->price;
                            $priceNew[$priceCus]['quantity']=$quan->quantity;
                        }
                    }
                }
                $priceCus++;
                $customersNew[$counterCus]['price']=$priceNew;
            }
            $priceNew = [];
            $priceCus = 0;
            $counterCus++;
        }
        return ['locations'=>$locations,'products'=>$products,'customers'=>$customersNew];
    }
    public function getCustomersInLocationSupply(Request $request){
        if($request->id == 'all'){
            $customers =  Customers::with('price','price.pricequantity')->get();
        }else{
            $customers =  Customers::with('price','price.pricequantity')->where(['location'=>$request->id])->get();
        }
        $customersNew = [];
        $priceNew = [];
        $counterCus = 0;
        $priceCus = 0;
        foreach ($customers as $customer) {
            $customersNew[$counterCus]['id']=$customer->id;
            $customersNew[$counterCus]['name']=$customer->name;
            $customersNew[$counterCus]['type']=$customer->type;
            foreach ($customer->price as $price){
                $priceNew[$priceCus]['id']=$price->id;
                $priceNew[$priceCus]['type_id']=$price->type_id;
                $priceNew[$priceCus]['type_name']=$price->type_name;
                $priceNew[$priceCus]['price']=$price->price;
                $priceNew[$priceCus]['quantity']=0;
                foreach ($price->pricequantity as $quan){
                    if($customer->id == $quan->customer && $quan->shift == $request->shift){
                        if($quan->type == $price->type_id){
                            $priceNew[$priceCus]['row']=$quan->id;
                            $priceNew[$priceCus]['price']=$quan->price;
                            $priceNew[$priceCus]['quantity']=$quan->quantity;
                        }
                    }
                }
                $priceCus++;
                $customersNew[$counterCus]['price']=$priceNew;
            }
            $priceNew = [];
            $priceCus = 0;
            $counterCus++;
        }
        return ['customers'=>$customersNew];
    }
    public function changeShift(Request $request){
        $customers =  Customers::with('price','price.pricequantity')->get();
        $customersNew = [];
        $priceNew = [];
        $counterCus = 0;
        $priceCus = 0;
        foreach ($customers as $customer) {
            $customersNew[$counterCus]['id']=$customer->id;
            $customersNew[$counterCus]['name']=$customer->name;
            $customersNew[$counterCus]['type']=$customer->type;
            foreach ($customer->price as $price){
                $priceNew[$priceCus]['id']=$price->id;
                $priceNew[$priceCus]['type_id']=$price->type_id;
                $priceNew[$priceCus]['type_name']=$price->type_name;
                $priceNew[$priceCus]['price']=$price->price;
                $priceNew[$priceCus]['quantity']=0;
                foreach ($price->pricequantity as $quan){
                    if($customer->id == $quan->customer && $quan->shift == $request->shift){
                        if($quan->type == $price->type_id){
                            $priceNew[$priceCus]['row']=$quan->id;
                            $priceNew[$priceCus]['price']=$quan->price;
                            $priceNew[$priceCus]['quantity']=$quan->quantity;
                        }
                    }
                }
                $priceCus++;
                $customersNew[$counterCus]['price']=$priceNew;
            }
            $priceNew = [];
            $priceCus = 0;
            $counterCus++;
        }
        return ['customers'=>$customersNew];
    }
    public function saveOrderSupply(Request $request){
       foreach ($request->order as $order){
           if(isset($order['row'])){
               $updateRow = milkSupply::where(['id'=>$order['row']])->update([
                   'price'=>$order['price'],
                   'quantity'=>$order['quantity'],
               ]);
           }elseif(!isset($order['row']) && $order['quantity'] != 0){
                $day =  Carbon::today();
                $dayIn = PeriodWeek::where(['name_en'=>$day->format('l')])->first();
               $addRow = milkSupply::create([
                   'customer'=>$request->id,
                   'date'=>$day->toDateString(),
                   'day'=>$dayIn ->name,
                   'shift'=>$request->shift,
                   'type'=>$order['type_id'],
                   'type_name'=>$order['type_name'],
                   'price'=>$order['price'],
                   'quantity'=>$order['quantity'],
               ]);
           }
       }
    }
}
