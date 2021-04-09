@extends('front.main')

@section('content')

<div class="row">

    <div class="col-md-2 d-none d-md-block">

        @include('front._sidebar')

    </div>

    <div class="col-md-10 pl-4">
        
        <div class="page-header my-4">
            <h2 class="display-6 font-weight-bold">Marhaban, {{ $user->name }}</h2>
        </div>
                
        @if ($examExist > 0)
        <div class="mt-4">
            <h3 class="h1 mb-0">Ujian Anda</h3>
            <div class="row">

                @foreach ($data as $item)         
                    @foreach ($item['ujian'] as $exam)
                        <div class="col-lg-4 col-md-6 my-3">
                            <div class="card">
                                <div class="card-status-top bg-primary"></div>
                                <div class="card-body">
                                    <div class="text-primary">Kelas: {{ $item['kelas_nama'] }}</div>
                                    <div class="h1 mb-3">{{ $exam['judul'] }}</div>
                                    <div class="d-flex small">
                                        <div class="d-inline-flex flex-column align-items-center mr-2">
                                            <div>
                                                <span class="text-green">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><rect x="9" y="3" width="6" height="4" rx="2" /><path d="M9 14l2 2l4 -4" /></svg>
                                                </span>

                                                <span>Sudah dikerjakan</span>
                                            </div>
                                        </div>
                                        <div class="d-inline-flex align-items-center">
                                            <div>
                                                <span class="text-primary">
                                                    @if ($exam['buka'] == 1)
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="5" y="11" width="14" height="10" rx="2" /><circle cx="12" cy="16" r="1" /><path d="M8 11v-5a4 4 0 0 1 8 0" /></svg>                                                
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="5" y="11" width="14" height="10" rx="2" /><circle cx="12" cy="16" r="1" /><path d="M8 11v-4a4 4 0 0 1 8 0v4" /></svg>
                                                    @endif
                                                </span>
                                                <span>{{ $exam['buka'] == 1 ? 'Terbuka' : 'Ditutup'}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="mr-auto lh-1 text-muted">
                                        {{ $item['grup'] }}
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                    @endforeach     
                @endforeach
                        
            </div>
        </div>
        @endif

    </div>

</div>


@endsection