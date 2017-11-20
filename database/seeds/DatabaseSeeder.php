<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * List of tables affected by seed
     * @var arary $tables
     */
    protected $tables = [
        'users',
        'groups',
        'group_user',
        'roles',
        'routes',
        'role_route',
        'configs'
    ];
    
    /**
     * List of seeders
     * @var array 
     */
    protected $seeders = [
        'RolesTableSeeder',
        'UsersTableSeeder',
        'GroupsTableSeeder',
        'GroupUserTableSeeder',
        'RoutesTableSeeder',
        'RoleRouteTableSeeder',
        'ConfigsTableSeeder'
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->cleanDatabase();

        foreach ($this->seeders as $seeder)
        {
            $this->call($seeder);
        }
    }
    
    private function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach ($this->tables as $table)
        {
            DB::table($table)->truncate();
        }  
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
