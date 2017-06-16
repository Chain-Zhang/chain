@extends('component.memlayout')
@section('style')
    <link rel="stylesheet" href="{{asset('editormd/editormd.min.css')}}">
@stop
@section('content')
    <div class="container" style="margin-top: 50px">
        <div class="page-header">
            <h3>修改博客</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" id="article-form" method="post">
                <input name="id" type="hidden" value="{{$article->id}}">
                <div class="form-group">
                    <label class="col-sm-2 control-label">标题</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="title" value="{{$article->title}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">概述</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="summary">{{$article->summary}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">内容</label>
                    <div class="col-sm-10">
                        <div id="editor_md">
                            <textarea style="display: none">{{$article->content}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">关键词</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="keywords" value="{{$article->keywords}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">分类</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="category_id">
                            @foreach($categories as $category)
                                @if($category->id == $article->category_id)
                                    <option value="{{$category->id}}" selected="selected">{{$category->name}}</option>
                                @else
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <label class="radio-inline col-sm-offset-1 col-sm-2">
                        <input type="radio" name="status" value="0"> 草稿
                    </label>
                    <label class="radio-inline col-sm-2">
                        <input type="radio" name="status" value="1"> 发布
                    </label>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" class="btn btn-primary" value="提交">
                    </div>

                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script src="{{asset('js/lrz.bundle.js')}}" type="text/javascript"></script>
    <script src="{{asset('editormd/editormd.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">

    var editor;
    $(function () {
        editor = editormd("editor_md",{
            width:"100%",
            height:600,
            syncScrolling:"single",
            path:"{{asset('/editormd/lib/')}}" + "/",
            tex:true,
            flowChart       : true,
            sequenceDiagram:true,
            saveHTMLToTextarea : true,
            imageUploadURL: "php/upload.php",
        });
    });

    $(function () {
       $('#article-form').validate({
            rules:{
                title:{
                    required:true
                },
                summary:{
                    required:true
                },
                content:{
                    required:true
                },
                category_id:{
                    required:true
                },
                status:{
                    required:true
                }
            },
           highlight : function(element) {
               $(element).closest('.form-group').addClass('has-error');
           },

           success : function(label) {
               label.closest('.form-group').removeClass('has-error');
               label.remove();
           },

           errorPlacement : function(error, element) {
               element.parent('div').append(error);
           },

           submitHandler : function(form) {
               _addArticle();
           }
       });
    });

    function paste(event) {
        var clipboardData = event.clipboardData;
        var items, item, types;
        if (clipboardData) {
            items = clipboardData.items;
            if (!items) {
                return;
            }
            // 保存在剪贴板中的数据类型
            types = clipboardData.types || [];
            for (var i = 0; i < types.length; i++) {
                if (types[i] === 'Files') {
                    item = items[i];
                    break;
                }
            }
            // 判断是否为图片数据
            if (item && item.kind === 'file' && item.type.match(/^image\//i)) {
                // 读取该图片
                var file = item.getAsFile(),
                        reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    //前端压缩
                    lrz(reader.result, {width: 1080}).then(function (res) {
                        $.ajax({
                            url: "{{asset('php-sdk/myapis/uploadImageToQiliu.php')}}",
                            type: 'post',
                            data: {
                                "image": res.base64,
                                "name": new Date().getTime() + ".png"
                            },
                            contentType: 'application/x-www-form-urlencoded;charest=UTF-8',
                            success: function (data) {
                                var imageName;
                                try {
                                    imageName = JSON.parse(data).key;
                                } catch (e) {
                                    alert(e.toString);
                                }

                                var qiniuUrl = '![](http://opgmvuzyu.bkt.clouddn.com/' + imageName + ')';

                                editor.insertValue(qiniuUrl);
                            }
                        })
                    });
                }
            }
        }
    }
    document.addEventListener('paste', function (event) {
        paste(event);
    })
    function _addArticle() {
        var id = $('input[name=id]').val();
        var title = $('input[name=title]').val();
        var keywords = $('input[name=keywords]').val();
        var summary = $('textarea[name=summary]').val();
        var content = editor.getMarkdown();
        var category_id = $('select[name=category_id]').val();
        var status = $('input[name=status]:checked').val();
        console.log(title);
        console.log(summary);
        console.log(content);
        console.log(category_id);
        console.log(status);
        $.ajax({
            url:"{{url('service/mod_article')}}",
            dataType:'json',
            type:'POST',
            cache:false,
            data:{
                id:id,
                title:title,
                keywords:keywords,
                summary:summary,
                content:content,
                category_id:category_id,
                status:status,
                _token:"{{csrf_token()}}"
            },
            success:function (data) {
                console.log('修改博客返回结果:');
                console.log(data);
                if (data == null){
                    swal("修改失败", "服务器错误", "error");
                    return;
                }
                if (data.status != 0){
                    swal("修改失败", data.message, "error");
                    return;
                }
                swal({title:"修改成功!",text: "博客【"+title+"】已修改成功!", type:"success" }, function(){
                    location.href = "{{url('member/article')}}";
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