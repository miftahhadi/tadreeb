<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    @foreach ($breadcrumbs as $item)
        <li class="breadcrumb-item" aria-current="page"><a href="{{ $item['href'] }}">
            {{ ucfirst($item['name']) }}
        </a></li>        
    @endforeach
</ol>