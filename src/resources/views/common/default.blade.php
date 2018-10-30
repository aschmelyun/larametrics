<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    @include('larametrics::common.partials.head')
</head>

<body class="larametrics">
    <div class="page">
        <div class="page-main">
            @include('larametrics::common.partials.header')
            <div class="my-3 my-md-5">
                <div class="container">
                    <div class="page-header">
                        <h1 class="page-title">{{ $pageTitle ?: 'Page Title Goes Here' }}</h1>
                        @if(isset($pageSubtitle))
                            <div class="text-muted mb-0 ml-4">{{ $pageSubtitle }}</div>
                        @endif
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
        @include('larametrics::common.partials.footer')
    </div>
</body>

</html>