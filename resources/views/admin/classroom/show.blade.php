@extends('admin.main')

@section('content')

    @include('admin._item-header')

    <div class="mt-4">
        <ul class="nav nav-tabs">
            
            <li class="nav-item">
                <a href="{{ $kelasUrl }}" 
                    class="nav-link @if (!$page) active @endif"
                >Ikhtisar</a>
            </li>
            
            @foreach ($service->navMenu as $nav)
                <li class="nav-item">
                    <a href="{{ $kelasUrl . '?page=' . strtolower($nav) }}" 
                        class="nav-link @if ($page == strtolower($nav)) active @endif"
                    >{{ $nav }}</a>
                </li>
            @endforeach
            
        </ul>

        <div class="content-tab mt-4" id="app">
            <div class="tab-pane">
                
                @if (!$page)
                    <span>Ikhtisar</span>                
                @elseif ($page == 'pengaturan')
                    pengaturan
                @else 
                    <kelas-item
                        :item-data="{{ json_encode($service->itemData) }}"
                        item="ujian"
                    ></kelas-item>
                @endif

            </div>
        </div>
    </div>
    
@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush