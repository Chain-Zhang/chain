<div class="sidebar-module sidebar-module-inset">
    <h4>About</h4>
    <p><em>Chain</em> worked as a middle-level Software Engineer in Snmi. His major work was <em>PHP</em> development based on <em>Laravel</em> framework and <em>C#</em> development based on <em>Asp.Net MVC</em> framework.</p>
</div>
<div class="sidebar-module sidebar-module-inset ">
    <h4>分类</h4>
    <ol class="list-unstyled">
        @foreach($categories as $category)
            <li><a href="{{url('blog/category', ['id'=>$category->id])}}">{{$category->name}}</a></li>
        @endforeach
    </ol>
</div>