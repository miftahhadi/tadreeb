@extends('admin.main')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-auto">
                <h3 class="h1 mt-0 mb-3">Impor User dari File CSV</h3>
            </div>
        </div>
    </div>

    <div id="app">

        <import-user
            :fields="{{ $fields }}"
            :data-to-show="{{ $dataToShow }}"
            :id="{{ $csvDataFile->id }}"
        ></import-user>

        {{-- <form action="{{ route('admin.user.processCsv') }}" method="post">
            @csrf

            <input type="hidden" name="id" value="{{ $csvDataFile->id }}">
        
            <div class="card">
    
                <div class="card-body">
                    <p class="mb-1">Periksa data yang akan diimpor apakah sudah sesuai dengan urutan yang ada di sistem</p>
                    
                    <div class="table-responsive">
                        <table class="table table-vcenter">
    
                            <thead>
    
                                @foreach ($fields as $field)
                                    <th>{{ $field }}</th>                                    
                                @endforeach
    
                            </thead>
    
                            <tbody>
    
                                @foreach ($dataToShow as $row)
                                    <tr>
                                        
                                        @foreach ($row as $key => $value)
                                            <td>{{ $value }}</td>                                            
                                        @endforeach
        
                                    </tr>
                                @endforeach
    
                            </tbody>
                        </table>    
                    </div>
                
                </div>
            </div>
    
            <div class="btn-list">
    
                <a href="{{ route('admin.user.index') }}" class="btn btn-secondary mr-1">Batal</a>
    
                <input type="submit" value="Simpan" class="btn btn-success">
                
            </div>

        </form> --}}

    </div>

@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush