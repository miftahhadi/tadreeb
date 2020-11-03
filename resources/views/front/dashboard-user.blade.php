@extends('front.main')

@section('content')

<div class="row">

    <div class="col-md-2 d-none d-md-block">

        @include('front._sidebar')

    </div>

    <div class="col-md-10 pl-4">
        
        <div class="page-header mb-4">
            <h2 class="display-6 font-weight-bold">Marhaban, {{ auth()->user()->nama }}</h2>
        </div>
        
        <div>
            <h3 class="h2 font-weight-bolder">Pelajaran Anda</h3>
            <div class="row row-deck">
                <div class="col-md-3">
        
                    <div class="card">
                        <img src="/images/beautiful.jpg" class="card-img-top" alt="Card top image">
                        <div class="card-body">
                            <h3 class="font-weight-bold">Card with title and image</h3>
                        </div>
                        <div class="card-footer">
                            Kelas Nahwu Dasar 1
                        </div>
                    </div>
            
                </div>
        
                <div class="col-md-3">
        
                    <div class="card">
                        <img src="/images/beautiful.jpg" class="card-img-top" alt="Card top image">
                        <div class="card-body">
                            <h3 class="font-weight-bold">Card with title and image</h3>
                        </div>
                        <div class="card-footer">
                            Kelas Nahwu Dasar 1
                        </div>
                    </div>
            
                </div>
        
                <div class="col-md-3">
        
                    <div class="card">
                        <img src="/images/beautiful.jpg" class="card-img-top" alt="Card top image">
                        <div class="card-body">
                            <h3 class="font-weight-bold">Card with title and image</h3>
                        </div>
                        <div class="card-footer">
                            Kelas Nahwu Dasar 1
                        </div>
                    </div>
            
                </div>
        
        
            </div>
        </div>
        
        <div class="mt-4">
            <h3 class="h2 font-weight-bolder">Ujian Anda</h3>
            <div class="row row-deck">
                
                <div class="col-lg-4 col-md-6">
        
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
        
                                <div class="col-auto m-0">
                                    <span class="bg-primary text-white stamp p-0">
                                        <i class="fas fa-file-alt"></i>
                                    </span>
                                </div>
        
                                <div class="col">
                                    <a href="#" class="stretched-link"><h3 class="m-0">Ujian Nahwu Dasar</h3></a>
        
        
                                    <span class="badge bg-success">Terbuka</span>
        
                                    {{-- <span class="badge bg-danger">Tertutup</span> --}}
        
                                </div>     
                                                        
                            </div>
                                                
                        </div>
        
                        <div class="card-footer">
                            Kelas: Nahwu Dasar
                        </div>
                    </div>
        
                </div>
        
                <div class="col-lg-4 col-md-6">
        
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
        
                                <div class="col-auto m-0">
                                    <span class="bg-primary text-white stamp p-0">
                                        <i class="fas fa-file-alt"></i>
                                    </span>
                                </div>
        
                                <div class="col">
                                    <a href="#" class="stretched-link"><h3 class="m-0">Ujian Nahwu Dasar</h3></a>
        
        
                                    <span class="badge bg-success">Terbuka</span>
        
                                    {{-- <span class="badge bg-danger">Tertutup</span> --}}
        
                                </div>     
                                                        
                            </div>
                                                
                        </div>
        
                        <div class="card-footer">
                            Kelas: Nahwu Dasar
                        </div>
                    </div>
        
                </div>
        
                <div class="col-lg-4 col-md-6">
        
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
        
                                <div class="col-auto m-0">
                                    <span class="bg-primary text-white stamp p-0">
                                        <i class="fas fa-file-alt"></i>
                                    </span>
                                </div>
        
                                <div class="col">
                                    <a href="#" class="stretched-link"><h3 class="m-0">Ujian Nahwu Dasar</h3></a>
        
        
                                    <span class="badge bg-success">Terbuka</span>
        
                                    {{-- <span class="badge bg-danger">Tertutup</span> --}}
        
                                </div>     
                                                        
                            </div>
                                                
                        </div>
        
                        <div class="card-footer">
                            Kelas: Nahwu Dasar
                        </div>
                    </div>
        
                </div>
                
            </div>
        </div>

    </div>

</div>


@endsection