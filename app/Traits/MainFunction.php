<?php
namespace App\Traits;

Trait MainFunction {
    public function saveImage($data){
        $file = $data['logo'] -> getClientOriginalExtension();
        $no_rand = rand(10,1000);
        $file_name = time() . $no_rand .  '.' . $file;
        $data['logo'] -> move($data['url'] , $file_name);
        return asset() . 'assets/info/' . $file_name;
    }
}
?>
