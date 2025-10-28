
    @php $configData = Helper::applClasses(); @endphp

    <!-- BEGIN: Content-->
    <div class="app-content content {{$configData['pageClass']}}" style="width: 100%">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
    <div class="content-area-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : '' }}">
        <div class="{{ $configData['sidebarPositionClass'] }}">
            <div class="sidebar">
                {{-- Include Sidebar Content --}}
                <div class="sidebar-content todo-sidebar">
                    <div class="todo-app-menu">
                        <div class="add-task">
                            @if (auth()->user()->hasPermission('category.create'))
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#new-frame-modal">
                                {{ __('locale.AddNewCategory') }}
                            </button>
                            @endif
                        </div>

                        <div class="sidebar-menu-list">
                            <div class="list-group list-group-filters">
                                <div class="tab" id="tabs">
                                    @foreach ($category2 as $item)
                                    <button class="list-group-item list-group-item-action tablinks FireWire"

                                            alt="{{$item->id}}" id="category-btn-{{ $item->id }}">
                                        <span class=" fa {{ $item->icon }}" style=" padding: 0 6px;  font-size: 20px;  color: #44225c; "></span>
                                        {{ $item->name }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="{{ $configData['contentsidebarClass'] }}">
            <div class="content-wrapper">
                <div class="content-body">
                    {{-- Include Page Content --}}
                    <div class="todo-app-list">

                        <!-- control List starts -->
                        <div class="todo-task-list-wrapper list-group">
                            <ul class="todo-task-list media-list" id="todo-task-list">

                                @foreach ($categoryList as $item)

                                <div id="firstTab{{ $item->id }}" class="tabcontent">

                                    <!-- Dark Tables start -->
                                    <div class="row" id="dark-table">
                                        <div class="col-12">

                                            <div class="card2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="frame">
                                                            <h4 class="card-title"> {{ __('locale.Name') }} : </h4>
                                                            <h5 class="card-desc"> {{ $item->name}} </h5>
                                                        </div>

                                                        <!-- <a href="#" class="card-link">Another link</a> -->
                                                        @if (auth()->user()->hasPermission('category.update'))
                                                        <button type="button" class="card-link btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#edit-modal{{ $item->id}}">
                                                            {{ __('locale.Edit') }}
                                                        </button>
                                                        @endif
                                                        @if (auth()->user()->hasPermission('category.delete'))
                                                        <form class="category_del" action="{{route('admin.governance.category.destroy',  $item->id )}}" style="display: inline-block;" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="card-link btn btn-outline-danger update-btn">{{ __('locale.Delete') }}</button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal modal-slide-in sidebar-todo-modal fade" id="edit-modal{{$item->id}}">
                                        <div class="modal-dialog sidebar-lg">
                                            <div class="modal-content p-0">

                                                <div class="alert alert-danger print-error-msg" style="display:none">
                                                    <ul></ul>
                                                </div>
                                                <form id="form-edit" class=" form-edit todo-modal needs-validation" novalidate method="POST" action="{{ route('admin.governance.category.update' , $item->id ) }}">
                                                    @csrf

                                                    <div class="modal-header align-items-center mb-1">
                                                        <h5 class="modal-title">{{ __('locale.Update') }} {{ __('locale.Category') }}</h5>
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

                                    <!-- add document starts -->
                                    <div class="modal modal-slide-in sidebar-todo-modal fade add_document" id="add_control{{$item->id}}">
                                        <div class="modal-dialog sidebar-lg">
                                            <div class="modal-content p-0">
                                                <form class=" form-add_control todo-modal needs-validation" novalidate method="POST" action="{{route('admin.governance.document.store' , $item->id)}}" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="modal-header align-items-center mb-1">
                                                        <h5 class="modal-title">{{ __('locale.AddANewDocument') }}</h5>
                                                        <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                                                            <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star" class="font-medium-2"></i></span>
                                                            <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                                        <div class="action-tags">
                                                            <div class="mb-1">
                                                                <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                                                                <input type="text" name="name" class=" form-control" required />
                                                                <span class="error error-name "></span>
                                                            </div>

                                                            <div class="mb-1">
                                                                <label class="form-label">{{ __('locale.Frameworks') }}</label>
                                                                <select class="js-example-basic-multiple" _id="framework" name="framework_ids[]" multiple>
                                                                    @foreach($frameworks as $framework)
                                                                    <option class="option" data-controls="{{json_encode($framework->FrameworkControls)}}" value="{{$framework->id}}" data-available_text="{{$framework->id}}">{{$framework->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="error error-framework_ids"></span>
                                                            </div>

                                                            <div class="mb-1">
                                                                <label class="form-label">{{ __('locale.Controls') }}</label>
                                                                <select class="js-example-basic-multiple" name="control_ids[]" _id="controls_id" multiple="multiple">
                                                                </select>
                                                                <span class="error error-control_ids"></span>
                                                            </div>

                                                            <!-- //AdditionalStakeholders -->
                                                            <div class="mb-1">
                                                                <label class="form-label" for="additional_stakeholders">{{ __('locale.AdditionalStakeholders') }}</label>
                                                                <select name="additional_stakeholders[]" class="js-example-basic-multiple" _id="additional_stakeholders" multiple>
                                                                    <option value="">{{ __('locale.select-option') }}</option>
                                                                    @foreach($testers as $tester)
                                                                    <option value="{{$tester->id}}">{{$tester->name}}</option>
                                                                    @endforeach

                                                                </select>
                                                                <span class="error error-additional_stakeholders"></span>
                                                            </div>

                                                            <!-- //owner -->

                                                            @if( auth()->user()->role_id == 1)
                                                            <div class="mb-1">
                                                                <label class="form-label" for="owner">{{ __('locale.DocumentOwner') }}</label>
                                                                <select class="select2 form-select" _id="task-assigned" name="owner">
                                                                    <option value="">{{ __('locale.select-option') }}</option>
                                                                    @foreach($testers as $tester)
                                                                    <option value="{{$tester->id}}">{{$tester->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="error error-owner"></span>
                                                            </div>
                                                            @endif

                                                            <div class="mb-1">
                                                                <label class="form-label" for="teams">{{ __('locale.Teams') }}</label>

                                                                <select _id="teams" name="team_ids[]" class="js-example-basic-multiple" multiple>
                                                                    <option value="">{{ __('locale.select-option') }}</option>
                                                                    @foreach($teams as $team)
                                                                    <option value="{{$team->id}}">{{$team->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="error error-team_ids"></span>
                                                            </div>

                                                            <div class="mb-1">
                                                                <label for="">{{ __('locale.CreationDate') }}</label>
                                                                <input type="text" name="creation_date" value="<?php echo date('Y-m-d'); ?>" id="creation_date" class="form-control js-datepicker">
                                                                <span class="error error-creation_date"></span>
                                                            </div>

                                                            <div class="mb-1">
                                                                <label for="">{{ __('locale.LastReview') }}</label>
                                                                <input type="text" data-i="0" name="last_review_date" value="<?php echo date('Y-m-d'); ?>" placeholder="YYYY-MM-DD " id="last_review" class="form-control js-datepicker">
                                                                <span class="error error-last_review_date"></span>
                                                            </div>

                                                            <div class="mb-1">
                                                                <label for="">{{ __('locale.ReviewFrequency') }} ({{ __('locale.days') }})</label>
                                                                <input type="number" min="0" name="review_frequency" id="review_frequency" value="0" class="form-control">
                                                                <span class="error error-review_frequency"></span>
                                                            </div>

                                                            <div class="mb-1">
                                                                <label for="">{{ __('locale.NextReviewDate') }}</label>
                                                                <input type="text" data-i="0"disabled name="next_review_date" placeholder="YYYY-MM-DD " id="next_review" class="form-control">
                                                                <span class="error error-next_review_date"></span>
                                                            </div>

                                                            {{-- <div class="mb-1">
                                                                <label for=""> ParentDocument </label>
                                                                <div class="parent_documents_container">
                                                                    <select name="parent" class="form-select select2 ">
                                                                        <option value="">select parent</option>
                                                                        @foreach($documents as $doc)
                                                                        <option value="{{$doc->id}}">{{$doc->document_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div> --}}

                                                            <div class="mb-1">
                                                                <label for="">{{ __('locale.Status') }}</label>
                                                                <div class="parent_documents_container">
                                                                    <select name="status" _id="status" class="form-select select2 " onchange="changePrivacy(this.value)">
                                                                        <option value="" selected disabled hidden>{{ __('locale.select-option') }}</option>
                                                                        @foreach($status as $sta)
                                                                        <option value="{{$sta->id}}">{{$sta->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <span class="error error-status"></span>
                                                                </div>
                                                            </div>

                                                            <div class="mb-1" id="approval_date">
                                                                <label for="">{{ __('locale.ApprovalDate') }}</label>
                                                                <input type="text" data-i="0" name="approval_date" placeholder="YYYY-MM-DD " class="form-control js-datepicker">
                                                                <span class="error error-approval_date"></span>
                                                            </div>

                                                            <!-- //owner -->
                                                            <div class="mb-1" id="reviewer">
                                                                <label class="form-label" for="reviewer">{{ __('locale.Reviewer') }}</label>
                                                                <select class="select2 form-select" name="reviewer">
                                                                    <option value="">{{ __('locale.select-option') }}</option>
                                                                    @foreach($testers as $tester)
                                                                    <option value="{{$tester->id}}">{{$tester->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="error error-reviewer"></span>
                                                            </div>

                                                            <div class="mb-1" id="privacy">
                                                                <label for="">{{ __('locale.Privacy') }}</label>
                                                                <div class="parent_documents_container">
                                                                    <select name="privacy" class="form-select select2 ">
                                                                        @foreach($privacies as $priv)
                                                                        <option value="{{$priv->id}}">{{$priv->title}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <span class="error error-privacy"></span>
                                                                </div>
                                                            </div>

                                                            <div class="mb-1 supporting_documentation_container">
                                                                <label class="text-label">{{ __('locale.File') }}</label>
                                                                :
                                                                <input type="file" name="file"
                                                                       class="form-control dt-post"
                                                                       aria-label="{{ __('locale.File') }}" />
                                                                <span class="error error-file "></span>
                                                            </div>

                                                            <div class="my-1">
                                                                <button type="submit" class="btn btn-primary add-todo-item me-1">{{ __('locale.Add') }}</button>
                                                                <button type="button" class="btn btn-outline-secondary add-todo-item " data-bs-dismiss="modal">
                                                                    {{ __('locale.Cancel') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- add document end -->

                                    <li class="todo-item">

                                        <!-- Advanced Search -->
                                        <section id="advanced-search-datatable">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">

                                                        <div class="card-header border-bottom p-1">
                                                            <div class="head-label">
                                                                <h4 class="card-title">{{ __('locale.Documents') }}</h4>
                                                            </div>
                                                            @if (auth()->user()->hasPermission('document.create'))
                                                            <div class="dt-action-buttons text-end">
                                                                <div class="dt-buttons d-inline-flex">
                                                                    <button class="dt-button  btn btn-primary  me-2" type="button" data-bs-toggle="modal" data-bs-target="#add_control{{$item->id}}">
                                                                        {{ __('locale.AddANewDocument') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>

                                                        <!--Search Form -->

                                                        <hr class="my-0" />
                                                        @dump($document_id)
                                                        <div class="card-datatable table-responsive mx-1">

                                                            <table class="dt-advanced-search{{ $item->id }} table">
                                                                <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th class="all">{{ __('locale.Name') }}</th>
                                                                    <th class="all">{{ __('locale.Frameworks') }}</th>
                                                                    <th class="all">{{ __('locale.Controls') }}</th>
                                                                    <th class="all">{{ __('locale.CreationDate') }}</th>
                                                                    <th class="all">{{ __('locale.ApprovalDate') }}</th>
                                                                    <th class="all">{{ __('locale.Status') }}</th>
                                                                    <th class="all">{{ __('locale.Actions') }}</th>
                                                                </tr>
                                                                </thead>

                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <!--/ Advanced Search -->
                                    </li>
                                </div>
                                @endforeach
                            </ul>
                            <div class="no-results">
                                <h5>No Items Found</h5>
                            </div>
                        </div>
                        <!-- Todo List ends -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


