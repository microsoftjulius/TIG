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
                            <form class="pull-right pt-4" role="search" action="/search-scheduled-messages" method="get" >
                            @csrf
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                            <div class="input-group">
                                                @include('layouts.breadcrumbs')
                                            </div>
                                        </div>
                                        <div class="col-md-4"></div>
                                            <div class="col-md-4">
                                                    <div class="input-group">
                                                            <input type="text" class="form-control col-md-12" placeholder="Search" name="scheduled_message" id="" required>
                                                            <div class="input-group-btn">
                                                                <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i>
                                                                </button>
                                                            </div>
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
                                                        <th class="th-sm">Id</th>
                                                        <th class="th-sm">Message</th>
                                                        <th class="th-sm">Group</th>
                                                        @if(auth()->user()->id == 1)
                                                        <th class="th-sm">Church</th>
                                                        @endif
                                                        <th class="th-sm"> Date/Time to send it</th>
                                                        <th class="th-sm"> Message status</th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                            @if ($display_all_scheduled_messages->currentPage() > 1)
                                            @php($i =  1 + (($display_all_scheduled_messages->currentPage() - 1) * $display_all_scheduled_messages->perPage()))
                                            @else
                                            @php($i = 1)
                                            @endif
                                            @foreach ($display_all_scheduled_messages as $scheduled_message_details)
                                                <tr>
                                                    <td>{{ $i++}}</td>
                                                    <td>{{ $scheduled_message_details->message }}</td>
                                                    <td>{{ $scheduled_message_details->group_name }}</td>
                                                    @if(auth()->user()->id == 1)
                                                    <td>{{ $scheduled_message_details->church_name}}</td>
                                                    @endif
                                                    <td>{{ $scheduled_message_details->tobesent_on }}</td>
                                                    <td>{{ $scheduled_message_details->status }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                    </table>
                                </section>
                                @if(isset($search_query))
                                {{ $display_all_scheduled_messages->appends(['search_message' => $search_query])->links() }}
                                @else
                                {{ $display_all_scheduled_messages->links() }}
                                @endif
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
