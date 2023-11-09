<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsRequest;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('products');
    }
    public function getProducts(){
        $products = Products::get()->all();
        return ['products'=>$products];
    }
    public function savProducts(ProductsRequest $request){
        $save = Products::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'l_price'=>$request->price,
            'pay_price'=>$request->pay_price,
            'qty'=>$request->qty
        ]);
        if($save){
            return ['status'=>true,'product'=>$save,'msg'=>'تم حفظ المنتج بنجاح'];
        }
    }
    public function deleteProduct(Request $request){
        $del = Products::find($request->id)->delete();
        if($del){
            return ['status'=>true,'data'=>'تم حذف المنتج بنجاح'];
        }
    }
    public function updateProduct(Request $request){
        $product = Products::find($request->id);
        $product->name = $request->name;
        $product->pay_price = $request->pay_price;
        $product->qty = $request->qty;
        $product->save();
        if($product){
            return ['status'=>true,'product'=>$product,'data'=>'تم التعديل المنتج بنجاح'];
        }
    }
}
