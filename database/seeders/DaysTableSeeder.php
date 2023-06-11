<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = [
            ['name' => 'Sunday', 'name_ar' => 'الأحد'],
            ['name' => 'Monday', 'name_ar' => 'الاثنين'],
            ['name' => 'Tuesday', 'name_ar' => 'الثلاثاء'],
            ['name' => 'Wednesday', 'name_ar' => 'الأربعاء'],
            ['name' => 'Thursday', 'name_ar' => 'الخميس'],
            ['name' => 'Friday', 'name_ar' => 'الجمعة'],
            ['name' => 'Saturday', 'name_ar' => 'السبت'],
        ];

        DB::table('days')->insert($days);
    }
}
