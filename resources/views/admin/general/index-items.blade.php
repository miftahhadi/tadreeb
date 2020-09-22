@extends('admin.main')

@section('content')

  <div class="page-header">
      
      <h2 class="page-title">@yield('pageTitle')</h2>
  
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

  <div class="box">
    <div class="card">
      <div class="table-responsive">

        <table class="table table-vcenter table-hover card-table">

          <thead>
            <tr>
              @yield('tableHeading')
            </tr>
          </thead>

          <tbody>

            @yield('tableBody')

          </tbody>

        </table>

      </div>
    </div>

    @yield('pagination')

  </div>

  <!-- Modal Add New -->
  <div class="modal fade" 
        id="tambahBaru" 
        tabindex="-1" 
        role="dialog" 
        aria-labelledby="tambahBaruLabel" 
        aria-hidden="true"
  >

  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ujian Baru</h5>
        
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <!-- SVG icon code -->
          </button>

      </div>
      
      <div class="modal-body" id="app">
            
          <item-baru-form 
              judul="{{ $judul }}" 
              item="{{ $item }}" 
              action="{{ $action }}" 
              url="{{ $url }}" 
              slug="{{ $slug }}"
          >
            @csrf
          
          </item-baru-form>
            
      </div>
    </div>
  </div>

  <!-- END Modal Add New -->

  <!-- Modal Delete Data -->
<div class="modal fade" 
      id="hapusData" 
      tabindex="-1" 
      role="dialog" 
      aria-labelledby="hapusDataLabel" 
      aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        Anda yakin ingin menghapus item ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
        <form action="" method="post">
          <input type="hidden" name="id" id="dataID">
          <input type="hidden" name="table" value="">
          <input type="hidden" name="primaryKey" value="">
          <input type="hidden" name="page" value="">
          <input type="submit" class="btn btn-danger" value="Hapus">
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#hapusData').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget) // Button that triggered the modal
  let id = button.data('id') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  let modal = $(this)
  modal.find('.modal-footer #dataID').val(id)
  })
</script>
<!-- END Modal Delete Data -->

  <script type="text/javascript" src="/dist/js/app.js"></script>

@endsection