<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Customers;
use App\Models\Locations;
use App\Models\PeriodWeek;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function viewLocations(){
        return view('locations');
    }
    public function getLocations(){
        $periods = PeriodWeek::select(['id','name'])->get();
        $locations = Locations::with(['startperiod','endperiod'])->get()->all();
        return ['locations'=>$locations,'periods'=>$periods];
    }
    public function saveLocation(LocationRequest $request){
        $save = Locations::create([
            'name'=>$request->name,
            's_period'=>$request->s_period,
            'e_period'=>$request->e_period,
        ]);
        if($save){return ['status'=>true,'id'=>$save->id,'data'=>'تم حفظ المنطقة'];}
    }
    public function updateLocation(Request $request){
        $update = Locations::limit(1)->where(['id'=>$request->id])->update([
            'name'=>$request->name,
            's_period'=>$request->s_period,
            'e_period'=>$request->e_period,
        ]);
        if($update){
            return ['status'=>true,'data'=>'تم التعديل بنجاح'];
        }
    }
    public function deleteLocation(Request $request){
        if(Customers::limit(1)->where(['location'=>$request->id])->count() > 0){
            return ['status'=>false,'data'=>'لا يمكن الحذف'];
        }else{
            $delete = Locations::limit(1)->where(['id'=>$request->id])->delete();
            if($delete){
                return ['status'=>true,'data'=>'تم الحذف بنجاح'];
            }
        }
    }
}
