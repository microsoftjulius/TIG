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
                    @include('layouts.message')
                <form  class="pull-right" action="/search-group" method="get">
                    @csrf
                    <!--serch form  -->
                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                            @include('layouts.breadcrumbs')
                                            </div>
                                        </div>
                                        <div class="col-md-4"></div>
                                            <div class="col-md-2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control col-md-12" placeholder="search group" name="group_name" id="srch-term" value="{{old('group_name')}}" required>
                                                            <div class="input-group-btn">
                                                                <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i>
                                                                </button>
                                                            </div>
                                                    </div>
                                            </div>
                                            @if(in_array('Can add contacts groups',auth()->user()->getUserPermisions()))
                                        <div class="col-md-2">
                                            <div class="input-group">
                                            <a href="/create-group-form"><button type="button" class="btn btn-primary"><i class="fa fa-plus"> Contact Group</i></button></a>

                                            </div>
                                        </div>
                                        @endif
                                </div>
                </form>
                <!--table -->
                <div class="row">
                        <div class="col-lg-12">
                            <section class="box col-lg-12 col-sm-12 col-md-12 mt-3">
                                <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="th-sm">No.</th>
                                        <th class="th-sm">Group name</th>
                                        <th class="th-sm">Created by</th>
                                        <th class="th-sm">Date created</th>
                                        
                                        <th class="th-sm">Number of contacts</th>
                                        @if(in_array('Can view contacts in a group',auth()->user()->getUserPermisions()))
                                        <th class="th-sm">Option</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                        @if ($contacts->currentPage() > 1)
                                        @php($i =  1 + (($contacts->currentPage() - 1) * $contacts->perPage()))
                                        @else
                                        @php($i = 1)
                                        @endif
                                    @foreach ($contacts as $contact)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $contact->group_name }}</td>
                                            <td>{{ $contact->email }}</td>
                                            <td>{{ $contact->created_at }}</td>
                                            <td>{{ $contact->number_of_contacts }}</td>
                                            @if(in_array('Can view contacts in a group',auth()->user()->getUserPermisions()))
                                            <td><a href="/view-contacts/{{ $contact->id }}">view contacts</a></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </section>
                            @if(isset($search_query))
                            {{ $contacts->appends(['group_name' => $search_query])->links() }}
                            @else
                            {{ $contacts->links() }}
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
