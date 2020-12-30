<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    @foreach ($breadcrumbs as $item)
        <li class="breadcrumb-item"><a href="{{ route($item['route']) }}">{{ $item['name'] }}</a></li>
    @endforeach
    <li class="breadcrumb-item active" aria-current="page"><a href="#">
        {{ $pelajaran->judul }}
    </a></li>
</ol>

<h2 class="h1 font-weight-bold">{{ $pelajaran->judul }}</h2>
<p>
    {{ $pelajaran->deskripsi }}
</p>

<ul class="list-inline">
    <li class="list-inline-item"><small><a href="#">Edit</a></small></li>
    <li class="list-inline-item"><small><a href="#" class="text-danger">Hapus</a></small></li>
</ul>