@extends('admin/layouts/contentLayoutMaster')

@section('title', __('configure.Import And Export'))

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

    <section id="nav-filled">
        <div class="row match-height">
            <!-- Filled Tabs starts -->
            <div class="col-xl-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <h4 class="card-title">Filled</h4> --}}
                    </div>
                    <div class="card-body">
                        @if (!auth()->user()->hasPermission('import_and_export.import') && !(auth()->user()->hasPermission('import_and_export.export')))
                                <p class="text-danger my-0">{{ __('locale.No permission for import or export') }}</p>
                            @endif
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                            @if (auth()->user()->hasPermission('import_and_export.import'))                            
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab-fill" data-bs-toggle="tab" href="#home-fill"
                                    role="tab" aria-controls="home-fill" aria-selected="true">Import</a>
                            </li>
                            @endif 
                            @if (auth()->user()->hasPermission('import_and_export.export'))                               
                            <li class="nav-item">
                                <a class="nav-link {{ auth()->user()->hasPermission('import_and_export.import') ? '' : 'active' }}" id="profile-tab-fill" data-bs-toggle="tab" href="#profile-fill"
                                    role="tab" aria-controls="profile-fill" aria-selected="false">Export</a>
                            </li>
                            @endif
                            {{-- <li class="nav-item">
              <a
                class="nav-link"
                id="messages-tab-fill"
                data-bs-toggle="tab"
                href="#messages-fill"
                role="tab"
                aria-controls="messages-fill"
                aria-selected="false"
                >Messages</a
              >
            </li>
            <li class="nav-item">
              <a
                class="nav-link"
                id="settings-tab-fill"
                data-bs-toggle="tab"
                href="#settings-fill"
                role="tab"
                aria-controls="settings-fill"
                aria-selected="false"
                >Settings</a
              >
            </li> --}}
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content pt-1">
                            @if (auth()->user()->hasPermission('import_and_export.import'))
                            <div class="tab-pane active" id="home-fill" role="tabpanel" aria-labelledby="home-tab-fill">
                                <section class="basic-select2">
                                    <div class="row">
                                        <div class="col-12">
                                            <form action="{{ route('admin.configure.file-import') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="card">
                                                    {{-- <div class="card-header">
                            <h4 class="card-title">Select</h4>
                          </div> --}}
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <!-- Basic -->
                                                            <div class="col-md-6 mb-1">
                                                                <label class="form-label"
                                                                    for="select2-basic">select</label>
                                                                <select class="select2 form-select table_name"
                                                                    name="table_name" id="select2-basic">
                                                                    <option value="assets">Import Assets</option>
                                                                    <option value="risks">Import Risks</option>
                                                                    {{--  <option value="asset_groups">Asset Group</option>  --}}
                                                                </select>
                                                            </div>
                                                            <input type="file" name="file" value="" style="margin: 10px">
                                                            <button type="submit" class="btn btn-primary"
                                                                style="width: 160px">import</button>

                                                            <a class="btn btn-primary download-ex "
                                                                style="width: 160px; margin:0 10px;" href="{{ asset('uploads/assets.csv') }}">
                                                                download
                                                            </a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </section>
                            </div>
                            @endif
                            @if (auth()->user()->hasPermission('import_and_export.export'))
                            <div class="tab-pane {{ auth()->user()->hasPermission('import_and_export.import') ? '' : 'active' }}" id="profile-fill" role="tabpanel"
                                aria-labelledby="profile-tab-fill">
                                <form action="{{ route('admin.configure.file-export') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-6 mb-1">
                                        <label class="form-label" for="select2-basic">select</label>
                                        <select class="select2 form-select" name="table_name" id="select2-basic">
                                            <option value="assets"> Assets</option>
                                            <option value="risks"> Risks</option>
                                            {{--  <option value="asset_groups">Asset Group</option>  --}}
                                        </select>
                                    </div>
                                    {{-- <input type="file"  name="file" value=""> --}}
                                    <button type="submit" class="btn btn-primary">Export</button>

                                    {{-- <a class="btn btn-success">Export data</a> --}}
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Filled Tabs ends -->
        </div>
    </section>


@endsection
@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
    <script src="{{ asset('js/scripts/components/components-navs.js') }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script>
        $('.table_name').on('change', function() {

            if($(this).val() == 'risks'){
                $(".download-ex").attr("href", "{{ asset('uploads/risks.csv') }}");
            }else if($(this).val() == 'asset_group'){
                $(".download-ex").attr("href", "{{ asset('uploads/asset_group.csv') }}");
            }
        });
    </script>
@endsection
