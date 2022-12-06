<?php

namespace App\Http\Controllers;

use App\Models\CustomerPrice;
use App\Models\Customers;
use App\Models\Locations;
use App\Models\PeriodWeek;
use App\Models\ProductType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomersPriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('customer_price');
    }
    public function getLocationsPrice(){
        $locations = Locations::get()->all();
        $products = ProductType::get()->all();
        $customers =  Customers::with('price')->get();
        return ['locations'=>$locations,'products'=>$products,'customers'=>$customers];
    }
    public function getCustomersInLocation(Request $request){
        $customers =  Customers::with('price')->where(['location'=>$request->id])->get();
        return ['customers'=>$customers];
    }
    public function updateCustomerPrice(Request $request){
        foreach ($request->price as $price){
            $update = CustomerPrice::limit(1)->where(['customer'=>$request->id,'type_id'=>$price['type_id']])->update([
                'price'=>$price['price'],
            ]);
        }
        return ['status'=>true,'data'=>'تم التعديل بنجاح'];
    }
}
