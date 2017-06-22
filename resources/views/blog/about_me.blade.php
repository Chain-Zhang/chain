@extends('component.bloglayout')

@section('title')
About Me
@stop

@section('content')
<div class="container blog-main" style="margin-top: 50px">
    <ol class="breadcrumb">
        <li><h3><a href="{{url('/')}}">Chain Blog</a></h3></li>
    </ol>
    <div class="page-header">
        <h2>About Me</h2>
    </div>
    <div class="panel-body">
        <div class="blog-post">
            {!! $user_profile->intro !!}
        </div>

        <div class="page-header">
            <h3>Contact me</h3>
        </div>
        <div class="panel-body">
            <p>Email: {{$user_profile->email}}</p>
            <p>QQ 号: {{$user_profile->qq_number}}</p>
        </div>
    </div>
</div>
@stop