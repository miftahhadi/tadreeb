<header class="navbar navbar-expand-md navbar-light">
    <div class="container-xl">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a href="{{ route('dashboard') }}" class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pr-0 pr-md-3">
        <img src="/static/logo.svg" alt="Tabler" class="navbar-brand-image">
      </a>
      <div class="navbar-nav flex-row order-md-last">
        
        <div class="nav-item dropdown">
          <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown">
            <span class="avatar">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
            </span>
            <div class="d-none d-xl-block pl-2">
              <div>{{ auth()->user()->name }}</div>
              <div class="mt-1 small text-muted">{{ auth()->user()->getRoleDisplayName() }}</div>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="accountMenuButton">
            <a href="#" class="dropdown-item">Profile & account</a>
            @if (auth()->user()->canAccessAdmin())
              <a href="{{ route('admin.dashboard') }}" class="dropdown-item">Halaman Admin</a>
            @endif
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <input type="submit" value="Logout" class="dropdown-item">
            </form>
        </div>
        </div>
      </div>
      
    </div>
  </header>