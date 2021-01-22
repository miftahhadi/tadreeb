@extends('admin.main')

@section('content')

<div id="app">
    <item-index item="{{ $item }}" fetch-url="{{ $fetchUrl }}" :table-heading="{{ $tableHeading }}" :item-properties="{{ $itemProperties }}" :search="true" item-identifier="{{ $identifier ?? null }}" name-shown-as="{{ $nameShownAs ?? null }}">
        <template v-slot:header>
            
            <div class="page-header">
                <div class="row align-items-center mw-100">

                    <div class="col">
                        <div class="mb-1">
                            <ol class="breadcrumb breadcrumb-arrows breadcrumb-alternate" aria-label="breadcrumbs">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#">
                                    Daftar User
                                </a></li>
                            </ol>
                        </div>
                        <h1>
                            <span class="text-truncate">Daftar User</span>
                        </h1>
                    </div>

                    <div class="col-auto">
                        <div class="btn-list">
                            <button type="button" class="btn" 
                                    data-toggle="modal" data-target="#tambahBaru"
                            >
        
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                                </span>
                                <span>Tambah Baru</span>
                            
                            </button>

                            <a href="#" class="btn btn-success">Impor dari .CSV</a>

                        </div>
                    </div>
                </div>
            </div>

        </template>
    </item-index>
</div>

@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush