@extends('admin.main')

@section('content')
    <div id="app">

        <item-index 
            :user-id="{{ auth()->user()->id }}" 
            item="{{ $item }}" 
            fetch-url="{{ $fetchUrl }}" 
            :table-heading="{{ $tableHeading }}" 
            :item-properties="{{ $itemProperties }}" 
            :search="true" 
            item-identifier="{{ $identifier ?? null }}" 
            name-shown-as="{{ $nameShownAs ?? null }}"
            store-url="{{ $storeUrl ?? null }}"
        >
            <template v-slot:header>
                
                <div class="page-header">
                    <div class="row align-items-center mw-100">

                        <div class="col">
                            <div class="mb-1">
                                @include('admin._breadcrumb')
                            </div>
                            <h1>
                                <span class="text-truncate">{{ ucfirst($item) }}</span>
                            </h1>
                        </div>

                        <div class="col-auto">
                            
                        </div>
                    </div>
                </div>

            </template>
        </item-index>

    </div>
@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush
