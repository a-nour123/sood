@extends('admin/layouts/contentLayoutMaster')

@section('title', __('governance.Define Control Frameworks'))

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/dragula.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">

@endsection

@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-todo.css')) }}">
    <link rel="stylesheet" href="{{ asset('cdn/font-awesome.min.css') }}">
<style>
    html .navbar-floating.footer-static .app-content .content-area-wrapper,
    html .navbar-floating.footer-static .app-content .kanban-wrapper {
        height: auto !important;
    }

    #view_type_sorting {
        font-family: "FontAwesome";
        font-size: 14px;
    }

    #view_type_sorting::before {
        vertical-align: middle;
    }

    .tab button:hover {
        background-color: #bee9f7;
    }

    .tab button.active {
        background-color: #6398a8;
    }

    .gov_btn {
        border-color: #44225c;
        background-color: #44225c;
        color: #fff !important;
        /* padding: 7px; */
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_edit {
        border-color: #5388B4 !important;
        background-color: #5388B4 !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_map {
        border-color: #6c757d !important;
        background-color: #6c757d !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_check {
        padding: 0.786rem 0.7rem;
        line-height: 1;
        font-weight: 500;
        font-size: 1.2rem;
    }

    .gov_err {

        color: red;
    }

    .frame .card-title {
        display: inline-block;
        color: #000;
        font-size: 1rem !important;
    }

    .frame .card-desc {
        display: inline-block;
        color: #6e6c6c;
    }

    .card-body .btn {
        margin-right: 5px;

    }

    .card-body form {
        margin-bottom: 0;

    }

    .todo-application .content-area-wrapper .content-right .todo-task-list-wrapper .todo-task-list li:not(:first-child) {
        border-top: 0 !important;
    }

    .card2 {
        padding: 0.893rem 2rem;
        margin-top: 25px;
    }

    .tab button {
        margin: 0;
    }

    .form-select {
        display: inline-block !important;
    }

    .dataTables_filter {
        float: right !important;
    }

    .dataTables_filter input {
        display: inline-block !important;
        width: auto !important;
    }
</style>
@endsection

@section('content-sidebar')


    <div class="sidebar-content todo-sidebar">
        <div class="todo-app-menu">
            @if (auth()->user()->hasPermission('framework.create'))
                <div class="add-task">
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                        data-bs-target="#new-frame-modal">
                        {{ __('locale.Add') }} {{ __('governance.Framework') }}
                    </button>
                </div>
            @endif

            <!-- Import and export container -->
                <x-export-import name=" {{ __('governance.Framework') }}" createPermissionKey='framework.create' exportPermissionKey='framework.export' exportRouteKey='admin.governance.framework.ajax.export' importRouteKey='will-added-TODO' />
            <!--/ Import and export container -->

            <hr>
            <div class="sidebar-menu-list">
                <div class="list-group list-group-filters">
                    <div class="tab" id="tabs">
                        @foreach ($category2 as $item)
                            <button class="list-group-item list-group-item-action tablinks"
                                onclick='openTab(event, "firstTab{{ $item->id }}"  , {{ $item->id }} )'
                                @if ($loop->first) id="defaultOpen" @endif style=" display: flex;">


                                <span class=" fa {{ $item->icon }}"
                                    style=" padding: 0 6px;  font-size: 20px;  color: #44225c; "></span>

                                <div class="mb-1">

                                    {{ $item->name }}
                            </button>
                        @endforeach

                    </div>


                </div>
            </div>


        </div>
    </div>

@endsection

@section('content')
    <div class="body-content-overlay"></div>
    <div class="todo-app-list">
            <!-- Todo search starts -->
        <div class="app-fixed-search d-flex align-items-center">
            <div class="sidebar-toggle d-block d-lg-none ms-1">
                <i data-feather="menu" class="font-medium-5"></i>
            </div>
        </div>
        <!-- Todo search ends -->

        <!-- control List starts -->
        <div class="todo-task-list-wrapper list-group">
            <ul class="todo-task-list media-list" id="todo-task-list">

                @foreach ($category2 as $item)
                    <div id="firstTab{{ $item->id }}" class="tabcontent">

                        <!-- Dark Tables start -->
                        <div class="row" id="dark-table">
                            <div class="col-12">

                                <div class="card2">
                                    <div class="card">

                                        <div class="card-body">

                                            <div class="frame">
                                                <h4 class="card-title"> {{ __('governance.FrameName:') }}  </h4>
                                                <h5 class="card-desc"> {{ $item->name }} </h5>
                                            </div>

                                            <div class="frame mb-1">
                                                <h4 class="card-title">{{ __('governance.FrameDescription:') }}  </h4>
                                                <h5 class="card-desc"> {{ $item->description }}</h5>

                                            </div>

                                            {{-- <div class="frame">

                                                <h4 class="card-title "> Status : </h4>
                                                <h5 class="card-desc"> active </h5>
                                            </div> --}}

                                            <!-- <a href="#" class="card-link">Another link</a> -->
                                            @if (auth()->user()->hasPermission('framework.update'))
                                                <button type="button" class="card-link btn btn-outline-primary"
                                                    data-bs-toggle="modal" data-bs-target="#copy-modal{{ $item->id }}">
                                                    {{ __('locale.Copy') }}
                                                </button>
                                            @endif
                                            @if (auth()->user()->hasPermission('framework.create'))
                                                <button type="button" class="btn btn-outline-warning"
                                                    data-bs-toggle="modal" data-bs-target="#edit-modal{{ $item->id }}">
                                                    {{ __('locale.Edit') }}
                                                </button>
                                            @endif
                                            @if (auth()->user()->hasPermission('framework.delete'))
                                                <form class="frame_del"
                                                    action="{{ route('admin.governance.framework.destroy', $item->id) }}"
                                                    style="display: inline-block;" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <span id="delete_status"> </span>
                                                    <button type="submit"
                                                        class="card-link btn btn-outline-danger"> {{ __('locale.Delete') }}
                                                    </button>
                                                </form>
                                            @endif
                                            {{-- @if (auth()->user()->hasPermission('framework.update'))
                                                <button class="card-link btn  btn-outline-success userinfo"
                                                    data-id="{{ $item->id }}">mapping</button>
                                            @endif --}}


                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dark Tables end -->
                        <div class="modal modal-slide-in sidebar-todo-modal fade" id="edit-modal{{ $item->id }}">
                            <div class="modal-dialog sidebar-lg">
                                <div class="modal-content p-0">

                                    <div class="alert alert-danger print-error-msg" style="display:none">
                                        <ul></ul>
                                    </div>
                                    <form id="form-edit" class=" form-edit todo-modal needs-validation" novalidate
                                        method="POST"
                                        action="{{ route('admin.governance.framework.update', $item->id) }}">
                                        @csrf

                                        <div class="modal-header align-items-center mb-1">
                                            <h5 class="modal-title">{{ __('locale.Update') }} {{ __('governance.Framework') }}</h5>

                                            <div
                                                class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                                                <span class="todo-item-favorite cursor-pointer me-75"><i
                                                        data-feather="star" class="font-medium-2"></i></span>
                                                <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal"
                                                    stroke-width="3"></i>
                                            </div>
                                        </div>
                                        <div class="modal-body flex-grow-1 pb-sm-0 pb-3">

                                            <div class="action-tags">
                                                {{-- Title --}}
                                                <div class="mb-1">
                                                    <label for="title" class="form-label">{{ __('locale.Title') }}</label>
                                                    <input type="text" name="name" class=" form-control"
                                                        placeholder="Title" value="{{ $item->name }}" required />

                                                    <span class="error error-name"></span>
                                                </div>

                                                {{-- families --}}
                                                <div class="mb-1 family-container">
                                                    <label class="form-label" for="family">{{ __('governance.Control Domain') }}</label>
                                                    {{-- @dd($item->only_families, $item->only_sub_families) --}}
                                                    <select class="select2 form-select framework_domain_select" data-prev="[]" multiple name="family[]" required>
                                                        @foreach ($families as $family)
                                                            <option value="{{ $family->id }}" @if(in_array($family->id, $item->_only_families)) {{ 'selected' }} @endif
                                                                data-families="{{ json_encode($family->custom_families_framework) }}">{{ $family->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-family"></span>
                                                </div>

                                                {{-- sub families --}}
                                                <div class="mb-1">
                                                    <label class="form-label ">{{ __('governance.control_sub_domain') }}</label>

                                                    <select class="select2 form-select" name="sub_family[]" multiple required data-subdomains="{{ json_encode($item->_only_sub_families) }}">
                                                    </select>
                                                    <span class="error error-sub_family"></span>
                                                </div>

                                                {{-- Icon --}}
                                                <div class="mb-1 position-relative">
                                                    <label for="task-assigned" class="form-label d-block">{{ __('locale.Icons') }}</label>
                                                    <select class="form-select"
                                                        style="text-align-last: left;font-weight: 600;margin-right: 0;vertical-align: text-bottom;"
                                                        id="view_type_sorting" aria-haspopup="true" aria-expanded="false"
                                                        name="icon">
                                                        <option {{ $item->icon === 'fas fa-ban' ? 'selected' : '' }}
                                                            value='fas fa-ban'>&#xf05e; fa-ban</option>
                                                        <option {{ $item->icon === 'fas fa-bug' ? 'selected' : '' }}
                                                            value='fas fa-bug'>&#xf188; fa-bug</option>
                                                        <option {{ $item->icon === 'fas fa-dungeon' ? 'selected' : '' }}
                                                            value='fas fa-dungeon'>&#xf6d9; fa-dungeon</option>
                                                        <option {{ $item->icon === 'far fa-eye' ? 'selected' : '' }}
                                                            value='far fa-eye'>&#xf06e; fa-eye </option>
                                                        <option {{ $item->icon === 'far fa-eye-slash' ? 'selected' : '' }}
                                                            value='far fa-eye-slash'>&#xf070; fa-eye-slash </option>
                                                        <option
                                                            {{ $item->icon === 'fas fa-id-fingerprint' ? 'selected' : '' }}
                                                            value='fas fa-file-signature'>&#xf573; fa-file-signature
                                                        </option>
                                                        <option
                                                            {{ $item->icon === 'fas fa-id-fingerprint' ? 'selected' : '' }}
                                                            value='fas fa-id-fingerprint'>&#xf577; fa-id-fingerprint
                                                        </option>
                                                        <option {{ $item->icon === 'far fa-id-badge' ? 'selected' : '' }}
                                                            value='far fa-id-badge'>&#xf2c1; fa-id-badge</option>
                                                        <option {{ $item->icon === 'fas fa-id-badge' ? 'selected' : '' }}
                                                            value='fas fa-id-badge'>&#xf2c1; fa-id-badge </option>
                                                        <option {{ $item->icon === 'far fa-id-card' ? 'selected' : '' }}
                                                            value='far fa-id-card'>&#xf2c2;fa-id-card </option>
                                                        <option {{ $item->icon === 'fas fa-key' ? 'selected' : '' }}
                                                            value='fas fa-key'>&#xf084; fa-key </option>
                                                        <option {{ $item->icon === 'fas  fa-lock' ? 'selected' : '' }}
                                                            value='fas  fa-lock'>&#xf023; fa-lock</option>
                                                        <option {{ $item->icon === 'fas fa-unlock' ? 'selected' : '' }}
                                                            value='fas fa-unlock'>&#xf09c; fa-unlock</option>
                                                        <!-- <option value='fas fa-unlock-alt'>&#xf13e; fa-unlock-alt </option> -->
                                                        <!-- <option value='fas user-lock'>&#xf502; user-lock</option> -->
                                                        <option
                                                            {{ $item->icon === 'fas fa-user-secret' ? 'selected' : '' }}
                                                            value='fas fa-user-secret'>&#xf21b; fa-user-secret </option>
                                                        <option {{ $item->icon === 'fa-underline' ? 'selected' : '' }}
                                                            value='fa-underline'>&#xf0cd; fa-underline </option>
                                                        <option {{ $item->icon === 'fa-undo' ? 'selected' : '' }}
                                                            value='fa-undo'>&#xf0e2; fa-undo </option>
                                                        <option
                                                            {{ $item->icon === 'fa-universal-access' ? 'selected' : '' }}
                                                            value='fa-universal-access'>&#xf29a; fa-universal-access
                                                        </option>
                                                        <option {{ $item->icon === 'fa-university' ? 'selected' : '' }}
                                                            value='fa-university'>&#xf19c; fa-university </option>
                                                        <option {{ $item->icon === 'fa-unlink' ? 'selected' : '' }}
                                                            value='fa-unlink'>&#xf127; fa-unlink </option>
                                                        <option {{ $item->icon === 'fa-unlock' ? 'selected' : '' }}
                                                            value='fa-unlock'>&#xf09c; fa-unlock </option>
                                                        <option {{ $item->icon === 'fa-unlock-alt' ? 'selected' : '' }}
                                                            value='fa-unlock-alt'>&#xf13e; fa-unlock-alt </option>
                                                        <option {{ $item->icon === 'fa-unsorted' ? 'selected' : '' }}
                                                            value='fa-unsorted'>&#xf0dc; fa-unsorted </option>
                                                        <option {{ $item->icon === 'fa-upload' ? 'selected' : '' }}
                                                            value='fa-upload'>&#xf093; fa-upload </option>
                                                        <option {{ $item->icon === 'fa-usb' ? 'selected' : '' }}
                                                            value='fa-usb'>&#xf287; fa-usb </option>
                                                        <option {{ $item->icon === 'fa-usd' ? 'selected' : '' }}
                                                            value='fa-usd'>&#xf155; fa-usd </option>
                                                        <option {{ $item->icon === 'fa-user' ? 'selected' : '' }}
                                                            value='fa-user'>&#xf007; fa-user </option>
                                                        <option {{ $item->icon === 'fa-user-circle' ? 'selected' : '' }}
                                                            value='fa-user-circle'>&#xf2bd; fa-user-circle </option>
                                                        <option {{ $item->icon === 'fa-user-circle-o' ? 'selected' : '' }}
                                                            value='fa-user-circle-o'>&#xf2be; fa-user-circle-o </option>
                                                        <option {{ $item->icon === 'fa-user-md' ? 'selected' : '' }}
                                                            value='fa-user-md'>&#xf0f0; fa-user-md </option>
                                                        <option {{ $item->icon === 'fa-user-o' ? 'selected' : '' }}
                                                            value='fa-user-o'>&#xf2c0; fa-user-o </option>
                                                        <option {{ $item->icon === 'fa-user-plus' ? 'selected' : '' }}
                                                            value='fa-user-plus'>&#xf234; fa-user-plus </option>
                                                        <option {{ $item->icon === 'fa-user-secret' ? 'selected' : '' }}
                                                            value='fa-user-secret'>&#xf21b; fa-user-secret </option>
                                                        <option {{ $item->icon === 'fa-user-times' ? 'selected' : '' }}
                                                            value='fa-user-times'>&#xf235; fa-user-times </option>
                                                        <option {{ $item->icon === 'fa-users' ? 'selected' : '' }}
                                                            value='fa-users'>&#xf0c0; fa-users </option>
                                                        <option {{ $item->icon === 'fa-vcard' ? 'selected' : '' }}
                                                            value='fa-vcard'>&#xf2bb; fa-vcard </option>
                                                        <option {{ $item->icon === 'fa-vcard-o' ? 'selected' : '' }}
                                                            value='fa-vcard-o'>&#xf2bc; fa-vcard-o </option>
                                                        <option {{ $item->icon === 'fa-venus' ? 'selected' : '' }}
                                                            value='fa-venus'>&#xf221; fa-venus </option>
                                                        <option {{ $item->icon === 'fa-venus-double' ? 'selected' : '' }}
                                                            value='fa-venus-double'>&#xf226; fa-venus-double </option>
                                                        <option {{ $item->icon === 'fa-venus-mars' ? 'selected' : '' }}
                                                            value='fa-venus-mars'>&#xf228; fa-venus-mars </option>
                                                        <option {{ $item->icon === 'fa-viacoin' ? 'selected' : '' }}
                                                            value='fa-viacoin'>&#xf237; fa-viacoin </option>
                                                        <option {{ $item->icon === 'fa-viadeo' ? 'selected' : '' }}
                                                            value='fa-viadeo'>&#xf2a9; fa-viadeo </option>
                                                        <option {{ $item->icon === 'fa-viadeo-square' ? 'selected' : '' }}
                                                            value='fa-viadeo-square'>&#xf2aa; fa-viadeo-square </option>
                                                        <option {{ $item->icon === 'fa-video-camera' ? 'selected' : '' }}
                                                            value='fa-video-camera'>&#xf03d; fa-video-camera </option>
                                                        <option {{ $item->icon === 'fa-vimeo' ? 'selected' : '' }}
                                                            value='fa-vimeo'>&#xf27d; fa-vimeo </option>
                                                        <option {{ $item->icon === 'fa-vimeo-square' ? 'selected' : '' }}
                                                            value='fa-vimeo-square'>&#xf194; fa-vimeo-square </option>
                                                        <option {{ $item->icon === 'fa-vine' ? 'selected' : '' }}
                                                            value='fa-vine'>&#xf1ca; fa-vine </option>
                                                        <option {{ $item->icon === 'fa-vk' ? 'selected' : '' }}
                                                            value='fa-vk'>&#xf189; fa-vk </option>
                                                        <option
                                                            {{ $item->icon === 'fa-volume-control-phone' ? 'selected' : '' }}
                                                            value='fa-volume-control-phone'>&#xf2a0;
                                                            fa-volume-control-phone </option>
                                                        <option {{ $item->icon === 'fa-volume-down' ? 'selected' : '' }}
                                                            value='fa-volume-down'>&#xf027; fa-volume-down </option>
                                                        <option {{ $item->icon === 'fa-volume-off' ? 'selected' : '' }}
                                                            value='fa-volume-off'>&#xf026; fa-volume-off </option>
                                                        <option {{ $item->icon === 'fa-volume-up' ? 'selected' : '' }}
                                                            value='fa-volume-up'>&#xf028; fa-volume-up </option>
                                                        <option {{ $item->icon === 'fa-warning' ? 'selected' : '' }}
                                                            value='fa-warning'>&#xf071; fa-warning </option>
                                                        <option {{ $item->icon === 'fa-wechat' ? 'selected' : '' }}
                                                            value='fa-wechat'>&#xf1d7; fa-wechat </option>
                                                        <option {{ $item->icon === 'fa-weibo' ? 'selected' : '' }}
                                                            value='fa-weibo'>&#xf18a; fa-weibo </option>
                                                        <option {{ $item->icon === 'fa-weixin' ? 'selected' : '' }}
                                                            value='fa-weixin'>&#xf1d7; fa-weixin </option>
                                                        <option {{ $item->icon === 'fa-whatsapp' ? 'selected' : '' }}
                                                            value='fa-whatsapp'>&#xf232; fa-whatsapp </option>
                                                        <option {{ $item->icon === 'fa-wheelchair' ? 'selected' : '' }}
                                                            value='fa-wheelchair'>&#xf193; fa-wheelchair </option>
                                                        <option {{ $item->icon === 'fa-wheelchair-alt' ? 'selected' : '' }}
                                                            value='fa-wheelchair-alt'>&#xf29b; fa-wheelchair-alt </option>
                                                        <option {{ $item->icon === 'fa-wifi' ? 'selected' : '' }}
                                                            value='fa-wifi'>&#xf1eb; fa-wifi </option>

                                                    </select>
                                                </div>


                                                <div class="mb-1">
                                                    <label for="desc" class="form-label">{{ __('locale.Description') }}</label>

                                                    <textarea class="form-control" name="description"> {{ $item->description }}</textarea>
                                                    <span class="error error-description  "></span>

                                                </div>

                                            </div>
                                            <div class="my-1">

                                                <button type="submit"
                                                    class="btn btn-primary update-btn me-1">{{ __('locale.Update') }}</button>
                                                <button type="button" class="btn btn-outline-danger update-btn"
                                                    data-bs-dismiss="modal">
                                                    {{ __('locale.Delete') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal modal-slide-in sidebar-todo-modal fade" id="copy-modal{{ $item->id }}">
                            <div class="modal-dialog sidebar-lg">
                                <div class="modal-content p-0">

                                    <div class="alert alert-danger print-error-msg" style="display:none">
                                        <ul></ul>
                                    </div>
                                    <form id="form-copy" class=" form-copy todo-modal" novalidate
                                        method="POST"
                                        action="{{ route('admin.governance.framework.copy', $item->id) }}">
                                        @csrf

                                        <div class="modal-header align-items-center mb-1">
                                            <h5 class="modal-title">{{ __('locale.Copy') }} {{ __('governance.Framework') }}</h5>
                                            <div
                                                class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                                                <span class="todo-item-favorite cursor-pointer me-75"><i
                                                        data-feather="star" class="font-medium-2"></i></span>
                                                <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal"
                                                    stroke-width="3"></i>
                                            </div>
                                        </div>
                                        <div class="modal-body flex-grow-1 pb-sm-0 pb-3">

                                            <div class="action-tags">
                                                <div class="mb-1">
                                                    <label for="title" class="form-label">{{ __('locale.Title') }}</label>
                                                    <input type="text" name="name" class=" form-control"
                                                        placeholder="Title" value="{{ $item->name }}" required />

                                                    <span class="error error-name "></span>

                                                </div>

                                                <div class="mb-1 position-relative">
                                                    <label for="task-assigned" class="form-label d-block">{{ __('locale.Icons') }}</label>
                                                    <select class="form-select"
                                                        style="text-align-last: left;font-weight: 600;margin-right: 0;vertical-align: text-bottom;"
                                                        id="view_type_sorting" aria-haspopup="true" aria-expanded="false"
                                                        name="icon">
                                                        <option {{ $item->icon === 'fas fa-ban' ? 'selected' : '' }}
                                                            value='fas fa-ban'>&#xf05e; fa-ban</option>
                                                        <option {{ $item->icon === 'fas fa-bug' ? 'selected' : '' }}
                                                            value='fas fa-bug'>&#xf188; fa-bug</option>
                                                        <option {{ $item->icon === 'fas fa-dungeon' ? 'selected' : '' }}
                                                            value='fas fa-dungeon'>&#xf6d9; fa-dungeon</option>
                                                        <option {{ $item->icon === 'far fa-eye' ? 'selected' : '' }}
                                                            value='far fa-eye'>&#xf06e; fa-eye </option>
                                                        <option {{ $item->icon === 'far fa-eye-slash' ? 'selected' : '' }}
                                                            value='far fa-eye-slash'>&#xf070; fa-eye-slash </option>
                                                        <option
                                                            {{ $item->icon === 'fas fa-id-fingerprint' ? 'selected' : '' }}
                                                            value='fas fa-file-signature'>&#xf573; fa-file-signature
                                                        </option>
                                                        <option
                                                            {{ $item->icon === 'fas fa-id-fingerprint' ? 'selected' : '' }}
                                                            value='fas fa-id-fingerprint'>&#xf577; fa-id-fingerprint
                                                        </option>
                                                        <option {{ $item->icon === 'far fa-id-badge' ? 'selected' : '' }}
                                                            value='far fa-id-badge'>&#xf2c1; fa-id-badge</option>
                                                        <option {{ $item->icon === 'fas fa-id-badge' ? 'selected' : '' }}
                                                            value='fas fa-id-badge'>&#xf2c1; fa-id-badge </option>
                                                        <option {{ $item->icon === 'far fa-id-card' ? 'selected' : '' }}
                                                            value='far fa-id-card'>&#xf2c2;fa-id-card </option>
                                                        <option {{ $item->icon === 'fas fa-key' ? 'selected' : '' }}
                                                            value='fas fa-key'>&#xf084; fa-key </option>
                                                        <option {{ $item->icon === 'fas  fa-lock' ? 'selected' : '' }}
                                                            value='fas  fa-lock'>&#xf023; fa-lock</option>
                                                        <option {{ $item->icon === 'fas fa-unlock' ? 'selected' : '' }}
                                                            value='fas fa-unlock'>&#xf09c; fa-unlock</option>
                                                        <!-- <option value='fas fa-unlock-alt'>&#xf13e; fa-unlock-alt </option> -->
                                                        <!-- <option value='fas user-lock'>&#xf502; user-lock</option> -->
                                                        <option
                                                            {{ $item->icon === 'fas fa-user-secret' ? 'selected' : '' }}
                                                            value='fas fa-user-secret'>&#xf21b; fa-user-secret </option>
                                                        <option {{ $item->icon === 'fa-underline' ? 'selected' : '' }}
                                                            value='fa-underline'>&#xf0cd; fa-underline </option>
                                                        <option {{ $item->icon === 'fa-undo' ? 'selected' : '' }}
                                                            value='fa-undo'>&#xf0e2; fa-undo </option>
                                                        <option
                                                            {{ $item->icon === 'fa-universal-access' ? 'selected' : '' }}
                                                            value='fa-universal-access'>&#xf29a; fa-universal-access
                                                        </option>
                                                        <option {{ $item->icon === 'fa-university' ? 'selected' : '' }}
                                                            value='fa-university'>&#xf19c; fa-university </option>
                                                        <option {{ $item->icon === 'fa-unlink' ? 'selected' : '' }}
                                                            value='fa-unlink'>&#xf127; fa-unlink </option>
                                                        <option {{ $item->icon === 'fa-unlock' ? 'selected' : '' }}
                                                            value='fa-unlock'>&#xf09c; fa-unlock </option>
                                                        <option {{ $item->icon === 'fa-unlock-alt' ? 'selected' : '' }}
                                                            value='fa-unlock-alt'>&#xf13e; fa-unlock-alt </option>
                                                        <option {{ $item->icon === 'fa-unsorted' ? 'selected' : '' }}
                                                            value='fa-unsorted'>&#xf0dc; fa-unsorted </option>
                                                        <option {{ $item->icon === 'fa-upload' ? 'selected' : '' }}
                                                            value='fa-upload'>&#xf093; fa-upload </option>
                                                        <option {{ $item->icon === 'fa-usb' ? 'selected' : '' }}
                                                            value='fa-usb'>&#xf287; fa-usb </option>
                                                        <option {{ $item->icon === 'fa-usd' ? 'selected' : '' }}
                                                            value='fa-usd'>&#xf155; fa-usd </option>
                                                        <option {{ $item->icon === 'fa-user' ? 'selected' : '' }}
                                                            value='fa-user'>&#xf007; fa-user </option>
                                                        <option {{ $item->icon === 'fa-user-circle' ? 'selected' : '' }}
                                                            value='fa-user-circle'>&#xf2bd; fa-user-circle </option>
                                                        <option {{ $item->icon === 'fa-user-circle-o' ? 'selected' : '' }}
                                                            value='fa-user-circle-o'>&#xf2be; fa-user-circle-o </option>
                                                        <option {{ $item->icon === 'fa-user-md' ? 'selected' : '' }}
                                                            value='fa-user-md'>&#xf0f0; fa-user-md </option>
                                                        <option {{ $item->icon === 'fa-user-o' ? 'selected' : '' }}
                                                            value='fa-user-o'>&#xf2c0; fa-user-o </option>
                                                        <option {{ $item->icon === 'fa-user-plus' ? 'selected' : '' }}
                                                            value='fa-user-plus'>&#xf234; fa-user-plus </option>
                                                        <option {{ $item->icon === 'fa-user-secret' ? 'selected' : '' }}
                                                            value='fa-user-secret'>&#xf21b; fa-user-secret </option>
                                                        <option {{ $item->icon === 'fa-user-times' ? 'selected' : '' }}
                                                            value='fa-user-times'>&#xf235; fa-user-times </option>
                                                        <option {{ $item->icon === 'fa-users' ? 'selected' : '' }}
                                                            value='fa-users'>&#xf0c0; fa-users </option>
                                                        <option {{ $item->icon === 'fa-vcard' ? 'selected' : '' }}
                                                            value='fa-vcard'>&#xf2bb; fa-vcard </option>
                                                        <option {{ $item->icon === 'fa-vcard-o' ? 'selected' : '' }}
                                                            value='fa-vcard-o'>&#xf2bc; fa-vcard-o </option>
                                                        <option {{ $item->icon === 'fa-venus' ? 'selected' : '' }}
                                                            value='fa-venus'>&#xf221; fa-venus </option>
                                                        <option {{ $item->icon === 'fa-venus-double' ? 'selected' : '' }}
                                                            value='fa-venus-double'>&#xf226; fa-venus-double </option>
                                                        <option {{ $item->icon === 'fa-venus-mars' ? 'selected' : '' }}
                                                            value='fa-venus-mars'>&#xf228; fa-venus-mars </option>
                                                        <option {{ $item->icon === 'fa-viacoin' ? 'selected' : '' }}
                                                            value='fa-viacoin'>&#xf237; fa-viacoin </option>
                                                        <option {{ $item->icon === 'fa-viadeo' ? 'selected' : '' }}
                                                            value='fa-viadeo'>&#xf2a9; fa-viadeo </option>
                                                        <option {{ $item->icon === 'fa-viadeo-square' ? 'selected' : '' }}
                                                            value='fa-viadeo-square'>&#xf2aa; fa-viadeo-square </option>
                                                        <option {{ $item->icon === 'fa-video-camera' ? 'selected' : '' }}
                                                            value='fa-video-camera'>&#xf03d; fa-video-camera </option>
                                                        <option {{ $item->icon === 'fa-vimeo' ? 'selected' : '' }}
                                                            value='fa-vimeo'>&#xf27d; fa-vimeo </option>
                                                        <option {{ $item->icon === 'fa-vimeo-square' ? 'selected' : '' }}
                                                            value='fa-vimeo-square'>&#xf194; fa-vimeo-square </option>
                                                        <option {{ $item->icon === 'fa-vine' ? 'selected' : '' }}
                                                            value='fa-vine'>&#xf1ca; fa-vine </option>
                                                        <option {{ $item->icon === 'fa-vk' ? 'selected' : '' }}
                                                            value='fa-vk'>&#xf189; fa-vk </option>
                                                        <option
                                                            {{ $item->icon === 'fa-volume-control-phone' ? 'selected' : '' }}
                                                            value='fa-volume-control-phone'>&#xf2a0;
                                                            fa-volume-control-phone </option>
                                                        <option {{ $item->icon === 'fa-volume-down' ? 'selected' : '' }}
                                                            value='fa-volume-down'>&#xf027; fa-volume-down </option>
                                                        <option {{ $item->icon === 'fa-volume-off' ? 'selected' : '' }}
                                                            value='fa-volume-off'>&#xf026; fa-volume-off </option>
                                                        <option {{ $item->icon === 'fa-volume-up' ? 'selected' : '' }}
                                                            value='fa-volume-up'>&#xf028; fa-volume-up </option>
                                                        <option {{ $item->icon === 'fa-warning' ? 'selected' : '' }}
                                                            value='fa-warning'>&#xf071; fa-warning </option>
                                                        <option {{ $item->icon === 'fa-wechat' ? 'selected' : '' }}
                                                            value='fa-wechat'>&#xf1d7; fa-wechat </option>
                                                        <option {{ $item->icon === 'fa-weibo' ? 'selected' : '' }}
                                                            value='fa-weibo'>&#xf18a; fa-weibo </option>
                                                        <option {{ $item->icon === 'fa-weixin' ? 'selected' : '' }}
                                                            value='fa-weixin'>&#xf1d7; fa-weixin </option>
                                                        <option {{ $item->icon === 'fa-whatsapp' ? 'selected' : '' }}
                                                            value='fa-whatsapp'>&#xf232; fa-whatsapp </option>
                                                        <option {{ $item->icon === 'fa-wheelchair' ? 'selected' : '' }}
                                                            value='fa-wheelchair'>&#xf193; fa-wheelchair </option>
                                                        <option {{ $item->icon === 'fa-wheelchair-alt' ? 'selected' : '' }}
                                                            value='fa-wheelchair-alt'>&#xf29b; fa-wheelchair-alt </option>
                                                        <option {{ $item->icon === 'fa-wifi' ? 'selected' : '' }}
                                                            value='fa-wifi'>&#xf1eb; fa-wifi </option>

                                                    </select>
                                                </div>


                                                <div class="mb-1">
                                                    <label for="desc" class="form-label">{{ __('locale.Description') }}</label>

                                                    <textarea class="form-control" name="description"> {{ $item->description }}</textarea>
                                                    <span class="error error-description  "></span>

                                                </div>

                                            </div>
                                            <div class="my-1">

                                                <button type="submit"
                                                    class="btn btn-primary me-1">{{ __('locale.Copy') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Right Sidebar ends -->

                        <!-- Right Sidebar starts -->
                        <div class="modal modal-slide-in sidebar-todo-modal fade" id="add_control{{ $item->id }}">
                            <div class="modal-dialog sidebar-lg">
                                <div class="modal-content p-0">
                                    <form id="form-add_control" class=" form-add_control todo-modal needs-validation"
                                        novalidate method="POST"
                                        action="{{ route('admin.governance.control.store', $item->id) }}">
                                        @csrf

                                        <div class="modal-header align-items-center mb-1">
                                            <h5 class="modal-title">Add Control</h5>
                                            <div
                                                class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                                                <span class="todo-item-favorite cursor-pointer me-75"><i
                                                        data-feather="star" class="font-medium-2"></i></span>
                                                <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal"
                                                    stroke-width="3"></i>
                                            </div>
                                        </div>
                                        <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                            <div class="action-tags">
                                                <div class="mb-1">
                                                    <label for="title" class="form-label">name</label>
                                                    <input type="text" name="name" class=" form-control"
                                                        placeholder="" required />
                                                    <span class="error error-name "></span>

                                                </div>

                                                <div class="mb-1">
                                                    <label for="desc" class="form-label">Description</label>
                                                    <textarea class="form-control" name="description"></textarea>
                                                    <span class="error error-description "></span>

                                                </div>
                                                <div class="mb-1">
                                                    <label for="title" class="form-label">Control number</label>
                                                    <input type="text" name="number" class=" form-control"
                                                        placeholder="" />

                                                </div>

                                                <!--  long_name -->
                                                <div class="mb-1">
                                                    <label class="form-label" for="long_name"> long name </label>
                                                    <input class="form-control" type="text" name="long_name">
                                                </div>

                                                <!--  families -->
                                                <div class="mb-1 family-container">
                                                    <label class="form-label" for="family"> Control domain </label>

                                                    <select class="select2 form-select domain_select" name="family"
                                                        required>
                                                        <option value="">
                                                            select domain
                                                        </option>
                                                        @foreach ($families as $family)
                                                            <option value="{{ $family->id }}"
                                                                data-families="{{ json_encode($family->families) }}">
                                                                {{ $family->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-family"></span>
                                                </div>

                                                {{-- sub families --}}
                                                <div class="mb-1">
                                                    <label
                                                        class="form-label ">{{ __('governance.control_sub_domain') }}</label>

                                                    <select class="select2 form-select" name="sub_family" required>
                                                        <option value="" selected>{{ __('locale.select-option') }}
                                                        </option>
                                                    </select>
                                                    <span class="error error-sub_family"></span>
                                                </div>

                                                {{-- Parent control --}}
                                                <div class="mb-1">
                                                    <label
                                                        class="form-label ">{{ __('governance.ParentControlFramework') }}</label>
                                                    <select class="select2 form-select" name="parent_id">
                                                        <option value="" selected>{{ __('locale.select-option') }}
                                                        </option>
                                                        @foreach ($parentControls as $control)
                                                            {{-- <option value="{{ $control->id }}">{{ $control->short_name }}</option> --}}
                                                            @php
                                                                 $controlName = $control->short_name;
                                                                if ($control->Frameworks()->count()) {
                                                                    $controlName .= ' (' . implode(', ', $control->Frameworks()->pluck('name')->toArray()) . ')';
                                                                }
                                                            @endphp
                                                            <option value="{{ $control->id }}">{{ $controlName }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-parent_id"></span>
                                                </div>

                                                <!--  mitigation_guidance -->
                                                <div class="mb-1">
                                                    <label class="form-label" for="mitigation_percent"> mitigation percent
                                                    </label>
                                                    <input class="form-control" type="text" name="mitigation_percent">
                                                </div>

                                                <!--  supplemental_guidance -->
                                                <div class="mb-1">
                                                    <label class="form-label" for="supplemental_guidance"> supplemental
                                                        guidance </label>
                                                    <input class="form-control" type="text"
                                                        name="supplemental_guidance">
                                                </div>



                                                <div class="mb-1">
                                                    <label class="form-label" for="priority"> Control priority </label>

                                                    <select class="select2 form-select" id="task-assigned"
                                                        name="priority">
                                                        <option value="">
                                                            select priority
                                                        </option>
                                                        @foreach ($priorities as $priority)
                                                            <option value="{{ $priority->id }}">
                                                                {{ $priority->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label" for="phase"> Control phase </label>

                                                    <select class="select2 form-select" id="task-assigned"
                                                        name="phase">
                                                        <option value="">
                                                            select phase
                                                        </option>
                                                        @foreach ($phases as $phase)
                                                            <option value="{{ $phase->id }}">
                                                                {{ $phase->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label" for="type"> Control type</label>

                                                    <select class="select2 form-select" id="task-assigned"
                                                        name="type">
                                                        <option value="">
                                                            select type
                                                        </option>
                                                        @foreach ($types as $type)
                                                            <option value="{{ $type->id }}">
                                                                {{ $type->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div class="mb-1">
                                                    <label class="form-label" for="maturity"> Control Maturity </label>

                                                    <select class="select2 form-select" id="task-assigned"
                                                        name="maturity">
                                                        <option value="">
                                                            select maturity
                                                        </option>
                                                        @foreach ($maturities as $maturity)
                                                            <option value="{{ $maturity->id }}">
                                                                {{ $maturity->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div class="mb-1">
                                                    <label class="form-label" for="class"> Control class </label>

                                                    <select class="select2 form-select" id="task-assigned"
                                                        name="class">
                                                        <option value="">
                                                            select class
                                                        </option>
                                                        @foreach ($classes as $class)
                                                            <option value="{{ $class->id }}">
                                                                {{ $class->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div class="mb-1">

                                                    <label class="form-label" for="desired_maturity"> Control desired
                                                        maturity </label>
                                                    <select class="select2 form-select" id="task-assigned"
                                                        name="desired_maturity">
                                                        <option value=""> select Desired Maturity </option>
                                                        @foreach ($desiredMaturities as $desiredMaturity)
                                                            {
                                                            <option value="{{ $desiredMaturity->id }}">
                                                                {{ $desiredMaturity->name }} </option>
                                                        @endforeach

                                                    </select>

                                                </div>

                                                <!-- //owner -->
                                                <div class="mb-1">

                                                    <label class="form-label" for="owner"> Control owner </label>
                                                    <select class="select2 form-select" id="task-assigned"
                                                        name="owner">
                                                        <option value=""> select owner </option>
                                                        @foreach ($owners as $owner)
                                                            {
                                                            <option value="{{ $owner->id }}"> {{ $owner->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>



                                                </div>

                                                <!-- //add test start-->

                                                <div class="mb-1">
                                                    <label class="form-label "
                                                        for="select2-basic1">{{ __('governance.Tester') }}</label>
                                                    <select class="select2 form-select" name="tester">
                                                        <option value="">{{ __('locale.select-option') }}</option>
                                                        @foreach ($testers as $tester)
                                                            <option value="{{ $tester->id }}">{{ $tester->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                    <span class="error error-tester "></span>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label"
                                                        for="basic-icon-default-post">{{ __('governance.TestName') }}</label>
                                                    <input type="text" name="test_name" id="basic-icon-default-post"
                                                        class="form-control dt-post" aria-label="Web Developer"
                                                        required />
                                                    <span class="error error-test_name "></span>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label"
                                                        for="normalMultiSelect1">{{ __('governance.TestFrequency') }}
                                                        ({{ __('locale.days') }})</label>
                                                    <input name="test_frequency" type="number" min="0" class="form-control " />
                                                    <span class="error error-test_frequency "></span>
                                                </div>

                                                <div class=" mb-1">
                                                    <label class="form-label" for="fp-default">
                                                        {{ __('locale.LastTestDate') }}</label>
                                                    <input type="text" data-i="0" name="last_date"
                                                        placeholder="YYYY-MM-DD " class="form-control js-datepicker">

                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label"
                                                        for="exampleFormControlTextarea1">{{ __('governance.TestSteps') }}</label>
                                                    <textarea class="form-control" name="test_steps" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                    <span class="error error-test_steps "></span>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="normalMultiSelect1">
                                                        {{ __('locale.ApproximateTime') }}
                                                        ({{ __('locale.minutes') }})</label>
                                                    <input name="approximate_time" type="number" min="0"
                                                        id="basic-icon-default-post" class="form-control dt-post"
                                                        aria-label="Web Developer" />
                                                    <span class="error error-approximate_time "></span>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="exampleFormControlTextarea1">
                                                        {{ __('locale.ExpectedResults') }}</label>
                                                    <textarea class="form-control" name="expected_results" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                    <span class="error error-expected_results"></span>
                                                </div>

                                                <!--add test end -->
                                            </div>

                                            <div class="my-1">
                                                <button type="submit"
                                                    class="btn btn-primary me-1">Add</button>
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Right Sidebar ends -->

                        {{-- Framework control table --}}
                        {{-- <li class="todo-item">

                            <!-- Advanced Search -->
                            <section id="advanced-search-datatable">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">

                                            <div class="card-header border-bottom p-1">
                                                <div class="head-label">
                                                    <h4 class="card-title">{{ __('locale.Controls') }}</h4>
                                                </div>
                                                @if (auth()->user()->hasPermission('control.create'))
                                                    <div class="dt-action-buttons text-end">
                                                        <div class="dt-buttons d-inline-flex">
                                                            <button class="dt-button  btn btn-primary  me-2"
                                                                type="button" data-bs-toggle="modal"
                                                                data-bs-target="#add_control{{ $item->id }}">
                                                                Add control
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <!--Search Form -->


                                            <hr class="my-0" />
                                            <div class="card-datatable table-responsive">

                                                <table class="dt-advanced-search{{ $item->id }} table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th class="all">{{ __('Name') }}</th>
                                                            <th class="all">{{ __('Description') }}</th>
                                                            <th class="all">{{ __('Control Domain') }}</th>
                                                            <th class="all">{{ __('control_sub_domain') }}</th>
                                                            <th class="all">{{ __('Unmap') }}</th>
                                                            <th class="all">{{ __('Actions') }}</th>
                                                        </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!--/ Advanced Search -->

                        </li> --}}

                        {{-- Framework domains and sub-domains --}}
                        @if (count($item->only_families) > 0)
                            <li class="todo-item">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>{{ __('governance.Domain') }}</th>
                                            <th>{{ __('governance.sub_domains') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($item->only_families as $domain)
                                        <tr>
                                            <td>{{ $domain->name }}</td>
                                            <td>
                                                @foreach ($item->only_sub_families as $subDomain)
                                                @if ($domain->id == $subDomain->parent_id)
                                                    <span class="badge rounded-pill badge-light-primary" style="margin: 4px">{{ $subDomain->name }}</span>
                                                @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </li>
                        @endif

                    </div>
                @endforeach


            </ul>
            <div class="no-results">
                <h5>No Items Found</h5>
            </div>
        </div>
        <!-- Todo List ends -->
    </div>

    <!-- Right Sidebar starts -->
<div class="modal modal-slide-in sidebar-todo-modal fade" id="new-frame-modal">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <form id="add_frame" class="add_frame todo-modal needs-validation" novalidate method="POST"
                    action="{{ route('admin.governance.framework.store') }}">
                    @csrf

                    <div class="modal-header align-items-center mb-1">
                        <h5 class="modal-title">{{ __('locale.Add') }} {{ __('governance.Framework') }}</h5>
                        <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                            <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                    class="font-medium-2"></i></span>
                            <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                        </div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="action-tags">
                            {{-- Title --}}
                            <div class="mb-1">
                                <label for="title" class="form-label">{{ __('locale.Title') }}</label>
                                <input type="text" name="name" class=" form-control" placeholder="Title"
                                    required />
                                <span class="error error-name "></span>
                            </div>

                            {{-- families --}}
                            <div class="mb-1 family-container">
                                <label class="form-label" for="family">{{ __('governance.Control Domain') }}</label>

                                <select class="select2 form-select framework_domain_select" data-prev="[]" multiple name="family[]" required>
                                    @foreach ($families as $family)
                                        <option value="{{ $family->id }}"
                                            data-families="{{ json_encode($family->custom_families_framework) }}">{{ $family->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="error error-family"></span>
                            </div>

                            {{-- sub families --}}
                            <div class="mb-1">
                                <label class="form-label ">{{ __('governance.control_sub_domain') }}</label>

                                <select class="select2 form-select" name="sub_family[]" multiple required>
                                </select>
                                <span class="error error-sub_family"></span>
                            </div>

                            {{-- Icon --}}
                            <div class="mb-1 position-relative">
                                <label for="task-assigned" class="form-label d-block">{{ __('locale.Icons') }}</label>
                                <select class="form-select"
                                    style="text-align-last: left;font-weight: 600;margin-right: 0;vertical-align: text-bottom;"
                                    id="view_type_sorting" aria-haspopup="true" aria-expanded="false" name="icon">
                                    <option value='fas fa-ban'>&#xf05e; fa-ban</option>
                                    <option value='fas fa-bug'>&#xf188; fa-bug</option>
                                    <option value='fas fa-dungeon'>&#xf6d9; fa-dungeon</option>
                                    <option value='far fa-eye'>&#xf06e; fa-eye </option>
                                    <option value='far fa-eye-slash'>&#xf070; fa-eye-slash </option>
                                    <option value='fas fa-file-signature'>&#xf573; fa-file-signature</option>
                                    <option value='fas fa-id-fingerprint'>&#xf577; fa-id-fingerprint </option>
                                    <option value='far fa-id-badge'>&#xf2c1; fa-id-badge</option>
                                    <option value='fas fa-id-badge'>&#xf2c1; fa-id-badge </option>
                                    <option value='far fa-id-card'>&#xf2c2;fa-id-card </option>
                                    <option value='fas fa-key'>&#xf084; fa-key </option>
                                    <option value='fas  fa-lock'>&#xf023; fa-lock</option>
                                    <option value='fas fa-unlock'>&#xf09c; fa-unlock</option>
                                    <!-- <option value='fas fa-unlock-alt'>&#xf13e; fa-unlock-alt </option> -->
                                    <!-- <option value='fas user-lock'>&#xf502; user-lock</option> -->
                                    <option value='fas fa-user-secret'>&#xf21b; fa-user-secret </option>
                                    <option value='fa-underline'>&#xf0cd; fa-underline </option>
                                    <option value='fa-undo'>&#xf0e2; fa-undo </option>
                                    <option value='fa-universal-access'>&#xf29a; fa-universal-access </option>
                                    <option value='fa-university'>&#xf19c; fa-university </option>
                                    <option value='fa-unlink'>&#xf127; fa-unlink </option>
                                    <option value='fa-unlock'>&#xf09c; fa-unlock </option>
                                    <option value='fa-unlock-alt'>&#xf13e; fa-unlock-alt </option>
                                    <option value='fa-unsorted'>&#xf0dc; fa-unsorted </option>
                                    <option value='fa-upload'>&#xf093; fa-upload </option>
                                    <option value='fa-usb'>&#xf287; fa-usb </option>
                                    <option value='fa-usd'>&#xf155; fa-usd </option>
                                    <option value='fa-user'>&#xf007; fa-user </option>
                                    <option value='fa-user-circle'>&#xf2bd; fa-user-circle </option>
                                    <option value='fa-user-circle-o'>&#xf2be; fa-user-circle-o </option>
                                    <option value='fa-user-md'>&#xf0f0; fa-user-md </option>
                                    <option value='fa-user-o'>&#xf2c0; fa-user-o </option>
                                    <option value='fa-user-plus'>&#xf234; fa-user-plus </option>
                                    <option value='fa-user-secret'>&#xf21b; fa-user-secret </option>
                                    <option value='fa-user-times'>&#xf235; fa-user-times </option>
                                    <option value='fa-users'>&#xf0c0; fa-users </option>
                                    <option value='fa-vcard'>&#xf2bb; fa-vcard </option>
                                    <option value='fa-vcard-o'>&#xf2bc; fa-vcard-o </option>
                                    <option value='fa-venus'>&#xf221; fa-venus </option>
                                    <option value='fa-venus-double'>&#xf226; fa-venus-double </option>
                                    <option value='fa-venus-mars'>&#xf228; fa-venus-mars </option>
                                    <option value='fa-viacoin'>&#xf237; fa-viacoin </option>
                                    <option value='fa-viadeo'>&#xf2a9; fa-viadeo </option>
                                    <option value='fa-viadeo-square'>&#xf2aa; fa-viadeo-square </option>
                                    <option value='fa-video-camera'>&#xf03d; fa-video-camera </option>
                                    <option value='fa-vimeo'>&#xf27d; fa-vimeo </option>
                                    <option value='fa-vimeo-square'>&#xf194; fa-vimeo-square </option>
                                    <option value='fa-vine'>&#xf1ca; fa-vine </option>
                                    <option value='fa-vk'>&#xf189; fa-vk </option>
                                    <option value='fa-volume-control-phone'>&#xf2a0; fa-volume-control-phone </option>
                                    <option value='fa-volume-down'>&#xf027; fa-volume-down </option>
                                    <option value='fa-volume-off'>&#xf026; fa-volume-off </option>
                                    <option value='fa-volume-up'>&#xf028; fa-volume-up </option>
                                    <option value='fa-warning'>&#xf071; fa-warning </option>
                                    <option value='fa-wechat'>&#xf1d7; fa-wechat </option>
                                    <option value='fa-weibo'>&#xf18a; fa-weibo </option>
                                    <option value='fa-weixin'>&#xf1d7; fa-weixin </option>
                                    <option value='fa-whatsapp'>&#xf232; fa-whatsapp </option>
                                    <option value='fa-wheelchair'>&#xf193; fa-wheelchair </option>
                                    <option value='fa-wheelchair-alt'>&#xf29b; fa-wheelchair-alt </option>
                                    <option value='fa-wifi'>&#xf1eb; fa-wifi </option>

                                </select>
                            </div>
                            <label for="desc" class="form-label">{{ __('locale.Description') }}</label>
                            <textarea class="form-control" name="description"></textarea>
                            <span class="error error-description "></span>
                        </div>

                    </div>
                    <div class="my-1 mx-1">
                        <button type="submit" class="btn btn-primary me-1">{{ __('locale.Add') }}</button>
                        <button type="button" class="btn btn-outline-secondary " data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}
                        </button>

                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    <!-- Right Sidebar ends -->


    <!-- Advanced Search -->

    <!-- Modal -->
    <!-- Dark Tables end -->
    <div class="modal modal-slide-in sidebar-todo-modal fade" id="empModal" role="dialog">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">


                <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">Mapping</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                class="font-medium-2"></i></span>
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div>

                <form class="todo-modal needs-validation" novalidate method="POST"
                    action="{{ route('admin.governance.framework.map') }}">
                    @csrf

                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3" id="form-modal-map">


                    </div>


                </form>


            </div>
        </div>
    </div>

    <!-- //edit control -->
    <!-- Right Sidebar ends -->
    <div class="modal modal-slide-in sidebar-todo-modal fade" id="edit_contModal" role="dialog">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">


                <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">Update Control</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                class="font-medium-2"></i></span>
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div>

                <form id="form-update_control" class="todo-modal needs-validation" novalidate method="POST"
                    action="{{ route('admin.governance.control.update') }}">
                    @csrf

                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3" id="form-modal-edit">


                    </div>


                </form>


            </div>
        </div>
    </div>


    <!--/ Advanced Search -->



    <!-- edit Sidebar starts -->


@endsection


@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>

    {{-- <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script> --}}
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

    <script src="{{ asset('cdn/picker.js') }}"></script>
    <script src="{{ asset('cdn/picker.date.js') }}"></script>

@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script>
        var permission = [];
        permission['edit'] = {{ auth()->user()->hasPermission('control.update')? 1: 0 }};
        permission['delete'] = {{ auth()->user()->hasPermission('control.delete')? 1: 0 }};

        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
            //datepicker start

            var $input = $('.js-datepicker').pickadate({
                format: 'yyyy-mm-dd',
                firstDay: 1,
                formatSubmit: 'yyyy-mm-dd',
                hiddenName: true,
                editable: true
            });

            var picker = {};

            //datepicker end

        });
    </script>

    <script>
        $('.multiple-select2').select2();

        // //tab
        function openTab(evt, cityName, id) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";

            // $( "#todo-item" ).empty();

            var url = "{{ route('admin.governance.ajax.get-list-test', '') }}" + "/" + id;
            var unmap_url = "{{ route('admin.governance.unmap.control', '') }}" + "/" + id;
            var myobj = document.getElementsByClassName('dt-advanced-search' + id);
            $(this).remove();
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                success: function(data) {
                    var isRtl = $('html').attr('data-textdirection') === 'rtl';
                    var dt_ajax_table = $('.datatables-ajax'),
                        dt_filter_table = $('.dt-column-search'),
                        dt_adv_filter_table = $('.dt-advanced-search' + id),
                        dt_responsive_table = $('.dt-responsive'),
                        assetPath = '../../../app-assets/';
                    if ($('body').attr('data-framework') === 'laravel') {
                        assetPath = $('body').attr('data-asset-path');
                    }
                    if (dt_adv_filter_table.length) {
                        dt_adv_filter_table.DataTable().clear().destroy();
                        var dt_adv_filter = dt_adv_filter_table.DataTable({
                            data: data,
                            lengthMenu: [
                                [10, 25, 50, -1],
                                [10, 25, 50, "All"]
                            ],

                            columns: [{
                                    data: 'responsive_id'
                                },
                                // { data: 'framework' },
                                // { data: 'map_id' },
                                {
                                    data: 'control'
                                },
                                {
                                    data: 'description'
                                },
                                {
                                    data: 'parent_family_name'
                                },
                                {
                                    data: 'family_name'
                                },

                                // { data: 'map_id' },

                                {
                                    data: "map_id",
                                    render: function(data, type, row, meta) {
                                        return type === 'display' ?
                                            '<a  href="javascript:;" onclick="unmap(' + data +
                                            ')" class="item-edit">' +
                                            feather.icons['git-merge'].toSvg({
                                                class: 'font-small-4'
                                            }) +
                                            '</a>' :
                                            data;
                                    }
                                },

                                {
                                    data: 'id'
                                },

                            ],
                            columnDefs: [
                                { width: '35%', targets: 2 },
                                {
                                title: '#',
                                className: 'index',
                                orderable: false,
                                responsivePriority: 2,
                                targets: 0
                            }, {
                                // Actions
                                targets: -1,
                                title: 'Actions',
                                orderable: false,
                                render: function(data, type, full, meta) {
                                    let returnedString = '';
                                    if (permission['edit']) {
                                        returnedString +=
                                            '<a  href="javascript:;" onclick="editControl(' +
                                            data + ')" class="item-edit dropdown-item ">' +
                                            feather.icons['edit'].toSvg({
                                                class: 'me-50 font-small-4'
                                            }) +
                                            'Edit</a>';
                                    }

                                    if (permission['delete']) {
                                        returnedString +=
                                            '<a  href="javascript:;" onclick="deleteControl(' +
                                            data +
                                            ')" class="dropdown-item  btn-flat-danger">' +
                                            feather.icons['trash-2'].toSvg({
                                                class: 'me-50 font-small-4'
                                            }) +
                                            'Delete</a>';
                                    }


                                    if (returnedString == '')
                                        return ('------');
                                    else
                                        return (
                                            '<div class="d-inline-flex">' +
                                            '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                            feather.icons['more-vertical'].toSvg({
                                                class: 'font-small-4'
                                            }) +
                                            '</a>' +
                                            '<div class="dropdown-menu dropdown-menu-end">' +
                                            returnedString +
                                            '</div>' +
                                            '</div>'
                                        );
                                }
                            }],
                            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                            orderCellsTop: true,
                            responsive: {
                                details: {
                                    display: $.fn.dataTable.Responsive.display.modal({
                                        header: function(row) {
                                            var data = row.data();
                                            return 'Details of ' + data['name'];
                                        }
                                    }),
                                    type: 'column',
                                    renderer: function(api, rowIdx, columns) {
                                        var data = $.map(columns, function(col, i) {
                                            return col.title !== '' ?
                                                '<tr data-dt-row="' +
                                                col.rowIndex +
                                                '" data-dt-column="' +
                                                col.columnIndex +
                                                '">' +
                                                '<td>' +
                                                col.title +
                                                ':' +
                                                '</td> ' +
                                                '<td>' +
                                                col.data +
                                                '</td>' +
                                                '</tr>' :
                                                '';
                                        }).join('');
                                        return data ? $('<table class="table"/><tbody />').append(
                                            data) : false;
                                    }
                                }
                            },
                            language: {
                                paginate: {
                                    previous: '&nbsp;',
                                    next: '&nbsp;'
                                }
                            }
                        });
                        dt_adv_filter.on('order.dt search.dt', function() {
                            dt_adv_filter.column(0, {
                                search: 'applied',
                                order: 'applied'
                            }).nodes().each(function(cell, i) {
                                cell.innerHTML = i + 1;
                            });
                        }).draw();
                    }
                    $('input.dt-input').on('keyup', function() {
                        filterColumn($(this).attr('data-column'), $(this).val());
                    });
                    $('select.dt-select').on('change', function() {
                        filterColumn($(this).attr('data-column'), $(this).val());
                    });
                    $('.dataTables_filter .form-control').removeClass('form-control-sm');
                    $('.dataTables_length .form-select').removeClass('form-select-sm').removeClass(
                        'form-control-sm');
                },
                error: function() {
                    //
                }
            });

            function filterColumn(i, val) {
                $('.dt-advanced-search').DataTable().column(i).search(val, false, true).draw();
            }

        }

        @if (count($category2))
            document.getElementById("defaultOpen").click();
        @endif

        // // mapping using ajax
        $('.userinfo').click(function() {

            var userid = $(this).data('id');
            var url = "{{ route('admin.governance.ajax.get-list-map', '') }}" + "/" + userid;

            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {
                    $('#empModal').modal('show');
                    $('#form-modal-map').html(response);

                }
            });
        });


        // unmap
        // // mapping using ajax
        function unmap(data) {

            var unmap_url = "{{ route('admin.governance.unmap.control', '') }}" + "/" + data;
            // AJAX request
            $.ajax({
                url: unmap_url,
                type: "GET",
                data: {},
                success: function(response) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    location.reload();
                }
            });
        };


        // edit control
        function editControl(data) {

            var url = "{{ route('admin.governance.ajax.edit_control', '') }}" + "/" + data;
            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {

                    $('#edit_contModal').modal('show');
                    $('#form-modal-edit').html(response);

                    $('#form-modal-edit').find('.select2').select2();
                }

            });
        };



        $(".frame_del").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        if (data.reload)
                            location.reload();
                    } else {
                        makeAlert('error', data.message, "{{ __('locale.Error') }}");
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    showError(responseData.errors);
                }
            });
        });



        $('.form-edit').submit(function(e) {
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


        $('.form-copy').submit(function(e) {
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

        $('.form-add_control').submit(function(e) {
            e.preventDefault();

            $('.error').empty();
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


        $('#form-update_control').submit(function(e) {
            e.preventDefault();
            $('.error').empty();
            $.ajax({
                url: $('#form-update_control').attr('action'),
                type: 'POST',
                data: $('#form-update_control').serialize(),
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


        function showError(data) {
            $('.error').empty();
            $.each(data, function(key, value) {
                $('.error-' + key).empty();
                $('.error-' + key).append(value);
            });
        }

        // status [warning, success, error]
        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }



        // $(document).ready(function() {


        //     'use strict'

        //     // Fetch all the forms we want to apply custom Bootstrap validation styles to
        //     var forms = document.querySelectorAll('.needs-validation')
        //     // Loop over them and prevent submission
        //     Array.prototype.slice.call(forms)
        //         .forEach(function(form) {
        //             form.addEventListener('submit', function(event) {
        //                 if (!form.checkValidity()) {
        //                     event.preventDefault()
        //                     event.stopPropagation()
        //                 } else if (form.checkValidity() == true) {
        //                     // makeAlert('success', "created successfuly", "{{ __('locale.Success') }}");
        //                     // location.reload();

        //                     // stop form submit only for demo
        //                     // event.preventDefault();
        //                 }

        //                 form.classList.add('was-validated')


        //             }, false)
        //         })
        // });


        function deleteControl(data) {
            var url = "{{ route('admin.governance.control.destroy', '') }}" + "/" + data;
            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $("#advanced-search-datatable").load(location.href + " #advanced-search-datatable>*",
                            "");
                        location.reload();
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });
        }

        // Load subdomains of domain
        $(document).on('change', '.domain_select', function() {
            const subDomains = $(this).find('option:selected').data('families');
            const subDomainSelect = $(this).parents('.family-container').next().find('select');
            subDomainSelect.find('option:not(:first)').remove();
            subDomainSelect.find('option:first').attr('selected', true)
            if (subDomains)
                subDomains.forEach(subDomains => {
                    subDomainSelect.append(
                        `<option value="${subDomains.id}">${subDomains.name}</option>`
                    );
                });
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
            $(this).data("prev",$(this).val());
        });

        $(document).on('change', '[name="parent_id"]', function() {
            if ($(this).val()) {
                $('[name="family"]').val('').trigger('change').prop('disabled', true);
                $('[name="sub_family"]').val('').trigger('change').prop('disabled', true);
            } else {
                $('[name="family"]').prop('disabled', false);
                $('[name="sub_family"]').prop('disabled', false);
            }
        });

        $(document).ready(function () {
            $('.framework_domain_select').trigger('change');
            setTimeout(() => {
                const subDomainsSelect = $('.framework_domain_select').parents('.family-container').next().find('select[data-subdomains]');
                subDomainsSelect.each((index, subDomainSelect) => {
                    const sobDomains = $(subDomainSelect).data('subdomains');
                    sobDomains.forEach(domain => {
                        $(subDomainSelect).find('option[value="' + domain + '"]').attr('selected', true).trigger('change');
                    });
                });

            }, 1000);
        });
    </script>


    <script src="{{ asset('js/scripts/pages/app-chat-framework.js') }}"></script>
@endsection
