@extends('component.memlayout')

@section('style')
    <style>
        section{margin:0 auto;}
       input:focus{outline-width:0}
        h2{position:relative;}
        span.todolist{position:absolute;top:2px;right:5px;display:inline-block;padding:0 5px;height:20px;border-radius:20px;background:#E6E6FA;line-height:22px;text-align:center;color:#666;font-size:14px;}
        #todolist,#donelist{padding:0;list-style:none;}
        #todolist li input{position:absolute;top:2px;left:10px;width:22px;height:22px;cursor:pointer;}
        #donelist li input{position:absolute;top:2px;left:10px;width:22px;height:22px;cursor:pointer;}
        p{margin: 0;}
        #todolist li p input{top:3px;left:40px;width:70%;height:20px;line-height:14px;text-indent:5px;font-size:14px;}
        #donelist li p input{top:3px;left:40px;width:70%;height:20px;line-height:14px;text-indent:5px;font-size:14px;}
        #donelist li{height:32px;line-height:32px;background: #fff;position:relative;margin-bottom: 10px;
            padding:0 45px;border-radius:3px;border-left: 5px solid #629A9C;box-shadow: 0 1px 2px rgba(0,0,0,0.07);}
        #todolist li{height:32px;line-height:32px;background: #fff;position:relative;margin-bottom: 10px;
            padding:0 45px;border-radius:3px;border-left: 5px solid #629A9C;box-shadow: 0 1px 2px rgba(0,0,0,0.07);}
        #todolist li{cursor:move;}
        #donelist li{border-left: 5px solid #999;opacity: 0.5;}
        #donelist li a{position:absolute;top:2px;right:5px;display:inline-block;width:14px;height:12px;border-radius:14px;border:6px double #FFF;background:#CCC;line-height:14px;text-align:center;color:#FFF;font-weight:bold;font-size:14px;cursor:pointer;}
        #todolist li a{position:absolute;top:2px;right:5px;display:inline-block;width:14px;height:12px;border-radius:14px;border:6px double #FFF;background:#CCC;line-height:14px;text-align:center;color:#FFF;font-weight:bold;font-size:14px;cursor:pointer;}
    </style>
@stop

@section('content')
    <div class="container" style="margin-top: 50px">
        <div class="page-header">
            <h3>My To Do List</h3>
        </div>
        <div id="content" class="panel-body" >
            <div style="width: 500px; margin: 0 auto">
                <div class="form-horizontal">
                    <div class="form-group form-horizontal">
                        <label class="control-label col-sm-3">To do list</label>
                        <div class="col-sm-9">
                            <input name="title" id="title" class="form-control" type="text">
                        </div>
                    </div>
                </div>
                <section>
                    <h2 >正在进行 <span class="todolist" id="todocount">{{$todocount}}</span></h2>
                    <ol id="todolist" class="demo-box">
                        {!! $todolistHtml !!}
                    </ol>
                    <h2>已经完成 <span class="todolist" id="donecount">{{$donecount}}</span></h2>
                    <ul id="donelist">
                        {!! $donelistHtml !!}
                    </ul>
                </section>

                <span class="btn btn-primary pull-right">生成timeline</span>
            </div>

        </div>
    </div>
@stop

@section('script')
<script type="text/javascript">

    function _onchanged(id) {
        console.log(id);

        $.ajax({
            url:"{{url('service/finish_todolist')}}",
            dataType:'json',
            type:'POST',
            cache:false,
            data:{
                id:id,
                _token:"{{csrf_token()}}"
            },
            success:function (data) {
                console.log('完成返回结果:');
                console.log(data);
                if (data == null){
                    swal("完成失败", "服务器错误", "error");
                    return;
                }
                if (data.status != 0){
                    swal("完成失败", data.message, "error");
                    return;
                }
                $('#donelist').html(data.donelistHtml);
                $('#donecount').html(data.donecount);
                $('#todolist').html(data.todolistHtml);
                $('#todocount').html(data.todocount);
            },
            error:function (xhr,status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });
    }

    $(document).ready(function(){
        $('#title').keydown(function (e) {
            if (e.keyCode == 13){
                var content = $('#title').val();
                if (content != '') {
                    $.ajax({
                        url:"{{url('service/add_todolist')}}",
                        dataType:'json',
                        type:'POST',
                        cache:false,
                        data:{
                            content:content,
                            _token:"{{csrf_token()}}"
                        },
                        success:function (data) {
                            console.log('新增博客返回结果:');
                            console.log(data);
                            if (data == null){
                                swal("新增失败", "服务器错误", "error");
                                return;
                            }
                            if (data.status != 0){
                                swal("新增失败", data.message, "error");
                                return;
                            }
                            $('#todolist').html(data.todolistHtml);
                            $('#todocount').html(data.todocount);
                            $('#title').val('');
                        },
                        error:function (xhr,status, error) {
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                        }
                    });

                }
            }
        });
    });

</script>
@stop