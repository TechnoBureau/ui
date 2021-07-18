<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="{{ url('/') }}">Product Name</a>
    @if(isset($view['nav']))
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
        <span class="navbar-toggler-icon"></span>
    </button>
    @endif
    
    @include("includes.search")
    @include("includes.auth")
</nav>
