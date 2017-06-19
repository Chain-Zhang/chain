@extends('component.memlayout')

@section('title')
    登录
@stop

@section('style')
    <link href="{{asset('css/login.css')}}" media="all" rel="stylesheet" type="text/css" />
@stop
@section('header')
@stop
@section('main')
    <div class="container">
        <form class="form-signin">
            <h2 class="form-signin-heading">Chain Blog Admin</h2>
            <label for="username" class="sr-only">User Name</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Username or Email" required autofocus>
            <label for="password" class="sr-only">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
            <a class="btn btn-lg btn-primary btn-block" onclick="_login();">
            <i>Sign in</i></a>
        </form>
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