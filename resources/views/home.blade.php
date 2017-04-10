@extends('layouts.app')

@section('content')
    <div class="row">
        @if (isset($newsOne) && isset($newsSecond))
            @foreach($newsOne as $new)
                <div class="col-md-6 col-xs-6 new-one">
                    @includeIf('partials.new-frame', 
                    ['new' => $new])
                </div>
            @endforeach
            @foreach($newsSecond as $new)
                <div class="col-md-6 col-xs-6 new-second">
                    @includeIf('partials.new-frame', 
                    ['new' => $new])
                </div>
            @endforeach
        @endif
    </div>
<script type="text/javascript">
    var lazyload = function () {
        var obj = $('.new-one');
        var obj2 = $('.new-second');
        if(obj.length > 0) {
            obj.lazyload({
                effect : "fadeIn",
                event : "scroll filter"
            });
        }

        if(obj2.length > 0) {
            obj2.lazyload({
                effect : "fadeIn",
                event : "scroll filter"
            });
        }
    }

    $(document).ready(function(){lazyload();})

</script>
@endsection
