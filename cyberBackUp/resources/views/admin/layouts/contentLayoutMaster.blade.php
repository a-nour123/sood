@isset($pageConfigs)
    {!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
@php
    $configData = Helper::applClasses();
@endphp

@if (session()->has('locale'))
    @php $local_key = session()->get('locale'); @endphp
@else
    @php $local_key = app()->getLocale(); @endphp
@endif


<html class="loading {{ $configData['theme'] === 'light' ? '' : $configData['layoutTheme'] }}"
    lang="@if (session()->has('locale')) {{ session()->get('locale') }}@else{{ $configData['defaultLanguage'] }} @endif"
    data-textdirection="{{ $local_key == 'ar' ? 'rtl' : 'ltr' }}"
    @if ($configData['theme'] === 'dark') data-layout="dark-layout" @endif>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="locale" content="{{ app()->getLocale() }}" />
    <meta name="description" content="{{ getSystemSetting('APP_NAME', 'GRC') }} ">
    <meta name="keywords" content="PK, {{ getSystemSetting('APP_NAME', 'GRC') }}, governance, risk, compliance">
    <meta name="author"
        content="{{ session()->get('locale') == 'ar' ? getSystemSetting('APP_AUTHOR_AR', 'Cyber Mode') : getSystemSetting('APP_AUTHOR_EN', 'Cyber Mode') }}">
    <title>@yield('title') - {{ getSystemSetting('APP_NAME', 'GRC') }}</title>
    <link rel="apple-touch-icon" href="{{ asset(getSystemSetting('APP_FAVICON')) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(getSystemSetting('APP_FAVICON')) }}">

    {{-- Include core + vendor Styles --}}
    @include('admin.panels.styles')

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
@isset($configData['mainLayoutType'])
    @extends($configData['mainLayoutType'] != 'horizontal' ? 'admin.layouts.horizontalLayoutMaster' : 'admin.layouts.verticalLayoutMaster')
@endisset
