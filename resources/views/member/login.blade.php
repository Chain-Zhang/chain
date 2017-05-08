@extends('component.memlayout')

@section('title')
    登录
@stop

@section('style')
    <link href="{{asset('css/app.css')}}" media="all" rel="stylesheet" type="text/css" />
@stop
@section('header')
@stop
@section('content')
    <div class="login">
    <div class="login-wrapper">
        <div class="login-container">
            <a href="index.html"><img width="100" height="30" src="{{asset('images/logo-login%402x.png')}}" /></a>
            <form>
                <div class="form-group">
                    <input class="form-control" placeholder="Username or Email" type="text" name="username">
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Password" type="password" name="password">
                    {{--<input type="submit" value="&#xf054;">--}}
                </div>
                <div class="form-options clearfix">
                    <a class="pull-right" href="#">Forgot password?</a>
                    <div class="text-left">
                        <label class="checkbox"><input type="checkbox"><span>Remember me</span></label>
                    </div>
                </div>
            </form>
            <div class="social-login">
                <a class="btn btn-primary pull-left facebook" onclick="_login();">
                    <i class="glyphicon glyphicon-ok"></i></a>
            </div>
            <p class="signup">
                Don't have an account yet? <a href="{{url('member/register')}}">Sign up now</a>
            </p>
        </div>
    </div>
    </div>
@stop

@section('script')
    <script type="text/javascript">
        function _login() {
            var username = $('input[name=username]').val();
            var password = $('input[name=password]').val();
            var agree = $('input[name=agree]').attr('checked');
            $.ajax({
                url:"{{url('service/login')}}",
                dataType:'json',
                type:'POST',
                cache:false,
                data:{username:username,password:password,_token:"{{csrf_token()}}"},
                success:function (data) {
                    console.log('登录返回结果:');
                    console.log(data);
                    if (data == null){
                        swal("登录失败", "服务器错误", "error");
                        return;
                    }
                    if (data.status != 0){
                        swal("登录失败", data.message, "error");
                        return;
                    }
                    swal({title:"登录成功!",text: "用户:【" + username + "】已登录成功!", type:"success" }, function(){
                        location.href = "{{url('member/home')}}";
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
@stop