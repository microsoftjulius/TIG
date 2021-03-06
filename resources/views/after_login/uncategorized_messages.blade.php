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
                    <!--table -->
                    <div class="row">
                        <div class="col-lg-12">
                    @include('layouts.message')
                            <section class="box col-lg-12 col-sm-12 col-md-12 mt-3">
                                <table id="dataTable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">No.</th>
                                            <th class="th-sm">Category</th>
                                            <th class="th-sm">Message</th>
                                            <th class="th-sm">Senders Contact</th>
                                            <th class="th-sm">Message Sent on</th>
                                            @if(in_array('Can delete uncategorized messages',auth()->user()->getUserPermisions()))
                                                <th class="th-sm">Options</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($uncategorized_messages->currentPage() > 1)
                                        @php($i =  1 + (($uncategorized_messages->currentPage() - 1) * $uncategorized_messages->perPage()))
                                        @else
                                        @php($i = 1)
                                        @endif
                                        @foreach ($uncategorized_messages as $index=>$message)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>No Category</td>
                                            <td>{{$message->message}}</td>
                                            <td>{{$message->contact}}</td>
                                            <td>{{$message->created_at}}</td>
                                            @if(in_array('Can delete uncategorized messages',auth()->user()->getUserPermisions()))
                                            <form action="/delete-uncategorized-message/{{$message->id}}" method="get">
                                                @csrf
                                                <td><button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button></td>
                                            </form>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $uncategorized_messages->links()}}
                                </section>
                        </div>
                    </div>
                    <form action="/save-search-term/{{\Request::route('id')}}" method="get" id="createCampaign">
                        <div class="modal fade" id="addSearchTerm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div id="pageloader">
                                            <img src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="processing..." />
                                        </div>
                                    <h5 class="modal-title" id="exampleModalLabel">Type Search Term</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="new_message" id="" class="form-control">
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Search term</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </form>
                </div>
                <!-- /page content -->
                <!-- footer content -->
                @include('layouts.footer')
                <!-- /footer content -->
            </div>
        </div>
        <!-- Modal -->
        @include('layouts.javascript')

        <script>
            $(document).ready(function(){
            $("#createCampaign").on("submit", function(){
                $("#pageloader").fadeIn();
            });//submit
        });
        </script>
    </body>
</html>
