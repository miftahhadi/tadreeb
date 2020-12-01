<header class="navbar navbar-expand-md pb-2 d-print-none">
    <div class="container-xl">

        <a href="{{ route('admin.dashboard') }}" class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pr-0 pr-md-3">
            <img src="{{ settings('app_logo') }}" alt="{{ settings('app_name') }}" class="navbar-brand-image">
        </a>

        <div class="nav-item dropdown">
            <a href="#" 
                role="button"
                class="nav-link d-flex lh-1 text-reset p-0" 
                data-toggle="dropdown"
                id="accountMenuButton" 
                aria-haspopup="true" aria-expanded="false"
            >
                <span class="avatar avatar-sm">AD</span>
                <div class="d-none d-xl-block pl-2">
                    <div>{{ auth()->user()->nama }}</div>
                    <div class="mt-1 small text-muted">{{ auth()->user()->getRoleNames()->first() }}</div>
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-arrow" aria-labelledby="accountMenuButton">
                <a href="#" class="dropdown-item">Set status</a>
                <a href="#" class="dropdown-item">Profile & account</a>
                <a href="#" class="dropdown-item">Feedback</a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">Settings</a>
                <a href="#" class="dropdown-item">Logout</a>
            </div>
            
        </div>

    </div>
</header>
