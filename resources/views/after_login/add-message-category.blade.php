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
                    <form class=" col-sm-12" style="border-width: 4px 4px 4px 4px; padding :4em; background-color:white;" action="/add-message-categories" method="get">
                        @csrf
                        @include('layouts.message')
                    <div class="panel-heading text-center"><h4>Please Enter The Message Category</h4>
                    <hr>
                    </div>
                            <div class="form-group row md-form"> 
                                    <div class="col-md-6">
                                            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Message category</label>
                                            <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" name="category" id="materialFormCardNameEx" placeholder="message category" autocomplete="off" required value="{{ old('category')}}">
                                            </div>
                                    </div>
                            </div> 
                            <div class="form-group row">
                                <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                <a href="/message-categories"><button type="button" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</i></button></a>
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