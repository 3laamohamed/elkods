<?php

namespace App\Http\Controllers;

use App\Http\Requests\customerMoneyRequest;
use App\Models\customerMoney;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Traits\MainFunction;

class customerMoneyController extends Controller
{
    use MainFunction;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('customer_money');
    }
    public function fetchData(){
        $data = customerMoney::with('customers')->where(['date'=>$this->getDate()])->get();
        $customers = Customers::get()->all();
        return ['customers'=>$customers,'data'=>$data];
    }
    public function addMoney(customerMoneyRequest $request){
       $save = customerMoney::create([
           'date'=>$this->getDate(),
           'time'=>$this->getTime(),
           'customer_id'=>$request->customer,
           'money'=>$request->money,
           'note'=>$request->note,
           'user'=>$this->getUser()
       ]);
       if($save){
           $this->decreaseMoney($request->customer,$request->money);
           $data = customerMoney::with('customers')->find($save->id);
           return ['status'=>true,'add'=>$data,'data'=>'تم الاضافة بنجاح'];
       }
    }
    public function updateMoney(Request $request){
        $get = customerMoney::find($request->id);
        $this->increaseMoney($get->customer_id,$get->money);
        $this->decreaseMoney($get->customer_id,$request->money);
        $get->money = $request->money;
        $get->save();
        return ['status'=>true,'data'=>'تم التعديل بنجاح'];
    }
    public function deleteMoney(Request $request){
        $get = customerMoney::find($request->id);
        $this->increaseMoney($get->customer_id,$get->money);
        $get->delete();
        return ['status'=>true,'data'=>'تم الحذف بنجاح'];
    }
}
