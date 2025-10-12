@foreach ($categoryList as $item)
<div id="firstTab{{ $item->id }}" class="tabcontent">

    <!-- Dark Tables start -->
    <div class="row" id="dark-table">
        <div class="col-12">

            <div class="card2">
                <div class="card">

                    <div class="card-body">

                        <div class="frame">
                            <h4 class="card-title"> {{ __('governance.FrameName:') }}  </h4>
                            <h5 class="card-desc FrameName" > {{ $item->name }} </h5>
                        </div>

                        <div class="frame mb-1">
                            <h4 class="card-title">{{ __('governance.FrameDescription:') }}  </h4>
                            <h5 class="card-desc FrameDesc"> {{ $item->description }}</h5>

                        </div>

                        {{-- <div class="frame">

                            <h4 class="card-title "> Status : </h4>
                            <h5 class="card-desc"> active </h5>
                        </div> --}}

                        <!-- <a href="#" class="card-link">Another link</a> -->
                        @if (auth()->user()->hasPermission('framework.update'))
                        {{-- <button type="button" class="card-link btn btn-outline-primary copyItem"
                                data-bs-toggle="modal" data-bs-target="#copy-modal{{ $item->id }}">
                            {{ __('locale.Copy') }}
                        </button> --}}
                        @endif
                        @if (auth()->user()->hasPermission('framework.update'))
                        <button type="button" class="btn btn-outline-warning updateItem"
                                data-bs-toggle="modal" data-bs-target="#edit-modal{{ $item->id }}">
                            {{ __('locale.Edit') }}
                        </button>
                        @endif
                        @if (auth()->user()->hasPermission('framework.delete'))
                        <button
                                class="card-link btn btn-outline-danger deleteItem" alt="item{{ $item->id }}"> {{ __('locale.Delete') }}
                        </button>
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
    <div class="modal modal-slide-in sidebar-todo-modal fade EditModal" id="edit-modal{{ $item->id }}">
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
                                <input type="text" name="name" class=" form-control FrameNameInput"
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

                                <select class="select2 form-select framework_subdomain_select" name="sub_family[]"
                                        multiple required data-subdomains="{{ json_encode($item->_only_sub_families) }}">
                                </select>
                                <span class="error error-sub_family"></span>
                            </div>

                            {{-- Icon --}}
                            <div class="mb-1 position-relative">
                                <label for="task-assigned" class="form-label d-block">{{ __('locale.Icons') }}</label>
                                <select class="form-select IconsSelect"
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

                                <textarea class="form-control FrameDescription" name="description"> {{ $item->description }}</textarea>
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

    <div class="modal modal-slide-in sidebar-todo-modal fade copyForm" id="copy-modal{{ $item->id }}">
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
                                <input type="text" name="name" class=" form-control FrameNameInput"
                                       placeholder="Title" value="{{ $item->name }}" required />

                                <span class="error error-name "></span>

                            </div>

                            <div class="mb-1 position-relative">
                                <label for="task-assigned" class="form-label d-block">{{ __('locale.Icons') }}</label>
                                <select class="form-select IconsSelect"
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

                                <textarea class="form-control FrameDescription" name="description"> {{ $item->description }}</textarea>
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
    <div class="modal modal-slide-in sidebar-todo-modal fade AddControl" id="add_control{{ $item->id }}">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <form id="form-add_control" class=" form-add_control todo-modal needs-validation"
                      novalidate method="POST"
                      action="{{ route('admin.governance.control.store', $item->id) }}">
                    @csrf

                    <div class="modal-header align-items-center mb-1">
                        <h5 class="modal-title">{{ __('governance.AddControl') }}</h5>
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
                                <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                                <input type="text" name="name" class=" form-control"
                                       placeholder="" required />
                                <span class="error error-name "></span>

                            </div>

                            <div class="mb-1">
                                <label for="desc" class="form-label">{{ __('locale.Description') }}</label>
                                <textarea class="form-control" name="description"></textarea>
                                <span class="error error-description "></span>

                            </div>
                            <div class="mb-1">
                                <label for="title" class="form-label">{{ __('governance.ControlNumber') }}</label>
                                <input type="text" name="number" class=" form-control"
                                       placeholder="" />

                            </div>

                            <!--  long_name -->
                            <div class="mb-1">
                                <label class="form-label" for="long_name">{{ __('governance.LongName') }} </label>
                                <input class="form-control" type="text" name="long_name">
                            </div>

                            <!--  families -->
                            <div class="mb-1 family-container">
                                <label class="form-label" for="family"> {{ __('governance.ControlDomain') }} </label>

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
                                <label class="form-label" for="mitigation_percent">{{ __('governance.mitigationpercent') }} 
                                </label>
                                <input class="form-control" type="text" name="mitigation_percent">
                            </div>

                            <!--  supplemental_guidance -->
                            <div class="mb-1">
                                <label class="form-label" for="supplemental_guidance"> {{ __('governance.supplementalguidance') }}  </label>
                                <input class="form-control" type="text"
                                       name="supplemental_guidance">
                            </div>



                            <div class="mb-1">
                                <label class="form-label" for="priority">{{ __('governance.ControlPriority') }}  </label>

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
                                <label class="form-label" for="phase"> {{ __('governance.ControlPhase') }} </label>

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
                                <label class="form-label" for="type"> {{ __('governance.ControlType') }}</label>

                                <select class="select2 form-select" id="task-assigned"
                                        name="type">
                                    <option value="">
                                        {{ __('governance.selectType') }}
                                    </option>
                                    @foreach ($types as $type)
                                    <option value="{{ $type->id }}">
                                        {{ $type->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-1">
                                <label class="form-label" for="maturity"> {{ __('governance.ControlMaturity') }} </label>

                                <select class="select2 form-select" id="task-assigned"
                                        name="maturity">
                                    <option value="">
                                        {{ __('governance.selectmaturity') }}
                                    </option>
                                    @foreach ($maturities as $maturity)
                                    <option value="{{ $maturity->id }}">
                                        {{ $maturity->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-1">
                                <label class="form-label" for="class"> {{ __('governance.ControlClass') }} </label>

                                <select class="select2 form-select" id="task-assigned"
                                        name="class">
                                    <option value="">
                                        {{ __('governance.selectClass') }}
                                    </option>
                                    @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">
                                        {{ $class->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-1">

                                <label class="form-label" for="desired_maturity"> {{ __('governance.Controldesired') }}
                                    maturity </label>
                                <select class="select2 form-select" id="task-assigned"
                                        name="desired_maturity">
                                    <option value=""> {{ __('governance.selectDesiredMaturity') }} </option>
                                    @foreach ($desiredMaturities as $desiredMaturity)
                                    {
                                    <option value="{{ $desiredMaturity->id }}">
                                        {{ $desiredMaturity->name }} </option>
                                    @endforeach

                                </select>

                            </div>

                            <!-- //owner -->
                            <div class="mb-1">

                                <label class="form-label" for="owner"> {{ __('governance.ControlOwner') }} </label>
                                <select class="select2 form-select" id="task-assigned"
                                        name="owner">
                                    <option value=""> {{ __('governance.selectOwner') }} </option>
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
                                    {{ __('governance.LastTestDate') }}</label>
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
                                    class="btn btn-primary me-1">{{ __('locale.Add') }}</button>
                            <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">
                                    {{ __('locale.Cancel') }}
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
                                    <button class="dt-button  btn btn-primary  me-2 "
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

        <table class="table table-bordered FrameFamiliesTable">
            <thead>
            <tr class="text-center">
                <th>{{ __('governance.Domain') }}</th>
                <th>{{ __('governance.sub_domains') }}</th>
            </tr>
            </thead>
            <tbody>
      {{--      @foreach ($item->only_families as $domain)
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
            </tbody> --}}
        </table>
    </li>
    @endif

</div>
<style>
    .pagination .paginate_button {
      background-color: white !important;

    }
    .dataTables_paginate paging_simple_numbers{
        background-color: white !important;
        width: 50%;
        float: right;
    }
</style>
@endforeach
