<!DOCTYPE html>
<html lang="ar" dir="RTL">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>{{ __('locale.Risk') }}</title>
    <link rel="stylesheet" href="{{ asset('cdn/bootcss.css') }}">
    <link rel="stylesheet" href="build/css/intlTelInput.css" />
    <link rel="stylesheet" href="build/css/demo.css" />
    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
    <style>
        * {
            font-family: cairo;
            font-size: 11px;
        }

        td {
            max-width: 150px;
            margin: 0 auto;
            word-wrap: break-word;
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        td.head1 {
            border: 1px solid #dddddd;
            border-bottom: none !important;
            /* Remove top border for td.head2 */
        }

        .head {
            background: rgb(241, 236, 236);
            height: 80px;
        }

        .notes {
            max-width: 80px;
        }

        table {
            width: 100%;
            /* height: 100vh; */
            border-collapse: collapse;
            margin-bottom: 5rem;
            page-break-inside: auto;

        }

        @media print {
            td {
                page-break-inside: avoid;
                text-align: right !important;
                vertical-align: middle !important
            }
        }
    </style>

</head>




<body>
    {{-- <button data-filename = "{{ __('locale.Risk') }}" data-id_selector="exportPdf_container" type="button" class="btn btn-outline-primary export-pdf-btn mt-2">
        <i data-feather="file-text" class="me-25"></i>
        <span>{{ __('locale.Export') }} PDF</span>
    </button> --}}
    <div class="container-fluid" id="exportPdf_container">
        <div class="container-fluid">
            <div id="firstPage" style="posation:relative; height:100vh">
                <img src='{{ asset('storage/'. getSystemSetting('risk_photo')) }}'
                    style="align-items: center; justify-content: center;width: 100%; height:90vh ; opacity:0.7">

                <div style="position: absolute ;top:30% ;left:50%; transform:translate(-50%,50%)">
                    <h1 id="FirstContent" style="text-align:center;">
                        {{ __('locale.RiskRegistersReport') }}
                    </h1>
                </div>
            </div>
            <div align="center">
                @if (isset($risks) && count($risks) > 0)
                    @foreach ($risks as $risk)
                        <?php
                        $calculatedRisk = $risk->riskScoring()->select('calculated_risk')->first()->calculated_risk;
                        ?>
                        <table dir="RTL" border="1" cellspacing="0" cellpadding="0" width="1185">
                            <tbody>
                                <tr>
                                    <td class="head" width="233">
                                        <p align="center" dir="RTL">
                                            <strong>(<strong>{{ __('locale.KRIs') }}</strong>)</strong>
                                        </p>
                                    </td>
                                    <td class="head" width="143">
                                        <p align="center" dir="RTL">
                                            <strong>{{ __('locale.MitigationEffort') }}</strong>
                                        </p>
                                    </td>
                                    <td class="head" width="84">
                                        <p align="center" dir="RTL">
                                            <strong>{{ __('locale.InherentRiskCurrent') }}</strong>
                                        </p>
                                    </td>
                                    <td class="head" width="145">
                                        <p align="center" dir="RTL">
                                            <strong>{{ __('locale.Impact') }}</strong>
                                        </p>
                                    </td>
                                    <td class="head" width="145">
                                        <p align="center" dir="RTL">
                                            <strong>{{ __('locale.Cateogry') }}</strong>
                                        </p>
                                    </td>
                                    <td class="head" width="145">
                                        <p align="center" dir="RTL">
                                            <strong>{{ __('locale.Description') }}</strong>
                                        </p>
                                    </td>
                                    <td class="head" width="145">
                                        <p align="center" dir="RTL">
                                            <strong>{{ __('locale.Subject') }}</strong>
                                        </p>
                                    </td>
                                    <td class="head" width="145">
                                        <p align="center" dir="RTL">
                                            <strong>{{ __('locale.RiskNumber') }}</strong>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="233">
                                        <p align="center" dir="RTL">
                                            {!! $risk['notes'] ?? null !!}
                                        </p>
                                    </td>
                                    <td width="143">
                                        <p align="center" dir="RTL">
                                            {{ $risk->mitigation->mitigationEfforts->name ?? null }}
                                        </p>
                                    </td>
                                    <td width="84" style="background-color:{{ riskScoringColor($calculatedRisk) }};">
                                        <p align="center" dir="RTL">
                                            {{ $calculatedRisk ?? null }}
                                            {{ $risk['residual_risk_data']['name'] ?? null }}
                                        </p>
                                    </td>
                                    <td width="145">
                                        <p dir="RTL">
                                            {{ $risk->source->name ?? null }}
                                        </p>
                                    </td>
                                    <td width="145">
                                        <p align="center" dir="RTL">
                                            {{ $risk->category->name ?? null }}
                                        </p>
                                    </td>
                                    <td width="145">
                                        <p align="center" dir="RTL">
                                            {{ $risk->risk_description ?? null }}
                                        </p>
                                    </td>
                                    <td width="145">
                                        <p align="center" dir="RTL">
                                            {{ $risk->subject ?? null }}
                                        </p>
                                    </td>
                                    <td width="145" rowspan="3">
                                        <p align="center" dir="RTL">
                                            R {{ $risk->id ?? null }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="head" width="145">
                                        <p align="center" dir="RTL">
                                            <strong>{{ __('locale.PlanningStrategy') }}</strong>
                                        </p>
                                    </td>
                                    <td class="head" width="520" colspan="4">
                                        <p align="center" dir="RTL">
                                            <strong>{{ __('locale.CurrentSolution') }}</strong>
                                        </p>
                                    </td>
                                    <td class="head" width="143">
                                        <p align="center" dir="RTL">
                                            <strong>{{ __('locale.Responsible') }}</strong>
                                        </p>
                                    </td>
                                    <td class="head" width="233">
                                        <p align="center" dir="RTL">
                                            <strong>{{ __('locale.SubmissionDate') }}</strong>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="145">
                                        <p align="center" dir="RTL">
                                            {{ $risk->mitigation->planningStrategies->name ?? null }}
                                        </p>
                                    </td>
                                    <td width="520" colspan="4">
                                        <p align="center" dir="RTL">
                                            {!! $risk->mitigation['current_solution'] ?? null !!}
                                        </p>
                                    </td>
                                    <td width="143">
                                        <p align="center" dir="RTL">
                                            {{ $risk->assessment ?? null }}
                                        </p>
                                    </td>
                                    <td width="145">
                                        <p align="center" dir="RTL">
                                            {{ $risk->mitigation->planning_date ?? null }}
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                @else
                    <p>No risks available for export.</p>
                @endif
            </div>
            
        </div>
</body>

</html>
