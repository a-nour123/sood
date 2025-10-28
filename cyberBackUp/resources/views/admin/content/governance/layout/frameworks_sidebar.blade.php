<div class="sidebar-content todo-sidebar">
    <div class="todo-app-menu">
        {{--  @if (auth()->user()->hasPermission('framework.create'))
            <div class="add-task" style="display: flex;flex-direction:column;align-items:center;justify-content:space-between">
                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                    data-bs-target="#new-frame-modal">
                    {{ __('locale.Add') }} {{ __('governance.Framework') }}
                </button>
                <a href="{{ route('admin.governance.notificationsSettingFramework') }}"
                    class="dt-button btn btn-primary mx-2 mt-1" target="_self">
                    {{ __('locale.NotificationsSettings') }}
                </a>
            </div>
        @endif

        <x-export-import name=" {{ __('governance.Framework') }}" createPermissionKey='framework.create'
            exportPermissionKey='framework.export' exportRouteKey='admin.governance.framework.ajax.export'
            importRouteKey='will-added-TODO' />  --}}


        {{--  <hr>  --}}
        <div class="sidebar-menu-list pt-2">
            <div class="list-group list-group-filters">
                <div class="tab CategoryList" id="tabs">
                    @foreach ($sidebarCategory as $item)
                        <button
                            class="list-group-item list-group-item-action tablinks sideNavBtn @if (session('frame_current_id_dtb') == $item->id) activeItemTab @endif"
                            id="item{{ $item->id }}" style=" display: flex;">
                            <span class=" fa {{ $item->icon }}" style=" padding: 0 6px;  font-size: 20px; "></span>
                            <div class="mb-1">
                                {{ $item->name }}
                            </div>
                        </button>
                    @endforeach
                </div>


            </div>
            @if ($checkCount > 5)
                <div class="customPgination" style="width: 100px;margin: auto">
                    <input type="hidden" value="1" id="currentPage">
                    <input type="hidden" value="10" id="lastPage">
                    <button id="PrevFramePage" class="btn btn-primary "
                        style="width: 30px;height: 25px;text-align: center;padding: 5px">&#8249;</button>
                    <button id="NexFramePage" class="btn btn-primary "
                        style="width: 30px;height: 25px;text-align: center;padding: 5px;">&#8250;</button>
                </div>
            @endif
        </div>


    </div>
</div>
