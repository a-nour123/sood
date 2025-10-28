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


@endsection




@section('content')

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



                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="quill-service-content" class="d-none"></div>

</div>

    <div class="">

        <div >



            <form action="{{ route('admin.languages.store') }}" class=" needs-validation p-0" method="post" novalidate>
                @csrf

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    @include('admin.language.translation.forms.text', [
                                        'field' => 'name',
                                        'label' => __('locale.language_name'),
                                    ])

                                    @include('admin.language.translation.forms.text', [
                                        'field' => 'locale',
                                        'label' => __('locale.locale'),
                                        'required' => true,
                                    ])


                                </div>

                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-12">
                        <div class="text-center mb-3">
                            <a href="{{ url('/admin/languages') }}" type="reset"
                                class="btn w-sm btn-light waves-effect">@lang('locale.Cancel')</a>
                            <button type="submit"
                                class="btn w-sm btn-primary waves-effect waves-light">@lang('locale.Save')</button>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </form>



        </div>
    </div>


@section('custom-script')

@endsection
@endsection
