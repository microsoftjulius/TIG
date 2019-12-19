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
                <div class="row">
                <form  class="pull-right" action="/" method="">
                        @csrf
                        <div class="col-md-12">
                        <div class="col-md-4">
                                <div class="input-group">
                                @include('layouts.breadcrumbs')
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
                                <a href="/addnewsubscription"><button type="button" class="btn btn-primary"><i class="fa fa-plus"> New subscription</i></button></a>
                                </div>
                            </div>
                        </div>
                    </form>
                        </div>
                    <!--Table-->
                <div class="row">
                            <div class="col-lg-12">
                                <section class="box col-lg-12 col-sm-12 col-md-12 mt-3">
                                    <table id="dtBasicExample" class="table table-striped table-bordered table-sm bg-white" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="th-sm">No.</th>
                                                        <th class="th-sm">Category Name</th>
                                                        <th class="th-sm">Phone Number</th>
                                                        <th class="th-sm">Subscription Type</th>
                                                        <th class="th-sm">Time frame</th>
                                                        <th class="th-sm">Amount</th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                                    @if ($all_packages->currentPage() > 1)
                                                    @php($i =  1 + (($all_packages->currentPage() - 1) * $all_packages->perPage()))
                                                    @else
                                                    @php($i = 1)
                                                    @endif
                                                @foreach ($all_packages as $index => $package)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $package->title }}</td>
                                                    <td>{{ $package->contact_number }}</td>
                                                    <td>{{ $package->type }}</td>
                                                    <td>{{ $package->time_frame }}</td>
                                                    <td>{{ number_format($package->Amount) }} /=</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                    </table>
                                    @if(isset($search_query))
                                    {{ $all_packages->appends(['search' => $search_query])->links() }}
                                    @else
                                    {{ $all_packages->links() }}
                                    @endif
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
