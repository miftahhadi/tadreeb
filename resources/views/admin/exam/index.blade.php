@extends('admin.general.index-items')

@section('pageTitle')
    Pelajaran
@endsection

@section('table')
<table class="table table-vcenter table-hover card-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Judul</th>
        <th>Dibuat oleh</th>
        <th>Role</th>
        <th class="w-1"></th>
      </tr>
    </thead>
    <tbody>

      <tr>
        <td>Paweł Kuna</td>
        <td class="text-muted">
          UI Designer, Training
        </td>
        <td class="text-muted"><a href="#" class="text-reset">paweluna@howstuffworks.com</a></td>
        <td class="text-muted">
          User
        </td>
        <td>
          <a href="#">Edit</a>
        </td>
      </tr>
    
    </tbody>
  </table>

@endsection