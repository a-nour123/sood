@extends('admin/layouts/contentLayoutMaster')

@section('title', 'Languages')

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

    <style>
       .header-btn {
            float: inline-end;
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
                    @if (auth()->user()->hasPermission('language.create'))
                    <div class="col-sm-6 pe-0" style="text-align: end;">

                        <div class="action-content">

                                    <a  href="{{ route('admin.languages.create') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-plus"></i>
                                    </a>


                        </div>

                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
<div id="quill-service-content" class="d-none"></div>

</div>

    @if (count($languages))
        <div>


            <div>



                <section class=" service-content">
                    <div >
                        <div class="row">
                            <div class="col-12">


                                <div class="card">
                                    <div class="card-body">
                                        <div id="basic-datatable_wrapper"
                                            class="dataTables_wrapper dt-bootstrap4 no-footer">

                                                    <div id="basic-datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100 table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('locale.language_name') }}</th>
                                                            <th>{{ __('locale.locale') }}</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($languages as $language => $name)
                                                            <tr>
                                                                <td>
                                                                    {{ $name }}
                                                                </td>
                                                                <td>
                                                                    <a  href="{{ route('admin.languages.translations.index', $language) }}">
                                                                        {{ $language }}
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{--  </div>  --}}
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->

                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </section>
                <!-- /.content -->



            </div>
        </div>
    @endif

@endsection
