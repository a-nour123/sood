@extends('admin/layouts/contentLayoutMaster')

@section('title', __('compliance.ViewActiveAudits'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
    <!-- Estaleiro Design System Core CSS -->
    <link rel="stylesheet" href="{{ asset('cdn/core.min.css') }}">
    </link>
    <link rel="stylesheet" href="{{ asset('cdn//rawline.css') }}">
    </link>
    <link rel="stylesheet" href="{{ asset('cdn/all.min.css') }}">
    </link>

@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">

    <style>
        @media (min-width: 576px) {
            .modal-dialog {
                max-width: fit-content !important;
            }
        }

        .modal-add-new-role {
            margin-right: auto;
            margin-left: auto;
        }

        .node circle {
            stroke: #3182bd;
            stroke-width: 3px;
        }

        .node text {
            font: 12px sans-serif;
        }

        .link {
            fill: none;
            stroke: #ccc;
            stroke-width: 2px;
        }

        .br-wizard {
            --wizard-min-height: 300px;
            --wizard-max-height: 800px;
            display: flex;
            flex-direction: column;
            height: 100%;
            margin-bottom: var(--spacing-scale-4x);
            max-height: var(--wizard-max-height);
            max-width: none;
            min-height: var(--wizard-min-height);
        }

        .br-wizard .wizard-progress {
            background-color: #f0f0f0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(0, 1fr));
            grid-template-rows: none;
            min-height: 164px;
            overflow-x: auto;
            overflow-y: hidden;
            padding-top: var(--spacing-scale-7x);
            width: 100%;
        }

        @media (max-width: 991px) {
            .br-wizard .wizard-progress {
                max-height: 100px;
                min-height: 100px;
                overflow-y: hidden;
                padding-top: var(--spacing-scale-3x);
                position: relative;
                transition-delay: 0s;
                transition-duration: 0.25s;
                transition-property: all;
                transition-timing-function: linear;
            }

            .br-wizard .wizard-progress::after {
                background-color: transparent;
                bottom: 2px;
                color: var(--interactive);
                content: "\f7a4";
                display: block;
                font-family: "Font Awesome 5 Free", sans-serif;
                font-size: var(--switch-icon-size);
                font-weight: var(--font-weight-black);
                height: 1em;
                left: 50%;
                margin-left: -0.5em;
                position: absolute;
                top: unset;
                transition-delay: 0s;
                transition-duration: 0.25s;
                transition-property: all;
                transition-timing-function: linear;
                width: auto;
            }
        }

        .br-wizard .wizard-progress-btn {
            background-color: transparent;
            border: 0;
            box-shadow: none !important;
            color: var(--interactive);
            font-size: var(--font-size-scale-up-01, 16.8px);
            line-height: 19px;
            max-height: 90px;
            padding-bottom: 0;
            padding-top: var(--spacing-scale-2x);
            position: relative;
            text-indent: 0;
            transition-delay: 0s;
            transition-duration: 0.15s;
            transition-property: all;
            transition-timing-function: linear;
        }

        .br-wizard .wizard-progress-btn[disabled] {
            color: rgba(var(--interactive-rgb), var(--disabled));
            opacity: 1;
        }

        .br-wizard .wizard-progress-btn[disabled]::before {
            opacity: var(--disabled);
        }

        .br-wizard .wizard-progress-btn:focus {
            outline: none;
        }

        .br-wizard .wizard-progress-btn.focus-visible:not([disabled]):not(.disabled)::before,
        .br-wizard .wizard-progress-btn:focus-visible:not([disabled]):not(.disabled)::before {
            outline-color: var(--focus-color);
            outline-offset: var(--focus-offset);
            outline-style: var(--focus-style);
            outline-width: var(--focus-width);
        }

        .br-wizard .wizard-progress-btn:hover:not([disabled])::before {
            background-image: linear-gradient(rgba(var(--interactive-rgb), var(--hover)), rgba(var(--interactive-rgb), var(--hover)));
        }

        .br-wizard .wizard-progress-btn:active:not([disabled])::before {
            background-image: linear-gradient(rgba(var(--interactive-rgb), var(--pressed)), rgba(var(--interactive-rgb), var(--pressed)));
        }

        .br-wizard .wizard-progress-btn::before {
            background-color: var(--background);
            border: 2px solid var(--interactive);
            border-radius: 50%;
            box-sizing: border-box;
            color: var(--interactive);
            content: attr(step) !important;
            display: block;
            font-size: var(--font-size-scale-up-02, 20.16px);
            font-weight: var(--font-weight-semi-bold, 600);
            height: 36px;
            left: 50%;
            line-height: 29px;
            margin-top: -13px;
            position: absolute;
            top: 0;
            transform: translateX(-50%);
            transition: all 0.15s linear 0s, transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
            width: 36px;
            z-index: 3;
        }

        .br-wizard .wizard-progress-btn::after {
            background-color: var(--interactive) !important;
            content: "";
            display: block;
            height: 1px;
            left: calc(-50% + 17px);
            position: absolute;
            top: 5px;
            transition-delay: 0s;
            transition-duration: 0.15s;
            transition-property: all;
            transition-timing-function: linear;
            width: calc(100% - 34px);
            z-index: 1;
        }

        .br-wizard .wizard-progress-btn:first-child::after {
            display: none;
        }

        .br-wizard .wizard-progress-btn[active] {
            color: var(--active);
            font-weight: var(--font-weight-semi-bold, 600);
        }

        .br-wizard .wizard-progress-btn[active]::after {
            background-color: var(--active);
        }

        .br-wizard .wizard-progress-btn[active]::before {
            background-color: var(--active);
            border: 2px solid var(--background-light);
            color: var(--background-light);
            font-weight: var(--font-weight-bold, 700);
        }

        @media (max-width: 991px) {
            .br-wizard .wizard-progress-btn .info {
                font-size: var(--font-size-scale-down-02, 9.716px);
                line-height: 1em;
                text-align: center;
            }
        }

        @media (max-width: 991px) {
            .br-wizard[collapsed] .wizard-progress {
                max-height: 64px;
                min-height: 64px;
                overflow-y: hidden;
                padding-bottom: var(--spacing-scale-3x);
                padding-top: var(--spacing-scale-3x);
            }

            .br-wizard[collapsed] .wizard-progress::after {
                margin-top: var(--spacing-scale-4xh);
            }

            .br-wizard[collapsed] .wizard-progress-btn {
                padding-bottom: var(--spacing-scale-base);
            }

            .br-wizard[collapsed] .wizard-progress-btn .info {
                display: none;
            }

            .br-wizard[collapsed] .wizard-form {
                height: auto;
            }

            .br-wizard[collapsed] .wizard-panel-content {
                overflow-x: hidden;
                overflow-y: auto;
            }
        }

        .br-wizard .wizard-form {
            display: flex;
            flex: 1;
            height: auto;
            overflow: hidden;
            position: relative;
        }

        .br-wizard .wizard-panel {
            display: none;
            flex-direction: column;
            flex-wrap: nowrap;
            height: auto;
            left: 0;
            margin-bottom: 0;
            opacity: 0;
            position: static;
            top: 0;
            visibility: hidden;
            width: 100%;
        }

        .br-wizard .wizard-panel[active] {
            display: flex;
            height: auto;
            left: 0 !important;
            opacity: 1;
            transition-delay: 0s;
            transition-duration: 0.5s;
            transition-property: all;
            transition-timing-function: linear;
            visibility: visible;
        }

        @keyframes slide-left {
            0% {
                opacity: 0;
                transform: translateX(1%);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .br-wizard .wizard-panel-content {
            border-top: 1px solid var(--border-color);
            flex-grow: 1;
            height: auto;
            max-height: none;
            overflow-x: auto;
            overflow-y: auto;
            padding: var(--spacing-scale-base) var(--spacing-scale-2x);
        }

        .br-wizard .wizard-panel-content::-webkit-scrollbar {
            height: var(--spacing-scale-base);
            width: var(--spacing-scale-base);
        }

        .br-wizard .wizard-panel-content::-webkit-scrollbar-track {
            background: var(--gray-10);
        }

        .br-wizard .wizard-panel-content::-webkit-scrollbar-thumb {
            background: var(--gray-30);
        }

        .br-wizard .wizard-panel-content:hover::-webkit-scrollbar-thumb {
            background: var(--gray-40);
        }

        .br-wizard .wizard-panel-content:focus,
        .br-wizard .wizard-panel-content:focus-visible,
        .br-wizard .wizard-panel-content.focus-visible {
            border-color: var(--focus) !important;
            box-shadow: 0 0 0 var(--surface-width-md) var(--focus);
            outline: none;
        }

        .br-wizard .wizard-panel-content> :last-child {
            margin-bottom: 0;
        }

        .br-wizard .wizard-panel-btn {
            align-self: flex-end;
            background-color: var(--background-alternative);
            border-top: 1px solid var(--border-color);
            height: fit-content;
            margin-top: 1px;
            padding: var(--spacing-scale-2x) 1.5%;
            width: 100%;
        }

        .br-wizard .wizard-btn-next,
        .br-wizard .wizard-btn,
        .br-wizard .wizard-btn-prev {
            float: right;
            margin-left: var(--spacing-scale-2x);
        }

        .br-wizard .wizard-btn-canc {
            float: left;
        }

        @media (max-width: 991px) {
            .br-wizard .wizard-form {
                height: auto;
            }

            .br-wizard .wizard-panel {
                border-top: 0;
                display: none;
                flex-wrap: nowrap;
                margin-bottom: 0;
                max-height: none;
            }

            .br-wizard .wizard-panel-content {
                height: auto;
                max-height: 100%;
                overflow-x: hidden;
                overflow-y: auto;
                padding: var(--spacing-scale-half) var(--spacing-scale-base);
                transition-delay: 0s;
                transition-duration: 0.25s;
                transition-property: all;
                transition-timing-function: linear;
            }

            .br-wizard .wizard-panel-btn {
                align-items: flex-end;
                background-color: var(--background-alternative);
                display: flex;
                flex-wrap: wrap;
                height: fit-content;
                justify-content: center;
                padding: 0 !important;
                position: static;
                width: 100%;
            }

            .br-wizard .wizard-btn-canc,
            .br-wizard .wizard-btn-next,
            .br-wizard .wizard-btn-prev,
            .br-wizard .wizard-btn {
                float: none;
                margin: var(--spacing-scale-base) 5%;
                width: 90%;
            }

            .br-wizard .wizard-btn-next,
            .br-wizard .wizard-btn {
                order: 1;
            }
        }

        .br-wizard[vertical] {
            flex-direction: row;
        }

        .br-wizard[vertical] .wizard-progress {
            flex: 1;
            float: none;
            grid-template-columns: 1fr;
            height: auto;
            max-width: 260px;
            overflow-x: hidden;
            padding-top: 0;
            position: relative;
            text-align: right;
        }

        .br-wizard[vertical] .wizard-progress-btn {
            height: 100%;
            line-height: 100%;
            max-height: 100%;
            padding-bottom: 0;
            padding-right: 70px;
            padding-top: 0;
            text-align: right;
        }

        .br-wizard[vertical] .wizard-progress-btn::before {
            left: calc(100% - 32px);
            line-height: 26px;
            margin-top: calc(var(--spacing-scale-2x) * -1);
            position: absolute;
            text-align: center;
            top: 50%;
        }

        .br-wizard[vertical] .wizard-progress-btn::after {
            height: calc(100% - 34px);
            left: calc(100% - 33px);
            position: absolute;
            top: calc(-50% + 18px);
            width: 1px;
        }

        .br-wizard[vertical] .wizard-progress-btn[active]::after {
            width: 1px;
        }

        .br-wizard[vertical][scroll] .wizard-progress {
            overflow-y: auto;
        }

        .br-wizard[vertical][scroll] .wizard-progress::-webkit-scrollbar {
            height: var(--spacing-scale-base);
            width: var(--spacing-scale-base);
        }

        .br-wizard[vertical][scroll] .wizard-progress::-webkit-scrollbar-track {
            background: var(--gray-10);
        }

        .br-wizard[vertical][scroll] .wizard-progress::-webkit-scrollbar-thumb {
            background: var(--gray-30);
        }

        .br-wizard[vertical][scroll] .wizard-progress:hover::-webkit-scrollbar-thumb {
            background: var(--gray-40);
        }

        .br-wizard[vertical][scroll] .wizard-progress .wizard-progress-btn {
            min-height: 100px;
        }

        .br-wizard[vertical] .wizard-form {
            float: none;
            height: auto;
            width: calc(100% - 260px);
        }

        .br-wizard[vertical] .wizard-form .wizard-panel .wizard-panel-content {
            border-top: 0;
        }

        @media (max-width: 991px) {
            .br-wizard[vertical] .wizard-progress {
                max-height: 100%;
                max-width: 110px;
            }

            .br-wizard[vertical] .wizard-progress::after {
                height: 1em;
                left: unset;
                margin-top: -0.5em;
                right: 2px;
                top: 50%;
                transform: rotate(-90deg);
                width: 1em;
            }

            .br-wizard[vertical] .wizard-progress-btn {
                line-height: 18px;
                padding-right: var(--spacing-scale-7x);
            }

            .br-wizard[vertical] .wizard-progress-btn .info {
                line-height: 1.6em;
                margin-top: -0.5em;
                position: absolute;
                right: 54px;
            }

            .br-wizard[vertical] .wizard-form {
                height: auto;
                max-width: calc(100% - 110px);
                min-width: calc(100% - 110px);
                transition-delay: 0s;
                transition-duration: 0.25s;
                transition-property: all;
                transition-timing-function: linear;
            }

            .br-wizard[vertical] .wizard-panel {
                height: 100%;
                max-height: 100%;
            }

            .br-wizard[vertical][collapsed] .wizard-progress {
                max-width: 60px;
                padding-bottom: 0;
                padding-top: 0;
            }

            .br-wizard[vertical][collapsed] .wizard-progress-btn {
                padding-right: 0;
            }

            .br-wizard[vertical][collapsed] .wizard-progress-btn .info {
                display: none;
            }

            .br-wizard[vertical][collapsed] .wizard-form {
                max-width: calc(100% - 60px);
                min-width: calc(100% - 60px);
            }
        }

        .br-wizard.inverted,
        .br-wizard.dark-mode {
            --color: var(--color-dark);
            --color-rgb: var(--color-dark-rgb);
            --text-color: var(--color-dark);
            --interactive: var(--interactive-dark);
            --interactive-rgb: var(--interactive-dark-rgb);
            --visited: var(--visited-dark);
            --hover: var(--hover-dark);
            --pressed: var(--pressed-dark);
            --focus-color: var(--focus-color-dark);
            --focus: var(--focus-color-dark);
        }

        .br-wizard.inverted .br-button.primary,
        .br-wizard.inverted .br-button[primary],
        .br-wizard.inverted .br-button.is-primary,
        .br-wizard.dark-mode .br-button.primary,
        .br-wizard.dark-mode .br-button[primary],
        .br-wizard.dark-mode .br-button.is-primary {
            --color: var(--color-light);
            --color-rgb: var(--color-light-rgb);
            --text-color: var(--color-light);
            --interactive: var(--interactive-light);
            --interactive-rgb: var(--background-dark-rgb);
            --visited: var(--visited-light);
            --hover: var(--hover-light);
            --pressed: var(--pressed-light);
            --focus-color: var(--focus-color-light);
            --focus: var(--focus-color-light);
            background-color: var(--interactive-dark);
            color: var(--background-dark);
        }

        .br-wizard.inverted .br-button.secondary,
        .br-wizard.inverted .br-button[secondary],
        .br-wizard.inverted .br-button.is-secondary,
        .br-wizard.dark-mode .br-button.secondary,
        .br-wizard.dark-mode .br-button[secondary],
        .br-wizard.dark-mode .br-button.is-secondary {
            background-color: var(--background-dark);
        }

        .br-wizard.inverted .wizard-progress,
        .br-wizard.dark-mode .wizard-progress {
            background-color: transparent;
        }

        .br-wizard.inverted .wizard-progress-btn[active],
        .br-wizard.dark-mode .wizard-progress-btn[active] {
            color: var(--color);
        }

        .br-wizard.inverted .wizard-progress-btn[active]::before,
        .br-wizard.dark-mode .wizard-progress-btn[active]::before {
            --interactive-rgb: var(--active-rgb);
            background-color: var(--color);
            color: var(--active);
        }

        .br-wizard.inverted .wizard-panel .wizard-panel-btn,
        .br-wizard.dark-mode .wizard-panel .wizard-panel-btn {
            background-color: transparent;
        }

        .br-wizard .wizard-progress {
            background-color: var(--background-alternative);
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(0, 1fr));
            grid-template-rows: none;
            min-height: 124px;
            overflow-x: auto;
            overflow-y: hidden;
            padding-top: var(--spacing-scale-7x);
            width: 100%;
        }

        .br-wizard .wizard-progress-btn[active] {
            color: var(--active);
            font-weight: var(--font-weight-semi-bold, 600);
        }

        :root {
            --active-color: #0c326f;
            /* Color for the active state */
            --inactive-color: #1351b4;
            /* Color for the inactive state */
        }

        .br-wizard .wizard-progress-btn {
            color: var(--inactive-color);
            /* Default color for inactive state */
            font-weight: var(--font-weight-semi-bold, 600);
            transition: color 0.3s ease;
            /* Smooth transition for color change */
        }

        .br-wizard .wizard-progress-btn[active] {
            color: var(--active-color);
            /* Color for active state */
            font-weight: var(--font-weight-semi-bold, 600);
        }

        :root {
            --active-background: #0c326f;
            /* Color for the active state */
            --inactive-background: #fff;
            /* Color for the inactive state */
            --border-color: var(--background-light);
            /* Border color for active state */
        }

        .card {
            position: relative;
        }

        .dropdown-menu {
            z-index: 1050;
            /* Bootstrap's default for dropdowns */
        }

        .card-pol,
        .card-req {
            border: 2px solid #ddd;
            /* Standard card border color */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Shadow to make it stand out */
        }

        /*# sourceMappingURL=wizard.css.map*/
    </style>
@endsection
@section('content')

    <section id="nav-filled" style="margin-top: 47px;">
        <div class="row match-height">
            <!-- Filled Tabs starts -->
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="wizard-sample-1">
                        <div class="br-wizard" collapsed="collapsed" step="1">
                            <div class="wizard-progress" role="tablist">
                                <button class="wizard-progress-btn" type="button" aria-labelledby="info1" role="tab"
                                    aria-controls="tab1"><span class="primary" id="info1">
                                        {{ __('compliance.AuditInfo') }}</span></button>
                                <button class="wizard-progress-btn" type="button" aria-labelledby="info2" role="tab"
                                    aria-controls="tab2" active="active"><span class="info"
                                        id="info2">{{ __('compliance.RequirementAchievement') }}</span></button>
                                <button class="wizard-progress-btn getTheGraphDetails" type="button"
                                    aria-labelledby="info3" role="tab" aria-controls="tab3" active="active"><span
                                        class="info" id="info3">{{ __('compliance.AuditResult') }}</span></button>
                                <button class="wizard-progress-btn" type="button" aria-labelledby="info4" role="tab"
                                    aria-controls="tab4" active="active"><span class="info"
                                        id="info4">{{ __('compliance.AuditRemdation') }}</span></button>
                                <button class="wizard-progress-btn" type="button" aria-labelledby="info5" role="tab"
                                    aria-controls="tab5"><span
                                        class="info">{{ __('compliance.AuditTrail') }}</span></button>
                            </div>
                            <div class="wizard-form">
                                <div class="wizard-panel" active="active" role="tabpanel" id="tab1">
                                    <div class="wizard-panel-content" tabindex="0">
                                        @include('admin.content.compliance.active-audit.info')

                                    </div>
                                    <div class="wizard-panel-btn">
                                        <button class="br-button primary wizard-btn-next" type="button"
                                            aria-description="Passo 2 de 5 Validar Dados"> Next
                                        </button>
                                    </div>
                                </div>
                                <div class="wizard-panel" role="tabpanel" id="tab2">
                                    <div class="wizard-panel-content" tabindex="0">
                                        <div class="card-req card mb-4"
                                            style="margin-top: 6px; position: relative; overflow: visible;">
                                            <div class="card-header d-flex"
                                                style="justify-content: space-between !important">
                                                <h3 class="section-title mb-0">{{ __('governance.Evidence') }}</h3>
                                                @if ($editable)
                                                    @if (auth()->user()->hasPermission('control.add_objectives'))
                                                        <button class="btn btn-success" id="addObjective"
                                                            onclick="showAddObjectiveForm({{ $frameworkControlTestAudit->FrameworkControl->id }})">
                                                            {{ __('Requirement') }}
                                                        </button>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                @include('admin.content.compliance.active-audit.objective-achievement')
                                            </div>
                                        </div>

                                        {{-- <div class="card mb-4">
                                            <div class="card-header">
                                                <h3 class="section-title mb-0">{{ __('governance.Document') }}
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                @include('admin.content.compliance.active-audit.related-policy')
                                            </div>
                                        </div> --}}
                                        @if ($mapping && $editable)
                                            <div class="card mb-4">
                                                <div class="card-header">
                                                    <h3 class="section-title mb-0">{{ __('governance.Mapping') }}
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <div id="chart-container">

                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                    <div class="wizard-panel-btn">

                                        <button class="br-button primary wizard-btn-next" type="button"
                                            aria-description="Passo 3 de 5 Habilitar Cadastro" id="getTheAuditgraphNext">
                                            Next
                                        </button>
                                        <button class="br-button secondary wizard-btn-prev" type="button"
                                            aria-description="Passo 1 de 5 Dados Pessoais">{{ __('governance.Pervious') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="wizard-panel" role="tabpanel" id="tab3">
                                    <div class="wizard-panel-content" tabindex="0">
                                        @include('admin.content.compliance.active-audit.edit')

                                    </div>
                                    <div class="wizard-panel-btn">

                                        <button class="br-button primary wizard-btn-next" type="button"
                                            aria-description="Passo 4 de 5 Cadastrar Senha"> {{ __('governance.Next') }}
                                        </button>
                                        <button class="br-button secondary wizard-btn-prev" type="button"
                                            aria-description="Passo 2 de 5 Validar Dados">{{ __('governance.Pervious') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="wizard-panel" role="tabpanel" id="tab4">
                                    <div class="wizard-panel-content" tabindex="0">
                                        @include('admin.content.compliance.active-audit.remdation')

                                    </div>
                                    <div class="wizard-panel-btn">

                                        <button class="br-button primary wizard-btn-next" id="getTheAudtTrailPage"
                                            type="button"
                                            aria-description="Passo 5 de 5 Finalizar">{{ __('governance.Next') }}
                                        </button>
                                        <button class="br-button secondary wizard-btn-prev" type="button"
                                            aria-description="Passo 3 de 5 Habilitar Cadastro"
                                            id="getTheAuditgraphPervious">{{ __('governance.Pervious') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="wizard-panel" role="tabpanel" id="tab5">
                                    <div class="wizard-panel-content" tabindex="0">
                                        @include('admin.content.compliance.active-audit.logs')
                                    </div>
                                    <div class="wizard-panel-btn">

                                        {{-- <button class="br-button primary wizard-btn" type="button">Concluir
                                        </button> --}}
                                        <button class="br-button secondary wizard-btn-home" id="homeAudit"
                                            type="button">{{ __('governance.Home') }}
                                        </button>
                                        <button class="br-button secondary wizard-btn-prev"
                                            type="button">{{ __('governance.Pervious') }}Pervious
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- // List Evidences Modal -->




@endsection
@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/file-uploaders/dropzone.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('ajax-files/compliance/edit-active-audit.js') }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset('ajax-files/compliance/general-compliance.js') }}"></script>
    <script src="{{ asset('cdn/core-init.js') }}"></script>
    <script src="{{ asset('cdn/d3.v3.min.js') }}"></script>
    <script src="{{ asset('cdn/jquery6.js') }}"></script>


    {{-- Risk scripts --}}
    <script>
        let riskAuditID = '{{ $id }}';
        // const createURL = "{{ route('admin.risk_management.ajax.store') }}",
        const createURL = "{{ route('admin.compliance.ajax.store-risk-with-audit') }}",
            lang = [];
        lang['confirmDelete'] = "{{ __('locale.ConfirmDelete') }}";
        lang['cancel'] = "{{ __('locale.Cancel') }}";
        lang['success'] = "{{ __('locale.Success') }}";
        lang['error'] = "{{ __('locale.Error') }}";
        lang['Closed'] = "{{ __('locale.Closed') }}";
        lang['Open'] = "{{ __('locale.Open') }}";

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

        $(document).ready(function() {
            $('.multiple-select2').select2();

            // Load controls of framework
            $("[name='framework_id']").on('change', function() {
                const frameworkControls = $(this).find('option:selected').data('controls');
                $("[name='control_id']").find('option:not(:first)').remove();
                $("[name='control_id']").find('option:first').attr('selected', true)
                if (frameworkControls)
                    frameworkControls.forEach(frameworkControl => {
                        $("[name='control_id']").append(
                            `<option value="${frameworkControl.id}">${frameworkControl.short_name}</option>`
                        );
                    });
            });

            // Load Owner manager
            $("[name='owner_id']").on('change', function() {
                const ownerManger = $(this).find('option:selected').data('manager');
                $("[name='owner_manager_id']").find('option:not(:first)').remove();
                $("[name='owner_manager_id']").find('option:first').attr('selected', true)
                if (ownerManger)
                    $("[name='owner_manager_id']").append(
                        `<option value="${ownerManger.id}">${ownerManger.name}</option>`);
            });

            // Submit form for creating risk
            $('#add-new-risk form').submit(function(e) {
                e.preventDefault();
                // Assuming quill is your Quill instance
                var additionalNotes = quill.root.innerHTML;

                var formData = new FormData(this);
                formData.append('additional_notes', additionalNotes);
                formData.append('auditID', riskAuditID);
                let risks = $('#risk').val();

                risks.forEach(risk => {
                    formData.append('risks[]', risk);
                });

                $.ajax({
                    url: createURL,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.status) {
                            makeAlert(data.alert ? 'warning' : 'success', data.alert ?
                                `${data.alert}<br>${data.message}` : `${data.message}`,
                                lang['success']);
                            $('#add-new-risk').modal('hide');
                            $("#advanced-search-datatable").load(location.href +
                                " #advanced-search-datatable>*", "");
                            if (data.redirect_to)
                                window.location.href = data.redirect_to;
                            // loadDatatable();
                        } else {
                            showError(data['errors']);
                        }
                    },
                    error: function(response, data) {
                        responseData = response.responseJSON;
                        makeAlert('error', responseData.message, lang['error']);
                        showError(responseData.errors);
                    }
                });
            });
        });

        // function to show error validation
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
    </script>
    <link rel="stylesheet" href="{{ asset('cdn/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn/buttons.dataTables.min.css') }}">
    <script src="{{ asset('cdn/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('cdn/jquery.dataTables.min.js') }}"></script>

    <script>
        // function loadDatatable() {

        //     var id = '{{ $id }}';
        //     let url = "{{ route('admin.compliance.ajax.get-logs-audits', ':id') }}";
        //     url = url.replace(':id', id);
        //     $.ajax({
        //         url: url,
        //         type: "GET",
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         data: {},
        //         success: function(data) {


        //             createDatatable(data);
        //         },
        //         error: function() {
        //             //
        //         }
        //     });
        // }

        // function createDatatable(JsonList) {
        //     var isRtl = $('html').attr('data-textdirection') === 'rtl';

        //     var dt_responsive_table = $('.dt-responsive');


        //     if ($('body').attr('data-framework') === 'laravel') {
        //         assetPath = $('body').attr('data-asset-path');
        //     }
        //     if (dt_responsive_table.length) {

        //         var dt_adv_filter = dt_responsive_table.DataTable({
        //             data: JsonList,
        //             columns: [{
        //                     data: 'responsive_id'
        //                 },
        //                 {
        //                     data: 'id'
        //                 },
        //                 {
        //                     data: 'user'
        //                 },
        //                 {
        //                     data: 'message'
        //                 },
        //                 {
        //                     data: 'created_at'
        //                 }
        //             ],
        //             columnDefs: [{
        //                 className: 'control',
        //                 orderable: false,
        //                 targets: 0
        //             }, {
        //                 // Label for verified
        //                 targets: -4,
        //                 render: function(data, type, full, meta) {
        //                     // return data ? `<pre>${JSON.stringify(data, null, '\t')}</pre>` : '';
        //                     return data ? JSON.stringify(data) : '';
        //                 }
        //             }],
        //             dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        //             orderCellsTop: true,
        //             responsive: {
        //                 details: {
        //                     display: $.fn.dataTable.Responsive.display.modal({
        //                         header: function(row) {
        //                             var data = row.data();
        //                             return 'Details of ' + data['name'];
        //                         }
        //                     }),
        //                     type: 'column',
        //                     renderer: function(api, rowIdx, columns) {
        //                         var data = $.map(columns, function(col, i) {
        //                             return col.title !== '' ?
        //                                 '<tr data-dt-row="' +
        //                                 col.rowIndex +
        //                                 '" data-dt-column="' +
        //                                 col.columnIndex +
        //                                 '">' +
        //                                 '<td>' +
        //                                 col.title +
        //                                 ':' +
        //                                 '</td> ' +
        //                                 '<td>' +
        //                                 col.data +
        //                                 '</td>' +
        //                                 '</tr>' :
        //                                 '';
        //                         }).join('');
        //                         return data ? $('<table class="table"/><tbody />').append(
        //                             data) : false;
        //                     }
        //                 }
        //             },
        //             language: {
        //                 paginate: {
        //                     previous: '&nbsp;',
        //                     next: '&nbsp;'
        //                 }
        //             }
        //         });
        //     }
        //     // filter function after input keyup
        //     $('input.dt-input').on('keyup', function() {
        //         filterColumn($(this).attr('data-column'), $(this).val());
        //     });
        //     $('.dataTables_filter .form-control').removeClass('form-control-sm');
        //     $('.dataTables_length .form-select').removeClass('form-select-sm').removeClass(
        //         'form-control-sm');
        // }
        // loadDatatable();


        $(document).ready(function() {
            // Inject the dynamic ID from Blade
            var id = '{{ $id }}'; // Assuming $id is passed from the controller to the Blade view

            // Construct the URL with the correct ID
            let url = "{{ route('admin.compliance.ajax.get-logs-audits', ':id') }}";
            url = url.replace(':id', id); // Replace the placeholder :id with the actual 'id' value

            // Initialize the DataTable
            let logsTable = $('#logsTable').DataTable({
                processing: true, // Show a loading indicator while data loads
                serverSide: true, // Enable server-side processing
                ajax: {
                    url: url, // Use the URL from the Blade variable
                    type: 'GET'
                },
                columns: [{
                        data: 'user',
                        name: 'user'
                    }, // User who generated the log
                    {
                        data: 'message',
                        name: 'message'
                    }, // Log message
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    } // Timestamp of the update
                ],
                order: [
                    [2, 'desc']
                ], // Default ordering by 'updated_at' (column 2) in descending order
            });

            // Attach click event to both buttons
            $('.wizard-progress-btn, #getTheAudtTrailPage').on('click', function() {
                // Reload the DataTable to fetch new data
                logsTable.ajax.reload(null, false); // `false` ensures it does not reset pagination
            });
        });
    </script>
    <script>
        const filePath = "{{ asset('/uploads/compliance/') }}";
        // Dropzone FILES
        var id = "{{ $id }}";
        let deleteURL = "{{ route('admin.compliance.audit-file.destroy', ':id') }}";
        deleteURL = deleteURL.replace(':id', id);
        var url = "{{ route('admin.compliance.audit-file.store') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        Dropzone.options.dropzone = {
            maxFiles: 5,
            maxFilesize: 4,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.xlsx,.xls,.doc,.docx", // Specify desired file types
            url: "{{ route('admin.compliance.audit-file.store') }}",
            //url:"{{ route('admin.governance.index') }}",
            /* success: function(file, response) {
                console.log(file);
                console.log(response);
                if (response != 0) {
                    // Download link
                    var anchorEl = document.createElement('a');
                    anchorEl.setAttribute('href', response);
                    anchorEl.setAttribute('target', '_blank');
                    anchorEl.innerHTML = "<br>Download";
                    file.previewTemplate.appendChild(anchorEl);
                }
            }*/
            method: 'POST',
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + "-" + file
                    .name; // to rename file name but i didn't use it. i renamed file with php in controller.
            },
            headers: {
                'x-csrf-token': CSRF_TOKEN,
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.xlsx,.xls,.doc,.docx", // Specify desired file types
            addRemoveLinks: true,
            timeout: 50000,
            params: {
                'id': id
            },
            init: function() {
                this.on("success", function(file, response) {
                    // $('#download-audit-file').append(`<a id="${response.unique_name.replace(/\./g, "-")}" style="padding: 7px 3px" class="btn btn-primary col-md-3 col-lg-2 col-12" href="${filePath}/${response.unique_name}" download><i style="margin: 0 5px" data-feather="file"></i>${response.name}</a>`);
                    location.reload();
                });

                var urlListImages = "{{ route('admin.compliance.audit-file.index') }}";
                // Get images
                var myDropzone = this;
                $.ajax({
                    url: urlListImages,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $.each(data, function(key, value) {
                            var file = {
                                unique_name: value.unique_name,
                                name: value.name,
                                size: value.size
                            };
                            myDropzone.options.addedfile.call(myDropzone, file);
                            myDropzone.options.thumbnail.call(myDropzone, file, value.path);
                            myDropzone.emit("complete", file);
                        });
                    }
                });
            },
            removedfile: function(file) {
                if (this.options.dictRemoveFile) {
                    return Dropzone.confirm("Are You Sure to " + this.options.dictRemoveFile, function() {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'DELETE',
                            url: deleteURL,
                            data: {
                                filename: file.unique_name
                            },
                            success: function(data) {
                                $('#' + file.unique_name.replace(/\./g, "-")).remove();
                                makeAlert('success', 'File has been successfully removed',
                                    "{{ __('locale.Success') }}");
                            },
                            error: function(e) {
                                makeAlert('error', "{{ __('locale.Error') }}",
                                    "{{ __('locale.Error') }}");
                            }
                        });
                        var fileRef;
                        return (fileRef = file.previewElement) != null ?
                            fileRef.parentNode.removeChild(file.previewElement) : void 0;
                    });
                }
            },

            success: function(file, response) {
                file.previewElement.id = response.success;
                // set new images names in dropzone’s preview box.
                var olddatadzname = file.previewElement.querySelector("[data-dz-name]");
                file.previewElement.querySelector("img").alt = response.success;
                olddatadzname.innerHTML = response.success;
            },
            error: function(file, response) {
                if ($.type(response) === "string")
                    var message = response; //dropzone sends it's own error messages in string
                else
                    var message = response.message;
                file.previewElement.classList.add("dz-error");
                _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                _results = [];
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i];
                    _results.push(node.textContent = message);
                }
                return _results;
            }

        };
    </script>


    <script>
        $('#risk').on('change', function() {
            let risks = $(this).val();
            let auditID = '{{ $id }}';
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "{{ route('admin.compliance.ajax.risk-to-result') }}",
                data: {
                    risks: risks,
                    auditID: auditID
                },
                success: function(data) {
                    $('#risks-table-content').empty();
                    $('#risks-table-content').append(data);
                }
            });
        });

        /* Start related policy script */
        // Handle preview-policy-document click
        $('.preview-policy-document').on('click', function() {
            console.log($(this).data('document-id'));
            console.log('preview');
        })

        // Handle download-policy-document click
        $('.download-policy-document').on('click', function() {
            console.log($(this).data('document-id'));
            console.log('download');

            // Download note file start
            const form = $('#download-file-form');
            form.find('[name="document_id"').val($(this).data('document-id'));

            form.trigger('submit');
            // Download note file End
        })

        // Handle approve-policy-document click
        $('.approve-policy-document').on('click', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.take_audit_policy_action') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: $(that).data('document-id'),
                    approved: true,
                    _method: 'patch'
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        $(that).addClass('bg-secondary');
                        $(that).parents('td').prev().html(
                            `<span class="badge rounded-pill badge-light-success">${$(that).data('approved')}</span>`
                        )
                        $(that).parent().find('.text-danger').removeClass('bg-secondary');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        })

        // Handle reject-policy-document click
        $('.reject-policy-document').on('click', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.take_audit_policy_action') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: $(that).data('document-id'),
                    approved: false,
                    _method: 'patch'
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        $(that).addClass('bg-secondary');
                        $(that).parents('td').prev().html(
                            `<span class="badge rounded-pill badge-light-danger">${$(that).data('rejected')}</span>`
                        )
                        $(that).parent().find('.text-success').removeClass('bg-secondary');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        });
        /* End related policy script */


        // Handle approve-objective click
        $('.approve-objective').on('click', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.take_audit_objective_action') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: $(that).data('objective-id'),
                    approved: true,
                    _method: 'patch'
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        $(that).addClass('bg-secondary');
                        $(that).parents('td').prev().html(
                            `<span class="status-span badge rounded-pill badge-light-success" data-objective-id="${$(that).data('objective-id')}">${$(that).data('approved')}</span>`
                        )
                        $(that).parent().find('.text-danger').removeClass('bg-secondary');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        })

        // Handle reject-objective click
        $('.reject-objective').on('click', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.take_audit_objective_action') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: $(that).data('objective-id'),
                    approved: false,
                    _method: 'patch'
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        $(that).addClass('bg-secondary');
                        $(that).parents('td').prev().html(
                            `<span class="status-span badge rounded-pill badge-light-danger" data-objective-id="${$(that).data('objective-id')}">${$(that).data('rejected')}</span>`
                        )
                        $(that).parent().find('.text-success').removeClass('bg-secondary');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        });
        // Handle view-objective-evidences click
        $('.view-objective-evidences').on('click', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.view_objective_evidences') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    objective_id: $(that).data('objective-id'),
                    test_id: $(that).data('test-id'),
                    editable: $(that).data('editable'),
                },
                success: function(data) {
                    if (data.status) {
                        $('#evidencesList').html(data.html);
                        $('#evidencesModal').modal('show');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        });

        // Handle approve-evidence click
        $('.approve-evidence').on('click', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.take_audit_evidence_action') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: $(that).data('evidence-id'),
                    approved: true,
                    _method: 'patch'
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        $(that).addClass('bg-secondary');
                        $(that).parents('td').prev().html(
                            `<span class="badge rounded-pill badge-light-success">${$(that).data('approved')}</span>`
                        )
                        $(that).parent().find('.text-danger').removeClass('bg-secondary');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        })

        // Handle reject-evidence click
        $('.reject-evidence').on('click', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.take_audit_evidence_action') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: $(that).data('evidence-id'),
                    approved: false,
                    _method: 'patch'
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        $(that).addClass('bg-secondary');
                        $(that).parents('td').prev().html(
                            `<span class="badge rounded-pill badge-light-danger">${$(that).data('rejected')}</span>`
                        )
                        $(that).parent().find('.text-success').removeClass('bg-secondary');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        });
        document.querySelectorAll('.wizard-progress-btn').forEach((btn, index) => {
            btn.addEventListener('click', function() {
                // Remove active state from all buttons
                document.querySelectorAll('.wizard-progress-btn').forEach(b => b.removeAttribute('active'));
                // Set active state on clicked button
                btn.setAttribute('active', 'active');

                // Hide all panels
                document.querySelectorAll('.wizard-panel').forEach(panel => panel.removeAttribute(
                    'active'));

                // Show the corresponding panel
                document.querySelector(`#tab${index + 1}`).setAttribute('active', 'active');
            });
        });


        $(document).ready(function() {
            var testAuditId =
                {{ $frameworkControlTestAudit->framework_control_id }}; // Pass the ID from the Blade view

            $.ajax({
                url: '{{ route('admin.governance.control.ajax.objective.tree.data', ':id') }}'.replace(
                    ':id', testAuditId),
                method: 'GET',
                success: function(response) {
                    var parentName = response.parentName;
                    var parentStatus = response.parentStatus;
                    var controls = response.controls;

                    var data = [{
                        "name": parentName,
                        "status": parentStatus,
                        "parent": "null",
                        "relation": "Parent Of",
                        "rid": "root",
                        "test_number": "", // No test number for root node
                        "test_number_created_at": "", // No test_created_at for root node
                        "children": []
                    }];

                    controls.forEach(function(control) {
                        if (!Array.isArray(control.children)) {
                            control.children = [];
                        }

                        // Only include test_number and test_number_created_at if the control has no children
                        var testNumber = control.children.length === 0 ? control.test_number :
                            '';
                        var testNumberCreatedAt = control.children.length === 0 ? control
                            .test_number_created_at : '';

                        data[0].children.push({
                            "name": control.name,
                            "status": control.status,
                            "test_number": testNumber, // Include test number only if no children
                            "test_number_created_at": testNumberCreatedAt, // Include test_created_at only if no children
                            "parent": parentName,
                            "relation": "Parent Of",
                            "rid": "child_" + control.name,
                            "children": control.children,
                            "child_test_numbers": control
                                .child_test_numbers // Include child test numbers
                        });
                    });

                    function ensureArray(node) {
                        if (!node.children) {
                            node.children = [];
                        }
                        node.children.forEach(ensureArray);
                    }

                    var root = data[0];
                    ensureArray(root);

                    var margin = {
                            top: 20,
                            right: 120,
                            bottom: 20,
                            left: 120
                        },
                        width = 960 - margin.right - margin.left,
                        height = 500 - margin.top - margin.bottom;

                    var i = 0;

                    var tree = d3.layout.tree()
                        .size([height, width]);

                    var diagonal = d3.svg.diagonal()
                        .projection(function(d) {
                            return [d.y, d.x];
                        });

                    var svg = d3.select("div#chart-container").append("svg")
                        .attr("width", width + margin.right + margin.left)
                        .attr("height", height + margin.top + margin.bottom)
                        .append("g")
                        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

                    update(root);

                    function update(source) {
                        var nodes = tree.nodes(root).reverse(),
                            links = tree.links(nodes);

                        nodes.forEach(function(d) {
                            d.y = width - d.depth * 180;
                        });

                        var node = svg.selectAll("g.node")
                            .data(nodes, function(d) {
                                return d.id || (d.id = ++i);
                            });

                        var nodeEnter = node.enter().append("g")
                            .attr("class", "node")
                            .attr("transform", function(d) {
                                return "translate(" + d.y + "," + d.x + ")";
                            });

                        nodeEnter.append("circle")
                            .attr("r", 10)
                            .style("fill", "#fff");

                        nodeEnter.append("text")
                            .attr("x", function(d) {
                                return d.children || d._children ? 13 : -13;
                            })
                            .attr("dy", ".35em")
                            .attr("text-anchor", function(d) {
                                return d.children || d._children ? "start" : "end";
                            })
                            .text(function(d) {
                                var text = d.name + ' (' + (d.status || '') + ') ';
                                if (d.test_number) {
                                    text += 'Test Number: ' + d.test_number;
                                } else {
                                    text += 'No Audit Yet';
                                }
                                if (d.test_number_created_at) {
                                    text += ' | Test Created At: ' + d.test_number_created_at;
                                }
                                return text;
                            })
                            .style("fill-opacity", 1);

                        var link = svg.selectAll("path.link")
                            .data(links, function(d) {
                                return d.target.id;
                            });

                        link.enter().insert("path", "g")
                            .attr("class", "link")
                            .attr("d", diagonal);
                    }
                }
            });
        });

        $(document).on('click', '.getTheGraphDetails, #getTheAuditgraphPervious, #getTheAuditgraphNext', function() {
            if (typeof fetchAuditData === 'function') {
                fetchAuditData();
            } else {
                console.error('fetchAuditData function is not defined.');
            }
        });

        $(document).on('click', '#homeAudit', function() {
            let auditID = '{{ $id }}';

            $.ajax({
                url: "{{ route('admin.compliance.ajax.checkForStatusTaken') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    audit_id: auditID,
                    _method: 'POST'
                },
                success: function(data) {
                    window.location.href =
                        "{{ route('admin.compliance.audit.index') }}";
                },
                error: function(response) {
                    // Alert instead of error toast with two buttons
                    Swal.fire({
                        title: '{{ __('locale.warning_title') }}',
                        text: response.responseJSON.message ||
                            '{{ __('locale.confirm_proceed') }}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '{{ __('locale.yes_proceed') }}',
                        cancelButtonText: '{{ __('locale.cancel') }}'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                "{{ route('admin.compliance.audit.index') }}";
                        }
                    });
                }
            });
        });
    </script>

@endsection
