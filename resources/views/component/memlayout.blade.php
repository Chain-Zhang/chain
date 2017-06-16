<!DOCTYPE html>
<html>
<head>
    <title>
        @yield('title')
    </title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    {{--<link href="{{asset('css/bootstrap.css')}}" media="all" rel="stylesheet" type="text/css" />--}}
    <link href="{{asset('css/sweetalert.css')}}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/font-awesome.css')}}" media="all" rel="stylesheet" type="text/css" />
    <link rel="icon" href="{{asset('images/logo.ico')}}" type="image/x-icon"/>
    @yield('style')
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    {{--<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}
    <script src="{{asset('js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery-ui.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.validate.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/sweetalert.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#header_nav li').click(function () {
                $(this).addClass('active').sibling().removeClass('active');
            });

        });

        function _logout() {
            $.ajax({
                url:"{{url('service/logout')}}",
                type:'POST',
                dataType:'json',
                cache:false,
                data:{_token:"{{csrf_token()}}"},
                success:function (data) {
                    console.log('退出返回结果:');
                    console.log(data);
                    if (data == null){
                        swal("退出失败", "服务器错误", "error");
                        return;
                    }
                    if (data.status != 0){
                        swal("退出失败", data.message, "error");
                        return;
                    }
                    swal({title:"退出成功!",text: "您已退出登录!", type:"success" }, function(){
                        location.href = "{{url('member/login')}}";
                    });
                },
                error:function (xhr,status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        }
    </script>
    @yield('script')
</head>

<body>
    @section('header')
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{url('member/home')}}">Chain Blog Admin</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse pull-left">
                    <ul id="header_nav" class="nav navbar-nav">
                        <li ><a href="{{url('member/home')}}">Home</a></li>
                        <li ><a href="{{url('member/todolist')}}">To Do List</a></li>
                        <li ><a href="{{url('member/timeline')}}">Time Line</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Blog <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{url('member/article')}}">博客管理</a></li>
                                <li><a href="{{url('member/category')}}">分类管理</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div id="navbar" class="navbar-collapse collapse pull-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <img class="img-circle" src="{{url('images/avatar-male.jpg')}}" width="23" height="23"/>
                                @if(isset($username))
                                    {{$username}}
                                @else
                                    Unknown
                                @endif
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">修改密码</a></li>
                                <li><a href="#">修改个人资料</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a onclick="_logout();">退出登录</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @show
    @section('content')

    @show
</body>


</html>