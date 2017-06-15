
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
        <p class="blog-post-meta">{{$article->created_at}}</p>
    </div>
    <div id="content" class="panel-body">
        {!! $article->content !!}
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
</body>
</html>
