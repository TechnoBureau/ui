<!doctype html>
<html lang="en">
@include("includes.header")

<body class="sb-nav-fixed">
    @include("includes.nav")
    <div id="layoutSidenav">
        @if(!isset($view['nav'])) @include("includes.left_nav") @endif
        <div id="layoutSidenav_content">
            @include('includes.message')
            <main class="h-100">
                @yield("content")
            </main>
            @include("includes.footer")
        </div>
    </div>
    @include("includes.footer-scripts")

</body>

</html>
