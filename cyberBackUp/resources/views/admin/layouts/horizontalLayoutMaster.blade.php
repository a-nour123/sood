<body class="horizontal-layout horizontal-menu {{$configData['contentLayout']}} {{$configData['horizontalMenuType']}} {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }} {{ $configData['footerType'] }}" data-open="hover" data-menu="horizontal-menu" data-col="{{$configData['showMenu'] ? $configData['contentLayout'] : '1-column' }}" data-framework="laravel" data-asset-path="{{ asset('/')}}">

    <!-- BEGIN: Header-->
    @include('admin.panels.navbar')

    {{-- Include Sidebar --}}
    @if((isset($configData['showMenu']) && $configData['showMenu'] === true))
    @include('admin.panels.horizontalMenu')
    @endif

    <!-- BEGIN: Content-->
    <div class="app-content content {{$configData['pageClass']}}">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        @if(($configData['contentLayout']!=='default') && isset($configData['contentLayout']))
        <div class="content-area-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : '' }}">
            <div class="{{ $configData['sidebarPositionClass'] }}">
                <div class="sidebar">
                    {{-- Include Sidebar Content --}}
                    @yield('content-sidebar')
                </div>
            </div>
            <div class="{{ $configData['contentsidebarClass'] }}">
                <div class="content-wrapper">
                    <div class="content-body">
                        {{-- Include Page Content --}}
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="content-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : '' }}">
            {{-- Include Breadcrumb --}}
            @if($configData['pageHeader'] == true)
            @include('admin.panels.breadcrumb')
            @endif

            <div class="content-body">

                {{-- Include Page Content --}}
                @yield('content')

            </div>
        </div>
        @endif

    </div>
    <!-- End: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    {{-- include footer --}}
    @include('admin.panels.footer')

    {{-- include default scripts --}}
    @include('admin.panels.scripts')

    <script>
        let appContentDefaultPaddingTopValue = 170.8; // for solve issue set value may be null by default
        var detectHorizontalMenuWrapLines = function(className) {

            let yAccess = new Set();
            var items = document.querySelectorAll(className);

            for (var i = 0; i < items.length; i++) {
                yAccess.add(items[i].getBoundingClientRect().top);
            };

            if (items.length > 0)
                return {
                    count: yAccess.size
                    , height: items[0].getBoundingClientRect().height
                };
            else
                return false;
        }

        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14
                    , height: 14
                });
            }

            const appContentPaddingTop = $('.horizontal-layout.navbar-floating:not(.blank-page) .app-content').css('padding-top'); // Get app content top padding value
            let appContentPaddingTopValue = parseFloat(appContentPaddingTop.slice(0, appContentPaddingTop.length - 2)).toFixed(1); // remove last 2 letters (px)
            if (appContentDefaultPaddingTopValue === null || appContentDefaultPaddingTopValue < 80) {
                appContentDefaultPaddingTopValue = appContentPaddingTopValue;
            }

            // changeFrameTitle();
            var iframe = document.querySelector('frame');
            if (iframe) {
                document.title= iframe.contentWindow.document.title;
            }
        });

        function recalculateAppMenuPadding() {
            var wrappedItems = detectHorizontalMenuWrapLines('.horizontal-menu-wrapper .header-navbar.navbar-expand-sm.navbar.navbar-horizontal.navbar-shadow.menu-border .navbar-container.main-menu-content ul.nav.navbar-nav li.nav-item');

            if (wrappedItems === false)
                return;

            if (wrappedItems.count > 5) {
                wrappedItems = detectHorizontalMenuWrapLines('.horizontal-menu-wrapper .header-navbar.navbar-expand-sm.navbar.navbar-horizontal.navbar-shadow.menu-border .navbar-container.main-menu-content ul.nav.navbar-nav li.nav-item');
                return;
            }
            const appContentPaddingTop = $('.horizontal-layout.navbar-floating:not(.blank-page) .app-content').css('padding-top'); // Get app content top padding value
            let appContentPaddingTopValue = parseFloat(appContentPaddingTop.slice(0, appContentPaddingTop.length - 2)).toFixed(1); // remove last 2 letters (px)
            if (appContentDefaultPaddingTopValue === null || appContentDefaultPaddingTopValue < 80) {
                appContentDefaultPaddingTopValue = appContentPaddingTopValue;
            }

            let addedPaddingValue = ((wrappedItems.count - 1) * wrappedItems.height).toFixed(1);

            $('.horizontal-layout.navbar-floating:not(.blank-page) .app-content').css('padding-top', `${(parseFloat(appContentDefaultPaddingTopValue) + parseFloat(addedPaddingValue)).toFixed(1)}px`);
        }

        window.onresize = function(event) {
            $.app.menu.changeMenu(Unison.fetch.now().name);
        };

        
        // <frame onload="var iframe = document.querySelector('frame'); if (iframe) { document.title= iframe.contentWindow.document.title;}">
        /* function changeFrameTitle() { // called every time frame is loaded (<frame onload="changeFrameTitle();">)
            var iframe = document.querySelector('frame');
            if (iframe) {
                $('title').text = iframe.contentWindow.document.title;
            }
        } */

    </script>
</body>

</html>
