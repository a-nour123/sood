<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\DocumentTypes;
use App\Models\Family;
use App\Models\Framework;
use Illuminate\Database\Seeder;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlMapping;
use App\Models\FrameworkControlTest;
use App\Models\Regulator;
use Illuminate\Support\Facades\DB;

class NCACCC_1_2020Seeder extends Seeder
{
    protected $options;
    protected $regulatorId;

    public function __construct()
    {
        // Get the environment variable
        $options = getenv('SEEDER_OPTIONS');
        $regulatorId = getenv('SEEDER_REGULATION');

        // Debugging: Check the raw environment variable
        // var_dump($options);

        if ($regulatorId) {
            // Split the string into an array using comma as the delimiter
            $this->regulatorId = json_decode($regulatorId, true) ?: [];
        } else {
            $this->regulatorId = [];
        }
        // Check if options are present
        if ($options) {
            // Split the string into an array using comma as the delimiter
            $this->options = json_decode($options, true) ?: [];
        } else {
            // Set options as an empty array if no options are present
            $this->options = [];
        }
    }


    public function run()
    {
        DB::transaction(function () {
            $currentDateTime = now();
            $currentDate = date('Y-m-d');
            $nextReviewDate = date('Y-m-d', strtotime('+180 days', strtotime($currentDate)));
            $regulation = getenv('SEEDER_REGULATION');

            // Debugging: Check the condition before entering the if block

            // if (in_array('install_document', $this->options)) {

            // DocumentTypes::updateOrCreate(
            //     ['name' => 'نماذج سياسات الأمن السيبراني'], // Attributes to search for
            //     ['icon' => 'fas fa-lock'] // Attributes to update or create
            // );

            // DocumentTypes::updateOrCreate(
            //     ['name' => 'معايير الأمن السيبراني'],
            //     ['icon' => 'fas fa-lock']
            // );

            // DocumentTypes::updateOrCreate(
            //     ['name' => 'الاجراءات'],
            //     ['icon' => 'fas fa-bug']
            // );

            // DocumentTypes::updateOrCreate(
            //     ['name' => 'صمود الأمن السيبراني'],
            //     ['icon' => 'fas fa-unlink']
            // );
            // }



            // Insert framework data
            $framework = Framework::create([
                'name' => 'NCA-CCC – 1: 2020',
                'description' => "The National Cybersecurity Authority “NCA” has developed the Cloud Cybersecurity Controls (CCC – 1: 2020) as an extension and a complement to Essential Cybersecurity Controls (ECC – 1: 2018). The CCC aims to set cybersecurity requirements for cloud computing from the perspective of Cloud Service Providers (CSPs) and Cloud Service Tenants (CSTs); to meet the security needs and raise the CSPs’ and the CSTs’ preparedness towards reducing cybersecurity risks on all cloud computing services. The Cloud Cybersecurity Controls consist of 37 main controls and 96 subcontrols for CSPs, and 18 main controls and 26 subcontrols for CSTs, divided into four main domains.",
                'icon' => 'fa-warning',
                'status' => '1',
                'regulator_id' => $this->regulatorId,
            ]);


            // Main domains with their subdomains
            $mainDomains = [
                [
                    'name' => 'Cybersecurity Governance',
                    'order' => '1',
                    'subdomains' => [
                        ['name' => 'Cybersecurity Role and Responsibilities', 'order' => '4'],
                        ['name' => 'Cybersecurity Risk Management', 'order' => '5'],
                        ['name' => 'Cybersecurity Regulatory Compliance', 'order' => '7'],
                        ['name' => 'Cybersecurity in Human Resources', 'order' => '9'],
                        ['name' => 'Management Change in Cybersecurity', 'order' => '11',]
                    ]
                ],
                [
                    'name' => 'Cybersecurity Defense',
                    'order' => '2',
                    'subdomains' => [
                        ['name' => 'Asset Management', 'order' => '1'],
                        ['name' => 'Identity and Access Management', 'order' => '2'],
                        ['name' => 'Information System and Processing Facilities Protection', 'order' => '3'],
                        ['name' => 'Networks Security Management', 'order' => '5'],
                        ['name' => 'Mobile Devices Security', 'order' => '6'],
                        ['name' => 'Data and Information Protection', 'order' => '7'],
                        ['name' => 'Cryptography', 'order' => '8'],
                        ['name' => 'Backup and Recovery Management', 'order' => '9'],
                        ['name' => 'Vulnerabilities Management', 'order' => '10'],
                        ['name' => 'Penetration Testing', 'order' => '11'],
                        ['name' => 'Cybersecurity Event Logs and Monitoring Management', 'order' => '12'],
                        ['name' => 'Cybersecurity Incident and Threat Management', 'order' => '13'],
                        ['name' => 'Physical Security', 'order' => '14'],
                        ['name' => 'Web Application Security', 'order' => '15'],
                        ['name' => 'Key management', 'order' => '16',],
                        ['name' => 'System Development Security', 'order' => '18',],
                        ['name' => 'Storage Media Security', 'order' => '19',],
                    ]
                ],
                [
                    'name' => 'CyberSecurity Resilience',
                    'order' => '3',
                    'subdomains' => [
                        [
                            'name' => 'Cybersecurity Resilience aspects of Business Continuity Management (BCM)',
                            'order' => '1',
                        ]
                    ]
                ],
                [
                    'name' => 'Third-Party and Cloud Computing Cybersecurity',
                    'order' => '4',
                    'subdomains' => [
                        [
                            'name' => 'Third-Party Cybersecurity',
                            'order' => '1'
                        ],

                    ]
                ],

            ];

            $subDomainFamilies = [];

            foreach ($mainDomains as $mainDomain) {
                // Create or update the main domain
                $domain = Family::updateOrCreate(
                    ['name' => $mainDomain['name'], 'parent_id' => null],
                    ['order' => $mainDomain['order']]
                );

                if (isset($mainDomain['subdomains'])) {
                    foreach ($mainDomain['subdomains'] as $subDomain) {
                        // Create or update the subdomain
                        $subDomainFamily = Family::updateOrCreate(
                            ['name' => $subDomain['name'], 'parent_id' => $domain->id],
                            ['order' => $subDomain['order']]
                        );
                        $subDomainFamilies[$subDomainFamily->id] = $subDomainFamily->parent_id;
                    }
                }

                // Sync the main domain with the framework
                $framework->families()->syncWithoutDetaching([
                    $domain->id => ['parent_family_id' => $domain->parent_id],
                ]);

                // Sync the subdomains with the framework
                foreach ($subDomainFamilies as $subDomainId => $parentId) {
                    $framework->families()->syncWithoutDetaching([
                        $subDomainId => ['parent_family_id' => $parentId],
                    ]);
                }
            }




            $frameworkControls = [

                [
                    "short_name" => "CCC ١-١-م-١",
                    "long_name" => "CCC ١-١-م-١",
                    "description" => "بالإضافة للضابط ‎٠-6-١‏ في الضوابط الأساسية للأمن السيبراني. يجب على صاحب الصلاحية\r\nتحديد وتوثيق واعتماد",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ١-١-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Role and Responsibilities'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ١-١-م-١-١‏",
                            "long_name" => "CCC ١-١-م-١-١‏",
                            "description" => "أدوار الأمن السيبراني. وتكليفات المسؤولية والمحاسبة والاستشارة والتبليغ\r\n(1هع) لكل أصحاب العلاقة في خدمات الحوسبة السحابية. بما في ذلك أدوار\r\nومسؤوليات صاحب الصلاحية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-١-م-١-١‏",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Role and Responsibilities'), // Dynamically get family ID
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ],

                ],
                [

                    "short_name" => "CCC ١-١-ش۔١",
                    "long_name" => "CCC ١-١-ش۔١",
                    "description" => "بالإضافة للضابط ‎٠-6-١‏ في الضوابط الأساسية للأمن السيبراني. يجب على صاحب الصلاحية\r\nتحديد وتوثيق واعتماد",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ١-١-ش۔١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Role and Responsibilities'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "CCC ١-١-ش۔١-١",
                            "long_name" => "CCC ١-١-ش۔١-١",
                            "description" => "أدوار الأمن السيبراني. وتكليفات المسؤولية والمحاسبة والاستشارة والتبليغ\r\n([ع) لكل أصحاب العلاقة في خدمات الحوسبة السحابية. بما في ذلك أدوار\r\nومسؤوليات صاحب الصلاحية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-١-ش۔١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Role and Responsibilities'), // Dynamically get family ID
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ],

                ],

                [

                    "short_name" => "CCC ١-٢-م-١",
                    "long_name" => "CCC ١-٢-م-١",
                    "description" => "يجب أن تتضمن منهجية إدارة مخاطر الأمن السيبراني المذكورة في المكون الفرعي ‎0-١‏ في\r\nالضوابط الأساسية للأمن السيبراني لدى مقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ١-٢-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "CCC ١-٢-م-١-١‏",
                            "long_name" => "CCC ١-٢-م-١-١‏",
                            "description" => "تحديد المستوى المقبول للمخاطر (160865 ون عاطةامع}) فيما يتعلق\r\nبخدمات الحوسبة السحابية. وتوضيحها للمشترك إذا كانت المخاطر ذات علاقة\r\nبه.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-٢-م-١-١‏",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "CCC ١-٢-م-١-٢",
                            "long_name" => "CCC ١-٢-م-١-٢",
                            "description" => "أخذ تصنيف البيانات والمعلومات بالاعتبار في منهجية إدارة مخاطر الأمن\r\nالسيبراني.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-٢-م-١-٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "CCC ١-٢-م-١-3",
                            "long_name" => "CCC ١-٢-م-١-3",
                            "description" => "إنشاء سجل لمخاطر الأمن السيبراني خاص بالعمليات وخدمات الحوسبة\r\nالسحابية. ومتابعته دوريًا بما يتناسب مع طبيعة المخاطر.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-٢-م-١-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ],

                ],

                [

                    "short_name" => "CCC ١-٢-ش-١",
                    "long_name" => "CCC ١-٢-ش-١",
                    "description" => "يجب أن تتضمن منهجية إدارة مخاطر الأمن السيبراني المذكورة في المكون الفرعي ‎٥-١‏ في\r\nالضوابط الأساسية للأمن السيبراني لدى المشتركين",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ١-٢-ش-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "CCC ١-٢-ش-١-١",
                            "long_name" => "CCC ١-٢-ش-١-١",
                            "description" => "تحديد المستوى المقبول للمخاطر (:1عع] فن عاطةامعع}) فيما يتعلق\r\nبخدمات الحوسبة السحابية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-٢-ش-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "CCC ١-٢-ش۔١۔٢",
                            "long_name" => "CCC ١-٢-ش۔١۔٢",
                            "description" => "أخذ تصنيف البيانات والمعلومات بالاعتبار في منهجية إدارة مخاطر الأمن\r\nالسيبراني.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-٢-ش۔١۔٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "CCC ١-٢-ش۔١۔3‏",
                            "long_name" => "CCC ١-٢-ش۔١۔3‏",
                            "description" => "إنشاء سجل لمخاطر الأمن السيبراني خاص بالعمليات وخدمات الحوسبة\r\nالسحابية. ومتابعته دوريًا يما يتناسب مع طبيعة المخاطر.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-٢-ش۔١۔3‏",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],

                    ],

                ],

