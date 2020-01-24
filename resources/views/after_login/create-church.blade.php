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
                        
                    <form class="col-md-offset-3 col-sm-6" style="border: 1px solid black ;border-width: 4px 4px 4px 4px; padding :1em; border: ridge #ccc; background-color:white;" action="/create-groups" method="get" enctype="multipart/form-data">
                        @csrf
                        @include('layouts.message')
                    <div class="panel-heading text-center"><h4>Please enter the campaign details</h4></div>
                            <div class="form-group row md-form">
                                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Name</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" name="church_name" id="materialFormCardNameEx" placeholder="Enter group name" value="{{old('church_name')}}" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabel" class="col-sm-2 col-form-label">Database</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="colFormLabel" name="database_name" placeholder="Enter Database name" value = "{{old('database_name')}}" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">URL</label>
                                <div class="col-sm-10">
                                <input type="url" class="form-control form-control-lg" name="url" id="colFormLabelLg" placeholder="Enter Your url" value = "{{old('url')}}" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">DB Password</label>
                                <div class="col-sm-10">
                                <input type="password" class="form-control form-control-lg" name="password" id="colFormLabelLg" placeholder="xxxxxxxxxxxxxxx" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Hosted Number</label>
                                <div class="col-sm-10">
                                <input type="number" class="form-control form-control-lg" name="hosted_number" id="colFormLabelLg" placeholder="256*********" {{old('hosted_number')}} autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Logo</label>
                                <div class="col-sm-10">
                                <input type="file" class="form-control form-control-lg" name="logo" id="colFormLabelLg" placeholder="attach logo" accept="image/*">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="text-center py-4 mt-3 ">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                <a href="/groups"><button type="button" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</i></button></a>
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
