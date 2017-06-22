@extends("component.memlayout")

@section('content')
    <div class="page-header">
        <h3>修改我的资料</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" id="profile-form">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="username">用户名:</label>
                <div class="col-sm-4">
                    <input readonly class="form-control"  name="username" type="text" value="{{$user->username}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="nickname">昵称:</label>
                <div class="col-sm-4">
                    <input class="form-control" name="nickname" type="text" value="{{$user_profile->nickname}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="realname">真实姓名:</label>
                <div class="col-sm-4">
                    <input class="form-control" name="realname" type="text" value="{{$user_profile->realname}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="email">邮箱:</label>
                <div class="col-sm-4">
                    <input class="form-control" name="email" type="email" value="{{$user_profile->email}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="qq_number">QQ号:</label>
                <div class="col-sm-4">
                    <input class="form-control" name="qq_number" type="text" value="{{$user_profile->qq_number}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="phone_number">手机号:</label>
                <div class="col-sm-4">
                    <input class="form-control" name="phone_number" type="text" value="{{$user_profile->phone_number}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="intro">简介:</label>
                <div class="col-sm-8">
                    <textarea class="form-control" rows="6" name="intro">{{$user_profile->intro}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-3">
                    <input class="btn btn-primary" type="submit" value="保存">
                </div>
            </div>
        </form>
    </div>
@stop

@section('script')
    <script type="text/javascript">
        $(function () {
            $('#profile-form').validate({
                submitHandler : function(form) {
                    var nickname = $('input[name=nickname]').val();
                    var realname = $('input[name=realname]').val();
                    var email = $('input[name=email]').val();
                    var qq_number = $('input[name=qq_number]').val();
                    var phone_number = $('input[name=phone_number]').val();
                    var intro = $('textarea[name=intro]').val();
                    $.ajax({
                        url: "{{url('service/profile_edit')}}",
                        dataType: 'json',
                        type: 'POST',
                        cache: false,
                        data: {
                            nickname: nickname,
                            realname: realname,
                            email: email,
                            qq_number: qq_number,
                            phone_number: phone_number,
                            intro: intro,
                            _token: "{{csrf_token()}}"
                        },
                        success: function (data) {
                            console.log('更新个人资料返回结果:');
                            console.log(data);
                            if (data == null) {
                                swal("更新个人资料失败", "服务器错误", "error");
                                return;
                            }
                            if (data.status != 0) {
                                swal("更新个人资料失败", data.message, "error");
                                return;
                            }
                            swal({title: "更新个人资料成功!", text: "您的个人资料已经更新成功!", type: "success"}, function () {
                                location.href = "{{url('member/home')}}";
                            });
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>
@stop