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
                                    <div class="animated flipInY col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="tile-stats">
                                            <div class="icon"><i class="fa fa-home"></i></div>
                                            <div class="count">{{ auth()->user()->count_groups() }}</div>
                                            <h3>Groups</h3>
                                            <p>Registered Groups</p>
                                        </div>
                                    </div>
                                    <div class="animated flipInY col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="tile-stats">
                                            <div class="icon"><i class="fa fa-users"></i></div>
                                            <div class="count">{{ auth()->user()->count_users_in_a_group() }}</div>
                                            <h3>Users</h3>
                                            <p>Groups With Users</p>
                                        </div>
                                    </div>
                                    <div class="animated flipInY col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="tile-stats">
                                            <div class="icon"><i class="fa fa-phone"></i></div>
                                            <div class="count">2</div>
                                            <h3>Contacts</h3>
                                            <p>Total Contacts Registered</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Setupform-->
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
