<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customers;
use App\Models\Locations;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
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
        if($save){return['status'=>true,'data'=>'تم حفظ العميل'];}
    }
    public function updatCustomers(){
        //
    }
    public function deletCustomers(){
        //
    }
}