                [

                    "short_name" => "CCC ١-٣-م-١",
                    "long_name" => "CCC ١-٣-م-١",
                    "description" => "بالإضافة للضابط ‎١-7-١‏ في الضوابط الأساسية للأمن السيبراني. يجب أن يشتمل التزام مقدمي\r\nالخدمات بالمتطلبات التشريعية والتنظيمية",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ١-٣-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Regulatory Compliance'),

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CCC ١-٣-م-١-١",
                            "long_name" => "CCC ١-٣-م-١-١",
                            "description" => "الالتزام الدائم والمستمر بجميع الأنظمة واللوائح والتعليمات والقرارات والأطر\r\nوالضوابط التنظيمية المتعلقة بالأمن السيبراني والمعمول بها في المملكة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-٣-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Regulatory Compliance'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]
                ],
                [
                    "short_name" => "CCC ١-٣-ش۔١",
                    "long_name" => "CCC ١-٣-ش۔١",
                    "description" => "بالإضافة للضابط ‎1-7-١‏ في الضوابط الأساسية للأمن السيبراني. يجب أن يشتمل التزام المشتركين\r\nبالمتطلبات التشريعية والتنظيمية",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ١-٣-ش۔١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Regulatory Compliance'),

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CCC ١-٣-ش-١-١",
                            "long_name" => "CCC ١-٣-ش-١-١",
                            "description" => "المراقبة الدائمة والمستمرة لمدى التزام مقدمي الخدمات بالتشريعات. وبنود\r\nالعقود المتعلقة بالأمن السيبراني.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-٣-ش-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Regulatory Compliance'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",


                        ],
                    ]
                ],

                [
                    "short_name" => "CCC ١-٤-م-١",
                    "long_name" => "CCC ١-٤-م-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابطين ‎٣-٢-١‏ و ‎2-9-١‏ في الضوابط الأساسية للأمن السيبراني؛\r\n\r\nيجب أن تغطي متطلبات الأمن السيبراني قبل بدء وخلال العلاقة المهنية بين العاملين ومقدمي\r\nالخدمة",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ١-٤-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CCC ١-٤-م-١-١",
                            "long_name" => "CCC ١-٤-م-١-١",
                            "description" => "فيما يتعلق بمراكز البيانات التابعة مقدم الخدمة داخل المملكة. يجب أن يشغل\r\nوظائف الأمن السيبراني مواطنون سعوديون مؤهلون",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-٤-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",


                        ],
                        [
                            "short_name" => "CCC ١-٤-م-١۔٢",
                            "long_name" => "CCC ١-٤-م-١۔٢",
                            "description" => "إجراء المسح الأمني للعاملين داخل المملكة الذين لهم حق الوصول إلى الأنظمة\r\nالتقنية السحابية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-٤-م-١۔٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",


                        ],
                        [
                            "short_name" => "CCC ١-٤-م-١۔3",
                            "long_name" => "CCC ١-٤-م-١۔3",
                            "description" => "إقرار وتوقيع العاملين على جميع سياسات الأمن السيبراني كشرط مسبق للوصول\r\nإلى الأنظمة التقنية السحابية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-٤-م-١۔3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",


                        ],
                    ]
                ],
                [
                    "short_name" => "CCC ١-٤-م-2",
                    "long_name" => "CCC ١-٤-م-2",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎0-4-١‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني بعد انتهاء العلاقة المهنية بين العاملين ومقدمي الخدمة",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ١-٤-م-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CCC ١-٤-م-2۔1",
                            "long_name" => "CCC ١-٤-م-2۔1",
                            "description" => "ضمان إعادة الأصول الخاصة بمقدمي الخدمات (لا سيما ذات الصلة بالأمن\r\nالسيبراني) بمجرد إنهاء الخدمة مع العاملين.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-٤-م-2۔1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",


                        ],
                    ]

                ],
                [
                    "short_name" => "CCC ١-٤-ش-١",
                    "long_name" => "CCC ١-٤-ش-١",
                    "description" => "الإضافة للضوابط الفرعية ضمن الضابط ‎٣-٢-١‏ في الضوابط الأساسية للأمن السيبراني. يجب\r\nأن تغطي متطلبات الأمن السيبراني قبل بدء العلاقة المهنية بين العاملين والمشتركين",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ١-٤-ش-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CCC ١-٤-ش-١-١",
                            "long_name" => "CCC ١-٤-ش-١-١",
                            "description" => "إجراء المسح الأمني للعاملين الذين لهم حق الوصول إلى المهام الحساسة\r\nلخدمات الحوسبة السحابية. مثل => إدارة المفاتيح. إدارة الخدمات التحكم\r\nبالوصول",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-٤-ش-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ]
                ],
                [
                    "short_name" => "CCC ١-٥-م-١",
                    "long_name" => "CCC ١-٥-م-١",
                    "description" => "يجب تحديد متطلبات الأمن السيبراني لإدارة التغيير لدى مقدمي الخدمات\" وتوثيقهاء واعتمادها.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ١-٥-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "CCC ١-٥-م-٢",
                    "long_name" => "CCC ١-٥-م-٢",
                    "description" => "يجب تطبيق متطلبات الأمن السيبراني. الخاصة بإدارة التغيير لدى مقدمي الخدمات.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ١-٥-م-٢",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "CCC ١-٥-م-۳",
                    "long_name" => "CCC ١-٥-م-۳",
                    "description" => "يجب أن يغطي األمن السيرباين إلدارة التغيري لدى مقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ١-٥-م-۳",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CCC ١-٥-م-۳-١",
                            "long_name" => "CCC ١-٥-م-۳-١",
                            "description" => "إجراءات تنفيذ التغيريات )املخطط لها( بطرق آمنة، يف أنظمة اإلنتاج\r\n)Systems Production ،)مع إعطاء أولوية للمالحظات املتعلقة باألمن\r\nالسيرباي",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-٥-م-۳-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ١-٥-م-۳-2",
                            "long_name" => "CCC ١-٥-م-۳-2",
                            "description" => "إجراءات تنفيذ التغيريات االستثنائية ذات العالقة باألمن السيرباين )مثل التغيريات\r\nأثناء التعايف من الحوادث(.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ١-٥-م-۳-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ]
                ],
                [
                    "short_name" => "CCC ١-٥-م-4",
                    "long_name" => "CCC ١-٥-م-4",
                    "description" => "يجب مراجعة متطلبات األمن السيرباين إلدارة التغيري لدى مقدمي الخدمات، ومراجعة تطبيقها،\r\nدوري",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ١-٥-م-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "CCC ٢-١-م-١",
                    "long_name" => "CCC ٢-١-م-١",
                    "description" => "بالإضافة للضوابط ضمن المكون الفرعي ‎١-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني لإدارة الأصول المعلوماتية والتقنية لدى مقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-١-م-١-١",
                            "long_name" => "CCC ٢-١-م-١-١",
                            "description" => "حصر جميع الأصول المعلوماتية والتقنية باستخدام التقنيات المناسبة كقاعدة\r\nبيانات إدارة الإعدادات (03101)؛ أو قدرة مماثلة. تتضمن جردًا لكل الأصول\r\nالتقنية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Asset Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-١-م-١-2",
                            "long_name" => "CCC ٢-١-م-١-2",
                            "description" => "تحديد ملاك الأصول  وإشراكهم في دورة حياة إدارة الأصول",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١-م-١-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Asset Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]
                ],

                [
                    "short_name" => "CCC ٢-١-ش۔١",
                    "long_name" => "CCC ٢-١-ش۔١",
                    "description" => "بالإضافة للضوابط ضمن المكون الفرعي ‎١-٢‏ في الضوابط الأساسية للأمن السيراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني لإدارة الأصول المعلوماتية والتقنية لدى المشتركين",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١-ش۔١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CCC ٢-١-ش۔١-١‏",
                            "long_name" => "CCC ٢-١-ش۔١-١‏",
                            "description" => "حصر جميع الخدمات السحابية والأصول المعلوماتية والتقنية المتعلقة بها.\r\nإدارة هويات الدخول والصلاحيات",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١-ش۔١-١‏",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Asset Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ]
                    ]
                ],
                [
                    "short_name" => "CCC ٢-٢-م-١",
                    "long_name" => "CCC ٢-٢-م-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-٢-٢‏ في الضوابط الأساسية للأمن السييراني. يجب\r\nأن تغطي متطلبات الأمن السيبراني الخاصة بإدارة هويات الدخول والصلاحيات لدى مقدمي\r\nالخدمات.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-٢-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CCC ٢-٢-م-١-١",
                            "long_name" => "CCC ٢-٢-م-١-١",
                            "description" => "إدارة الحسابات العامة (فاصناهع>ه ععصء6) التي لا ممكن إسناد مسؤوليتها\r\nإلى أشخاص محددين",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٢-م-١۔٢",
                            "long_name" => "CCC ٢-٢-م-١۔٢",
                            "description" => "الإدارة الآمنة للجلسات Management Session Secure ،). وتشمل مو\r\nالجلسات (Authenticity). وإقفالها لأدمعك16) وإنهاء مهلتها ()Timeout.)).",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢-م-١۔٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٢-م-١-٣",
                            "long_name" => "CCC ٢-٢-م-١-٣",
                            "description" => "التحقق من الهوية متعدد العناصر )ح -(\r\nلحسابات المستخدمين ذوي الصلاحيات الهامة والحساسة والذين لهم حق\r\nالوصول إلى الأنظمة التقنية السحابية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢-م-١-٣",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٢-م۔١-٤",
                            "long_name" => "CCC ٢-٢-م۔١-٤",
                            "description" => "إجراءات لكشف محاولات الوصول غير المصرح به ومنعها مثل => (الحد الأقصى\r\nمن محاولات عمليات الدخول غير الناجحة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢-م۔١-٤",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٢-م-١-٥",
                            "long_name" => "CCC ٢-٢-م-١-٥",
                            "description" => "استخدام الطرق والخوارزميات الآمنة لحفظ ومعالجة كلمات المرور مثل:\r\nاستخدام دوال اختزال آمنة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢-م-١-٥",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢۔٢-م-١-٦",
                            "long_name" => "CCC ٢۔٢-م-١-٦",
                            "description" => "الإدارة الآمنة للحسابات الخاصة بالعاملين التابعين للأطراف الخارجية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢۔٢-م-١-٦",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٢-م-١-٧",
                            "long_name" => "CCC ٢-٢-م-١-٧",
                            "description" => "التحكم في الوصول إلى الأنظمة الإدارية (es A)‏ والإشرافية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢-م-١-٧",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٢-م-١-٨",
                            "long_name" => "CCC ٢-٢-م-١-٨",
                            "description" => "إخفاء معلومات التحقق من الهوية. خاصة كلمات المرور. عند عرضها\r\nللمستخدم؛ لحمايتها من اطلاع الآخرين عليها",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢-م-١-٨",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٢-م-١-٩",
                            "long_name" => "CCC ٢-٢-م-١-٩",
                            "description" => "الحصول على موافقة المشترك قبل عملية الوصول إلى أي من الأصول والبيانات\r\nالخاصة به. من قبل مقدم الخدمة أو الأطراف الخارجية مقدم الخدمة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢-م-١-٩",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٢-م-١-١٠",
                            "long_name" => "CCC ٢-٢-م-١-١٠",
                            "description" => "القدرة على الإيقاف الفوري للجلسة (صمنوعك) لعمليات الدخول عن بعد\r\nومنع المستخدم من الدخول مستقبلا.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢-م-١-١٠",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٢-م-١-١١‏",
                            "long_name" => "CCC ٢-٢-م-١-١١‏",
                            "description" => "تزويد المشتركين بخدمات التحقق من الهوية متعدد العناصر لكافة الحسابات\r\nالسحابية للمستخدمين ذوي الصلاحيات الهامة والحساسة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢-م-١-١١‏",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٢-م-١-١٢",
                            "long_name" => "CCC ٢-٢-م-١-١٢",
                            "description" => "التحكم بالوصول لأنظمة ووسائل التخزين (مثل الشبكة الخاصة بالتخزين",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢-م-١-١٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],
                [
                    "short_name" => "CCC ٢-٢-ش۔١",
                    "long_name" => "CCC ٢-٢-ش۔١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط 7-7-9 في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بإدارة هويات الدخول والصلاحيات لدى المشتركين",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-٢-ش۔١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CCC ٢-٢-ش۔١۔1",
                            "long_name" => "CCC ٢-٢-ش۔١۔1",
                            "description" => "إدارة هويات الدخول والصلاحيات لجميع الحسابات. التي لديها صلاحية\r\nالوصول إلى الخدمات السحابية. خلال دورة حياتها",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢-ش۔١۔1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٢-ش۔١۔٢‏",
                            "long_name" => "CCC ٢-٢-ش۔١۔٢‏",
                            "description" => "سرية هوية المستخدم والحسابات والصلاحيات بما في ذلك الطلب من\r\nالمستخدمين حفظ خصوصيتها (للعاملين. والأطراف الخغارجية\r\nوالمستخدمين من جهة المشترك",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢-ش۔١۔٢‏",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٢-ش۔١-٣‏",
                            "long_name" => "CCC ٢-٢-ش۔١-٣‏",
                            "description" => "الإدارة الآمنة لجلسات ) ). وتشمل موثوقية\r\nالجلسات (). وإقفالها (1) وإنهاء مهلتها .",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢-ش۔١-٣‏",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢۔٢-ش۔١-٤",
                            "long_name" => "CCC ٢۔٢-ش۔١-٤",
                            "description" => "التحقق من الهوية متعدد العناصر لكافة الحسابات السحابية للمستخدمين\r\nذوي الصلاحيات الهامة والحساسة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢۔٢-ش۔١-٤",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٢-ش-١-٥",
                            "long_name" => "CCC ٢-٢-ش-١-٥",
                            "description" => "إجراءات لكشف محاولات الوصول غير المصرح به ومنعها مثل => (الحد الأقصى\r\nمن محاولات عمليات الدخول غير الناجحة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢-ش-١-٥",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]

                ],

                [
                    "short_name" => "CCC  ٢-٣-م-١",
                    "long_name" => "ccc ٢-٣-م-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-٢-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بحماية الأنظمة وأجهزة معالجة المعلومات لدى مقدمي\r\nالخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "ccc ٢-٣-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CCC  ٢-٣-م-١-١",
                            "long_name" => "ccc ٢-٣-م-١-١",
                            "description" => "التحقق من مدى التزام الإعدادات التقنية معايير الأمن السيبراني المعتمدة لدى\r\nمقدم الخدمة",
                            "supplemental_guidance" => null,
                            "control_number" => "ccc ٢-٣-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-٣-م-١-٢‏",
                            "long_name" => "CCC ٢-٣-م-١-٢‏",
                            "description" => "وضع ضمانات لمنع اختلاط بيانات (ing D ) المشتركين",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٣-م-١-٢‏",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC  ٢-٣-م-١-٣‏",
                            "long_name" => "CCC  ٢-٣-م-١-٣‏",
                            "description" => "اتباع مبادئ الأمن السيبراني لتفعيل الحد الأدنى من الوظائف المطلوبة\r\n)ج نج صنصنصن) لإعدادات الأنظمة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC  ٢-٣-م-١-٣‏",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-٣-م-۔١-٤",
                            "long_name" => "CCC ٢-٣-م-۔١-٤",
                            "description" => "أن تكون الأنظمة التقنية السحابية (015) قادرة على التعامل بطرق آمنة مع:\r\nالمدخلات والتحقق منها ).‏ والاستثناء ات \r\nوالتوقف (عنلنة)",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٣-م-۔١-٤",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-٣-م-١-٥",
                            "long_name" => "CCC ٢-٣-م-١-٥",
                            "description" => "عزل التطبيقات والوظائف الأمنية عن التطبيقات والوظائف الأخرى في الأنظمة\r\nالتقنية السحابية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٣-م-١-٥",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-٣-م-١-٦",
                            "long_name" => "CCC ٢-٣-م-١-٦",
                            "description" => "تبليغ المشترك بالمتطلبات المتعلقة بالأمن السيبراني التي يوفرها مقدم الخدمة\r\nوالقابلة للاستخدام من قبل المشترك",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٣-م-١-٦",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢۔٣-م-١-٧",
                            "long_name" => "CCC ٢۔٣-م-١-٧",
                            "description" => "اكتشاف ومنع التغييرات غير المصرح بها على البرامج والأنظمة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢۔٣-م-١-٧",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-٣-م-١-٨",
                            "long_name" => "CCC ٢-٣-م-١-٨",
                            "description" => "العزل بين بيئات الاستضافة الخاصة بالمشتركين ) («\r\nوالحماية فيما بينها",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٣-م-١-٨",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-٣-م-١-٩",
                            "long_name" => "CCC ٢-٣-م-١-٩",
                            "description" => "أن تكون الحوسبة السحابية المشتركة المقدمة للمشتركين (الجهات الحكومية\r\nوالجهات ذات البنية التحتية الحساسة) معزولة عن أي حوسبة سحابية أخرى\r\nمقدمة للجهات خارج نطاق العمل",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٣-م-١-٩",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-٣-م-١-10",
                            "long_name" => "CCC ٢-٣-م-١-10",
                            "description" => "تقديم خدمات الحوسبة السحابية من داخل المملكة. وتشمل الأنظمة\r\nالمستخدمة بما في ذلك أنظمة التخزين والمعالجة ومراكز التعافي من الكوارث",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٣-م-١-10",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-٣-م-١-١١",
                            "long_name" => "CCC ٢-٣-م-١-١١",
                            "description" => "تقديم خدمات الحوسبة السحابية من داخل المملكة. وتشمل الأنظمة\r\nالمستخدمة بما في ذلك أنظمة المراقبة. والدعم.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٣-م-١-١١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-٣-م-١-12",
                            "long_name" => "CCC ٢-٣-م-١-12",
                            "description" => "استخدام التقنيات الحديثة. مثل تقنيات ة ع ع(\r\n))( صمم => . لضمان جاهزية خوادم وأجهزة المعلومات الخاصة\r\nبأنظمة وأجهزة معالجة المعلومات لدى مقدمي الخدمات للاستجابة السريعة\r\nللحوادث.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٣-م-١-12",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ],
                ],

                [
                    "short_name" => "CCC ٢-٣-ش۔١",
                    "long_name" => "CCC ٢-٣-ش۔١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-٣-٢‏ في الضوابط الأساسية للأمن السيبراني يجب\r\n\r\nأن تغطي متطلبات الأمن السيبراني الخاصة بحماية الأنظمة وأجهزة معالجة المعلومات لدى\r\nالمشتركين",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-٣-ش۔١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CCC ٢-٣-ش۔١-١",
                            "long_name" => "CCC ٢-٣-ش۔١-١",
                            "description" => "التحقق من قيام مقدم الخدمة بعزل الحوسبة السحابية المشتركة المقدمة\r\nللمشتركين (الجهات الحكومية والجهات ذات البنية التحتية الحساسة) عن أي\r\nحوسبة سحابية أخرى مقدمة للجهات خارج نطاق العمل.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٣-ش۔١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ],
                ],


                [
                    "short_name" => "CCC ٢-٤-م-١",
                    "long_name" => "CCC ٢-٤-م-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-٥-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بإدارة أمن الشبكات لدى مقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-٤-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Networks Security Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-٤-م-١-١",
                            "long_name" => "CCC ٢-٤-م-١-١",
                            "description" => "مراقبة الشبكات الداخلية والخارجية للكشف عن الأنشطة المشبوهة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٤-م-١-١",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٤-م-١-٢",
                            "long_name" => "CCC ٢-٤-م-١-٢",
                            "description" => "عزل وحماية الشبكة الخاصة بالأنظمة التقنية السحابية (015) من الشبكات\r\nالأخرى الداخلية والخارجية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٤-م-١-٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٤-م-١-٣",
                            "long_name" => "CCC ٢-٤-م-١-٣",
                            "description" => "الحماية من هجمات تعطيل الخدمات ((6٥(ا)‏ 567166 ه لمنصء(). وهجمات\r\nتعطيل الخدمات الموزعة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٤-م-١-٣",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٤-م-١-٤",
                            "long_name" => "CCC ٢-٤-م-١-٤",
                            "description" => "CCC  استخدام التشفير للبيانات المنتقلة عبر الشبكة من وإلى الشبكة الخاصة بالأنظمة التقنية السحابية (015) لعمليات الوصول الإشرافي والإداري",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٤-م-١-٤",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٤-م-١-٥",
                            "long_name" => "CCC ٢-٤-م-١-٥",
                            "description" => "التحكم في الوصول ) بين أجزاء الشبكة\r\n‎)٦‏ المختلفة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٤-م-١-٥",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٤-م-١-٦",
                            "long_name" => "CCC ٢-٤-م-١-٦",
                            "description" => "العزل بين شبكات الخدمات السحابية )نع 567166 نها) وشبكات\r\nالإدارة السحابية (صعصععةصة1 01008) والشبكة الداخلية مقدم الخدمة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٤-م-١-٦",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "CCC ٢-٤-ش-١",
                    "long_name" => "CCC ٢-٤-ش-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-٥-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بإدارة أمن الشبكات لدى المشتركين",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-٤-ش-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Networks Security Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-٤-ش-1-١",
                            "long_name" => "CCC ٢-٤-ش-1-١",
                            "description" => "حماية القناة المستخدمة للاتصال الشبكي مع مقدم الخدمة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٤-ش-1-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ],
                ],

                [
                    "short_name" => "CCC ٢-٥-م-١",
                    "long_name" => "CCC ٢-٥-م-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-٦-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بأمن الأجهزة المحمولة لدى مقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-٥-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-٥-م-١-١",
                            "long_name" => "CCC ٢-٥-م-١-١",
                            "description" => "الاحتفاظ بقائمة جرد محدثة (Inventory) للأجهزة المحمولة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٥-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٥-م-١-٢",
                            "long_name" => "CCC ٢-٥-م-١-٢",
                            "description" => "الإدارة الأمنية للأجهزة المحمولةement Device M21) مركزيا",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٥-م-١-٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٥-م-١-٣",
                            "long_name" => "CCC ٢-٥-م-١-٣",
                            "description" => "قفل الشاشة لأجهزة المستخدمين",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٥-م-١-٣",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٥-م-١-4",
                            "long_name" => "CCC ٢-٥-م-١-4",
                            "description" => "قبل إعادة استخدام الأجهزة المحمولة أو التخلص منها! خصوصًا التي يتم\r\nاستخدامها للدخول على الأنظمة التقنية السحابية (015)؛ يجب التأكد من\r\nعدم احتوائها على أية بيانات أو معلومات باستخدام وسائل آمنة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٥-م-١-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ],

                ],
                [
                    "short_name" => "CCC ٢-٥-ش-١",
                    "long_name" => "CCC ٢-٥-ش-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-٦-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بأمن الأجهزة المحمولة لدى المشتركين",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-٥-ش-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-٥-ش۔١-١",
                            "long_name" => "CCC ٢-٥-ش۔١-١",
                            "description" => "قبل إعادة استخدام الأجهزة المحمولة أو التخلص منها! خصوصًا التي يتم\r\nاستخدامها للدخول على الخدمات السحابية. يجب التأكد من عدم احتوائها\r\nعلى أية بيانات أو معلومات باستخدام وسائل آمنة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٥-ش۔١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ],
                ],
                [
                    "short_name" => "CCC ٢-٦-م-١",
                    "long_name" => "CCC ٢-٦-م-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-٧-٢‏ في الضوابط الأساسية للأمن السيبراز\r\nتغطي متطلبات الأمن السيبراني الخاصة بحماية البيانات والمعلومات لدى مقدمي الخدمة",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-٦-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-٦-م-١-١",
                            "long_name" => "CCC ٢-٦-م-١-١",
                            "description" => "عدم استخدام بيانات الأنظمة التقنية السحابية (75©) في غير بيئة الإنتاج\r\n)ج «مناءه0:00) إلا بعد استخدام ضوابط مشددة لحماية\r\nتلك البيانات مثل => تقنيات تعتيم البيانات (ع«ن81ه134 ها) أو تقنيات مزج\r\ning D",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٦-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٦-م-١-٢",
                            "long_name" => "CCC ٢-٦-م-١-٢",
                            "description" => "تزويد المشتركين بعمليات وإجراءات وتقنيات آمنة لتخزين البيانات» مع الالتزام\r\nبالمتطلبات التشريعية والتنظيمية ذات العلاقة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٦-م-١-٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢۔٦-م-١-٣",
                            "long_name" => "CCC ٢۔٦-م-١-٣",
                            "description" => "حذف وإتلاف بيانات المشترك بطرق آمنة عند الانتهاء من العلاقة مع المشترك",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢۔٦-م-١-٣",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٦-م-۔١-٤",
                            "long_name" => "CCC ٢-٦-م-۔١-٤",
                            "description" => "الالتزام بالمحافظة على سرية بيانات ومعلومات ابلشترك. حسب المتطلبات\r\nالتشريعية والتنظيمية ذات العلاقة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC  ٢-٦-م-۔١-٤",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٦-م-١-٥",
                            "long_name" => "CCC ٢-٦-م-١-٥",
                            "description" => "تزويد المشتركين بوسائل آمنة لتصدير ونقل البيانات والبنية التحتية الافتراضية.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٦-م-١-٥",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "CCC ٢-٦-ش-١",
                    "long_name" => "CCC ٢-٦-ش-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-٧-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب\r\n\r\nأن تغطي متطلبات الأمن السيبراني الخاصة بحماية بيانات و معلومات المشتركين في الحوسبة\r\nالسحابية",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-٦-ش-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-٦-ش۔١-١‏",
                            "long_name" => "CCC ٢-٦-ش۔١-١‏",
                            "description" => "وجود ضمانات للقدرة على حذف البيانات بطرق آمنة عند الانتهاء من العلاقة\r\nمع مقدم الخدمة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٦-ش۔١-١‏",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٦-ش۔١۔٢",
                            "long_name" => "CCC ٢-٦-ش۔١۔٢",
                            "description" => "استخدام وسائل آمنة لتصدير ونقل البيانات والبنية التحتية الافتراضية.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٦-ش۔١۔٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]
                ],

                [
                    "short_name" => "CCC ٢-٧-م-١",
                    "long_name" => "CCC ٢-٧-م-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط 7-8-7 في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بالتشفير لدى مقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-٧-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cryptography'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-٧-م-١-١",
                            "long_name" => "CCC ٢-٧-م-١-١",
                            "description" => "لالتزام باستخدام طرق وخوارزميات ومفاتيح وأجهزة تشفير محدثة وآمنة.\r\nوفقا للمستوى المتقدم (ععصة٧4ه)‏ ضمن المعايير الوطنية للتشفير",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٧-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cryptography'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٧-م-١۔٢",
                            "long_name" => "CCC ٢-٧-م-١۔٢",
                            "description" => "لقدرة على إصدار شهادات رقمية وإدارتها بطرق آمنة. أو استخدام شهادات\r\nرقمية صادرة من جهات موثوقة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٧-م-١۔٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cryptography'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]
                ],
                [
                    "short_name" => "CCC ٢-٧-ش-١",
                    "long_name" => "CCC ٢-٧-ش-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-٨-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بالتشفير لدى المشتركين",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-٧-ش-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cryptography'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-٧-ش۔١-١",
                            "long_name" => "CCC ٢-٧-ش۔١-١",
                            "description" => "الالتزام باستخدام طرق وخوارزميات ومفاتيح وأجهزة تشفير محدثة وآمنة.\r\nوفقا للمستوى المتقدم (لععصه٧4ه)‏ ضمن المعايير الوطنية للتشفير",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٧-ش۔١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cryptography'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٧-ش۔١۔٢",
                            "long_name" => "CCC ٢-٧-ش۔١۔٢",
                            "description" => "تشفير البيانات والمعلومات المنقولة إلى الخدمات السحابية. أو المنقولة منها!\r\nبحسب المتطلبات التشريعية والتنظيمية ذات العلاقة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٧-ش۔١۔٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cryptography'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]
                ],
                [
                    "short_name" => "CCC ٢-٨-م-١",
                    "long_name" => "CCC ٢-٨-م-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بإدارة النسخ الاحتياطية لدى مقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-٨-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-٨-م-١-١",
                            "long_name" => "CCC ٢-٨-م-١-١",
                            "description" => "تأمين الوصول\" والتخزين\" والنقل لمحتوى النسخ الاحتياطية لبيانات المشترك\r\nووسائطهاء وحمايتها من الإتلاف. أو التعديل. أو الاطلاع غير المصرح به",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٨-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٨-م-١۔٢",
                            "long_name" => "CCC ٢-٨-م-١۔٢",
                            "description" => "أمين الوصول\" والتخزين\" والنقل لمحتوى النسخ الاحتياطية للأنظمة التقنية\r\nالسحابية (015)؛ ووسائطها. وحمايتها من الإتلاف. أو التعديل. أو الاطلاع غير\r\nالمصرح به",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٨-م-١۔٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]
                ],
                [
                    "short_name" => "CCC ٢-٩-م-١",
                    "long_name" => "CCC ٢-٩-م-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-١٠-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بإدارة الثغرات لدى مقدمي الخدمات\"",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-٩-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-٩-م-١-١",
                            "long_name" => "CCC ٢-٩-م-١-١",
                            "description" => "تقييم ومعالجة الثغرات لمكونات الأنظمة التقنية السحابية (015) الخارجية\r\nمرة واحدة شهريا على الأقل. وكل ثلاثة أشهر على الأقل لمكونات الأنظمة\r\nالتقنية السحابية (015) الداخلية.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٩-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٩-م-١-٢",
                            "long_name" => "CCC ٢-٩-م-١-٢",
                            "description" => "إشعار المشترك بالثغرات المكتشفة التي قد تؤثر عليه. وكيفية معالجتها",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٩-م-١-٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]

                ],
                [
                    "short_name" => "CCC ٢-٩-ش-١",
                    "long_name" => "CCC ٢-٩-ش-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-١٠-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بإدارة الثغرات لدى المشتركين",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-٩-ش-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-٩-ش-١-١",
                            "long_name" => "CCC ٢-٩-ش-١-١",
                            "description" => "تقييم ومعالجة الثغرات الخاصة بالخدمات السحابية مرة واحدة كل ثلاثة أشهر\r\nعلى الأقل.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٩-ش-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-٩-ش۔١۔٢",
                            "long_name" => "CCC ٢-٩-ش۔١۔٢",
                            "description" => "إدارة الثغرات التي تم إشعار المشترك بها عن طريق مقدم الخدمة. ومعالجتها",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٩-ش۔١۔٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]
                ],

                [
                    "short_name" => "CCC ٢-١٠-م-١",
                    "long_name" => "CCC ٢-١٠-م-١",
                    "description" => "الإضافة للضوابط الفرعية ضمن الضابط ‎٣-١١-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب\r\nأن تغطي متطلبات الأمن السيبراني الخاصة باختبار الاختراق لدى مقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٠-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Penetration Testing'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-١٠-م-١-١",
                            "long_name" => "CCC ٢-١٠-م-١-١",
                            "description" => "يجب أن يشمل نطاق عمل اختبار الاختراق الأنظمة التقنية السحابية (015)»\r\nوأن يتم عمل اختبار الاختراق كل ستة أشهر؛ على الأقل.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٠-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Penetration Testing'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],
                [
                    "short_name" => "CCC ٢-١١-م-١",
                    "long_name" => "CCC ٢-١١-م-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-١٢-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب\r\n\r\nأن تغطي متطلبات الأمن السيبراني لإدارة سجلات الأحداث ومراقبة الأمن السيبراني لدى مقدمي\r\nالخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١١-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [


                        [
                            "short_name" => "CCC ٢-١١-م-١-١",
                            "long_name" => "CCC ٢-١١-م-١-١",
                            "description" => "تفعيل وحماية سجلات الأحداث ‎1٥8(‏ اصعءع) والتدقيق للف انهنه)\r\nللأنظمة التقنية السحابية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١١-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-١١-م-١-٢",
                            "long_name" => "CCC ٢-١١-م-١-٢",
                            "description" => "تفعيل سجلات الأحداث الخاصة محاولات عمليات الدخول (صنع10) وجمعها.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١١-م-١-٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-١١-م-١-٣",
                            "long_name" => "CCC ٢-١١-م-١-٣",
                            "description" => "تفعيل وحماية سجلات الأحداث لجميع الأنشطة والعمليات التي يقوم بها\r\nمقدم الخدمة على أنظمة المشتركين. بهدف دعم عمليات التحليل الرقمي\r\nالجناني",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١١-م-١-٣",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-١١-م-١-٤",
                            "long_name" => "CCC ٢-١١-م-١-٤",
                            "description" => "حماية سجلات الأحداث (1088 صءه2) الخاصة بالأمن السيبراني. من الوصول\r\nغير المصرح به. أو العبث. أو التغيير. أو الحذف غير المشروع. وذلك وفقا\r\nللمتطلبات التشريعية. أو التنظيمية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١١-م-١-٤",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-١١۔م-١-٥",
                            "long_name" => "CCC ٢-١١۔م-١-٥",
                            "description" => "للمراقبة الأمنية المستمرة لأحداث الأمن السييراني )ص رح(\r\nباستخدام تقنيات (51814) بحيث تشمل جميع الأحداث المتعلقة بالأنظمة\r\nالتقنية السحابية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١١۔م-١-٥",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-١١۔م-١-٦",
                            "long_name" => "CCC ٢-١١۔م-١-٦",
                            "description" => "المراجعة الدورية لسجلات الأحداث (1685 27604) والتدقيق (لنهع7 نهسه)\r\nبحيث تشمل الأحداث والسجلات المتعلقة بالأنظمة التقنية السحابية (75©)»\r\nالتي تم تنفيذها من قبل مقدم الخدمة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١١۔م-١-٦",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-١١۔م-١-٧",
                            "long_name" => "CCC ٢-١١۔م-١-٧",
                            "description" => "ستخدام وسائل آلية لمراقبة سجلات الأحداث الخاصة بعمليات الدخول",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١١۔م-١-٧",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-١١۔م-١-٨‏",
                            "long_name" => "CCC ٢-١١۔م-١-٨‏",
                            "description" => "تعامل الآمن مع بيانات المستخدمين المتواجدة في سجلات الأحداث\r\n‎]Logs Events Cybersecurity. والتدقيق (فلنه 1 انهنه) وسجلات أحداث الأمن السيبراني",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١١۔م-١-٨‏",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],


                    ]
                ],
                [
                    "short_name" => "CCC ٢-١١-ش-١",
                    "long_name" => "CCC ٢-١١-ش-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-١٢-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني لإدارة سجلات الأحداث ومراقبة الأمن السيبراني لدى المشتركين",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١١-ش-١",
                    "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-١١-ش-١-١",
                            "long_name" => "CCC ٢-١١-ش-١-١",
                            "description" => "تفعيل وجمع سجلات الأحداث الخاصة بعمليات الدخول (صنهه])» وسجلات\r\nالأحداث الخاصة بالأمن السيبراني على الأصول المتعلقة بالخدمات السحابية.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١١-ش-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-١١-ش۔١۔٢",
                            "long_name" => "CCC ٢-١١-ش۔١۔٢",
                            "description" => "أن تشمل عملية المراقبة جميع الأحداث أحداث الأمن السيبراني المفعلة على\r\nالخدمات السحابية الخاصة بالمشترك",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١١-ش۔١۔٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ],
                ],

                [
                    "short_name" => "CCC ٢-١٢-م-١",
                    "long_name" => "CCC ٢-١٢-م-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-١٣-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني لإدارة حوادث وتهديدات الأمن السيبراني لدى مقدمي الخدمات.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٢-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-١٢-م-١-1",
                            "long_name" => "CCC ٢-١٢-م-١-1",
                            "description" => "الاشتراك مع المجموعات والجهات المتخصصة والموثوقة للحصول على آخر\r\nالتهديدات والمستجدات في مجال الأمن السيبراني",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٢-م-١-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-١٢-م-١-2",
                            "long_name" => "CCC ٢-١٢-م-١-2",
                            "description" => "تدريب العاملين (موظفين ومتعاقدين) على الاستجابة لحوادث الأمن السيبراني\r\nيما يتماثى مع الأدوار والمسؤوليات",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٢-م-١-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-١٢-م-١-3",
                            "long_name" => "CCC ٢-١٢-م-١-3",
                            "description" => "اختبار قدرات الاستجابة لحوادث الأمن السيبراني دوريًا",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٢-م-١-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-١٢-م-١-4",
                            "long_name" => "CCC ٢-١٢-م-١-4",
                            "description" => "تحليل وتحديد الأسباب الجذرية (و¡درلةمه عقنة0 ٥0ع)‏ لحوادث الأمن\r\nالسيبراني. ووضع الخطط الكفيلة بمعالجتها.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٢-م-١-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-١٢-م-١-5",
                            "long_name" => "CCC ٢-١٢-م-١-5",
                            "description" => "تقديم الدعم إلى المشتركين في حالات القضايا القانونية. والتحليل الرقمي الجناني.\r\nوالحفاظ على الأدلة الرقمية التي تقع تحت إدارة ومسؤولية مقدم الخدمة\r\nحسب المتطلبات التشريعية والتنظيمية ذات العلاقة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٢-م-١-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-١٢-م-١-6",
                            "long_name" => "CCC ٢-١٢-م-١-6",
                            "description" => "تبليغ المشترك بشكل فوري عن حوادث الأمن السيبراني التي قد تؤثر عليه. في\r\nحال اكتشاف الحادثة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٢-م-١-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-٢١-م-١-٧",
                            "long_name" => "CCC ٢-٢١-م-١-٧",
                            "description" => "دعم المشتركين للتعامل مع حوادث الأمن السيبراني حسب الاتفاقية مابين مقدم\r\nالخدمة والمشترك.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-٢١-م-١-٧",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-١٢-م-١-8",
                            "long_name" => "CCC ٢-١٢-م-١-8",
                            "description" => "قياس ومراقبة مؤشرات الأداء الخاصة بإدارة حوادث الأمن السيراني. ومراقبة\r\nمدى الالتزام بمتطلبات العقود والتشريعات",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٢-م-١-8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ],
                ],
                [
                    "short_name" => "CCC ٢-١٣-م-1",
                    "long_name" => "CCC ٢-١٣-م-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-١٤-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بالأمن المادي لدى مقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٣-م-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-١٣-م-١-١",
                            "long_name" => "CCC ٢-١٣-م-١-١",
                            "description" => "للمراقبة المستمرة لعمليات الدخول والخروج للمباني والمواقع لدى مقدم الخدمة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٣-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-١٣-م-١-٢",
                            "long_name" => "CCC ٢-١٣-م-١-٢",
                            "description" => "منع الوصول غير المصرح به للأجهزة التي تتعامل مباشرة مع الأنظمة التقنية\r\nالسحابية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٣-م-١-٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-١٣-م-١-٣",
                            "long_name" => "CCC ٢-١٣-م-١-٣",
                            "description" => "التخلص الآمن من أجهزة البنية التحتية )4 «\r\n) باتباع أفضل الممارسات\r\nوالتشريعات ذات العلاقة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٣-م-١-٣",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]
                ],

                [
                    "short_name" => "CCC ٢-١٤-م-١",
                    "long_name" => "CCC ٢-١٤-م-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-١٥-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بحماية تطبيقات الويب لدى مقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٤-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Web Application Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-١٤-م-١-١",
                            "long_name" => "CCC ٢-١٤-م-١-١",
                            "description" => "حماية المعلومات المستخدمة في إجراء المعاملات عن طريق تطبيقات الويب\r\nمن المخاطر المحتملة. مثل => انقطاع الاتصال )ممن «\r\nالتوجيه الخاطئ (ع018-20010). التعديل غير المصرح به. الاطلاع غير المصرح\r\nبه.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٤-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Web Application Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],


                    ]

                ],
                [
                    "short_name" => "CCC ٢-١٥-م-١",
                    "long_name" => "CCC ٢-١٥-م-١",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الأمن السيبراني. الخاصة بعملية إدارة المفاتيح لدى\r\nمقدمي الخدمات.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٥-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Key management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "CCC ٢-١٥-م-٢",
                    "long_name" => "CCC ٢-١٥-م-٢",
                    "description" => "يجب تطبيق متطلبات الأمن السيبراني. الخاصة بعملية إدارة المفاتيح لدى مقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٥-م-٢",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Key management'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "CCC ٢-١٥-م-٣",
                    "long_name" => "CCC ٢-١٥-م-٣",
                    "description" => "الإضافة للضابط ‎٢-٢-٨-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي متطلبات الأمن\r\nالسيبراني الخاصة بعملية إدارة المفاتيح لدى مقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٥-م-٣",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Key management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-١٥-م-٣-١",
                            "long_name" => "CCC ٢-١٥-م-٣-١",
                            "description" => "تحديد ملاك مفاتيح التشفير",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٥-م-٣-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Key management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-١٥-م-٣-2",
                            "long_name" => "CCC ٢-١٥-م-٣-2",
                            "description" => "جود آلية آمنة لاسترجاع مفاتيح التشفير في حال فقدانها مثل => (نسخها احتياطيًا\r\nوتخزينها بطرق آمنة خارج الأنظمة السحابية).",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٥-م-٣-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Key management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [

                            "short_name" => "CCC ٢-١٥-م-٣-3",
                            "long_name" => "CCC ٢-١٥-م-٣-3",
                            "description" => "تفعيل سجلات الأحداث المتعلقة بمفاتيح التشفير. ومراقبتها",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٥-م-٣-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Key management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],

                    ]
                ],
                [

                    "short_name" => "CCC ٢-١٥-م-٤",
                    "long_name" => "CCC ٢-١٥-م-٤",
                    "description" => "يجب مراجعة متطلبات الأمن السيبراني. الخاصة بإدارة المفاتيح لدى مقدمي الخدمات. ومراجعة\r\nتطبيقها دوريا",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٥-م-٤",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Key management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "CCC ٢-١٥-ش-١",
                    "long_name" => "CCC ٢-١٥-ش-١",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الأمن السيبراني. الخاصة بإدارة المفاتيح لدى المشتركين.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٥-ش-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Key management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "CCC ٢-١٥-ش-٢",
                    "long_name" => "CCC ٢-١٥-ش-٢",
                    "description" => "يجب تطبيق متطلبات الأمن السييراني. الخاصة بإدارة المفاتيح لدى المشتركين.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٥-ش-٢",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Key management'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "CCC ٢-١٥-ش-3",
                    "long_name" => "CCC ٢-١٥-ش-3",
                    "description" => "بالإضافة للضابط ‎٢-٢-٨-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي متطلبات الأمن\r\nالسيبراني. الخاصة بعملية إدارة المفاتيح لدى المشتركين",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٥-ش-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Key management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-١٥-ش-٣-١",
                            "long_name" => "CCC ٢-١٥-ش-٣-١",
                            "description" => "تحديد ملاك مفاتيح التشفير",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٥-ش-٣-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Key management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-١٥-ش-٣-٢",
                            "long_name" => "CCC ٢-١٥-ش-٣-٢",
                            "description" => "وجود آلية آمنة لاسترجاع مفاتيح التشفير في حال فقدانها مثل => (نسخها احتياطيا\r\nوتخزينها بطرق آمنة خارج الأنظمة السحابية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٥-ش-٣-٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Key management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]
                ],


                [
                    "short_name" => "CCC ٢-١٥-ش-٤",
                    "long_name" => "CCC ٢-١٥-ش-٤",
                    "description" => "يجب مراجعة متطلبات الأمن السيبراني الخاصة بإدارة المفاتيح لدى المشتركين. ومراجعة تطبييقهاء\r\nدوريا.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٥-ش-٤",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Key management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "CCC ٢-١٦-م-١",
                    "long_name" => "CCC ٢-١٦-م-١",
                    "description" => "يجب تحديد متطلبات الأمن السيبراني لتطوير الأنظمة لدى مقدمي الخدمات. وتوثيقها\r\nواعتمادها.\r\nيجب تطبي",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٦-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('System Development Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "CCC ٢-١٦-م-٢",
                    "long_name" => "CCC ٢-١٦-م-٢",
                    "description" => "يجب تطبيق متطلبات الأمن السيبراني لتطوير الأنظمة لدى مقدمي الخدمات.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٦-م-٢",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('System Development Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "CCC ٢-١٦-م-٣",
                    "long_name" => "CCC ٢-١٦-م-٣",
                    "description" => "يجب أن تغطي متطلبات الأمن السيبراني لتطوير الأنظمة لدى مقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٦-م-٣",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('System Development Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-١٦-م-٣-١",
                            "long_name" => "CCC ٢-١٦-م-٣-١",
                            "description" => "أخذ متطلبات الأمن السيبراني (للأنظمة التقنية السحابية (015) والأنظمة\r\nذات العلاقة) بالاعتبار عند تصميم وتطوير خدمات الحوسبة السحابية.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٦-م-٣-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('System Development Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC ٢-١٦-م-٣-٢",
                            "long_name" => "CCC ٢-١٦-م-٣-٢",
                            "description" => "حماية بيئات للتطوير )ents Development ) والاختبار\r\n)ن منعآ) وماتحويه من بيانات. ومنصات التكامل",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٦-م-٣-٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('System Development Security'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]
                ],

                [
                    "short_name" => "CCC ٢-١٦-م-4",
                    "long_name" => "CCC ٢-١٦-م-4",
                    "description" => "يجب مراجعة متطلبات الأمن السيبراني لتطوير الأنظمة لدى مقدمي الخدمات. ومراجعة\r\nتطبيقها. دوريا",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٦-م-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('System Development Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "CCC ٢-١٧-م-١",
                    "long_name" => "CCC ٢-١٧-م-١",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الأمن السيبراني لاستخدام وسائط المعلومات والبيانات\r\nالمادية لدى مقدمي الخدمات.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٧-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Storage Media Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "CCC ٢-١٧-م-٢",
                    "long_name" => "CCC ٢-١٧-م-٢",
                    "description" => "يجب تطبيق متطلبات الأمن السيبراني لاستخدام وسائط المعلومات والبيانات المادية لدى\r\nمقدمي الخدمات.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٧-م-٢",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Storage Media Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "CCC ٢-١٧-م-٣",
                    "long_name" => "CCC ٢-١٧-م-٣",
                    "description" => "متطلبات الأمن السيبراني لاستخدام وسائط المعلومات والبيانات المادية لدى مقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٧-م-٣",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Storage Media Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٢-١٧-م-٣-١",
                            "long_name" => "CCC ٢-١٧-م-٣-١",
                            "description" => "يجب التأكد من عدم احتواء الوسائط على أية بيانات أو معلومات. قبل إعادة\r\nاستخدام الوسائط أو التخلص منها.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٧-م-٣-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Storage Media Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-١٧-م-٣-٢",
                            "long_name" => "CCC ٢-١٧-م-٣-٢",
                            "description" => "يجب استخدام وسائل آمنة عند التخلص من الوسائط",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٧-م-٣-٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Storage Media Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-١٧-م-٣-٣",
                            "long_name" => "CCC ٢-١٧-م-٣-٣",
                            "description" => "الحفاظ على سرية وسلامة البيانات على أجهزة وسائط التخزين الخارجية.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٧-م-٣-٣",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Storage Media Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-١٧-م-٣-٤",
                            "long_name" => "CCC ٢-١٧-م-٣-٤",
                            "description" => "وضع ترميز أو علامة (ع«نلكه1) مقروءة على الوسائط توضح تصنيفها ومدى\r\nحساسية المعلومات والبيانات التي تحتويها.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٧-م-٣-٤",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Storage Media Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-١٧-م-٣-٥",
                            "long_name" => "CCC ٢-١٧-م-٣-٥",
                            "description" => "الحفظ الآمن لأجهزة وسائط التخزين الخارجية.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٧-م-٣-٥",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Storage Media Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٢-١٧-م-٣-٦",
                            "long_name" => "CCC ٢-١٧-م-٣-٦",
                            "description" => "لتقييد الحازم لاستخدام وسائط التخزين الخارجية على الأنظمة التقنية\r\nالسحابية",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٢-١٧-م-٣-٦",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Storage Media Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "CCC ٢-١٧-م-٤",
                    "long_name" => "CCC ٢-١٧-م-٤",
                    "description" => "يجب مراجعة متطلبات الأمن السيبراني لاستخدام وسائط المعلومات والبيانات المادية لدى\r\nمقدمي الخدمات\" ومراجعة تطبيقها دوريا.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٢-١٧-م-٤",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Storage Media Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "CCC ٣-١-م-١",
                    "long_name" => "CCC ٣-١-م-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-١-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني لجوانب صمود الأمن السيبراني في إدارة استمرارية الأعمال لدى\r\nمقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٣-١-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٣-١-م-١-١",
                            "long_name" => "CCC ٣-١-م-١-١",
                            "description" => "تطوير وتنفيذ إجراءات التعافي من الكوارث واستمرارية الأعمال بصورة آمنة",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٣-١-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٣-١-م-١-٢",
                            "long_name" => "CCC ٣-١-م-١-٢",
                            "description" => "تطوير وتنفيذ إجراءات لضمان صمود واستمرارية أنظمة الأمن السيبراني\r\nالمخصصة لحماية الأنظمة التقنية السحابي",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٣-١-م-١-٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "CCC ٣-١-ش-١",
                    "long_name" => "CCC ٣-١-ش-١",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-١-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني لجوانب صمود الأمن السيبراني في إدارة استمرارية الأعمال لدى\r\nا مشتركين",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٣-١-ش-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٣-١-ش-١-١",
                            "long_name" => "CCC ٣-١-ش-١-١",
                            "description" => "تطوير وتنفيذ إجراءات التعافي من الكوارث واستمرارية الأعمال. المتعلقة\r\nبالحوسبة السحابية. بصورة آمنة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٣-١-ش-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "CCC ٤-١-م-١",
                    "long_name" => "CCC ٤-١-م-١",
                    "description" => "بالإضافة إلى تطبيق الضابطين ‎٢-١-٤‏ و ‎٢-١-٤‏ في الضوابط الأساسية للأمن السييراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني المتعلق بالأطراف الخارجية لدى مقدمي الخدمات",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC ٤-١-م-١",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC ٤-١-م-١-١",
                            "long_name" => "CCC ٤-١-م-١-١",
                            "description" => "ضمان تنفيذ مقدم الخدمة لطلبات الهيئة الوطنية للأمن السيبراني الخاصة\r\nبإزالة البرمجيات أو الخدمات المقدمة من أطراف خارجية التي قد تعتبر تهديدا\r\nعلى الأمن السيبراني للجهات الوطنية. من السوق",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٤-١-م-١-١",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٤-١-م-١-٢",
                            "long_name" => "CCC ٤-١-م-١-٢",
                            "description" => "طلب تقديم التوثيق (صمتاها«»«0000) اللازم! فيما يخص الأمن السيبراني؛\r\nلأي معدات أو خدمات مقدمة من الموردين ومقدمي الخدمات من الأطراف\r\nالخارجية.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٤-١-م-١-٢",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٤-١-م-١-٣",
                            "long_name" => "CCC ٤-١-م-١-٣",
                            "description" => "‏ الزام الأطراف الخارجية بالمتطلبات التنظيمية؛ والتشريعية ذات الصلة بنطاق\r\nعملهم.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٤-١-م-١-٣",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CCC ٤-١-م-١-٤",
                            "long_name" => "CCC ٤-١-م-١-٤",
                            "description" => "يجب على الطرف الخارجي إدارة مخاطر الأمن السيبراني الخاصة به.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC ٤-١-م-١-٤",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],
            ];
            foreach ($frameworkControls as $controlData) {
                $this->createControlAndTests($controlData, null, $framework->id);
            }
        });
    }

    private function createControlAndTests($controlData, $parentId = null, $frameworkId)
    {
        // Remove the 'children' key if it exists
        $dataToInsert = $controlData;
        unset($dataToInsert['children']);

        // Remove the 'document' key to avoid the array to string conversion issue
        $documentData = $dataToInsert['document'] ?? []; // Store document data separately
        unset($dataToInsert['document']);

        // Ensure that 'parent_id' is set correctly
        $dataToInsert['parent_id'] = $parentId;
        $dataToInsert['description'] = ['en' => $controlData['description'], 'ar' => $controlData['description']];

        // Log the data to be inserted
        \Log::info('Data to insert:', $dataToInsert);

        // Create or update the FrameworkControl record
        $control = FrameworkControl::create($dataToInsert);

        // Handle associated documents
        if (in_array('install_document', $this->options)) {
            if (isset($documentData) && !empty($documentData)) {
                foreach ($documentData as $docData) {

                    $this->createOrUpdateDocument($docData, $control->id);
                }
            }
        }
        // Create a FrameworkControlTest record associated with the newly created control
        FrameworkControlTest::create([
            "tester" => "1",
            "last_date" => now(),
            "next_date" => now(),
            "name" => $control->short_name,
            "framework_control_id" => $control->id,
        ]);

        // Create a FrameworkControlMapping record for the newly created control
        FrameworkControlMapping::create([
            "framework_control_id" => $control->id,
            "framework_id" => $frameworkId,
        ]);

        // Recursively handle child controls if they exist
        if (isset($controlData['children'])) {
            foreach ($controlData['children'] as $childControlData) {
                $this->createControlAndTests($childControlData, $control->id, $frameworkId);
            }
        }
    }


    private function createOrUpdateDocument($documentData, $controlId)
    {
        if (isset($documentData) && !empty($documentData)) {
            \Log::info('Processing document data:', $documentData);

            $documentName = $documentData['document_name'];
            \Log::info('Document Name:', ['document_name' => $documentName]);

            $document = Document::where('document_name', $documentName)->first();

            if ($document) {
                // Ensure control_ids is a string or an array, depending on your schema
                $existingControlIds = $document->control_ids ? explode(',', $document->control_ids) : [];
                if (!in_array($controlId, $existingControlIds)) {
                    $existingControlIds[] = $controlId;
                }
                \Log::info('Updating document with ID:', ['id' => $document->id, 'control_ids' => $existingControlIds]);
                $document->control_ids = implode(',', $existingControlIds); // Convert back to a string if necessary
                $document->save();
            } else {
                \Log::info('Creating new document with name:', ['document_name' => $documentName]);
                Document::create([
                    'document_type' => $documentData['document_type'],
                    'privacy' => $documentData['privacy'],
                    'document_name' => $documentName,
                    'document_status' => $documentData['document_status'],
                    'creation_date' => $documentData['creation_date'],
                    'last_review_date' => $documentData['last_review_date'],
                    'review_frequency' => $documentData['review_frequency'],
                    'next_review_date' => $documentData['next_review_date'],
                    'control_ids' => implode(',', [$controlId]), // Ensure this is a string if needed
                    'framework_ids' => $documentData['framework_ids'],
                    'document_owner' => $documentData['document_owner'],
                    'additional_stakeholders' => $documentData['additional_stakeholders'],
                    'team_ids' => $documentData['team_ids'],
                    'created_by' => $documentData['created_by']
                ]);
            }
        } else {
            \Log::info('Document data is empty or not set.');
        }
    }


    private function getFamilyIdByName($familyName)
    {
        return Family::where('name', $familyName)->value('id');
    }

    private function getDocumentIdByName($documentTypeName)
    {
        return DocumentTypes::where('name', $documentTypeName)->value('id');
    }

    public function debugOptions()
    {
        return $this->options;
    }
}