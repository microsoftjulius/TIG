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

                        <!-- /menu footer buttons -->
                    </div>
                </div>
                <!-- top navigation -->
                @include('layouts.topnav')
                <!-- /top navigation -->
                <!-- page content -->
                <div class="right_col" role="main">
                    <!-- Search form -->
                    <div class="row">
                        <form id="packages"  class="pull-right" action="#" method="">
                            @csrf
                            <div class="col-md-12">
                                <div id="pageloader">
                                    <img src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="processing..." />
                                </div>
                                @include('layouts.message')
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
                                        <a href="/addnewsubscription"><button type="button" class="btn btn-primary"><i class="fa fa-plus"> New Package</i></button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--Table-->
                    <form action="/map-package-to-category" method="get">
                        <div class="row">
                            <div class="col-lg-6">
                                <section class="box col-lg-12 col-sm-12 col-md-12 mt-3">
                                    <table id="dtBasicExample" class="table table-striped table-bordered table-sm bg-white" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="th-sm"></th>
                                                <th class="th-sm">Package Name</th>
                                                <th class="th-sm">Time frame</th>
                                                <th class="th-sm">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($all_packages as $package)
                                            <tr>
                                                <td><input type="radio" name="package" value="{{$package->id}}"></td>
                                                <td>{{ $package->package_name }}</td>
                                                <td>{{ $package->time_frame }} days</td>
                                                <td>{{ number_format($package->Amount) }} /=</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </section>
                                <!--link for pagination-->
                            </div>
                            <div class="col-lg-6">
                                <section class="box col-lg-12 col-sm-12 col-md-12 mt-3">
                                    <table id="dtBasicExample" class="table table-striped table-bordered table-sm bg-white" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="th-sm"></th>
                                                <th class="th-sm">Category Name</th>
                                                <th class="th-sm">Number Of Subscribers</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($message_categories as $category)
                                            <tr>
                                                <td><input type="checkbox" name="category[]" value="{{$category->id}}"></td>
                                                <td>{{ $category->title }}</td>
                                                <td>{{ $category->number_of_subscribers}}</td>
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
                        <input type="submit" value="save" class="btn btn-primary pull-right">
                    </form>
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
        <script>
            $(document).ready(function(){
            $("#packages").on("submit", function(){
                $("#pageloader").fadeIn();
            });//submit
            });
        </script>
    </body>
</html>