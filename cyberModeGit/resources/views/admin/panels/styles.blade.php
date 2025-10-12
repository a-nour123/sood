<!-- BEGIN: Vendor CSS-->
@if (session()->has('locale'))
    @php $local_key = session()->get('locale'); @endphp
@else
    @php $local_key = app()->getLocale(); @endphp
@endif

@if ($local_key  == 'ar')

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors-rtl.min.css')) }}" />
@else
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors.min.css')) }}" />
@endif

@yield('vendor-style')
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">
<!-- END: Vendor CSS-->
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('css/base/themes/dark-layout.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('css/base/themes/bordered-layout.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('css/base/themes/semi-dark-layout.css')) }}" />

@php $configData = Helper::applClasses(); @endphp

<!-- BEGIN: Page CSS-->
@if ($configData['mainLayoutType'] === 'horizontal')
    <link rel="stylesheet" href="{{ asset(mix('css/base/core/menu/menu-types/horizontal-menu.css')) }}" />
@else
    <link rel="stylesheet" href="{{ asset(mix('css/base/core/menu/menu-types/vertical-menu.css')) }}" />
@endif

{{-- Page Styles --}}
@yield('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">

<!-- laravel style -->
<link rel="stylesheet" href="{{ asset(mix('css/overrides.css')) }}" />

<!-- BEGIN: Custom CSS-->
<style>
    .notification-unread {
        background-color: #efeded !important;
        opacity: .8;
    }
</style>
@if  ($local_key  == 'ar')
    <link rel="stylesheet" href="{{ asset(mix('css-rtl/custom-rtl.css')) }}" />
    <link rel="stylesheet" href="{{ asset(mix('css-rtl/style-rtl.css')) }}" />
@else
    {{-- user custom styles --}}
    <link rel="stylesheet" href="{{ asset(mix('css/style.css')) }}" />
@endif
<link rel="stylesheet" href="{{ asset('css/overrides_color.css') }}" />


{{--  <link rel="stylesheet" type="text/css" href="{{ asset('new_d/scrollbar.css') }}">  --}}

<!-- Bootstrap css-->
{{--  <link rel="stylesheet" type="text/css" href="{{ asset('new_d/bootstrap.css') }}">  --}}
<!-- App css-->
{{--  <link rel="stylesheet" type="text/css" href="{{ asset('new_d/style.css') }}">  --}}



<link rel="stylesheet" type="text/css" href="{{asset('new_d/css/vendors/flag-icon.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('new_d/css/vendors/slick.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('new_d/css/vendors/slick-theme.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('new_d/css/vendors/scrollbar.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('new_d/css/vendors/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('new_d/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('new_d/css/vendors/datatable/select.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('new_d/css/vendors/prism.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('new_d/css/vendors/vector-map.css')}}">
<!-- Plugins css Ends-->
<!-- Bootstrap css-->
<link rel="stylesheet" type="text/css" href="{{asset('new_d/css/vendors/bootstrap.css')}}">
<!-- App css-->
<link rel="stylesheet" type="text/css" href="{{asset('new_d/css/style.css')}}">
<link id="color" rel="stylesheet" href="{{asset('new_d/css/color-1.css')}}" media="screen">
<!-- Responsive css-->
<link rel="stylesheet" type="text/css" href="{{asset('new_d/css/responsive.css')}}">

<link rel="stylesheet" href="{{ asset('css/release_3.css') }}" />

@if  ($local_key  == 'ar')
<link rel="stylesheet" href="{{ asset('css/rtl.css') }}" />
@endif


<style>
    .stroke-icon {
        width: 24px;
        height: 24px;
        stroke: #000;
    }

    .toggle-sidebar {
        cursor: pointer;
    }

    .status_toggle.middle {
        fill: none;
        stroke: #333;
    }

    .page-wrapper .page-header .header-wrapper .nav-right > ul > li.langdrop::after {
    left: 85px;
}




</style>



