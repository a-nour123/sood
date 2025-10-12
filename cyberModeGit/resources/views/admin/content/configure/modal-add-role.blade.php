<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true" data-type="create">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-add-new-role">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-5 pb-5">
                <div class="text-center mb-4">
                    <h1 class="role-title">Add New Role</h1>
                    <p>Set role permissions</p>
                </div>
                <!-- Add role form -->
                <form id="addRoleForm" class="row" method="post"
                    action="{{ route('admin.configure.roles.role.store') }}">
                    @csrf
                    <div class="col-12">
                        <label class="form-label" for="modalRoleName">Role Name</label>
                        <input type="text" id="modalRoleName" name="name" class="form-control"
                            placeholder="Enter role name" tabindex="-1" data-msg="Please enter role name" />
                    </div>
                    <div class="col-12">
                        <h4 class="mt-2 pt-50">Role Permissions</h4>
                        <div class="form-check">
                            <input class="form-check-input selectAllpermissionGroup" type="checkbox" />
                            <label class="form-check-label" for="selectAll"> Select All </label>
                        </div>
                        <!-- Permission table -->
                        <div class="table-responsive">
                            <table class="table table-flush-spacing">
                                <tbody>
                                    @foreach ($permissions_group as $groups)
                                        {{--  @if (in_array($groups->id, [5]))
                                            @continue
                                        @endif  --}}
                                        <tr>
                                            <td class="text-nowrap fw-bolder">
                                                {{ $groups->name }}
                                                <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Allows a full access to the system">
                                                    <i data-feather="info"></i>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input selectAllPermission" type="checkbox"
                                                        data-id="{{ $groups->id }}" />
                                                    <label class="form-check-label" for="selectAll"> Select All </label>
                                                </div>
                                            </td>
                                        </tr>


                                        {{-- <tr style="padding: 5px 0;">
                                            {{ $groups->name }} <i data-feather="info"></i>
                                        </tr> --}}
                                        @foreach ($groups->subgroups as $subgroup)
                                        {{-- nuglect Tests and Compliance --}}
                                            {{--  @if (in_array($subgroup->id, [4, 6, 7, 8, 11, 18]))
                                                @continue
                                            @endif  --}}
                                            <tr>
                                                <td class="text-nowrap fw-bolder" style="padding: 5px 0px 5px 20px">
                                                    {{ $subgroup->name }}
                                                    <input type="hidden" value="{{ $subgroup->id }}">
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-wrap">
                                                        @foreach ($subgroup->permissions as $permission)
                                                            <div class="form-check me-2 me-lg-5" style="width: 18%;">
                                                                <input
                                                                    class="form-check-input checkboxType-{{ $groups->id }}"
                                                                    type="checkbox" name="keys[]"
                                                                    value="{{ $permission->id }}" />
                                                                <label class="form-check-label">
                                                                    {{ $permission->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                        <!-- Permission table -->
                    </div>
                    <div class="col-12 text-center mt-2">
                        <button type="submit" class="btn btn-primary me-1">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">
                            Discard
                        </button>
                    </div>
                </form>
                <!--/ Add role form -->
            </div>
        </div>
    </div>
</div>
<!--/ Add Role Modal -->
