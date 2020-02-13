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
                        <div class="row">
                            <div class="col-lg-12">
                                @include('layouts.message')
                            </div>
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6 card">
                                <form method="get" action="/save-contact-to-category/{{request()->route('id')}}">
                                    <div class="form-group">
                                        <label for="exampleInputContact">Contact</label>
                                        <input type="number" class="form-control" placeholder="Enter phone_number" name="contact_number" value="{{old('contact_number')}}" autocomplete="off">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4"></div>
                                        <div class="col-lg-4">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        <div class="col-lg-4"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <div class="row">
                        <div class="row pull-right">
                            <form action="/import-contacts-category/{{ \Request::segment(2) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <input type="file" name="file" class="form-control" required>
                                        <input type="hidden" name="category" value="{{ \Request::segment(2) }}">
                                    </div>
                                </div>

                        <div class="col-md-2 pull-right">
                            <div class="input-group">
                            <a href='/add-search-term/{{ \Request::segment(2) }}'><button type="button" class="btn btn-warning">
                                <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</i></button></a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <br>
                                <button class="btn btn-success"><i class="fa fa-paperclip"></i> Import User Data</button>
                            </div>
                        </div>
                            </form>
                        </div>
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
            $("#packages").on("submit", function(){
                $("#pageloader").fadeIn();
            });//submit
            });
        </script>
    </body>
</html>