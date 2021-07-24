<!doctype html>
<html lang="en">
@include("includes.header")

<body class="sb-nav-fixed @if(!isset($view['nav'])) sb-sidenav-toggled @endif">
    @include("includes.nav")
    <div id="layoutSidenav">
        @include("includes.left_nav")
        <div id="layoutSidenav_content">
            @include('includes.message')
	    <main class="h-100">
		@include('includes.breadcrumbs')
                @yield("content")
            </main>
            @include("includes.footer")
        </div>
    </div>
    @include("includes.footer-scripts")

</body>

</html>
