
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="chain, 博客, 编程技术, 前端技术, 后端技术, 个人博客" />
    <meta name="description" content="chain的个人博客,记录个人的编程技术心得,和个人生活感悟。">
    <meta name="author" content="chain">
    <title>@yield('title')</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('css/blog.css')}}" rel="stylesheet">
    <link rel="icon" href="{{asset('images/logo.ico')}}" type="image/x-icon"/>
    @yield('style')
</head>

<body>
@section('content')
    <div class="container">

        <div class="blog-header">
            <h1 class="blog-title">Chain's Blog</h1>
            <p class="lead blog-description">Thoughts, stories and ideas.</p>
        </div>

        <div class="row">

            <div class="col-sm-9 blog-main">
            @section('main')

            @show
            </div>

            <div class="col-sm-3 blog-sidebar">
                @section('right_sider')

                @show
            </div>

        </div><!-- /.row -->

    </div><!-- /.container -->
@show
<footer class="blog-footer">
    @section('footer')
    <p>@Copyright 2017   Chain</p>
    <p>沪ICP备17023106号-1</p>
    @show
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://s13.cnzz.com/z_stat.php?id=1262950922&web_id=1262950922" language="JavaScript"></script>
@yield('script')
</body>
</html>
