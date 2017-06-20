@extends('component.memlayout')
@section('style')
    <link rel="stylesheet" href="{{asset('editormd/editormd.min.css')}}">
@stop
@section('content')
    <div>
        <div class="page-header">
            <h3>{{$article->title}}</h3>
        </div>
        <div id="content" class="panel-body">
            <div id="show_editor">
                <textarea style="display: none">{{$article->content}}</textarea>
            </div>
        </div>
    </div>
@stop

@section('script')
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
@stop