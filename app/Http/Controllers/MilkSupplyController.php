<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Locations;
use App\Models\milkSupply;
use App\Models\PeriodWeek;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Traits\MainFunction;

class MilkSupplyController extends Controller
{
    use MainFunction;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $this->endDay();
        return view('milk_supply');
    }
    protected function getSuppliersMilk($customers,$shift){
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
                $priceNew[$priceCus]['quantity']='';
                foreach ($price->pricequantity as $quan){
                    if($customer->id == $quan->customer && $quan->shift == $shift){
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
        return $customersNew;
    }
    public function getSupplyMilk(){
        $locations = Locations::get()->all();
        $products = ProductType::get()->all();
        $customers =  Customers::with('price','price.pricequantity')->get();
        return ['locations'=>$locations,'products'=>$products,'customers'=>$this->getSuppliersMilk($customers,'صباحي')];
    }
    public function getCustomersInLocationSupply(Request $request){
        if($request->id == 'all'){
            $customers =  Customers::with('price','price.pricequantity')->get();
        }else{
            $customers =  Customers::with('price','price.pricequantity')->where(['location'=>$request->id])->get();
        }
        return ['customers'=>$this->getSuppliersMilk($customers,'صباحي')];
    }
    public function changeShift(Request $request){
        $customers =  Customers::with('price','price.pricequantity')->get();
        return ['customers'=>$this->getSuppliersMilk($customers,$request->shift)];
    }
    public function saveOrderSupply(Request $request){
       foreach ($request->order as $order){
           if(isset($order['row'])){
               $getRow = milkSupply::find($order['row']);
               $moneyDec = $getRow->price * $getRow->quantity;
               $this->decreaseMoney($request->id,$moneyDec);
               $getRow->price = $order['price'];
               $getRow->quantity = $order['quantity'];
               $moneyInc = $order['price'] * $order['quantity'];
               $this->increaseMoney($request->id,$moneyInc);
               $getRow->save();
//               return ['status'=>true,'data'=>'تم التعديل بنجاح'];
           }elseif(!isset($order['row']) && $order['quantity'] != ''){
                $day =  Carbon::today('Africa/Cairo');
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
               $money = $order['price'] * $order['quantity'];
               $this->increaseMoney($request->id,$money);
           }
       }
        $customer =  Customers::limit(1)->with('price','price.pricequantity')->where(['id'=>$request->id])->get();
       $newcus = $this->getSuppliersMilk($customer,$request->shift);
        return ['status'=>true,'customer'=>$newcus[0],'data'=>'تم الحفط بنجاح'];
    }
}
