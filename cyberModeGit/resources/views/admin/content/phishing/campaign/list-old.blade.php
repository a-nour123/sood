@extends('admin/layouts/contentLayoutMaster')

@section('title', __('governance.Regulators'))

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

    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}

    <style>
       .tab-pane.fade {
            display: none !important;
        }

        .tab-pane.fade.active.show {
            display: block !important;
        }

        .side-menu {
            background-color: #f4f4f4;
            padding: 10px;
            height: 100%;
            border-right: 1px solid #ddd;
        }

        .folders, .labels {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .folder-item, .label-item {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }

        .folder-item:hover, .label-item:hover {
            background-color: #e9ecef;
        }

        .email-display {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        .email-subject {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .email-details {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 10px;
        }

        .email-body {
            white-space: pre-wrap;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
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

                        @if(Route::currentRouteName() == 'admin.phishing.campaign.index')
                            <div class="col-sm-6 pe-0" style="text-align: end;">
                                <div class="action-content">
                                    @if (auth()->user()->hasPermission('asset.create'))
                                        <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                            data-bs-target="#add-new-senderProfile">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <a href="{{ route('admin.asset_management.notificationsSettingsActiveAsset') }}"
                                            class=" btn btn-primary" target="_self">
                                            <i class="fa fa-regular fa-bell"></i>
                                        </a>
                                        <a href="{{ route('admin.phishing.campaign.archivedcampaign') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa  fa-trash"></i>
                                    </a>
                                    @endif
                                    <a class="btn btn-primary" href="http://"> <i class="fa fa-solid fa-gear"></i> </a>

                                    <x-export-import name=" {{ __('locale.Asset') }}" createPermissionKey='asset.create'
                                        exportPermissionKey='asset.export'
                                        exportRouteKey='admin.asset_management.ajax.export'
                                        importRouteKey='admin.asset_management.import' />

                                    <a class="btn btn-primary" href="http://"> <i class="fa-solid fa-file-invoice"></i></a>
                                </div>
                            </div>
                        @else
                            <div class="col-sm-6 pe-0" style="text-align: end;">
                                <div class="action-content">
                                    @if (auth()->user()->hasPermission('asset.create'))
                                        <a href="{{ route('admin.asset_management.notificationsSettingsActiveAsset') }}"
                                            class=" btn btn-primary" target="_self">
                                            <i class="fa fa-regular fa-bell"></i>
                                        </a>
                                    @endif
                                    <a class="btn btn-primary" href="http://"> <i class="fa fa-solid fa-gear"></i> </a>

                                    <x-export-import name=" {{ __('locale.Asset') }}" createPermissionKey='asset.create'
                                        exportPermissionKey='asset.export'
                                        exportRouteKey='admin.asset_management.ajax.export'
                                        importRouteKey='admin.asset_management.import' />

                                    <a class="btn btn-primary" href="http://"> <i class="fa-solid fa-file-invoice"></i></a>
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



<section id="advanced-search-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <hr class="my-0" />
                <div class="card-datatable table-responsive">
                    <table class="dt-advanced-server-search table">
                        <thead>
                            <tr>
                                <th>{{ __('locale.#') }}</th>
                                <th class="all">{{ __('Campaign Name') }}</th>
                                <th class="all">{{ __('Campaign type') }}</th>
                                <th class="all">{{ __('Delivery Status') }}</th>
                                <th class="all">{{ __('Scheduled Date') }}</th>
                                <th class="all">{{ __('Scheduled Time') }}</th>
                                <th class="all">{{ __('Next Delivery') }}</th>
                                <th class="all">{{ __('Actions') }}</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>{{ __('locale.#') }}</th>
                                <th class="all">{{ __('Campaign Name') }}</th>
                                <th class="all">{{ __('Campaign type') }}</th>
                                <th class="all">{{ __('Delivery Status') }}</th>
                                <th class="all">{{ __('Scheduled Time') }}</th>
                                <th class="all">{{ __('Scheduled Date') }}</th>
                                <th class="all">{{ __('Next Delivery') }}</th>
                                <th class="all">{{ __('Actions') }}</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Modal Employees Filter -->
<div class="modal fade bd-example-modal-xl" style="z-index: 999999999999999" tabindex="-1" role="dialog" aria-labelledby="addNewWebsiteModalLabel" aria-hidden="true" id="filter-employees-modal"  >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewWebsiteModalLabel">Filter Selected Employees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body dark-modal">
               <table class="table my-5">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col" class="all">name</th>
                        <th scope="col" class="all">email</th>
                        <th scope="col" class="all">select</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
               </table>
            </div>
        </div>
    </div>
</div>



<!-- Modal Email Template Data -->
<div class="modal fade" style="z-index: 99999999; top: 150px;" id="email-template-data-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"       aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Tabs -->
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="email-tab" data-toggle="tab" href="#email" role="tab" aria-controls="email" aria-selected="true">
                <i class="fa fa-envelope"></i> Email
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="website-tab" data-toggle="tab" href="#website" role="tab" aria-controls="website" aria-selected="false">
                <i class="fa fa-globe"></i> Website
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="sender-profile-tab" data-toggle="tab" href="#sender-profile" role="tab" aria-controls="sender-profile" aria-selected="false">
                <i class="fa fa-id-card"></i> Sender Profile
              </a>
            </li>
          </ul>

          <!-- Tab Contents -->
          <div class="" id="myTabContent">
            <!-- Email Tab -->
            <div class="tab-pane fade show active" id="email" role="tabpanel" aria-labelledby="email-tab">
              <div class="form-group">
                <label for="phishingEmail">Phishing Email</label>
                <input type="text" class="form-control" id="phishingEmail" readonly>
              </div>
              <div class="form-group">
                <label for="emailSubject">Email Subject</label>
                <input type="text" class="form-control" id="emailSubject" readonly>
              </div>

              <div class="form-group">
                <label for="emailSubject" class="text-danger">Note: The below image is just a screenshot. Click the screenshot to see the live email.</label>
                <img src="path/to/image.png" id="openSimulatorModal" alt="Clickable Image" style="cursor: pointer; width: 100%; height: 200px;" />
              </div>
            </div>

            <!-- Website Tab -->
            <div class="tab-pane fade" id="website" role="tabpanel" aria-labelledby="website-tab">
              <div class="form-group my-3">
                <label for="phishingWebsite">Phishing Website</label>
                <input type="text" class="form-control" id="phishingWebsite"  readonly>
              </div>
              <div class="form-group">
                <label for="websiteURL">Website URL</label>
                <input type="text" class="form-control" id="websiteURL"  readonly>
              </div>
            </div>

            <!-- Sender Profile Tab -->
            <div class="tab-pane fade" id="sender-profile" role="tabpanel" aria-labelledby="sender-profile-tab">
              <div class="form-group my-3">
                <label for="senderProfile">Sender Profile</label>
                <input  type="text" class="form-control" id="senderProfile" readonly>
              </div>
              <div class="form-group">
                <label for="displayNameAddress">Display Name & Address</label>
                <input type="text" class="form-control" id="displayNameAddress" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" disabled>Update Bundle</button>
          <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>



<!-- Modal For Mail simulation -->
<div class="modal fade" id="SimulatorModal" style="z-index: 99999999999;" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email Inbox Simulator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="John">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="Doe">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="emailAddress">Email Address</label>
                            <input type="email" class="form-control" id="emailAddress" placeholder="john.doe@mybusiness.com">
                        </div>

                    </div>
                    <div class="row">
                        <!-- Side Menu -->
                        <div class="col-md-3">
                            <div class="side-menu">
                                <ul class="folders">
                                    <li class="folder-item">Inbox</li>
                                    <li class="folder-item">Starred</li>
                                    <li class="folder-item">Draft</li>
                                    <li class="folder-item">Sent Mail</li>
                                    <li class="folder-item">Spam</li>
                                    <li class="folder-item">Trash</li>
                                </ul>
                                <ul class="labels">
                                    <li class="label-item">Work</li>
                                    <li class="label-item">Business</li>
                                    <li class="label-item">Family</li>
                                    <li class="label-item">Friends</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Main Content -->
                        <div class="col-md-9">
                            <div class="email-display">
                                <h3 class="email-subject">test Freedom email subject</h3>
                                <div class="email-details">
                                    <span>pk ( ar@pksaudi[.]sa )</span>
                                    <span>to john[.]doe@mybusiness[.]com</span>
                                </div>
                                {{-- <textarea class="form-control" rows="10" id="email-subject"></textarea> --}}
                                <input type="hidden"  id="email-template-id"/>
                                <input type="hidden"  id="email-website-url"/>
                                <textarea class="form-control"  placeholder="body" id="editor1" rows="10" required="required"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal Email Website Filter -->
<div class="modal fade bd-example-modal-xl" style="z-index: 9999999999999999" tabindex="-1" role="dialog" aria-labelledby="addNewWebsiteModalLabel" aria-hidden="true" id="email-website-modal"  >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewWebsiteModalLabel">Website</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body dark-modal">
                <div class="form-group">
                    <img src="path/to/image.png" id="email-website-url-modal" alt="Clickable Image" style="cursor: pointer; width: 100%; height: 200px;" />
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Create Form -->
{{--  @if (auth()->user()->hasPermission('domains.create'))  --}}
<x-phishing-campaign-form id="add-new-senderProfile" title="{{ __('locale.AddANewCampaign') }}" :emailtemplate="$emailtemplate" :employees="$employees"/>

{{--  @endif  --}}
<!--/ Create Form -->

<!-- Update Form -->
{{--  @if (auth()->user()->hasPermission('asset.update'))  --}}
<x-phishing-campaign-form id="edit-regulator" title="{{ __('locale.EditCampaign') }}" :emailtemplate="$emailtemplate" :employees="$employees"/>
{{--  @endif   --}}
<!--/ Update Form -->





@endsection

@section('vendor-script')
<script src="{{ asset('js/scripts/components/components-dropdowns-font-awesome.js') }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
{{-- <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script> --}}
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

<script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('new_d/js/editor/ckeditor/adapters/jquery.js') }}"></script>
<script src="{{ asset('new_d/js/editor/ckeditor/styles.js') }}"></script>
<script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.custom.js') }}"></script>



<script>
    var table = $('.dt-advanced-server-search').DataTable({
        lengthChange: true,
        processing: false,
        serverSide: true,
        ajax: {
            url: '{{ route('admin.phishing.campaign.Datatable') }}'
        },
        language: {
            // ... your language settings
        },
        columns: [{
                name: "id",
                data: "id",
                sortable: false,
                searchable: false, // Set to false since this column is not searchable
                orderable: false
            },
            {
                name: "campaign_name",
                data: "campaign_name"
            },
            {
                name: "campaign_type", // Use the actual column name in your database
                data: "campaign_type",
                searchable: true
            },

            {
                name: "delivery_status", // Use the actual column name in your database
                data: "delivery_status",
                searchable: true
            },

            {
                name: "schedule_date_from", // Use the actual column name in your database
                data: "schedule_date_from",
                searchable: true
            },

            {
                name: "schedule_time_from", // Use the actual column name in your database
                data: "schedule_time_from",
                searchable: true
            },

            {
                name: "schedule_time_to", // Use the actual column name in your database
                data: "schedule_time_to",
                searchable: true
            },


            {
                name: "actions",
                data: "actions",
                searchable: false // Set to false since this column is not searchable
            }
        ],
    });
</script>
@endsection

@section('page-script')
<script>
    const verifiedTranslation = "{{ __('locale.Verified') }}",
        UnverifiedAssetsTranslation = "{{ __('asset.UnverifiedAssets') }}",
        customDay = "{{ trans_choice('locale.custom_days', 1) }}",
        customDays = "{{ trans_choice('locale.custom_days', 3) }}",
        {{--  assetInQuery = "{{ $assetInQuery }}";  --}}

    var permission = [],
        lang = [],
        URLs = [];
    permission['edit'] = {{ auth()->user()->hasPermission('asset.update') ? 1 : 0 }};
    permission['delete'] = {{ auth()->user()->hasPermission('asset.delete') ? 1 : 0 }};

    lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('asset.asset')]) }}";

    URLs['ajax_list'] = "{{ route('admin.asset_management.ajax.index') }}";
