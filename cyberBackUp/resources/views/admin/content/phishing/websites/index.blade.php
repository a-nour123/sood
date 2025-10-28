@extends('admin/layouts/contentLayoutMaster')

@section('title', __('phishing.Websites'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('new_d/css/vendors/icofont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('new_d/css/vendors/themify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('new_d/css/vendors/flag-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('new_d/css/vendors/feather-icon.css') }}">

    <script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/styles.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.custom.js') }}"></script>
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('new_d/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('new_d/css/color-1.css') }}" media="screen">

    {{-- Custom loader styles --}}
    <style>
        .custom-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .custom-loader.active {
            opacity: 1;
            visibility: visible;
        }

        .loader-content {
            text-align: center;
        }

        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loader-text {
            color: #333;
            font-size: 14px;
            font-weight: 500;
        }

        .spa-indicator {
            color: #007bff;
            font-weight: 600;
        }

        .spa-section {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-top: 15px;
        }

        .instructions {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .instructions ol {
            margin-bottom: 0;
            padding-left: 20px;
        }

        .instructions li {
            margin-bottom: 5px;
        }

        .btn-loading {
            position: relative;
            pointer-events: none;
        }

        .btn-loading .btn-text {
            opacity: 0;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
    </style>
@endsection

@section('content')
    {{-- Custom Loader --}}
    <div class="custom-loader" id="customLoader">
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <div class="loader-text" id="loaderText">جاري التحميل...</div>
        </div>
    </div>

    {{-- Page Header --}}
    @include('admin.content.phishing.websites.partials.header')

    {{-- Main Content --}}
    <div class="page-wrapper" id="pageWrapper">
        <div class="page-body-wrapper">
            <div class="container-fluid product-wrapper">
                <div class="product-grid">
                    {{-- Controls Section --}}
                    @include('admin.content.phishing.websites.partials.controls')

                    {{-- Websites Grid --}}
                    <div class="product-wrapper-grid" id="website-parent-div">
                        <div class="row">
                            @foreach ($websites as $website)
                                @include('admin.content.phishing.websites.partials.website-card', [
                                    'website' => $website,
                                ])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    @include('admin.content.phishing.websites.partials.add-website')
    @include('admin.content.phishing.websites.partials.edit-website')
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset('new_d/js/product-tab.js') }}"></script>
@endsection

@section('page-script')
    <script>
        // Translations and permissions
        const translations = {
            verified: "{{ __('locale.Verified') }}",
            unverifiedAssets: "{{ __('asset.UnverifiedAssets') }}",
            customDay: "{{ trans_choice('locale.custom_days', 1) }}",
            customDays: "{{ trans_choice('locale.custom_days', 3) }}",
            success: "{{ __('locale.Success') }}",
            error: "{{ __('locale.Error') }}",
            loading: "جاري التحميل...",
            saving: "جاري الحفظ...",
            processing: "جاري المعالجة...",
            close: "{{ __('locale.close') }}",
            save: "{{ __('locale.save') }}"
        };

        const permissions = {
            edit: {{ auth()->user()->hasPermission('asset.update') ? 1 : 0 }},
            delete: {{ auth()->user()->hasPermission('asset.delete') ? 1 : 0 }}
        };

        const urls = {
            edit: "{{ route('admin.phishing.website.edit', '') }}",
            store: "{{ route('admin.phishing.website.store') }}",
            update: "{{ route('admin.phishing.website.update', '') }}",
            trash: "{{ route('admin.phishing.website.trash', '') }}",
            search: "{{ route('admin.phishing.website.search') }}"
        };

        // Loader utilities
        const LoaderManager = {
            show: function(text = translations.loading) {
                document.getElementById('loaderText').textContent = text;
                document.getElementById('customLoader').classList.add('active');
            },

            hide: function() {
                document.getElementById('customLoader').classList.remove('active');
            },

            updateText: function(text) {
                document.getElementById('loaderText').textContent = text;
            }
        };

        // Button loading state manager
        const ButtonLoader = {
            start: function(button, text = translations.saving) {
                const btn = $(button);
                btn.data('original-text', btn.html());
                btn.addClass('btn-loading').prop('disabled', true);
                btn.html(`<span class="btn-text">${text}</span>`);
            },

            stop: function(button) {
                const btn = $(button);
                btn.removeClass('btn-loading').prop('disabled', false);
                btn.html(btn.data('original-text') || btn.find('.btn-text').text());
            }
        };

        // Website manager object
        // Fixed Website Manager with proper edit functionality
        // Fixed Website Manager with proper edit functionality
        // Website manager object - COMPLETELY FIXED VERSION
        const WebsiteManager = {
            // Initialize CKEditor with proper configuration
            initEditors: function() {
                const editorConfig = {
                    autoParagraph: false,
                    entities: false,
                    entities_latin: false,
                    entities_greek: false,
                    allowedContent: true,
                    enterMode: CKEDITOR.ENTER_BR,
                    shiftEnterMode: CKEDITOR.ENTER_BR,
                    forcePasteAsPlainText: true,
                    height: 300,
                    removeButtons: '',
                    extraPlugins: 'colorbutton,colordialog'
                };

                // Destroy existing editors before creating new ones
                Object.keys(CKEDITOR.instances).forEach(instanceName => {
                    if (CKEDITOR.instances[instanceName]) {
                        CKEDITOR.instances[instanceName].destroy(true);
                    }
                });

                // Create editors with proper delay and error handling
                setTimeout(() => {
                    try {
                        // Add editor
                        if (document.getElementById('editor1')) {
                            CKEDITOR.replace('editor1', editorConfig);
                            console.log('Add editor created successfully');
                        }

                        // Edit editor - will be created when modal opens
                        console.log('Base editors initialization completed');
                    } catch (error) {
                        console.error('Error initializing editors:', error);
                    }
                }, 200);
            },

            // Create edit editor when needed
            createEditEditor: function(callback) {
                console.log('Creating edit editor...');

                const editorConfig = {
                    autoParagraph: false,
                    entities: false,
                    entities_latin: false,
                    entities_greek: false,
                    allowedContent: true,
                    enterMode: CKEDITOR.ENTER_BR,
                    shiftEnterMode: CKEDITOR.ENTER_BR,
                    forcePasteAsPlainText: true,
                    height: 300,
                    removeButtons: ''
                };

                // Destroy existing edit editor if it exists
                if (CKEDITOR.instances.edit_editor1) {
                    CKEDITOR.instances.edit_editor1.destroy(true);
                }

                // Wait a bit for destruction to complete
                setTimeout(() => {
                    try {
                        const editEditor = CKEDITOR.replace('edit_editor1', editorConfig);

                        // Wait for editor to be ready
                        editEditor.on('instanceReady', function() {
                            console.log('Edit editor is ready');
                            if (callback && typeof callback === 'function') {
                                callback();
                            }
                        });

                        // Fallback timeout
                        setTimeout(() => {
                            if (callback && typeof callback === 'function') {
                                callback();
                            }
                        }, 1000);

                    } catch (error) {
                        console.error('Error creating edit editor:', error);
                        if (callback && typeof callback === 'function') {
                            callback();
                        }
                    }
                }, 300);
            },

            // Handle form type changes
            handleTypeChange: function() {
                $(document).on('change', "input[type=radio][name=type]", function() {
                    const isOwn = $(this).val() === 'own';
                    const isEdit = $(this).attr('id').includes('edit');
                    const prefix = isEdit ? 'edit_' : '';

                    const domainDiv = $(`#${prefix}website_domain_id_div`);
                    const addressDiv = $(`#${prefix}website_from_address_name_div`);
                    const domainSelect = $(`#${prefix}domain_id`);

                    if (isOwn) {
                        domainDiv.hide();
                        if (!isEdit) {
                            addressDiv.removeClass('col-6').addClass('col-12');
                        }
                        domainSelect.prop('required', false);
                    } else {
                        domainDiv.show();
                        if (!isEdit) {
                            addressDiv.removeClass('col-12').addClass('col-6');
                        }
                        domainSelect.prop('required', true);
                    }
                });
            },

            // Handle SPA checkbox
            handleSPAToggle: function() {
                // For add modal
                $('#is_spa').change(function() {
                    if ($(this).is(':checked')) {
                        $('#spa-html-section').slideDown();
                    } else {
                        $('#spa-html-section').slideUp();
                    }
                });

                // For edit modal
                $('#edit_is_spa').change(function() {
                    if ($(this).is(':checked')) {
                        $('#edit-spa-html-section').slideDown();
                    } else {
                        $('#edit-spa-html-section').slideUp();
                        $('#edit_spa_html_code').val('');
                    }
                });
            },

            // Handle add website form
            handleAddWebsite: function() {
                $('#add-new-website-form').submit(function(e) {
                    e.preventDefault();

                    const form = $(this);
                    const submitBtn = form.find('button[type="submit"]');

                    if (!WebsiteManager.validateForm(form, false)) {
                        return;
                    }

                    ButtonLoader.start(submitBtn, translations.saving);
                    LoaderManager.show(translations.processing);

                    const formData = WebsiteManager.prepareFormData(form, 'editor1');

                    $.ajax({
                        url: form.attr('action'),
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            WebsiteManager.handleSuccess(data, form, '#add-new-website');
                        },
                        error: function(response) {
                            WebsiteManager.handleError(response, false);
                        },
                        complete: function() {
                            ButtonLoader.stop(submitBtn);
                            LoaderManager.hide();
                        }
                    });
                });
            },

            // Handle edit website functionality - COMPLETELY FIXED VERSION
            // Handle edit website functionality - COMPLETELY FIXED VERSION
            handleEditWebsite: function() {
                // Show edit modal when edit button is clicked
                $(document).on('click', '.edit-website', function(e) {
                    e.preventDefault();

                    const websiteId = $(this).data('id');
                    console.log('Edit button clicked for website ID:', websiteId);

                    if (!websiteId) {
                        console.error('Website ID not found');
                        makeAlert('error', 'Website ID not found', translations.error);
                        return;
                    }

                    // Store website data temporarily
                    const websiteData = {
                        id: websiteId,
                        name: $(this).data('name'),
                        phishing_category_id: $(this).data('phishing_category_id'),
                        from_address_name: $(this).data('from_address_name'),
                        website_url: $(this).data('website_url'),
                        type: $(this).data('type'),
                        domain_id: $(this).data('domain_id'),
                        is_spa: $(this).data('is_spa'),
                        cover: $(this).data('cover'),
                        html_code: $(this).data('html_code') || '',
                        spa_html_code: $(this).data('spa_html_code') || '',
                        download_css: $(this).data('download_css') ? 1 : 0,
                        download_images: $(this).data('download_images') ? 1 : 0,
                        download_js: $(this).data('download_js') ? 1 : 0,
                        download_fonts: $(this).data('download_fonts') ? 1 : 0,
                        download_json: $(this).data('download_json') ? 1 : 0,
                        download_other_assets: $(this).data('download_other_assets') ? 1 : 0
                    };

                    // Store data for later use
                    window.currentWebsiteData = websiteData;

                    // Show modal first
                    $('#edit-website').modal('show');
                });

                // Handle edit form submission
                $('#edit-website-form').submit(function(e) {
                    e.preventDefault();

                    const form = $(this);
                    const submitBtn = form.find('button[type="submit"]');
                    const websiteId = $('#edit_website_id').val();

                    console.log('Submitting edit form for website ID:', websiteId);

                    if (!websiteId) {
                        makeAlert('error', 'Website ID is missing', translations.error);
                        return;
                    }

                    // Validate form
                    if (!WebsiteManager.validateForm(form, true)) {
                        return;
                    }

                    ButtonLoader.start(submitBtn, translations.saving);
                    LoaderManager.show(translations.processing);

                    // Create FormData and explicitly add checkbox values
                    const formData = new FormData(form[0]);

                    // Remove the hidden inputs for checkboxes first
                    formData.delete('download_css');
                    formData.delete('download_images');
                    formData.delete('download_js');
                    formData.delete('download_fonts');
                    formData.delete('download_json');
                    formData.delete('download_other_assets');

                    // Add checkbox values explicitly (0 or 1)
                    formData.append('download_css', $('#edit_download_css').is(':checked') ? '1' : '0');
                    formData.append('download_images', $('#edit_download_images').is(':checked') ? '1' :
                        '0');
                    formData.append('download_js', $('#edit_download_js').is(':checked') ? '1' : '0');
                    formData.append('download_fonts', $('#edit_download_fonts').is(':checked') ? '1' : '0');
                    formData.append('download_json', $('#edit_download_json').is(':checked') ? '1' : '0');
                    formData.append('download_other_assets', $('#edit_download_other_assets').is(
                        ':checked') ? '1' : '0');

                    // Add is_spa value explicitly
                    formData.set('is_spa', $('#edit_is_spa').is(':checked') ? '1' : '0');

                    // Add editor content if exists
                    if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.edit_editor1) {
                        formData.set('updated_html_code', CKEDITOR.instances.edit_editor1.getData());
                    }

                    formData.append('_method', 'PUT');

                    // Fix the URL construction
                    let updateUrl = urls.update;
                    if (updateUrl.includes(':id')) {
                        updateUrl = updateUrl.replace(':id', websiteId);
                    } else {
                        updateUrl = updateUrl.endsWith('/') ? updateUrl + websiteId : updateUrl + '/' +
                            websiteId;
                    }

                    console.log('Update URL:', updateUrl);

                    $.ajax({
                        url: updateUrl,
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            console.log('Update success:', data);
                            WebsiteManager.handleSuccess(data, form, '#edit-website');
                        },
                        error: function(response) {
                            console.error('Update error:', response);
                            WebsiteManager.handleError(response, true);
                        },
                        complete: function() {
                            ButtonLoader.stop(submitBtn);
                            LoaderManager.hide();
                        }
                    });
                });
            },

            // Populate edit modal with website data - COMPLETELY FIXED VERSION
            populateEditModal: function(websiteData) {
                console.log('Populating edit modal with data:', websiteData);

                // Clear previous errors
                $('.error').empty();

                // Set basic fields
                $('#edit_website_id').val(websiteData.id);
                $('#edit_name').val(websiteData.name || '');
                $('#edit_phishing_category_id').val(websiteData.phishing_category_id || '');
                $('#edit_from_address_name').val(websiteData.from_address_name || '');
                $('#edit_website_url').val(websiteData.website_url || '');

                // Set type radio buttons and trigger change
                const type = websiteData.type || 'own';
                $(`input[name="type"][value="${type}"]`).prop('checked', true);
                $(`input[name="type"][value="${type}"]`).trigger('change');

                // Handle domain selection
                if (type === 'managed' && websiteData.domain_id) {
                    $('#edit_domain_id').val(websiteData.domain_id);
                }

                // Handle SPA settings
                const isSpa = websiteData.is_spa == 1 || websiteData.is_spa === true;
                $('#edit_is_spa').prop('checked', isSpa);

                if (isSpa) {
                    $('#edit-spa-html-section').show();
                    $('#edit_spa_html_code').val(websiteData.spa_html_code || '');
                } else {
                    $('#edit-spa-html-section').hide();
                    $('#edit_spa_html_code').val('');
                }

                // Show current cover if exists
                if (websiteData.cover) {
                    $('#current-cover-preview').show();
                    $('#current-cover-image').attr('src', websiteData.cover);
                } else {
                    $('#current-cover-preview').hide();
                }

                // Handle download options - THIS IS THE FIX
                const websiteUrl = websiteData.website_url || '';
                if (websiteUrl.trim() !== '') {
                    $('#edit-download-options-section').show();

                    // Set download options checkboxes
                    $('#edit_download_css').prop('checked', websiteData.download_css == 1);
                    $('#edit_download_images').prop('checked', websiteData.download_images == 1);
                    $('#edit_download_js').prop('checked', websiteData.download_js == 1);
                    $('#edit_download_fonts').prop('checked', websiteData.download_fonts == 1);
                    $('#edit_download_json').prop('checked', websiteData.download_json == 1);
                    $('#edit_download_other_assets').prop('checked', websiteData.download_other_assets == 1);

                    // Update select all checkbox
                    this.updateEditSelectAllCheckbox();
                } else {
                    $('#edit-download-options-section').hide();
                }

                // Set HTML content in CKEditor - THIS IS THE FIXED PART
                const htmlCode = websiteData.html_code || '';
                console.log('HTML code to set:', htmlCode);

                // Wait for editor to be ready before setting data
                const setEditorData = () => {
                    if (CKEDITOR.instances.edit_editor1) {
                        try {
                            CKEDITOR.instances.edit_editor1.setData(htmlCode);
                            console.log('HTML content set in editor successfully');
                        } catch (error) {
                            console.error('Error setting editor data:', error);
                        }
                    } else {
                        console.warn('Edit editor not ready yet');
                    }
                };

                // Try setting data multiple times with different delays
                setTimeout(setEditorData, 100);
                setTimeout(setEditorData, 500);
                setTimeout(setEditorData, 1000);
            },

            // Add this new function to WebsiteManager
            updateEditSelectAllCheckbox: function() {
                const assetCheckboxes = [
                    '#edit_download_css',
                    '#edit_download_images',
                    '#edit_download_js',
                    '#edit_download_fonts',
                    '#edit_download_json',
                    '#edit_download_other_assets'
                ];

                const selectAllCheckbox = $('#edit_select_all_assets');
                const totalCheckboxes = assetCheckboxes.length;
                const checkedCount = assetCheckboxes.filter(selector => $(selector).is(':checked')).length;

                if (checkedCount === totalCheckboxes) {
                    selectAllCheckbox.prop('checked', true);
                    selectAllCheckbox.prop('indeterminate', false);
                } else if (checkedCount === 0) {
                    selectAllCheckbox.prop('checked', false);
                    selectAllCheckbox.prop('indeterminate', false);
                } else {
                    selectAllCheckbox.prop('checked', false);
                    selectAllCheckbox.prop('indeterminate', true);
                }
            },

            // Search functionality
            handleSearch: function() {
                let searchTimeout;
                $('#search-input').on('input', function() {
                    clearTimeout(searchTimeout);
                    const query = $(this).val();

                    searchTimeout = setTimeout(function() {
                        LoaderManager.show('جاري البحث...');

                        $.ajax({
                            url: urls.search,
                            type: "GET",
                            data: {
                                query: query
                            },
                            success: function(data) {
                                $('#website-parent-div').html(data);
                            },
                            error: function(xhr, status, error) {
                                console.error("Search error:", error);
                                makeAlert('error', 'حدث خطأ أثناء البحث', translations
                                    .error);
                            },
                            complete: function() {
                                LoaderManager.hide();
                            }
                        });
                    }, 300);
                });
            },

            // Delete website
            handleDelete: function() {
                window.ShowModalDeleteWebsite = function(id) {
                    Swal.fire({
                        title: "{{ __('locale.AreYouSureToTrashThisRecord') }}",
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
                            WebsiteManager.deleteWebsite(id);
                        }
                    });
                };
            },

            deleteWebsite: function(id) {
                LoaderManager.show('جاري الحذف...');

                $.ajax({
                    url: `${urls.trash}/${id}`,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.status) {
                            makeAlert('success', data.message, translations.success);
                            $(`.website-card[data-id="${id}"]`).fadeOut(300, function() {
                                $(this).remove();
                            });
                        }
                    },
                    error: function(response) {
                        const responseData = response.responseJSON;
                        makeAlert('error', responseData.message, translations.error);
                    },
                    complete: function() {
                        LoaderManager.hide();
                    }
                });
            },

            // Validate form
            validateForm: function(form, isEdit = false) {
                const prefix = isEdit ? 'edit_' : '';
                const isSpa = $(`#${prefix}is_spa`).is(':checked');
                const websiteUrl = $(`#${prefix}website_url`).val().trim();
                const spaHtmlCode = $(`#${prefix}spa_html_code`).val().trim();
                const editorId = isEdit ? 'edit_editor1' : 'editor1';
                const regularHtmlCode = CKEDITOR.instances[editorId] ?
                    CKEDITOR.instances[editorId].getData().trim() : '';

                $('.error').empty();

                if (isSpa && !websiteUrl) {
                    $(`.error-website_url`).text('Website URL مطلوب للـ SPA Mode');
                    makeAlert('error', 'Website URL مطلوب عند استخدام SPA Mode', 'خطأ في التحقق');
                    return false;
                }

                if (isSpa && !spaHtmlCode) {
                    $(`.error-spa_html_code`).text('كود HTML مطلوب للـ SPA Mode');
                    makeAlert('error', 'يجب إدخال كود HTML للـ SPA Mode', 'خطأ في التحقق');
                    return false;
                }

                if (!websiteUrl && !regularHtmlCode) {
                    makeAlert('error', 'يجب إدخال Website URL أو HTML Code', 'خطأ في التحقق');
                    return false;
                }

                return true;
            },

            // Prepare form data
            prepareFormData: function(form, editorId) {
                const formData = new FormData(form[0]);

                if (CKEDITOR.instances[editorId]) {
                    let htmlCode = CKEDITOR.instances[editorId].getData();
                    htmlCode = htmlCode.replace(/&nbsp;/g, '').replace(/(<br\s*\/?>\s*)+/g, '');

                    const fieldName = editorId === 'edit_editor1' ? 'updated_html_code' : 'html_code';
                    formData.delete(fieldName);
                    formData.append(fieldName, htmlCode);
                }

                return formData;
            },

            // Handle success response
            handleSuccess: function(data, form, modalId) {
                if (data.status) {
                    let message = data.message;
                    if (data.website_data && data.website_data.is_spa) {
                        message +=
                            `<br><small>تم معالجة الموقع كـ SPA وتحميل ${data.website_data.assets_count || 0} من الأصول</small>`;
                    }

                    makeAlert('success', message, translations.success);
                    $(modalId).modal('hide');

                    // Reset form
                    this.resetForm(form);

                    // Reload page to show updated content
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    makeAlert('error', data.message, translations.error);
                }
            },

            // Handle error response
            handleError: function(response, isEdit = false) {
                const errors = response.responseJSON?.errors || {};
                $('.error').empty();

                $.each(errors, function(key, value) {
                    const errorClass = `.error-${key}`;
                    $(errorClass).text(value[0]);
                });

                const firstError = Object.values(errors)[0]?.[0] ||
                    response.responseJSON?.message ||
                    'Failed to fetch the website. may be the website is not found or you have no permission to access it.';
                makeAlert('error', firstError, translations.error);
            },

            // Reset form
            resetForm: function(form) {
                $('.error').empty();
                form[0].reset();

                // Hide SPA sections
                $('#spa-html-section, #edit-spa-html-section').hide();

                // Reset selects
                form.find('select').each(function() {
                    $(this).find('option').first().prop('selected', true);
                });

                // Reset CKEditor instances
                setTimeout(() => {
                    if (CKEDITOR.instances.editor1) {
                        CKEDITOR.instances.editor1.setData('');
                    }
                    if (CKEDITOR.instances.edit_editor1) {
                        CKEDITOR.instances.edit_editor1.setData('');
                    }
                }, 100);
            },

            // Handle modal events - COMPLETELY FIXED VERSION
            handleModalEvents: function() {
                // Reset form when modal is hidden
                $('.modal').on('hidden.bs.modal', function() {
                    const form = $(this).find('form');
                    if (form.length) {
                        WebsiteManager.resetForm(form);
                    }
                });

                // FIXED: Handle edit modal show event properly
                $('#edit-website').on('show.bs.modal', function() {
                    console.log('Edit modal is about to show...');
                    LoaderManager.show('جاري تحضير النموذج...');
                });

                // FIXED: Initialize editor and populate data when modal is shown
                $('#edit-website').on('shown.bs.modal', function() {
                    console.log('Edit modal shown, creating editor and populating data...');

                    // Create edit editor first
                    WebsiteManager.createEditEditor(function() {
                        console.log('Editor created, now populating data...');

                        // Get stored website data
                        const websiteData = window.currentWebsiteData;
                        if (websiteData) {
                            // Small delay to ensure modal is fully rendered
                            setTimeout(() => {
                                WebsiteManager.populateEditModal(websiteData);
                                LoaderManager.hide();
                            }, 200);
                        } else {
                            console.error('No website data found');
                            LoaderManager.hide();
                        }
                    });
                });

                // Clean up on modal hide
                $('#edit-website').on('hide.bs.modal', function() {
                    // Clean up stored data
                    window.currentWebsiteData = null;

                    // Destroy edit editor
                    if (CKEDITOR.instances.edit_editor1) {
                        CKEDITOR.instances.edit_editor1.destroy(true);
                    }
                });
            },

            // Initialize all functionality
            init: function() {
                console.log('Initializing WebsiteManager...');

                this.initEditors();
                this.handleTypeChange();
                this.handleSPAToggle();
                this.handleAddWebsite();
                this.handleEditWebsite();
                this.handleSearch();
                this.handleDelete();
                this.handleModalEvents();

                // Hide initial loader
                LoaderManager.hide();

                console.log('WebsiteManager initialized successfully');
            }
        };

        // Initialize when document is ready
        $(document).ready(function() {
            WebsiteManager.init();
        });

        // Legacy asset management script variables (if needed)
        const lang = {
            DetailsOfItem: "{{ __('locale.DetailsOfItem', ['item' => __('asset.asset')]) }}"
        };

        const URLs = {
            ajax_list: "{{ route('admin.asset_management.ajax.index') }}"
        };
    </script>

    <script>
        // Show/Hide download options based on website URL input
        document.getElementById('website_url').addEventListener('input', function() {
            const downloadOptionsSection = document.getElementById('download-options-section');
            if (this.value.trim() !== '') {
                downloadOptionsSection.style.display = 'block';
            } else {
                downloadOptionsSection.style.display = 'none';
            }
        });

        // Handle checkbox behavior with hidden inputs
        function setupCheckboxWithHidden(checkboxId) {
            const checkbox = document.getElementById(checkboxId);
            const hiddenInputs = document.querySelectorAll(`input[type="hidden"][name="${checkboxId}"]`);

            checkbox.addEventListener('change', function() {
                // When checkbox is checked, hidden inputs should be disabled
                // When unchecked, hidden inputs should be enabled to send 0 value
                hiddenInputs.forEach(hidden => {
                    hidden.disabled = this.checked;
                });
            });

            // Initial state setup
            hiddenInputs.forEach(hidden => {
                hidden.disabled = checkbox.checked;
            });
        }

        // Setup all download option checkboxes
        document.addEventListener('DOMContentLoaded', function() {
            const downloadOptions = ['download_css', 'download_images', 'download_js', 'download_fonts',
                'download_json', 'download_other_assets'
            ];
            downloadOptions.forEach(optionId => {
                setupCheckboxWithHidden(optionId);
            });
        });

        // Select/Deselect all assets functionality
        document.getElementById('select_all_assets').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll(
                '#download-options-section input[type="checkbox"]:not(#select_all_assets)');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                // Trigger change event to update hidden inputs
                checkbox.dispatchEvent(new Event('change'));
            });
        });

        // Update select all checkbox when individual checkboxes change
        document.addEventListener('DOMContentLoaded', function() {
            const downloadCheckboxes = document.querySelectorAll(
                '#download-options-section input[type="checkbox"]:not(#select_all_assets)');
            downloadCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allCheckboxes = document.querySelectorAll(
                        '#download-options-section input[type="checkbox"]:not(#select_all_assets)'
                    );
                    const checkedBoxes = document.querySelectorAll(
                        '#download-options-section input[type="checkbox"]:not(#select_all_assets):checked'
                    );
                    const selectAllCheckbox = document.getElementById('select_all_assets');

                    if (checkedBoxes.length === allCheckboxes.length) {
                        selectAllCheckbox.checked = true;
                        selectAllCheckbox.indeterminate = false;
                    } else if (checkedBoxes.length === 0) {
                        selectAllCheckbox.checked = false;
                        selectAllCheckbox.indeterminate = false;
                    } else {
                        selectAllCheckbox.checked = false;
                        selectAllCheckbox.indeterminate = true;
                    }
                });
            });
        });

        // Show/Hide SPA HTML section
        document.getElementById('is_spa').addEventListener('change', function() {
            const spaSection = document.getElementById('spa-html-section');
            if (this.checked) {
                spaSection.style.display = 'block';
            } else {
                spaSection.style.display = 'none';
            }
        });

        // Form submission debug
        document.getElementById('add-new-website-form').addEventListener('submit', function(e) {
            const formData = new FormData(this);
            console.log('Form submission data:');
            for (let [key, value] of formData.entries()) {
                if (key.startsWith('download_')) {
                    console.log(`${key}: ${value}`);
                }
            }
        });
    </script>

    <script>
        function toggleEditDownloadOptions() {
            const websiteUrl = document.getElementById('edit_website_url').value;
            const downloadSection = document.getElementById('edit-download-options-section');

            if (websiteUrl && websiteUrl.trim() !== '') {
                downloadSection.style.display = 'block';
            } else {
                downloadSection.style.display = 'none';
                // Clear all download options when hiding
                const downloadCheckboxes = [
                    'edit_download_css',
                    'edit_download_images',
                    'edit_download_js',
                    'edit_download_fonts',
                    'edit_download_json',
                    'edit_download_other_assets',
                    'edit_select_all_assets'
                ];

                downloadCheckboxes.forEach(checkboxId => {
                    const checkbox = document.getElementById(checkboxId);
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                });
            }
        }


        // Function to toggle SPA HTML section
        function toggleEditSpaSection() {
            const isSpaChecked = document.getElementById('edit_is_spa').checked;
            const spaSection = document.getElementById('edit-spa-html-section');

            if (isSpaChecked) {
                spaSection.style.display = 'block';
            } else {
                spaSection.style.display = 'none';
            }
        }

        // Function to handle select all assets checkbox
        function handleEditSelectAllAssets() {
            const selectAllCheckbox = document.getElementById('edit_select_all_assets');
            const assetCheckboxes = [
                'edit_download_css',
                'edit_download_images',
                'edit_download_js',
                'edit_download_fonts',
                'edit_download_json',
                'edit_download_other_assets'
            ];

            assetCheckboxes.forEach(checkboxId => {
                const checkbox = document.getElementById(checkboxId);
                if (checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                }
            });
        }

        // Function to populate edit modal with website data
        function populateEditWebsiteModal(websiteData) {
            // Basic fields
            document.getElementById('edit_website_id').value = websiteData.id;
            document.getElementById('edit_name').value = websiteData.name;
            document.getElementById('edit_phishing_category_id').value = websiteData.phishing_category_id;
            document.getElementById('edit_from_address_name').value = websiteData.from_address_name || '';
            document.getElementById('edit_domain_id').value = websiteData.domain_id || '';
            document.getElementById('edit_website_url').value = websiteData.website_url || '';

            // Type radio buttons
            if (websiteData.type === 'own') {
                document.getElementById('edit_own').checked = true;
            } else {
                document.getElementById('edit_managed').checked = true;
            }

            // SPA checkbox
            document.getElementById('edit_is_spa').checked = websiteData.is_spa == 1;
            document.getElementById('edit_spa_html_code').value = websiteData.spa_html_code || '';

            // Download options checkboxes
            document.getElementById('edit_download_css').checked = websiteData.download_css == 1;
            document.getElementById('edit_download_images').checked = websiteData.download_images == 1;
            document.getElementById('edit_download_js').checked = websiteData.download_js == 1;
            document.getElementById('edit_download_fonts').checked = websiteData.download_fonts == 1;
            document.getElementById('edit_download_json').checked = websiteData.download_json == 1;
            document.getElementById('edit_download_other_assets').checked = websiteData.download_other_assets == 1;

            // Update select all checkbox based on individual checkboxes
            updateEditSelectAllCheckbox();

            // Show/hide sections based on current values
            toggleEditDownloadOptions();
            toggleEditSpaSection();

            // Update form action URL
            const form = document.getElementById('edit-website-form');
            const action = form.getAttribute('action');
            form.setAttribute('action', action.replace(':id', websiteData.id));

            // Handle cover image preview if exists
            if (websiteData.cover_url) {
                document.getElementById('current-cover-image').src = websiteData.cover_url;
                document.getElementById('current-cover-preview').style.display = 'block';
            } else {
                document.getElementById('current-cover-preview').style.display = 'none';
            }

            // Set HTML content in editor (if using a rich text editor)
            if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.edit_editor1) {
                CKEDITOR.instances.edit_editor1.setData(websiteData.html_code || '');
            } else {
                document.getElementById('edit_editor1').value = websiteData.html_code || '';
            }
        }

        // Function to update select all checkbox based on individual checkboxes
        function updateEditSelectAllCheckbox() {
            const assetCheckboxes = [
                'edit_download_css',
                'edit_download_images',
                'edit_download_js',
                'edit_download_fonts',
                'edit_download_json',
                'edit_download_other_assets'
            ];

            const selectAllCheckbox = document.getElementById('edit_select_all_assets');
            const checkedCount = assetCheckboxes.filter(id => document.getElementById(id).checked).length;

            selectAllCheckbox.checked = checkedCount === assetCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < assetCheckboxes.length;
        }

        // Event listeners for edit modal
        document.addEventListener('DOMContentLoaded', function() {
            // Website URL change event
            const editWebsiteUrlInput = document.getElementById('edit_website_url');
            if (editWebsiteUrlInput) {
                editWebsiteUrlInput.addEventListener('input', toggleEditDownloadOptions);
            }

            // SPA checkbox change event
            const editIsSpaCheckbox = document.getElementById('edit_is_spa');
            if (editIsSpaCheckbox) {
                editIsSpaCheckbox.addEventListener('change', toggleEditSpaSection);
            }

            // Select all assets checkbox event
            const editSelectAllCheckbox = document.getElementById('edit_select_all_assets');
            if (editSelectAllCheckbox) {
                editSelectAllCheckbox.addEventListener('change', handleEditSelectAllAssets);
            }

            // Individual asset checkboxes events
            const assetCheckboxes = [
                'edit_download_css',
                'edit_download_images',
                'edit_download_js',
                'edit_download_fonts',
                'edit_download_json',
                'edit_download_other_assets'
            ];

            assetCheckboxes.forEach(checkboxId => {
                const checkbox = document.getElementById(checkboxId);
                if (checkbox) {
                    checkbox.addEventListener('change', updateEditSelectAllCheckbox);
                }
            });
        });

        // Example usage when opening edit modal
        function openEditModal(websiteData) {
            populateEditWebsiteModal(websiteData);
            const modal = new bootstrap.Modal(document.getElementById('edit-website'));
            modal.show();
        }
    </script>
    {{-- Include asset management script if needed --}}
    <script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
@endsection
