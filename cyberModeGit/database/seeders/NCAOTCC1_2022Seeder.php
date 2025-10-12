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

class NCAOTCC1_2022Seeder extends Seeder
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
                'name' => 'NCA-OTCC-1:2022',
                'description' => "In continuation of its role in regulating and protecting the Kingdom's cyberspace, and in line with the Kingdom’s Vision 2030, NCA publishes the Operational Technology Cybersecurity Controls (OTCC-1:2022). These controls are aligned with related international cybersecurity standards, frameworks, controls, and best practices.
    
                The controls aim to raise the cybersecurity level of OT systems in the Kingdom by setting the minimum cybersecurity requirements for organizations to protect their Industrial Control systems (ICS) from cyber threats that could result in negative impacts. These controls are an extension to the NCA’s Essential Cybersecurity Controls (ECC).",
                'icon' => 'fa-upload',
                'status' => '1',
                'regulator_id' => $this->regulatorId,

            ]);


            // Main domains with their subdomains
            $mainDomains = [
                [
                    'name' => 'Cybersecurity Governance',
                    'order' => '1',
                    'subdomains' => [

                        ['name' => 'Cybersecurity Policies and Procedures', 'order' => '3'],
                        ['name' => 'Cybersecurity Role and Responsibilities', 'order' => '4'],
                        ['name' => 'Cybersecurity Risk Management', 'order' => '5'],
                        ['name' => 'Cybersecurity in Information Technology Projects', 'order' => '6'],
                        ['name' => 'Cybersecurity Periodical Assessment and Audit', 'order' => '8'],
                        ['name' => 'Cybersecurity in Human Resources', 'order' => '9'],
                        ['name' => 'Cybersecurity Awareness and Training Program', 'order' => '10'],
                        ['name' => 'Management Change in Cybersecurity', 'order' => '11',]
                    ]
                ],
                [
                    'name' => 'Cybersecurity Defense',
                    'order' => '2',
                    'subdomains' => [
                        ['name' => 'Asset Management', 'order' => '1'],
                        ['name' => 'Identity and Access Management', 'order' => '2'],
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
                        [
                            'name' => 'Facility Processing and System Protection',
                            'order' => '20',
                        ],
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
                    "short_name" => "OTCC 1-1-1",
                    "long_name" => "OTCC 1-1-1",
                    "description" => "رجوعاً للضابطين 1-3-1 و 1-3-2 في الضوابط الاساسية الامن السيرباني؛\r\nيجب على الجهة توثيق مجموعة من سياسات وإجراءات الامن السيرباني\r\nالمخصصة أالنظمة التحكم الصناعي )ICS\/OT )واعتامدها وتطبيقها .",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Policies and Procedures'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [

                    "short_name" => "OTCC 1-1-2",
                    "long_name" => "OTCC 1-1-2",
                    "description" => "رجوعاً للضابط 1-3-3 يف الضوابط الاساسية للامن السيرباني؛ يجب أن تكون\r\nسياسات وإجراءات الامن السيرباني انظمة التحكم الصناعي )ICS\/OT )\r\nمدعومة مبتطلبات ومعايري الامن السيرباني والمتطلبات التقنية ذات العلاقة.\r\n)مثل => توصيات الجهة المصنعة، إرشادات التطبيق والتنفيذ، إرشادات إدارة\r\nالاعدادات(.",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Policies and Procedures'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [

                    "short_name" => "OTCC 1-1-3",
                    "long_name" => "OTCC 1-1-3",
                    "description" => "رجوعاً للضابط 1-3-4 يف الضوابط الاساسيةللامن السيرباني؛ يجب مراجعة\r\nسياسات وإجراءات الامن السيرباني أنظمة التحكم الصناعي )ICS\/OT )\r\nدوريا، أو عند حدوث تغيريات تؤثر عىل أمن وسلامة أنظمة التحكم\r\nالصناعي )ICS\/OT( .)مثل => حدوث تغيريات في مستوى وطبيعة المخاطر،\r\nأو تغيري يف الهيكل التنظيمي للجهة، أو تغريات في العمليات والاجراءات\r\nالتشغيلية(.",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-1-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Policies and Procedures'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],


                [

                    "short_name" => "OTCC 1-2-1",
                    "long_name" => "OTCC 1-2-1",
                    "description" => "الاضافة للضوابط ضمن المكون الفرعي 1-4 في الضوابط الاساسية للامن\r\nالسيرباني؛ يجب أن تغطي متطلبات الامن السيرباني المتعلقة بأدوار\r\nومسؤوليات الامن السيرباني في بيئة أنظمة التحكم الصناعي )ICS\/OT )",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Role and Responsibilities'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "OTCC 1-2-1-1",
                            "long_name" => "OTCC 1-2-1-1",
                            "description" => "يجب على صاحب الصلاحية، تحديد الادوار والمسؤوليات الخاصة\r\nبالامن السيرباني )RACI )وتوثيقها واعتامدها لجميع أصحاب المصلحة\r\nالمعنيني بأنظمة التحكم الصناعي )ICS\/OT ،)مع الاخذ في الحسبان عدم\r\nتعارض المصالح",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-2-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Role and Responsibilities'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "OTCC 1-2-1-2",
                            "long_name" => "OTCC 1-2-1-2",
                            "description" => "يجب إسناد أدوار الامن السيرباني ومسؤولياته المتعلقة بأنظمة\r\nالتحكم الصناعي )ICS\/OT )لإلدارة المعنية بالامن السيرباني لدى الجهة؛\r\nمع الاخذ في الحسبان عدم تعارض المصالح.\r\n1-3 إدارة مخاطر الامن السيرباني )Manage",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-2-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Role and Responsibilities'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],

                    ],

                ],

                [

                    "short_name" => "OTCC 1-3-1",
                    "long_name" => "OTCC 1-3-1",
                    "description" => "الاضافة للضوابط ضمن المكون الفرعي 1-5 في الضوابط الاساسية الامن\r\nالسيرباني؛ يجب أن تغطي متطلبات إدارة مخاطر الامن السيرباني المتعلقة\r\nبأنظمة التحكم الصناعي )ICS\/OT",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-3-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "OTCC 1-3-1-1",
                            "long_name" => "OTCC 1-3-1-1",
                            "description" => "وضع منهجية مخاطر الامن السيرباني، المتعلقة بأنظمة التحكم\r\nالصناعي )ICS\/OT )ضمن منهجية إدارة المخاطر و إدارة مخاطر السالمة\r\nوإجراءاتها في الجهة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-3-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "OTCC 1-3-1-2",
                            "long_name" => "OTCC 1-3-1-2",
                            "description" => "يجب تقييم مخاطر الامن السيرباني،لانظمة التحكم الصناعي\r\n)ICS\/OT )بشكل دوري، مع التأكد من تضمني مخاطر توقيع العقود\r\nوالاتفاقيات، مع الاطراف الخارجية المتعلقة بأنظمة التحكم الصناعي\r\n)ICS\/OT )و\/أو عند حدوث تغيريات باملتطلبات الترشيعية والتنظيمية،\r\nذات العلاقة بوصفها جزء من التقييم",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-3-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "OTCC 1-3-1-3",
                            "long_name" => "OTCC 1-3-1-3",
                            "description" => "تضمني سجل مخاطر الامن السيرباني، المتعلقة بأنظمة التحكم\r\nالصناعي )ICS\/OT )ضمن سجل المخاطر في الجهة.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-3-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "OTCC 1-3-1-4",
                            "long_name" => "OTCC 1-3-1-4",
                            "description" => "تحديد المستويات الملائمة للمناطق، والمرافق التي تحتوي على\r\nً على منهجية معتمدة.\r\nأنظمة التحكم الصناعي )ICS\/OT",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-3-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "OTCC 1-3-1-5",
                            "long_name" => "OTCC 1-3-1-5",
                            "description" => "تضمني تحليل نوعي )Analysis Qualitative )مخاطر الامن\r\nالسيرباني، ضمن إجراءات تحليل مخاطر العمليات )Hazard Process\r\nAnalysis )الذي يطبق قبل أي تغيري في العمليات أو إجراءاتها في المصانع",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-3-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "OTCC 1-3-1-6",
                            "long_name" => "OTCC 1-3-1-6",
                            "description" => "في حال عدم التمكن من استيفاء متطلبات الامن السيرباني\r\nداخل البيئة الخاصة بأنظمة التحكم الصناعي )ICS\/OT ،)فيجب توضيح\r\nالمربرات الالزمة، مع توثيقها واعتامدها من قبل الجهة المعنية بالامن\r\nالسيرباني، وموافقة صاحب الصلاحية",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-3-1-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "OTCC 1-3-1-7",
                            "long_name" => "OTCC 1-3-1-7",
                            "description" => "في حال الموافقة عىل قبول المخاطر السيربانية؛ فيجب تحديد\r\nالضوابط البديلة لها مع توثيقها، واعتامدها من قبل صاحب الصلاحية؛\r\nمع التأكد من تطبيقها بفعالية في وقت محدد، مع الاستمرار في تقييم تلك\r\nالمخاطر ومراجعتها بشكل مستمر",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-3-1-7",
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
                    "short_name" => "OTCC 1-4-1",
                    "long_name" => "OTCC 1-4-1",
                    "description" => "بالاضافة للضوابط الفرعية ضمن الضابطين 1-6-2 و 1-6-3 من الضوابط\r\nالاساسية للامن السيرباين؛ يجب أن تغطي متطلبات الامن السيرباني ضمن\r\nإدارة مشاريع أنظمة التحكم الصناعي )ICS\/OT )",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-4-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "OTCC 1-4-1-1",
                            "long_name" => "OTCC 1-4-1-1",
                            "description" => "تضمني متطلبات الامن السيرباني بوصفه جزء من دورة حياة\r\nاملشاريع المتعلقة بأنظمة التحكم الصناعي )ICS\/OT.)",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-4-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "OTCC 1-4-1-2",
                            "long_name" => "OTCC 1-4-1-2",
                            "description" => "تضمني متطلبات الامن السيرباني ضمن اختبارات القبول\r\n)Test Acceptance )وعمليات التقييم )Process Evaluation .)مثل:\r\nاختبارات قبول المصنع ))FAT (Tests Acceptance Factory )واختبارات\r\nالقبول الميداين ))SAT (Tests Acceptance Site )واختبارات التشغيل\r\n)Tests Commissioning )واختبارات التغيري )Tests Change )\r\nواختبارات التكامل )Tests Integration )ومراجعة الشفرة المصدرية\r\n)Review Code Source.)",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-4-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "OTCC 1-4-1-3",
                            "long_name" => "OTCC 1-4-1-3",
                            "description" => "تضمني مبدأ الامن من خلال التصميم )Design-By-Secure ) بوصفه جزء من الامن المعامري لتصميم البيئة الخاصة بأنظمة التحكم الصناعي )ICS\/OT.)",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-4-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "OTCC 1-4-1-4",
                            "long_name" => "OTCC 1-4-1-4",
                            "description" => "حامية الانظمة في البيئة التطويرية )Development\r\nEnvironment ،)وتشمل بيئات الاختبار)Environment Testing )\r\nوالمنصات التكاملية )Platforms Integration.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-4-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ],

                ],

                [
                    "short_name" => "OTCC 1-4-2",
                    "long_name" => "OTCC 1-4-2",
                    "description" => "جب مراجعة متطلبات الامن السيرباني، ضمن إدارة مشاريع أنظمة التحكم\r\n1-4-2 الصناعي )ICS\/OT )وقياس فعالية تطبيقها وتقييمها دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-4-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "OTCC 1-5-1",
                    "long_name" => "OTCC 1-5-1",
                    "description" => "‏يجب تحديد متطلبات الأمن السيبراني وتوثيقها واعتمادها. ضمن إدارة\r\nالتغيير لدى الجهة. ويجب التأكد من أن متطلبات الأمن السيبراني تمثل\r\nجزءًا لا يتجزأ من المتطلبات الأساسية لإدارة التغيير لأنظمة التحكم\r\nالصناعي (07\/168)",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-5-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [
                    "short_name" => "OTCC 1-5-2",
                    "long_name" => "OTCC 1-5-2",
                    "description" => "‏يجب تطبيق متطلبات الأمن السيبراني ضمن دورة حياة إدارة التغيير.\r\nالمتعلقة بأنظمة التحكم الصناعي (01\/105) لدى الجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-5-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "OTCC 1-5-3",
                    "long_name" => "OTCC 1-5-3",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابطين ‎٢-٦-١‏ و ‎٣-٦-١‏ في الضوابط\r\nالأساسية للأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني. ضمن\r\nإدارة التغيير لأنظمة التحكم الصناعي (07\/108)",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-5-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "OTCC 1-5-3-1",
                            "long_name" => "OTCC 1-5-3-1",
                            "description" => "تضمين متطلبات الأمن السيبراني بوصفها جزء من دورة حياة\r\nإدارة التغيير.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-5-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "OTCC 1-5-3-2",
                            "long_name" => "OTCC 1-5-3-2",
                            "description" => "التحقق من صحة وسلامة التغييرات في بي\r\nعلى بيئة النتاج )",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-5-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "OTCC 1-5-3-3",
                            "long_name" => "OTCC 1-5-3-3",
                            "description" => "التحقق من كفاءة متطلبات الأمن السيبراني لأنظمة التحكم\r\nالصناعي (07\/15) في حال استبدالها بأجهزة مماثلة لها. سواء أكان ذلك\r\nفي بيئات التصاميم؛ أم الاختبارات. أو التشغيلية. للتأكد من سلامتها. وذلك\r\nقبل تطبيقها في بيئة الإنتاج. أو البينة التشغيلية",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-5-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "OTCC 1-5-3-4",
                            "long_name" => "OTCC 1-5-3-4",
                            "description" => "تطبيق إجراءات مقيدة. وآمنة للتغييرات الاستثنائية",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-5-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "OTCC 1-5-3-5",
                            "long_name" => "OTCC 1-5-3-5",
                            "description" => "(‏تطبيق آلية أتمتة الإعدادات ))Configuration Automated\r\n‏وآلية كشف التغييرات بالأصول )مع ح عع)۔‎",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-5-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ],


                ],

                [
                    "short_name" => "OTCC 1-5-4",
                    "long_name" => "OTCC 1-5-4",
                    "description" => "‏يجب مراجعة متطلبات الأمن السيراني. ضمن إدارة التغيير المتعلقة بأنظمة\r\nالتحكم الصناعي (01\/108) و قياس فعالية تطبيقها وتقييمها دورا.",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-5-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "OTCC 1-6-1",
                    "long_name" => "OTCC 1-6-1",
                    "description" => "‏رجوعا للضابط ‎٢-٨-١‏ في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nتطبيق ضوابط الآمن السيبراني للأنظمة التشغيلية (2022 :0106-1) من\r\nقبل أطراف مستقلة عن الإدارة المعنية بالأمن السيبراني في الجهة. وذلك مرة\r\nواحدة كل سنويا على الأقل",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-6-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Periodical Assessment and Audit'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "OTCC 1-6-2",
                    "long_name" => "OTCC 1-6-2",
                    "description" => "‏رجوعا للضابط ‎٢-٨-١‏ في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nتطبيق ضوابط الآمن السيبراني للأنظمة التشغيلية (2022 :0106-1) من\r\nقبل أطراف مستقلة عن الإدارة المعنية بالأمن السيبراني في الجهة. وذلك مرة\r\nواحدة كل ثلاث سنوات على الأقل",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-6-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Periodical Assessment and Audit'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [
                    "short_name" => "OTCC 1-7-1",
                    "long_name" => "OTCC 1-7-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-٢-١‏ في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني. المتعلقة بالموارد البشرية\r\nلأنظمة التحكم الصناعي (07\/165©). بحد أدنى؛ إجراء عمل مسح أمني\r\n)ن عه نععك) لجميع العاملين (ويشمل ذلك الموظفين والمتعاقدين)\r\nوالذين يمكنهم الوصول إلى أصول أنظمة التحكم الصناعي (01\/108) أو\r\nاستخدامها؛ وذلك قبل منحهم صلاحيات الوصول",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-7-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "OTCC 1-7-2",
                    "long_name" => "OTCC 1-7-2",
                    "description" => "رجوعاً للضابط ‎7-9-١‏ في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الأمن السيبراني لأنظمة التحكم الصناعي (01\/108) المتعلقة\r\nبالموارد البشرية. وقياس فعالية تطبيقهاء وتقييمها دورياً",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-7-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "OTCC 1-8-1",
                    "long_name" => "OTCC 1-8-1",
                    "description" => "بالإضافة للضوابط الفرعية. ضمن الضابط ‎٣-١٠-١‏ في الضوابط الأساسية\r\nللأمن السيرا في؛ يجب أن يتضمن برنامج التوعية بالأمن السيبراني. التعامل | ي | ي | ي\r\nالآمن مع أنظمة التحكم الصناعي (07\/165) في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-8-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [
                    "short_name" => "OTCC 1-8-2",
                    "long_name" => "OTCC 1-8-2",
                    "description" => "بالإضافة للضوابط الفرعية. ضمن الضابط ١-٠١-ع‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيراني. المتعلقة\r\nببرنامج التوعية والتدريب بالأمن السيبراني في بيئة أنظمة التحكم\r\nالصناعي (01\/105",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 1-8-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "OTCC 1-8-2-1",
                            "long_name" => "OTCC 1-8-2-1",
                            "description" => "يجب أن يتم توفير تمارين خاصة. وشهادات مهنية. ومهارات\r\nاحترافية في مجال الأمن السييراني. لجميع العاملين على الأصول المتعلقة\r\nبأنظمة التحكم الصناعي (01\/105). كما تشجع الهيئة الجهة على.\r\nالاستفادة من الإطار السعودي لكوادر الأمن السيبراني (سيوف) ليكون\r\nمرجع لها.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-8-2-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "OTCC 1-8-2-2",
                            "long_name" => "OTCC 1-8-2-2",
                            "description" => "يجب تشجيع الجهة للمشاركة مع الجهات المعتمدة و\/أو ذات\r\nالاختصاص في مجال أنظمة التحكم الصناعي (01\/105) للتعرف على\r\nأحدث التقنيات والممارسات في مجال الآمن السيبراني لأنظمة التحكم\r\nالصناعي (071\/105)",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 1-8-2-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],

                    ],

                ],

                [
                    "short_name" => "OTCC 2-1-1",
                    "long_name" => "OTCC 2-1-1",
                    "description" => "بالإضافة للضوابط. ضمن المكون الفرعي ‎١-‏ في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب أن تغطي متطلبات الأمن السييراني. المتعلقة بإدارة الأصول\r\nأنظمة التحكم الصناعي (071\/108",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "OTCC 2-1-1-1",
                            "long_name" => "OTCC 2-1-1-1",
                            "description" => "نشاء قائمة جرد إلكترونية. لجميع أصول أنظمة التحكم الصناعي\r\n(01\/105) ومراجعتها بشكل دوري",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-1-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Asset Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "OTCC 2-1-1-2",
                            "long_name" => "OTCC 2-1-1-2",
                            "description" => "استخدام تقنيات الأتمتة لحصر الأصول",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-1-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Asset Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "OTCC 2-1-1-3",
                            "long_name" => "OTCC 2-1-1-3",
                            "description" => "‏حفظ معلومات أصول أنظمة التحكم الصناعي‎ ٣-١-١-٢\r\n‏المحصورة بشكل آمن.‎",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-1-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Asset Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "OTCC 2-1-1-4",
                            "long_name" => "OTCC 2-1-1-4",
                            "description" => "تحديد ملاك الأصول (عص٧٥‏ :8فوه) لجميع أصول أنظمة\r\nالتحكم الصناعي (01\/105) والتأكد من مشاركتهم في دورة حياة إدارة\r\nجرد الأصول ذات العلاقة.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-1-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Asset Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "OTCC 2-1-1-5",
                            "long_name" => "OTCC 2-1-1-5",
                            "description" => "تصنيف مستوى الحساسية (من رانلةعنان) وتوثيقه\r\nواعتماده لجميع الأصول. من قبل ملاك الأصول.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-1-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Asset Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ],
                ],


                [
                    "short_name" => "OTCC 2-1-2",
                    "long_name" => "OTCC 2-1-2",
                    "description" => "‏رجوعا للضابط 7-1-3 في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الأمن السيبراني المتعلقة بإدارة أصول أنظمة التحكم الصناعي\r\n(01\/105). وقياس فعالية تطبيقها وتقييمها دورباً.",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "OTCC 2-2-1",
                    "long_name" => "OTTC 2-2-1",
                    "description" => "بالإضافة للضوابط الفرعية. ضمن الضابط ‎٣-٢-٢‏ في الضوابط الأساسية\r\nللأمن السيبراني. يجب أن تغطي متطلبات الأمن السيبراني المتعلقة بإدارة\r\nهويات الدخول. والصلاحيات في بيئة أنظمة التحكم الصناعي (07\/105",
                    "supplemental_guidance" => null,
                    "control_number" => "OTTC 2-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "OTCC 2-2-1-1",
                            "long_name" => "OTCC 2-2-1-1",
                            "description" => "التأكد من أن دورة حياة إدارة هويات الدخول والصلاحيات»\r\nلأنظمة التحكم الصناعي (01\/105) مفصولة ومستقلة. عن تلك المتعلقة\r\nبتقنية المعلومات (17) وذلك يشمل الحلول التقنية المستخدمة في الإدارة\r\nالمركزية لهويات الدخول والصلاحيات",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-2-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-2-1-2",
                            "long_name" => "OTCC 2-2-1-2",
                            "description" => "الإدارة الآمنة لحسابات الخدمات (و)صاععه 166 :5) المتعلقة\r\nبخدمات التحكم الصناعي (071\/108) وتطبيقاتها! وأنظمتها. وأجهزتها\r\nالمعزولة وغير المتصلة بحسابات دخول المستخدمين التفاعلية )عصا",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-2-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-2-1-3",
                            "long_name" => "OTCC 2-2-1-3",
                            "description" => "تغيير الهويات المصنعية )ولصءلعءح} السه؟ء() لجميع الأصول\r\nالمتعلقة بأنظمة التحكم الصناعي (071\/168) أو تعطيلهاء أو إزالتها",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-2-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-2-1-4",
                            "long_name" => "OTCC 2-2-1-4",
                            "description" => "الإدارة الآمنة لجلسات الاتصال\" ويشمل ذلك موثوقية الجلسات\r\nجد | )نط ن). و إقفالها مم1 وإنهاء مهلتها )معسنآ)",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-2-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-2-1-5",
                            "long_name" => "OTCC 2-2-1-5",
                            "description" => "منع التعطيل. أو الإزالة التلقائية لحسابات الخدمات. أو البرامج.\r\nأو حسابات الأجهزة المتعلقة بأنظمة التحكم الصناعي (01\/105) باستثناء | مي\r\nأنظمة المراقبة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-2-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-2-1-6",
                            "long_name" => "OTCC 2-2-1-6",
                            "description" => "استخدام إجراءات الاعتمادات الثنائية (لةدهءممه لهسط) وآليات\r\nمحددة لتصعيد الصلاحيات للإجراءات الحساسة. داخل بيئة أنظمة التحكم | مي\r\nالصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-2-1-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-2-1-7",
                            "long_name" => "OTCC 2-2-1-7",
                            "description" => "تقييد الوصول عن بعد لشبكات أنظمة التحكم الصناعي\r\n(01\/108) وتمكينه بشكل استثنائي عند الضرورة. ووجود المبررات\r\nاللازمة. على أن يتم إجراء تقييم مخاطر الأمن السيبراني قبل منح\r\nالوصول عن بعد. ورصد المخاطر المتعلقة بذلك وإدارتها. وأن يكون\r\nالدخول المصرح به من خلال التحقق من الهوية ذات العناصر المتعددة | ي | ي\r\n)”“ ن ة-نال”) وعبر قناة مشفرة لفترة\r\nزمنية محددة. وبصلاحيات محدودة. ويتم مراقبة جلسة الوصول عن بعد\r\nوتسجيلها. على أن تكون الصلاحيات الممنوحة للمستخدم. متوافقة مع\r\nتقييم مخاطر الأمن السيبراني",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-2-1-7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-2-1-8",
                            "long_name" => "OTCC 2-2-1-8",
                            "description" => "تطبيق معايير آمنة ومعقدة لكلمات المرور",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-2-1-8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-2-1-9",
                            "long_name" => "OTCC 2-2-1-9",
                            "description" => "استخدام آليات آمنة لتخزين كلمات المرور. الخاصة بأصول أنظمة\r\nالتحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-2-1-9",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-2-1-10",
                            "long_name" => "OTCC 2-2-1-10",
                            "description" => "رجوعا للضابط الفرعي 0-2-7-7 في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب مراجعة هويات الدخول والصلاحيات. عند الاستجابة\r\nلحوادث الأمن السيبراني. وعند التغيير في أدوار العاملين. أو عند حدوث أي\r\nتغيبر في الهيكلية المعمارية لأنظمة التحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-2-1-10",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-2-1-11",
                            "long_name" => "OTCC 2-2-1-11",
                            "description" => "إلغاء صلاحيات الدخول مباشرة. عند انتهاء الحاجة لها.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-2-1-11",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],


                    ],
                ],

                [
                    "short_name" => "OTCC 2-2-2",
                    "long_name" => "OTCC 2-2-2",
                    "description" => "‏رجوعا للضابط 2-7-9 في الضوابط الأساسية للأمن السيبرا\r\n\r\n‏مراجعة متطلبات الأمن السيبراني. المتعلقة بإدارة هويات الدخول\r\nوالصلاحيات. في بينة أنظمة التحكم الصناعي (01\/105)؛ وقياس فعالية ‏تطبيقها وتقييمها دوريا",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-2-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "OTCC 2-3-1",
                    "long_name" => "OTCC 2-3-1",
                    "description" => "‏بالإضافة للضوابط الفرعية. ضمن الضابط ‎٣-٣-٢‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني. لحماية الأنظمة\r\nوأجهزة معالجة المعلومات. المتعلقة بأنظمة التحكم الصناعي",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-3-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Facility Processing and System Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "OTCC 2-3-1-1",
                            "long_name" => "OTCC 2-3-1-1",
                            "description" => "استخدام تقنيات وآليات الحماية الحديثة والمتقدمة. وإدارتها\r\nبشكل آمن. للحماية من الفيروسات. والبرامج. والأنشطة المشبوهة.\r\nوالبرمجيات الضارة (8ته»2481). والتهديدات المتقدمة المستمرة (7)“\r\nوالملفات الضارة. وحظرها.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-3-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Facility Processing and System Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-3-1-2",
                            "long_name" => "OTCC 2-3-1-2",
                            "description" => "إجراء مراجعة دورية للإعدادات والتحصين )ء\r\n\r\n‏ن ة مج) بما يتوافق مع إرشادات الأمن\r\nالسيبراني. وأفضل الممارسات. والتوصيات الخاصة بالموردين (:Vendors).‏\r\nوما يتوافق مع آليات إدارة التغيير المتبعة في الجهة.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-3-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Facility Processing and System Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-3-1-3",
                            "long_name" => "OTCC 2-3-1-3",
                            "description" => "تطبيق حزم التحديثات والإصلاحات الأمنية بشكل دوري.\r\nعلى أنظمة التحكم الصناعي (01\/105) يما يتوافق مع إرشادات\r\nالأمن السيبراني. وأفضل الممارسات الخاصة بالموردين (Vendors٢).‏ وبما\r\nيتوافق مع آليات إدارة التغيير المتبعة في الجهة.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-3-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Facility Processing and System Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-3-1-4",
                            "long_name" => "OTCC 2-3-1-4",
                            "description" => "تطبيق مبدأ الحد الأدنى من الصلاحيات والامتيازات (ا5ةء[\r\nععلدن) والحد الأدنى من الامكانيات",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-3-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Facility Processing and System Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-3-1-5",
                            "long_name" => "OTCC 2-3-1-5",
                            "description" => "إعداد ووضع وحدات التحكم (5:»ل000:01) في أنظمة معدات\r\nالسلامة (515) في الأوضاع الاعتيادية التشغيلية في جميع الأوقات؛ مما يمنع\r\nأي تغييرات غير مصرح بها. ولا يكون تغييرها الى الوضع غير الاعتيادي إلا\r\nبصفة استثنا\r\n‏ائية. ويكون ذلك مقيدا بفترة زمنية محددة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-3-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Facility Processing and System Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-3-1-6",
                            "long_name" => "OTCC 2-3-1-6",
                            "description" => "تحديد قوائم محددة من التطبيقات المسموح بتشغيلها في بيئة\r\nأنظمة التحكم الصناعي (071\/105) من خلال التقنيات المتاحة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-3-1-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Facility Processing and System Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-3-1-7",
                            "long_name" => "OTCC 2-3-1-7",
                            "description" => "إدارة أصول أنظمة التحكم الصناعي (071\/105) من خلال أجهزة\r\nالمهندسين (صمنهام٥‏ ومنععصنعصع) وأجهزة واجهات التعامل مع\r\nالأنظمة )”“ ه عصنطة-صةصنل]). والتأكد من أن تكون\r\nأجهزة إدارة الأصول و صيانتها! محصنة ومعزولة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-3-1-7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Facility Processing and System Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-3-1-8",
                            "long_name" => "OTCC 2-3-1-8",
                            "description" => "فحص وسائط التخزين الخارجية. وتحليلها ضد البرامج الضارة.\r\nوالتهديدات المتقدمة المستمرة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-3-1-8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Facility Processing and System Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-3-1-9",
                            "long_name" => "OTCC 2-3-1-9",
                            "description" => "التقييد الحازم لاستخدام وسائط التخزين الخارجية في بيئة الإنتاج»\r\nما م يتم تطوير آليات آمنة وتطبيقها لنقل البيانات",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-3-1-9",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Facility Processing and System Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-3-1-10",
                            "long_name" => "OTCC 2-3-1-10",
                            "description" => "حماية سجلات الأحداث. والملفات الحساسة. من الدخول غير\r\nالمصرح به. أو التلاعب أو التغيير غير المصرح به. أو الحذف",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-3-1-10",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Facility Processing and System Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-3-1-11",
                            "long_name" => "OTCC 2-3-1-11",
                            "description" => "اكتشاف التطبيقات والبرامج النصية (وامنت) والمهمات\r\nوالتغييرات غير المصرح بها! وفحصها",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-3-1-11",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Facility Processing and System Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-3-1-12",
                            "long_name" => "OTCC 2-3-1-12",
                            "description" => "كتشاف الأوامر المنفذة ))Execution Commands) وجلسات\r\nالاتصالات الحديثة ))Sessions Communication New).‏ وفحصها",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-3-1-12",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Facility Processing and System Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-3-1-13",
                            "long_name" => "OTCC 2-3-1-13",
                            "description" => "اكتشاف الاتصالات المباشرة بين بيئة شبكات أنظمة التحكم\r\nالصناعي (07\/125©) والأطراف الخارجية ):s Extern). وفحصها.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-3-1-13",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Facility Processing and System Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ],

                ],
                [
                    "short_name" => "OTCC 2-3-2",
                    "long_name" => "OTCC 2-3-2",
                    "description" => "رجوعا للضابط 2-3-3 في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الأمن السيبراني لحماية أنظمة معالجة المعلومات والأجهزة\r\nالمتعلقة بأنظمة التحكم الصناعي (07\/165©). وقياس فعالية تطبيقها\r\nوتقييمها دوريا.",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-3-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Facility Processing and System Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "OTCC 2-4-1",
                    "long_name" => "OTCC 2-4-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط 2-0-3 في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني. لإدارة أمن الشبكات\r\nالمتعلقة بأنظمة التحكم الصناعي",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-4-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Networks Security Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "OTCC 2-4-1-1",
                            "long_name" => "OTCC 2-4-1-1",
                            "description" => "تقسيم شبكات أنظمة التحكم الصناعي (07\/108) منطقيا أو\r\nماديا عن الشبكات الأخرى.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-4-1-2",
                            "long_name" => "OTCC 2-4-1-2",
                            "description" => "تقسيم المناطق المختلفة (ءصه7) داخل بيئة أنظمة التحكم\r\nالصناعي (01\/108) منطقيا أو ماديا وفقاً للمستوى المناسب للمنطقة\r\nوعزل تدفق البيانات بين المناطق بحيث يتم الاتصال بين المناطق عبر نقاط\r\nاتصال محددة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                        [
                            "short_name" => "OTCC 2-4-1-3",
                            "long_name" => "OTCC 2-4-1-3",
                            "description" => "تقسيم أنظمة معدات السلامة ) ك\r\n7\" وصءءرك) منطقياً أو مادياً عن الشبكات الأخرى الخاصة بأنظمة\r\nالتحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-4-1-4",
                            "long_name" => "OTCC 2-4-1-4",
                            "description" => "‏تقييد استخدام التقنيات اللاسلكية (مثل => ,طهعداظ‎ ٤-١-٤٢\r\n‏للع مالك . وغيرها) . على أن يكون استخدامها لتلبية متطلبات‎\r\n‏عمل محددة مع ضمان تأمينها بالشكل المناسب.‎",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-4-1-5",
                            "long_name" => "OTCC 2-4-1-5",
                            "description" => "عزل التقنيات اللاسلكية منطقيًا أو ماديًا. عن الشبكات الخاصة\r\nبأنظمة التحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-4-1-6",
                            "long_name" => "OTCC 2-4-1-6",
                            "description" => "تقييد استخدام اتصالات الشبكة. والخدمات. ونقاط الاتصال بين\r\nالمناطق المختلفة ()Zones )) وحصرها على الحد الأدفى؛ لتلبية متطلبات\r\nالتشغيل والصيانة والسلامة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-4-1-7",
                            "long_name" => "OTCC 2-4-1-7",
                            "description" => "منع الوصول المباشر لخدمات التحقق. و إدارة الدخول عن بعد\r\n) سه عصعع) على الأجهزة\r\nالمتواجدة في الشبكة الخارجية للجهة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-4-1-8",
                            "long_name" => "OTCC 2-4-1-8",
                            "description" => "قصر الوصول لخدمات الأعمال الحساسة )1 => عنس(\r\nالمتعلقة بالشبكة الداخلية لأنظمة التحكم الصناعي (07\/108) على\r\nالخدمات المصرح بها. ويجب الحد من الوصول للخدمات ذات الثغرات\r\nالأمنية المعروفة إلى أقصى حد ممكن",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-4-1-9",
                            "long_name" => "OTCC 2-4-1-9",
                            "description" => "منع الوصول المباشر عن بعد. بين منطقة الجهة الداخلية\r\n) ) ومنطقة شبكات أنظمة التحكم الصناعي (Zone Corporate ))»\r\nوتوجيه جميع الاتصالات إلى نقاط الوصول عن بعد (110555 مصدا[) بحيث\r\nتكون مخصصة لهذه العمليات. وآمنة ومحصنة في المنطقة المحايدة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-9",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-4-1-10",
                            "long_name" => "OTCC 2-4-1-10",
                            "description" => "عدم الاتصال بشبكات أنظمة التحكم الصناعي (7\/1&5©)\r\nباستخدام نقطة الوصول عن بعد المتواجدة في المنطقة المحايدة\r\n(0112) إلا عند الحاجة. مع ضمان تطبيق مبدأ التحقق من الهوية.\r\nذات العناصر المتعددة )”“ م ح-(\r\nوتسجيل جلسات الاتصال ”MFA “Authentication Factor-Multi) وأن يكون الاتصال\r\nلفترة زمنية محددة فحسب",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-10",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-4-1-11",
                            "long_name" => "OTCC 2-4-1-11",
                            "description" => "استخدام الوكيل ((:2:0) بين منطقة الجهة الداخلية\r\n) ) ومنطقة أنظمة التحكم الصناعي (017\/108)\r\nللتحكم بالحركة عند الاتصال ما بين الأجهزة  )Machine-to-Machine.)",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-11",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-4-1-12",
                            "long_name" => "OTCC 2-4-1-12",
                            "description" => "استخدام البوابات (رة\"»ءاة6) المخصصة؛ لتقسيم\r\nشبكات أنظمة التحكم الصناعي (07\/108) من الشبكة الداخلية  )Zone Corporate",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-12",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-4-1-13",
                            "long_name" => "OTCC 2-4-1-13",
                            "description" => "استخدام منطقة محايدة (DMZ) لاستضافة أي نظام. يقدم\r\nخدمات بين منطقة الشبكة الداخلية )ع ع1ه:0م:00) ومنطقة أنظمة\r\nالتحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-13",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-4-1-14",
                            "long_name" => "OTCC 2-4-1-14",
                            "description" => "التقييد الصارم على تمكين البروتوكولات الصناعية (لمنعاس4صا\r\nوله»2:010) والمنافذ (20:18) واستخدامها إلى الحد الأدنى. بالتوافق مع\r\nمتطلبات التشغيل والصيانة والسلامة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-14",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-4-1-15",
                            "long_name" => "OTCC 2-4-1-15",
                            "description" => "اعتماد حزم التحديثات الدورية. والإصلاحات الأمنية للأصول في\r\nبيئة الإنتاج. من قبل الشركة المصنعة. وإجراء اختبار في بيئة تجريبية قبل\r\nتطبيقها على بيئة الإنتاج",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-15",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-4-1-16",
                            "long_name" => "OTCC 2-4-1-16",
                            "description" => "الحفاظ على الوثائق المفصلة. لهندسة الشبكة وتصميمها.\r\nوتقسيماتهاء وتدفقات بيانات الشبكة. و نقاط ترابطهاء واعتماديتها؛ وتوثيق.\r\nوتحديث الوثائق مع كل تغيير",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-4-1-16",
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
                    "short_name" => "OTCC 2-4-2",
                    "long_name" => "OTCC 2-4-2",
                    "description" => "‏رجوعا للضابط 2-0-7 في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الآمن السيبراني لإدارة أمن شبكات أنظمة التحكم الصناعي )ICS\/OT)\r\nوقياس فعالية تطبيقها وتقييمها دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-4-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Networks Security Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "OTCC 2-5-1",
                    "long_name" => "OTCC 2-5-1",
                    "description" => "بالإضافة للضوابط الفرعية. ضمن الضابط ‎٣-٦-٢‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني لأمن الأجهزة\r\nالمحمولة",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-5-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "OTCC 2-5-1-1",
                            "long_name" => "OTCC 2-5-1-1",
                            "description" => "تقييد استخدام الأجهزة المحمولة. لشبكات أنظمة التحكم الصناعي\r\n(01\/108) عند الحاجة لاستخدام الأجهزة المحمولة. ويجب إجراء تقييم | ‎٧‏ | ص\r\nمخاطر الأمن السييراني. وتحديد المخاطر وإدارتها. يجب الحصول على\r\nموافقة الإدارة المعنية بالأمن السيبراني لفترة زمنية محددة فحسب\" بما\r\nيتوافق مع آليات إدارة صلاحيات الوصول المتبعة في الجهة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-5-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-5-1-2",
                            "long_name" => "OTCC 2-5-1-2",
                            "description" => "استخدام الأجهزة المحمولة المخصصة لأغراض العمل. وبما يتوافق\r\nمع متطلبات الأمن السيبراني. للمناطق الخاصة بها (وعصه7) قبل توصيلها\r\n٢-٥۔١‏ ببيئة شبكات أنظمة التحكم الصناعي (01\/105). ويجب أن يتم تحصينها\r\nوتحديثها بالتحديثات الأمنية الحديثة؛ وفحصها من البرمجيات الضارة\r\n(ع»له1) والتهديدات المتقدمة المستمرة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-5-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-5-1-3",
                            "long_name" => "OTCC 2-5-1-3",
                            "description" => "تحديد قائمة مقيدة بالأجهزة المحمولة المصرح بها مع ضمان\r\nإمكانية توصيل هذه الأجهزة المحمولة فحسب ببيئة التقنية التشغيلية | ي | ي\r\nوأنظمة التحكم الصناعي (01\/105). واعتمادها",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-5-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-5-1-4",
                            "long_name" => "OTCC 2-5-1-4",
                            "description" => "تطبيق آلية لإدارة الأجهزة المحمولة. مركزياً   ice Mobile\r\nMDM “Management.)",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-5-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-5-1-5",
                            "long_name" => "OTCC 2-5-1-5",
                            "description" => "تنفيذ عمليات التشفير على الأجهزة المحمولة المصرح باستخدامها\r\nللوصول إلى أصول أنظمة التحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-5-1-5",
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
                    "short_name" => "OTCC 2-5-2",
                    "long_name" => "OTCC 2-5-2",
                    "description" => "رجوعا للضابط 2-7-7 في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nلما متطلبات الأمن السيبراني لحماية استخدام الأجهزة المحمولة في بيئة ث\r\nأنظمة التحكم الصناعي (01\/108) وقياس فعالية تطبيقها",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-5-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "OTCC 2-6-1",
                    "long_name" => "OTCC 2-6-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-٧-٢‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني لحماية البيانات\r\nوالمعلومات المتعلقة بأنظمة التحكم الصناعي",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-6-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "OTCC 2-6-1-1",
                            "long_name" => "OTCC 2-6-1-1",
                            "description" => "حماية البيانات الإلكترونية والمادية (في حال التخزين والنقل)\r\nبالمستوى الذي يتوافق مع تصنيف البيانات",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-6-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-6-1-2",
                            "long_name" => "OTCC 2-6-1-2",
                            "description" => "حماية البيانات والمعلومات المصنفة من خلال تقنيات. منع\r\nتسريب البيانات",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-6-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-6-1-3",
                            "long_name" => "OTCC 2-6-1-3",
                            "description" => "استخدام آليات الحذف الآمنة )صن ) لبيانات\r\nالإعدادات والبيانات المخزنة على أصول أنظمة التحكم الصناعي (07\/105)»\r\nوذلك عند الانتهاء منها.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-6-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-6-1-4",
                            "long_name" => "OTCC 2-6-1-4",
                            "description" => "التقييد الحازم لنقل بيانات أنظمة التحكم الصناعي (01\/105)\r\nأو استخدامها خارج بيئة الإنتاج؛ إلى أن تطبق ضوابط صارمة لحماية تلك\r\nالبيانات.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-6-1-4",
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
                    "short_name" => "OTCC 2-6-2",
                    "long_name" => "OTCC 2-6-2",
                    "description" => "‏رجوعا للضابط 2-1-9 في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الأمن السيبراني لحماية البيانات والمعلومات في بيئة شبكات أنظمة\r\nالتحكم الصناعي (07\/165©). وقياس فعالية تطبيقها وتقييمها دوريا.",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-6-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [
                    "short_name" => "OTCC 2-7-1",
                    "long_name" => "OTCC 2-7-1",
                    "description" => "‏بالإضافة للضوابط الفرعية. ضمن الضابط 2-0-3 في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب على الجهة أن تتأكد من مواءمة تقنيات التشفير\r\nالمستخدمة في بيئة شبكات أنظمة التحكم الصناعي (01\/105) مع المعايير\r\nالوطنية للتشفير ‎",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-7-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cryptography'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "OTCC 2-7-2",
                    "long_name" => "OTCC 2-7-2",
                    "description" => "رجوعا للضابط 2-8-7 في الضوابط الأساسية للأمن السيبراني؛ فإنه يجب\r\nمراجعة متطلبات الآمن السيبراني للتشفير. في بيئة شبكات أنظمة التحكم\r\nالصناعي (01\/105). وقياس فعالية تطبيقها وتقييمها دوريا.",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-7-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cryptography'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "OTCC 2-8-1",
                    "long_name" => "OTCC 2-8-1",
                    "description" => "بالإضافة للضوابط الفرعية. ضمن الضابط 2-9-3 في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني لإدارة النسخ الاحتياطية\r\nالمتعلقة بأنظمة التحكم الصناعي (07\/165)",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-8-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [


                        [
                            "short_name" => "OTCC 2-8-1-1",
                            "long_name" => "OTCC 2-8-1-1",
                            "description" => "يجب أن تغطي النسخ الاحتياطية جميع أصول أنظمة التحكم\r\nالصناعي (01\/108), كما يجب تخزينها بشكل مركزي )ءينلةاه>\r\n«متا10) وفي مواقع غير متصلة بالشبكة.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-8-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-8-1-2",
                            "long_name" => "OTCC 2-8-1-2",
                            "description" => "التأكد من كون ملفات الإعدادات الحساسة والهندسية المختصة\r\nبأنظمة التحكم الصناعي (01\/105) مضمنه في النسخ الاحتياطية",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-8-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-8-1-3",
                            "long_name" => "OTCC 2-8-1-3",
                            "description" => "إجراء عمليات النسخ الاحتياطي دوريا. وفقاً لتصنيف أصول\r\nأنظمة التحكم الصناعي (01\/105) والمخاطر المتعلقة بها",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-8-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-8-1-4",
                            "long_name" => "OTCC 2-8-1-4",
                            "description" => "تأمين الوصول والتخزين والنقل للنسخ الاحتياطية ووسائطهاء\r\nوضمان حمايتها من التلف أو التغيير. أو الوصول غير المصرح به.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-8-1-4",
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
                    "short_name" => "OTCC 2-8-2",
                    "long_name" => "OTCC 2-8-2",
                    "description" => "‏رجوعاً للضابط 2-9-3 في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الأمن السيبراني لإدارة النسخ الاحتياطية الخاصة بأنظمة التحكم\r\nالصناعي (01\/105). وقياس فعالية تطبيقها وتقييمها دورياً",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-8-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "OTCC 2-9-1",
                    "long_name" => "OTCC 2-9-1",
                    "description" => "‏بالإضافة للضوابط الفرعية ضمن الضابط ‎٢١٠٢‏ في الضوابط الأساسية\r\nي لإدارة الثغرات\r\nالمتعلقة بأنظمة التحكم الصناعي",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-9-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [


                        [
                            "short_name" => "OTCC 2-9-1-1",
                            "long_name" => "OTCC 2-9-1-1",
                            "description" => "يجب تحديد نطاق عمليات تقييم الثغرات وأنشطتها لبيئة شبكات\r\nأنظمة التحكم الصناعي (01\/108) بوصفه جزء من الآليات الرسمية لإدارة\r\nالثغرات في الجهة. وضمان تأثير محدود أو غير محدود على بيئة الإنتاج",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-9-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-9-1-2",
                            "long_name" => "OTCC 2-9-1-2",
                            "description" => "رجوعا للضابط الفرعي ‎٣-٢-١٠-٢‏ في الضوابط الأساسية للأمن\r\nالسيبراني؛ يتم التأكد من ضمان المعالجة الفورية. للثغرات الحساسة\r\nالمكتشفة حديثاً. والتي تشكل مخاطر كبيرة على بينة شبكات أنظمة التحكم\r\nالصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-9-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-9-1-3",
                            "long_name" => "OTCC 2-9-1-3",
                            "description" => "رجوعا للضابط الفرعي ‎١-٣-١٠-٢‏ في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب إجراء تقييم الثغرات لأنظمة التحكم الصناعي دوريا.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-9-1-3",
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
                    "short_name" => "OTCC 2-9-2",
                    "long_name" => "OTCC 2-9-2",
                    "description" => "رجوعا للضابط ٢-٠١-ع‏ في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الأمن السيبراني لإدارة الثغرات الخاصة بأنظمة التحكم الصناعي | ي | ي\r\n(01\/105). وقياس فعالية تطبيقها وتقييمها دوريا.",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-9-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "OTCC 2-10-1",
                    "long_name" => "OTCC 2-10-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎2-١-7‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني إجراء اختبارات\r\nاختراق على أنظمة التحكم الصناعي (07\/165)",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-10-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Penetration Testing'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [


                        [
                            "short_name" => "OTCC 2-10-1-1",
                            "long_name" => "OTCC 2-10-1-1",
                            "description" => "رجوعا للضابط الفرعي ‎١-٣-١١-٢‏ في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب تحديد نطاق أنشطة اختبارات الاختراق. لتغطي بيئة\r\nشبكات أ التحكم الصناعي (01\/105) و الشبكات الرتب 8\r\nالتشغيلية. وأن يتم عمل الاختبارات من قبل فريق ذي كفاءة عالية",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-10-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Penetration Testing'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-10-1-2",
                            "long_name" => "OTCC 2-10-1-2",
                            "description" => "رجوعا للضابط الفرعي ‎٢-٢-١١-٢‏ في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب إجراء اختبار الاختراق\" بعد التأكد من أن تأثير الاختبار6\r\nمحدود على بيئة الإنتاج. أو إجراء اختبار الاختراق. في بيئة منفصلة مماثلة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-10-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Penetration Testing'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-10-1-3",
                            "long_name" => "OTCC 2-10-1-3",
                            "description" => "في الضوابط الأساسية للأمن‎ ٢-٢-١١-٢ ‏رجوعا للضابط الفرعي‎ 3-1-١-٠\r\n‏السيبراني؛ يجب إجراء اختبار الاختراق لأنظمة التحكم الصناعي دوريا.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-10-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Penetration Testing'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-10-1-4",
                            "long_name" => "OTCC 2-10-1-4",
                            "description" => "‏يجب تحديد طرق اختبارات بديلة وتنفيذها مثل الاختبارات‎ ٤١-١٠-٢\r\n‏غير الفعالة (وصناتع]' ©19ومة0) لجمع المعلومات عندما يكون هنالك أثر‎\r\n‏محتمل على بيئة الإنتاج التشغيلية.‎",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-10-1-4",
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
                    "short_name" => "OTCC 2-10-2",
                    "long_name" => "OTCC 2-10-2",
                    "description" => "‏رجوعا للضابط ‎2-١-3‏ في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الأمن السيبراني لاختبارات الاختراق على أنظمة التحكم الصناعي | ي\r\n(01\/105). وقياس فعالية تطبيقها وتقييمها دوريا.",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-10-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Penetration Testing'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "OTCC 2-11-1",
                    "long_name" => "OTCC 2-11-1",
                    "description" => "بالإضافة للضوابط الفرعية. ضمن الضابط ‎٣-١٢-٢‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الآمن السيبراني لإدارة سجلات\r\nالأحداث ومراقبة الأمن السيبراني الخاصة بأنظمة التحكم الصناعي",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-11-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "OTCC 2-11-1-1",
                            "long_name" => "OTCC 2-11-1-1",
                            "description" => "تفعيل سجلات الأحداث المتعلقة بالأمن السيبراني على جميع\r\nالأصول في بيئة شبكات أنظمة التحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-11-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-11-1-2",
                            "long_name" => "OTCC 2-11-1-2",
                            "description" => "اكتشاف محاولات فشل الوصول إلى نظام المراقبة الخاص\r\nبالجهة. ورصدها.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-11-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-11-1-3",
                            "long_name" => "OTCC 2-11-1-3",
                            "description" => "إجراء مراجعة ومراقبة مستمرة ودقيقة لسجلات الأحداث\r\n(1088 صعءع) والتدقيق(ولنةء7 انهسه) المتعلقة بالأمن السيبراني. على\r\nأصول أنظمة التحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-11-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-11-1-4",
                            "long_name" => "OTCC 2-11-1-4",
                            "description" => "إجراء مراقبة وكشف. وتحليل لسلوك المستخدم  “ UBA “Analytics Behaviors User.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-11-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-11-1-5",
                            "long_name" => "OTCC 2-11-1-5",
                            "description" => "اكتشاف عمليات الرفع أو التنزيل على أجهزة وأنظمة التحكم\r\nالصناعي (01\/105). بما في ذلك أنظمة السلامة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-11-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-11-1-6",
                            "long_name" => "OTCC 2-11-1-6",
                            "description" => "مراقبة جميع عمليات الوصول عن بعد  s Remote\r\nSessions",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-11-1-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-11-1-7",
                            "long_name" => "OTCC 2-11-1-7",
                            "description" => "‏ اكتشاف الاحداث الضارة Malicious events) وفحصها.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-11-1-7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-11-1-8",
                            "long_name" => "OTCC 2-11-1-8",
                            "description" => "تسجيل التنبيهات الحديثة ومراقبتها في حال اتصال أجهزة\r\nجديدة. أو غير مسموح بها بشبكات أنظمة التحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-11-1-8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-11-1-9",
                            "long_name" => "OTCC 2-11-1-9",
                            "description" => "استخدام التهديدات الاستباقية (ععصععنلاءاصآ هععط]آ) المتعلقة\r\nبأنظمة التحكم الصناعي (071\/1058) لضبط تنبيهات نظام إدارة سجلات\r\nالاحداث وتحديثها. ومراقبة الأمن السيبراني (:]51) بشكل منتظم.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-11-1-9",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-11-1-10",
                            "long_name" => "OTCC 2-11-1-10",
                            "description" => "مراقبة جميع نقاط التحكم بالدخول )ؤ :دهعم\r\nوصنه) بين حدود الشبكة )Boundaries N‏ والاتصالات الخارجية.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-11-1-10",
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
                    "short_name" => "OTCC 2-11-2",
                    "long_name" => "OTCC 2-11-2",
                    "description" => "رجوعا للضابط 2-1-3 في الضوابط الأساسية للأمن السيبراني؛ يجب\r\nمراجعة متطلبات الأمن السيبراني لإدارة سجلات الأحداث. ومراقبة الأمن\r\nالسيبراني لأنظمة التحكم الصناعي (07\/165©). وقياس فعالية تطبيقها\r\nوتقييمها دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-11-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "OTCC 2-12-1",
                    "long_name" => "OTCC 2-12-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-١٣-٢‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني لإدارة حوادث\r\nوتهديدات الأمن السيبراني المتعلقة بأنظمة التحكم الصناعي",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-12-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "OTCC 2-12-1-1",
                            "long_name" => "OTCC 2-12-1-1",
                            "description" => "التأكد من أن خطط الاستجابة للحوادث الأمنية. المتعلقة بأنظمة\r\nالتحكم الصناعي (01\/105) مدمجة. ومتوائمة مع خطط الجهة وإجراءاتها؛\r\nمثل خطط الاستجابة لحوادث تقنية المعلومات. وإدارة الأزمات. وخطط\r\n‏استمرارية الأعمال",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-12-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-12-1-2",
                            "long_name" => "OTCC 2-12-1-2",
                            "description" => "إجراء تحليل للحوادث\" وتحليل الأسباب الجذرية )e Root\r\nAnalysis )) لحوادث الأمن السيبراني. بطريقة منظمة. بعد اكتشاف الحوادث",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-12-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-12-1-3",
                            "long_name" => "OTCC 2-12-1-3",
                            "description" => "تحديد تسلسل أنشطة الاستجابة. لحوادث الأمن السيبراني\r\nاللازمة لاستعادة العمليات التشغيلية لطبيعتها",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-12-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-12-1-4",
                            "long_name" => "OTCC 2-12-1-4",
                            "description" => "إنشاء خطط التواصل. عند وقوع الحوادث",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-12-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-12-1-5",
                            "long_name" => "OTCC 2-12-1-5",
                            "description" => "تضمين إجراءات التعافي لأنظمة التحكم الصناعي وتشمل أنظمة\r\nمعدات السلامة (515) في خطط الاستجابة للحوادث. واستعادة النظام. | ‎٩‏\r\n‏واستمرارية الأعمال",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-12-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-12-1-6",
                            "long_name" => "OTCC 2-12-1-6",
                            "description" => "تزويد العاملين بالجهة بالمهارات والدورات التدريبية المطلوبة\r\n(الموظفين والمتعاقدين). للاستجابة لحوادث الأمن السيبراني المتعلقة بأنظمة | ي | ي | ي\r\nالتحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-12-1-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-12-1-7",
                            "long_name" => "OTCC 2-12-1-7",
                            "description" => "اختبار قدرات الاستجابة لحوادث الأمن السيبراني ومستوى\r\nالجاهزية والخطة المعتمدة بشكل دوري من خلال إجراء تمارين محاكاة | ص | يي\r\nللهجمات السيبرانية",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-12-1-7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-12-1-8",
                            "long_name" => "OTCC 2-12-1-8",
                            "description" => "استخدام معلومات التهديدات الاستباقية )محن ععط7)\r\nلتحديد الخطط والأساليب والإجراءات (1178) المستخدمة من قبل\r\nالمجموعات النشطة (ومسه:6 زالناءه) التي تستهدف أنظمة التحكم\r\nالصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-12-1-8",
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
                    "short_name" => "OTCC 2-12-2",
                    "long_name" => "OTCC 2-12-2",
                    "description" => "‏رجوعا للضابط ٢-٣١-ع‏ في الضوابط الأساسية للأمن السيبراني. يجب مراجعة\r\nيفيص متطلبات الأمن السيبراني لإدارة حوادث وتهديدات الأمن السيبراني في بينة | ي | ي\r\nأنظمة التحكم الصناعي (01\/108). وقياس فعالية تطبيقها وتقييمها دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-12-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "OTCC 2-13-1",
                    "long_name" => "OTCC 2-13-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-١٤٢‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الآمن السيبراني للأمن المادي\r\nالمتعلقة بأنظمة التحكم الصناعي",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-13-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "OTCC 2-13-1-1",
                            "long_name" => "OTCC 2-13-1-1",
                            "description" => "الاحتفاظ بقائمة الأشخاص. الذين لديهم حق الوصول المادي\r\nالمصرح به إلى المنشآت والأماكن الحساسة. التي يتواجد بها أصول أنظمة\r\nالتحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-13-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-13-1-2",
                            "long_name" => "OTCC 2-13-1-2",
                            "description" => "تطبيق الآليات المناسبة للتنبيه. والكشف عن التسلل المادي\r\n(صمنوسعصا لمعنورط2ٍ) والمراقبة (ع>صةللنعبءسك) بشكل لحظي (-لةعج\r\nءنآ). للتعرف على محاولات الدخول المحتملة. وتطبيق إجراءات\r\nالاستجابة المعتمدة.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-13-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-13-1-3",
                            "long_name" => "OTCC 2-13-1-3",
                            "description" => "حماية نقاط الدخول المادية. والمحيط بالأماكن التي تحتوي\r\nعلى أنظمة التحكم الصناعي (01\/105) الحساسة. والتأكد من مراقبتها\r\nباستمرار.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-13-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-13-1-4",
                            "long_name" => "OTCC 2-13-1-4",
                            "description" => "استخدام إجراءات الحماية المناسبة؛ مثل الأقفال على جميع\r\nالخزائن (ماءصنطة0) التي تحتوي على أنظمة تحكم)عرك !دصهح)\r\nوأصول حساسة متعلقة بأنظمة التحكم الصناعي (071\/105) وذلك لمنع\r\nالوصول غير المصرح به للأجهزة. التي يمكن أن توفر آلية لاختراق أصول\r\nأنظمة التحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-13-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-13-1-5",
                            "long_name" => "OTCC 2-13-1-5",
                            "description" => "تطبيق قيود صارمة على صلاحيات الوصول المادي. لجميع أصول\r\nأجهزة وأنظمة التحكم الصناعي؛ بما في ذلك أنظمة معدات السلامة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-13-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-13-1-6",
                            "long_name" => "OTCC 2-13-1-6",
                            "description" => "الاحتفاظ بسجلات دخول الزوار إلى المناطق الحساسة. والتي\r\nتحتوي على أنظمة التحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-13-1-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-13-1-7",
                            "long_name" => "OTCC 2-13-1-7",
                            "description" => "مراقبة الأعمال. التي يتم تأديتها من المقاولين. أو الموظفين\r\nالتابعين للموردين. ومزودي الخدمات.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-13-1-7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-13-1-8",
                            "long_name" => "OTCC 2-13-1-8",
                            "description" => "تزويد حراس الأمن بالمهارات المتخصصة. والتدريب اللازم. يما\r\nيتوافق مع المهمات والمسؤوليات المنوطة بهم؛ فيما يتعلق بالأمن المادي\r\nلأنظمة التحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-13-1-8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 2-13-1-9",
                            "long_name" => "OTCC 2-13-1-9",
                            "description" => "اختبار إمكانيات الأمن المادي وجاهزيته بشكل دوري؛ من خلال\r\nعمل تمارين المحاكاة (مثل => الهندسة الاجتماعية).",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 2-13-1-9",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ],


                ],
                [
                    "short_name" => "OTCC 2-13-2",
                    "long_name" => "OTCC 2-13-2",
                    "description" => "رجوعا للضابط 2-14-4 في الضوابط الأساسية للأمن السيبراني يجب مراجعة متطلبات الامن السيبراني لإدارة الأمن المادي في بيئة أنظمة التحكم الصناعي",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 2-13-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "OTCC 3-1-1",
                    "long_name" => "OTCC 3-1-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-١-٢‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات صمود الأمن السيبراني في إدارة\r\nاستمرارية الأعمال المتعلقة بأنظمة التحكم الصناعي",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 3-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "OTCC 3-1-1-1",
                            "long_name" => "OTCC 3-1-1-1",
                            "description" => "تحديد الأنشطة اللازمة. للمحافظة على الحد الأدنى من العمليات\r\nالمتعلقة بأنظمة التحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 3-1-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 3-1-1-2",
                            "long_name" => "OTCC 3-1-1-2",
                            "description" => "تطبيق التوافر (رعصةص4ءع) للشبكات. والوسائط. والأجهزة\r\nالحساسة لأصول أنظمة التحكم الصناعي (01\/105) وفقاً للتقييم الدوري\r\nلمخاطر الأمن السيبراني. لأصول أنظمة التحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 3-1-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 3-1-1-3",
                            "long_name" => "OTCC 3-1-1-3",
                            "description" => "تضمين متطلبات الأمن السيبراني. المتعلقة بأنظمة التحكم الصناعي\r\n(01\/105) إلى خطة استمرارية الأعمال (}8)؛ تحليل التأثر عاى الأعمال\r\n(ه8[1). ووقت الاستعادة المستهدف (870). ونقطة الاستعادة المستهدفة",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 3-1-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 3-1-1-4",
                            "long_name" => "OTCC 3-1-1-4",
                            "description" => "تضمين متطلبات الأمن السيبراني المتعلقة بأنظمة التحكم\r\nالصناعي (01\/105) ضمن خطط التعافي من الكوارث (0180)؛ بحيث\r\nتشمل سيناريوهات الكوارث المتعلقة بالأمن السيبراني. وإجراءات التعامل\r\nمع توقف النظام. وإجراءات إدارة العمليات التشغيلية.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 3-1-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 3-1-1-5",
                            "long_name" => "OTCC 3-1-1-5",
                            "description" => "عند فشل الأنظمة بسبب حادثة أمن سيبراني؛ يجب أن تكون\r\nأنظمة التحكم الصناعي (01\/105) قادرة على العمل بمستوى أمان مقبول.\r\nأو بأوضاع تسمح باستمرارية العمل.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 3-1-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 3-1-1-6",
                            "long_name" => "OTCC 3-1-1-6",
                            "description" => "إجراء اختبارات وتمارين المحاكاة. بشكل دوري (مثل مهعاطة]'\r\n1177\" ¡ع×غ) من أجل اختبار فعالية أنظمة التحكم الصناعي (\/07\r\n© المتعلقة بخطط التعافي من الكوارث (01) وخطة استمرارية\r\nالعمل (ع}8) وإجراء تحليل الأسباب الجذرية )ل ح (\r\nللحوادث",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 3-1-1-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ],

                ],
                [
                    "short_name" => "OTCC 3-1-2",
                    "long_name" => "OTCC 3-1-2",
                    "description" => "رجوعا للضابط 3-1-4 في الضوابط الأساسية للأمن السيبراني يجب مراجعة متطلبات الامن السيبراني في ادارة استمرارية الاعمال",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 3-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "OTCC 4-1-1",
                    "long_name" => "OTCC 4-1-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابطين ‎٢-١-٤‏ و 2-1-6 في الضوابط\r\nالأساسية للأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني للأطراف\r\nالخارجية. المتعلقة ب التحكم الصناعي",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 4-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "OTCC 4-1-1-1",
                            "long_name" => "OTCC 4-1-1-1",
                            "description" => "تضمين متطلبات الأمن السيبراني. أثناء دورة حياة المشتريات.\r\nلمنتجات وخدمات أنظمة التحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 4-1-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 4-1-1-2",
                            "long_name" => "OTCC 4-1-1-2",
                            "description" => "تحديد متطلبات الآمن السيبراني. لتقييم الأطراف الخارجية\r\n1-1 } | واختيارهم ومشاركتهم المعلومات",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 4-1-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 4-1-1-3",
                            "long_name" => "OTCC 4-1-1-3",
                            "description" => "استخدام المتعاقدين والموردين الخارجيين ممارسات رسمية\r\nوموثقة لدورة حياة التطوير الآمن (©601) للبرامج الخاصة بالأنظمة | ي | ي\r\nوالأصول المصممة أو المطبقة في بيئة أنظمة التحكم الصناعي",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 4-1-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "OTCC 4-1-1-4",
                            "long_name" => "OTCC 4-1-1-4",
                            "description" => "إجراء تقييم للأمن السيبراني وتدقيق له. بشكل دوري للأطراف\r\nالخارجية؛ والتأكد من وجود ما يضمن السيطرة؛ على أي مخاطر سيبرانية | ‎٩‏\r\n‏تم رصدها.",
                            "supplemental_guidance" => null,
                            "control_number" => "OTCC 4-1-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ],

                ],
                [
                    "short_name" => "OTCC 4-1-2",
                    "long_name" => "OTCC 4-1-2",
                    "description" => "‏رجوعا للضابط ‎2-١-6‏ في الضوابط الأساسية للأمن السيبراني؛ يجب مرا\r\nبحص متطلبات الأمن السيبراني للأمن السيبراني للأطراف الخارجية. لبينة أنظمة | ي | ي\r\nالتحكم الصناعي (01\/108). وقياس فعالية تطبيقها وتقييمها دوريا.",
                    "supplemental_guidance" => null,
                    "control_number" => "OTCC 4-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

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

        // Log the data to be inserted
        \Log::info('Data to insert:', $dataToInsert);
        $dataToInsert['description'] = ['en' => $controlData['description'], 'ar' => $controlData['description']];

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