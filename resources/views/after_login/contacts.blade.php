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
                    @include('layouts.errormessage')
                            <section class="box col-lg-12 col-sm-12 col-md-12 mt-3">
                                <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">No.</th>
                                            <th class="th-sm">Group name</th>
                                            <th class="th-sm">Created by</th>
                                            <th class="th-sm">Updated by</th>
                                            <th class="th-sm">name</th>
                                            <th class="th-sm">Contacts</th>
                                            <th class="th-sm">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @if ($contacts->currentPage() > 1)
                                            @php($i =  1 + (($contacts->currentPage() - 1) * $contacts->perPage()))
                                            @else
                                            @php($i = 1)
                                            @endif
                                        @foreach ($contacts as $index => $contact)
                                        <tr>
                                            <form action="/delete-contact/{{ $group->group_id }}" method="POST">
                                                @csrf
                                                <td hidden><input type="hidden" name="index_to_delete" id="" value="{{ $i }}"></td>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $group->group_name }}</td>
                                                <td>{{ $group->email }}</td>
                                                <td>{{ $group->email }}</td>
                                                <td>{{ $contact->name }}</td>
                                                <td>{{ $contact->Contact }}</td>
                                                <td><button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button></td>
                                            </form>
                                        </tr>
                                        @endforeach
                                        <form action="/save-contact-to-group/{{ \Request::segment(2) }}" method="POST">
                                            @csrf
                                            <tr>
                                                <td></td>
                                                <td><input type="text" name="groupname" value="{{ $group->group_name }}" class="form-control" disabled></td>
                                                <td><input type="text" name="created_by" value="{{ auth()->user()->email }}" class="form-control" disabled></td>
                                                <td><input type="text" name="created_by" value="{{ auth()->user()->email }}" class="form-control" disabled></td>
                                                <td><input type="text" name="name" value="" class="form-control"></td>
                                                <td><input type="text" name="contact" value="" class="form-control"></td>
                                                <td></td>
                                            </tr>

                                            <a href="/contact-groups"><button type="button" class="btn btn-warning pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</i></button></a>
                                            <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-save"></i> Save</button>
                                            @include('layouts.breadcrumbs')
                                            <span class="text-primary">After inputing a name and a contact number, press enter to save it to the group</span>
                                            {{-- <input type="file" name="file" id="" value="Upload"> --}}
                                        </form>

                                    </tbody>

                                </table>
                                {{ $contacts->links() }}
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
