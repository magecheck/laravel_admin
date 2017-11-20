<?php

use Illuminate\Database\Seeder;

class RoleRouteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_route')->insert([
            ['role_id' => "1", 'route_id' => "1"],
            ['role_id' => "1", 'route_id' => "2"],
            ['role_id' => "1", 'route_id' => "3"],
            ['role_id' => "1", 'route_id' => "4"],
            ['role_id' => "1", 'route_id' => "5"],
            ['role_id' => "1", 'route_id' => "6"],
            ['role_id' => "1", 'route_id' => "7"],
            ['role_id' => "1", 'route_id' => "8"],
            ['role_id' => "1", 'route_id' => "9"],
            ['role_id' => "1", 'route_id' => "10"],
            ['role_id' => "1", 'route_id' => "11"],
            ['role_id' => "1", 'route_id' => "12"],
            ['role_id' => "1", 'route_id' => "13"],
            ['role_id' => "1", 'route_id' => "14"],
            ['role_id' => "1", 'route_id' => "15"],
            ['role_id' => "1", 'route_id' => "16"],
            ['role_id' => "1", 'route_id' => "17"],
            ['role_id' => "1", 'route_id' => "18"],
            ['role_id' => "1", 'route_id' => "19"],
            ['role_id' => "1", 'route_id' => "20"],
            ['role_id' => "1", 'route_id' => "21"]
        ]);
    }
}
