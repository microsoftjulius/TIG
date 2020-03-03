<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="clearfix"></div>
    
        <!-- menu profile quick info -->
        <div class="profile clearfix">
        <div class="profile_pic">
            <img src="{{ asset('images/'.auth()->user()->getLoggedInChurchLogo()) }}" alt="Church Logo" class="img-circle profile_img" style="border-radius:100%; width:55px;height:60px;">
        </div>
        <div class="profile_info">
            <span>Welcome</span>
            <h2 style="text-transform:capitalize">{{ auth()->user()->name }}</h2>
        </div>
        </div>
        <!-- /menu profile quick info -->
    
        <br />
    
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3>General</h3>
            <ul class="nav side-menu">
                @if(in_array('Can view Dashboards',auth()->user()->getUserPermisions()))
                    <li><a href='/home'><i class="fa fa-home"></i> Home </a></li>
                @endif
                @if(in_array('Can view groups',auth()->user()->getUserPermisions()))
                    @if(Auth::user()->church_id == 1)
                        <li><a href='/groups'><i class="fa fa-book"></i> Groups </a></li>
                    @endif
                @endif
                @if(in_array('Can add users to church',auth()->user()->getUserPermisions()))
                    <li><a href='/user'><i class="fa fa-user"></i>Users </a></li>
                @endif
            @if(in_array('Can view contacts in a group',auth()->user()->getUserPermisions()))
            <li><a><i class="fa fa-phone"></i> Contacts <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/contact-groups">Contacts groups</a></li>
                </ul>
            </li>
            @endif
            @if(in_array('Can view wrong contact messages',auth()->user()->getUserPermisions()) || in_array('Can Send a Quick Message',auth()->user()->getUserPermisions())
            || in_array('Can view sent messages',auth()->user()->getUserPermisions()) || in_array('Can view scheduled messages',auth()->user()->getUserPermisions())
            || in_array('Can view message categoriess',auth()->user()->getUserPermisions()) || in_array('Can view incoming messages',auth()->user()->getUserPermisions())
            || in_array('Can view uncategorized messages',auth()->user()->getUserPermisions()))
                <li><a><i class="fa fa-envelope"></i> Messages <span class="fa fa-chevron-down"></span></a>
            @endif
                <ul class="nav child_menu">
                    @if(in_array('Can Send a Quick Message',auth()->user()->getUserPermisions()))
                        <li><a href="/sent-quick-messages">Quick Message</a></li>
                    @endif
                    @if(in_array('Can view sent messages',auth()->user()->getUserPermisions()))
                        <li><a href="/display-sent-messages">Sent Messages</a></li>
                    @endif
                    @if(in_array('Can view scheduled messages',auth()->user()->getUserPermisions()))
                        <li><a href="/display-scheduled-messages">Scheduled Messages</a></li>
                    @endif
                    @if(in_array('Can view message categories',auth()->user()->getUserPermisions()))
                        <li><a href="/message-categories"><i class=""></i> Message categories </a></li>
                    @endif
                    @if(in_array('Can view incoming messages',auth()->user()->getUserPermisions()))
                        <li><a href="/incoming-messages"><i class=""></i> Incoming messages </a></li>
                    @endif
                    @if(in_array('Can view uncategorized messages',auth()->user()->getUserPermisions()))
                        <li><a href="/uncategorized-messages"><i class=""></i> Uncategorized Messages</a></li>
                    @endif
                    {{-- <li><a href="/deleted-messages"><i class=""></i> Deleted Messages</a></li> --}}
                    @if(in_array('Can view wrong contact messages',auth()->user()->getUserPermisions()))
                        <li><a href="/contact-not-found-messages">Wrong Contact Messages</a></li>
                    @endif
                </ul>
            </li>
            @if(in_array('Can view payment packages',auth()->user()->getUserPermisions())|| in_array('Can view logs',auth()->user()->getUserPermisions()))
            <li><a><i class="fa fa-cc-paypal"></i> Payments <span class="fa fa-chevron-down"></span></a>
                @endif
                <ul class="nav child_menu">
                    @if(in_array('Can view payment packages',auth()->user()->getUserPermisions()))
                        <li><a href="/packages">Packages</a></li>
                    @endif
                    @if(in_array('Can view logs',auth()->user()->getUserPermisions()))
                        <li><a href="/logs">Logs</a></li>
                    @endif
                </ul>
            </li>
            @if(in_array('Can create user permissions',auth()->user()->getUserPermisions()))
                <li><a href="/roles-and-permision"><i class="fa fa-key"></i> User Permission </a></li>
            @endif
            <li><a href="/change-passwords"><i class="fa fa-lock"></i> Change Password </a></li>
            </ul>
        </div>
        </div>
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
        
        </div>
        <!-- /menu footer buttons -->
    </div>
    </div>
    