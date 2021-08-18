<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                                <img alt="image" class="img-circle" src="img/profile_small.jpg" />
                                </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{Auth::user()->name}}</strong></span> 
                                @if(Auth::user()->user_access_id == '1')
                                    <span class="text-muted text-xs block">{{"Normal Staff"}}<b class="caret"></b></span>
                                @elseif (Auth::user()->user_access_id == '2')
                                    <span class="text-muted text-xs block">{{"HOD"}}<b class="caret"></b></span>
                                @elseif (Auth::user()->user_access_id == '3')
                                    <span class="text-muted text-xs block">{{"PROVOST"}}<b class="caret"></b></span>
                                @elseif (Auth::user()->user_access_id == '4')
                                    <span class="text-muted text-xs block">{{"REGISTRY"}}<b class="caret"></b></span>
                                @elseif (Auth::user()->user_access_id == '5')
                                    <span class="text-muted text-xs block">{{"VICE CHANCELLOR"}}<b class="caret"></b></span>
                                @elseif (Auth::user()->user_access_id == '100')
                                    <span class="text-muted text-xs block">{{"SUPER ADMIN"}}<b class="caret"></b></span>
                                @endif
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.html">Profile</a></li>
                            <li class="divider"></li>
                            <li><a href={{ route('logout') }}>Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li>
                    <a href="{{ url('/')}}"><i class="fa fa-th-large"></i><span class="nav-label"> Dashboards </span></a>
                </li>
                {{-- @if (Auth::user()->cadre == 'Patient') --}}
                    <li class="active">
                        <a href="{{ url('/application') }}"><i class="fa fa-user"></i> <span class="nav-label">Application</span></a>
                    </li>
                    <li class="active">
                        <a href="{{ url('/signUp') }}"><i class="fa fa-user"></i> <span class="nav-label">signUp</span></a>
                    </li>
                    <li class="active">
                        <a href="{{ url('/search') }}"><i class="fa fa-diamond"></i> <span class="nav-label">Search</span></a>
                    </li>
                {{-- @endif --}}
                {{-- @if (Auth::user()->cadre == 'Doctor') --}}
                    <li class="active">
                        <a href="{{ url('/allLeave') }}"><i class="fa fa-user"></i> <span class="nav-label">All Leave</span></a>
                    </li>
                    <li class="active">
                        <a href="{{ url('/applied') }}"><i class="fa fa-user"></i> <span class="nav-label">Applied</span></a>
                    </li>
                    <li class="active">
                        <a href="{{ url('/approved') }}"><i class="fa fa-user"></i> <span class="nav-label">Approved Leaves</span></a>
                    </li>
                    <li class="active">
                        <a href="{{ url('/faculty') }}"><i class="fa fa-diamond"></i> <span class="nav-label">Add Faculty</span></a>
                    </li>
                    <li class="active">
                        <a href="{{ url('/department') }}"><i class="fa fa-diamond"></i> <span class="nav-label">Add Department</span></a>
                    </li>
                    <li class="active">
                        <a href="{{ url('/unit') }}"><i class="fa fa-diamond"></i> <span class="nav-label">Add Unit</span></a>
                    </li>
                    <li class="active">
                        <a href="{{ url('/holiday') }}"><i class="fa fa-diamond"></i> <span class="nav-label">Add Holiday</span></a>
                    </li>
                    <li class="active">
                        <a href="{{ url('/leaveType') }}"><i class="fa fa-diamond"></i> <span class="nav-label">Leave Type</span></a>
                    </li>
                {{-- @endif --}}
            </ul>
        </div>
    </nav>
</div>