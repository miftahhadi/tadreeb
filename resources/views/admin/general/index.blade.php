@extends('admin.main')

@section('content')
<div id="app">

    <div class="page-header">
      <div class="row align-items-center">
        <div class="col-auto">
          <h2 class="page-title">{{ ucfirst($item) }}</h2>
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

              <i class="fas fa-plus"></i> 
              <span class="ml-2">Tambah Baru</span>
            
            </button>

          @endif
          
        </div>
      </div>   

    </div>

    <div class="mt-5">
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
