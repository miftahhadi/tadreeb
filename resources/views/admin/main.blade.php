@extends('layouts.base')

@section('main')

<div class="page">

  <div class="content">

    <div class="container d-flex flex-column">
      <header class="navbar navbar-expand-md pb-2 border-bottom row">
          <div class="container-xl">
            
            @include('admin._header-nav')

          </div>
      </header>

  
      <div class="row mt-4 flex-grow-1">

        <div class="col-md-2">

          <div>
            
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

    <footer class="footer footer-transparent flex-shrink-0">
      @include('admin._footer')
    </footer>

  </div>

</div>

@endsection

@section('js')
    <!-- Libs JS -->
    <script src="/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js"></script>
@endsection