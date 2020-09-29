@extends('admin.main')

@section('content')

    <div class="page-header">
        <h2 class="page-title">Pengaturan</h2>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    
@endsection