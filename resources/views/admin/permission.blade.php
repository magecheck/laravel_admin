@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="panel panel-info panel-orders">
                <div class="panel-heading">{{ __('Access Rights') }}</div>

                <div class="panel-body permission-panel">
                    {{ csrf_field() }}
                    <div class="col-sm-12">
                        <div class="col-xs-3">
                            <ul class="nav nav-pills nav-stacked">
                                @foreach($roles as $role)
                                    <li class="<?php if($loop->index == 0): ?>active<?php endif; ?>"  >
                                        <a href="#role{{$role->id}}" data-toggle="tab">{{$role->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-xs-9">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                @foreach($roles as $role)
                                    <div class="tab-pane <?php if($loop->index == 0): ?>active<?php endif; ?>" id="role{{$role->id}}">
                                        <span class="label label-warning"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <strong>{{$role->name}}</strong></span>
                                        <hr>
                                        <div class="alert-top" role="alert">&nbsp;</div>

                                        <ul class="nav nav-pills">
                                            </li>
                                            <li class="pull-right">
                                                <a href="#config{{$role->id}}" data-toggle="tab">{{ __('Config') }}</a>
                                            </li>
                                            <li class="pull-right">
                                                <a href="#users{{$role->id}}" data-toggle="tab">{{ __('Users') }}</a>
                                            </li>
                                            <li class="pull-right">
                                                <a href="#groups{{$role->id}}" data-toggle="tab">{{ __('Groups') }}</a>
                                            </li>
                                            <li class="pull-right">
                                                <a href="#roles{{$role->id}}" data-toggle="tab">{{ __('Roles') }}</a>
                                            </li>
                                            <li class="pull-right active">
                                                <a href="#access{{$role->id}}" data-toggle="tab">{{ __('Access') }}</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <!-- Permission -->
                                            <div class="tab-pane active" id="access{{$role->id}}">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left">{{ __('Action') }}</th>
                                                            <th class="text-left">{{ __('Route') }}</th>
                                                            <th class="text-center">{{ __('Access') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($routes as $route)
                                                            @if ($route->name === 'permission')
                                                                <tr>
                                                                    <td class="text-left">{{__('-'.ucfirst($route->name))}}</td>
                                                                    <td class="text-left">{{$route->route}}</td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" class="permission permission-checkbox" role="{{$role->id}}" route="{{$route->id}}" <?php if($role->routes->contains($route->id)): ?>checked="checked"<?php endif; ?> />
                                                                    </td>
                                                                </tr>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Groups -->
                                            <div class="tab-pane" id="groups{{$role->id}}">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left">{{ __('Action') }}</th>
                                                            <th class="text-left">{{ __('Route') }}</th>
                                                            <th class="text-center">{{ __('Access') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($routes as $route)
                                                            @if (strpos($route->name, 'groups') !== false)
                                                                <tr>
                                                                    <td class="text-left">{{ __('-'.ucfirst(explode('.',$route->name)[1])) }}</td>
                                                                    <td class="text-left">{{$route->route}}</td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" class="permission permission-checkbox" role="{{$role->id}}" route="{{$route->id}}" <?php if($role->routes->contains($route->id)): ?>checked="checked"<?php endif; ?> />
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Roles -->
                                            <div class="tab-pane" id="roles{{$role->id}}">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left">{{ __('Action') }}</th>
                                                            <th class="text-left">{{ __('Route') }}</th>
                                                            <th class="text-center">{{ __('Access') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($routes as $route)
                                                            @if (strpos($route->name, 'roles') !== false)
                                                                <tr>
                                                                    <td class="text-left">{{ __('-'.ucfirst(explode('.',$route->name)[1])) }}</td>
                                                                    <td class="text-left">{{$route->route}}</td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" class="permission permission-checkbox" role="{{$role->id}}" route="{{$route->id}}" <?php if($role->routes->contains($route->id)): ?>checked="checked"<?php endif; ?> />
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Users -->
                                            <div class="tab-pane" id="users{{$role->id}}">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left">{{ __('Action') }}</th>
                                                            <th class="text-left">{{ __('Route') }}</th>
                                                            <th class="text-center">{{ __('Access') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($routes as $route)
                                                            @if (strpos($route->name, 'users') !== false)
                                                                <tr>
                                                                    <td class="text-left">{{ __('-'.ucfirst(explode('.',$route->name)[1])) }}</td>
                                                                    <td class="text-left">{{$route->route}}</td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" class="permission permission-checkbox" role="{{$role->id}}" route="{{$route->id}}" <?php if($role->routes->contains($route->id)): ?>checked="checked"<?php endif; ?> />
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Config -->
                                            <div class="tab-pane" id="config{{$role->id}}">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left">{{ __('Action') }}</th>
                                                            <th class="text-left">{{ __('Route') }}</th>
                                                            <th class="text-center">{{ __('Access') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($routes as $route)
                                                            @if (strpos($route->name, 'config') !== false)
                                                                <tr>
                                                                    <td class="text-left">{{ __('-'.ucfirst(explode('.',$route->name)[1])) }}</td>
                                                                    <td class="text-left">{{$route->route}}</td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" class="permission permission-checkbox" role="{{$role->id}}" route="{{$route->id}}" <?php if($role->routes->contains($route->id)): ?>checked="checked"<?php endif; ?> />
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <script type="text/javascript">
                        $('.permission').click(function(){
                            if(confirm("{{ __('Are you sure you want to change permission?') }}")) {
                                var that = $(this);
                                var data = {
                                        role: that.attr('role'),
                                        route: that.attr('route'),
                                        _token: $('input[type="hidden"]').val(),
                                        checked: that.is(':checked')
                                    };

                                // Ajax differentiating
                                if(that.hasClass('permission-radio')){
                                    data.view = that.val();
                                } 
                                // Uncheck extra params
                                if(that.hasClass('permission-view')){
                                    // Visual effects
                                    if(that.is(':checked')){
                                        // add check to own
                                        $('[name="view'+that.attr('role')+that.attr('route')+'"][value="0"]').prop('checked',true);
                                        $('[name="view'+that.attr('role')+that.attr('route')+'"]').prop('disabled', false);
                                    }else{
                                        // remove check from all input in that row
                                        $('[name="view'+that.attr('role')+that.attr('route')+'"]').prop('checked',false).prop('disabled', true);
                                    }
                                }

                                $.post("<?php echo Request::url() ?>",data,
                                    function(data, status){
                                        data = JSON.parse(data);
                                        var alert = $('div.alert-top');
                                        if(!alert.hasClass('*[class^="alert-"]')){
                                            if(data.status === "success"){
                                                alert.addClass('alert-success');
                                                alert.html("<span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span> "+data.message);
                                            }else{
                                                alert.addClass('alert-warning');
                                                alert.html("<span class='glyphicon glyphicon-thumbs-down' aria-hidden='true'></span> "+data.message);
                                            }
                                        }else{
                                            if(data.status === "success" && !alert.hasClass('alert-success')){
                                                alert.attr('class', 'alert alert-success');
                                                alert.html("<span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span> "+data.message);
                                            }else if(data.status !== "success"){
                                                alert.attr('class', 'alert alert-warning');
                                                alert.html("<span class='glyphicon glyphicon-thumbs-down' aria-hidden='true'></span> "+data.message);
                                            }
                                        }
                                        setTimeout(function() {
                                            alert.attr('class','alert-top').html('&nbsp;');
                                        }, 3000);
                                    }
                                );
                            } else {
                                return false;
                            }
                            
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
