@extends('component.memlayout')

@section('content')
    <div class="container" style="margin-top: 50px">
        <div class="page-header">
            <h3>{{$article->title}}</h3>
        </div>
        <div id="content" class="panel-body">

            {!! $article->content !!}

        </div>
    </div>
@stop

@section('script')
        {{--<script type="text/javascript">--}}
            {{--$(function () {--}}
                {{--console.log('{{$article->content}}');--}}
                {{--$('#content').html("{{$article->content}}");--}}
            {{--});--}}
        {{--</script>--}}
@stop