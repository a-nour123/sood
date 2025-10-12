<body
    class="vertical-layout vertical-menu-modern {{ $configData['verticalMenuNavbarType'] }} {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }} {{ $configData['sidebarClass']}} {{ $configData['footerType'] }} {{$configData['contentLayout']}}"
    data-open="click" data-menu="vertical-menu-modern"
    data-col="{{$configData['showMenu'] ? $configData['contentLayout'] : '1-column' }}" data-framework="laravel"
    data-asset-path="{{ asset('/') }}">

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }


        .page-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .app-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .content-body {
            margin-top: 20px;
        }
    </style>

    <div class="loader-wrapper">
        <div class="loader"></div>
    </div>

    <!-- BEGIN: Header -->
    <div class="page-wrapper null compact-sidebar compact-small material-icon" id="pageWrapper">
        @include('admin.panels.navbar')
        <!-- END: Header -->

        <!-- BEGIN: Main Menu -->
        @if((isset($configData['showMenu']) && $configData['showMenu'] === true))
            @include('admin.panels.sidebar')
        @endif
        <!-- END: Main Menu -->

        <!-- BEGIN: Content -->
        <div class="app-content content {{ $configData['pageClass'] }}">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>

            @if(($configData['contentLayout'] !== 'default') && isset($configData['contentLayout']))

            <div class="content-wrapper ">
            <div class="page-body-wrapper">
                            <div class="content-body">
                                @yield('content-breadcrumbs-top')
                            </div>
                            </div>
                            </div>



                            <div class="content-area-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : '' }}">
                                <div class="{{ $configData['sidebarPositionClass'] }}" style="
                    margin: 11px;
                ">

                                    <div class="sidebar">

                                        @yield('content-sidebar')
                                    </div>
                                </div>
                                <div class="{{ $configData['contentsidebarClass'] }}">
                                    <div class="content-wrapper">
                                        <div class="content-body" style="margin: 0;">
                                            @yield('content')
                                        </div>
                                    </div>
                                </div>
                            </div>
            @else
                <div class="content-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : '' }}">
                    <div class="page-body-wrapper">
                        {{-- Include Breadcrumb --}}
                        @if($configData['pageHeader'] === true && isset($configData['pageHeader']))
                            @include('admin.panels.breadcrumb')
                        @endif

                        <div class="content-body">
                            {{-- Include Page Content --}}
                            @yield('content')
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <!-- End: Content -->
    </div>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    {{-- Include footer --}}
    @include('admin.panels.footer')

    {{-- Include default scripts --}}
    @include('admin.panels.scripts')

    <script>
        $(window).on('load', function () {
            if (feather) {
                feather.replace({
                    width: 14, height: 14
                });
            }
        });
    </script>

</body>

</html>
