<div class="list-group list-group-transparent mb-0">

  @foreach (App\AdminSideNav::all() as $nav)
    <a href="{{ route($nav->route) }}" 
        class="list-group-item list-group-item-action d-flex align-items-center @if (strpos(Route::currentRouteName(), $nav->item) !== false) active @endif">
      <span class="icon mr-3 mb-2">
        {!! $nav->icon !!}
      </span>
      {{ $nav->judul }}
    </a>      
  @endforeach
  
</div>