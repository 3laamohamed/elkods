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
        $data = [
            'السبت',
            'الاحد',
            'الاثنين',
            'الثلاثاء',
            'الاربعاء',
            'الخميس',
            'الجمعة',
        ];
        foreach ($data as $day){
            PeriodWeek::create(['name'=>$day]);
        }
    }
}
