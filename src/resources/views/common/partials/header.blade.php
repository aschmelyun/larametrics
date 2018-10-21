<div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 order-lg-first">
                <div class="logo">
                    <a href="{{ route('larametrics::metrics.index') }}"><img src="/vendor/larametrics/images/larametrics-logo.svg" height="24"></a>
                </div>
            </div>
            <div class="col-lg">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row justify-content-end">
                    <li class="nav-item">
                        <a href="{{ route('larametrics::metrics.index') }}" class="nav-link{{ str_contains(Request::route()->getName(), 'larametrics::metrics.index') ? ' active' : '' }}"><i class="fe fe-home"></i> Home</a>
                    </li>
                    @if(config('larametrics.logsWatched') || !config('larametrics.hideUnwatchedMenuItems'))
                        <li class="nav-item">
                            <a href="{{ route('larametrics::logs.index') }}" class="nav-link{{ str_contains(Request::route()->getName(), 'larametrics::logs') ? ' active' : '' }}"><i class="fe fe-file-text"></i> Logs</a>
                        </li>
                    @endif
                    @if(count(config('larametrics.modelsWatched')) || !config('larametrics.hideUnwatchedMenuItems'))
                        <li class="nav-item">
                            <a href="{{ route('larametrics::models.index') }}" class="nav-link{{ str_contains(Request::route()->getName(), 'larametrics::models') ? ' active' : '' }}"><i class="fe fe-database"></i> Models</a>
                        </li>
                    @endif
                    @if(config('larametrics.requestsWatched') || !config('larametrics.hideUnwatchedMenuItems'))
                        <li class="nav-item">
                            <a href="{{ route('larametrics::performance.index') }}" class="nav-link{{ str_contains(Request::route()->getName(), 'larametrics::performance') ? ' active' : '' }}"><i class="fe fe-bar-chart-2"></i> Performance</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('larametrics::requests.index') }}" class="nav-link{{ str_contains(Request::route()->getName(), 'larametrics::requests') ? ' active' : '' }}"><i class="fe fe-package"></i> Requests</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('larametrics::notifications.index') }}" class="nav-link{{ str_contains(Request::route()->getName(), 'larametrics::notifications') ? ' active' : '' }}"><i class="fe fe-bell"></i> Notifications</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>