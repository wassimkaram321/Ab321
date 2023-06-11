<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialMediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $socialMedia = [
            ['name' => 'Facebook',  'name_ar' => 'فيسبوك',   'image' => 'Facebook-Logo.png'],
            ['name' => 'Instagram', 'name_ar' => 'انستغرام', 'image' => 'Instagram-logo.png'],
            ['name' => 'Whatsapp',  'name_ar' => 'واتساب',   'image' => 'Whatsapp-logo.png'],
            ['name' => 'Youtube',   'name_ar' => 'يوتيوب',   'image' => 'Youtube-logo.png'],
            ['name' => 'Tiktok',    'name_ar' => 'تيكتوك',   'image' => 'Tiktok-logo.png'],
            ['name' => 'Twitter',   'name_ar' => 'تيكتوك',   'image' => 'Twitter-logo.png'],
            ['name' => 'Pinterest', 'name_ar' => 'بينتريست', 'image' => 'Pinterest-logo.png'],

        ];

        DB::table('social_media')->insert($socialMedia);
    }
}
