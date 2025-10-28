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
                            @forelse ($actionsWithSettingsAuto as $action)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ __('locale.' . $action['action_name']) }}
                                    </td>
                                    <td>
                                        <span id ="AutoNotifyEditStatus-{{ $action['action_id'] }}"
                                            class="badge rounded-pill badge-light-{{ $action['auto_notifies_status'] ? 'success' : 'danger' }}">
                                            {{ $action['auto_notifies_status'] ? __('locale.Active') : __('locale.Inactive') }}</span>

                                    </td>
                                    <td>
                                        <a id="AutoNotifyEdit-{{ $action['action_id'] }}" class="item-edit"
                                            href="javascript:;"
                                            onclick="ShowModalEditAutoNOtfiy( {{ $action['action_id'] }} , {{ $action['auto_notifies_id'] ? $action['auto_notifies_id'] : '' }})">
                                            <i data-feather="edit" class="font-small-4"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="center-cell" colspan="4">{{ __('locale.No actions with settings found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .center-cell {
        text-align: center;
    }
</style>
