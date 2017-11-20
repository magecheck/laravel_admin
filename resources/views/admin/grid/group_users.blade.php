@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <div class="panel panel-info panel-orders">
            <div class="panel-heading">
                {{ __('Group-Users Management') }}
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
            <h2>{{ __('Group') }}: {{ $groupName }}</h2>
            <?php echo $grid ?>
            {{ csrf_field() }}
        </div>
    </div>
    <script type="text/javascript">
        $(".member").click(function() {
            var that = $(this);           
            $.post("{{ route('groups.users') }}", { user: that.attr('user'), group: that.attr('group'), _token: $("[name='_token']").val(), checked: that.is(":checked") });
        });
        $(".leader").click(function() {
            var that = $(this);
            $.post("{{ route('groups.users') }}", { user: that.attr('user'), group: that.attr('group'), _token: $("[name='_token']").val() });
            if (!$(".member[user='"+that.attr('user')+"']").is(":checked")) {
                $(".member[user='"+that.attr('user')+"']").click();
            }
        });
    </script>
@stop