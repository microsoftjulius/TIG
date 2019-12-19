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
                <div class="row">
                <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <!-- Default form login -->
                    <!-- Material form register -->
                    <!--form to create users

                        <div class="card" style=" border:1px solid black; padding :1em">

                        <div class="card-body px-lg-10 pt-0"></div>


                            <form method="POST" action="/create-user" class="text-center" style="color: #757575;">
                                @csrf
                                @foreach($all_churches as $all_church)
                                <input type="hidden" name="church_id" value="{{ $all_church->id }}">
                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col text-center">
                                            <button type="submit" class="btn btn-primary btn-rounded btn-block my-8 waves-effect z-depth-0">
                                                {{ __('Register') }}
                                            </button>
                                        </div>
                                    </div>

                                @endforeach
                                </form>
                        </div>
                    </div>
                    </div>
                    -->

                        <!-- Material form register -->
                    <!-- Default form login -->


                    <!-- Search form -->
                    <div class="row">
                        <form class="pull-right" role="search">
                            <div class="col-md-12">
                                    <div class="col-md-8"></div>
                                        <div class="col-md-2">
                                                <div class="input-group">
                                                        <input type="text" class="form-control col-md-12" placeholder="Search" name="srch-term" id="srch-term">
                                                    <div class="input-group-btn">

                                                        <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i>

                                                        </button>
                                                    </div>
                                                </div>
                                        </div>
                                    <div class="col-md-2">
                                        <div class="input-group">
                                            <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-user"> Add User</i></button>
                                        </div>
                                    </div>
                            </div>
                        </form>
                    </div>

                        <!--table-->
                    <div class="row">
                            <div class="col-lg-12">
                                <section class="box col-lg-12 col-sm-12 col-md-12 mt-3">
                                        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="th-sm">No.</th>
                                                    <th class="th-sm">Name
                                                    </th>
                                                    <th class="th-sm">Email</th>
                                                    <th class="th-sm">Group</th>
                                                    <th class="th-sm"> Options</th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                        </tbody>
                                        </table>
                                </section>
                            </div>
                    </div>
                    <div class="col-lg-2"></div>
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
