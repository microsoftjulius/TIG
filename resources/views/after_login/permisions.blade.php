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
                        @include('layouts.message')
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
                    <form @foreach ($roles as $role) action="/assign-role/{{$role->id}}" @endforeach method="get">
                        <div class="row">
                            <div class="col-lg-6">
                                <section class="box col-lg-12 col-sm-12 col-md-12 mt-3">
                                    <table id="dtBasicExample" class="table table-striped table-bordered table-sm bg-white" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="th-sm"></th>
                                                <th class="th-sm">Members Role Title</th>
                                                {{-- <th class="th-sm">Number Of Permissions</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $role)
                                            <tr>
                                                <td><input type="radio" name="role_id" value="{{$role->id}}"></td>
                                                <td>{{$role->role_name}}</td>
                                                {{-- <td>{{$role->countRoles}}</td> --}}
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if(in_array('Can add a role',auth()->user()->getUserPermisions()))
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addrole"><i class="fa fa-plus"></i> Add Role</button>
                                    @endif
                                </section>
                                <!--link for pagination-->
                            </div>
                            <div class="col-lg-6">
                                <section class="box col-lg-12 col-sm-12 col-md-12 mt-3">
                                    <table id="dtBasicExample" class="table table-striped table-bordered table-sm bg-white" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="th-sm"></th>
                                                <th class="th-sm">Permission</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            @foreach ($permissions as $permission)
                                            <tr>
                                                <th class="th-sm"><input type="checkbox" name="user_permisions[]" value="{{$permission->id}}"></th>
                                                <th class="th-sm">{{$permission->permission_description}}</th>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        
                                    </table>
                                    {{ $permissions->links()}}
                                </section>
                                <!--link for pagination-->
                            </div>
                        </div>
                        <input type="submit" value="save" class="btn btn-primary pull-right">
                    </form>
                    <div class="row">
                    </div>
                </div>
                <!-- Modal -->
                <form action="/add-new-role" method="get">
                    @csrf
                <div class="modal fade" id="addrole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add new Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <input type="text" name="role" class="form-control" autocomplete="off">
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="container">
                    <!-- Trigger the modal with a button -->
                    {{-- <button type="button" class="btn btn-info btn-lg" id="sample">Open Modal</button> --}}

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
        {{-- <script>
            $(document).ready(function () {
                setTimeout(function () {
                    $("#myModal").modal('show')
                }, 3000);
            });
        </script> --}}
    </body>
</html>