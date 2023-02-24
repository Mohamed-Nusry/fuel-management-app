<li style="color:#fff !important" class="nav-item {{ request()->is('*user*') ? 'menu-opening menu-open' : '' }}">
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
        <i class="nav-icon fas fa-car"></i>
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
        <i class="nav-icon fas fa-clock"></i>
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
        <i class="nav-icon fas fa-envelope"></i>
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
            <a href="{{ route('fueltoken.index') }}" class="nav-link {{ request()->is('*fueltoken') ? 'sub-active' : '' }}">
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
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('customerreport.index') }}" class="nav-link {{ request()->is('*report/customer') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Customer Report</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('customerreport.index') }}" class="nav-link {{ request()->is('*report/customer') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Vehicle Report</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('fueldistreport.index') }}" class="nav-link {{ request()->is('*report/fueldist') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Fuel Distribution Report</p>
            </a>
        </li>
    </ul>
</li>
