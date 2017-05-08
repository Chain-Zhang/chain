@extends('component.memlayout')

@section('content')
    <div class="container" style="margin-top: 50px">
        <div class="page-header">
            <h3>添加博客</h3>
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
                        <textarea class="form-control" rows="3" name="summary">
                            {{$article->summary}}
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">内容</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="blogContent" placeholder="Content" rows="15" name="content">
                            {{$article->content}}
                        </textarea>
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
    <script src="{{asset('js/kindeditor-min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    
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
    
    $(function(){
        var editor = KindEditor.create("#blogContent", {
            uploadJson: "/upload",
            fileManagerJson: "/board/keditor/filemanager",
            allowFileManager: true,
            filterMode : false,
            afterBlur: function(){this.sync();}
        });
    })

    function _addArticle() {
        var id = $('input[name=id]').val();
        var title = $('input[name=title]').val();
        var keywords = $('input[name=keywords]').val();
        var summary = $('textarea[name=summary]').val();
        var content = $('textarea[name=content]').val();
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