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
