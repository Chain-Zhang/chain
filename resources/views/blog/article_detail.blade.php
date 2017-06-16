
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Chain Blog</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('css/blog.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('editormd/editormd.min.css')}}">
    <link rel="icon" href="{{asset('images/logo.ico')}}" type="image/x-icon"/>
    @yield('style')
</head>

<body>
<div class="container blog-main" style="margin-top: 50px">
    <ol class="breadcrumb">
        <li><a href="{{url('blog')}}">首页</a></li>
        <li><a href="{{url('blog/category', ['id' => $article->category_id])}}">{{$article->category_name}}</a></li>
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
</div>

<footer class="blog-footer">
        <p>@Copyright 2017   Chain</p>
        <p>沪ICP备17023106号-1</p>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
        });
    </script>
</body>
</html>
