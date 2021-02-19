@extends('admin.main')

@section('content')

<div id="app">

    @include('admin._item-header')

    <item-tab>
        <tab-details name="Kelas" :selected="true">
            <h2>Daftar Kelas</h2>

            <item-index
                :user-id="{{ auth()->user()->id }}" 
                item="kelas" 
                fetch-url="{{ $fetchUrl }}" 
                :table-heading="{{ $tableHeading }}" 
                :item-properties="{{ $itemProperties }}" 
                item-identifier="{{ $identifier ?? null }}" 
                name-shown-as="Nama"
                store-url="{{ route('admin.grup.kelas.store', ['grup' => $grup->id]) }}"
            ></item-index>
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