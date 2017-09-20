@extends('component.memlayout')

@section('content')
    <div >
        <div class="page-header">
            <h3>博客列表</h3>
        </div>
        <div class="panel-body">
            <a class="btn btn-primary" href="{{url('member/article/add')}}"><span> <li class="glyphicon glyphicon-plus"></li>新增</span></a>
            @if(count($articles) > 0)
                <table class="table">
                    <thead>
                    <tr>
                        <th width="40%">标题</th>
                        <th>分类</th>
                        <th>阅读次数</th>
                        <th>评论次数</th>
                        <th>状态</th>
                        <th>创建日期</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td>{{$article->title}}</td>
                            <td>{{$article->category_name}}</td>
                            <td>{{$article->read_count}}</td>
                            <td>{{$article->comment_count}}</td>
                            <td>{{$article->getStatus()}}</td>
                            <td>{{$article->created_at}}</td>
                            <td>
                                <a href="{{url('member/article/detail', ['id'=>$article->id])}}" title="查看文章">
                                    <span>
                                        <li class="glyphicon glyphicon-list-alt"></li>
                                    </span>
                                </a>
                                |
                                <a href="{{url('member/article/edit', ['id'=>$article->id])}}" title="编辑文章">
                                    <span>
                                        <li class="glyphicon glyphicon-pencil"></li>
                                    </span>
                                </a>
                                |
                                <a onclick="_delArticle({{$article->id}});" title="删除文章">
                                    <span >
                                        <li class="glyphicon glyphicon-trash"></li>
                                    </span>
                                </a>
                                |
                                <a onclick="_pushToBaidu({{$article->id}});" title="推送到百度">
                                    <span >
                                        <li class="glyphicon glyphicon-hand-up"></li>
                                    </span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$articles->links()}}
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
        function _delArticle(id) {
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
                            url:"{{url('service/del_article')}}",
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

        function _pushToBaidu(id) {
                $.ajax({
                    url:"{{url('service/push_article')}}",
                    dataType:'json',
                    type:'POST',
                    cache:false,
                    data:{id:id,_token:"{{csrf_token()}}"},
                    success:function (data) {
                        console.log('推送返回结果:');
                        console.log(data);
                        if (data == null){
                            swal("推送失败", "服务器错误", "error");
                            return;
                        }
                        if (data.status != 0){
                            swal("推送失败", data.message, "error");
                            return;
                        }
                        swal({title:"推送成功!",text: data.message, type:"success" }, function(){
                            location.reload();
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