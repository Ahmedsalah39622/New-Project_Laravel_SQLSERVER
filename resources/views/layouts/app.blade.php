<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Dashboard')</title>
    @include('layouts.sections.styles')
</head>
<body>
    <?php
    $configData = Helper::appClasses(); ?>
    <div class="container">
        @yield('content')
    </div>
    @include('layouts.sections.scripts')
</body>
</html>
