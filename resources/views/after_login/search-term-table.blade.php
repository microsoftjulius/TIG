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
                                <span>Number of subscribers: {{$count_subscribers}}</span>
                                <a href="/message-categories"><button class="btn btn-warning pull-right"><i class="fa fa-arrow-left"></i> Back</button></a>
                                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addSearchTerm"><i class="fa fa-plus"></i> Add search term</button>
                                {{-- <a href="/add-category-contacts/{{request()->route('id')}}"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Contacts </button></a> --}}
                                        {{-- <button class="btn btn-primary pull-right" onclick="addRow('dataTable')"><i class="fa fa-plus"></i> Row</button> --}}
                                    {{-- <button class="btn btn-danger" onclick="deleteRow('dataTable')"><i class="fa fa-trash"></i> Row</button> --}}
                                <table id="dataTable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">No.</th>
                                            <th class="th-sm">Category</th>
                                            <th class="th-sm">Search Term</th>
                                            <th class="th-sm">Created by</th>
                                            <th class="th-sm">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ($all_search_terms as $index=>$search_term)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>{{$search_term->title}}</td>
                                            <td>{{$search_term->search_term}}</td>
                                            <td>{{$search_term->name}}</td>
                                            <form action="/delete-search-term/{{$search_term->id}}" method="get">
                                                @csrf
                                                <td><button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button></td>
                                            </form>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $all_search_terms->links()}}
                                </section>
                        </div>
                    </div>
                    <form id="searchTerm" action="/save-search-term/{{\Request::route('id')}}" method="get">
                        <div class="modal fade" id="addSearchTerm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div id="pageloader">
                                        <img src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="processing..." />
                                    </div>
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Type Search Term</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="new_search_term" id="" class="form-control" required>
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
            $("#searchTerm").on("submit", function(){
                $("#pageloader").fadeIn();
            });//submit
        });
        </script>
    </body>
</html>
