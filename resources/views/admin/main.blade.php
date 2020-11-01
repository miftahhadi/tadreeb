@extends('layouts.base')

@section('main')

<div class="page">

  <div class="content">

    <div class="container d-flex flex-column">
      
      @include('admin._header-nav')

      <div class="row mt-4 flex-grow-1">

        <div class="col-md-2">

          <div class="sticky-top">
            
              @include('admin._sidebar-nav')

          </div>


        </div>

        <div class="col-md-10">

          <div class="container pt-2 pl-4">

            @yield('content')

          </div>

        </div>
      
      </div>
  
    </div>

    @include('admin._footer')

  </div>

</div>

@endsection

@prepend('js')
    <!-- Libs JS -->
    <script src="/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Tabler Core -->
    <script src="/dist/js/tabler.min.js"></script>
@endprepend

@section('area')
    Area Admin
@endsection