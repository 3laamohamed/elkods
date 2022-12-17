<?php

namespace App\Http\Controllers;

use App\Http\Requests\customerBorrowRequest;
use App\Http\Requests\customerMoneyRequest;
use App\Models\customerMoney;
use App\Models\Customers;
use App\Models\customersBorrow;
use App\Traits\MainFunction;
use Illuminate\Http\Request;

class customersBorrowController extends Controller
{
    use MainFunction;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('customer_borrow');
    }
    public function fetchData(){
        $data = customersBorrow::with('customers')->get();
        $customers = Customers::get()->all();
        return ['customers'=>$customers,'data'=>$data];
    }
    public function addMoney(customerBorrowRequest $request){
        if($request->money > $request->borrow){
            return ['status'=>false,'data'=>'لا يمكن ان يكون قيمة الخصم اكبر من السلفة'];
        }else{
            $save = customersBorrow::create([
                'date'=>$this->getDate(),
                'customer_id'=>$request->customer,
                'value'=>$request->money,
                'borrow'=>$request->borrow,
                're_value'=>0,
                'user'=>$this->getUser()
            ]);
            if($save){
                $data = customersBorrow::with('customers')->find($save->id);
                return ['status'=>true,'add'=>$data,'data'=>'تم الاضافة بنجاح'];
            }
        }
    }
    public function updateMoney(Request $request){
        if($request->value > $request->borrow){
            return ['status'=>false,'data'=>'لا يمكن ان يكون قيمة الخصم اكبر من السلفة'];
        }else{
            $get = customersBorrow::find($request->id);
            $get->value = $request->value;
            $get->borrow = $request->borrow;
            $get->save();
            return ['status'=>true,'data'=>'تم التعديل بنجاح'];
        }
    }
    public function deleteMoney(Request $request){
        $get = customersBorrow::find($request->id);
        $get->delete();
        return ['status'=>true,'data'=>'تم الحذف بنجاح'];
    }
}
