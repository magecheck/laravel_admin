<?php

namespace App\Http\Controllers;

use App\Config;

use Illuminate\Http\Request;
use function back;
use function redirect;
use function view;

class IndexController extends Controller
{
    /**
     * Variable to store route name
     * @var array $request Request
     */
    protected $_routeName = "";
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function view()
    {
        return view('index', ['user' => $this->getUser(),'config' => Config::all()]);
    }
}
