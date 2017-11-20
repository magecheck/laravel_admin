@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ __('Add') }}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('groups.create') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus />

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                            <label for="logo" class="col-md-4 control-label">{{ __('Logo') }}</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="logo" id="logo">
                                @if ($errors->has('logo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('background') ? ' has-error' : '' }}">
                            <label for="background" class="col-md-4 control-label">{{ __('Background') }}</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="background" id="background">
                                @if ($errors->has('background'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('background') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if($group->background)
                            <div class="form-group">
                                <label for="background" class="col-md-4 control-label">&nbsp;</label>
                                <div class="col-md-6 text-center">
                                    <img class="logo-img" src="{{ asset($group->background) }}" alt="{{ $group->name }}"/>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-register">
                                    {{ __('Add')." ".__('Group') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
