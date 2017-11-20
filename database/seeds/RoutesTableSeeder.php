<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class RoutesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        print_r($this->getRoutes());
        DB::table('routes')->insert($this->getRoutes());
    }
    
    /**
     * Getting all routes in route list from artisan
     * @return array $finalRoutes
     */
    public function getRoutes() {
        Artisan::call('route:list');
        $routeList = explode("\n", Artisan::output());
        
        $routes = array_slice($routeList, 8, count($routeList) - 18);

        $finalRoutes = array();
        foreach($routes as $route){
            $elem = explode('|', $route);
            foreach ($elem as $key => $value) {
                if(     strpos($value, 'Closure')   != false    // Not default route
                    ||  strpos($value, 'POST')      != false    // Not Post type route
                    ||  strpos($value, 'account')   != false    // Not account
                    ||  strpos($value, 'dashboard') != false  // Not dashboard
                    ||  strpos($value, 'contact') != false){  // Not Contact
                    $elem = array();
                    break;
                }
                if(trim($value) == '' || in_array($key, array(3,7))){
                    unset($elem[$key]);
                }else{
                    $elem[$key] = trim($value);
                }
            }

            if(count($elem)){
                $elem = array_values($elem);
                $remaped = array(
                    'type' => $elem[0],
                    'route' => $elem[1],
                    'name' => $elem[2],
                    'action' => $elem[3]
                );
                array_push($finalRoutes,$remaped);
            }
        }
        return $finalRoutes;
    }
}
