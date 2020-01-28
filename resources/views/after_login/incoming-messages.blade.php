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
                    <form action="/search-incoming-messages" method="get" id="incomingMessages">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-md-7">
                                    <div class="col-lg-5">
                                        <div class="input-group">
                                            <div class="input-group-btn">
                                                <input type="text" id="datetimepicker" class="form-control col-sm-2 mr-2" name="from" placeholder=" start date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="input-group-btn">
                                            <input type="text" id="datetimepicker1" class="form-control col-sm-2" name="to" placeholder="End date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="col-lg-4"></div>
                                    <div class="col-md-8 pull-right">
                                        <div class="btn-group">
                                        <a href="#" class="btn btn-default dropdown-toggle w-50" data-toggle="dropdown">
                                        Select a category &nbsp;<span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" style="padding: 5px;" id="myDiv">
                                            @foreach($drop_down_categories as $getting_from_database)
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="" name="search_message" value="{{ $getting_from_database->title }}"/> {{ $getting_from_database->title }}
                                                    </label>
                                                </div>
                                            @endforeach

                                        </ul>
                                        <div class="input-group-btn">
                                                                <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i>
                                                                </button>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--Table-->
                    <div class="row">
                        <div class="col-lg-12">
                            <section class="box col-lg-12 col-sm-12 col-md-12 mt-3">
                                <table id="dtBasicExample" class="table table-striped table-bordered table-sm bg-white" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Id</th>
                                            <th class="th-sm">Message</th>
                                            <th class="th-sm">Senders Contact</th>
                                            @if(auth()->user()->church_id == 1)
                                            <th class="th-sm">Sending Church</th>
                                            @endif
                                            <th class="th-sm">Message Sent on</th>
                                            <th class="th-sm">Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($messages_to_categories->currentPage() > 1)
                                        @php($i =  1 + (($messages_to_categories->currentPage() - 1) * $messages_to_categories->perPage()))
                                        @else
                                        @php($i = 1)
                                        @endif
                                        @foreach ($messages_to_categories as $messages)
                                        <tr>
                                            <th class="th-sm">{{ $i++ }}</th>
                                            <th class="th-sm">{{ $messages->message }}</th>
                                            <th class="th-sm">{{ $messages->message_from }}</th>
                                            @if(auth()->user()->church_id == 1)
                                            <th class="th-sm">{{ $messages->church_name}}</th>
                                            @endif
                                            <th class="th-sm">{{ $messages->created_at }}</th>
                                            <th class="th-sm">{{ $messages->title }}</th>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if(isset($search_query))
                                {{ $messages_to_categories->appends(['search' => $search_query])->links() }}
                                @else
                                {{ $messages_to_categories->links() }}
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
        
        <script>
            $(document).ready(function(){
            $("#incomingMessages").on("submit", function(){
                $("#pageloader").fadeIn();
            });//submit
        });
        </script>
    </body>
</html>
