<?php

namespace Database\Seeders;

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
            'فرزة',
        ];
        foreach ($data as $name){
            $save = ProductType::create([
                'name'=>$name
            ]);
        }
    }
}
