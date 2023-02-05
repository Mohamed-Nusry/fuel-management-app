<li class="nav-item">
    <a href="{{ url('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>

<li class="nav-item {{ request()->is('*user*') ? 'menu-opening menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Users
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('manager.index') }}" class="nav-link {{ request()->is('*user/manager') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Managers</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('customer.index') }}" class="nav-link {{ request()->is('*user/customer') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Customers</p>
            </a>
        </li>
    </ul>
  
</li>


<li class="nav-item {{ request()->is('*vehiclemanagement*') ? 'menu-opening menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-suitcase"></i>
        <p>
            Vehicle Registrations
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('vehicle.index') }}" class="nav-link {{ request()->is('*vehiclemanagement/vehicle') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>All Vehicles</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('vehicleregistration.index') }}" class="nav-link {{ request()->is('*vehiclemanagement/vehicleregistration') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Vehicle Registrations</p>
            </a>
        </li>
    </ul>

</li>


<li class="nav-item {{ request()->is('*fuelstation*') ? 'menu-opening menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-suitcase"></i>
        <p>
            Fuel Stations
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('fuelstation.index') }}" class="nav-link {{ request()->is('*fuelstation') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>All Fuel Stations</p>
            </a>
        </li>
    </ul>

</li>


<li class="nav-item {{ request()->is('*schedule*') ? 'menu-opening menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-suitcase"></i>
        <p>
            Schedules
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('schedule.index') }}" class="nav-link {{ request()->is('*schedule') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Schedule Distributions</p>
            </a>
        </li>
    </ul>

</li>



<li class="nav-item {{ request()->is('*fuelrequest*') ? 'menu-opening menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-suitcase"></i>
        <p>
            Fuel Requests
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('fuelrequest.index') }}" class="nav-link {{ request()->is('*fuelrequest') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>All Fuel Requests</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('fuelrequest.index') }}" class="nav-link {{ request()->is('*fuelrequest') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Tokens</p>
            </a>
        </li>
    </ul>

</li>



<li class="nav-item {{ request()->is('*report*') ? 'menu-opening menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        <p>
            Reports
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    {{-- <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('workreport.index') }}" class="nav-link {{ request()->is('*report/work') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Work Report</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('incomereport.index') }}" class="nav-link {{ request()->is('*report/income') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Income Report</p>
            </a>
        </li>
    </ul> --}}
</li>
