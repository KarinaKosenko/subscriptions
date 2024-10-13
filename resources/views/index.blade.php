<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.components.head')
</head>
<body>
    @include('layout.components.header')
    @yield('content')
    @include('layout.components.footer')
    @include('layout.components.footer-scripts')
</body>
</html>
