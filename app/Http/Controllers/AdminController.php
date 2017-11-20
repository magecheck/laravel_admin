<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Group;

use HTML;
use URL;

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
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\SelectFilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use Nayjest\Grids\EloquentDataRow;

use function back;
use function view;

class AdminController extends Controller
{
    /**
     * Variable to store route name
     * @var array $request Request
     */
    protected $_routeName = "users";

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
     * @param  Request  $request
     * @return Response
     */
    public function view(Request $request)
    {
        $cfg = (new GridConfig())
            ->setName('administrate')
            ->setDataProvider(
                    new EloquentDataProvider(
                        User::with('groups','role')
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
                    ->setName('group')
                    ->setLabel(__('Groups'))
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setOptions(Group::getGroupsToArray())
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()->whereHas('groups',function($q) use ($val) {
                                    $q->where('group_user.group_id', '=', $val);
                                });
                            })
                    )
                    ->setCallback(function ($val, EloquentDataRow $row){
                        $groups = User::find($row->getSrc()->id)->groups;
                        $count = count($groups);
                        $output = '';
                        foreach ($groups as $group){
                            $output .= HTML::linkRoute('groups.view', $group->name, ['groups[filters][id-eq]' => $group->id]);
                            if($count > 1){
                                $output .= '<br>';
                                $count--;
                            }
                        }
                        return $output;
                    }),
                (new FieldConfig)
                    ->setName('role_id')
                    ->setLabel(__('Role'))
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setOptions(Role::getAllRolesToArray())
                    )
                    ->setCallback(function ($val, EloquentDataRow $row) {
                        return $row->getSrc()->role->getName();
                    })
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
                    ->setName('username')
                    ->setLabel(__('Username'))
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('username')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('email')
                    ->setLabel(__('E-mail'))
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('email')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('action')
                    ->setLabel(__('Action'))
                    ->setCallback(function ($val, EloquentDataRow $row) {
                        $output = "";
                        if($this->checkPermissionUpdate()){
                            $output .=  "<a class='btn btn-primary' href='".URL::route('users.update')."/".$row->getSrc()->id."'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i> ".__('Edit')."</a>";
                        }
                        if($this->checkPermissionDelete()){
                            $output .=  "<a class='btn btn btn-danger' href='".URL::route('users.delete', array('id' => $row->getSrc()->id))."'><i class='glyphicon glyphicon-trash' aria-hidden='true'></i>".__('Delete')."</a>";
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
                            'href' => URL::route('users.create')
                        ])
                        ->addComponent(new RenderFunc(function() {
                            return '<i class="glyphicon glyphicon-plus"></i> '.__('Add');
                        }))
                );
        }
        if($this->checkPermissionExport())
        {
            $cfg->getComponentByName(THead::NAME)
                   ->addComponent(
                        (new HtmlTag)
                            ->setTagName('span')
                            ->setAttributes([
                                'class' => 'btn-export pull-left'
                            ])
                            ->addComponent(
                                (new ExcelExport)
                                ->setFileName('admin_users')
                                ->setIgnoredColumns(['action'])
                            )
                    );
        }

        $grid = (new Grid($cfg))->render();
        
        return view('admin.grid.users', ['user' => $this->getUser()], compact('grid'));
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
        return view('admin.form.users.edit', ['user' => User::find($id), 'roles' => Role::getAllRolesToArray(), 'groups' => Group::getAllGroupsToArray()]);
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
            $user = User::find($request->input('id'));

            $user->setName($request->input('name'));
            $user->setUsername($request->input('username'));
            $user->setRoleId($request->input('role_id'));
            $user->setEmail($request->input('email'));

            if($request->has('password'))
            {
                $user->setPassword($request->input('password'));
            }
            if($request->has('groups'))
            {
                $user->groups()->detach();
                foreach($request->input('groups') as $group){
                    $user->groups()->attach($group);
                }
            }

            $user->save();
            
            return redirect()->route('users.view')
                             ->with('status', __('User has been updated!'));
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
            'name' => 'required|max:255',
            'role_id' => 'required|max:255',
            'username' => 'required|max:255',
            'email' => 'max:255',
        ]);
    }

    /**
     * Delete the specified resource.
     *
     * @return Response
     */
    public function delete($id)
    {
        if ($id){
            if($id == 1){
                return back()->with('error', __('Not allowed to delete the main admin!'));
            }
            $user = User::find($id);
            if($user){
                $user->delete();
                return redirect()->route('users.view')->with('status',  __('User has been deleted!') );
            }
        }
        return back()->with('error', __('Id was missing from the request, check data!'));
    }
}
