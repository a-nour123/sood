@extends('admin/layouts/contentLayoutMaster')

@section('title', __('configure.Risk Calculate'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('page-style')
    <style>
        .risk-table-definition {
            width: 10px;
            height: 10px;
            border: 1px solid #000;
        }

        .number-color {
            color: #FFF !important;
            font-size: 17px;
        }
    </style>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">

            <div class="row breadcrumbs-top  widget-grid">
                <div class="col-12">
                    <div class="page-title mt-2">
                        <div class="row">
                            <div class="col-sm-6 ps-0">
                                @if (@isset($breadcrumbs))
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                                style="display: flex;">
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
    <!-- Select2 Start  -->
    <section class="basic-select2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Risk Calculation</h4>
                    </div>
                    <div class="card-body">
                        <!-- Basic -->
                        <form action="{{ route('admin.configure.riskmodels.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-6 mb-1">
                                    <label class="form-label" for="select2-basic">Risk </label>
                                    <select class="select2 form-select" name="value" id="select2-basic"
                                        {{ auth()->user()->hasPermission('classic_risk_formula.update') ? '' : 'disabled' }}>
                                        @foreach ($riskmodels as $riskmodel)
                                            <option {{ $currentRiskModel == $riskmodel->id ? 'selected' : '' }}
                                                value="{{ $riskmodel->id }}">{{ $riskmodel->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                @if (auth()->user()->hasPermission('classic_risk_formula.update'))
                                    <div class="col-12 col-md-3 mt-md-2" style="padding-top: 3px">
                                        <button class="w-100 btn btn-warning waves-effect waves-float waves-light"
                                            type="submit">
                                            <span>Save</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </form>
                        <div style="float: left;display:flex;">
                            {{-- @if (auth()->user()->hasPermission('classic_risk_formula.create'))
                            <form action="{{ route('admin.configure.impact.create') }}" method="post">
                                @csrf
                                <button id="add-impact" style="border: 0;
                                                            background: transparent;padding:0" href="#"><img
                                        title="Add impact" width="25px"
                                        src="https://pksaudi.simplerisk.com/images/plus.png"></button>&nbsp;&nbsp;&nbsp;&nbsp;

                            </form>
                            @endif
                            @if (auth()->user()->hasPermission('classic_risk_formula.delete'))
                            <form action="{{ route('admin.configure.Impactorlikelhood.delete', 'impact') }}"
                                method="post">
                                @csrf
                                @method('delete')
                                <button id="delete-impact" style="border: 0;
                                                            background: transparent;padding:0" href="#"><img
                                        title="Delete impact" width="30px"
                                        src="https://pksaudi.simplerisk.com/images/minus.png"></button>
                            </form>
                            @endif                                 --}}
                        </div>

                        <div id="classic-risk-formula" class="text-center" style="margin-top: 35px;">
                            <div class="table-responsive">

                                <table class="mx-auto mb-1">
                                    <tbody>
                                        <tr height="20px">
                                            @foreach ($risklevels as $riskLevel)
                                                <td>{{ $riskLevel->name }}</td>
                                                <td>
                                                    <div class="risk-table-definition mx-1"
                                                        style="background-color: {{ $riskLevel->color }}">
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>

                                <div>
                                </div>
                                <table class="mx-auto text-center" border="0" cellspacing="0" cellpadding="10">
                                    <tbody>
                                        @foreach ($customrRiskScringsData as $customrRiskScringData)
                                            <tr>
                                                @if ($loop->first)
                                                    <td rowspan="{{ count($customrRiskScringsData) }}">
                                                        <div
                                                            style="text-orientation: upright; writing-mode: vertical-lr; width: 25px;">
                                                            <b>{{ __('configure.Impact') }}</b>
                                                        </div>
                                                    </td>
                                                @endif

                                                @foreach ($customrRiskScringData as $calculated_risk)
                                                    @if ($loop->first)
                                                        <td bgcolor="silver" height="50px" width="200px">

                                                            <span
                                                                class="editable ">{{ $calculated_risk['name'] }}</span>
                                                            @if (auth()->user()->hasPermission('classic_risk_formula.update'))
                                                                <input type="text"
                                                                    class="editable d-none editable-input "
                                                                    value="{{ $calculated_risk['name'] }}"
                                                                    style=" width: 100%;" data-type="impact"
                                                                    data-id="{{ $calculated_risk['id'] }}">
                                                                <a class="edit-record"><i data-feather='edit-2'></i></a>
                                                            @endif
                                                        </td>
                                                        <td bgcolor="silver" align="center" height="50px"
                                                            width="50px">
                                                            {{ $calculated_risk['id'] }}</td>
                                                    @else
                                                        <td align="center" height="50px" width="150px"
                                                            bgcolor="{{ getRiskColor($risklevels, $calculated_risk) }}">

                                                            <span
                                                                class="editable number-color">{{ $calculated_risk }}</span>
                                                            {{--  <input type="text" class="editable d-none editable-input"
                                                                value="{{ $calculated_risk }}" style="width: 42.4px;"
                                                                data-type="score" data-impact="4" data-likelihood="1">

                                                            <a class="edit-record">edit</a>  --}}
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td>&nbsp;</td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            @foreach ($likelihoods as $likelihood)
                                                <td align="center" bgcolor="silver">{{ $likelihood->id }}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            @foreach ($likelihoods as $likelihood)
                                                <td align="center" bgcolor="silver" height="50px" width="100px">
                                                    <span>
                                                        <span
                                                            class="editable likeloodspan">{{ $likelihood->name }}</span>
                                                        @if (auth()->user()->hasPermission('classic_risk_formula.update'))
                                                            <input type="text"
                                                                class="editable d-none editable-input2"
                                                                value="{{ $likelihood['name'] }}" style=" width: 100%;"
                                                                data-type="likelihood"
                                                                data-id="{{ $likelihood['id'] }}">
                                                            <a class="edit-record2"> <i
                                                                    data-feather='edit-2'></i></i></a>
                                                        @endif
                                                    </span>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td colspan="5" align="center"><b>{{ __('configure.Likelihood') }}</b>
                                            </td>
                                            <td align="center"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="float:right; display:flex;">
                                {{-- @if (auth()->user()->hasPermission('classic_risk_formula.create'))
                                <form action="{{ route('admin.configure.likelihood.create') }}" method="post">
                                    @csrf
                                    <button id="add-likelihood" style="border: 0;
                                                                background: transparent;padding:0" href="#"><img
                                            title="Add likelihood" width="25px"
                                            src="https://pksaudi.simplerisk.com/images/plus.png"></button>&nbsp;&nbsp;&nbsp;&nbsp;
                                </form>
                                @endif
                                @if (auth()->user()->hasPermission('classic_risk_formula.delete'))
                                <form action="{{ route('admin.configure.Impactorlikelhood.delete', 'likelihood') }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <button id="delete-likelihood" style="border: 0; background: transparent;padding:0;"
                                        href="#"><img title="Delete likelihood" width="30px"
                                            src="https://pksaudi.simplerisk.com/images/minus.png"></button>
                                </form>
                                @endif                                 --}}
                            </div>

                            {{-- <div style="float:right; display:flex;">
                                <form action="{{ route('admin.configure.likelihood.create') }}" method="post">
                                    @csrf
                                    <button id="add-likelihood" href="#"><img title="Add likelihood" width="25px"
                                            src="https://pksaudi.simplerisk.com/images/plus.png"></button>&nbsp;&nbsp;&nbsp;&nbsp;
                                </form>
                                <form action="{{ route('admin.configure.Impactorlikelhood.delete', 'likelihood') }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <button id="delete-likelihood" href="#"><img title="Delete likelihood" width="25px"
                                            src="https://pksaudi.simplerisk.com/images/minus.png"></button>
                                </form>
                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Select2 End -->
@endsection
@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

    <script>
        $('.edit-record').on('click', function() {
            $(this).parents('td').find('span').addClass('d-none');
            $(this).parents('td').find('input').removeClass('d-none');
        });

        $('.edit-record2').on('click', function() {
            $(this).parents('td').find('.likeloodspan').addClass('d-none');
            $(this).parents('td').find('input').removeClass('d-none');
        });
        $('.editable-input').on('change', function() {
            var name = $(this).val();
            var _that = $(this);
            var id = $(this).data('id');
            var url = "{{ route('admin.configure.updateimpact', ':id') }}";
            url = url.replace(':id', id);
            $(this).on('focusout', function() {

                $.ajax({

                    url: url,
                    type: 'post',
                    data: {
                        name: name,
                        "_token": "{{ csrf_token() }}",

                    },
                    success: function(response) {
                        _that.parents('td').find('span').text(response);
                        _that.parents('td').find('span').removeClass('d-none');
                        _that.parents('td').find('input').addClass('d-none');

                    },
                    error: function(response) {}
                });

            });
        });


        $('.editable-input2').on('change', function() {
            var name = $(this).val();
            var _that = $(this);
            var id = $(this).data('id');
            var url = "{{ route('admin.configure.updatelikelhood', ':id') }}";
            url = url.replace(':id', id);
            $(this).on('focusout', function() {

                $.ajax({

                    url: url,
                    type: 'post',
                    data: {
                        name: name,
                        "_token": "{{ csrf_token() }}",

                    },
                    success: function(response) {
                        _that.parents('td').find('.likeloodspan').text(response);
                        _that.parents('td').find('.likeloodspan').removeClass('d-none');
                        _that.parents('td').find('input').addClass('d-none');

                    },
                    error: function(response) {}
                });

            });
        });
    </script>
@endsection
