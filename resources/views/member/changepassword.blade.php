@extends('component.memlayout')

@section('content')
    <div class="page-header">
        <h3>修改密码</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" id="update_password_form">
            <div class="form-group">
                <label for="oldpw" class="control-label col-sm-4">旧密码:</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" name="oldpw" required="true">
                </div>
            </div>
            <div class="form-group">
                <label for="newpw" class="control-label col-sm-4">新密码:</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" name="newpw" required="true">
                </div>
            </div>
            <div class="form-group">
                <label for="confirmpw" class="control-label col-sm-4">确认密码:</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" name="confirmpw" required="true">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-4 ">
                    <input type="submit" class="btn btn-primary" value="确定">
                </div>
            </div>
        </form>
    </div>
@stop

@section('script')
<script type="text/javascript">
    $(function () {
        $('#update_password_form').validate({
            submitHandler : function(form) {
                var oldpw = $('input[name=oldpw]').val();
                var newpw = $('input[name=newpw]').val();
                var confirmpw = $('input[name=confirmpw]').val();
                $.ajax({
                    url: "{{url('service/password_change')}}",
                    dataType: 'json',
                    type: 'POST',
                    cache: false,
                    data: {
                        oldpw: oldpw,
                        newpw: newpw,
                        confirmpw: confirmpw,
                        _token: "{{csrf_token()}}"
                    },
                    success: function (data) {
                        console.log('修改密码返回结果:');
                        console.log(data);
                        if (data == null) {
                            swal("修改密码失败", "服务器错误", "error");
                            return;
                        }
                        if (data.status != 0) {
                            swal("修改密码失败", data.message, "error");
                            return;
                        }
                        swal({title: "修改密码成功!", text: "您的密码已修改成功!", type: "success"}, function () {
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
