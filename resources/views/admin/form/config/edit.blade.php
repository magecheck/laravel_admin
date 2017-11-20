@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ __('Edit')." ".__('Config') }}:  <span class="text-info text-uppercase">{{ $config->getName() }}</span></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('config.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $config->getId() }}" />

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $config->getName() }}" required autofocus <?php if($config->getSystem()):?>disabled<?php endif; ?> />

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="col-md-4 control-label">{{ __('Type') }}</label>

                            <div class="col-md-6">
                                <select name="type" class="form-control" required <?php if($config->getSystem()):?>disabled<?php endif; ?>>
                                    <option value="text" <?php if($config->getType() == 'text'):?>selected="selected"<?php endif; ?>>{{ __('text') }}</option>
                                    <option value="integer" <?php if($config->getType() == 'integer'):?>selected="selected"<?php endif; ?>>{{ __('Integer') }}</option>
                                </select>

                                @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                            <label for="value" class="col-md-4 control-label">{{ __('Value') }}</label>

                            <div class="col-md-6">
                                <textarea id="value" type="text" class="form-control" name="value" required >{{ $config->getValue() }}</textarea>

                                @if ($errors->has('value'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('value') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-register">
                                    {{ __('Update')." ".__('Config') }}
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
