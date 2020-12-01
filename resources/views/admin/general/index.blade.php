@extends('admin.main')

@section('content')
    <div id="app">

        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">
                {{ ucfirst($item) }}
            </a></li>
        </ol>

        <div class="page-header mt-2">

            <div class="row align-items-center">
                <div class="col-auto">
                  <h1>{{ ucfirst($item) }}</h1>
                </div>
              
                <div class="col-auto ml-auto d-print-none">
                  
                    @if ($item == 'user')
                        <div class="btn-list">
                            <a href="{{ route('admin.user.create') }}" class="btn btn-primary">User Baru</a>
                            <a href="{{ route('admin.user.getCsv') }}" class="btn btn-success">Tambah dari file CSV</a>
                        </div>            
                    @else

                    <button type="button" 
                            class="btn btn-primary" 
                            data-toggle="modal" 
                            data-target="#tambahBaru"
                    >

                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                        </span>
                        <span>Tambah Baru</span>
                    
                    </button>

                  @endif
                  
                </div>
            </div>   

        </div>

        <div class="mt-4">
            <item-index
              item="{{ $item }}"
              fetch-url="{{ $fetchUrl }}"
              :table-heading="{{ $tableHeading }}"
              :item-properties="{{ $itemProperties }}"
              :search="true"
            ></item-index>
        </div>

        @include('admin.general._new-item-modal')

    </div>
@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush
