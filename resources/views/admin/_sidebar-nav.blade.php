<div class="list-group list-group-transparent mb-0">

    <ul class="nav nav-pills nav-vertical">

        @foreach (settings('admin_nav_menu') as $nav)
        <li class="nav-item">

            <a href="{{ route($nav['route']) }}" 
                class="nav-link @if ((Route::currentRouteName() == 'admin.dashboard' && $nav['item'] == 'admin') || (strpos(Route::currentRouteName(), $nav['item']) !== false && $nav['item'] != 'admin')) active @endif">
              
                <span class="icon mr-2 mb-2">
                  {!! $nav['icon'] !!}
                </span>
            
                {{ $nav['name'] }}
            
            </a>

        </li>
                
        @endforeach

    </ul>
  
</div>