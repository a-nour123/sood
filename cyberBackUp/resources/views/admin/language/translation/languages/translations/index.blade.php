@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.translations'))


@section('vendor-style')
<link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">


    <link rel="stylesheet" href="{{ asset('vendor/translation/css/main.css') }}">
    @if (session()->has('locale'))
        @php $local_key = session()->get('locale'); @endphp
    @else
        @php $local_key = app()->getLocale(); @endphp
    @endif

    @if ($local_key == 'ar')
        <style>
            body {
                direction: rtl;

            }

            .cursor-pointer.fill-current {
                margin-left: 0.5rem;
            }
        </style>
    @endif
    <style>
        .panel-body th {
            font-weight: bold;
        }

        .panel-body td,
        .select-group select,
        .panel-header {
            font-weight: 500;
        }

        .panel-body td textarea {
            font-weight: 500;
            color: #44225c;
            font-size: 14px;
        }

        .panel-header .select-group {
            margin: 5px;
        }

        .panel-header {
            background: #44225c;
            border-radius: 15px 15px 0 0;
            color: #FFF !important;
        }

        .button {
            color: #FFF !important;
        }
        ul{
            display: initial;
        }
        nav a{
            opacity: 1;
        }
        nav a:hover {
            opacity: 1;
            text-decoration: none;
        }
    </style>


@endsection


@section('content')

    @php
        $currentLanguage = app()->getLocale();
    @endphp


<div class="content-header row">
    <div class="content-header-left col-12 mb-2">

        <div class="row breadcrumbs-top  widget-grid">
            <div class="col-12">
                <div class="page-title mt-2">
                    <div class="row">
                        <div class="col-sm-6 ps-0">
                            @if (@isset($breadcrumbs))
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                            style="display: flex;">
                                            <svg class="stroke-icon">
                                                <use href="{{ asset('fonts/icons/icon-sprite.svg#stroke-home') }}">
                                                </use>
                                            </svg></a></li>
                                    @foreach ($breadcrumbs as $breadcrumb)
                                        <li class="breadcrumb-item">
                                            @if (isset($breadcrumb['link']))
                                                <a
                                                    href="{{ $breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link'] : url($breadcrumb['link']) }}">
                                            @endif
                                            {{ $breadcrumb['name'] }}
                                            @if (isset($breadcrumb['link']))
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            @endisset
                    </div>
                    <div class="col-sm-6 pe-0" style="text-align: end;">

                        <div class="action-content">

                                    <a  href="{{ route('admin.languages.translations.create', $language) }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-plus"></i>
                                    </a>



                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="quill-service-content" class="d-none"></div>

</div>


    <div id="app">
        <form action="{{ route('admin.languages.translations.index', ['language' => $language]) }}" method="get">

            <div class="panel">

                <div class="panel-header">

                    {{ __('locale.translations') }}

                    <div class="flex flex-grow justify-end items-center">

                        @include('admin.language.translation.forms.search', [
                            'name' => 'filter',
                            'value' => Request::get('filter'),
                        ])

                        @include('admin.language.translation.forms.select', [
                            'name' => 'language',
                            'items' => $languages,
                            'submit' => true,
                            'selected' => $language,
                        ])

                        <div class="sm:hidden lg:flex items-center">

                            @include('admin.language.translation.forms.select', [
                                'name' => 'group',
                                'items' => $groups,
                                'submit' => true,
                                'selected' => Request::get('group'),
                                'optional' => true,
                            ])



                        </div>

                    </div>

                </div>

                <div class="panel-body">

                    @if (count($translations))
                        @php
                            $language_key = request()->segment(3);
                        @endphp
                        <table>

                            <thead>
                                <tr>
                                    <th class="w-1/5 uppercase font-thin">{{ __('locale.group_single') }}</th>
                                    <th class="w-1/5 uppercase font-thin">{{ __('locale.key') }}</th>
                                    {{--  <th class="uppercase font-thin">{{ config('app.locale') }}</th>  --}}
                                    <th class="uppercase font-thin">{{ __('locale.'.$language_key) }}</th>
                                    <th class="uppercase font-thin">{{ $language }}</th>
                                </tr>
                            </thead>

                            <tbody>


                                @foreach ($translations as $type => $items)
                                    @foreach ($items as $group => $translations)
                                        @foreach ($translations as $key => $value)
                                            @if (!is_array($value[$language_key]))
                                                <tr>
                                                    <td>{{ $group }}</td>
                                                    <td>{{ $key }}</td>
                                                    <td>{{ $value[$language_key] }}</td>
                                                    <td>

                                                        <translation-input initial-translation="{{ $value[$language] }}"
                                                            language="{{ $language }}" group="{{ $group }}"
                                                            translation-key="{{ $key }}"
                                                            route="{{ config('translation.ui_url') }}">
                                                        </translation-input>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>

                        </table>

                    @endif

                </div>

            </div>

        </form>

    </div>

@section('vendor-script')
    <script src="{{ asset('/vendor/translation/js/app.js') }}"></script>
@endsection
@endsection
