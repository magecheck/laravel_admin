<?php
namespace App\Http\Controllers;

use App\Role;
use HTML;
use URL;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Nayjest\Grids\Components\ExcelExport;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\RenderFunc;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\EloquentDataRow;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;

class RoleController extends Controller 
{
    /**
     * Variable to store role name
     * @var array $request Request
     */
    protected $_routeName = "roles";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function view()
    {        
        $cfg = (new GridConfig())
            ->setName('roles')
            ->setPageSize(10)
            ->setDataProvider(
                new EloquentDataProvider(
                    (new Role)->newQuery()
                )
            )
            ->setColumns([
                (new FieldConfig)
                    ->setName('id')
                    ->setLabel(__('Id'))
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('id')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('name')
                    ->setLabel(__('Name'))
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('name')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('created_at')
                    ->setLabel(__('Created'))
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('updated_at')
                    ->setLabel(__('Updated'))
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('action')
                    ->setLabel(__('Action'))
                    ->setCallback(function ($val, EloquentDataRow $row) {
                        $output = "";
                        if($this->checkPermissionUpdate()){
                            $output .=  "<a class='btn btn-primary' href='".URL::route('roles.update').'/'.$row->getSrc()->id."'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i> ".__('Edit')."</a>";
                        }
                        if($this->checkPermissionDelete()){
                            $output .=  "<a class='btn btn-danger' href='".URL::route('roles.delete',array('id' => $row->getSrc()->id))."'><i class='glyphicon glyphicon-trash' aria-hidden='true'></i> ".__('Delete')."</a>";
                        }
                        return $output;
                    })
            ])
            ->setComponents([ 
                (new OneCellRow)
                    ->setRenderSection(RenderableRegistry::SECTION_END)
                    ->setComponents([
                        new RecordsPerPage,
                    ]),
                (new THead),
                (new TFoot) 
            ]);
     
        if($this->checkPermissionCreate()){
            $cfg->getComponentByName(THead::NAME)
                ->addComponent(
                    (new HtmlTag)
                        ->setTagName('a')
                        ->setAttributes([
                            'class' => 'btn btn-primary btn-small add-user pull-right',
                            'href' => URL::route('roles.create')
                        ])
                        ->addComponent(new RenderFunc(function() {
                            return '<i class="glyphicon glyphicon-plus"></i> '.__('Add');
                        }))
                );
        }
        if($this->checkPermissionExport()){
            $cfg->getComponentByName(THead::NAME)
                ->addComponent(
                    (new HtmlTag)
                        ->setTagName('span')
                        ->setAttributes([
                            'class' => 'btn-export pull-left'
                        ])
                        ->addComponent(
                            (new ExcelExport)
                            ->setFileName('roles')
                            ->setIgnoredColumns(['action'])
                        )
                );
        }

        $grid = (new Grid($cfg))->render();

        return view('admin.grid.roles', ['user' => $this->getUser()], compact('grid'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Redirect
     */
    public function register(Request $request)
    {
        $this->validatorAdd($request->all())->validate();

        $role = new Role();
        $role->setName($request->input('name'));
        $role->save();

        return redirect()->route('roles.view')
                                 ->with('status', __('Role has been created!'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.form.roles.add', ['user' => $this->getUser()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        return view('admin.form.roles.edit', ['role' => Role::find($id),'user' => $this->getUser()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Redirect
     */
    public function update(Request $request)
    {
        $this->validator($request->all())->validate();

        if($request->has('id'))
        {
            $role = Role::find($request->input('id'));
            
            $role->setName($request->input('name'));
            $role->save();

            return redirect()->route('roles.view')->with('status', __('Role has been updated!'));
        }
        return redirect()->route('roles.view')->with('error', __('Id was missing from the request, check data!'));
    }
    
    /**
     * Delete the specified resource.
     *
     * @param  integer $id
     * @return Redirect
     */
    public function delete($id)
    {
        if ($id){
            if($id == 1){
                return back()->with('error', __('Not allowed to delete the main role!'));
            }
            $role = Role::find($id);
            if($role){
                $role->delete();
                return redirect()->route('roles.view')->with('status',  __('Role has been deleted!') );
            }
        }
        return back()->with('error', __('Id was missing from the request, check data!'));
    }

    /**
     * Get a validator for an incoming update request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'id' => 'required',
            'name' => 'required|max:255',
        ]);
    }

    /**
     * Get a validator for an incoming add request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorAdd(array $data)
    {
        return Validator::make($data, [ 'name' => 'required|max:255' ]);
    }
}