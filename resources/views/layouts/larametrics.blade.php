<!DOCTYPE html>
<html lang="en_US">

<head>
    <title>[LM] @yield('title')</title>
    <link href="/vendor/larametrics/app.css" rel="stylesheet">
    @stack('head')
</head>

<body class="bg-gray-100 text-gray-500 antialiased">
    @include('larametrics::partials.logo')
    <div class="max-w-screen-lg mx-auto py-8">
        @include('larametrics::partials.header')
        <main>
            @yield('content')
        </main>
    </div>
    @stack('footer')
</body>

</html>