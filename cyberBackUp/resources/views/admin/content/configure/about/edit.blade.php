@extends('admin/layouts/contentLayoutMaster')

@section('title', __('configure.About'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">

@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-12 mb-2">

        <div class="row breadcrumbs-top  widget-grid">
            <div class="col-12">
                <div class="page-title mt-2">
                    <div class="row">
                        <div class="col-sm-12 ps-0">
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

                </div>
            </div>
        </div>

    </div>
</div>
<div id="quill-service-content" class="d-none"></div>

</div>
    <section id="123">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!--Search Form -->
                    <div class="card-body mt-2">
                        <form action="{{ route('admin.configure.about.ajax.update') }}" method="POST"
                            class="modal-content pt-0">
                            @csrf
                            {{-- Vision --}}
                            <div class="mb-1">
                                <h3>{{ __('configure.vision') }}</h3>
                                <div id="vision">
                                    <textarea class="form-control" hidden name="vision" rows="3"></textarea>
                                    <div class="editor">
                                    </div>
                                </div>
                                <span class="error error-vision "></span>
                            </div>
                            {{-- Message --}}
                            <div class="mb-1">
                                <h3>{{ __('configure.message') }}</h3>
                                <div id="message">
                                    <textarea class="form-control" hidden name="message" rows="3"></textarea>
                                    <div class="editor">
                                    </div>
                                </div>
                                <span class="error error-message "></span>
                            </div>
                            {{-- Mission --}}
                            <div class="mb-1">
                                <h3>{{ __('configure.mission') }}</h3>
                                <div id="mission">
                                    <textarea class="form-control" hidden name="mission" rows="3"></textarea>
                                    <div class="editor">
                                    </div>
                                </div>
                                <span class="error error-mission "></span>
                            </div>
                            {{-- Objectives --}}
                            <div class="mb-1">
                                <h3>{{ __('configure.objectives') }}</h3>
                                <div id="objectives">
                                    <textarea class="form-control" hidden name="objectives" rows="3"></textarea>
                                    <div class="editor">
                                    </div>
                                </div>
                                <span class="error error-objectives "></span>
                            </div>
                            {{-- Responsibilities --}}
                            <div class="mb-1">
                                <h3>{{ __('configure.responsibilities') }}</h3>
                                <div id="responsibilities">
                                    <textarea class="form-control" hidden name="responsibilities" rows="3"></textarea>
                                    <div class="editor">
                                    </div>
                                </div>
                                <span class="error error-responsibilities "></span>
                            </div>

                            <button type="Submit" class="btn btn-warning data-submit">
                                {{ __('locale.Update') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="quill-content" class="d-none"></div>

@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/katex.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
@endsection


@section('page-script')
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

    <script>
        const aboutData = @json($about);
        /*=========================================================================================
          File Name: form-quill-editor.js
          Description: Quill is a modern rich text editor built for compatibility and extensibility.
          ----------------------------------------------------------------------------------------
          Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
          Author: PIXINVENT
          Author URL: http://www.themeforest.net/user/pixinvent
        ==========================================================================================*/
        var fullEditor = null,
            editAboutVision = null,
            editAboutMessage = null,
            editAboutMission = null,
            editAboutObjectives = null,
            editAboutResponsibilities = null;
        (function(window, document, $) {
            'use strict';
            var Font = Quill.import('formats/font');
            Font.whitelist = ['sofia', 'slabo', 'roboto', 'inconsolata', 'ubuntu'];
            Quill.register(Font, true);

            // Full Editor
            const editorConfiguration = {
                bounds: '#full-container .editor',
                modules: {
                    formula: true,
                    syntax: true,
                    toolbar: [
                        [{
                            size: []
                        }],
                        ['bold', 'italic', 'underline'],
                        [{
                            color: []
                        }],
                        [{
                                header: '1'
                            },
                            {
                                header: '2'
                            }
                        ],
                        [{
                                list: 'ordered'
                            },
                            {
                                list: 'bullet'
                            }
                        ],
                        [{
                            align: []
                        }]
                    ]
                },
                theme: 'snow'
            };

            editAboutVision = new Quill('#vision .editor', editorConfiguration);
            editAboutMessage = new Quill('#message .editor', editorConfiguration);
            editAboutMission = new Quill('#mission .editor', editorConfiguration);
            editAboutObjectives = new Quill('#objectives .editor', editorConfiguration);
            editAboutResponsibilities = new Quill('#responsibilities .editor',
                editorConfiguration);

            var editors = [fullEditor];
        })(window, document, jQuery);


        // Submit form for editing asset
        $('form').submit(function(e) {
            e.preventDefault();
            let url = "{{ route('admin.configure.about.ajax.update') }}";
            $.ajax({
                url: url,
                type: "PUT",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
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

        // Show for editing
        function ShoWAboutEditorData() {
            // Start Assign department data to
            const editForm = $('form');
            editForm.find("textarea[name='vision']").val(aboutData.vision);
            editForm.find("textarea[name='message']").val(aboutData.message);
            editForm.find("textarea[name='mission']").val(aboutData.mission);
            editForm.find("textarea[name='objectives']").val(aboutData.objectives);
            editForm.find("textarea[name='responsibilities']").val(aboutData.responsibilities);

            editAboutVision.setContents(JSON.parse(aboutData.vision));
            editAboutMessage.setContents(JSON.parse(aboutData.message));
            editAboutMission.setContents(JSON.parse(aboutData.mission));
            editAboutObjectives.setContents(JSON.parse(aboutData.objectives));
            editAboutResponsibilities.setContents(JSON.parse(aboutData.responsibilities));
            // End Assign department data to
        }
        ShoWAboutEditorData();


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

    <script>
        // Start text editor events

        editAboutVision.on('text-change', function(delta, oldDelta, source) {
            const visionInput = $(editAboutVision.container).parent().find('[name="vision"]');
            if (editAboutVision.getLength() > 1) {
                visionInput.val(JSON.stringify(editAboutVision.getContents()));

            } else {
                visionInput.val('');
            }
        });

        editAboutMessage.on('text-change', function(delta, oldDelta, source) {
            const visionInput = $(editAboutMessage.container).parent().find('[name="message"]');
            if (editAboutMessage.getLength() > 1) {
                visionInput.val(JSON.stringify(editAboutMessage.getContents()));
            } else {
                visionInput.val('');
            }
        });

        editAboutMission.on('text-change', function(delta, oldDelta, source) {
            const visionInput = $(editAboutMission.container).parent().find('[name="mission"]');
            if (editAboutMission.getLength() > 1) {
                visionInput.val(JSON.stringify(editAboutMission.getContents()));
            } else {
                visionInput.val('');
            }
        });

        editAboutObjectives.on('text-change', function(delta, oldDelta, source) {
            const visionInput = $(editAboutObjectives.container).parent().find('[name="objectives"]');
            if (editAboutObjectives.getLength() > 1) {
                visionInput.val(JSON.stringify(editAboutObjectives.getContents()));
            } else {
                visionInput.val('');
            }
        });

        editAboutResponsibilities.on('text-change', function(delta, oldDelta, source) {
            const visionInput = $(editAboutResponsibilities.container).parent().find(
                '[name="responsibilities"]');
            if (editAboutResponsibilities.getLength() > 1) {
                visionInput.val(JSON.stringify(editAboutResponsibilities.getContents()));
            } else {
                visionInput.val('');
            }
        });

        // End text editor events

        const quill = new Quill('#quill-content', {
            theme: 'bubble'
        });
    </script>

@endsection
