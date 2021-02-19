@extends('admin.main')

@section('content')

<div id="app">

    @include('admin._item-header')

    <item-tab>
        <tab-details name="Kelas" :selected="true">
            <h2>Daftar Kelas</h2>
        </tab-details>

        <tab-details name="Item Bersama">
            <h2>Daftar Item Bersama</h2>
        </tab-details>
    </item-tab>

</div>
@endsection


@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush