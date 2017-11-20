<?php

namespace App\Http\Controllers;

use HTML;
use URL;
use App\Config;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

use Nayjest\Grids\Components\ExcelExport;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\RenderFunc;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\SelectFilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use Nayjest\Grids\EloquentDataRow;
use function back;
use function view;

class ConfigController extends Controller
{
    /**
     * Variable to store route name
     * @var array $request Request
     */
    protected $_routeName = "config";

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
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request)
    {
        $query = (new Config)->newQuery();
        
        $cfg = (new GridConfig())
            ->setName('administrate')
            ->setDataProvider(
                    new EloquentDataProvider(
                        $query
                    )
            )
            ->setPageSize(10)
            ->setColumns([
                (new FieldConfig)
                    ->setName('id')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('id')
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('name')
                    ->setLabel('Name')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('name')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('type')
                    ->setLabel('type')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('type')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('value')
                    ->setLabel('value')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('value')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                
                (new FieldConfig)
                    ->setName('action')
                    ->setLabel(__('Action'))
                    ->setCallback(function ($val, EloquentDataRow $row) {
                        $output = "";
                        if(!$row->getSrc()->getSystem() && $this->checkPermissionDelete()){
                            $output = "<a class='btn btn btn-danger' href='".URL::route('config.delete', array('id' => $row->getSrc()->id))."'><i class='glyphicon glyphicon-trash' aria-hidden='true'></i>".__('Delete')."</a>";
                        }
                        if($this->checkPermissionUpdate()){
                            $output .=  "<a class='btn btn btn-primary' href='".URL::route('config.update')."/".$row->getSrc()->id."'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i> ".__('Edit')."</a>";
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
                (new THead)
                ->getComponentByName(FiltersRow::NAME)
                ->addComponent(
                    (new ExcelExport)
                        ->setFileName('configs')
                        ->setRenderSection('filters_row_column_action')
                        ->setIgnoredColumns(['action'])
                )
                ->getParent()
            ,new TFoot ]);
        if($this->checkPermissionCreate()){
            $cfg->getComponentByName(THead::NAME)
                ->addComponent(
                    (new HtmlTag)
                        ->setTagName('a')
                        ->setAttributes([
                            'class' => 'btn btn-primary btn-small add-user pull-right',
                            'href' => URL::route('config.create')
                        ])
                        ->addComponent(new RenderFunc(function() {
                            return '<i class="glyphicon glyphicon-plus"></i> '.__('Add');
                        }))
                );
        }

        $grid = (new Grid($cfg))->render();
        
        return view('admin.grid.configs', ['user' => $this->getUser()], compact('grid'));
    }
    
    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.form.config.add', ['config' => new Config(),'user' => $this->getUser()], compact('grid'));
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
        return view('admin.form.config.edit', ['config' => Config::find($id),'user' => $this->getUser()]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Redirect
     */
    public function update(Request $request)
    {
        if($request->has('id'))
        {
            $config = Config::find($request->input('id'));
            
            if($config->getSystem()){
                return redirect()->route('config.view')->with('status', __('Disabled this feature for live website! If you want to update this you will have to go in <app/Http/Controllers/ConfigController.php> line 189 and comment that line!'));
                $this->validatorSystem($request->all())->validate();
            }else{
                if($config->getName() == $request->input('name')){
                    $this->validatorSameName($request->all())->validate();
                }else{
                    $this->validator($request->all())->validate();
                    $config->setName($request->input('name'));
                }
                
                $config->setType($request->input('type'));
            }
            
            $config->setValue($request->input('value'));
            $config->save();

            return redirect()->route('config.view')->with('status', __('Config has been updated!'));
        }
        return redirect()->route('config.view')->with('error', __('Id was missing from the request, check data!'));
    }
    
    
    
    /**
     * Get a validator for an incoming update request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorSystem(array $data)
    {
        return Validator::make($data, [
            'value' => 'required',
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Redirect
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $config = new Config();
        $config->setName($request->input('name'));
        $config->setType($request->input('type'));
        $config->setSystem(0);
        $config->setValue($request->input('value'));
        $config->save();

        return redirect()->route('config.view')
                                 ->with('status', __('Config has been created!'));
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
            'name' => 'required|unique:configs,name',
            'type' => 'required',
            'value' => 'required',
        ]);
    }
    
    /**
     * Get a validator for an incoming update request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorSameName(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'type' => 'required',
            'value' => 'required',
        ]);
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
            $config = Config::find($id);
            if($config){
                if($config->getSystem()){
                    return back()->with('error', __('Not allowed to delete system config!'));
                }
                $config->delete();
                return redirect()->route('config.view')->with('status',  __('Config has been deleted!') );
            }
        }
        return back()->with('error', __('Id was missing from the request, check data!'));
    }
}
