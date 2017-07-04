@extends('component.bloglayout')

@section('title')
    Chain Blog
@stop

@section('style')
    <link href="{{asset('css/sweetalert.css')}}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/font-awesome.css')}}" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('editormd/editormd.min.css')}}">
@stop
@section('content')
<div class="container blog-main" style="margin-top: 50px">
    <ol class="breadcrumb">
        <li class="blog-nav"><a href="{{url('blog')}}">首页</a></li>
        <li class="blog-nav"><a href="{{url('blog/category', ['id' => $article->category_id])}}">{{$article->category_name}}</a></li>
    </ol>
    <div class="page-header">
        <h2 class="blog-post-title">{{$article->title}}</h2>
        <p class="blog-post-meta">{{$article->created_at}} &nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open">({{$article->read_count}})</span> </p>
    </div>
    <div id="content" class="panel-body">
        <div id="show_editor">
            <textarea style="display: none">{{$article->content}}</textarea>
        </div>
    </div>
    <div>
        <div class="page-header">
           <h3>留言({{count($comments)}}条)</h3>
        </div>
        <div class="panel-body">
            @foreach($comments as $comment)
                <dl style="padding: 20px">
                    <dt>{{$comment->nickname}} 说: </dt>
                    <dd>
                        <div class="comment"
                             id="{{'md'.$comment->id}}">
                            <textarea style="display: none">{{$comment->content}}</textarea>
                        </div>
                    </dd>
                    <footer>
                        <div class="comment-footer" style="font-size: 12px; text-align: right;color: #bbb;border-bottom: 1px solid #e5e5e5;">
                            <p>{{$comment->created_at}}</p>
                        </div>
                    </footer>
                </dl>
            @endforeach
        </div>
    </div>
    <div>
        <div class="page-header">
            <h3>我要留言</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" id="comment-form" method="post">
                <input name="article_id" type="hidden" value="{{$article->id}}">
                <div class="form-group">
                    <label for="content">您的留言(支持markdown语法)</label>
                    <textarea name="content" rows="5" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label lass="control-label" for="nickname">昵称:</label>
                    <input type="text" name="nickname" class="form-control" {{empty($tourist->nickname) ? '' : 'readonly'}}
                           value="{{empty($tourist->nickname) ? '' : $tourist->nickname}}" style="width: 300px">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="发表">
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('script')
<script src="{{asset('js/jquery.validate.js')}}" type="text/javascript"></script>
<script src="{{asset('js/sweetalert.min.js')}}" type="text/javascript"></script>

    <script src="{{asset('editormd/editormd.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('editormd/lib/marked.min.js')}}"></script>
    <script src="{{asset('editormd/lib/prettify.min.js')}}"></script>

    <script src="{{asset('editormd/lib/raphael.min.js')}}"></script>
    <script src="{{asset('editormd/lib/underscore.min.js')}}"></script>
    <script src="{{asset('editormd/lib/sequence-diagram.min.js')}}"></script>
    <script src="{{asset('editormd/lib/flowchart.min.js')}}"></script>
    <script src="{{asset('editormd/lib/jquery.flowchart.min.js')}}"></script>
    <script type="text/javascript">
        $(function() {
            var testEditormdView;
            testEditormdView = editormd.markdownToHTML("show_editor", {
                htmlDecode      : "style,script,iframe",  // you can filter tags decode
                emoji           : true,
                taskList        : true,
                tex             : true,  // 默认不解析
                flowChart       : true,  // 默认不解析
                sequenceDiagram : true,  // 默认不解析
            });

            $(".comment").each(function () {
                var editor = editormd.markdownToHTML(this.id, {
                    htmlDecode      : "style,script,iframe",  // you can filter tags decode
                    emoji           : true,
                    taskList        : true,
                    tex             : true,  // 默认不解析
                    flowChart       : true,  // 默认不解析
                    sequenceDiagram : true,  // 默认不解析
                });
            })
        });

        $(function () {
            $('#comment-form').validate({
                rules:{
                    nickname:{
                        required:true
                    },
                    content:{
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
                    _addComment();
                }
            });
        });

        function _addComment() {
            var article_id = $('input[name=article_id]').val();
            var nickname = $('input[name=nickname]').val();
            var content = $('textarea[name=content]').val();
            console.log(article_id);
            console.log(nickname);
            console.log(content);
            $.ajax({
                url:"{{url('service/add_comment')}}",
                dataType:'json',
                type:'POST',
                cache:false,
                data:{
                    article_id:article_id,
                    nickname:nickname,
                    content:content,
                    _token:"{{csrf_token()}}"
                },
                success:function (data) {
                    console.log('新增留言返回结果:');
                    console.log(data);
                    if (data == null){
                        swal("评论失败", "服务器错误", "error");
                        return;
                    }
                    if (data.status != 0){
                        swal("评论失败", data.message, "error");
                        return;
                    }
                    swal({title:"评论成功!",text: "您的留言已发布成功!", type:"success" }, function(){
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
