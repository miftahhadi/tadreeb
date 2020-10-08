<div class="list-group list-group-transparent mb-0">

  @foreach (settings('admin_nav_menu') as $nav)
    <a href="{{ route($nav['route']) }}" 
        class="list-group-item list-group-item-action d-flex align-items-center 
                @if ((Route::currentRouteName() == 'admin.' && $nav['item'] == 'admin') || (strpos(Route::currentRouteName(), $nav['item']) !== false && $nav['item'] != 'admin')) 
                  active 
                @endif">
      <span class="icon mr-3 mb-2">
        {!! $nav['icon'] !!}
      </span>
      {{ $nav['name'] }}
    </a>      
  @endforeach
  
</div>