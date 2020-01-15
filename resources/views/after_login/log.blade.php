<!DOCTYPE html>
<html lang="en">
    @include('layouts.styling')
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <!-- sidebar menu -->
                        @include('layouts.sidebar')
                        <!-- /sidebar menu -->
                        <!-- /menu footer buttons -->
                        <div class="sidebar-footer hidden-small">
                            <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                        </div>
                        <!-- /menu footer buttons -->
                    </div>
                </div>
                <!-- top navigation -->
                @include('layouts.topnav')
                <!-- /top navigation -->
                <!-- page content -->
                <div class="right_col" role="main">
                @include('layouts.message')
                <!-- Search form -->
                @include('layouts.breadcrumbs')
                {{--<div class="row">
                <form  class="pull-right" action="/" method="">
                        @csrf
                        <div class="col-md-12">
                        <div class="col-md-4">
                                <div class="input-group">

                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="text" class="form-control col-md-12" placeholder="Search package" name="" id="srch-term" value="" required>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                <a href="/"><button type="button" class="btn btn-primary"><i class="fa fa-plus"> </i></button></a>
                                </div>
                            </div>

                        </div>
                    </form>
                        </div>
                        --}}
                    <!--Table-->
                <div class="row">
                            <div class="col-lg-12">
                                <section class="box col-lg-12 col-sm-12 col-md-12 mt-3">
                                    <table id="dtBasicExample" class="table table-striped table-bordered table-sm bg-white" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="th-sm">No.</th>
                                                        <th class="th-sm">Subscriber</th>
                                                        <th class="th-sm">Category Subscribed for</th>
                                                        <th class="th-sm">Amount Initiated</th>
                                                        <th class="th-sm">Payment Status</th>
                                                        <th class="th-sm">Subscription Date</th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                                    @if ($all_packages->currentPage() > 1)
                                                    @php($i =  (1 + (($all_packages->currentPage() - 1) * $all_packages->perPage())))
                                                    @else
                                                    @php($i = 1)
                                                    @endif
                                                @foreach ($all_packages as $index=>$packages)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $packages->message_from }}</td>
                                                    <td>{{ $packages->title}}</td>
                                                    <td>{{ number_format($packages->Amount)}} /=</td>
                                                    <td>{{ $packages->transaction_status}}</td>
                                                    <td>{{ $packages->created_at }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                    </table>
                                {{ $all_packages->links()}}
                                </section>
                                <!--link for pagination-->
                            </div>
                    </div>
                    <div class="row">
                    </div>
                </div>
                <!-- /page content -->
                <!-- footer content -->
                @include('layouts.footer')
                <!-- /footer content -->
            </div>
        </div>
        @include('layouts.javascript')
    </body>
</html>
