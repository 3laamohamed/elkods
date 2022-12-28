<?php

namespace App\Http\Controllers;

use App\Models\customerPeriods;
use App\Models\Customers;
use App\Models\customersBorrow;
use App\Models\Info;
use App\Models\Locations;
use App\Models\milkSupply;
use App\Models\periodsData;
use App\Models\PeriodWeek;
use App\Models\procurementBorrow;
use App\Models\ProductType;
use App\Models\supplyPeriod;
use App\Traits\MainFunction;
use Illuminate\Http\Request;


class followSuppliersController extends Controller
{
    use MainFunction;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('follow_suppliers');
    }
    public function getCustomerTotal($getCustomers){
        $customers = [];
        $counter = 0;
        foreach ($getCustomers as $customer){
            $customers[$counter]['id'] = $customer->id;
            $customers[$counter]['name'] = $customer->name;
            $customers[$counter]['phone'] = $customer->phone;
            $customers[$counter]['money'] = $customer->money;
            if($customer->locations){
                $customers[$counter]['location'] = $customer->locations->name;
            }
            $quantity = 0;
            $total = 0;
            foreach ($customer->suppliers_periods as $one){
                $quantity += $one->quantity;
                $total += $one->quantity * $one->price;
            }
            foreach ($customer->suppliers_day as $one){
                $quantity += $one->quantity;
                $total += $one->quantity * $one->price;
            }
            $customers[$counter]['qty'] = $quantity;
            $customers[$counter]['total'] = $total;
            $quantity = 0;
            $total = 0;
            $counter++;
        }
        return $customers;
    }
    public function fetchData(Request $request){
        $locations = Locations::get()->all();
        $products = ProductType::get()->all();
        $getCustomers =  Customers::with('suppliers_periods','suppliers_day')->where(['type'=>'مورد'])->get();
        return ['locations'=>$locations,'products'=>$products,'customers'=>$this->getCustomerTotal($getCustomers)];
    }
    public function fetchDataLocation(Request $request){
        if($request->id != 'all'){
            $getCustomers =  Customers::with('suppliers_periods','suppliers_day')->where(['type'=>'مورد','location'=>$request->id])->get();
        }else{
            $getCustomers =  Customers::with('suppliers_periods','suppliers_day')->where(['type'=>'مورد'])->get();
        }
        return ['customers'=>$this->getCustomerTotal($getCustomers)];
    }
    public function detailsSupplier($customer){
        $counterCus = 0;
        $counterDay = 0;
        $costomerSearch = $customer;
        $counter = 0;
        $day = [];
        $periods = PeriodWeek::select(['id','name'])->get();
        $getCustomer =  Customers::limit(1)
            ->with('suppliers_periods','suppliers_day','locations','locations.startperiod','locations.endperiod')
            ->where(['id'=>$customer,'type'=>'مورد'])->first();
        $supliersPeriods = $getCustomer->suppliers_periods;
        $supliersDay = $getCustomer->suppliers_day;
        $anCounter = sizeof($supliersPeriods);
        foreach ($supliersDay as $one){
            $supliersPeriods[$anCounter] = $one;
            $anCounter++;
        }
        $counterDay = $getCustomer->locations->s_period;
        $customer = $getCustomer->id;
        foreach ($periods as $oneDay){
            if($oneDay->id == $counterDay){
                $day[$counter]['id']=$oneDay->id;
                $day[$counter]['day']=$oneDay->name;
                $day[$counter]['customer']=$customer;
                $day[$counter]['date']=null;
                $day[$counter]['shift']=null;
                $counter++;
                if($counterDay < 7) {
                    $counterDay++;
                }
                if($oneDay->id == 7){
                    foreach ($periods as $oneDayagain){
                        if($oneDayagain->id > $getCustomer->locations->e_period){
                            break;
                        }else{
                            $day[$counter]['id']=$oneDayagain->id;
                            $day[$counter]['day']=$oneDayagain->name;
                            $day[$counter]['customer']=$customer;
                            $day[$counter]['date']=null;
                            $day[$counter]['shift']=null;
                            $counter++;
                        }
                    }
                }
            }
        }
        foreach ($supliersPeriods as $customer){
            $counter = 0;
            foreach ($day as $onDay){
                if($onDay['day'] == $customer->day){
                    $day[$counter]['date'] = $customer->date;
                }
                $counter++;
            }
        }
        $counter = 0;
        $counterL = 0;
        $currentPeriod = [];
        $types = ProductType::get();
        $currentType = [];
        foreach ($types as $type){
            $currentType[$counter]['id'] = $type->id;
            $currentType[$counter]['name'] = $type->name;
            $currentType[$counter]['shifts'] =  [0=>['name'=>'صباحي','qty'=>0,'price'=>0]];
            $currentType[$counter]['shifts'] +=  [1=>['name'=>'مسائي','qty'=>0,'price'=>0]];
            $counter++;
        }
        $counter = 0;
        $counterL = 0;
        $newPeriod = [];
        $counterShift = 0;
        $counterType = 0;
        $newPeriodType = [];
        for($d=0;$d<sizeof($day);$d++){
            $day[$d]['typeData'] = $currentType;
            for($o=0;$o<sizeof($supliersPeriods);$o++){
                if($supliersPeriods[$o]->date == $day[$d]['date']){
                    for($t=0;$t<sizeof($day[$d]['typeData']);$t++){
                        if($day[$d]['typeData'][$t]['id'] == $supliersPeriods[$o]->type){
                            for($sh=0;$sh<sizeof($day[$d]['typeData'][$t]['shifts']);$sh++){
                                if($day[$d]['typeData'][$t]['shifts'][$sh]['name'] == $supliersPeriods[$o]->shift ){
                                    $day[$d]['typeData'][$t]['shifts'][$sh]['qty'] = $supliersPeriods[$o]->quantity;
                                    $day[$d]['typeData'][$t]['shifts'][$sh]['price'] = $supliersPeriods[$o]->price;
                                }
                            }
                        }
                    }
                }
            }
        }
        $getCustomers =  Customers::with('suppliers_periods','suppliers_day')->where(['id'=>$costomerSearch])->get();
        $dataCustomer =  $this->getCustomerTotal($getCustomers);
        $dataCustomer = $dataCustomer[0];
        $borrow = customersBorrow::limit(1)->where(['customer_id'=>$costomerSearch,'status'=>1])->first();
        if($borrow){
            $checkval = $borrow->borrow - $borrow->re_value;
            if($checkval < $borrow->value){
                $borrow->value = $checkval;
            }
        }
        $info = Info::limit(1)->first();
        return view('supplier_period',compact('day','currentType','dataCustomer','borrow','info'));
    }
    public function closePeriod(Request $request){
        $getNewPeriod = customerPeriods::where(['customer_id'=>$request->customer])->max('period_id') + 1;
        $getData = Customers::limit(1)->with('suppliers_periods','suppliers_day')->where(['id'=>$request->customer])->first();
        if($request->valBorrow > $getData->money){
            return 'قيمة سداد السلفه اكبر من المبلغ المستحق';
        }
        return $this->incBorrow($request->customer,$request->valBorrow);
        $addNewPeriod = customerPeriods::create([
            'customer'=>$request->customer,
            'period_id'=>$getNewPeriod,
        ]);
        if($addNewPeriod){
            foreach ($getData->suppliers_periods as $row){
                $saveData = periodsData::create([
                    'customer'=>$row->customer,
                    'customer_period'=>$getNewPeriod,
                    'date'=>$row->date,
                    'day'=>$row->day,
                    'shift'=>$row->shift,
                    'type'=>$row->type,
                    'type_name'=>$row->type_name,
                    'price'=>$row->price,
                    'quantity'=>$row->quantity,
                ]);
            }
            foreach ($getData->suppliers_day as $row){
                $saveData = periodsData::create([
                    'customer'=>$row->customer,
                    'customer_period'=>$getNewPeriod,
                    'date'=>$row->date,
                    'day'=>$row->day,
                    'shift'=>$row->shift,
                    'type'=>$row->type,
                    'type_name'=>$row->type_name,
                    'price'=>$row->price,
                    'quantity'=>$row->quantity,
                ]);
            }
            $customerBorrow = customersBorrow::limit(1)->where(['customer_id'=>$request->customer,'status'=>1])->first();
        }
        return $getData;
    }
    protected function incBorrow($customer,$valBorrow){
        $customerBorrow = customersBorrow::limit(1)->where(['customer_id'=>$customer,'status'=>1])->first();
        $checkval = $customerBorrow->borrow - $customerBorrow->re_value;
        if($checkval < $customerBorrow->value){
            $valBorrow = $checkval;
        }
        $add = procurementBorrow::create([
            'customer_id'=>$customer,
            'user_id'=>$this->getUser(),
            'value'=>$valBorrow,
            'date'=>$this->getDate(),
        ]);
        if($add){
            $customerBorrow->re_value += $valBorrow;
            if($customerBorrow->re_value == $customerBorrow->borrow){
                $customerBorrow->value = 0;
                $customerBorrow->status = 0;
                $customerBorrow->status_ar = 'تم السداد';
            }
            $customerBorrow->save();
        }
    }
}

