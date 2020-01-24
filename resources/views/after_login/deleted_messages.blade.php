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
                                            <th class="th-sm">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($uncategorized_messages as $index=>$message)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>No Category</td>
                                            <td hidden>{{$message->id}}</td>
                                            <td>{{$message->message}}</td>
                                            <td>{{$message->contact_number}}</td>
                                            <td>{{$message->updated_at}}</td>
                                            <td><button class="btn btn-danger" data-toggle="modal" data-target="#addSearchTerm"><i class="fa fa-trash"></i> Delete</button></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $uncategorized_messages->links()}}
                            </section>
                        </div>
                    </div>
                    <form action="/permanetly-delete-message" method="get">
                        @csrf
                        <div class="modal fade" id="addSearchTerm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                {{-- <h2 class="modal-title" id="exampleModalLabel">Approve Delete</h2> --}}
                                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button> --}}
                                </div>
                                <div class="modal-body">
                                    <h4>Performing this is not reversable, are you sure you want to continue?</h4>
                                    <input type="hidden" name="message_id" id="message_id" class="form-control">
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
                @include('layouts.footer')
                <!-- /footer content -->
            </div>
        </div>
        <!-- Modal -->
        @include('layouts.javascript')
        <script>
            $('button[data-toggle = "modal"]').click(function(){
                var message_id = $(this).parents('tr').children('td').eq(2).text();
                document.getElementById('message_id').setAttribute("Value", message_id);
            });
        </script>
    </body>
</html>
