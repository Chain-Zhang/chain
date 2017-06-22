@extends('component.memlayout')

@section('content')
    <div >
        <div class="page-header">
            <h3>Dashboard</h3>
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

            <h2 class="sub-header">Section title</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Header</th>
                        <th>Header</th>
                        <th>Header</th>
                        <th>Header</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1,001</td>
                        <td>Lorem</td>
                        <td>ipsum</td>
                        <td>dolor</td>
                        <td>sit</td>
                    </tr>
                    <tr>
                        <td>1,002</td>
                        <td>amet</td>
                        <td>consectetur</td>
                        <td>adipiscing</td>
                        <td>elit</td>
                    </tr>
                    <tr>
                        <td>1,003</td>
                        <td>Integer</td>
                        <td>nec</td>
                        <td>odio</td>
                        <td>Praesent</td>
                    </tr>
                    <tr>
                        <td>1,003</td>
                        <td>libero</td>
                        <td>Sed</td>
                        <td>cursus</td>
                        <td>ante</td>
                    </tr>
                    <tr>
                        <td>1,004</td>
                        <td>dapibus</td>
                        <td>diam</td>
                        <td>Sed</td>
                        <td>nisi</td>
                    </tr>
                    <tr>
                        <td>1,005</td>
                        <td>Nulla</td>
                        <td>quis</td>
                        <td>sem</td>
                        <td>at</td>
                    </tr>
                    <tr>
                        <td>1,006</td>
                        <td>nibh</td>
                        <td>elementum</td>
                        <td>imperdiet</td>
                        <td>Duis</td>
                    </tr>
                    <tr>
                        <td>1,007</td>
                        <td>sagittis</td>
                        <td>ipsum</td>
                        <td>Praesent</td>
                        <td>mauris</td>
                    </tr>
                    <tr>
                        <td>1,008</td>
                        <td>Fusce</td>
                        <td>nec</td>
                        <td>tellus</td>
                        <td>sed</td>
                    </tr>
                    <tr>
                        <td>1,009</td>
                        <td>augue</td>
                        <td>semper</td>
                        <td>porta</td>
                        <td>Mauris</td>
                    </tr>
                    <tr>
                        <td>1,010</td>
                        <td>massa</td>
                        <td>Vestibulum</td>
                        <td>lacinia</td>
                        <td>arcu</td>
                    </tr>
                    <tr>
                        <td>1,011</td>
                        <td>eget</td>
                        <td>nulla</td>
                        <td>Class</td>
                        <td>aptent</td>
                    </tr>
                    <tr>
                        <td>1,012</td>
                        <td>taciti</td>
                        <td>sociosqu</td>
                        <td>ad</td>
                        <td>litora</td>
                    </tr>
                    <tr>
                        <td>1,013</td>
                        <td>torquent</td>
                        <td>per</td>
                        <td>conubia</td>
                        <td>nostra</td>
                    </tr>
                    <tr>
                        <td>1,014</td>
                        <td>per</td>
                        <td>inceptos</td>
                        <td>himenaeos</td>
                        <td>Curabitur</td>
                    </tr>
                    <tr>
                        <td>1,015</td>
                        <td>sodales</td>
                        <td>ligula</td>
                        <td>in</td>
                        <td>libero</td>
                    </tr>
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
                    data: {{$today_data}},
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
                    data: {{$week_data}},
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
                    data: {{$month_data}},
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
    </script>
@stop