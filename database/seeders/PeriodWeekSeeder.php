<?php

namespace Database\Seeders;

use App\Models\PeriodWeek;
use Illuminate\Database\Seeder;

class PeriodWeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $data = [
//            'السبت',
//            'الاحد',
//            'الاثنين',
//            'الثلاثاء',
//            'الاربعاء',
//            'الخميس',
//            'الجمعة',
//        ];
        $data = [
            ['name'=>'السبت','name_en'=>'saturday'],
            ['name'=>'الاحد','name_en'=>'sunday'],
            ['name'=>'الاثنين','name_en'=>'monday'],
            ['name'=>'الثلاثاء','name_en'=>'tuesday'],
            ['name'=>'الاربعاء','name_en'=>'wednesday'],
            ['name'=>'الخميس','name_en'=>'thursday'],
            ['name'=>'الجمعة','name_en'=>'friday'],
        ];
        foreach ($data as $day){
            PeriodWeek::create([
                'name'=>$day['name'],
                'name_en'=>$day['name_en']
            ]);
        }
    }
}
