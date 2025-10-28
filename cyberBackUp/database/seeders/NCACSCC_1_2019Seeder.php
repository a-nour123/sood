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

class NCACSCC_1_2019Seeder extends Seeder
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

            if (in_array('install_document', $this->options)) {

                DocumentTypes::updateOrCreate(
                    ['name' => 'نماذج سياسات الأمن السيبراني'], // Attributes to search for
                    ['icon' => 'fas fa-lock'] // Attributes to update or create
                );

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
            }



            // Insert framework data
            $framework = Framework::create([
                'name' => 'NCA-CSCC – 1: 2019',
                'description' => "The National Cybersecurity Authority “NCA” has developed the Critical Systems Cybersecurity Controls (CSCC – 1: 2019), as an extension and a complement to the Essential Cybersecurity Controls (ECC), to fit the cybersecurity needs for national critical systems. The Critical Systems Cybersecurity Controls consist of 32 main controls and 73 subcontrols, divided into four main domains.",
                'icon' => 'fa-lock',
                'status' => '1',
                'regulator_id' => $this->regulatorId,

            ]);


            // Main domains with their subdomains
            $mainDomains = [
                [
                    'name' => 'Cybersecurity Governance',
                    'order' => '1',
                    'subdomains' => [
                        ['name' => 'Cybersecurity Strategy', 'order' => '1'],
                        ['name' => 'Cybersecurity Risk Management', 'order' => '5'],
                        ['name' => 'Cybersecurity in Information Technology Projects', 'order' => '6'],
                        ['name' => 'Cybersecurity Periodical Assessment and Audit', 'order' => '8'],
                        ['name' => 'Cybersecurity in Human Resources', 'order' => '9'],

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
                        ['name' => 'Web Application Security', 'order' => '15'],
                        ['name' => 'Application Security', 'order' => '17',],

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
                        [
                            'name' => 'Cloud Computing and hosting Cybersecurity',
                            'order' => '2'
                        ]
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
                    "short_name" => "CSCC 1-1-1",
                    "long_name" => "CSCC 1-1-1",
                    "description" => "الإضافة للضوابط ضمن المكون الفرعي ‎١ - ١‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تضع\r\nإستراتيجية الأمن السيبراني للجهة أولوية لدعم حماية الأنظمة الحساسة الخاصة بالجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 1-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Strategy'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [

                    "short_name" => "CSCC 1-2-1",
                    "long_name" => "CSCC 1-2-1",
                    "description" => "بالإضافة للضوابط ضمن المكون الفرعي ‎٥ - ١‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تشمل\r\nمنهجية إدارة مخاطر الأمن السيبراني",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 1-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "CSCC 1-2-1-1",
                            "long_name" => "CSCC 1-2-1-1",
                            "description" => "تنفيذ إجراء تقييم مخاطر الأمن السيبراني؛ على الأنظمة الحساسة. مرة واحدة سنويا.\r\nعلى الأقل.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 1-2-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [

                            "short_name" => "CSCC 1-2-1-2",
                            "long_name" => "CSCC 1-2-1-2",
                            "description" => "إنشاء سجل مخاطر الأمن السيبراني الخاص بالأنظمة الحساسة. ومتابعته مرة شهريا\r\nعلى الأقل.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 1-2-1-2",
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

                    "short_name" => "CSCC 1-3-1",
                    "long_name" => "CSCC 1-3-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٢ - ٦ - ١‏ في الضوابط الأساسية للأمن السييراني. يجب أن تغطي\r\nمتطلبات الأمن السيبراني. لإدارة المشاريع والتغييرات على الأصول المعلوماتية والتقنية للأنظمة\r\nالحساسة في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 1-3-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "CSCC 1-3-1-1",
                            "long_name" => "CSCC 1-3-1-1",
                            "description" => "إجراء اختبار التحمل  للتأكد من سعة المكونات المختلفة",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 1-3-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",


                        ],
                        [

                            "short_name" => "CSCC 1-3-1-2",
                            "long_name" => "CSCC 1-3-1-2",
                            "description" => "التأكد من تطبيق متطلبات استمرارية الأعمال.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 1-3-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ]
                ],


                [

                    "short_name" => "CSCC 1-3-2",
                    "long_name" => "CSCC 1-3-2",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٦ - ١‏ في الضوابط الأساسية للأمن السييراني. يجب أن تغطي\r\nمتطلبات الأمن السييراني. لمشاريع تطوير التطبيقات. والبرمجيات الخاصة بالأنظمة الحساسة للجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 1-3-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "CSCC 1-3-2-1",
                            "long_name" => "CSCC 1-3-2-1",
                            "description" => "إجراء مراجعة أمنية للشفرة المصدرية. قبل إطلاقها",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 1-3-2-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "CSCC 1-3-2-2",
                            "long_name" => "CSCC 1-3-2-2",
                            "description" => "تأمين الوصول والتخزين. والتوثيق للشفرة المصدرية واصداراتها",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 1-3-2-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "CSCC 1-3-2-3",
                            "long_name" => "CSCC 1-3-2-3",
                            "description" => "‏ تأمين واجهة برمجة التطبيقات   API A",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 1-3-2-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "CSCC 1-3-2-4",
                            "long_name" => "CSCC 1-3-2-4",
                            "description" => "النقل الآمن والموثوق للتطبيقات من بيئات الاختبار t Testin) إلى\r\nبيئات الإنتاج ) مع حذف أي بيانات. أو هويات. أو\r\nكلمات مرور. متعلقة ببينات الاختبار. قبل النقل",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 1-3-2-4",
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

                    "short_name" => "CSCC 1-4-1",
                    "long_name" => "CSCC 1-4-1",
                    "description" => "‏رجوعا للضابط ‎١ - ٨ - ١‏ في الضوابط الأساسية للأمن السيبراني. فإنه يجب على الإدارة المعنية بالأمن\r\nالسيبراني؛ مراجعة تطبيق ضوابط الأمن السيبراني للأنظمة الحساسة. مرة واحدة سنوياً؛ على الأقل",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 1-4-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Periodical Assessment and Audit'),

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "CSCC 1-4-2",
                    "long_name" => "CSCC 1-4-2",
                    "description" => "رجوعاً للضابط ‎٢ - ٨ - ١‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تتم مراجعة تطبيق ضوابط الأمن السيبراني للأنظمة الحساسة؛ من قبل أطراف مستقلة عن الإدارة المعنية بالأمن السيبراني من داخل الجهة. مرة واحدة؛ كل ثلاث سنوات على الأقل.",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 1-4-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Periodical Assessment and Audit'),

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "CSCC 1-5-1",
                    "long_name" => "CSCC 1-5-1",
                    "description" => "‏بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - 3 - ١‏ في الضوابط الأساسية للأمن السيبراذ\r\nتغطي متطلبات الأمن السيبراني. قبل بدء علاقة العاملين المهنية بالجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 1-5-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CSCC 1-5-1-1",
                            "long_name" => "CSCC 1-5-1-1",
                            "description" => "إجراء امسح الأمني  للعاملين على الأنظمة الحساسة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 1-5-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",


                        ],
                        [
                            "short_name" => "CSCC 1-5-1-2",
                            "long_name" => "CSCC 1-5-1-2",
                            "description" => "أن يشغل وظائف الدعم. والتطوير التقني. للأنظمة الحساسة؛ مواطنون ذوو كفاءة عالية",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 1-5-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",


                        ]
                    ]
                ],
                [
                    "short_name" => "CSCC 2-1-1",
                    "long_name" => "CSCC 2-1-1",
                    "description" => "بالإضافة للضوابط ضمن المكون الفرعي ‎١ - ٢‏ في الضوابط الأساسية للأمن السييراني. يجب أن تشمل\r\nمتطلبات الآمن السيبراني لإدارة الأصول المعلوماتية والتقنية",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CSCC 2-1-1-1",
                            "long_name" => "CSCC 2-1-1-1",
                            "description" => "الاحتفاظ بقائمة محدثة سنويا. لجميع الأصول التابعة للأنظمة الحساسة",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-1-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Asset Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",


                        ],
                        [
                            "short_name" => "CSCC 2-1-1-2",
                            "long_name" => "CSCC 2-1-1-2",
                            "description" => "تحديد ملاك الأصول  وإشراكهم في دورة حياة إدارة الأصول\"\r\nالتابعة للأنظمة الحساسة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-1-1-2",
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
                    "short_name" => "CSCC 2-2-1",
                    "long_name" => "CSCC 2-2-1",
                    "description" => "‏بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٢ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي متطلبات الأمن السيبراني المتعلقة بإدارة هويات الدخول\" والصلاحيات للأنظمة الحساسة في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CSCC 2-2-1-1",
                            "long_name" => "CSCC 2-2-1-1",
                            "description" => "منع الدخول عن بعد من خارج المملكة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-2-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-2-1-2",
                            "long_name" => "CSCC 2-2-1-2",
                            "description" => "تقييد الدخول عن بعد من داخل المملكة؛ على أن يتم التأكد عن طريق مركز\r\nالعمليات الأمنية الخاص بالجهة. عند كل عملية دخول؛ ومراقبة الأنشطة المتعلقة\r\nبالدخول عن بعد باستمرار",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-2-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-2-1-3",
                            "long_name" => "CSCC 2-2-1-3",
                            "description" => "التحقق من الهوية متعدد العناصر MFA «Authentication Factor-Multi )-(\r\nلجميع المستفيدين.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-2-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-2-1-4",
                            "long_name" => "CSCC 2-2-1-4",
                            "description" => "التحقق من الهوية متعدد العناصر )»« محن -(\r\nللمستخدمين ذوي الصلاحيات الهامة. والحساسة؛ وعلى الأنظمة المستخدمة لإدارة\r\nالأنظمة الحساسة المذكورة في الضابط ‎٤ - ١ - ٣ - ٢‏ ومتابعتها.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-2-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-2-1-5",
                            "long_name" => "CSCC 2-2-1-5",
                            "description" => "وضع سياسة آمنة لكلمة المرور ذات معايير عالية. وتطبيقها.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-2-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-2-1-6",
                            "long_name" => "CSCC 2-2-1-6",
                            "description" => "استخدام الطرق والخوارزميات الآمنة لحفظ ومعالجة كلمات المرور مثل => استخدام\r\nدوال الاختزال",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-2-1-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-2-1-7",
                            "long_name" => "CSCC 2-2-1-7",
                            "description" => "الإدارة الآمنة لحسابات الخدمات  مابين التطبيقات والأنظمة؛\r\nوتعطيل الدخول البشري التفاعلي  من خلالها",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-2-1-7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-2-1-8",
                            "long_name" => "CSCC 2-2-1-8",
                            "description" => "يما عدا مشرفي قواعد البيانات  يمنع الوصول أو\r\nالتعامل المباشر لأي مستخدم مع قواعد البيانات؛ ويتم ذلك من خلال التطبيقات\r\nفقط وبناء على الصلاحيات المخؤل بها؛ مع مراعاة تطبيق حلول أمنية تحد. أو\r\nتمنح من اطلاع مشرفي قواعد البيانات على البيانات المصنفة",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-2-1-8",
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
                    "short_name" => "CSCC 2-2-2",
                    "long_name" => "CSCC 2-2-2",
                    "description" => "رجوعاً للضابط ‎٥ - ٣ - ٢ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب مراجعة هويات الدخول على الأنظمة الحساسة مرة واحدة. كل ثلاثة أشهر. على الأقل.",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-2-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [
                    "short_name" => "CSCC 2-3-1",
                    "long_name" => "CSCC 2-3-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٣ - ٢‏ في الضوابط الأساسية للأمن السييراني. يجب أن تغطي متطلبات الأمن السيبراني لحماية الأنظمة الحساسة. وأجهزة معالجة المعلومات الخاصة بها!",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-3-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CSCC 2-3-1-1",
                            "long_name" => "CSCC 2-3-1-1",
                            "description" => "السماح فقط بقائمة محددة من ملفات التشغيل) للتطبيقات\r\nوالبرامج؛ للعمل على الخوادم الخاصة بالأنظمة الحساسة",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-3-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-3-1-2",
                            "long_name" => "CSCC 2-3-1-2",
                            "description" => "حماية الخوادم الخاصة بالأنظمة الحساسة بتقنيات حماية الأجهزة الطرفية\r\n المعتمدة لدى الجهة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-3-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-3-1-3",
                            "long_name" => "CSCC 2-3-1-3",
                            "description" => "تطبيق حزم التحديثات. والإصلاحات الأمنية. مرة واحدة شهرياً على الأقل. للأنظمة\r\nالحساسة الخارجية. والمتصلة بالإنترنت؛ وكل ثلاثة أشهر على الأقل. للأنظمة الحساسة\r\nالداخلية؛ مع اتباع آليات التغيير المعتمدة لدى الجهة",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-3-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-3-1-4",
                            "long_name" => "CSCC 2-3-1-4",
                            "description" => "تخصيص أجهزة حاسب للعاملين في الوظائف التقنية. ذات\r\nالصلاحيات الهامة والحساسة؛ على أن تكون معزولة في شبكة خاصة لإدارة الأنظمة\r\n وعلى أن لا ترتبط بأي شبكة. أو خدمة أخرى مثل:\r\nخدمة البريد الإلكتروني. الإنترنت).",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-3-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-3-1-5",
                            "long_name" => "CSCC 2-3-1-5",
                            "description" => "تشفير أي وصول إشرافي عبر الشبكة\r\nلأي من المكونات التقنية للأنظمة الحساسة. باستخدام خوارزميات\" وبروتوكولات\r\nالتشفير الآمنة",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-3-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-3-1-6",
                            "long_name" => "CSCC 2-3-1-6",
                            "description" => "راجعة إعدادات الأنظمة الحساسة وتحصيناتها ) م 5\r\nمنعة ]) كل ستة أشهر على الأقل.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-3-1-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-3-1-7",
                            "long_name" => "CSCC 2-3-1-7",
                            "description" => "مراجعة الإعدادات المصنعية ل) وتعديلها والتأكد من عدم\r\nوجود كلمات مرور ثابتة. وخلفية. وإفتراضية",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-3-1-7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-3-1-8",
                            "long_name" => "CSCC 2-3-1-8",
                            "description" => "حماية السجلات. والملفات الحساسة للأنظمة. من الوصول غير المصرح به. أو العبث»\r\nأو التغيير. أو الحذف غير المشروع.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-3-1-8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ]
                ],
                [
                    "short_name" => "CSCC 2-4-1",
                    "long_name" => "CSCC 2-4-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٥ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي متطلبات الأمن السيبراني لإدارة أمن شبكات الأنظمة الحساسة للجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-4-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Networks Security Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CSCC 2-4-1-1",
                            "long_name" => "CSCC 2-4-1-1",
                            "description" => "العزل والتقسيم المادي. أو المنطقي. لشبكات الأنظمة الحساسة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-4-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-4-1-2",
                            "long_name" => "CSCC 2-4-1-2",
                            "description" => "مراجعة إعدادات جدار الحماية (es F) وقوائمه؛ كل ستة أشهر. على الأقل",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-4-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-4-1-3",
                            "long_name" => "CSCC 2-4-1-3",
                            "description" => "منع التوصيل المباشر. لأي جهاز بالشبكة المحلية للأنظمة الحساسة؛ إلا بعد الفحص\"\r\nوالتأكد من توافر عناصر الحماية المحققة. للمستويات المقبولة للأنظمة الحساسة",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-4-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-4-1-4",
                            "long_name" => "CSCC 2-4-1-4",
                            "description" => "منع الأنظمة الحساسة من الاتصال بالشبكة اللاسلكية",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-4-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-4-1-5",
                            "long_name" => "CSCC 2-4-1-5",
                            "description" => "الحماية من التهديدات المتقدمة المستمرة على مستوى الشبكة",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-4-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-4-1-6",
                            "long_name" => "CSCC 2-4-1-6",
                            "description" => "منع الأنظمة الحساسة من الاتصال بالإنترنت في حال أن كانت تقدم خدمة داخلية\r\nللجهة؛ ولا توجد هناك حاجة ضرورية جدا. للدخول على الخدمة من خارج الجهة",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-4-1-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "CSCC 2-4-1-7",
                            "long_name" => "CSCC 2-4-1-7",
                            "description" => "تقديم خدمات الأنظمة الحساسة. من خلال شبكات مستقلة عن الإنترنت\" في حال أن\r\nكانت خدمات تلك الأنظمة. موجهة لجهات محدودة؛ وليست للأفراد.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-4-1-7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-4-1-8",
                            "long_name" => "CSCC 2-4-1-8",
                            "description" => "الحماية من هجمات تعطيل الشبكات ) \r\n للحد من المخاطر الناتجة عن هجمات تعطيل الشبكات",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-4-1-8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-4-1-9",
                            "long_name" => "CSCC 2-4-1-9",
                            "description" => "السماح بقائمة محددة فقط. لقوائم جدار الحماية. الخاصة\r\nبالأنظمة الحساسة",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-4-1-9",
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
                    "short_name" => "CSCC 2-5-1",
                    "long_name" => "CSCC 2-5-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٦ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي متطلبات الأمن السيبراني. الخاصة بأمن الأجهزة المحمولة. وأجهزة ((80) للجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-5-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CSCC 2-5-1-1",
                            "long_name" => "CSCC 2-5-1-1",
                            "description" => "منع الوصول من الأجهزة المحمولة للأنظمة الحساسة. إلا لفترة مؤقتة فقط؛ وذلك بعد\r\nإجراء تقييم المخاطر. وأخذ الموافقات اللازمة من الإدارة المعنية بالأمن السيبراني في الجهة",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-5-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-5-1-2",
                            "long_name" => "CSCC 2-5-1-2",
                            "description" => "تشفير أقراص الأجهزة المحمولة. ذات صلاحية الوصول للأنظمة الحساسة. تشفيراً\r\nكامل",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-5-1-2",
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
                    "short_name" => "CSCC 2-6-1",
                    "long_name" => "CSCC 2-6-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٧ - ٢‏ في الضوابط الأساسية للأمن السيبراني؛\r\nيجب أن تغطي متطلبات الأمن السيبراني لحماية البيانات والمعلومات",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-6-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CSCC 2-6-1-1",
                            "long_name" => "CSCC 2-6-1-1",
                            "description" => "عدم استخدام بيانات الأنظمة الحساسة في غير بيئة الإنتاج )Production\r\nEnvironment) إلا بعد استخدام ضوابط مشددة لحماية تلك البيانات مثل => تقنيات\r\nتعتيم البيانات (Masking D أو تقنيات مزج البيانات ) )Scrambling Data.).",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-6-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-6-1-2",
                            "long_name" => "CSCC 2-6-1-2",
                            "description" => "تصنيف جميع بيانات الأنظمة الحساسة",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-6-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-6-1-3",
                            "long_name" => "CSCC 2-6-1-3",
                            "description" => "حماية البيانات المصنفة الخاصة بالأنظمة الحساسة من خلال تقنيات. منع تسريب\r\nالبيانات",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-6-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-6-1-4",
                            "long_name" => "CSCC 2-6-1-4",
                            "description" => "تحديد مدة الاحتفاظ المطلوبة  لبيانات الأعمال المتعلقة\r\nبالأنظمة الحساسة؛ حسب التشريعات ذات العلاقة. ويتم الاحتفاظ بالبيانات\r\nالمطلوبة فقط» في بينات الإنتاج للأنظمة الحساسة",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-6-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-6-1-5",
                            "long_name" => "CSCC 2-6-1-5",
                            "description" => "منع نقل أي من بيانات بيئة الإنتاج الخاصة بالأنظمة الحساسة إلى أي بيئة أخرى.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-6-1-5",
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
                    "short_name" => "CSCC 2-7-1",
                    "long_name" => "CSCC 2-7-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٨ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي\r\nمتطلبات الآمن السيبراني للتشفير.",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-7-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cryptography'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CSCC 2-7-1-1",
                            "long_name" => "CSCC 2-7-1-1",
                            "description" => "تشفير جميع بيانات الأنظمة الحساسة؛ أثناء النقل   ansit-In-Data.)",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-7-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cryptography'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-7-1-2",
                            "long_name" => "CSCC 2-7-1-2",
                            "description" => "تشفير جميع بيانات الأنظمة الحساسة؛ أثناء التخزين  على مستوى\r\nالملفات. أو قاعدة البيانات. أو على مستوى أعمدة محددة. داخل قاعدة البيانات.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-7-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cryptography'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-7-1-3",
                            "long_name" => "CSCC 2-7-1-3",
                            "description" => "استخدام طرق وخوارزميات ومفاتيح وأجهزة تشفير محدثة وآمنة وفقاً لما تصدره\r\nالهيئة بهذا الشأن",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-7-1-3",
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
                    "short_name" => "CSCC 2-8-1",
                    "long_name" => "CSCC 2-8-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - 9 - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي متطلبات الأمن السيبراني لإدارة النسخ الاحتياطية",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-8-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CSCC 2-8-1-1",
                            "long_name" => "CSCC 2-8-1-1",
                            "description" => "نطاق عمل النسخ الاحتياطي المتصل. وغير المتصل )Backup Offline and Online\r\nليشمل جميع الأنظمة الحساسة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-8-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-8-1-2",
                            "long_name" => "CSCC 2-8-1-2",
                            "description" => "عمل النسخ الاحتياطي على فترات زمنية مخطط لها؛ بناء على تقييم المخاطر للجهة\r\nوتوصي الهيئة بأن يتم عمل النسخ الاحتياطي. للأنظمة الحساسة. بشكل يومي.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-8-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-8-1-3",
                            "long_name" => "CSCC 2-8-1-3",
                            "description" => "تأمين الوصول. والتخزين. والنقل لمحتوى النسخ الاحتياطية للأنظمة الحساسة\r\nووسائطهاء وحمايتها من الإتلاف. أو التعديل. أو الاطلاع غير المصرح به.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-8-1-3",
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
                    "short_name" => "CSCC 2-8-2",
                    "long_name" => "CSCC 2-8-2",
                    "description" => "جوعا للضابط ‎٣ - ٩ - ٢‏ - © في الضوابط الأساسية للأمن السيبراني. يجب إجراء فحص دوري؛ كل ثلاثة\r\nأشهر على الأقل. لتحديد مدى فعالية استعادة النسخ الاحتياطية. الخاصة بالأنظمة الحساسة.",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-8-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "CSCC 2-9-1",
                    "long_name" => "CSCC 2-9-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٠١ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني لإدارة الثغرات للأنظمة الحساسة",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-9-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CSCC 2-9-1-1",
                            "long_name" => "CSCC 2-9-1-1",
                            "description" => "استخدام وسائل وأدوات موثوقة لإكتشاف الثغرات.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-9-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-9-1-2",
                            "long_name" => "CSCC 2-9-1-2",
                            "description" => "تقييم الثغرات ومعالجتها (بتنصيب حزم التحديثات والإصلاحات) على المكونات\r\nالتقنية للأنظمة الحساسة. مرة واحدة شهريا. على الأقل. للأنظمة الحساسة الخارجية.\r\nوالمتصلة بالإنترنت؛ وكل ثلاثة أشهر على الأقل. للأنظمة الحساسة الداخلية.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-9-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CSCC 2-9-1-3",
                            "long_name" => "CSCC 2-9-1-3",
                            "description" => "معالجة فورية للثغرات الحرجة )) المكتشفة حديثا؟ مع\r\nاتباع آليات إدارة التغيير. المعتمدة لدى الجهة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-9-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ],
                ],


                [
                    "short_name" => "CSCC 2-9-2",
                    "long_name" => "CSCC 2-9-2",
                    "description" => "رجوعا للضابط ‎١ - ٣ - ١٠ - ٢‏ في الضوابط الأساسية للأمن السيبراني\r\nالمكونات التقنية. للأنظمة الحساسة. مرة واحدة شهريا على الأقل.",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-9-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "CSCC 2-10-1",
                    "long_name" => "CSCC 2-10-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ١١ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني لاختبار الاختراق للأنظمة الحساسة",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-10-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Penetration Testing'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CSCC 2-10-1-1",
                            "long_name" => "CSCC 2-10-1-1",
                            "description" => "نطاق عمل اختبار الاختراق. ليشمل جميع المكونات التقنية للأنظمة الحساسة.\r\nوجميع الخدمات المقدمة داخليا وخارجيا.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-10-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Penetration Testing'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-10-1-2",
                            "long_name" => "CSCC 2-10-1-2",
                            "description" => "عمل اختبار الاختراق من قبل فريق مؤهل.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-10-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Penetration Testing'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ],
                ],

                [
                    "short_name" => "CSCC 2-10-2",
                    "long_name" => "CSCC 2-10-2",
                    "description" => "‏رجوعا للضابط ‎٢ - ٣ - ١١ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب عمل اختبار الاختراق على\r\nالأنظمة الحساسة. كل ستة أشهر؛ على الأقل",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-10-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Penetration Testing'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "CSCC 2-11-1",
                    "long_name" => "CSCC 2-11-1",
                    "description" => "‏بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ١٢ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\n‏تغطي متطلبات إدارة سجلات الأحداث\" ومراقبة الأمن السيبراني للأنظمة الحساسة",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-11-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CSCC 2-11-1-1",
                            "long_name" => "CSCC 2-11-1-1",
                            "description" => "تفعيل سجلات الأحداث  الخاصة بالأمن السيبراني؛ على جميع المكونات\r\nالتقنية للأنظمة الحساسة",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-11-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-11-1-2",
                            "long_name" => "CSCC 2-11-1-2",
                            "description" => "تفعيل التنبيهات وسجلات الأحداث المتعلقة بإدارة تغييرات الملفات ) ومراقبتها",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-11-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-11-1-3",
                            "long_name" => "CSCC 2-11-1-3",
                            "description" => "مراقبة سلوك المستخدم»UBA «Analytics Behavior U وتحليله",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-11-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-11-1-4",
                            "long_name" => "CSCC 2-11-1-4",
                            "description" => "مراقبة سجلات الأحداث الخاصة بالأنظمة الحساسة على مدار الساعة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-11-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-11-1-5",
                            "long_name" => "CSCC 2-11-1-5",
                            "description" => "الاحتفاظ بسجلات الأحداث\" الخاصة بالأمن السيبراني. المتعلقة بالأنظمة الحساسة\r\nوحمايتها! على أن تكون شاملة. ومتضمنة للتفاصيل كاملة (مثل => الوقت\" التاريخ.\r\nالهوية. النظام اممتأثر",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-11-1-5",
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
                    "short_name" => "CSCC 2-11-2",
                    "long_name" => "CSCC 2-11-2",
                    "description" => "رجوعا للضابط ‎٥ - ٣ - ١٢ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن لا تقل مدة الاحتفاظ\r\nبسجلات الأحداث الخاصة بالأمن السيبراني. على الأنظمة الحساسة عن ‎١8‏ شهرا حسب المتطلبات\r\nالتشريعية. والتنظيمية. ذات العلاقة.",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-11-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "CSCC 2-12-1",
                    "long_name" => "CSCC 2-12-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ١٥ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب\r\nأن تغطي متطلبات الآمن السيبراني. لحماية تطبيقات الويب الخارجية للأنظمة الحساسة للجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-12-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Web Application Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CSCC 2-12-1-1",
                            "long_name" => "CSCC 2-12-1-1",
                            "description" => "الإدارة الآمنة للجلسات)Management Session Secure ،). ويشمل موثوقية\r\nالجلسات (Authenticity ،). وإقفالهاLockout ،).‏ وإنهاء مهلتها Timeout.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-12-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Web Application Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-12-1-2",
                            "long_name" => "CSCC 2-12-1-2",
                            "description" => "تطبيق معايير أمن التطبيقات وحمايتها )Ten Top OWASP) في حدها الأدنى",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-12-1-2",
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
                    "short_name" => "CSCC 2-12-2",
                    "long_name" => "CSCC 2-12-2",
                    "description" => "‏رجوعا للضابط ‎٢ - ٢- ١٥ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب استخدام مبداً المعمارية\r\nذات المستويات المتعددة ture tier-M على أن لا يقل عدد المستويات عن ‎٣‏\r\n‏) -3(.",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-12-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Web Application Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "CSCC 2-13-1",
                    "long_name" => "CSCC 2-13-1",
                    "description" => "‏يجب تحديد وتوثيق واعتماد متطلبات الأمن السيبراني لحماية التطبيقات الداخلية الخاصة بالأنظمة\r\n‏الحساسة للجهة من المخاطر السيبرانية.",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-13-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Application Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "CSCC 2-13-2",
                    "long_name" => "CSCC 2-13-2",
                    "description" => "‏يجب تطبيق متطلبات الأمن السيبراني؛ لحماية التطبيقات الداخلية. الخاصة بالأنظمة الحساسة للجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-13-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Application Security'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "CSCC 2-13-3",
                    "long_name" => "CSCC 2-13-3",
                    "description" => "‏يجب أن تغطي متطلبات الأمن السيبراني؛ لحماية التطبيقات الداخلية. الخاصة بالأنظمة الحساسة\r\nللجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-13-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Application Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CSCC 2-13-3-1",
                            "long_name" => "CSCC 2-13-3-1",
                            "description" => "استخدام مبدأ المعمارية ذات المستويات المتعددة )نه )‏ على\r\nأن لا يقل عدد المستويات عن ‎٣‏",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-13-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-13-3-2",
                            "long_name" => "CSCC 2-13-3-2",
                            "description" => ".)1117175 ‏استخدام بروتوكولات آمنة (مثل بروتوكول HTTPS",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-13-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-13-3-3",
                            "long_name" => "CSCC 2-13-3-3",
                            "description" => "‏توضيح سياسة الاستخدام الآمن للمستخدمين",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-13-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 2-13-3-4",
                            "long_name" => "CSCC 2-13-3-4",
                            "description" => "‏ الإدارة الآمنة للجلسات  ويشمل موثوالجلسات  وإقفالها  وإنهاء مهلتها .",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 2-13-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]
                ],
                [
                    "short_name" => "CSCC 2-13-4",
                    "long_name" => "CSCC 2-13-4",
                    "description" => "‏مراجعة متطلبات الأمن السيبراني لحماية التطبيقات الداخلية الخاصة بالأنظمة الحساسة للجهة دوريا.",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 2-13-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Application Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [
                    "short_name" => "CSCC 3-1-1",
                    "long_name" => "CSCC 3-1-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ١ - ٣‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي إدارة استمرارية الأعمال في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 3-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة الأمن السيبراني ضمن استمرارية الأعمال',
                            'document_status' => 1,
                            'creation_date' => date('Y-m-d'),
                            'last_review_date' => date('Y-m-d'),
                            'review_frequency' => 180,
                            'next_review_date' => date('Y-m-d', strtotime('+180 days')),
                            'framework_ids' => $framework->id,
                            'document_owner' => 1,
                            'additional_stakeholders' => '',
                            'team_ids' => '',
                            'created_by' => 1
                        ]
                    ],
                    "children" => [
                        [
                            "short_name" => "CSCC 3-1-1-1",
                            "long_name" => "CSCC 3-1-1-1",
                            "description" => "وضع مركز للتعافي من الكوارث للأنظمة الحساسة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 3-1-1-1",
                            "control_status" => "Not Implemented",

                            "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 3-1-1-2",
                            "long_name" => "CSCC 3-1-1-2",
                            "description" => "إدراج الأنظمة الحساسة؛ ضمن خطط التعافي من الكوارث",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 3-1-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 3-1-1-3",
                            "long_name" => "CSCC 3-1-1-3",
                            "description" => "إجراء اختبارات دورية؛ للتأكد من فعالية خطط التعافي. من الكوارث للأنظمة\r\nالحساسة. مرة واحدة سنوياً؛ على الأقل",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 3-1-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 3-1-1-4",
                            "long_name" => "CSCC 3-1-1-4",
                            "description" => "توصي الهيئة بإجراء اختبار دوري حي؛ للتعافي من الكوارث (1888 ط عن]) للأنظمة\r\nالحساسة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 3-1-1-4",
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
                    "short_name" => "CSCC 4-1-1",
                    "long_name" => "CSCC 4-1-1",
                    "description" => "بالإضافة للضوابط ضمن المكون الفرعي ع - ‎١‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي متطلبات الأمن السيبراني. المتعلقة بالأطراف الخارجية",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 4-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CSCC 4-1-1-1",
                            "long_name" => "CSCC 4-1-1-1",
                            "description" => "إجراء المسح الأمني لشركات خدمات الإسناد. وموظفي\r\nخدمات الإسناد. والخدمات المدارة العاملين على الأنظمة الحساسة",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 4-1-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "CSCC 4-1-1-2",
                            "long_name" => "CSCC 4-1-1-2",
                            "description" => "أن تكون خدمات الإسناد. والخدمات المدارة على الأنظمة الحساسة؛ عن طريق شركات»\r\nوجهات وطنية؛ وفقاً للمتطلبات التشريحية. والتنظيمية ذات العلاقة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 4-1-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]
                ],
                [
                    "short_name" => "CSCC 4-2-1",
                    "long_name" => "CSCC 4-2-1",
                    "description" => "‏بالإضافة للضوابط الفرعية ضمن الضابط © - ‎٣ - ٢‏ في الضوابط الأساسية للأمن السيراني. يجب أن تغطي متطلبات الأمن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية والاستضافة",
                    "supplemental_guidance" => null,
                    "control_number" => "CSCC 4-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cloud Computing and hosting Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [


                        [
                            "short_name" => "CSCC 4-2-1-1",
                            "long_name" => "CSCC 4-2-1-1",
                            "description" => "أن يكون موقع استضافة الأنظمة الحساسة. أو أي جزء من مكوناتها التقنية. داخل\r\n‏الجهة. أو في خدمات الحوسبة السحابية. المقدمة من قبل جهات حكومية. أو شركات وطنية\r\n‏محققة لضوابط الحوسبة السحابية الصادرة من الهيئة مع مراعاة تصنيف البيانات المستضافة.",
                            "supplemental_guidance" => null,
                            "control_number" => "CSCC 4-2-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cloud Computing and hosting Cybersecurity'),
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

        // Log the data to be insertedN
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