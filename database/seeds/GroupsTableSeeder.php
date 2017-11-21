<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            [
                'name' => "Administrator",
                'leader_id' => "1",
                'logo' => "logo/groups/head/logo.png",
                'background' => "background/groups/head/background.jpg"
            ]
        ]);
    }
}
