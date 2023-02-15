<aside style="background: #262d5a !important" class="main-sidebar elevation-4">
    <a href="{{ route('home') }}" class="brand-link">
        &nbsp;  &nbsp;  &nbsp;
        <span class="brand-text font-weight-light" style="color:#fff !important">FuelIn App</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul style="color:#fff !important" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>

</aside>
