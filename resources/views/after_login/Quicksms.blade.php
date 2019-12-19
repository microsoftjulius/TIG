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
                            <a data-toggle="tooltip" data-placement="top" title="Logout" href="">
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
                    <form class="col-md-offset-1 col-sm-10" style="border-width: 4px 4px 4px 4px; padding :1em; background-color:white;" action="/store-sent-messages" method="POST">
                        @csrf
                        <div class="panel-heading text-center">
                            <h4></h4>
                            <hr>
                        </div>
                        @include('layouts.errormessage')
                        <div class="form-group row md-form">
                            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Contact groups</label>
                            <div class="col-sm-10">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-default dropdown-toggle w-50" data-toggle="dropdown">
                                    Select a group &nbsp;<span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" style="padding: 5px;" id="myDiv">
                                        <li><input type="checkbox" id="select_all"/> All groups</li>
                                            @foreach($drop_down_groups as $picking_from_database)
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="checkbox dropdown-item checkbox-primary" name="checkbox[]" value="{{$picking_from_database->id}}" data-count="{{ $picking_from_database->number_of_contacts }}" /> {{ $picking_from_database->group_name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabel" class="col-sm-2 col-form-label">Date and time</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="datepicker" name="created_at" value="{{ old('created_at') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Text message</label>
                            <div class="col-sm-8">
                            <textarea type="text" class="form-control form-control-lg" rows="7" name="message" id="message" onkeyup="countChars(this);" maxlength='310' value="{{ old('message') }}"></textarea>
                            <p id="charNum">0   characters [1message is 160 characters,2messages 310 characters]</p>

                                <br>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg"> Number of Contacts</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-lg" name="contact_character" id="contact_character" placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="text-center py-4 mt-3 ">
                                <button type="submit" class="btn btn-primary"><li class="fa fa-send-o"></li> Send Message</button>
                                <a href="{{url()->previous()}}"><button type="button" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</i></button></a>
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
        <script>
            $('.dropdown-menu').click(e => {
                $selected = $('.checkbox input[type="checkbox"]:checked');
                var total = 0;
                const count = $selected.length;
                for (var i = 0; i < count; ++i) {
                    total += parseInt($selected[i].getAttribute('data-count'));
                }

                $('#contact_character').val(total);
            });
        </script>
    </body>
</html>
