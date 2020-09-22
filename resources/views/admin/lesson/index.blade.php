@extends('admin.main')

@section('content')
<div class="page-header">
      
    <h2 class="page-title">Pelajaran</h2>

</div>

<div class="row mb-3">

    <div class="col">
      <button type="button" 
              class="btn btn-primary" 
              data-toggle="modal" 
              data-target="#tambahBaru"
      >

        <i class="fas fa-plus"></i> 
        <span class="ml-2">Tambah Baru</span>
      
      </button>
    </div>
    

    <div class="col-auto">
        <form action="." method="get">
            <div class="input-icon">
              <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><circle cx="10" cy="10" r="7"></circle><line x1="21" y1="21" x2="15" y2="15"></line></svg>
              </span>
              <input type="text" class="form-control form-control-rounded" placeholder="Search…">
            </div>
        </form>
    </div>
    
</div>

<div class="box" id="app">
  <lesson-index></lesson-index>
</div>
    
@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush
