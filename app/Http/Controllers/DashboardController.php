<?php

namespace App\Http\Controllers;

use App\Route;

use Illuminate\Http\Request;

use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\EloquentDataRow;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;

class DashboardController extends Controller
{
    CONST Current_Route = 'dashboard';
    
    /**
     * Variable to store route name
     * @var array $request Request
     */
    protected $_routeName = "dashboard";

    /**
     * Show the application dashboard.
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request)
    {
        return view('admin.dashboard', ['user' => $this->getUser()]);
    }
}
