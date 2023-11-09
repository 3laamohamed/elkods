<?php

namespace Database\Seeders;

use App\Models\Products;
use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'بقري',
            'جاموسي',
        ];
        foreach ($data as $name){
            $save = ProductType::create([
                'name'=>$name
            ]);
            Products::create([
                'name'=>$name,
                'price'=>0,
                'l_price'=>0,
                'qty'=>0,
                'status'=>1
            ]);
        }
    }
}