</script>

<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
<script src="{{ asset('js/scripts/config.js') }}"></script>

<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>


<script src="{{ asset('new_d/js/form-wizard/form-wizard.js') }}"></script>
<script src="{{ asset('new_d/js/form-wizard/image-upload.js') }}"></script>

<script src="{{ asset('new_d/js/bootstrap/bootstrap11.min.js')}}"></script>



<script>

    function moveSelected(from, to) {
        var fromList = document.getElementById(from);
        var toList = document.getElementById(to);
        var selectedOptions = Array.from(fromList.selectedOptions);
        selectedOptions.forEach(option => {
            toList.appendChild(option);
        });
    }

    function moveAll(from, to) {
        var fromList = document.getElementById(from);
        var toList = document.getElementById(to);
        var allOptions = Array.from(fromList.options);
        allOptions.forEach(option => {
            toList.appendChild(option);
        });
    }

    function validateStep() {

        var activeForm = $('#msform form').filter(function() {
            return $(this).css('display') === 'flex';
        });

        if (activeForm.length === 0) {
            console.log('No form is currently visible.');
            return;
        }

        var formId = activeForm.attr('id');
        var formData = new FormData(activeForm[0]);
        formData.append('formStep',formId)

        let checkedEmployees = $('input[type=checkbox][name="checkedEmployees[]"]:checked')
        .map(function() {
            return $(this).val();
        }).get();

        if (checkedEmployees.length > 0) {
            checkedEmployees.forEach(function(employee) {
                formData.append('checkedEmployees[]', employee);
            });
        }

        fetch('{{ route('admin.phishing.campaign.validateFirstStep') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {

            console.log(data.sessionCampaign);
            if(data.stepThreeNow == true){
               $('#campaignName').val(data.sessionCampaign.campaign_name);
               $('select[name=campaignType][value="' + data.sessionCampaign.campaign_type + '"]').prop('selected', true);
               $('input[type=radio][name=delivery_type][value="' + data.sessionCampaign.delivery_type + '"]').prop('checked', true);
               $('#scheduleDays').val(data.sessionCampaign.schedule_date_from + '-' + data.sessionCampaign.schedule_date_to);
               $('#scheduleFromTime').val(data.sessionCampaign.schedule_time_from);
               $('#scheduleToTime').val(data.sessionCampaign.schedule_time_to);
               $('#expireAfter').val(data.sessionCampaign.expire_after);
               $('input[type=radio][name=campaign_frequency][value="' + data.sessionCampaign.campaign_frequency + '"]').prop('checked', true);
               $('#phishingBundlesContainer').empty();
               data.sessionCampaign.email_templates.forEach(templateId => {
                    let templateName = null;
                    let websiteName = null;
                    let senderProfileName = null;

                    let url = "{{ route('admin.phishing.emailTemplate.edit', ':id') }}".replace(':id', templateId);
                    fetch(url, {
                        method: 'GET',
                    })
                    .then(response => response.json())
                    .then(data => {
                        templateName = data.EmailTemplate.name;
                        websiteName = data.EmailTemplate.website.name;
                        senderProfileName = data.EmailTemplate.website.name;
                        let phishingBundleHtml = `
                            <div class="form-group row">
                                <h4 class="col-sm-12 col-form-label">Phishing Bundle</h4>
                            </div>

                            <div class="form-group row">
                                <label for="phishingEmail" class="col-sm-2 col-form-label">Phishing Email</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="phishingEmail" disabled>
                                        <option selected>${templateName}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phishingWebsite" class="col-sm-2 col-form-label">Phishing Website</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="phishingWebsite" disabled>
                                        <option selected>${websiteName}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="senderProfile" class="col-sm-2 col-form-label">Sender Profile</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="senderProfile" disabled>
                                        <option selected>${senderProfileName}</option>
                                    </select>
                                </div>
                            </div>
                        `;
                        $('#phishingBundlesContainer').append(phishingBundleHtml);

                    }).catch(error => {
                        console.log('Error:', error);
                    });
                });
            }

            if(data.createdSuccessfully == true){
                makeAlert('success', data.message, "{{ __('locale.Success') }}");
                window.location.reload();
            }

            if (data.errors) {
                $('.error').empty();
                $.each(data.errors, function(key, value) {
                    $('.error-' + key).text(value[0]);
                });

            } else {
                nextStep();
            }
        })
        .catch(error => {
            console.log('Error:', error);
        });
    }

    $(document).on('change','input[type=radio][name=delivery_type]',function(){
        if($(this).val() == 'setup'){
            $('#block-of-setup').css('display','block')
        }else{
            $('#block-of-setup').css('display','none')
        }

        if($(this).val() == 'later'){
            $('#campaign-frequency-section').css('display','none')
        }else{
            $('#campaign-frequency-section').css('display','block')
        }
    })

    $(document).on('change','input[type=radio][name=campaign_frequency]',function(){
        if($(this).val() == 'oneOf'){
            $('#expire-after-section').css('display','none')
        }else{
            $('#expire-after-section').css('display','block')
        }
    })

    $(document).ready(function() {

        CKEDITOR.replace( 'editor1', {
            on: {
                contentDom: function( evt ) {
                    // Allow custom context menu only with table elemnts.
                    evt.editor.editable().on( 'contextmenu', function( contextEvent ) {
                        var path = evt.editor.elementPath();

                        if ( !path.contains( 'table' ) ) {
                            contextEvent.cancel();
                        }
                    }, null, null, 5 );
                }
            }
        } );
    });

    // filter-employees
    $(document).on('click', '#filter-employees', function() {
       let selectedEmployees  = $('#selected_employees').val();
       if(selectedEmployees.length == 0){
        alert('empty')
        return
       }

       $.ajax({
        type:'POST',
        data:{
            selectedEmployees:selectedEmployees,
        },
        url:"{{route('admin.phishing.campaign.employees')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(response){
            $('table tbody').html('');
            let employees = response.employees;
            let tbody = '';

            employees.forEach(function(employee) {
                tbody += `
                    <tr>
                        <th>${employee.id}</th>
                        <th class="all">${employee.name}</th>
                        <th class="all">${employee.email}</th>
                        <th class="all">
                            <input type="checkbox" class="checkedEmployees" checked name="checkedEmployees[]" value="${employee.id}" />
                        </th>
                    </tr>
                `;
            });
            $('table tbody').append(tbody);
            $('#filter-employees-modal').modal('show')
        },
        error:function(error){
            alert(error.error);
        }
       })

    })

    function openEmailTemplate(id){
        $.ajax({
            type:'GET',
            url:"{{route('admin.phishing.campaign.emailTemplateData',':id')}}".replace(':id',id),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){

                console.log(response);
                $('#exampleModalLabel').text(response.EmailTemplate.name);
                // $('#exampleModalLabel').html(response.EmailTemplate.name);
                $('#phishingEmail').val(response.EmailTemplate.name);
                $('#emailSubject').val(response.EmailTemplate.subject);
                $('#phishingWebsite').val(response.EmailTemplate.website?.name);
                $('#websiteURL').val(response.EmailTemplate.website?.website_url);
                $('#senderProfile').val(response.EmailTemplate.sender_profile?.name);
                if(response.EmailTemplate.sender_profile.website_domain_id){
                    $('#displayNameAddress').val(response.EmailTemplate.sender_profile?.from_address_name + response.EmailTemplate.sender_profile?.domain?.name);
                }else{
                    $('#displayNameAddress').val(response.EmailTemplate.sender_profile?.from_address_name);
                }

                // image
                $('#openSimulatorModal').attr('src',response.EmailTemplate.website?.website_url);
                $('#email-template-id').val(response.EmailTemplate.id);
                $('#email-website-url').val(response.EmailTemplate.website?.website_url);


                // other simultion email modal
                // $('#email-subject').text(response.EmailTemplate.subject)
                CKEDITOR.instances.editor1.setData(response.EmailTemplate.body);


                $('#email-template-data-modal').modal('show')
            },
            error:function(error){
                alert(error.error);
            }
        })
    }

    $(document).on('click','#openSimulatorModal',function(){
        $('#SimulatorModal').modal('show');
    })

    CKEDITOR.instances['editor1'].on('contentDom', function() {
        var editor = this;
        editor.editable().on('click', function(event) {
            console.log('clicked')
            var element = event.data.getTarget();
            if (element.is('a')) {
                var href = element.getAttribute('href');
                var websiteUrl= $('#email-website-url').val();

                if (href && href.includes('{PhishWebsitePage}')) {
                    event.data.preventDefault();
                    $('#email-website-url-modal').attr('src',websiteUrl)
                    $('#email-website-modal').modal('show');
                }else{
                    window.open(href, '_blank');
                }
            }
        });
    });

    $(document).on('click', '.edit-regulator', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "{{ route('admin.phishing.campaign.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(response) {
                var editForm = $("#msform #form-step-one");
                editForm.find('input[name="id"]').val(response.data.id);
                editForm.find('input[name="campaign_name"]').val(response.data.campaign_name);
                editForm.find('select[name="campaign_type"]').val(response.data.campaign_type);
                editForm.find('input[name="training_frequency"]').val(response.data.training_frequency);
                // editForm.find('select[name="selected_employees[]"]').val(response.data.selected_employees).trigger('change');
            },
            error: function(response) {
                console.log('Error: ' + response.error);
            }
        })
        $('.dtr-bs-modal').modal('hide');
        $('#edit-regulator').modal('show');
    });


    // Submit form for creating asset
    $('#add-new-senderProfile form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Tell jQuery not to set the content type
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#add-new-senderProfile').modal('hide');
                    // location.reload();
                    $('.dt-advanced-server-search').DataTable().ajax.reload();
                    $('#domains-parent-div').append(data.newSenderProfileTemplate);

                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                var responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });





    // Submit form for editing asset
    $('#edit-regulator form').submit(function(e) {
        e.preventDefault();

        const id = $(this).find('input[name="id"]').val();
        let url = "{{ route('admin.phishing.campaign.update', ':id') }}";
        url = url.replace(':id', id);

        // Create a FormData object
        let formData = new FormData(this);

        $.ajax({
            url: url,
            type: "POST", // Laravel typically handles file uploads via POST
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Set the content type to false as jQuery will tell the server it's a query string request
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#edit-regulator form').trigger("reset");
                    $('#edit-regulator').modal('hide');
                    $('.dt-advanced-server-search').DataTable().ajax.reload();
                    location.reload();
                } else {
                    showError(data['errors']);
                }
            },
            error: function(response) {
                let responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });

    $(document).on('click', '.new-frame-modal-btn', function() {
        var regulator_id = $(this).data('regulator');
        $('.regulator_id').val(regulator_id);
    });



    function TrashSenderProfile(id) {
        let url = "{{ route('admin.phishing.campaign.trash', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('.dt-advanced-server-search').DataTable().ajax.reload();
                    $(`.domain-card[data-id="${id}"]`).remove();

                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }





    // Show delete alert modal
    function ShowModalDeleteDomain(id) {
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToTrashThisRecord') }}",
            {{--  text: '@lang('locale.YouWontBeAbleToRevertThis')',  --}}
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "{{ __('locale.ConfirmTrash') }}",
            cancelButtonText: "{{ __('locale.Cancel') }}",
            customClass: {
                confirmButton: 'btn btn-relief-success ms-1',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                TrashSenderProfile(id);
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

    $('.add_frame').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    if (data.reload)
                        location.reload();
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

    $(document).on('change', "input[name='type']", function() {
        console.log($(this).val())
        let typeValue = $("input[name='type']:checked").val();
        if(typeValue == 'own'){
            $('#website_domain_id_div').css('display', 'none');
            $('#website_from_address_name_div').removeClass('col-6').addClass('col-12');
            $('#website_domain_id').attr('required',false)
        } else {
            $('#website_domain_id_div').css('display', 'block');
            $('#website_from_address_name_div').removeClass('col-12').addClass('col-6');
            $('#website_domain_id').attr('required',true)
        }
    });

    // Load subdomains of framework domain
    $(document).on('change', '.framework_domain_select', function() {
        const oldDomains = $(this).data("prev"),
            currentDomains = $(this).val();
        let deletedDomains = oldDomains.filter(x => !currentDomains.includes(x));
        let addedDomains = currentDomains.filter(x => !oldDomains.includes(x));
        const subDomainSelect = $(this).parents('.family-container').next().find('select');

        addedDomains.forEach(domain => {
            const subDomains = $(this).find(`[value="${domain}"]`).data('families');
            if (subDomains)
                subDomains.forEach(subDomains => {
                    subDomainSelect.append(
                        `<option data-parent="${domain}" value="${subDomains.id}">${subDomains.name}</option>`
                    );
                });
        });

        deletedDomains.forEach(domain => {
            subDomainSelect.find('option[data-parent="' + domain + '"]').remove();
        });

        subDomainSelect.trigger('change');
        $(this).data("prev", $(this).val());
    });

    $(document).ready(function() {

        let labelColor, headingColor, borderColor;


        labelColor = config.colors_dark.textMuted;
        headingColor = config.colors_dark.headingColor;
        borderColor = config.colors_dark.borderColor;


        const chartProgressList = document.querySelectorAll('.chart-progress');
        if (chartProgressList) {
            chartProgressList.forEach(function(chartProgressEl) {
                const color = chartProgressEl.dataset.color,
                    series = chartProgressEl.dataset.series;
                const progress_variant = chartProgressEl.dataset.progress_variant;
                const optionsBundle = radialBarChart(color, series, progress_variant);
                console.log(color)
                const chart = new ApexCharts(chartProgressEl, optionsBundle);
                chart.render();
            });
        }


        // Radial bar chart functions
        function radialBarChart(color, value, show) {
            const radialBarChartOpt = {
                chart: {
                    height: show == 'true' ? 58 : 53,
                    width: show == 'true' ? 58 : 43,
                    type: 'radialBar'
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: show == 'true' ? '45%' : '33%'
                        },
                        dataLabels: {
                            show: show == 'true' ? true : false,
                            value: {
                                offsetY: -10,
                                fontSize: '14px',
                                fontWeight: 700,
                                color: '#333'
                            }
                        },
                        track: {
                            background: config.colors_label.secondary
                        }
                    }
                },
                stroke: {
                    lineCap: 'round'
                },
                colors: [color],
                grid: {
                    padding: {
                        top: show == 'true' ? -12 : -15,
                        bottom: show == 'true' ? -17 : -15,
                        left: show == 'true' ? -17 : -5,
                        right: -15
                    }
                },
                series: [value],
                labels: show == 'true' ? [''] : ['Progress']
            };
            return radialBarChartOpt;
        }
    });
</script>
@endsection
