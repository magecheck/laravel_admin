<?php

use Illuminate\Database\Seeder;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            [
                'name' => "title",
                'system' => 1,
                'type' => "text",
                'value' => "Mage Check - Laravel Demo Admin"
            ],
            [
                'name' => "meta_description",
                'system' => 1,
                'type' => "text",
                'value' => "Mage Check - this is a demo admin for laravel admin"
            ],
            [
                'name' => "meta_keywords",
                'system' => 1,
                'type' => "text",
                'value' => "laravel admin,laravel permission,laravel roles,laravel groups,laravel users,laravel contact form"
            ],
            [
                'name' => "robots",
                'system' => 1,
                'type' => "text",
                'value' => "INDEX,FOLLOW"
            ],
            [
                'name' => "facebook_pixel",
                'system' => 1,
                'type' => "text",
                'value' => "935377126631298"
            ],
            [
                'name' => "google_analytics",
                'system' => 1,
                'type' => "text",
                'value' => "UA-98092789-1"
            ],
            [
                'name' => "contact",
                'system' => 1,
                'type' => "text",
                'value' => "victorchiriac89@gmail.com"
            ],
        ]);
    }
}
