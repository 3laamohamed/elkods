<?php

namespace App\Http\Controllers;

use App\Models\Info;
use Illuminate\Http\Request;
use App\Traits\MainFunction;
use Illuminate\Validation\Rules\In;

class InfoController extends Controller
{
    use MainFunction;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('info');
    }
    public function getInfo(){
        $info = Info::limit(1)->first();
        if(!empty($info)){
            return ['status'=>true,'info'=>$info];
        }else{
            return ['status'=>false];
        }
    }
    public function saveInfo(Request $request){
        $logo = null;
        if($request->logo){
            $data = ['logo'=>$request->logo,'url'=>'assets/info'];
            $logo = $this->saveImage($data);
        }
        if(Info::count() == 0){
            Info::create([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'location'=>$request->location,
                'logo'=>$logo,
            ]);
        }else{
            $get = Info::limit(1)->first();
            if($request->logo){
                Info::where(['id'=>$get->id])->update([
                    'name'=>$request->name,
                    'phone'=>$request->phone,
                    'location'=>$request->location,
                    'logo'=>$logo,
                ]);
            }else{
                Info::where(['id'=>$get->id])->update([
                    'name'=>$request->name,
                    'phone'=>$request->phone,
                    'location'=>$request->location,
                ]);
            }

        }
    }
}
