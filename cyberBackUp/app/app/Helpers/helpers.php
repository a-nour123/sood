<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Models\Family;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlMapping;
use App\Models\FrameworkControlTestAudit;
use App\Models\PhishingCategory;
use App\Models\PhishingWebsitePage;
use App\Models\PhishingDomains;
use App\Models\PhishingSenderProfile;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Helper
{
    public static function applClasses()
    {
        // Demo
        $fullURL = request()->fullurl();
        // if (App()->environment() === 'production') {
        //     for ($i = 1; $i < 7; $i++) {
        //         $contains = Str::contains($fullURL, 'demo-' . $i);
        //         if ($contains === true) {
        //             $data = config('custom.' . 'demo-' . $i);
        //         }
        //     }
        // } else {
        $data = config('custom.custom');
        // }
        // default data array
        $DefaultData = [
            'mainLayoutType' => 'vertical',
            'theme' => 'light',
            'sidebarCollapsed' => false,
            'navbarColor' => '',
            'horizontalMenuType' => 'floating',
            'verticalMenuNavbarType' => 'floating',
            'footerType' => 'static', //footer
            'layoutWidth' => 'boxed',
            'showMenu' => true,
            'bodyClass' => '',
            'pageClass' => '',
            'pageHeader' => true,
            'contentLayout' => 'default',
            'blankPage' => false,
            'defaultLanguage' => 'en',
            'direction' => env('MIX_CONTENT_DIRECTION', 'ltr'),
        ];

        // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
        $data = array_merge($DefaultData, $data);

        // All options available in the template
        $allOptions = [
            'mainLayoutType' => array('vertical', 'horizontal'),
            'theme' => array('light' => 'light', 'dark' => 'dark-layout', 'bordered' => 'bordered-layout', 'semi-dark' => 'semi-dark-layout'),
            'sidebarCollapsed' => array(true, false),
            'showMenu' => array(true, false),
            'layoutWidth' => array('full', 'boxed'),
            'navbarColor' => array('bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-dark'),
            'horizontalMenuType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky'),
            'horizontalMenuClass' => array('static' => '', 'sticky' => 'fixed-top', 'floating' => 'floating-nav'),
            'verticalMenuNavbarType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky', 'hidden' => 'navbar-hidden'),
            'navbarClass' => array('floating' => 'floating-nav', 'static' => 'navbar-static-top', 'sticky' => 'fixed-top', 'hidden' => 'd-none'),
            'footerType' => array('static' => 'footer-static', 'sticky' => 'footer-fixed', 'hidden' => 'footer-hidden'),
            'pageHeader' => array(true, false),
            'contentLayout' => array('default', 'content-left-sidebar', 'content-right-sidebar', 'content-detached-left-sidebar', 'content-detached-right-sidebar'),
            'blankPage' => array(false, true),
            'sidebarPositionClass' => array('content-left-sidebar' => 'sidebar-left', 'content-right-sidebar' => 'sidebar-right', 'content-detached-left-sidebar' => 'sidebar-detached sidebar-left', 'content-detached-right-sidebar' => 'sidebar-detached sidebar-right', 'default' => 'default-sidebar-position'),
            'contentsidebarClass' => array('content-left-sidebar' => 'content-right', 'content-right-sidebar' => 'content-left', 'content-detached-left-sidebar' => 'content-detached content-right', 'content-detached-right-sidebar' => 'content-detached content-left', 'default' => 'default-sidebar'),
            'defaultLanguage' => array('en' => 'en', 'fr' => 'fr', 'de' => 'de', 'pt' => 'pt'),
            'direction' => array('ltr', 'rtl'),
        ];

        //if mainLayoutType value empty or not match with default options in custom.php config file then set a default value
        foreach ($allOptions as $key => $value) {
            if (array_key_exists($key, $DefaultData)) {
                if (gettype($DefaultData[$key]) === gettype($data[$key])) {
                    // data key should be string
                    if (is_string($data[$key])) {
                        // data key should not be empty
                        if (isset($data[$key]) && $data[$key] !== null) {
                            // data key should not be exist inside allOptions array's sub array
                            if (!array_key_exists($data[$key], $value)) {
                                // ensure that passed value should be match with any of allOptions array value
                                $result = array_search($data[$key], $value, 'strict');
                                if (empty($result) && $result !== 0) {
                                    $data[$key] = $DefaultData[$key];
                                }
                            }
                        } else {
                            // if data key not set or
                            $data[$key] = $DefaultData[$key];
                        }
                    }
                } else {
                    $data[$key] = $DefaultData[$key];
                }
            }
        }

        //layout classes
        $layoutClasses = [
            'theme' => $data['theme'],
            'layoutTheme' => $allOptions['theme'][$data['theme']],
            'sidebarCollapsed' => $data['sidebarCollapsed'],
            'showMenu' => $data['showMenu'],
            'layoutWidth' => $data['layoutWidth'],
            'verticalMenuNavbarType' => $allOptions['verticalMenuNavbarType'][$data['verticalMenuNavbarType']],
            'navbarClass' => $allOptions['navbarClass'][$data['verticalMenuNavbarType']],
            'navbarColor' => $data['navbarColor'],
            'horizontalMenuType' => $allOptions['horizontalMenuType'][$data['horizontalMenuType']],
            'horizontalMenuClass' => $allOptions['horizontalMenuClass'][$data['horizontalMenuType']],
            'footerType' => $allOptions['footerType'][$data['footerType']],
            'sidebarClass' => '',
            'bodyClass' => $data['bodyClass'],
            'pageClass' => $data['pageClass'],
            'pageHeader' => $data['pageHeader'],
            'blankPage' => $data['blankPage'],
            'blankPageClass' => '',
            'contentLayout' => $data['contentLayout'],
            'sidebarPositionClass' => $allOptions['sidebarPositionClass'][$data['contentLayout']],
            'contentsidebarClass' => $allOptions['contentsidebarClass'][$data['contentLayout']],
            'mainLayoutType' => $data['mainLayoutType'],
            'defaultLanguage' => $allOptions['defaultLanguage'][$data['defaultLanguage']],
            'direction' => $data['direction'],
        ];
        // set default language if session hasn't locale value the set default language
        if (!session()->has('locale')) {
            app()->setLocale($layoutClasses['defaultLanguage']);
        }

        // sidebar Collapsed
        if ($layoutClasses['sidebarCollapsed'] == 'true') {
            $layoutClasses['sidebarClass'] = "menu-collapsed";
        }

        // blank page class
        if ($layoutClasses['blankPage'] == 'true') {
            $layoutClasses['blankPageClass'] = "blank-page";
        }

        return $layoutClasses;
    }

    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        $fullURL = request()->fullurl();
        if (App()->environment() === 'production') {
            for ($i = 1; $i < 7; $i++) {
                $contains = Str::contains($fullURL, 'demo-' . $i);
                if ($contains === true) {
                    $demo = 'demo-' . $i;
                }
            }
        }
        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set('custom.' . $demo . '.' . $config, $val);
                }
            }
        }
    }

    public static function getIcons()
    {
        return [
            ['key' => 'fas fa-ban', 'value' => '&#xf05e; fa-ban'],
            ['key' => 'fas fa-bug', 'value' => '&#xf188; fa-bug'],
            ['key' => 'fas fa-dungeon', 'value' => '&#xf6d9; fa-dungeon'],
            ['key' => 'far fa-eye', 'value' => '&#xf06e; fa-eye'],
            ['key' => 'far fa-eye-slash', 'value' => '&#xf070; fa-eye-slash'],
            ['key' => 'fas fa-file-signature', 'value' => '&#xf573; fa-file-signature'],
            ['key' => 'fas fa-id-fingerprint', 'value' => '&#xf577; fa-id-fingerprint'],
            ['key' => 'far fa-id-badge', 'value' => '&#xf2c1; fa-id-badge'],
            ['key' => 'fas fa-id-badge', 'value' => '&#xf2c1; fa-id-badge'],
            ['key' => 'far fa-id-card', 'value' => '&#xf2c2; fa-id-card'],
            ['key' => 'fas fa-key', 'value' => '&#xf084; fa-key'],
            ['key' => 'fas  fa-lock', 'value' => '&#xf023; fa-lock'],
            ['key' => 'fas fa-unlock', 'value' => '&#xf09c; fa-unlock'],
            ['key' => 'fas fa-user-secret', 'value' => '&#xf21b; fa-user-secret '],
            ['key' => 'fa-undo', 'value' => '&#xf0e2; fa-undo'],
            ['key' => 'fa-universal-access', 'value' => '&#xf29a; fa-universal-access'],
            ['key' => 'fa-university', 'value' => '&#xf19c; fa-university'],
            ['key' => 'fa-unlink', 'value' => '&#xf127; fa-unlink'],
            ['key' => 'fa-unlock', 'value' => '&#xf09c; fa-unlock '],
            ['key' => 'fa-unlock-alt', 'value' => '&#xf13e; fa-unlock-alt'],
            ['key' => 'fa-unsorted', 'value' => '&#xf0dc; fa-unsorted'],
            ['key' => 'fa-upload', 'value' => '&#xf093; fa-upload '],
            ['key' => 'fa-usb', 'value' => '&#xf287; fa-usb '],
            ['key' => 'fa-usd', 'value' => '&#xf155; fa-usd'],
            ['key' => 'fa-user', 'value' => '&#xf007; fa-user'],
            ['key' => 'fa-user-circle', 'value' => '&#xf2bd; fa-user-circle'],
            ['key' => 'fa-user-circle-o', 'value' => '&#xf2be; fa-user-circle-o'],
            ['key' => 'fa-user-md', 'value' => '&#xf0f0; fa-user-md'],
            ['key' => 'fa-user-o', 'value' => '&#xf2c0; fa-user-o'],
            ['key' => 'fa-user-plus', 'value' => '&#xf234; fa-user-plus'],
            ['key' => 'fa-user-secret', 'value' => '&#xf21b; fa-user-secret'],
            ['key' => 'fa-user-times', 'value' => '&#xf235; fa-user-times'],
            ['key' => 'fa-users', 'value' => '&#xf0c0; fa-users'],
            ['key' => 'fa-vcard', 'value' => '&#xf2bb; fa-vcard'],
            ['key' => 'fa-vcard-o', 'value' => '&#xf2bc; fa-vcard-o'],
            ['key' => 'fa-venus', 'value' => '&#xf221; fa-venus'],
            ['key' => 'fa-venus-double', 'value' => '&#xf226; fa-venus-double '],
            ['key' => 'fa-venus-mars', 'value' => '&#xf228; fa-venus-mars'],
            ['key' => 'fa-viacoin', 'value' => '&#xf237; fa-viacoin'],
            ['key' => 'fa-viadeo', 'value' => '&#xf2a9; fa-viadeo'],
            ['key' => 'fa-viadeo-square', 'value' => '&#xf2aa; fa-viadeo-square'],
            ['key' => 'fa-video-camera', 'value' => '&#xf03d; fa-video-camera'],
            ['key' => 'fa-vimeo', 'value' => '&#xf27d; fa-vimeo'],
            ['key' => 'fa-vimeo-square', 'value' => '&#xf194; fa-vimeo-square'],
            ['key' => 'fa-vine', 'value' => '&#xf1ca; fa-vine'],
            ['key' => 'fa-vk', 'value' => '&#xf189; fa-vk'],
            ['key' => 'fa-volume-control-phone', 'value' => '&#xf2a0; fa-volume-control-phone'],
            ['key' => 'fa-volume-down', 'value' => '&#xf027; fa-volume-down'],
            ['key' => 'fa-volume-off', 'value' => '&#xf026; fa-volume-off'],
            ['key' => 'fa-volume-up', 'value' => '&#xf028; fa-volume-up '],
            ['key' => 'fa-warning', 'value' => '&#xf071; fa-warning'],
            ['key' => 'fa-wechat', 'value' => '&#xf1d7; fa-wechat '],
            ['key' => 'fa-weibo', 'value' => '&#xf18a; fa-weibo'],
            ['key' => 'fa-weixin', 'value' => '&#xf1d7; fa-weixin'],
            ['key' => 'fa-whatsapp', 'value' => '&#xf232; fa-whatsapp'],
            ['key' => 'fa-wheelchair', 'value' => '&#xf193; fa-wheelchair'],
            ['key' => 'fa-wheelchair-alt', 'value' => '&#xf29b; fa-wheelchair-alt'],
            ['key' => 'fa-wifi', 'value' => '&#xf1eb; fa-wifi'],
        ];
    }

    public static function  ImplementedStatistic($id)
    {
        $frameworkId = $id;
        $childStatus = 'Implemented';

        $controlIds = FrameworkControl::select('framework_controls.*')
            ->leftJoin('framework_control_mappings', 'framework_controls.id', '=', 'framework_control_mappings.framework_control_id')
            ->whereNull('framework_controls.parent_id')
            ->where('framework_control_mappings.framework_id', $frameworkId)
            ->pluck('id')
            ->toArray();
        $numcontrolIds = count($controlIds);
        $existingIds = FrameworkControlTestAudit::whereIn('framework_control_id', $controlIds)
            ->distinct()
            ->pluck('framework_control_id')
            ->toArray();

        $nonExistingIds = array_diff($controlIds, $existingIds);
        $childIds = FrameworkControl::whereIn('parent_id', $nonExistingIds)
            ->selectRaw('MIN(id) as first_child_id')
            ->groupBy('parent_id')
            ->pluck('first_child_id')
            ->toArray();

        $auditsTestNumbers = FrameworkControlTestAudit::whereIn('framework_control_id', $existingIds)
            ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]')) AS first_test_number")
            ->distinct()
            ->pluck('first_test_number')
            ->toArray();

        $auditsTestNumbersChild = FrameworkControlTestAudit::whereIn('framework_control_id', $childIds)
            ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]')) AS first_test_number")
            ->distinct()
            ->pluck('first_test_number')
            ->toArray();

        $countsByTestNumber = [];

        $encounteredTestNumbers = []; // Array to keep track of encountered test numbers
        $countsByTestNumber = []; // Initialize the array for storing counts

        // Initialize the array for storing counts

        foreach (array_merge($auditsTestNumbers, $auditsTestNumbersChild) as $testNumber) {
            // Check if the test number has not been encountered before
            if (!in_array($testNumber, $encounteredTestNumbers)) {
                $encounteredTestNumbers[] = $testNumber; // Add the test number to encountered array

                $auditCountAll = 0; // Initialize audit count for the current test number
                // Check if the test number is from $auditsTestNumbers
                if (in_array($testNumber, $auditsTestNumbers)) {
                    $auditCountAll += FrameworkControlTestAudit::whereIn('framework_control_id', $existingIds)
                        ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]'))"), $testNumber)
                        ->where(function ($query) use ($childStatus) {
                            $query->where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[1]')), ''), 'Not Implemented')"), $childStatus);
                            // ->orWhere(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[2]')), ''), 'Not Implemented')"), $childStatus);
                        })
                        ->orwhereIn('framework_control_id', $childIds)
                        ->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[0]'))"), $testNumber)
                        ->where(function ($query) use ($childStatus) {
                            $query->
                                // where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[1]')), ''), 'Not Implemented')"), $childStatus)
                                Where(DB::raw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[2]')), ''), 'Not Implemented')"), $childStatus);
                        })
                        ->count();
                }
                // Add the result to the $countsByTestNumber array
                $countsByTestNumber = [
                    'percentage' => number_format($auditCountAll * 100 / $numcontrolIds, 2),
                ];
            }
        }



        return  $countsByTestNumber ?   $countsByTestNumber['percentage'] : 0;
    }

    public static function ImplementedStatisticProfilesOfDomain($id)
    {
        $domain = PhishingDomains::withCount('profiles')->findOrFail($id);
        $domain_count = $domain->profiles_count;
        $count_of_profiles = PhishingSenderProfile::withoutTrashed()->where('website_domain_id', '!=', null)->count();
        if ($count_of_profiles > 0) {
            return number_format($domain_count * 100 / $count_of_profiles);
        }
        return $domain_count;
    }

    public static function  ImplementedStatisticTestPercentage($id, $result)
    {

        $framework = Framework::find($id);
        $testControlNumbers = $result;

        if ($testControlNumbers !== null) {
            // Decode the JSON string and get the first element
            $testNumberArray = json_decode($testControlNumbers->test_number, true);

            // Assuming the structure is [2, ""], retrieve the first element
            $testControlNumber = ($testNumberArray && count($testNumberArray) > 0) ? $testNumberArray[0] : null;
        } else {
            // Handle the case when no record is found
            $testControlNumber = null;
        }


        if ($testControlNumber && $framework) {
            // $data['total'] = $framework->FrameworkControls()->groupBy('control_status')->select('control_status', DB::raw('count(*) as total'))->pluck('total', 'control_status')->toArray();
            $data['total'] = $framework->only_parent_controls()->groupBy('control_status')->select('control_status', DB::raw('count(*) as total'))->pluck('total', 'control_status')->toArray();
            $controlStatuses = ['Not Applicable', 'Not Implemented', 'Partially Implemented', 'Implemented'];

            foreach ($controlStatuses as $controlStatus) {
                if (!array_key_exists($controlStatus, $data['total'])) {
                    $data['total'][$controlStatus] = 0;
                }
            }
            unset($controlStatuses);

            // $data['all'] = $framework->FrameworkControls()->count();
            // $data['all'] = $framework->only_parent_controls()->count();
            $frameWorkDomainIds = $framework->only_families()->pluck('families.id')->toArray();
            $frameWorkSubDomainIds = $framework->only_sub_families()->pluck('families.id')->toArray();
            $frameworkControlIds = $framework->FrameworkControls()->pluck('framework_controls.id')->toArray();

            // Fetch all data for FrameworkControl instances with associated test audits
            $ma = FrameworkControl::with(['frameworkControlTestAudits' => function ($query) use ($testControlNumber) {
                $query->whereRaw('JSON_EXTRACT(test_number, "$[0]") = ?', [$testControlNumber]);
            }])->whereIn('id', $frameworkControlIds)->get()->toArray();

            // Fetch only the IDs
            Family::$frameworkControlIds = FrameworkControl::with(['frameworkControlTestAudits' => function ($query) use ($testControlNumber) {
                $query->whereRaw('JSON_EXTRACT(test_number, "$[0]") = ?', [$testControlNumber]);
            }])->whereIn('id', $frameworkControlIds)->pluck('id')->toArray();

            // Iterate through each FrameworkControl in Family::$frameworkControlIds
            foreach (Family::$frameworkControlIds as &$frameworkControl) {
                // Check if there are related frameworkControlTestAudits
                if (isset($frameworkControl['framework_control_test_audits']) && count($frameworkControl['framework_control_test_audits']) > 0) {
                    // Get the test_number value from the first related frameworkControlTestAudit
                    $testNumber = $frameworkControl['framework_control_test_audits'][0]['test_number'];
                    // Decode the JSON array and get the value at index 2
                    $testStatus = json_decode($testNumber)[1];
                    // Store the original control_status value before updating
                    $frameworkControl['original_control_status'] = $frameworkControl['control_status'];
                    // Update the control_status value based on the test_number value
                    $frameworkControl['control_status'] = $testStatus;
                }
            }


            $domains = Family::whereIn('id', $frameWorkDomainIds)
                ->orderBy('order')
                ->with([
                    "custom_families_report_time" => function ($q) use ($frameWorkSubDomainIds) {
                        $q->whereIn('id', $frameWorkSubDomainIds);
                    },
                    "custom_families_report_time.custom_frameworkControls.frameworkControlTestAudits" => function ($q) use ($testControlNumber) {
                        $q->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(test_number, "$[0]")) = ?', [$testControlNumber]);
                    }
                ])
                ->get();





            $domains = Family::whereIn('id', $frameWorkDomainIds)->orderBy('order')
                ->with(["families" => function ($q) use ($frameWorkSubDomainIds) {
                    $q->whereIn('id', $frameWorkSubDomainIds);
                }])->get();
            foreach ($domains as &$domain) {

                foreach ($domain->families as &$family) {
                    if (isset($family->frameworkControls)) {
                        foreach ($family->frameworkControls as &$control) {
                            Helper::handleControlUpdate($control, $ma);
                            if (isset($control->frameworkControls)) {
                                foreach ($control->frameworkControls as &$childControl) {
                                    Helper::handleControlUpdate($childControl, $ma);
                                }
                            }
                        }
                    }
                }
            }


            $domainsArray = [];

            foreach ($domains as $mainKey => $domain) {
                $domainsArray[$mainKey] = [];
                $domainsArray[$mainKey]['id'] = $domain['id'];
                $domainsArray[$mainKey]['name'] = $domain['name'];
                $domainsArray[$mainKey]["Partially Implemented"] = 0;
                $domainsArray[$mainKey]["Implemented"] = 0;
                $domainsArray[$mainKey]["Not Applicable"] = 0;
                $domainsArray[$mainKey]["Not Implemented"] = 0; // Fix this line
                $domainsArray[$mainKey]["total"] = 0;

                foreach ($domain->families as $family) {
                    // Check if the family ID is in $frameWorkSubDomainIds
                    if (in_array($family->id, $frameWorkSubDomainIds)) {
                        $formattedFamily = [
                            'id' => $family->id,
                            'name' => $family->name,
                            'order' => $family->order,
                            'parent_id' => $family->parent_id,
                            'custom_framework_controls' => [],
                        ];

                        foreach ($family->frameworkControls as $control) {
                            $formattedControl = [
                                'control_status' => $control->control_status,
                                'family' => $control->family,
                            ];

                            // Update the counters based on control status
                            switch ($control->control_status) {
                                case 'Partially Implemented':
                                    $domainsArray[$mainKey]["Partially Implemented"]++;
                                    break;
                                case 'Implemented':
                                    $domainsArray[$mainKey]["Implemented"]++;
                                    break;
                                case 'Not Applicable':
                                    $domainsArray[$mainKey]["Not Applicable"]++;
                                    break;
                                case 'Not Implemented':
                                    $domainsArray[$mainKey]["Not Implemented"]++; // Fix this line
                                    break;
                                case '':
                                    $domainsArray[$mainKey]["Not Implemented"]++; // Optional: Handle empty status separately if needed
                                    break;
                            }

                            $formattedFamily['custom_framework_controls'][] = $formattedControl;
                        }

                        $domainsArray[$mainKey]['total'] += count($family->frameworkControls);
                    }
                }
            }



            $totals = [
                'Partially Implemented' => 0,
                'Implemented' => 0,
                'Not Applicable' => 0,
                'Not Implemented' => 0,
            ];

            $totalAll = 0;
            foreach ($domainsArray as $domain) {
                $totals['Partially Implemented'] += $domain['Partially Implemented'];
                $totals['Implemented'] += $domain['Implemented'];
                $totals['Not Applicable'] += $domain['Not Applicable'];
                $totals['Not Implemented'] += $domain['Not Implemented'];
                $totalAll += $domain['total'];
            }

            $data = [
                'total' => $totals,
                'all' => $totalAll,
            ];

            unset($domains);

            $implementedPercentage = $data['all'] > 0 ? number_format(($data['total']['Implemented'] / $data['all']) * 100, 2) : '0.00';

            $response = $implementedPercentage;
        } else {
            // $data['total'] = $framework->FrameworkControls()->groupBy('control_status')->select('control_status', DB::raw('count(*) as total'))->pluck('total', 'control_status')->toArray();
            $data['total'] = $framework->only_parent_controls()->groupBy('control_status')->select('control_status', DB::raw('count(*) as total'))->pluck('total', 'control_status')->toArray();
            $controlStatuses = ['Not Applicable', 'Not Implemented', 'Partially Implemented', 'Implemented'];

            foreach ($controlStatuses as $controlStatus) {
                if (!array_key_exists($controlStatus, $data['total'])) {
                    $data['total'][$controlStatus] = 0;
                }
            }
            unset($controlStatuses);

            // $data['all'] = $framework->FrameworkControls()->count();
            $data['all'] = $framework->only_parent_controls()->count();
            $frameWorkDomainIds = $framework->only_families()->pluck('families.id')->toArray();
            $frameWorkSubDomainIds = $framework->only_sub_families()->pluck('families.id')->toArray();
            $domains = Family::whereIn('id', $frameWorkDomainIds)->orderBy('order')
                ->with(["custom_families" => function ($q) use ($frameWorkSubDomainIds) {
                    $q->whereIn('id', $frameWorkSubDomainIds);
                }])->get();


            Family::$frameworkControlIds = $framework->FrameworkControls()->pluck('framework_controls.id')->toArray();
            $domains = Family::whereIn('id', $frameWorkDomainIds)->orderBy('order')
                ->with(["families" => function ($q) use ($frameWorkSubDomainIds) {
                    $q->whereIn('id', $frameWorkSubDomainIds);
                }])->get();

            $domainsArray = [];
            foreach ($domains as $mainKey => $domain) {

                $domainsArray[$mainKey] = [];
                $domainsArray[$mainKey]['id'] = $domain['id'];
                $domainsArray[$mainKey]['name'] = $domain['name'];
                $domainsArray[$mainKey]["Partially Implemented"] = 0;
                $domainsArray[$mainKey]["Implemented"] = 0;
                $domainsArray[$mainKey]["Not Applicable"] = 0;
                $domainsArray[$mainKey]["Not Implemented"] = 0;
                $domainsArray[$mainKey]["total"] = 0;

                foreach ($domain->custom_families as $key => $subDomain) {

                    foreach ($subDomain->custom_frameworkControls as $key => $frameworkControl) {

                        $domainsArray[$mainKey][$frameworkControl['control_status']]++;
                        $domainsArray[$mainKey]['total']++;
                    }
                }
            }
            unset($domains);
            $implementedPercentage = $data['all'] > 0 ? number_format(($data['total']['Implemented'] / $data['all']) * 100, 2) : '0.00';
            $response = $implementedPercentage;
        }


        return $response ? $response . ' %' : 0;
    }

    protected function handleControlUpdate(&$control, $ma)
    {
        $controlId = $control->id;
        $matchingFrameworkControl = array_filter($ma, function ($item) use ($controlId) {
            return is_array($item) && $item['id'] == $controlId;
        });
        $matchingFrameworkControl = reset($matchingFrameworkControl);

        if ($matchingFrameworkControl) {
            $originalControlStatus = $control->control_status;

            if (isset($matchingFrameworkControl['framework_control_test_audits'][0]['test_number'])) {
                $testNumberString = $matchingFrameworkControl['framework_control_test_audits'][0]['test_number'];

                $testNumberArray = json_decode($testNumberString, true);

                if (is_array($testNumberArray) && isset($testNumberArray[1])) {
                    $newControlStatus = trim($testNumberArray[1]);

                    if ($originalControlStatus !== $newControlStatus) {
                        // Update the array directly
                        $control->control_status = $newControlStatus;
                        $matchingFrameworkControl['control_status'] = $newControlStatus;
                    }
                }
            } else {
                // Fetch the parent control and its related framework_control_test_audits
                $testId = $matchingFrameworkControl['id'];
                $parentControl = FrameworkControl::with('frameworkControlTestAudits')->find($testId);

                if ($parentControl) {
                    // Now, use the ID of the latest child control
                    $latestChildControl = FrameworkControl::where('parent_id', $testId)
                        ->orderBy('created_at', 'desc')
                        ->first();

                    if ($latestChildControl) {
                        // Fetch the latest child control and its related framework_control_test_audits
                        $latestChildControlId = $latestChildControl->id;
                        $latestChildControl = FrameworkControl::with('frameworkControlTestAudits')->find($latestChildControlId);

                        // Now, compare the relationship
                        if ($parentControl->id === $latestChildControl->parent_id) {
                            $controlId = $parentControl->id;
                            $childControlId = $latestChildControl->id;

                            $matchingFrameworkControlchild = array_filter($ma, function ($item) use ($childControlId) {
                                return is_array($item) && $item['id'] == $childControlId;
                            });

                            $matchingFrameworkControlparent = array_filter($ma, function ($item) use ($controlId) {
                                return is_array($item) && $item['id'] == $controlId;
                            });

                            $matchingFrameworkControlchild = reset($matchingFrameworkControlchild);
                            $matchingFrameworkControlparent = reset($matchingFrameworkControlparent);

                            // Your additional logic here
                            // For example, merge framework_control_test_audits
                            $mergedTestAudits = array_merge(
                                $matchingFrameworkControlparent['framework_control_test_audits'],
                                $matchingFrameworkControlchild['framework_control_test_audits']
                            );

                            // Remove duplicates based on the 'id' field, you may need to adjust based on your structure
                            $uniqueMergedTestAudits = collect($mergedTestAudits)->unique('id')->values()->all();

                            // Update the framework_control_test_audits for parent control
                            $matchingFrameworkControlparent['framework_control_test_audits'] = $uniqueMergedTestAudits;
                            // Check if the array is not empty before accessing its elements
                            if (!empty($matchingFrameworkControlparent['framework_control_test_audits'])) {
                                $testNumberString = $matchingFrameworkControlparent['framework_control_test_audits'][0]['test_number'];

                                $testNumberArray = json_decode($testNumberString, true);

                                if (is_array($testNumberArray) && isset($testNumberArray[2])) {
                                    $newControlStatus = trim($testNumberArray[2]);

                                    if ($originalControlStatus !== $newControlStatus) {
                                        // Update the array directly
                                        $control->control_status = $newControlStatus;
                                        $matchingFrameworkControlparent['control_status'] = $newControlStatus;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public static function ImplementedStatisticWebsitesOfCategory($id)
    {

        $category = PhishingCategory::withCount('websites')->findOrFail($id);
        $category_count = $category->websites_count;
        $count_of_profiles = PhishingWebsitePage::withoutTrashed()->where('phishing_category_id', '!=', null)->count();
        if ($count_of_profiles > 0) {
            return number_format($category_count * 100 / $count_of_profiles);
        }
        return $category_count;
    }

    public static function appendDataToHostAndSiteEnabled($newWebsite)
    {
        // Append For hosts File C:\Windows\System32\drivers\etc\hosts
        if ($newWebsite->domain()->exists()) {
            $subdomain = $newWebsite->from_address_name;
            $domain = ltrim($newWebsite->domain->name, '@');
            $all_domain = $subdomain . '.' . $domain; // e.g., sub.example.com
        } else {
            $all_domain = $newWebsite->from_address_name; // e.g., example.com
        }

        // Hosts file path (depending on the OS)
        $hostsFilePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ?
            'C:\Windows\System32\drivers\etc\hosts' : '/etc/hosts';

        // Entry to add to the hosts file
        $newHostEntry = "127.0.0.1\t{$all_domain}\n";

        // Check if the entry already exists to avoid duplicates
        if (!str_contains(file_get_contents($hostsFilePath), $all_domain)) {
            // Append the new entry to the hosts file
            file_put_contents($hostsFilePath, $newHostEntry, FILE_APPEND | LOCK_EX);
        }

        // Append For Site Enabled File C:\laragon\etc\apache2\sites-enabled\auto.grc.test.conf
        $rootDirectory = 'C:/laragon/www/grc/public/';
        $siteDomain = $all_domain;
        // VirtualHost content
        $virtualHostEntry = "
        <VirtualHost *:80>
            DocumentRoot \"$rootDirectory\"
            ServerName $siteDomain
            ServerAlias *.$siteDomain
            <Directory \"$rootDirectory\">
                AllowOverride All
                Require all granted
            </Directory>
        </VirtualHost>
        ";

        $configFilePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ?
            'C:\laragon\etc\apache2\sites-enabled\auto.grc.test.conf' : '/etc/apache2/sites-enabled';
        // Write the new VirtualHost to the Apache configuration file
        file_put_contents($configFilePath, $virtualHostEntry, FILE_APPEND | LOCK_EX);
        // Restart Apache to apply the changes
        exec('C:/laragon/bin/apache/httpd.exe -k restart');
    }

    public static function countOfquestions($course_id)
    {
        return DB::table('l_m_s_courses')
            ->join('l_m_s_levels', 'l_m_s_courses.id', '=', 'l_m_s_levels.course_id')
            ->join('l_m_s_training_modules', 'l_m_s_levels.id', '=', 'l_m_s_training_modules.level_id')
            ->join('l_m_s_questions', 'l_m_s_training_modules.id', '=', 'l_m_s_questions.training_module_id')
            ->where('l_m_s_courses.id', $course_id)
            ->count('l_m_s_questions.id');
    }

    public static function countOfStatements($course_id)
    {
        return DB::table('l_m_s_courses')
            ->join('l_m_s_levels', 'l_m_s_courses.id', '=', 'l_m_s_levels.course_id')
            ->join('l_m_s_training_modules', 'l_m_s_levels.id', '=', 'l_m_s_training_modules.level_id')
            ->join('l_m_s_statements', 'l_m_s_training_modules.id', '=', 'l_m_s_statements.training_module_id')
            ->where('l_m_s_courses.id', $course_id)
            ->count('l_m_s_statements.id');
    }

    // public static function GetAllFrameworksAuditGraph()
    // {

    //     // Define the statuses you want to include in the result
    //     $statuses = ["Implemented", "Partially Implemented", "Not Implemented", "Not Applicable"];

    //     // Fetch all frameworks
    //     $frameworks = DB::table('frameworks')->select('id', 'name')->get();

    //     // Fetch all controls and their mappings in a single query
    //     $controls = DB::table('framework_controls')
    //         ->leftJoin('framework_control_mappings', 'framework_controls.id', '=', 'framework_control_mappings.framework_control_id')
    //         ->select(
    //             'framework_controls.id as control_id',
    //             'framework_controls.control_status',
    //             'framework_control_mappings.framework_id'
    //         )
    //         ->whereNull('framework_controls.parent_id') // Exclude parent controls
    //         ->get();

    //     // Group controls by framework_id for easier processing
    //     $controlsByFramework = $controls->groupBy('framework_id');

    //     // Initialize an array to store the total count for each status across all frameworks
    //     $totalStatusCounts = array_fill_keys($statuses, 0);
    //     $groupedByFramework = [];

    //     foreach ($frameworks as $framework) {
    //         $frameworkId = $framework->id;
    //         $frameworkControls = $controlsByFramework->get($frameworkId, collect());

    //         // Get control IDs associated with the framework
    //         $controlIds = $frameworkControls->pluck('control_id')->toArray();

    //         // Initialize array for the framework's statuses
    //         $statusCounts = [];

    //         // Get total number of controls for percentage calculations
    //         $numControlIds = count($controlIds);

    //         foreach ($statuses as $status) {
    //             $auditCountAll = $frameworkControls->where('control_status', $status)->count();

    //             // Update total status counts
    //             $totalStatusCounts[$status] += $auditCountAll;

    //             // Add the result to the $statusCounts array for the current framework
    //             $statusCounts[] = [
    //                 'status_name' => $status,
    //                 'count' => $auditCountAll,
    //                 'percentage' => $numControlIds > 0 ? number_format($auditCountAll * 100 / $numControlIds, 2) : 0,
    //                 'total_controls' => $numControlIds
    //             ];
    //         }

    //         // Prepare the grouped result for the framework
    //         $groupedByFramework[] = [
    //             'framework_id' => $frameworkId,
    //             'framework_name' => $framework->name,
    //             'statuses' => $statusCounts,
    //         ];
    //     }
    //     // Return the response with the aggregated data
    //     return response()->json([
    //         'groupedByFramework' => $groupedByFramework,
    //         'totalStatusCounts' => $totalStatusCounts
    //     ]);
    // }

    public static function GetAllFrameworksAuditGraph()
    {
        $statuses = ["Implemented", "Partially Implemented", "Not Implemented", "Not Applicable"];
        $frameworks = DB::table('frameworks')->select('id', 'name')->get();
    
        $groupedByFramework = [];
        $totalStatusCounts = [];
    
        foreach ($frameworks as $framework) {
            $controls = FrameworkControl::select('framework_controls.id', 'framework_controls.parent_id')
                ->leftJoin('framework_control_mappings', 'framework_controls.id', '=', 'framework_control_mappings.framework_control_id')
                ->whereNull('framework_controls.parent_id')
                ->where('framework_control_mappings.framework_id', $framework->id)
                ->with('frameworkControls') // Relationship for children
                ->get();
    
            $parentWithChildren = [];
            $parentWithoutChildren = [];
    
            foreach ($controls as $control) {
                if ($control->frameworkControls->isNotEmpty()) {
                    $firstChildId = $control->frameworkControls->first()->id;
                    $parentWithChildren[] = $firstChildId;
                } else {
                    $parentWithoutChildren[] = $control->id;
                }
            }
    
            $statusCounts = [];
            $totalControls = count($parentWithChildren) + count($parentWithoutChildren);
    
            foreach ($statuses as $status) {
                $auditCountChildren = FrameworkControlTestAudit::whereIn('framework_control_id', $parentWithChildren)
                    ->whereRaw("id IN (SELECT MAX(id) FROM framework_control_test_audits GROUP BY framework_control_id)")
                    // ->whereRaw("NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[1]')), '') = ?", [$status])
                    ->whereRaw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[2]')), ''), 'Not Implemented') = ?", [$status])
                    ->count();
    
                $auditCountParents = FrameworkControlTestAudit::whereIn('framework_control_id', $parentWithoutChildren)
                    ->whereRaw("id IN (SELECT MAX(id) FROM framework_control_test_audits GROUP BY framework_control_id)")
                    // ->whereRaw("NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[1]')), '') = ?", [$status])
                    ->whereRaw("IFNULL(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(test_number, '$[1]')), ''), 'Not Implemented') = ?", [$status])
                    ->count();
    
                $totalCount = $auditCountChildren + $auditCountParents;
    
                // Calculate percentage
                $percentage = ($totalControls > 0) ? round(($totalCount / $totalControls) * 100, 2) : 0;
    
                $statusCounts[] = [
                    'status_name' => $status,
                    'count' => $totalCount,
                    'percentage' => $percentage,
                    'total_controls' => $totalControls,
                ];
    
                if (!isset($totalStatusCounts[$status])) {
                    $totalStatusCounts[$status] = 0;
                }
                $totalStatusCounts[$status] += $totalCount;
            }
    
            $groupedByFramework[] = [
                'framework_id' => $framework->id,
                'framework_name' => $framework->name,
                'statuses' => $statusCounts,
            ];
        }
    
        return response()->json([
            'groupedByFramework' => $groupedByFramework,
            'totalStatusCounts' => $totalStatusCounts
        ]);
    }
    

}
