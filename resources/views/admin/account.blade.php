@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="panel panel-info panel-orders panel-myacc">
                <div class="panel-heading">{{ __('My account') }}</div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="panel-body">
                    <div class="panel-body account-panel">
                    <div class="col-sm-12">
                        <div class="col-xs-3">
                            <ul class="nav nav-pills nav-stacked">
                                <li class="active"  >
                                    <a href="#details" data-toggle="tab">{{ __('Details') }}</a>
                                </li>
                                <li class=""  >
                                    <a href="#group" data-toggle="tab">{{ __('Group') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-9">
                            <div class="tab-content">
                                <div class="tab-pane active" id="details">
                                    <p>
                                        <a href="{{ route('account.update') }}" class="pull-right label label-primary btn-register"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ __('Edit') }}</a>
                                        <div class="clearfix"></div>
                                    </p>
                                    <table class="table">
                                        <tbody>
                                            <tr class="row">
                                                <td class="col-sm-6 col-md-6">{{ __('Username') }}</td>
                                                <td class="col-sm-6 col-md-6 text-left">{{ $user->username }}</td>
                                            </tr>
                                            <tr class="row">
                                                <td class="col-sm-6 col-md-6">{{ __('Name') }}</td>
                                                <td class="col-sm-6 col-md-6 text-left">{{ $user->name }}</td>
                                            </tr>
                                            <tr class="row">
                                                <td class="col-sm-6 col-md-6">{{ __('E-mail') }}</td>
                                                <td class="col-sm-6 col-md-6 text-left">{{ $user->email }}</td>
                                            </tr>
                                            <tr class="row">
                                                <td class="col-sm-6 col-md-6">{{ __('Role') }}</td>
                                                <td class="col-sm-6 col-md-6 text-left">{{ $user->role->name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="group">
                                    @foreach($user->groups as $group)
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    <span class="glyphicon glyphicon-th" aria-hidden="true"></span> {{ __('Group') }} <strong>{{ $group->name }}</strong>
                                                </h3>
                                            </div>
                                            <div class="panel-body">
                                                @if($group->hasLeader())
                                                    <table>
                                                        <tbody>
                                                            <tr class="row">
                                                                <td class="col-sm-6 col-md-6"><span class="glyphicon glyphicon-king" aria-hidden="true"></span> {{ __('Leader') }}</td>
                                                                <td class="col-sm-3 col-md-3 text-left">{{ __('Name') }}:</td>
                                                                <td class="col-sm-3 col-md-3 text-left">{{ $group->leader->name }}</td>
                                                            </tr>
                                                            <tr class="row">
                                                                <td class="col-sm-6 col-md-6">&nbsp;</td>
                                                                <td class="col-sm-3 col-md-3 text-left">{{ __('E-mail') }}:</td>
                                                                <td class="col-sm-3 col-md-3 text-left">{{ $group->leader->email }}</td>
                                                            </tr>
                                                            <tr class="row">
                                                                <td class="col-sm-6 col-md-6">&nbsp;</td>
                                                                <td class="col-sm-3 col-md-3 text-left">&nbsp;</td>
                                                                <td class="col-sm-3 col-md-3 text-left">&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                @endif
                                                @if(count($group->user) > 1 || (count($group->user) == 1 && $group->user->first()->id != $group->getLeaderId()))
                                                    <table>
                                                        <tbody>
                                                            <tr class="row members">
                                                                <td class="col-sm-3 col-md-3"><span class="glyphicon glyphicon-pawn" aria-hidden="true"></span> {{ __('Members') }}</td>
                                                                <td class="col-sm-3 col-md-3 text-left">&nbsp;</td>
                                                                <td class="col-sm-3 col-md-3 text-left">&nbsp;</td>
                                                            </tr>
                                                            @foreach($group->user as $accUser)
                                                                @if($accUser->id != $group->getLeaderId())
                                                                    <tr class="row">
                                                                        <td class="col-sm-4 col-md-4 text-left"><strong>{{ __('Name') }}:</strong> {{ $accUser->name }}</td>
                                                                        <td class="col-sm-4 col-md-4 text-left"><strong>{{ __('Username') }}:</strong> {{ $accUser->username }}</td>
                                                                        <td class="col-sm-4 col-md-4 text-left"><strong>{{ __('E-mail') }}:</strong> {{ $accUser->email }}</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
