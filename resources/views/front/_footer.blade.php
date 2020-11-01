<footer class="footer footer-transparent flex-shrink-0">
    <div class="container">
        <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-lg-auto ml-lg-auto">

            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                Copyright © {{ date('Y') }}
                <a href="{{ route('dashboard') }}" class="link-secondary">{{ settings('app_name') }}</a>.
                All rights reserved.
            </div>
        </div>
    </div>
</footer>