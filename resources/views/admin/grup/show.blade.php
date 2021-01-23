@extends('admin.main')

@section('content')

<div id="app">

    @include('admin._item-header')

    <div class="row">
        <div class="col-auto">
            <h2>Daftar Kelas</h2>
        </div>    
        <div class="col-auto ml-auto">
    
            <button type="button" 
                    class="btn" 
                    data-toggle="modal" 
                    data-target="#tambahBaru">
                
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                </span> 
                
                Buat Kelas Baru
            </button>  
    
        </div>
    </div>

</div>
@endsection


@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush