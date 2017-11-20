<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Role;
use App\Route;

class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function view()
    {
        return view('admin.permission',['roles' => Role::with('routes')->get(),'routes' => Route::with('roles')->get(),'user' => $this->getUser()]);
    }
    
    /**
     * Check permission update data
     * @param Request $request
     */
    public function update(Request $request) {
        $data = $request->all();
        try {
            $role = Role::find($data['role']);
            if($request->has('view')){
                $pivot = $role->routes()->where('route_id', $data['route'])->first()->pivot;
                if($data['view']){
                    $pivot->view = $data['view'];
                    $pivot->save();
                }else{
                    $pivot->view = 0;
                    $pivot->save();
                }
            }else{
                if($data['checked'] === "true"){
                    $role->routes()->attach($data['route']);
                }else{
                    $role->routes()->detach($data['route']);
                } 
            }
            return json_encode(array( 'status' => 'success', 'message' => __('The permission has been successfully updated!') ), 200);
        } catch (Exception $ex) {
            return json_encode(array( 'status' => 'error', 'message' => $ex ), 500);
        }
        
    }
}
