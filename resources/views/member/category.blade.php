@extends('component.memlayout')
@section('title')
category
@stop

@section('content')
    <div class="container" style="margin-top: 50px">
        <div class="page-header">
            <h3>分类管理</h3>
        </div>
        <div class="panel-body">
            <span onclick="_addCategory();" class="btn btn-primary"><li class="glyphicon glyphicon-plus"></li>新增</span>
            @if(count($categories) > 0)
                <table class="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Category Name</th>
                        <th>Operation</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td>
                                <a onclick="_modCategory('{{$category->id}}', '{{$category->name}}');">
                                    <span ><li class="glyphicon glyphicon-pencil"></li></span>
                                </a>
                                    |
                                <a onclick="_delCategory({{$category->id}});"><span >
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
    function _addCategory() {
        swal({
                    title: "Add new Category",
                    text: "please enter Category Name:",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputPlaceholder: "Category Name"
                },
                function(inputValue) {
                    if (inputValue === false) return false;

                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false;
                    }

                    $.ajax({
                        url:"{{url('service/add_category')}}",
                        dataType:'json',
                        type:'POST',
                        cache:false,
                        data:{name:inputValue,_token:"{{csrf_token()}}"},
                        success:function (data) {
                            console.log('添加返回结果:');
                            console.log(data);
                            if (data == null){
                                swal("添加失败", "服务器错误", "error");
                                return;
                            }
                            if (data.status != 0){
                                swal("添加失败", data.message, "error");
                                return;
                            }
                            swal({title:"添加成功!",text: "添加分类:【" + inputValue + "】成功!", type:"success" }, function(){
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

    function _delCategory(id) {
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
                        url:"{{url('service/del_category')}}",
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

    function _modCategory(id, name) {
        swal({
                    title: "Modify Category!",
                    text: "Please Input New Category Name:",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputPlaceholder: "Write something",
                    inputValue:name
                },
                function(inputValue){
                    if (inputValue === false) return false;

                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }

                    $.ajax({
                        url:"{{url('service/mod_category')}}",
                        dataType:'json',
                        type:'POST',
                        cache:false,
                        data:{id:id,name:inputValue,_token:"{{csrf_token()}}"},
                        success:function (data) {
                            console.log('修改返回结果:');
                            console.log(data);
                            if (data == null){
                                swal("修改失败", "服务器错误", "error");
                                return;
                            }
                            if (data.status != 0){
                                swal("修改失败", data.message, "error");
                                return;
                            }
                            swal({title:"修改成功!",text: "分类名称【" + name + "】已成功修改为【" + inputValue + "】", type:"success" }, function(){
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