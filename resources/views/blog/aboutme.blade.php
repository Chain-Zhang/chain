@extends('component.bloglayout')

@section('title')
    About Me
@stop

@section('style')
<link href="{{asset('css/timeline.css')}}" media="all" rel="stylesheet" type="text/css" />
    <style>
        #left{
            width: 75%;
            float: left;
        }
        #right{
            width: 25%;
            float: right;
        }
        #content{
            margin: 50px;
        }
        .tags{
            margin: 5px;
            margin-bottom: 5px;
            margin-top: 5px;
            display: inline-block
        }
    </style>
@stop

@section('content')
    <div id="content" class="panel-body" >
        <div id="left" class="container-fluid main-content">
            <div class="page-title">
                <h1>
                    Chain Zhang
                </h1>
            </div>
            <ul class="timeline animated">
                @foreach($projects as $project)
                <li>
                    <div class="timeline-time">
                        <strong>{{$project->getStringProDate()}}</strong>
                    </div>
                    <div class="timeline-icon">
                        <div class="{{$iconbg_class[array_rand($iconbg_class)]}}">
                            <i class="{{$project->icon}}"></i>
                        </div>
                    </div>
                    <div class="timeline-content">
                        <h2>
                            {{$project->name}}
                        </h2>
                        @if(!empty($project->picture))
                        <img width="320px" src="{{$project->picture}}" />
                        @endif
                        <p>
                            {{$project->desc}}
                        </p>
                        @if(!empty($project->source))
                            <a class="tags label label-info" href="{{$project->source}}">source</a>
                        @endif
                        @if(!empty($project->pro_url))
                            <a class="tags label label-warning" href="{{$project->pro_url}}">web</a>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div id="right">
            <div class="panel panel-success">
                <div class="panel-heading">About Me</div>
                <div class="panel-body">
                    <p>{!! $user_profile->intro !!}</p>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">Contact Me</div>
                <div class="panel-body">
                    <p>Email  : {{$user_profile->email}}</p>
                    <p>QQ 号  : {{$user_profile->qq_number}}</p>
                    <p>Github : <a href="{{$user_profile->github}}">{{$user_profile->github}}</a></p>
                </div>
            </div>
            <div class="panel panel-warning">
                <div class="panel-heading">My Tags</div>
                <div class="panel-body">
                    @foreach($user_profile->tag_arr as $tag)
                        <span class="tags label {{$tag_class[array_rand($tag_class)]}}">{{$tag}}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="{{asset('js/fitvids.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var timelineAnimate ;
            $(".timeline-content").fitVids();
            /*
             # =============================================================================
             #   Timeline animation
             # =============================================================================
             */

            timelineAnimate = function(elem) {
                return $(".timeline.animated li").each(function(i) {
                    var bottom_of_object, bottom_of_window;
                    bottom_of_object = $(this).position().top + $(this).outerHeight();
                    bottom_of_window = $(window).scrollTop() + $(window).height();
                    if (bottom_of_window > bottom_of_object) {
                        return $(this).addClass("active");
                    }
                });
            };
            timelineAnimate();
            $(window).scroll(function() {
                return timelineAnimate();
            });
        });
    </script>
@stop