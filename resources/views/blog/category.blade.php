@extends('component.bloglayout')

@section('title')
    Chain Blog
@stop

@section('main')
    <div class="col-sm-8 blog-main">
        <ol class="breadcrumb">
            <li><a href="{{url('blog')}}">首页</a></li>
            <li class="active">{{$current_category->name}}</li>
        </ol>
        @foreach($articles as $article)
            <div class="blog-post">
                <h2 class="blog-post-title"><a href="{{url('blog/article', ['id'=>$article->id])}}">{{$article->title}}</a></h2>
                <p class="blog-post-meta">{{$article->created_at}}
                    &nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open">({{$article->read_count}})</span></p>
                <div style="display:-webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp:3;overflow:hidden; text-overflow: clip ">
                    {{$article->summary}}
                </div>
            </div><!-- /.blog-post -->
        @endforeach

    </div><!-- /.blog-main -->
@stop