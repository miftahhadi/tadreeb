@extends('layouts.admin')

@section('page')
<!-- Page Title and Stuffs -->
<div class="page-header">

    <div class="row align-items-center">
        <div class="col-auto">
            <h3 class="h1 my-0">Daftar User</h3>
        </div>   
        <div class="col-auto ml-auto">
            <a href="{{ route('user.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> 
                <span class="ml-2">Tambah Baru</span>
            </a>
            <a href="{{ route('user.getCsv') }}" class="btn btn-success">
                <i class="fas fa-file-csv"></i>
                <span class="ml-2">Impor dari file CSV</span>
            </a>
        </div> 
    </div>

</div>
<!-- END Page Title and Stuffs -->
<!-- Data table -->
<div class="card">
    <table class="table card-table table-hover table-vcenter">
        <thead>
        <tr>
            <th width="5%">ID</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Peran</th>
            <th>Jenis Kelamin</th>
            <th width="30%"></th>
        </tr>
        </thead>
        <tbody>

        @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->username }}</td>
                <td>
                    @foreach ($user->roles as $role)
                    <span class="badge bg-blue">{{ $role->tipe }}</span>
                    @endforeach
                </td>
                <td>{{ $user->gender }}</td>
                <td class="text-right">
                    <div class="btn-list">
                        <a href="#" class="btn bg-light" data-toggle="tooltip" title="Lihat">Lihat</a>
                        <a href="{{ route('user.edit', ['user' => $user->id ]) }}" class="btn bg-light" data-toggle="tooltip" title="Edit">Edit</a>
                        <!-- Button modal trigger-->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-id="" data-target="#hapusData">Hapus</button>
                    </div>
                    
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">Belum ada user</td> 
            </tr>
        @endforelse      

        </tbody>
    </table>
</div>
<!-- END Data table -->

<!-- Modal -->
<div class="modal fade" id="hapusData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        Anda yakin ingin menghapus item ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
        <form action="delete.php" method="post">
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

@endsection