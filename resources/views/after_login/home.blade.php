<!DOCTYPE html>
<html lang="en">
    @include('layouts.styling')
    <link rel="stylesheet" href="{{asset('bootstrap/mdb/css/mdb.min.css')}}">
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <!-- sidebar menu -->
                        @include('layouts.sidebar')
                        <!-- /sidebar menu -->
                        <!-- /menu footer buttons -->
                        <!-- /menu footer buttons -->
                    </div>
                </div>
                <!-- top navigation -->
                @include('layouts.topnav')
                <!-- /top navigation -->
                <!-- page content -->
                <div class="right_col" role="main">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div class="input-group">
                            @include('layouts.breadcrumbs')
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="">
                                <div class="row top_tiles">
                                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="tile-stats">
                                            <h3>SMS LEFT</h3>
                                            <div class="count pull-right">{{ auth()->user()->getTotalSmsLeft() }}</div>
                                        </div>
                                    </div>
                                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="tile-stats">
                                            <h3>SCHEDULED SMS</h3>
                                            <div class="count pull-right">{{ auth()->user()->countScheduledMessages() }}</div>
                                        </div>
                                    </div>
                                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="tile-stats">
                                            <h3>AMOUNT</h3>
                                            <div class="count pull-right">{{ auth()->user()->getTotalAmountLeft()}} /=</div>
                                        </div>
                                    </div>
                                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="tile-stats">
                                            <h3>TOTAL CONTACTS</h3>
                                            <div class="count pull-right">{{ auth()->user()->countGroupsTotalContactsOfAChurch() + auth()->user()->countCategoriesTotalContactsOfAChurch() }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Setupform-->
                    
                    <div class="row">
                        <div class="col-lg-6 card-body">
                            <div id ="container"></div>
                        </div>
                        <div class="col-lg-6 card-body" style="width:540px; height:400px; background-color:white">
                            <h2 class="text-center" style="color:black">SMS SCHEDULING</h2>
                            <canvas id="doughnutChart"></canvas>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-12 card-body">
                            <canvas id="barChart" class="card"  style="background-color:white"></canvas>
                        </div>
                    </div>
                </div>
                <!-- /page content -->
                <!-- footer content -->
                @include('layouts.footer')
                <!-- /footer content -->
            </div>
        </div>
        @include('layouts.javascript')
        <script src="{{asset('bootstrap/mdb/js/mdb.min.js')}}"></script>
        <script>
            //doughnut
            var ctxD = document.getElementById("doughnutChart").getContext('2d');
            var myLineChart = new Chart(ctxD, {
            type: 'doughnut',
            data: {
            labels: ["SCHEDULED SMS", "FAILED SMS"],
            datasets: [{
            data: [{!! auth()->user()->countScheduledMessages() !!}, {!! auth()->user()->countFailedMessages() !!}],
            backgroundColor: ["#F7464A", "#46BFBD"],
            hoverBackgroundColor: ["#FF5A5E", "#5AD3D1"]
            }]
            },
            options: {
            responsive: true
            }
            });
            //bar
    var ctxB = document.getElementById("barChart").getContext('2d');
    var myBarChart = new Chart(ctxB, {
    type: 'bar',
    data: {
    labels: {!! json_encode(auth()->user()->getClientsRegisteredMonths()) !!},
    datasets: [{
    label: 'SUBSCRIBERS',
    data: [{!! auth()->user()->getSubscribersInJanuary() !!},{!! auth()->user()->getSubscribersInFebruary() !!},{!! auth()->user()->getSubscribersInMarch() !!},
            {!! auth()->user()->getSubscribersInApril() !!},{!! auth()->user()->getSubscribersInMay() !!},{!! auth()->user()->getSubscribersInJune() !!},{!! auth()->user()->getSubscribersInjuly() !!},{!! auth()->user()->getSubscribersInAugust() !!}
        ,{!! auth()->user()->getSubscribersInSeptember() !!},{!! auth()->user()->getSubscribersInOctober() !!},{!! auth()->user()->getSubscribersInNovember() !!},{!! auth()->user()->getSubscribersInDecember() !!}],
    backgroundColor: [
    'rgba(255, 99, 132, 0.2)',
    'rgba(54, 162, 235, 0.2)',
    'rgba(255, 206, 86, 0.2)',
    'rgba(75, 192, 192, 0.2)',
    'rgba(153, 102, 255, 0.2)',
    'rgba(255, 159, 64, 0.2)'
    ],
    borderColor: [
    'rgba(255,99,132,1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)'
    ],
    borderWidth: 1
    }]
    },
    options: {
    scales: {
    yAxes: [{
    ticks: {
    beginAtZero: true
    }
    }]
    }
    }
    });
        </script>
            <script language = "JavaScript">
                $(document).ready(function() {  
                var chart = {      
                    type: 'pie',     
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                };
                var title = {
                    text: 'PIE CHAT SHOWING MAXIMUM AND MINIMUM SUBSCRIBED CATEGORIES'   
                };   
                var tooltip = {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                };
                var plotOptions = {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}'
                        }
                    }
                };   
                var series = [{
                    type: 'pie',
                    name: 'Maximum and Minimum Subscribers',
                    data: [
                        ["{!! auth()->user()->getMaximumCategoryOfAChurch() !!}",  {!! auth()->user()->getMaximumsubscribersOfACategory()->count() !!}],
                        ["{!! auth()->user()->getMinimumCategoryOfAChurch() !!}",  {!! auth()->user()->getMinimumsubscribersOfACategory()->count() !!}],
                    ]
                }];     
                var json = {};   
                json.chart = chart; 
                json.title = title;       
                json.tooltip = tooltip; 
                json.plotOptions = plotOptions; 
                json.series = series;   
                $('#container').highcharts(json);
                });
            </script>
                <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
                </script>
                <script src = "https://code.highcharts.com/highcharts.js"></script>  
                <script src = "https://code.highcharts.com/highcharts-3d.js"></script>
    </body>
</html>
