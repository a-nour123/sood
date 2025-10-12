{{--  <div class="content-header row">
    <div class="content-header-left col-12 mb-2">

        <div class="row breadcrumbs-top  widget-grid">
            <div class="col-12">
                <div class="page-title mt-2">
                    <div class="row">
                        <div class="col-sm-6 ps-0">
                            <h3 @if (session('serviceDescription')) cursor-pointer @endif"
                                @if (session('serviceDescription')) data-bs-toggle="modal" data-bs-target="#service-description-modal" @endif>
                                @if (session('serviceDescription'))
                                    <i data-feather="help-circle"></i>
                                @endif @yield('title')
                            </h3>
                        </div>
                        <div class="col-sm-6 pe-0">




                            @if (@isset($breadcrumbs))
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="display: flex;">
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

<div class="modal-size-lg d-inline-block">
<!-- Modal -->
<div class="modal fade text-start" id="service-description-modal" tabindex="-1"
    aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">@yield('title')
                    {{ __('locale.ServicesDescription') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="service-description-data" class="ql-editor"></div>
            </div>
        </div>
    </div>
</div>
</div>

</div>  --}}
