@extends('admin.main')

@section('content')

<div id="app">

    @include('admin._item-header')

    <item-tab>
        <tab-details name="Kelas" :selected="true">
            <item-index
                :user-id="{{ auth()->user()->id }}" 
                :parent-id="{{ $grup->id }}"
                item="kelas" 
                fetch-url="{{ $fetchUrl }}" 
                :table-heading="{{ $tableHeading }}" 
                :item-properties="{{ $itemProperties }}" 
                item-identifier="{{ $identifier ?? null }}" 
                name-shown-as="Nama"
                store-url="{{ '/api/grup/' . $grup->id . '/kelas' }}"
                delete-url="{{ '/api/grup/' . $grup->id . '/kelas'}}"
                base-url="/admin/grup/{{ $grup->id }}/kelas/"
            ></item-index>
        </tab-details>

        <tab-details name="Item Bersama">
            ** Coming Soon **
        </tab-details>

        <tab-details name="Pengaturan">
            ** Coming Soon ** 
        </tab-details>
    </item-tab>

</div>
@endsection


@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush