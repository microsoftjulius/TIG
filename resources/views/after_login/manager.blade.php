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
                    <div class="row pull right">
                        <div class="col-lg-12">
                            <div class="">
                                <div class="row top_tiles">
                                    <div class="animated flipInY col-lg-4 col-md-4 col-sm-4 col-xs-12">

                                    </div>
                                    <div class="animated flipInY col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group row col-lg-12">
                                            <label for="churchName" class="col-sm-6 col-form-label">Enter Group Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="church_name" placeholder="enter group name"required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="animated flipInY col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--table -->
                <div class="row">
                    <div class="text-center">
                      <p><h3>List of Contacts Churches</h3></p>
                    </div>
                        <div class="col-lg-12">
                            <section class="box col-lg-12 col-sm-12 col-md-12 mt-3">
                                <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="th-sm">Group Name
                                        </th>
                                        <th class="th-sm">No. of Contacts
                                        </th>
                                        <th class="th-sm">Description
                                        </th>
                                        <th class="th-sm">Contacts
                                        </th>
                                        <th class="th-sm">Options
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>St Augustine</td>
                                    <td>2</td>
                                    <td>Caters all christians</td>
                                    <td>0775401793</td>
                                    <td>Details</td>
                                </tr>
                                <tr>
                                <td>St Francis</td>
                                    <td>2</td>
                                    <td>Caters all christians</td>
                                    <td>0775401793</td>
                                    <td>Delete</td>
                                </tr>
                                <tr>
                                <td>St Paul</td>
                                    <td>2</td>
                                    <td>Caters all christians</td>
                                    <td>0775401793</td>
                                    <td>Edit</td>
                                </tr>
                                </tbody>
                                </table>
                            </section>
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
