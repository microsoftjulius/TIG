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
                    <!-- Search form -->
                    <!--Table-->
                    <form action="/map-package-to-category" method="get">
                        <div class="row">
                            <div class="col-lg-6">
                                <section class="box col-lg-12 col-sm-12 col-md-12 mt-3">
                                    <table id="dtBasicExample" class="table table-striped table-bordered table-sm bg-white" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="th-sm"></th>
                                                <th class="th-sm">Members Role Title</th>
                                                <th class="th-sm">Number Of People With the Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="radio" name="package" value="dsds"></td>
                                                <td>dsds</td>
                                                <td>dg</td>
                                            </tr>
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
                                                <th class="th-sm">Permisions </th>
                                                <th class="th-sm">Number Of People with this Permision</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <tr>
                                                <td><input type="checkbox" name="category[]" value="dsd"></td>
                                                <td>ddsd</td>
                                                <td>ds</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </section>
                                <!--link for pagination-->
                            </div>
                        </div>
                        <input type="submit" value="save" class="btn btn-primary pull-right">
                    </form>
                    <div class="row">
                    </div>
                </div>
                <div class="container">
                    <!-- Trigger the modal with a button -->
                    <button type="button" class="btn btn-info btn-lg" id="sample">Open Modal</button>

                    <!-- Modal -->
                    @include('layouts.notifications_modal')
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
        <script>
            $(document).ready(function () {
                setTimeout(function () {
                    $("#myModal").modal('show')
                }, 3000);
            });
        </script>
    </body>
</html>