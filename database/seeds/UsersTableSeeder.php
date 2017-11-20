<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => "admin",
                'role_id' => "1",
                'api_token' => str_random(),
                'username' => "admin",
                'email' => "victorchiriac89@gmail.com",
                'password' => bcrypt('password')
            ],
        ]);
    }
}
