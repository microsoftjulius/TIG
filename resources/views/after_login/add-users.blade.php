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
                    <!--Setupform-->
                    <form class="col-md-offset-3 col-sm-6" style="border-width: 4px 4px 4px 4px; padding :1em; background-color:white;" action="/adds-user" method="POST">
                        @csrf
                        @include('layouts.message')
                    <div class="panel-heading text-center"><h4>Please add user</h4>
                    <hr>
                    </div>
                            <div class="form-group row md-form">
                                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">First name</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" name="first_name" id="materialFormCardNameEx" placeholder="Enter Your First Name" value="{{ old('first_name')}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabel" class="col-sm-2 col-form-label">Last name</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="colFormLabel" name="last_name" placeholder="Enter Your Last Name" value="{{ old('last_name')}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Username / Phone number</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control form-control-lg" name="username" id="colFormLabelLg" value="{{old('username')}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Password</label>
                                <div class="col-sm-10">
                                <input type="password" class="form-control form-control-lg" name="password" id="colFormLabelLg" placeholder="xxxxxxxxxxxxxxx" value="{{old('password')}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="text-center py-4 mt-3 ">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                <a href="/user"><button type="button" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</i></button></a>
                                </div>
                            </div>
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
    </body>
</html>
