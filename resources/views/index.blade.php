<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Search Engine Details -->
        <?php if($config->where('name','title')->first()): ?>
            <title>{{ $config->where('name','title')->first()->getValue() }}</title>
        <?php endif; ?>
        <?php if($config->where('name','meta_description')->first()): ?>
            <meta name="description" content="{{ $config->where('name','meta_description')->first()->getValue() }}">
        <?php endif; ?>
        <?php if($config->where('name','meta_keywords')->first()): ?>
            <meta name="keywords" content="{{ $config->where("name","meta_keywords")->first()->getValue() }}">
        <?php endif; ?>
        <?php if($config->where('name','robots')->first()): ?>
            <meta name="robots" content="{{ $config->where('name','robots')->first()->getValue() }}">
        <?php endif; ?>

        <link rel="icon" type="image/x-icon" href="{{ URL::asset('img/favicon.png') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('img/favicon.png') }}">
        
        <?php if($config->where('name','facebook_pixel')->first()): ?>
            <!-- Facebook Pixel Code -->
            <script>
              !function(f,b,e,v,n,t,s)
              {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
              n.callMethod.apply(n,arguments):n.queue.push(arguments)};
              if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
              n.queue=[];t=b.createElement(e);t.async=!0;
              t.src=v;s=b.getElementsByTagName(e)[0];
              s.parentNode.insertBefore(t,s)}(window, document,'script',
              '{{ URL::asset("js/all.js") }}');
              fbq('init', '{{ $config->where("name","facebook_pixel")->first()->getValue() }}');
              fbq('track', 'PageView');
            </script>
            <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $config->where("name","facebook_pixel")->first()->getValue() }}&ev=PageView&noscript=1" /></noscript>
            <!-- End Facebook Pixel Code -->
        <?php endif; ?>
        
        <?php if($config->where('name','google_analytics')->first()): ?>
            <!-- BEGIN GOOGLE ANALYTICS CODE -->
            <script>
            //<![CDATA[
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script',"{{ URL::asset('js/analytics.js') }}",'ga');

                ga('create', '{{ $config->where("name","google_analytics")->first()->getValue() }}', 'auto');
                ga('send', 'pageview');

            //]]>
            </script>
            <!-- END GOOGLE ANALYTICS CODE -->
        <?php endif; ?>
        
        <!-- Styles -->    
        <link rel="stylesheet" href="{{ URL::asset('bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    </head>
    <body>
        {{ csrf_field() }}
        <!-- Content Here -->
        <div class="container">
            <div class="col-md-4 col-sm-12 pull-right"><a href="/admin/dashboard" class=" text-primary text-center"><h2>{{ __('Admin login') }}</h2></a></div>
            <div class="col-md-4 col-sm-12 pull-right"><a href="https://github.com/magecheck/laravel_admin" target="_blank" rel="noreferrer" class=" text-primary text-center"><h2>{{ __('GitHub Link') }}</h2></a></div>
            <div class="col-md-4 col-sm-12 pull-right"><h1 class="text-center">{{ __('Laravel Admin with:') }}</h1></div>
            
            <div class="clearfix"></div>
            <ul>
                <li>{{ __('Bootstrap 3.3.4') }}</li>
                <li>{{ __('Font Awesome') }}</li>
                <li>{{ __('Code supports translation to a different language') }}</li>
                <li>{{ __('Login by changing factor (username or email) - Configurable') }}</li>
                <li>{{ __('My Account') }}</li>
                <li>{{ __('Users') }}</li>
                <li>{{ __('Groups') }}</li>
                <li>{{ __('Roles') }}</li>
                <li>{{ __('Permission over route by user role - Configurable') }}</li>
                <li>{{ __('Contact Section') }}</li>
                <li>{{ __('Google Analytics code') }}</li>
                <li>{{ __('Facebook pixel code') }}</li>
                <li>{{ __('Config section with system configs and ability to add extra') }}</li>
                <li>{{ __('Automatic installation of framework with one shell command that takes about ~5 seconds to process') }}</li>
            </ul>
            <div class="panel-heading text-center"></div>
        </div>
        @include('contact.form')
        @include('footer')
        
        <!-- Scripts -->
        <script async src="{{ URL::asset('js/analytics.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/jquery-1.12.4.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>
    </body>
</html>
