<?php
namespace App\Http\Controllers;

use App\Group;
use App\User;

use HTML;
use URL;
use Input;
use File;

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

use function back;
use function redirect;
use function view;

class GroupController extends Controller 
{
    /**
     * Variable to store route name
     * @var array $request Request
     */
    protected $_routeName = "groups";

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
            ->setName('groups')
            ->setDataProvider(
                new EloquentDataProvider(
                    Group::with('leader','users')
                )
            )
            ->setPageSize(10)
            ->setColumns([
                (new FieldConfig)
                    ->setName('id')
                    ->setLabel(__('Id'))
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('id')
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
                    ->setName('leader_id')
                    ->setLabel(__('Leader'))
                    ->setCallback(function ($val, EloquentDataRow $row) {
                        foreach ($row->getSrc()->users as $key => $user) {
                            if($user->id == $val){
                                return $user->getUsername();
                            }
                        }
                    })
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('leader_id')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider) {
                                return $provider->getBuilder()->whereHas('leader',function($q) use ($val) {
                                    $q->where('users.username','like',"%".$val."%");
                                });
                            })
                    ),
                (new FieldConfig)
                    ->setName('logo')
                    ->setLabel(__('Logo'))
                    ->setCallback(function ($val, EloquentDataRow $row) {
                        if($val){
                            return '<img class="logo-img" src="'.asset($val).'" alt="'.$row->getSrc()->getName().'"/>';
                        }else{
                            return ;
                        }
                    }),
                (new FieldConfig)
                    ->setName('background')
                    ->setLabel(__('Background'))
                    ->setCallback(function ($val, EloquentDataRow $row) {
                        if($val){
                            return '<img class="logo-img" src="'.asset($val).'" alt="'.$row->getSrc()->getName().'"/>';
                        }else{
                            return ;
                        }
                    }),
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
                        if($this->checkPermissionUsers()){
                            $output .=  "<a class='btn btn btn-info' href='".URL::route('groups.users')."/".$row->getSrc()->id."'><i class='glyphicon glyphicon-user' aria-hidden='true'></i> ".__('Users')."</a>";
                        }
                        if($this->checkPermissionUpdate()){
                            $output .=  "<a class='btn btn btn-primary' href='".URL::route('groups.update')."/".$row->getSrc()->id."'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i> ".__('Edit')."</a>";
                        }
                        if($this->checkPermissionDelete()){
                            $output .=  "<a class='btn btn btn-danger' href='".URL::route('groups.delete', array('id' => $row->getSrc()->id))."'><i class='glyphicon glyphicon-trash' aria-hidden='true'></i>".__('Delete')."</a>";
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
                            'href' => URL::route('groups.create')
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
                            ->setFileName('groups')
                            ->setIgnoredColumns(['action'])
                        )
                );
        }

        $grid = (new Grid($cfg))->render();

        return view('admin.grid.groups', ['user' => $this->getUser()], compact('grid'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        $this->validatorAdd($request->all())->validate();
        
        $group = new Group();
        
        if(Input::hasFile('logo')){
            $logo = Input::file('logo');
            
            $path = public_path('logo'.DIRECTORY_SEPARATOR);
            if (!is_dir($path)) { File::makeDirectory($path, 0755); }
            $path .= "groups".DIRECTORY_SEPARATOR;
            if (!is_dir($path)) { File::makeDirectory($path, 0755); }
            $path .= strtolower(str_replace(' ', '-', $request->input('name'))).DIRECTORY_SEPARATOR;
            if (!is_dir($path)) { File::makeDirectory($path, 0755); }

            if(is_file($path.$logo->getClientOriginalName())){
                $cnt = 0;
                while (is_file($path.$cnt.DIRECTORY_SEPARATOR.$logo->getClientOriginalName())) {
                    $cnt++;
                }
                $path .= $cnt.DIRECTORY_SEPARATOR;
            }

            $logo->move($path,$logo->getClientOriginalName());
            chmod($path.$logo->getClientOriginalName(), 0755);
            $realPath = explode(DIRECTORY_SEPARATOR, $path);
            
            foreach ($realPath as $key => $value) {
                if($value != "public"){
                    unset($realPath[$key]);
                }else{
                    unset($realPath[$key]);
                    break;
                }
            }
            $realPath = implode(DIRECTORY_SEPARATOR, $realPath).$logo->getClientOriginalName();
            $group->setLogo($realPath);
        }elseif(!$group->getLogo()){
            $group->setLogo('logo'.DIRECTORY_SEPARATOR.'groups'.DIRECTORY_SEPARATOR.'default.jpg');
        }

        if(Input::hasFile('background')){
            $background = Input::file('background');

            $path = public_path('background'.DIRECTORY_SEPARATOR);
            if (!is_dir($path)) { File::makeDirectory($path, 0755); }
            $path .= "groups".DIRECTORY_SEPARATOR;
            if (!is_dir($path)) { File::makeDirectory($path, 0755); }
            $path .= strtolower(str_replace(' ', '-', $request->input('name'))).DIRECTORY_SEPARATOR;
            if (!is_dir($path)) { File::makeDirectory($path, 0755); }

            if(is_file($path.$background->getClientOriginalName())){
                $cnt = 0;
                while (is_file($path.$cnt.DIRECTORY_SEPARATOR.$background->getClientOriginalName())) {
                    $cnt++;
                }
                $path .= $cnt.DIRECTORY_SEPARATOR;
            }

            $background->move($path,$background->getClientOriginalName());
            chmod($path.$background->getClientOriginalName(), 0755);
            $realPath = explode(DIRECTORY_SEPARATOR, $path);
            
            foreach ($realPath as $key => $value) {
                if($value != "public"){
                    unset($realPath[$key]);
                }else{
                    unset($realPath[$key]);
                    break;
                }
            }
            $realPath = implode(DIRECTORY_SEPARATOR, $realPath).$background->getClientOriginalName();
            $group->setBackground($realPath);
        }elseif(!$group->getBackground()){
            $group->setBackground('background'.DIRECTORY_SEPARATOR.'groups'.DIRECTORY_SEPARATOR.'default.jpg');
        }
        
        $group->setName($request->input('name'));
        $group->save();

        return redirect()->route('groups.view')
                                 ->with('status', __('Group has been created!'));
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.form.groups.add', ['group' => new Group(),'user' => $this->getUser()], compact('grid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        return view('admin.form.groups.edit', ['group' => Group::find($id),'user' => $this->getUser()], compact('grid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function users(Request $request, $id)
    {
        // Grab users
        $query = User::with('groups');
        
        $cfg = (new GridConfig())
            ->setName('users')
            ->setDataProvider(new EloquentDataProvider($query))
            ->setPageSize(10)
            ->setColumns([
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
                    ->setName('username')
                    ->setLabel(__('Username'))
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('username')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('member')
                    ->setLabel(__('Member'))
                    ->setCallback(function ($val, EloquentDataRow $row) use($id) {
                        $value = '';
                        foreach ($row->getSrc()->groups as $group) {
                            if($group->id == $id){
                                $value = 'checked';
                                break;
                            }
                        }
                        
                        return '<input type="checkbox" user="'.$row->getId().'" group="'.$id.'" class="member" '.$value.' />';
                    }),
                (new FieldConfig)
                    ->setName('leader')
                    ->setLabel(__('Leader'))
                    ->setCallback(function ($val, EloquentDataRow $row) use($id) {
                        $value = '';
                        foreach ($row->getSrc()->groups as $group) {
                            if($group->getLeaderId() == $row->getSrc()->id && $group->id == $id){
                                $value = 'checked';
                                break;
                            }
                        }
                        
                        return '<input type="radio" name="leader" user="'.$row->getSrc()->id.'" group="'.$id.'" class="leader" '.$value.' />';
                    })
            ])
            ->setComponents([
                new THead,
                new TFoot
            ]);

        $groupName = Group::find($id)->getName();
        $grid = (new Grid($cfg))->render();

        return view('admin.grid.group_users', [$query->get(),'user' => $this->getUser()], compact('grid', 'groupName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function usersUpdate(Request $request)
    {
        if ($request->has('checked')) {
            if ($request->input('checked') == 'true') {
                Group::find($request->input('group'))->users()->attach($request->input('user'));
            } else {
                Group::find($request->input('group'))->users()->detach($request->input('user'));
            }
        } else {
            $group = Group::find($request->input('group'));
            $group->setLeaderId($request->input('user'));
            $group->save();
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request)
    {
        $this->validator($request->all())->validate();
        
        if($request->has('id'))
        {
            $group = Group::find($request->input('id'));
            if(Input::hasFile('logo')){
                $logo = Input::file('logo');

                $path = public_path('logo'.DIRECTORY_SEPARATOR);
                if (!is_dir($path)) { File::makeDirectory($path, 0755); }
                $path .= "groups".DIRECTORY_SEPARATOR;
                if (!is_dir($path)) { File::makeDirectory($path, 0755); }
                $path .= strtolower(str_replace(' ', '-', $request->input('name'))).DIRECTORY_SEPARATOR;
                if (!is_dir($path)) { File::makeDirectory($path, 0755); }

                if(is_file($path.$logo->getClientOriginalName())){
                    $cnt = 0;
                    while (is_file($path.$cnt.DIRECTORY_SEPARATOR.$logo->getClientOriginalName())) {
                        $cnt++;
                    }
                    $path .= $cnt.DIRECTORY_SEPARATOR;
                }

                $logo->move($path,$logo->getClientOriginalName());
                chmod($path.$logo->getClientOriginalName(), 0755);
                $realPath = explode(DIRECTORY_SEPARATOR, $path);

                foreach ($realPath as $key => $value) {
                    if($value != "public"){
                        unset($realPath[$key]);
                    }else{
                        unset($realPath[$key]);
                        break;
                    }
                }
                $realPath = implode(DIRECTORY_SEPARATOR, $realPath).$logo->getClientOriginalName();
                $group->setLogo($realPath);
            }

            if(Input::hasFile('background')){
                $background = Input::file('background');

                $path = public_path('background'.DIRECTORY_SEPARATOR);
                if (!is_dir($path)) { File::makeDirectory($path, 0755); }
                $path .= "groups".DIRECTORY_SEPARATOR;
                if (!is_dir($path)) { File::makeDirectory($path, 0755); }
                $path .= strtolower(str_replace(' ', '-', $request->input('name'))).DIRECTORY_SEPARATOR;
                if (!is_dir($path)) { File::makeDirectory($path, 0755); }

                if(is_file($path.$background->getClientOriginalName())){
                    $cnt = 0;
                    while (is_file($path.$cnt.DIRECTORY_SEPARATOR.$background->getClientOriginalName())) {
                        $cnt++;
                    }
                    $path .= $cnt.DIRECTORY_SEPARATOR;
                }

                $background->move($path,$background->getClientOriginalName());
                chmod($path.$background->getClientOriginalName(), 0755);
                $realPath = explode(DIRECTORY_SEPARATOR, $path);

                foreach ($realPath as $key => $value) {
                    if($value != "public"){
                        unset($realPath[$key]);
                    }else{
                        unset($realPath[$key]);
                        break;
                    }
                }
                $realPath = implode(DIRECTORY_SEPARATOR, $realPath).$background->getClientOriginalName();
                $group->setBackground($realPath);
            }elseif(!$group->getBackground()){
                $group->setBackground('background'.DIRECTORY_SEPARATOR.'groups'.DIRECTORY_SEPARATOR.'default.jpg');
            }
            
            $group->setName($request->input('name'));

            $group->save();

            return redirect()->route('groups.view')->with('status', __('Group has been updated!'));
        }
        return redirect()->route('groups.view')->with('error', __('Id was missing from the request, check data!'));
    }

    /**
     * Delete the specified resource.
     *
     * @param  string  $id
     * @return Response
     */
    public function delete($id)
    {
        if ($id){
            if($id == 1){
                return back()->with('error', __('Not allowed to delete the main group!'));
            }
            $group = Group::find($id);
            if($group){
                $group->delete();
                return redirect()->route('groups.view')->with('status',  __('Group has been deleted!') );
            }
            
        }
        return back()->with('error', __('Id was missing from the request, check data!'));
    }

    /**
     * Get a validator for an incoming update request.
     *
     * @param  array  $data
     * @return Validator2
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'id' => 'required',
            'name' => 'required|max:255'
        ]);
    }

    /**
     * Get a validator for an incoming add request.
     *
     * @param  array  $data
     * @return Validator2
     */
    protected function validatorAdd(array $data)
    {
        return Validator::make($data, [ 'name' => 'required|max:255','logo' => 'mimes:jpg,png,jpeg|max:1000' ]);
    }
}