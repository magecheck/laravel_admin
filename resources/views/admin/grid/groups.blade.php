@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <div class="panel panel-info panel-orders">
            <div class="panel-heading">
                {{ __('Groups Management') }}
            </div>
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
            <h2>{{ __('Groups') }}</h2>
            <?php echo $grid ?>
        </div>
    </div>
    <script type="text/javascript">
        $(".btn-danger").click(function(e) {
            if (!confirm('{{ __("Are you sure you want to continue?") }}')) {
                e.preventDefault();
            }
        });
    </script>
@stop

