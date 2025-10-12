@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
@php $configData = Helper::applClasses(); @endphp

<html class="loading {{($configData['theme'] === 'light') ? '' : $configData['layoutTheme'] }}"
lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif"
data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}"
@if($configData['theme'] === 'dark') data-layout="dark-layout"@endif>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="description" content="{{ getSystemSetting('APP_NAME', "GRC") }}">
  <meta name="keywords" content=" {{ getSystemSetting('APP_NAME', "GRC") }}, governance, risk, compliance">
  <meta name="author" content="{{ session()->get('locale') == 'ar' ? getSystemSetting('APP_AUTHOR_AR', 'Cyber Mode') : getSystemSetting('APP_AUTHOR_EN', 'Cyber Mode') }}">
  <title>@yield('title') - {{ getSystemSetting('APP_NAME', "GRC") }}</title>
  <link rel="apple-touch-icon" href="{{asset(getSystemSetting('APP_FAVICON'))}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{asset(getSystemSetting('APP_FAVICON'))}}">


  {{-- Include core + vendor Styles --}}
  @include('admin.panels.styles')

  {{-- Include core + vendor Styles --}}
  @include('admin.panels.styles')
</head>



<body class="vertical-layout vertical-menu-modern {{ $configData['bodyClass'] }} {{($configData['theme'] === 'dark') ? 'dark-layout' : ''}} {{ $configData['blankPageClass'] }} blank-page"
data-menu="vertical-menu-modern"
data-col="blank-page"
data-framework="laravel"
data-asset-path="{{ asset('/')}}">

  <!-- BEGIN: Content-->
  <div class="app-content content {{ $configData['pageClass'] }}">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>

    <div class="content-wrapper">
      <div class="content-body">

        {{-- Include Startkit Content --}}
        @yield('content')

      </div>
    </div>
  </div>
  <!-- End: Content-->

  {{-- include default scripts --}}
  @include('admin.panels.scripts')

  <script>
    $(window).on('load', function() {
      if (feather) {
        feather.replace({
          width: 14,
          height: 14
        });
      }
    })
  </script>

</body>

</html>

