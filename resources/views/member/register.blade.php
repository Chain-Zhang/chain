@extends('component.memlayout')

@section('title')
    注册
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
            <a href="index.html"><img width="100" height="30" src="{{url('images/logo-login%402x.png')}}" /></a>
            <form method="post">
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Enter your email address" name="username">
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Select a password" type="password" name="password">
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Repeat your password" type="password" name="confirmpassword">

                </div>
                <div class="form-options">
                    <label class="checkbox">
                        <input type="checkbox" name="agree">
                        <span>I agree to the terms and conditions.</span>
                    </label>
                </div>
            </form>
            <div class="social-login clearfix">
                <a class="btn btn-primary pull-left" onclick="_signup();">
                    <i class="glyphicon glyphicon-ok"></i></a>
                <a class="btn btn-default pull-right" href="index-2.html" onclick="history.back(-1);">
                    <i class="glyphicon glyphicon-remove"></i></a>
            </div>
            <p class="signup">
                Already have an account? <a href="login1.html">Log in now</a>
            </p>
        </div>
    </div>
    </div>
@stop

@section('script')
<script type="text/javascript">
    function _signup() {
        var username = $('input[name=username]').val();
        var password = $('input[name=password]').val();
        var confirmpassword = $('input[name=confirmpassword]').val();
        var agree = $('input[name=agree]').attr('checked');
        $.ajax({
            url:"{{url('service/register')}}",
            dataType:'json',
            type:'POST',
            cache:false,
            data:{username:username,password:password,confirmpassword:confirmpassword,_token:"{{csrf_token()}}"},
            success:function (data) {
                console.log('注册返回结果:');
                console.log(data);
                if (data == null){
                    swal("注册失败", "服务器错误", "error");
                    return;
                }
                if (data.status != 0){
                    swal("注册失败", data.message, "error");
                    return;
                }
                swal({title:"注册成功!",text: "用户:【" + username + "】已注册成功!", type:"success" }, function(){
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
@stop