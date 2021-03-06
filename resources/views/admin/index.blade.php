@extends('layouts.admin')

@section('page')
<!-- Page Title and Stuffs -->
<div class="page-header">
  <h3 class="page-title">Mata Pelajaran</h3>
  <div class="page-options d-flex">
    <a href="#" class="btn btn-square btn-secondary ml-auto"><i class="fa fa-plus-square"></i> Tambah Baru</a>
    <div class="ml-2">
        <a href="#" class="btn btn-square btn-secondary ml-auto"><i class="fa fa-upload"></i> Import dari CSV</a>
    </div>
  </div>
</div>
<!-- END Page Title and Stuffs -->
<!-- Data table -->
<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th width="5%">#</th>
                <th>Mata Pelajaran</th>
                <th>Kategori</th>
                <th width="14%" class="ml-auto"></th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Nahwu 1</td>
                    <td>Kelas Dasar</td>
                    <td>
                    <a href="#" class="btn bg-blue-lightest btn-xs" data-toggle="tooltip" title="Susun"><i class="fe fe-package"></i></a>
                    <a href="#" class="btn bg-blue-lightest btn-xs" data-toggle="tooltip" title="Edit"><i class="fe fe-edit"></i></a>
                    <!-- Button modal trigger-->
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-id="" data-target="#hapusData"><i class="fe fe-trash-2" data-toggle="tooltip" title="Hapus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Nahwu 2</td>
                    <td>Kelas Dasar</td>
                    <td>
                    <a href="#" class="btn bg-blue-lightest btn-xs" data-toggle="tooltip" title="Susun"><i class="fe fe-package"></i></a>
                    <a href="#" class="btn bg-blue-lightest btn-xs" data-toggle="tooltip" title="Edit"><i class="fe fe-edit"></i></a>
                    <!-- Button modal trigger-->
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-id="" data-target="#hapusData"><i class="fe fe-trash-2" data-toggle="tooltip" title="Hapus"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
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