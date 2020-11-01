@extends('front.kelas.base')

@section('content')
    <div class="page-header">
        <h2>Anggota</h2>
    </div>
    
    <div class="row">

        @foreach ($people as $member)

        <div class="col-md-6 col-xl-3">
            <div class="card card-sm">
              <div class="card-body">
                <div class="float-left mr-3">
                  <span class="avatar rounded">EP</span>
                </div>
                <div class="lh-sm">
                  <div class="strong">{{ $member->nama }}</div>
                  <div class="text-muted">{{ $member->username }}</div>
                </div>
              </div>
            </div>
        </div>
        
        @endforeach


    </div>
@endsection