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
                            <form class="pull-right pt-4" role="search" action="/search-user" method="get" >
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
                                                        <input type="text" class="form-control col-md-12" placeholder="Search" name="search" id="srch-term" required>
                                                            <div class="input-group-btn">
                                                                <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i>
                                                                </button>
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                            @if(in_array('Can add users to church',auth()->user()->getUserPermisions()))
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                <a href="/addusers"><button type="button" class="btn btn-primary"><i class="fa fa-plus"> User</i></button></a>
                                                </div>
                                            </div>
                                            @endif
                                </div>
                            </form>
                        </div>
                    <!--Table-->
                <div class="row">
                            <div class="col-lg-12">
                                <section class="box col-lg-12 col-sm-12 col-md-12 mt-3">
                                        <table id="dtBasicExample" class="table table-striped table-bordered table-sm bg-white table-responsive" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="th-sm">Id</th>
                                                    <th class="th-sm">First name
                                                    </th>
                                                    <th class="th-sm">Last name
                                                    </th>
                                                    <th class="th-sm">Phone number / Username
                                                    </th>
                                                    <th class="th-sm">Date created</th>
                                                    {{-- <th class="th-sm">User Role</th> --}}
                                                </tr>
                                            </thead>
                                        <tbody>
                                                @if ($display_all_church_users->currentPage() > 1)
                                                @php($i =  1 + (($display_all_church_users->currentPage() - 1) * $display_all_church_users->perPage()))
                                                @else
                                                @php($i = 1)
                                                @endif
                                        @foreach ($display_all_church_users as $index =>$users_particular_church)
                                            <tr>
                                                <?php
                                                    $first_name = explode(' ',trim($users_particular_church->name));
                                                    if(empty($first_name[1])){
                                                        array_push($first_name,'');
                                                    }
                                                ?>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $first_name[0] }}</td>
                                                <td>{{ $first_name[1] }}</td>
                                                <td>{{ $users_particular_church->email }}</td>
                                                <td>{{ $users_particular_church->created_at }}</td>
                                                {{-- <td>{{ $users_particular_church->role_name }}</td> --}}
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        </table>
                                        @if(isset($search_query))
                                        {{ $display_all_church_users->appends(['search' => $search_query])->links() }}
                                        @else
                                        {{ $display_all_church_users->links() }}
                                        @endif
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
