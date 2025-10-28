
<section id="advanced-search-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom p-1">
                    <div class="dt-action-buttons text-end">
                        <div class="dt-buttons d-inline-flex">


                        </div>
                    </div>
                </div>
                <!--Search Form -->

                <hr class="my-0" />

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('locale.Action') }}</th>
                                <th>{{ __('locale.Status') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="risks-table-content">
                            @foreach ($actionsWithSettings as $action)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ __('locale.' . $action['action_name']) }}
                                    </td>
                                    <td>
                                        <span id ="systemNotificationStatus-{{ $action['action_id'] }}"
                                            class="badge rounded-pill badge-light-{{ $action['system_notification_setting_status'] ? 'success' : 'danger' }}">
                                            {{ $action['system_notification_setting_status'] ? __('locale.Active') : __('locale.Inactive') }}</span>

                                    </td>
                                    <td>
                                        <a id="systemNotificationEdit-{{ $action['action_id'] }}" class="item-edit"
                                            href="javascript:;"
                                            onclick="ShowModalEditSystemNotification( {{ $action['action_id'] }} , {{ $action['system_notification_setting_id'] ? $action['system_notification_setting_id'] : '' }})">
                                            <i data-feather="edit" class="font-small-4"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
