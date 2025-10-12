@extends('admin/layouts/contentLayoutMaster')

@section('title', __('asset.Assets'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
@endsection

@section('page-style')
    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <style>
        .error {
            color: red !important;
            font-size: 14px;
            display: block;
            margin-top: 5px;
        }

        /* Chat Form Inline Styling */
        .chat-app-form {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        .form-send-message {
            flex: 1;
            margin-right: 0 !important;
        }

        .chat-app-form .btn.send {
            flex-shrink: 0;
            min-width: 50px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 0;
        }

        /* Ensure input group takes full available width */
        .input-group-merge {
            width: 100%;
        }

        /* Optional: Adjust input height to match button */
        .form-send-message .form-control {
            height: 38px;
        }

        /* Mobile responsive adjustments */
        @media screen and (max-width: 768px) {
            .chat-app-form {
                padding: 10px;
                gap: 8px;
            }

            .chat-app-form .btn.send {
                min-width: 45px;
                height: 36px;
            }

            .form-send-message .form-control {
                height: 36px;
                font-size: 14px;
            }
        }

        /* Ensure the attachment icon doesn't interfere with layout */
        .attachment-icon {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Optional: Add some visual improvements */
        .chat-app-form .btn.send:hover {
            transform: translateY(-1px);
            transition: transform 0.2s ease;
        }

        .chat-app-form .btn.send:active {
            transform: translateY(0);
        }
    </style>
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

                            <div class="action-content">
                                @if (auth()->user()->hasPermission('asset.create'))
                                    <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-new-asset">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a href="{{ route('admin.asset_management.notificationsSettingsActiveAsset') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                @endif
                                @if (auth()->user()->hasPermission('asset.export'))
                                    <button id="openexportAssetModal" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exportAssetModal">
                                        <i class="fa-solid fa-file-export"></i>
                                    </button>
                                @endif

                                @if (auth()->user()->hasPermission('asset.create'))
                                    <a href="{{ route('admin.asset_management.import') }}"
                                        class="dt-button btn btn-primary" target="_self">
                                        <i class="fa-solid fa-file-import"></i> </a>
                                @endif

                                <div class="btn-group dropdown dropdown-icon-wrapper">
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown" aria-expanded="false"
                                        style="border-radius: 8px !important;
                                        width: 40px;
                                        text-align: center;
                                        color: #FFF !important;
                                        height: 32px;
                                        line-height: 19px;">
                                        <i class="fa fa-solid fa-gear"></i>
                                    </button>
                                    @if (auth()->user()->hasPermission('asset.configuration') || auth()->user()->hasPermission('asset.asset_value'))
                                        <div class="dropdown-menu dropdown-menu-end export-types  ">
                                            @if (auth()->user()->hasPermission('asset.configuration'))
                                                <span class="dropdown-item" data-type="excel">
                                                    <i class="fa fa-solid fa-gear"></i>
                                                    <span class="px-1 text-start"><a
                                                            href="{{ route('admin.asset_management.configuretion') }}">{{ __('configuretion') }}</a></span>

                                                </span>
                                            @endif
                                            @if (auth()->user()->hasPermission('asset.asset_value'))
                                                <span class="dropdown-item" data-type="excel">
                                                    <i class="fa fa-solid fa-gear"></i>
                                                    <span class="px-1 text-start"><a
                                                            href="{{ route('admin.asset_management.asset_value_settings') }}">{{ __('locale.AssetValueManagement') }}</a></span>

                                                </span>
                                            @endif

                                        </div>
                                    @endif
                                </div>


                                <a class="btn btn-primary"
                                    href="{{ route('admin.asset_management.ajax.statistics.asset') }}"> <i
                                        class="fa-solid fa-file-invoice"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

</div>

<div class="card">
    <div class="card-header border-bottom p-1">
        <div class="head-label">
            <h4 class="card-title">{{ __('locale.Asset_Summary') }}</h4>
        </div>
    </div>

    <div class="row status-row mb-3">
        <div class="status col-12 d-flex flex-wrap justify-content-md-around">
            <!-- Status Card: Overview -->
            <div class="col-md-4">
                <div class="card widget-1" style="background-image:url('images/widget-bg.png'); position: relative;">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round secondary">
                                <div class="bg-round">
                                    <i style="font-size:20px; color:rgb(46, 46, 45)" data-feather="minus-circle"></i>
                                </div>
                            </div>
                            <div>
                                <h4 style="color:rgb(46, 46, 45)">{{ $assetStatistic['assetCount'] ?? 0 }}</h4>
                                <span class="f-light"
                                    style="color:rgb(46, 46, 45)">{{ __('locale.total_assets') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Card: Critical Vulnerabilities -->
            <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                <div class="card widget-1" style="background-image:url('images/widget-bg.png')">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round secondary">
                                <div class="bg-round">
                                    <i style="font-size:20px; color:red" data-feather="x-circle"></i>
                                </div>
                            </div>
                            <div>
                                <h4 style="color:red">{{ $assetStatistic['assetsWithCriticalVulnsCount'] ?? 0 }}</h4>
                                <span class="f-light"
                                    style="color:red">{{ __('locale.assets_with_critical_vulns') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Card: Asset Groups -->
            <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                <div class="card widget-1" style="background-image:url('images/widget-bg.png')">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round secondary">
                                <div class="bg-round">
                                    <i style="font-size:20px; color:rgb(165, 165, 192)" data-feather="archive"></i>
                                </div>
                            </div>
                            <div>
                                <h4 style="color:rgb(165, 165, 192)">{{ $assetStatistic['assetGroupCount'] ?? 0 }}
                                </h4>
                                <span class="f-light"
                                    style="color:rgb(165, 165, 192)">{{ __('locale.asset_groups') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>







<!-- Advanced Search -->
<x-asset-search id="advanced-search-datatable" :assetValues="$assetValues" :assetCategories="$assetCategories" :locations="$locations" :regions="$regions"
    :users="$users" createModalID="add-new-asset" />
<!--/ Advanced Search -->

<!-- Create Form -->
@if (auth()->user()->hasPermission('asset.create'))
    <x-asset-form id="add-new-asset" title="{{ __('locale.AddANewAsset') }}" :assetValues="$assetValues" :assetCategories="$assetCategories"
        :assetEnvironmentCategories="$assetEnvironmentCategories" :locations="$locations" :teams="$teams" :tags="$tags" :users="$users" :regions="$regions"
        :operatingSystems="$operatingSystems" />

@endif
<!--/ Create Form -->

<!-- Update Form -->
@if (auth()->user()->hasPermission('asset.update'))
    <x-asset-form id="edit-asset" title="{{ __('locale.Edit Assets') }}" :assetValues="$assetValues" :assetCategories="$assetCategories"
        :assetEnvironmentCategories="$assetEnvironmentCategories" :locations="$locations" :teams="$teams" :tags="$tags" :users="$users"
        :regions="$regions" :operatingSystems="$operatingSystems" />
@endif
<!--/ Update Form -->


<div class="modal fade" id="exampleModalLong" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="modal-body">

                    <section class="modern-horizontal-wizard">
                        <div class="bs-stepper wizard-modern modern-wizard-example">
                            <div class="bs-stepper-header">
                                @foreach ($assetValueCategories as $category)
                                    <div class="step" data-target="#asset-value-{{ $category->id }}"
                                        role="tab" id="asset-value-{{ $category->id }}-trigger">
                                        <button type="button" class="step-trigger">
                                            <span class="bs-stepper-box">
                                                <i data-feather="file-text" class="font-medium-3"></i>
                                            </span>
                                            <span class="bs-stepper-label">
                                                <span class="bs-stepper-title">{{ $category->name }}</span>

                                            </span>
                                        </button>
                                    </div>

                                    @if (!$loop->last)
                                        <div class="line">
                                            <i data-feather="chevron-right" class="font-medium-2"></i>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                            <div class="bs-stepper-content">

                                @foreach ($assetValueCategories as $category)
                                    <div id="asset-value-{{ $category->id }}"
                                        class="content category-content @if ($category->type == 1) category-avg-content @endif"
                                        role="tabpanel" aria-labelledby="asset-value-{{ $category->id }}-trigger">
                                        <div class="content-header">
                                            <h5 class="mb-0">{{ $category->name }}</h5>

                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                @foreach ($category->questions as $question)
                                                    <div class="row category-row">
                                                        <div class="mb-1 col-md-5">
                                                            <input type="text" class="form-control"
                                                                value="{{ $question->question }}" id=""
                                                                readonly>
                                                        </div>
                                                        @if ($category->type == 0)
                                                            <div class="mb-1 col-md-5">
                                                                <select class="select2 w-100 select-item">
                                                                    <option value="0">{{ __('locale.No') }}
                                                                    </option>
                                                                    <option value="1">{{ __('locale.Yes') }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-1 col-md-1">
                                                                <input type="text"
                                                                    class="form-control select-item-value"
                                                                    value="0" readonly>
                                                            </div>
                                                        @else
                                                            <div class="mb-1 col-md-6">
                                                                <select class="select2 w-100 select-item">
                                                                    @foreach (json_decode($question->answers, true) as $answer)
                                                                        <option value="{{ $answer['value'] }}">
                                                                            {{ $answer['answer'] }}</option>
                                                                        @if ($loop->first)
                                                                            @php
                                                                                $firstValue = $answer['value'];
                                                                            @endphp
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="mb-1 col-md-1">
                                                                <input type="text"
                                                                    class="form-control select-item-value"
                                                                    value="{{ $firstValue }}" readonly>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7">
                                                <input type="hidden" class="total-category-input-number">
                                                <div class="alert alert-primary p-2 total-category-number"
                                                    role="alert">
                                                    {{ __('locale.Total') }} ( {{ $category->name }} )
                                                    {{ __('locale.Number') }} : <span> </span>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($loop->last)
                                            <div class="row">
                                                <div class="col-7">
                                                    <input type="hidden" class="return-total-impact-input-number">
                                                    <div class="alert alert-primary p-2 total-impact-input-number"
                                                        role="alert">
                                                        {{ __('locale.businessImpactAnalysis') }} : <span> ( 0 )
                                                        </span>
                                                    </div>
                                                    <div class="alert alert-danger p-2 check-valid-impact d-none"
                                                        role="alert">
                                                        <span> {{ __('locale.not_invaild_value_please_check_again') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif


                                        <div class="d-flex justify-content-between">
                                            @if ($loop->first)
                                                <button class="btn btn-outline-secondary btn-prev" disabled>
                                                    <i data-feather="arrow-left"
                                                        class="align-middle me-sm-25 me-2"></i>
                                                    <span
                                                        class="align-middle d-sm-inline-block d-none">{{ __('locale.Previous') }}
                                                    </span>
                                                </button>
                                            @else
                                                <button class="btn btn-primary btn-prev">
                                                    <i data-feather="arrow-left"
                                                        class="align-middle me-sm-25 me-2"></i>
                                                    <span
                                                        class="align-middle d-sm-inline-block d-none">{{ __('locale.Previous') }}
                                                    </span>
                                                </button>
                                            @endif
                                            @if ($loop->last)
                                                <button
                                                    class="btn btn-primary  category-impact-submit">{{ __('locale.Save') }}
                                                </button>
                                            @else
                                                <button class="btn btn-primary btn-next">
                                                    <span
                                                        class="align-middle d-sm-inline-block d-none">{{ __('locale.Next') }}
                                                    </span>
                                                    <i data-feather="arrow-right"
                                                        class="align-middle ms-sm-25 ms-0"></i>
                                                </button>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                    </section>

                </div>

            </div>

        </div>
    </div>
</div>


<!-- // Asset Comments Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal"
    aria-hidden="true" id="assetCommentsModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myExtraLargeModal">{{ __('locale.Comments') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- <div class="modal modal-slide-in sidebar-todo-modal fade" id="assetCommentsModal" role="dialog">
    <div class="modal-dialog sidebar-lg"> -->
            <div class="modal-content p-0">


                <!-- <div class="modal-header align-items-center mb-1">
                <h5 class="modal-title">{{ __('locale.Comments') }}</h5>
                <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                    <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                </div>
            </div> -->

                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                    <div id="chat-container">
                        <!-- Main chat area -->
                        <section class="chat-app-window">
                            <!-- To load Conversation -->

                            <!--/ To load Conversation -->
                            <!-- Active Chat -->
                            @if (auth()->user()->role->name == 'Administrator')
                                <div class="text-center mb-1">
                                    <a href="javascript:" class="btn btn-danger clearCommentsBtn"
                                        title="Clear Comments">
                                        {{ __('governance.ClearComments') }}
                                    </a>
                                </div>
                            @endif
                            <div class="active-chat">
                                <!-- User Chat messages -->
                                <div class="user-chats">
                                    <div class="chats">
                                    </div>
                                </div>
                                <!-- User Chat messages -->
                                <p class="my-0 mx-2 file-name"
                                    data-content="{{ __('locale.FileName', ['name' => '']) }}">
                                </p>
                                <!-- Submit Chat form -->
                                <form class="chat-app-form" id="chat-app-form" action="javascript:void(0);"
                                    onsubmit="enterChat('#assetCommentsModal');">
                                    @csrf
                                    <input type="hidden" name="asset_id" />
                                    <div class="input-group input-group-merge me-1 form-send-message">
                                        <input type="text" class="form-control message" name ="comment"
                                            placeholder="{{ __('locale.TypeYourComment') }}" />
                                        <span class="input-group-text" title="hhhh">
                                            <label for="attach-doc" class="attachment-icon form-label mb-0">
                                                <i data-feather="file" class="cursor-pointer text-secondary"></i>
                                                <input name="comment_file" type="file" class="attach-doc"
                                                    id="attach-doc" hidden /> </label></span>
                                    </div>
                                    <button type="submit" class="btn btn-primary send">
                                        {{-- <i data-feather="send" class="d-lg-none"></i> --}}
                                        <i data-feather="send"></i>
                                        {{-- <span class="d-none d-lg-block">Send</span> --}}
                                    </button>
                                </form>
                                <!--/ Submit Chat form -->
                            </div>
                            <!--/ Active Chat -->
                        </section>
                        <!--/ Main chat area -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('vendor-script')
<script src="{{ asset('js/scripts/components/components-dropdowns-font-awesome.js') }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
<script src="{{ asset('ajax-files/asset_management/asset/app-chat.js') }}"></script>
<script>
    var assetValueLevels = {!! json_encode($assetValueLevels->toArray()) !!};

    $(document).on('change', '.select-item', function() {
        $(this).parents('.category-row').find('.select-item-value').val($(this).val());
        updateCategoryTotalNumber($(this));
        totalImpactNumber();
    });

    function totalImpactNumber() {
        var maxVal = 0;
        $('.total-category-input-number').each(function(index, element) {
            var currentVal = parseInt($(this).val()) || 0;
            if (currentVal > maxVal) {
                maxVal = currentVal;
            }
        });
        var correspondingObject = assetValueLevels.find(function(obj) {
            return obj.level == maxVal;
        });

        if (correspondingObject) {
            var correspondingName = correspondingObject.name;
            var correspondingId = correspondingObject.id;

            $('.total-impact-input-number span').text(' ( ' + maxVal + ' ) - ( ' + correspondingName + ' ) ');
            $('.asset_value_impact').val(' ( ' + maxVal + ' ) - ( ' + correspondingName + ' ) ');
            $('.return-total-impact-input-number').val(correspondingId);
            $('.check-valid-impact').addClass('d-none');
        } else {
            $('.asset_value_impact').val('');
            $('.total-impact-input-number span').text(maxVal);
            $('.return-total-impact-input-number').val('');

        }

    }

    function updateCategoryTotalNumber(_that) {
        var totalElement = _that.parents('.category-content').find('.total-category-number span');
        var inputElement = _that.parents('.category-content').find('.total-category-input-number');

        var isAvgContent = _that.parents('.category-content').hasClass('category-avg-content');

        var values = _that.parents('.category-content').find('.category-row .select-item-value');
        var total = 0;

        values.each(function() {
            total += parseInt($(this).val());
        });

        if (isAvgContent) {
            var average = total / values.length;
            var roundedAverage = Math.round(average);
            totalElement.text(' (  ' + roundedAverage + ' ) ');
            inputElement.val(roundedAverage);
        } else {
            totalElement.text(' ( ' + total + ' ) ');
            inputElement.val(total);
        }
    }

    $(document).on('click', '.category-impact-submit', function() {

        valId = $('.return-total-impact-input-number').val();

        if (valId != '') {
            $('.check-valid-impact').addClass('d-none');
            totalImpactNumber();
            $('.asset_value_impact_level').val(valId);
            $('#exampleModalLong').modal('hide');

        } else {
            $('.check-valid-impact').removeClass('d-none');

        }


    });

    // Example of calling the function
    // Pass the element that triggered the update (e.g., a button or select)
    var buttonElement = $('.example-button');
    updateCategoryTotalNumber(buttonElement);




    {{--  $('.select-item').trigger('change');  --}}
</script>
{{-- Add Verification translation --}}
<script>
    const verifiedTranslation = "{{ __('locale.Verified') }}",
        UnverifiedAssetsTranslation = "{{ __('asset.UnverifiedAssets') }}",
        customDay = "{{ trans_choice('locale.custom_days', 1) }}",
        customDays = "{{ trans_choice('locale.custom_days', 3) }}",
        assetInQuery = "{{ $assetInQuery }}";

    var permission = [],
        lang = [],
        URLs = [];
    userName = "{{ auth()->user()->name }}";
    user_id = {{ auth()->id() }}, customUserName =
        "{{ getFirstChartacterOfEachWord(auth()->user()->name, 2) }}";
    role_id = {{ auth()->user()->role_id }};
    userName = "{{ auth()->user()->name }}";
    permission['edit'] = {{ auth()->user()->hasPermission('asset.update') ? 1 : 0 }};
    permission['delete'] = {{ auth()->user()->hasPermission('asset.delete') ? 1 : 0 }};

    lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('asset.asset')]) }}";

    URLs['ajax_list'] = "{{ route('admin.asset_management.ajax.index') }}";
    URLs['sendAssetComment'] = "{{ route('admin.asset_management.ajax.sendComment') }}";
    URLs['downloadAssetCommentFile'] = "{{ route('admin.asset_management.ajax.downloadCommentFile', '') }}";
</script>

<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>


<script>
    // Submit form for creating asset
    $('#add-new-asset form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#add-new-asset').modal('hide');
                    redrawDatatable();
                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });

    // Submit form for editing asset
    $('#edit-asset form').submit(function(e) {
        e.preventDefault();
        const id = $(this).find('input[name="id"]').val();
        let url = "{{ route('admin.asset_management.ajax.update', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "PUT",
            data: $(this).serialize(),
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#edit-asset form').trigger("reset");
                    $('#edit-asset').modal('hide');
                    redrawDatatable();
                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });

    function DeleteAsset(id) {
        let url = "{{ route('admin.asset_management.ajax.destroy', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    redrawDatatable();
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    // Show modal for editing
    function ShowModalEditAsset(id) {
        let url = "{{ route('admin.asset_management.ajax.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    const editForm = $("#edit-asset form");

                    // Start Assign asset data to modal
                    editForm.find('input[name="id"]').val(id);
                    editForm.find("input[name='name']").val(response.data.name);
                    editForm.find("input[name='ip']").val(response.data.ip);

                    // Select region directly based on the response
                    editForm.find("select[name='asset_region']").val(response.data.asset_region).trigger(
                        'change'); // Directly set the asset_region

                    editForm.find(
                        `select[name='asset_value_id'] option[value='${response.data.asset_value_id}']`
                    ).attr('selected', true).trigger('change');

                    editForm.find(
                        `select[name='asset_category_id'] option[value='${response.data.asset_category_id}']`
                    ).attr('selected', true).trigger('change');

                    editForm.find(
                        `select[name='asset_environment_category_id'] option[value='${response.data.asset_environment_category_id}']`
                    ).attr('selected', true).trigger('change');

                    editForm.find(
                        `select[name='os'] option[value='${response.data.os}']`
                    ).attr('selected', true).trigger('change');

                    editForm.find(
                        `select[name='physical_virtual_type'] option[value='${response.data.physical_virtual_type}']`
                    ).attr('selected', true).trigger('change');

                    editForm.find(
                        `select[name='asset_owner'] option[value='${response.data.asset_owner}']`
                    ).attr('selected', true).trigger('change');

                    editForm.find(`select[name='location_id'] option[value='${response.data.location_id}']`)
                        .attr('selected', true).trigger('change');

                    response.data.teams.forEach(teamId => {
                        editForm.find(`select[name='teams[]'] option[value='${teamId}']`).attr(
                            'selected', true).trigger('change');
                    });

                    response.data.tags.forEach(tagId => {
                        editForm.find(`select[name='tags[]'] option[value='${tagId}']`).attr(
                            'selected', true).trigger('change');
                    });
                    editForm.find("select[name='region_id']").val(response.data.region_id).trigger(
                        'change');
                    editForm.find("input[name='expiration_date']").val(response.data.expiration_date);
                    editForm.find("input[name='start_date']").val(response.data.start_date);
                    editForm.find("input[name='alert_period']").val(response.data.alert_period);
                    editForm.find("textarea[name='details']").val(response.data.details);
                    editForm.find("input[name='url']").val(response.data.url);
                    editForm.find("input[name='os_version']").val(response.data.os_version);
                    editForm.find("input[name='asset_owner']").val(response.data.asset_owner);
                    // editForm.find("input[name='owner_email']").val(response.data.owner_email);
                    // editForm.find("input[name='owner_manager_email']").val(response.data.owner_manager_email);
                    editForm.find("input[name='project_vlan']").val(response.data.project_vlan);
                    editForm.find("input[name='vlan']").val(response.data.vlan);
                    editForm.find("input[name='vendor_name']").val(response.data.vendor_name);
                    editForm.find("input[name='model']").val(response.data.model);
                    editForm.find("input[name='firmware']").val(response.data.firmware);
                    editForm.find("input[name='rack_location']").val(response.data.rack_location);
                    editForm.find("input[name='city']").val(response.data.city);
                    editForm.find("input[name='mac_address']").val(response.data.mac_address);
                    editForm.find("input[name='subnet_mask']").val(response.data.subnet_mask);
                    editForm.find("input[name='verified']").attr('checked', response.data.verified);
                    if (response.data.verified) {
                        editForm.find("input[name='verified']").attr('checked', true);
                    } else {
                        editForm.find("input[name='verified']").attr('checked', false);
                    }

                    var correspondingObject = assetValueLevels.find(function(obj) {
                        return obj.id == response.data.asset_value_level_id;
                    });

                    if (correspondingObject) {
                        var correspondingName = correspondingObject.name;
                        var correspondingLevel = correspondingObject.level;
                        editForm.find(".asset_value_impact").val(' ( ' + correspondingLevel + ' ) - ( ' +
                            correspondingName + ' ) ');
                    } else {
                        editForm.find(".asset_value_impact").val('');
                    }
                    editForm.find("input[name='asset_value']").val(response.data.asset_value_level_id);

                    // End Assign asset data to modal
                    $('.dtr-bs-modal').modal('hide');
                    $('#edit-asset').modal('show');
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    // Show delete alert modal
    function ShowModalDeleteAsset(id) {
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
            text: '@lang('locale.YouWontBeAbleToRevertThis')',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
            cancelButtonText: "{{ __('locale.Cancel') }}",
            customClass: {
                confirmButton: 'btn btn-relief-success ms-1',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                DeleteAsset(id);
            }
        });
    }

    // Reset form
    function resetFormData(form) {
        $('.error').empty();
        form.trigger("reset")
        form.find('input:not([name="_token"])').val('');
        form.find('select.multiple-select2 option[selected]').attr('selected', false);
        form.find('select.select2 option').attr('selected', false);
        form.find("select.select2").each(function(index) {
            $(this).find('option').first().attr('selected', true);
        });
        form.find('select').trigger('change');
    }

    $('.modal').on('hidden.bs.modal', function() {
        resetFormData($(this).find('form'));
    })
</script>
<script>
    $(document).ready(function() {
        $('#export-assets-btn').on('click', function() {
            var region = $('#exportRegion').val();
            $.ajax({
                url: '{{ route('admin.asset_management.ajax.export') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    type: 'xlsx', // or 'pdf' based on the requirement
                    region: region
                },
                success: function(response) {
                    makeAlert('success', response.message, "{{ __('locale.Success') }}");
                    $('#exportAssetModal').modal('hide');
                },
                error: function(xhr) {
                    makeAlert('error', 'An error occurred while exporting assets.');
                }
            });
        });

    });

    $(document).off('show.bs.dropdown').on('show.bs.dropdown', '.dropdown', function(e) {
        // redrawDatatable();

        const dropdown = $(e.target).closest('.dropdown');

        // 🔴 Remove unread badge when dropdown opens
        dropdown.find('.position-absolute.badge.bg-danger').remove();

        // Handle comment item
        const commentItem = dropdown.find('.dropdown-menu .item-comment');
        if (commentItem.length) {
            const assetId = commentItem.data('asset-id') || commentItem.attr('asset-id');
            if (assetId) {
                fetchUnreadCommentCount(assetId);
            } else {
                console.error('Could not find asset ID on comment item');
            }
        }
    });


    function fetchUnreadCommentCount(assetId) {
        console.log('Fetching unread count for asset:', assetId); // Better than alert

        var url = "{{ route('admin.asset_management.ajax.showCommentsCounts', '') }}" + "/" + assetId;
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                asset_id: assetId,
                _token: csrfToken,
            },
            success: function(response) {
                const unreadCount = response.unread_count || 0;
                const badgeEl = $('#unread-count-' + assetId);

                if (unreadCount > 0) {
                    badgeEl.text(unreadCount).show();
                } else {
                    badgeEl.hide();
                }
            },
            error: function(err) {
                console.error('Failed to fetch unread comment count:', err);
            }
        });
    }

    function openAssetCommentsModal(assetId) {
        var url = "{{ route('admin.asset_management.ajax.showComments', '') }}" + "/" +
            assetId;
        $('[name="asset_id"]').val(assetId)

        // AJAX request
        $.ajax({
            url: url,
            type: "GET",
            data: {},
            success: function(response) {
                comments = response.data;
                addMessageToChat(comments);
                $('.clearCommentsBtn').attr('onclick', 'showModalClearComments(' +
                    assetId + ')');
                const commentsModal = new bootstrap.Modal(document.getElementById('assetCommentsModal'));
                commentsModal.show();
                $('[name="asset_id"]').val(assetId)
                // You can set the asset ID in the modal if needed
                document.getElementById('assetCommentsModal').dataset.assetId = assetId;
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });

    }

    // Function to show delete confirmation modal for an comments
    function showModalClearComments(id) {
        // Display confirmation modal using SweetAlert
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToClearComments') }}",
            text: '@lang('locale.YouWontBeAbleToRevertThis')',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
            cancelButtonText: "{{ __('locale.Cancel') }}",
            customClass: {
                confirmButton: 'btn btn-relief-success ms-1',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                // If confirmed, call the Delete Comments function
                clearComments(id);
            }
        });
    }

    function clearComments(id) {
        // Construct the URL for deleting the comments
        let url = "{{ route('admin.asset_management.ajax.clearComments', ':id') }}";
        url = url.replace(':id', id);

        // AJAX request to delete the objective
        $.ajax({
            url: url,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status) {
                    // Display success alert and update comments list
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('.chats').empty();
                }
            },
            error: function(response, data) {
                // Display error alert if deletion fails
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    function makeAlert($status, message, title) {
        // On load Toast
        if (title == 'Success')
            title = '👋' + title;
        toastr[$status](message, title, {
            closeButton: true,
            tapToDismiss: false,
        });
    }
</script>
@endsection
