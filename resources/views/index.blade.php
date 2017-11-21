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
        <style type="text/css">*{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}*:before,*:after{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}html{font-size:10px;-webkit-tap-highlight-color:rgba(0,0,0,0)}body{font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.42857143;color:#333;background-color:#fff;margin:0}hr{margin-top:20px;margin-bottom:20px;border:0;border-top:1px solid #eee}h1,h2{font-family:inherit;font-weight:500;line-height:1.1;color:inherit;margin:10px 0}.text-center{text-align:center}ul{margin-top:0;margin-bottom:10px}fieldset{min-width:0;padding:0;margin:0;border:0}.container{padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (max-width:500px){.container{padding:0}}@media (min-width:768px){.container{width:750px}}@media (min-width:992px){.container{width:970px}}@media (min-width:1200px){.container{width:1170px}}.col-xs-1,.col-sm-1,.col-md-1,.col-lg-1,.col-xs-2,.col-sm-2,.col-md-2,.col-lg-2,.col-xs-3,.col-sm-3,.col-md-3,.col-lg-3,.col-xs-4,.col-sm-4,.col-md-4,.col-lg-4,.col-xs-5,.col-sm-5,.col-md-5,.col-lg-5,.col-xs-6,.col-sm-6,.col-md-6,.col-lg-6,.col-xs-7,.col-sm-7,.col-md-7,.col-lg-7,.col-xs-8,.col-sm-8,.col-md-8,.col-lg-8,.col-xs-9,.col-sm-9,.col-md-9,.col-lg-9,.col-xs-10,.col-sm-10,.col-md-10,.col-lg-10,.col-xs-11,.col-sm-11,.col-md-11,.col-lg-11,.col-xs-12,.col-sm-12,.col-md-12,.col-lg-12{position:relative;min-height:1px;padding-right:15px;padding-left:15px}.col-xs-1,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-8,.col-xs-9,.col-xs-10,.col-xs-11,.col-xs-12{float:left}.col-xs-12{width:100%}.col-xs-11{width:91.66666667%}.col-xs-10{width:83.33333333%}.col-xs-9{width:75%}.col-xs-8{width:66.66666667%}.col-xs-7{width:58.33333333%}.col-xs-6{width:50%}.col-xs-5{width:41.66666667%}.col-xs-4{width:33.33333333%}.col-xs-3{width:25%}.col-xs-2{width:16.66666667%}.col-xs-1{width:8.33333333%}@media (min-width:768px){.col-sm-1,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-sm-10,.col-sm-11,.col-sm-12{float:left}.col-sm-12{width:100%}.col-sm-11{width:91.66666667%}.col-sm-10{width:83.33333333%}.col-sm-9{width:75%}.col-sm-8{width:66.66666667%}.col-sm-7{width:58.33333333%}.col-sm-6{width:50%}.col-sm-5{width:41.66666667%}.col-sm-4{width:33.33333333%}.col-sm-3{width:25%}.col-sm-2{width:16.66666667%}.col-sm-1{width:8.33333333%}}@media (min-width:992px){.col-md-1,.col-md-2,.col-md-3,.col-md-4,.col-md-5,.col-md-6,.col-md-7,.col-md-8,.col-md-9,.col-md-10,.col-md-11,.col-md-12{float:left}.col-md-12{width:100%}.col-md-11{width:91.66666667%}.col-md-10{width:83.33333333%}.col-md-9{width:75%}.col-md-8{width:66.66666667%}.col-md-7{width:58.33333333%}.col-md-6{width:50%}.col-md-5{width:41.66666667%}.col-md-4{width:33.33333333%}.col-md-3{width:25%}.col-md-2{width:16.66666667%}.col-md-1{width:8.33333333%}}@media (min-width:1200px){.col-lg-1,.col-lg-2,.col-lg-3,.col-lg-4,.col-lg-5,.col-lg-6,.col-lg-7,.col-lg-8,.col-lg-9,.col-lg-10,.col-lg-11,.col-lg-12{float:left}.col-lg-12{width:100%}.col-lg-11{width:91.66666667%}.col-lg-10{width:83.33333333%}.col-lg-9{width:75%}.col-lg-8{width:66.66666667%}.col-lg-7{width:58.33333333%}.col-lg-6{width:50%}.col-lg-5{width:41.66666667%}.col-lg-4{width:33.33333333%}.col-lg-3{width:25%}.col-lg-2{width:16.66666667%}.col-lg-1{width:8.33333333%}}a{text-decoration:none}.clearfix{clear:both;content:"";font-size:0;height:0;width:0}.top-container h1{text-align:center;font-size:2em;font-weight:600}.top-container h2{text-align:center;font-size:1.5em;font-weight:600}form{margin-bottom:45px}form .field{margin:0 0 18px}form .field label{color:#ed6f2a;font-size:1em;margin-bottom:0;font-weight:600}input[type="text"],input[type="password"],input[type="url"],input[type="tel"],input[type="search"],input[type="number"],input[type="datetime"],input[type="email"]{background:#fff;background-clip:padding-box;border:1px solid #c2c2c2;border-radius:1px;font-family:'Open Sans','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:14px;height:32px;line-height:1.42857143;padding:0 9px;vertical-align:baseline;width:100%;box-sizing:border-box}textarea{background:#fff;background-clip:padding-box;border:1px solid #c2c2c2;border-radius:1px;font-family:'Open Sans','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:14px;height:auto;line-height:1.42857143;margin:0;padding:10px;vertical-align:baseline;width:100%;box-sizing:border-box;resize:vertical;resize:none}form .actions-toolbar .submit{background:#ed6f2a;border:0;color:#fff;font-weight:600;margin-top:15px;line-height:32px;padding:0 15px}.footer{background-color:#536a7b;padding:10px;position:fixed;bottom:0;width:100%;color:#fff;text-align:center}.footer a{color:#fff;font-weight:600}.messages{text-align:center;padding:10px}.messages .success{color:green}.messages .error{color:red}@media only screen and (max-width:767px){form .actions-toolbar .submit{margin-top:0;width:100%}.top-container h1,.top-container h2{font-size:1.5em;font-weight:600}}</style>
        <!--<link rel="stylesheet" href="{{ URL::asset('bootstrap/dist/css/bootstrap.min.css') }}">-->
        <!-- <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">-->

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
        @include('pagespeed.index')
        @include('footer')
        
        <!-- Scripts -->
        <script async src="{{ URL::asset('js/analytics.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/jquery-1.12.4.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>
    </body>
</html>
