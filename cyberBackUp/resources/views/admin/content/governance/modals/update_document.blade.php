<div class="modal modal-slide-in sidebar-todo-modal fade" id="edit-modal{{$item->id}}">
    <div class="modal-dialog sidebar-lg">
        <div class="modal-content p-0">

            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <form id="form-edit" class=" form-edit todo-modal needs-validation" novalidate method="POST" action="{{ route('admin.governance.category.update' , $item->id ) }}">
                @csrf

                <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">{{ __('locale.Update') }} {{ __('governance.Category') }}</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star" class="font-medium-2"></i></span>
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div>
                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                    <div class="action-tags">
                        <div class="mb-1">
                            <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                            <input type="text" name="name" class=" form-control" value="{{ $item->name}}" required />
                            <span class="error error-name "></span>
                        </div>
                        <div class="mb-1 ">
                            <label for="task-assigned" class="form-label d-block">{{ __('locale.Icons') }}</label>
                            <select class="form-select" style="text-align-last: left;font-weight: 600;margin-right: 0;vertical-align: text-bottom;" id="view_type_sorting" aria-haspopup="true" aria-expanded="false" name="icon">
                                <option value="" selected disabled hidden>{{ __('locale.select-option') }}</option>
                                <option {{ $item->icon == 'fas fa-ban'? 'selected' : ''  }} value='fas fa-ban'>&#xf05e; fa-ban</option>
                                <option {{ $item->icon == 'fas fa-bug'? 'selected' : ''  }} value='fas fa-bug'>&#xf188; fa-bug</option>
                                <option {{ $item->icon == 'fas fa-dungeon'? 'selected' : ''  }} value='fas fa-dungeon'>&#xf6d9; fa-dungeon</option>
                                <option {{ $item->icon == 'far fa-eye'? 'selected' : ''  }} value='far fa-eye'>&#xf06e; fa-eye </option>
                                <option {{ $item->icon == 'far fa-eye-slash'? 'selected' : ''  }} value='far fa-eye-slash'>&#xf070; fa-eye-slash </option>
                                <option {{ $item->icon == 'fas fa-file-signature'? 'selected' : ''  }} value='fas fa-file-signature'>&#xf573; fa-file-signature</option>
                                <option {{ $item->icon == 'fas fa-id-fingerprint'? 'selected' : ''  }} value='fas fa-id-fingerprint'>&#xf577; fa-id-fingerprint </option>
                                <option {{ $item->icon == 'far fa-id-badge'? 'selected' : ''  }} value='far fa-id-badge'>&#xf2c1; fa-id-badge</option>
                                <option {{ $item->icon == 'fas fa-id-badge'? 'selected' : ''  }} value='fas fa-id-badge'>&#xf2c1; fa-id-badge </option>
                                <option {{ $item->icon == 'far fa-id-card'? 'selected' : ''  }} value='far fa-id-card'>&#xf2c2;fa-id-card </option>
                                <option {{ $item->icon == 'fas fa-key'? 'selected' : ''  }} value='fas fa-key'>&#xf084; fa-key </option>
                                <option {{ $item->icon == 'fas  fa-lock'? 'selected' : ''  }} value='fas  fa-lock'>&#xf023; fa-lock</option>
                                <option {{ $item->icon == 'fas fa-unlock'? 'selected' : ''  }} value='fas fa-unlock'>&#xf09c; fa-unlock</option>
                                <!-- <option {{ $item->icon == 'fas fa-unlock-alt'? 'selected' : ''  }} value='fas fa-unlock-alt'>&#xf13e; fa-unlock-alt </option> -->
                                <!-- <option {{ $item->icon == 'fas user-lock'? 'selected' : ''  }} value='fas user-lock'>&#xf502; user-lock</option> -->
                                <option {{ $item->icon == 'fas fa-user-secret'? 'selected' : ''  }} value='fas fa-user-secret'>&#xf21b; fa-user-secret </option>
                                <option {{ $item->icon == 'fa-underline'? 'selected' : ''  }} value='fa-underline'>&#xf0cd; fa-underline </option>
                                <option {{ $item->icon == 'fa-undo'? 'selected' : ''  }} value='fa-undo'>&#xf0e2; fa-undo </option>
                                <option {{ $item->icon == 'fa-universal-access'? 'selected' : ''  }} value='fa-universal-access'>&#xf29a; fa-universal-access </option>
                                <option {{ $item->icon == 'fa-university'? 'selected' : ''  }} value='fa-university'>&#xf19c; fa-university </option>
                                <option {{ $item->icon == 'fa-unlink'? 'selected' : ''  }} value='fa-unlink'>&#xf127; fa-unlink </option>
                                <option {{ $item->icon == 'fa-unlock'? 'selected' : ''  }} value='fa-unlock'>&#xf09c; fa-unlock </option>
                                <option {{ $item->icon == 'fa-unlock-alt'? 'selected' : ''  }} value='fa-unlock-alt'>&#xf13e; fa-unlock-alt </option>
                                <option {{ $item->icon == 'fa-unsorted'? 'selected' : ''  }} value='fa-unsorted'>&#xf0dc; fa-unsorted </option>
                                <option {{ $item->icon == 'fa-upload'? 'selected' : ''  }} value='fa-upload'>&#xf093; fa-upload </option>
                                <option {{ $item->icon == 'fa-usb'? 'selected' : ''  }} value='fa-usb'>&#xf287; fa-usb </option>
                                <option {{ $item->icon == 'fa-usd'? 'selected' : ''  }} value='fa-usd'>&#xf155; fa-usd </option>
                                <option {{ $item->icon == 'fa-user'? 'selected' : ''  }} value='fa-user'>&#xf007; fa-user </option>
                                <option {{ $item->icon == 'fa-user-circle'? 'selected' : ''  }} value='fa-user-circle'>&#xf2bd; fa-user-circle </option>
                                <option {{ $item->icon == 'fa-user-circle-o'? 'selected' : ''  }} value='fa-user-circle-o'>&#xf2be; fa-user-circle-o </option>
                                <option {{ $item->icon == 'fa-user-md'? 'selected' : ''  }} value='fa-user-md'>&#xf0f0; fa-user-md </option>
                                <option {{ $item->icon == 'fa-user-o'? 'selected' : ''  }} value='fa-user-o'>&#xf2c0; fa-user-o </option>
                                <option {{ $item->icon == 'fa-user-plus'? 'selected' : ''  }} value='fa-user-plus'>&#xf234; fa-user-plus </option>
                                <option {{ $item->icon == 'fa-user-secret'? 'selected' : ''  }} value='fa-user-secret'>&#xf21b; fa-user-secret </option>
                                <option {{ $item->icon == 'fa-user-times'? 'selected' : ''  }} value='fa-user-times'>&#xf235; fa-user-times </option>
                                <option {{ $item->icon == 'fa-users'? 'selected' : ''  }} value='fa-users'>&#xf0c0; fa-users </option>
                                <option {{ $item->icon == 'fa-vcard'? 'selected' : ''  }} value='fa-vcard'>&#xf2bb; fa-vcard </option>
                                <option {{ $item->icon == 'fa-vcard-o'? 'selected' : ''  }} value='fa-vcard-o'>&#xf2bc; fa-vcard-o </option>
                                <option {{ $item->icon == 'fa-venus'? 'selected' : ''  }} value='fa-venus'>&#xf221; fa-venus </option>
                                <option {{ $item->icon == 'fa-venus-double'? 'selected' : ''  }} value='fa-venus-double'>&#xf226; fa-venus-double </option>
                                <option {{ $item->icon == 'fa-venus-mars'? 'selected' : ''  }} value='fa-venus-mars'>&#xf228; fa-venus-mars </option>
                                <option {{ $item->icon == 'fa-viacoin'? 'selected' : ''  }} value='fa-viacoin'>&#xf237; fa-viacoin </option>
                                <option {{ $item->icon == 'fa-viadeo'? 'selected' : ''  }} value='fa-viadeo'>&#xf2a9; fa-viadeo </option>
                                <option {{ $item->icon == 'fa-viadeo-square'? 'selected' : ''  }} value='fa-viadeo-square'>&#xf2aa; fa-viadeo-square </option>
                                <option {{ $item->icon == 'fa-video-camera'? 'selected' : ''  }} value='fa-video-camera'>&#xf03d; fa-video-camera </option>
                                <option {{ $item->icon == 'fa-vimeo'? 'selected' : ''  }} value='fa-vimeo'>&#xf27d; fa-vimeo </option>
                                <option {{ $item->icon == 'fa-vimeo-square'? 'selected' : ''  }} value='fa-vimeo-square'>&#xf194; fa-vimeo-square </option>
                                <option {{ $item->icon == 'fa-vine'? 'selected' : ''  }} value='fa-vine'>&#xf1ca; fa-vine </option>
                                <option {{ $item->icon == 'fa-vk'? 'selected' : ''  }} value='fa-vk'>&#xf189; fa-vk </option>
                                <option {{ $item->icon == 'fa-volume-control-phone'? 'selected' : ''  }} value='fa-volume-control-phone'>&#xf2a0; fa-volume-control-phone </option>
                                <option {{ $item->icon == 'fa-volume-down'? 'selected' : ''  }} value='fa-volume-down'>&#xf027; fa-volume-down </option>
                                <option {{ $item->icon == 'fa-volume-off'? 'selected' : ''  }} value='fa-volume-off'>&#xf026; fa-volume-off </option>
                                <option {{ $item->icon == 'fa-volume-up'? 'selected' : ''  }} value='fa-volume-up'>&#xf028; fa-volume-up </option>
                                <option {{ $item->icon == 'fa-warning'? 'selected' : ''  }} value='fa-warning'>&#xf071; fa-warning </option>
                                <option {{ $item->icon == 'fa-wechat'? 'selected' : ''  }} value='fa-wechat'>&#xf1d7; fa-wechat </option>
                                <option {{ $item->icon == 'fa-weibo'? 'selected' : ''  }} value='fa-weibo'>&#xf18a; fa-weibo </option>
                                <option {{ $item->icon == 'fa-weixin'? 'selected' : ''  }} value='fa-weixin'>&#xf1d7; fa-weixin </option>
                                <option {{ $item->icon == 'fa-whatsapp'? 'selected' : ''  }} value='fa-whatsapp'>&#xf232; fa-whatsapp </option>
                                <option {{ $item->icon == 'fa-wheelchair'? 'selected' : ''  }} value='fa-wheelchair'>&#xf193; fa-wheelchair </option>
                                <option {{ $item->icon == 'fa-wheelchair-alt'? 'selected' : ''  }} value='fa-wheelchair-alt'>&#xf29b; fa-wheelchair-alt </option>
                                <option {{ $item->icon == 'fa-wifi'? 'selected' : ''  }} value='fa-wifi'>&#xf1eb; fa-wifi </option>
                            </select>
                            <span class="error error-icon "></span>
                        </div>
                    </div>
                    <div class="my-1">

                        <button type="submit" class="btn btn-primary update-btn  me-1">{{ __('locale.Update') }}</button>
                        <button type="button" class="btn btn-outline-danger update-btn " data-bs-dismiss="modal">
                            {{ __('locale.Delete') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--edit category ends -->
