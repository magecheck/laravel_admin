@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <div class="panel panel-info panel-configs">
            <div class="panel-heading">
                {{ __('Configs Management') }}
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
            <p class="text-danger guideline">{{ __("System config's can't be deleted!") }}</p>
                
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