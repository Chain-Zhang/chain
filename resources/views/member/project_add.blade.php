@extends("component.memlayout")

@section('content')
    <div class="page-header">
        <h3>新增项目资料</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" id="project-form">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="name">项目名称:</label>
                <div class="col-sm-4">
                    <input class="form-control"  name="name" type="text" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pro_date">项目时间:</label>
                <div class="col-sm-4">
                    <input class="form-control"  name="pro_date" type="text" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="source">源码地址:</label>
                <div class="col-sm-4">
                    <input class="form-control" name="source" type="text" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pro_url">项目地址:</label>
                <div class="col-sm-4">
                    <input class="form-control" name="pro_url" type="text" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="icon">icon:</label>
                <div class="col-sm-4">
                    <input class="form-control" name="icon" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="tags">tags:</label>
                <div class="col-sm-4">
                    <input class="form-control" name="tags" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="picture">项目截图:</label>
                <div class="col-sm-4">
                    <input class="form-control" name="picture" type="text">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="desc">简介:</label>
                <div class="col-sm-8">
                    <textarea class="form-control" rows="6" name="desc"></textarea>
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
            $('#project-form').validate({
                submitHandler : function(form) {
                    var name = $('input[name=name]').val();
                    var pro_date = $('input[name=pro_date]').val();
                    var source = $('input[name=source]').val();
                    var pro_url = $('input[name=pro_url]').val();
                    var icon = $('input[name=icon]').val();
                    var picture = $('input[name=picture]').val();
                    var tags = $('input[name=tags]').val();
                    var desc = $('textarea[name=desc]').val();
                    $.ajax({
                        url: "{{url('service/add_project')}}",
                        dataType: 'json',
                        type: 'POST',
                        cache: false,
                        data: {
                            name: name,
                            pro_date: pro_date,
                            source: source,
                            pro_url: pro_url,
                            icon: icon,
                            picture: picture,
                            tags: tags,
                            desc: desc,
                            _token: "{{csrf_token()}}"
                        },
                        success: function (data) {
                            console.log('新增项目返回结果:');
                            console.log(data);
                            if (data == null) {
                                swal("新增项目失败", "服务器错误", "error");
                                return;
                            }
                            if (data.status != 0) {
                                swal("新增项目失败", data.message, "error");
                                return;
                            }
                            swal({title: "新增项目成功!", text: "您新增的项目已经成功!", type: "success"}, function () {
                                location.href = "{{url('member/project_list')}}";
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