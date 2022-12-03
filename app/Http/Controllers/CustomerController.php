<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\CustomerPrice;
use App\Models\Customers;
use App\Models\Locations;
use App\Models\ProductType;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function viewCustomers(){
        return view('customers');
    }
    public function getCustomers(){
        $locations = Locations::get()->all();
        $customers = Customers::with('location')->get()->all();
        return ['locations'=>$locations,'customers'=>$customers];
    }
    public function savCustomers(CustomerRequest $request){
        $save = Customers::create([
            'name' =>$request->name,
            'phone' =>$request->phone,
            'location' =>$request->location,
            'type' =>$request->type,
        ]);
        if($save){
            $products = ProductType::get()->all();
            foreach ($products as $product){
                $savePrice = CustomerPrice::create([
                    'customer'=>$save->id,
                    'type_id'=>$product->id,
                    'type_name'=>$product->name,
                    'price' => 0
                ]);
            }
            return['status'=>true,'id'=>$save->id,'data'=>'تم حفظ العميل'];
        }
    }
    public function updatCustomers(Request $request){
        $update = Customers::limit(1)->where(['id'=>$request->id])->update([
            'name' =>$request->name,
            'phone' =>$request->phone,
            'location' =>$request->location,
            'type' =>$request->type,
        ]);
        if($update){
            return ['status'=>true,'data'=>'تم التعديل بنجاح'];
        }
    }
    public function deletCustomers(Request $request){
        $delete = Customers::limit(1)->where(['id'=>$request->id])->delete();
        if($delete){
            return ['status'=>true,'data'=>'تم الحذف بنجاح'];
        }
    }
}
