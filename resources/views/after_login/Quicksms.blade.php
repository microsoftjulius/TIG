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
                <div class="row">
                    <div id="content">
                        <ul id="tabs" class="nav nav-tabs col-md-offset-1 col-sm-10" data-tabs="tabs">
                            <li class="active"><a href="#groupmessage" data-toggle="tab">Send to Group</a></li>
                            <li><a href="#categorymessage" data-toggle="tab">Send To Category</a></li>
                            <li><a href="#nocategorymessage" data-toggle="tab">Send To Un Categorized</a></li>
                        </ul>
                        <div id="my-tab-content" class="tab-content">
                            @include('layouts.groupsMessage')
                            @include('layouts.categorizedMessage')
                            @include('layouts.unCategorizedMessage')
                        </div>
                        <div class="row">
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
                $("#messagesForm").on("submit", function(){
                    $("#pageloader").fadeIn();
                });//submit
            });

            $('.dropdown-menu').click(e => {
                $selected = $('.checkbox1 input[type="checkbox"]:checked');
                var total = 0;
                const count = $selected.length;
                for (var i = 0; i < count; ++i) {
                    total += parseInt($selected[i].getAttribute('data-count'));
                }
                $('#contact_character').val(total);
            });

            $('.dropdown-menu').click(e => {
                $selected = $('.checkbox2 input[type="checkbox"]:checked');
                var total = 0;
                const count = $selected.length;
                for (var i = 0; i < count; ++i) {
                    total += parseInt($selected[i].getAttribute('data-count'));
                }
                $('#category_contacts_count').val(total);
            });
        </script>
    </body>
</html>