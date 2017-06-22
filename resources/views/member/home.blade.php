@extends('component.memlayout')

@section('content')
    <div >
        <div class="page-header">
            <h2>Dashboard</h2>
        </div>
        <div class="panel-body">
            <div class="row placeholders">
                <div class="col-xs-6 col-sm-4 placeholder">
                    <canvas id="today"  width="300" height="300"></canvas>
                    <h4>今日访问</h4>
                </div>
                <div class="col-xs-6 col-sm-4 placeholder">
                    <canvas id="week" width="300" height="300" ></canvas>
                    <h4>周访问</h4>
                </div>
                <div class="col-xs-6 col-sm-4 placeholder">
                    <canvas id="month" width="300" height="300"></canvas>
                    <h4>月访问</h4>
                </div>
            </div>
            <div class="page-header">
                <h3>
                    近7日访问统计
                </h3>
            </div>
            <div class="panel-body">
                <canvas height="300" width="800" id="seven"></canvas>
            </div>
            <h2 class="sub-header">Hot Blog Top 10</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>标题</th>
                        <th>评论次数</th>
                        <th>阅读次数</th>
                        <th>创建日期</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles_top10 as $article)
                        <tr>
                            <td>{{$article->title}}</td>
                            <td>{{$article->comment_count}}</td>
                            <td>{{$article->read_count}}</td>
                            <td>{{$article->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="{{asset('js/Chart.bundle.js')}}"></script>
    <script src="{{asset('js/Chart.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script type="text/javascript">
        $.get('get_chart_data',function (data, status) {
            console.log(data);
            console.log(status);
            var today = document.getElementById("today").getContext("2d");
            var todayChart = new Chart(today,{
                type: 'pie',
                data: {
                    labels: [
                        "首页文章列表",
                        "分类文章列表",
                        "关于我",
                        "文章详情"
                    ],
                    datasets: [{
                        data: data.today_data,
                        backgroundColor: [
                            window.chartColors.red,
                            window.chartColors.orange,
                            window.chartColors.purple,
                            window.chartColors.green,
                        ],
                    }]
                },
                options: {
                    responsive: true,
                }
            });

            var week = document.getElementById("week").getContext("2d");
            var weekChart = new Chart(week,{
                type: 'doughnut',
                data: {
                    labels: [
                        "首页文章列表",
                        "分类文章列表",
                        "关于我",
                        "文章详情"
                    ],
                    datasets: [{
                        data: data.week_data,
                        backgroundColor: [
                            window.chartColors.red,
                            window.chartColors.orange,
                            window.chartColors.purple,
                            window.chartColors.green,
                        ],
                    }]
                },
                options: {
                    responsive: true,
                }
            });

            var month = document.getElementById("month");
            var color = Chart.helpers.color;
            var monthChart = Chart.PolarArea(month,{
                type: 'pie',
                data: {
                    labels: [
                        "首页文章列表",
                        "分类文章列表",
                        "关于我",
                        "文章详情"
                    ],
                    datasets: [{
                        data: data.month_data,
                        backgroundColor: [
                            color(window.chartColors.red).alpha(0.5).rgbString(),
                            color(window.chartColors.orange).alpha(0.5).rgbString(),
                            color(window.chartColors.purple).alpha(0.5).rgbString(),
                            color(window.chartColors.green).alpha(0.5).rgbString()
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    scale: {
                        ticks: {
                            beginAtZero: true
                        },
                        reverse: false
                    },
                    animation: {
                        animateRotate: false,
                        animateScale: true
                    }
                }
            });

            var seven = document.getElementById("seven").getContext("2d")
            var sevenChart = new Chart(seven,{
                type: 'line',
                data: {
                    labels: data.seven_labels,
                    datasets: [{
                        label: "7日访问线",
                        data: data.seven_data,
                        backgroundColor: window.chartColors.red,
                        borderColor: window.chartColors.red,
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: '日期'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: '访问次数'
                            }
                        }]
                    }
                }
            });
        });

    </script>
@stop