
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('css/blog.css')}}" rel="stylesheet">
    @yield('style')
</head>

<body>
<div class="container">

    <div class="blog-header">
        <h1 class="blog-title">Chain's Blog</h1>
        <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p>
    </div>

    <div class="row">
        @section('main')

        @show
        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
            <div class="sidebar-module sidebar-module-inset">
                <h4>About</h4>
                <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
            </div>
            <div class="sidebar-module sidebar-module-inset ">
                <h4>分类</h4>
                <ol class="list-unstyled">
                    @foreach($categories as $category)
                        <li><a href="{{url('blog/category', ['id'=>$category->id])}}">{{$category->name}}</a></li>
                    @endforeach
                </ol>
            </div>

            {{--<div class="sidebar-module sidebar-module-inset">--}}
                {{--<h4>Elsewhere</h4>--}}
                {{--<ol class="list-unstyled">--}}
                    {{--<li><a href="#">GitHub</a></li>--}}
                    {{--<li><a href="#">Twitter</a></li>--}}
                    {{--<li><a href="#">Facebook</a></li>--}}
                {{--</ol>--}}
            {{--</div>--}}
        </div><!-- /.blog-sidebar -->

    </div><!-- /.row -->

</div><!-- /.container -->

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
@yield('script')
</body>
</html>
