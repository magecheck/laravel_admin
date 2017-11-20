<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ url('/') }}">
          <?php $logo = URL::asset('img/logo.png');
          if($group = $user->groups()->first()):
              if($group->getLogo()){
                  $logo = URL::asset($group->getLogo());
              }
          endif; ?>
            <img src="{{ $logo  }}" alt="Mage Check" />
        </a>
    </div>
    <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
      <ul class="nav navbar-nav navbar-right">
          <li class="<?php if(route('dashboard') == url()->current()):?>active<?php endif;?>"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            @if(Auth::user()->hasPermission('permission'))
                <li class="<?php if(strpos(url()->current(), 'permission')   != false):?>active<?php endif;?>"><a href="{{ route('permission') }}">{{ __('Access') }}</a></li>
            @endif
            @if(Auth::user()->hasPermission('roles.view'))
                <li class="<?php if(strpos(url()->current(), 'roles')   != false):?>active<?php endif;?>"><a href="{{ route('roles.view') }}">{{ __('Roles') }}</a></li>
            @endif
            @if(Auth::user()->hasPermission('groups.view'))
                <li class="<?php if(strpos(url()->current(), 'groups')   != false):?>active<?php endif;?>"><a href="{{ route('groups.view') }}">{{ __('Groups') }}</a></li>
            @endif
            @if(Auth::user()->hasPermission('users.view'))
                <li class="<?php if(strpos(url()->current(), 'users')   != false):?>active<?php endif;?>"><a href="{{ route('users.view') }}">{{ __('Users') }}</a></li>
            @endif
            <li class="<?php if(strpos(url()->current(), 'contact')   != false):?>active<?php endif;?>"><a href="{{ route('contact.view') }}">{{ __('Contact') }}</a></li>
            @if(Auth::user()->hasPermission('config.view'))
                <li class="<?php if(strpos(url()->current(), 'config')   != false):?>active<?php endif;?>"><a href="{{ route('config.view') }}">{{ __('Config') }}</a></li>
            @endif
            <li class="<?php if(strpos(url()->current(), 'account')   != false):?>active<?php endif;?>"><a href="{{ route('account.view') }}">{{ __('Account') }}</a></li>
            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>    
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
      </ul>
    </div>
  </div>
</nav>