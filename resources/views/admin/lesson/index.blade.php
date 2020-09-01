@extends('admin.general.index-items')

@section('pageTitle')
    Pelajaran
@endsection

@section('table')
<table class="table table-vcenter table-hover card-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Title</th>
        <th>Email</th>
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
      <tr>
        <td>Jeffie Lewzey</td>
        <td class="text-muted">
          Chemical Engineer, Support
        </td>
        <td class="text-muted"><a href="#" class="text-reset">jlewzey1@seesaa.net</a></td>
        <td class="text-muted">
          Admin
        </td>
        <td>
          <a href="#">Edit</a>
        </td>
      </tr>
      <tr>
        <td>Mallory Hulme</td>
        <td class="text-muted">
          Geologist IV, Support
        </td>
        <td class="text-muted"><a href="#" class="text-reset">mhulme2@domainmarket.com</a></td>
        <td class="text-muted">
          User
        </td>
        <td>
          <a href="#">Edit</a>
        </td>
      </tr>
      <tr>
        <td>Dunn Slane</td>
        <td class="text-muted">
          Research Nurse, Sales
        </td>
        <td class="text-muted"><a href="#" class="text-reset">dslane3@epa.gov</a></td>
        <td class="text-muted">
          Owner
        </td>
        <td>
          <a href="#">Edit</a>
        </td>
      </tr>
      <tr>
        <td>Emmy Levet</td>
        <td class="text-muted">
          VP Product Management, Accounting
        </td>
        <td class="text-muted"><a href="#" class="text-reset">elevet4@senate.gov</a></td>
        <td class="text-muted">
          Admin
        </td>
        <td>
          <a href="#">Edit</a>
        </td>
      </tr>
    </tbody>
  </table>
@endsection