<!-- Edit Website Modal -->
<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="editWebsiteModalLabel"
    aria-hidden="true" id="edit-website">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWebsiteModalLabel">{{ __('phishing.edit website') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body dark-modal">

                <form method="POST" action="{{ route('admin.phishing.website.update', ':id') }}" id="edit-website-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="website_id" id="edit_website_id">

                    <div class="row">
                        <div class="form-group">
                            <label for="edit_name">{{ __('locale.name') }}</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                            <span class="error error-name text-danger my-2"></span>
                        </div>

                        <div class="form-group">
                            <label for="edit_phishing_category_id">{{ __('locale.category') }}</label>
                            <select class="form-control" name="phishing_category_id" id="edit_phishing_category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 my-3">
                            <div class="mb-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" id="edit_own" value="own">
                                    <label class="form-check-label" for="edit_own">{{ __('locale.Own') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" id="edit_managed" value="managed">
                                    <label class="form-check-label" for="edit_managed">{{ __('locale.Managed') }}</label>
                                </div>
                                <span class="error error-type text-danger my-2"></span>
                            </div>
                        </div>

                        <div class="col-6 mb-3" id="edit_website_from_address_name_div">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.FromAddressName') }} <span class="text-danger">*</span></label>
                                <input type="text" name="from_address_name" class="form-control dt-post" id="edit_from_address_name"
                                    aria-label="{{ __('locale.FromAddressName') }}" required />
                                <span class="error error-from_address_name text-danger my-2"></span>
                            </div>
                        </div>

                        <div class="col-6 mb-3" id="edit_website_domain_id_div">
                            <div class="form-group">
                                <label for="edit_domain_id"><b>{{ __('phishing.domain') }} <span class="text-danger">*</span></b></label>
                                <select id="edit_domain_id" name="domain_id" class="form-control">
                                    <option value="">--</option>
                                    @foreach ($domains as $domain)
                                        <option value="{{ $domain->id }}">{{ $domain->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-domain_id text-danger my-2"></span>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.WebsiteUrl') }}</label>
                                <input type="text" name="website_url" class="form-control dt-post" id="edit_website_url"
                                    aria-label="{{ __('locale.WebsiteUrl') }}" />
                                <span class="error error-website_url text-danger my-2"></span>
                            </div>
                        </div>

                        <!-- Download Options Section -->
                        <div class="col-12 mb-3 download-options-section" id="edit-download-options-section" style="display: none;">
                            <div class="card border-info">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fa fa-download text-info"></i> خيارات تحميل الأصول
                                    </h6>
                                    <small class="text-muted">اختر نوع الملفات التي تريد تحميلها مع الموقع</small>
                                </div>
                                <div class="card-body">
                                    <!-- Hidden inputs to ensure all values are sent -->
                                    <input type="hidden" name="download_css" value="0">
                                    <input type="hidden" name="download_images" value="0">
                                    <input type="hidden" name="download_js" value="0">
                                    <input type="hidden" name="download_fonts" value="0">
                                    <input type="hidden" name="download_json" value="0">
                                    <input type="hidden" name="download_other_assets" value="0">

                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="download_css" id="edit_download_css" value="1" checked>
                                                <label class="form-check-label" for="edit_download_css">
                                                    <i class="fa fa-paint-brush text-primary"></i> ملفات CSS
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="download_images" id="edit_download_images" value="1" checked>
                                                <label class="form-check-label" for="edit_download_images">
                                                    <i class="fa fa-image text-success"></i> الصور
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="download_js" id="edit_download_js" value="1" checked>
                                                <label class="form-check-label" for="edit_download_js">
                                                    <i class="fa fa-code text-warning"></i> ملفات JavaScript
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="download_fonts" id="edit_download_fonts" value="1" checked>
                                                <label class="form-check-label" for="edit_download_fonts">
                                                    <i class="fa fa-font text-info"></i> الخطوط
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="download_json" id="edit_download_json" value="1" checked>
                                                <label class="form-check-label" for="edit_download_json">
                                                    <i class="fa fa-file-code text-secondary"></i> ملفات JSON
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="download_other_assets" id="edit_download_other_assets" value="1" checked>
                                                <label class="form-check-label" for="edit_download_other_assets">
                                                    <i class="fa fa-file text-dark"></i> ملفات أخرى
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="edit_select_all_assets" checked>
                                            <label class="form-check-label" for="edit_select_all_assets">
                                                <strong>تحديد/إلغاء تحديد الكل</strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SPA Checkbox Section -->
                        <div class="col-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_spa" id="edit_is_spa" value="1">
                                <label class="form-check-label spa-indicator" for="edit_is_spa">
                                    <i class="fa fa-code"></i> Single Page Application (SPA)
                                </label>
                                <small class="form-text text-muted d-block">
                                    اختر هذا الخيار إذا كان الموقع SPA ولا يظهر المحتوى مباشرة عند السحب
                                </small>
                            </div>
                        </div>

                        <!-- SPA HTML Section (Hidden by default) -->
                        <div class="col-12 mb-3 spa-section" id="edit-spa-html-section" style="display: none;">
                            <div class="instructions">
                                <h6 class="spa-indicator">
                                    <i class="fa fa-info-circle"></i> تعليمات لـ Single Page Applications:
                                </h6>
                                <ol class="mb-0">
                                    <li>افتح الموقع في متصفح جديد</li>
                                    <li>انتظر حتى يحمل المحتوى كاملاً</li>
                                    <li>اضغط F12 أو Right Click → Inspect</li>
                                    <li>في تبويب Elements، انسخ كل كود الـ HTML</li>
                                    <li>الصق الكود في المربع أدناه</li>
                                </ol>
                            </div>

                            <div class="form-group">
                                <label for="edit_spa_html_code" class="spa-indicator">
                                    <i class="fa fa-code"></i> كود HTML الكامل من الـ Inspect:
                                </label>
                                <textarea name="spa_html_code" id="edit_spa_html_code" class="form-control" rows="12"
                                    placeholder="الصق هنا كود الـ HTML الكامل من inspect element بعد تحميل الصفحة كاملة...
                                            مثال:
                                            <!DOCTYPE html>
                                            <html>
                                            <head>...</head>
                                            <body>
                                            <div id='root'>
                                                <!-- المحتوى المولد بـ JavaScript -->
                                            </div>
                                            </body>
                                            </html>">
                                </textarea>
                                <span class="error error-spa_html_code text-danger my-2"></span>
                                <small class="form-text text-muted">
                                    تأكد من نسخ كود الـ HTML بعد تحميل المحتوى كاملاً، وليس قبل التحميل
                                </small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ __('locale.cover') }}</label>
                            <input type="file" name="cover" class="form-control dt-post" id="edit_cover"
                                aria-label="{{ __('locale.cover') }}" />
                            <span class="error error-cover text-danger my-2"></span>
                            <div id="current-cover-preview" class="mt-2" style="display: none;">
                                <small class="text-muted">{{ __('locale.current_cover') }}:</small><br>
                                <img id="current-cover-image" src="" alt="Current Cover" style="max-width: 100px; max-height: 100px; object-fit: cover;" class="border rounded">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_html_code">{{ __('locale.content') }}</label>
                            <textarea name="html_code" id="edit_editor1" cols="30" rows="10"></textarea>
                            <input type="hidden" id="edit_supplemental_guidance_input" name="updated_html_code">
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('locale.close') }}</button>
                <button type="submit" form="edit-website-form" class="btn btn-primary">{{ __('locale.update') }}</button>
            </div>
        </div>
    </div>
</div>
