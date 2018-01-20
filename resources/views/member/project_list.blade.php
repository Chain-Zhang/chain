@extends('component.memlayout')
@section('title')
    Projects
@stop

@section('content')
    <div >
        <div class="page-header">
            <h3>我的项目列表</h3>
        </div>
        <div class="panel-body">
            <a href="{{url('member/project_add')}}" class="btn btn-primary"><li class="glyphicon glyphicon-plus"></li>新增</a>
            @if(count($projects) > 0)
                <table class="table">
                    <thead>
                    <tr>
                        <th>名称</th>
                        <th>源码</th>
                        <th>项目地址</th>
                        <th>项目时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($projects as $project)
                        <tr>
                            <td>{{$project->name}}</td>
                            <td>{{$project->source}}</td>
                            <td>{{$project->pro_url}}</td>
                            <td>{{$project->pro_date}}</td>
                            <td>
                                <a href="{{url('member/project_edit/'.$project->id)}}">
                                    <span ><li class="glyphicon glyphicon-pencil"></li></span>
                                </a>
                                |
                                @if($project->status == 2)
                                <a onclick="_enableProject('{{$project->id}}',1);"><span >
                                        <li class="glyphicon glyphicon-eye-close"></li>
                                    </span>
                                </a>
                                @else
                                    <a onclick="_enableProject('{{$project->id}}',2);"><span >
                                        <li class="glyphicon glyphicon-eye-open"></li>
                                    </span>
                                    </a>
                                @endif
                                |
                                <a onclick="_delProject({{$project->id}});"><span >
                                        <li class="glyphicon glyphicon-trash"></li>
                                    </span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <br>
                <br>
                <p>查无数据</p>
            @endif
        </div>
    </div>
@stop

@section('script')
    <script type="text/javascript">
        function _delProject(id) {
            swal({
                        title: "确定要删除该条记录吗?",
                        text: "",
                        type: "info",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true,
                    },
                    function(){
                        $.ajax({
                            url:"{{url('service/project_del')}}",
                            dataType:'json',
                            type:'POST',
                            cache:false,
                            data:{id:id,_token:"{{csrf_token()}}"},
                            success:function (data) {
                                console.log('删除返回结果:');
                                console.log(data);
                                if (data == null){
                                    swal("删除失败", "服务器错误", "error");
                                    return;
                                }
                                if (data.status != 0){
                                    swal("删除失败", data.message, "error");
                                    return;
                                }
                                swal({title:"删除成功!",text: "该条记录已删除成功!", type:"success" }, function(){
                                    location.reload();
                                });
                            },
                            error:function (xhr,status, error) {
                                console.log(xhr);
                                console.log(status);
                                console.log(error);
                            }
                        });
                    });
        }

        function _enableProject(id,status) {
            var tip
            if (status == 2){
                tip = "隐藏"
            }
            else {
                tip = "显示"
            }
            swal({
                        title: "确定要"+tip+"该条记录吗?",
                        text: "",
                        type: "info",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true,
                    },
                    function(inputValue){
                        $.ajax({
                            url:"{{url('service/project_enable')}}",
                            dataType:'json',
                            type:'POST',
                            cache:false,
                            data:{id:id,status:status,_token:"{{csrf_token()}}"},
                            success:function (data) {
                                console.log(tip+'返回结果:');
                                console.log(data);
                                if (data == null){
                                    swal(tip+"失败", "服务器错误", "error");
                                    return;
                                }
                                if (data.status != 0){
                                    swal(tip+"失败", data.message, "error");
                                    return;
                                }
                                swal({title:tip+"成功!",text: "该条记录已" + tip+",效果请看about me页面", type:"success" }, function(){
                                    location.reload();
                                });
                            },
                            error:function (xhr,status, error) {
                                console.log(xhr);
                                console.log(status);
                                console.log(error);
                            }
                        });
                    });
        }
    </script>
@stop