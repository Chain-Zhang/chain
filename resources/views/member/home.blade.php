@extends('component.memlayout')


@section('content')
    <div class="container theme-showcase" role="main" style="margin-top: 55px">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="{{url('images/first.jpeg')}}" alt="First slide"  width="100%">
            </div>
            <div class="item">
                <img src="{{url('images/second.jpeg')}}" alt="Second slide" width="100%">
            </div>
            <div class="item">
                <img src="{{url('images/third.jpeg')}}" alt="Third slide" width="100%">
            </div>
        </div>
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    </div>
@stop