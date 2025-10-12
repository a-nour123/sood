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

class NCATCCSeeder extends Seeder
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
                    ['name' => 'صمود الأمن السيبراني'],
                    ['icon' => 'fas fa-unlink']
                );
            }



            // Insert framework data
            $framework = Framework::create([
                'name' => 'NCA-TCC',
                'description' => "Based on the objectives of the National Cybersecurity Authority (NCA) strategy and in continuation of its role in regulating and protecting the Kingdom's cyberspace, NCA has issued the Telework Cybersecurity Controls (TCC) document. These controls were developed after reviewing many international cybersecurity standards, frameworks, controls and international practices in cybersecurity. The document aims to contribute to raising the level of cybersecurity at the national level by enabling the organization to perform its work remotely in a secure manner and adapt to the changes in the business environment and telework systems, and enhancing the organization’s cybersecurity capabilities and resilience against cyber threats when providing remote work. These controls are an extension to the Essential Cybersecurity Controls (ECC).",
                'icon' => 'fa-user-times',
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
                        ['name' => 'Cybersecurity Risk Management', 'order' => '5'],
                        ['name' => 'Cybersecurity Awareness and Training Program', 'order' => '10'],
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

                    ]
                ],

                [
                    'name' => 'Third-Party and Cloud Computing Cybersecurity',
                    'order' => '4',
                    'subdomains' => [
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
                    "short_name" => "TCC 1-1-1",
                    "long_name" => "TCC 1-1-1",
                    "description" => "رجوعا للضابط 1- 3-1 يف الضوابط الاساسيةللامن السيرباني، يجب أن تغطي سياسات وإجراءات\r\nالامن السيرباني",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 1-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Policies and Procedures'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "TCC 1-1-1-1",
                            "long_name" => "TCC 1-1-1-1",
                            "description" => "رجوعا للضابط 1- 3-1 يف الضوابط الاساسية للأمن السيرباني، يجب أن تغطي سياسات وإجراءات\r\nالامن السيرباني بحد أدى تحديد وتوثيق متطلبات وضوابط الامن السيرباني للعمل عن بعد ضمن سياسات\r\nالامن السيرباني للجهة",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 1-1-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Policies and Procedures'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ],


                ],
                [

                    "short_name" => "TCC 1-2-1",
                    "long_name" => "TCC 1-2-1",
                    "description" => "بالاضافة للضوابط ضمن المكون الفرعي 1 - 5 يف الضوابط الاساسية لألمن السيرباني، يجب أن\r\nتغطي منهجية إدارة مخاطر الامن السيرباني",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 1-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "TCC 1-2-1-1",
                            "long_name" => "TCC 1-2-1-1",
                            "description" => "بالاضافة للضوابط ضمن المكون الفرعي 1 - 5 يف الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي منهجية إدارة مخاطر الامن السيرباني بحد أدى   تقييم مخاطر الامن السيرباني ألانظمة العمل عن بعد، مرة واحدة سنوياً، عىل\r\nالاقل",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 1-2-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [

                            "short_name" => "TCC 1-2-1-2",
                            "long_name" => "TCC 1-2-1-2",
                            "description" => "بالاضافة للضوابط ضمن المكون الفرعي 1 - 5 يف الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي منهجية إدارة مخاطر الامن السيرباين بحد أدى   تقييم مخاطر الامن السيرباني عند التخطيط وقبل السامح بالعمل عن بعد ألي\r\nخدمة أو نظام.",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 1-2-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [

                            "short_name" => "TCC 1-2-1-3",
                            "long_name" => "TCC 1-2-1-3",
                            "description" => "تضمني مخاطر الامن السيرباين الخاصة بأنظمة العمل عن بعد والخدمات\r\nوالانظمة المسموح لها بالعمل عن بعد يف سجل مخاطر الامن السيرباني الخاص\r\nبالجهة، ومتابعته مرة واحدة سنويا، عىل الاقل",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 1-2-1-3",
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

                    "short_name" => "TCC 1-3-1",
                    "long_name" => "TCC 1-3-1",
                    "description" => "بالاضافة للضوابط الفرعية ضمن الضابط 1 - 10 -3 يف الضوابط الاساسية للامن السيرباي، فإنه\r\nيجب أن يغطي برنامج التوعية بالامن السيرباني المخاطر والتهديدات السيربانية للعمل عن بعد\r\nوالاستخدام الامن للحد من هذه المخاطر والتهديدات",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 1-3-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "TCC 1-3-1-1",
                            "long_name" => "TCC 1-3-1-1",
                            "description" => "الاستخدام الامن للأجهزة المخصصة للعمل عن بعد والمحافظة عليها وحاميتها.",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 1-3-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "TCC 1-3-1-2",
                            "long_name" => "TCC 1-3-1-2",
                            "description" => "التعامل الامن مع هويات الدخول وكلمات المرور.",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 1-3-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "TCC 1-3-1-3",
                            "long_name" => "TCC 1-3-1-3",
                            "description" => "حامية البيانات التي يتم حفظها على الاجهزة المستخدمة للعمل عن بعد\r\nوالتعامل معها حسب تصنيفها وإجراءات وسياسات الجهة",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 1-3-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('صمود الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'لوائح صمود الامن السيبراني',
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
                            ]

                        ],
                        [

                            "short_name" => "TCC 1-3-1-4",
                            "long_name" => "TCC 1-3-1-4",
                            "description" => "التعامل الامن مع التطبيقات والحلول المستخدمة للعمل عن بعد كالاجتامعات\r\nاالفرتاضية، والتعاون ومشاركة الملفات",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 1-3-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "TCC 1-3-1-5",
                            "long_name" => "TCC 1-3-1-5",
                            "description" => "التعامل الامن مع الشبكات المنزلية والتأكد من إعدادت الحامية الخاصة بها",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 1-3-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "TCC 1-3-1-6",
                            "long_name" => "TCC 1-3-1-6",
                            "description" => "تجنب العمل عن بعد باستخدام أجهزة أو شبكات عامة غري موثوقة أو أثناء\r\nالتواجد يف أماكن عامة.",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 1-3-1-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "TCC 1-3-1-7",
                            "long_name" => "TCC 1-3-1-7",
                            "description" => "الوصول الملادي غري مصرح به والفقدان والرسقة والتخريب الأصول التقنية\r\nوأنظمة العمل عن بعد.",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 1-3-1-7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "TCC 1-3-1-8",
                            "long_name" => "TCC 1-3-1-8",
                            "description" => "التواصل مبارشة مع اإلدارة املعنية باألمن السيرباين يف الجهة حال االشتباه بتهديد\r\nأمن سيرباي",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 1-3-1-8",
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

                    "short_name" => "TCC 1-3-2",
                    "long_name" => "TCC 1-3-2",
                    "description" => "بالاضافة للضوابط الفرعية ضمن الضابط 1 - 10 - 4 يف الضوابط الاساسية للامن السيرباني، فإنه\r\nيجب تدريب العاملين على المهارات التقنية الالزمة لضامن تطبيق متطلبات ومامرسات الامن\r\nالسيرباني عند التعامل مع أنظمة العمل عن بعد",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 1-3-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [

                    "short_name" => "TCC 2-1-1",
                    "long_name" => "TCC 2-1-1",
                    "description" => "بالاضافة للضوابط ضمن المكون الفرعي 2-1 يف الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي متطلبات الامن السيرباني إلادارةالاصول المعلوماتية والتقنية",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'),

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "TCC 2-1-1-1",
                            "long_name" => "TCC 2-1-1-1",
                            "description" => "تحديد وحرص الاصول المعلوماتية والتقنية للانظمة العمل عن بعد، وتحديثها\r\nمرة واحدة، كل سنة؛ عىل الاقل",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-1-1-1",
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
                    "short_name" => "TCC 2-2-1",
                    "long_name" => "TCC 2-2-1",
                    "description" => "بالاضافة للضوابط الفرعية ضمن الضابط 2-2-3 يف الضوابط الاساسية للامن السيرباني، يجب\r\nأن تغطي متطلبات الامن السيرياني المتعلقة بإدارة هويات الدخول، والصلاحيات للانظمة\r\nالمستخدمة يف العمل عن بعد في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "TCC 2-2-1-1",
                            "long_name" => "TCC 2-2-1-1",
                            "description" => "ً على احتياجات العمل، مع\r\nإدارة صلاحيات المستخدمين للعمل عن بعد بناء\r\nمراعاة حساسيةالانظمة ومستوى الصلاحيات، ونوعية الاجهزة المستخدمة من\r\nقبل الموظفين للعمل عن بعد",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-2-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",


                        ],
                        [
                            "short_name" => "TCC 2-2-1-2",
                            "long_name" => "TCC 2-2-1-2",
                            "description" => "تقييد إمكانية الوصول عن بعد لنفس المستخدم من أجهزة حاسبات متعددة\r\nيف نفس الوقت )Logins Concurrent.",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-2-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",


                        ],
                        [
                            "short_name" => "TCC 2-2-1-3",
                            "long_name" => "TCC 2-2-1-3",
                            "description" => "استخدام معايري آمنة إلادارة الهويات وكليمات المرور المستخدمة في أنظمة\r\nالعمل عن بعد.",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-2-1-3",
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
                    "short_name" => "TCC 2-2-2",
                    "long_name" => "TCC 2-2-2",
                    "description" => "رجوعاً للضابط الفرعي 2-2-3-5 يف الضوابط الاساسية للامن السيرباني، يجب مراجعة هويات\r\nالدخول والصلاحيات المستخدمة للعمل عن بعد، بحد أدنى مرة واحدة كل سنة",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-2-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "TCC 2-3-1",
                    "long_name" => "TCC 2-3-1",
                    "description" => "بالاضافة للضوابط الفرعية ضمن الضابط 2-3-3 في الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي متطلبات الامن السيرباني لحامية أنظمة العمل عن بعد، وأجهزة المعلومات الخاصة بها،",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-3-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "TCC 2-3-1-1",
                            "long_name" => "TCC 2-3-1-1",
                            "description" => "تطبيق حزم التحديثات، والاصلاحات الامنية للانظمة العمل عن بعد، مرة واحدة\r\nشهريا على الاقل",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-3-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",


                        ],
                        [
                            "short_name" => "TCC 2-3-1-2",
                            "long_name" => "TCC 2-3-1-2",
                            "description" => "مراجعة إعدادات الحاميةالانظمة العمل عن بعد والتحصين\r\n)Hardening and Configuration Secure ،)مرة واحدة كل سنة عىل الاقل",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-3-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",


                        ],
                        [
                            "short_name" => "TCC 2-3-1-3",
                            "long_name" => "TCC 2-3-1-3",
                            "description" => "مراجعة وتحصين الاعدادت المصنعية )Configuration Default )لأصولا\r\nالتقنية الانظمة العمل عن بعد، ومنها وجود كليمات مرور ثابتة، وخلفية\r\nافتراضية",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-3-1-3",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",


                        ],
                        [
                            "short_name" => "TCC 2-3-1-4",
                            "long_name" => "TCC 2-3-1-4",
                            "description" => "اإالدارة آلامنة لجلسات )Management Session Secure ،)ويشمل موثوقية\r\nالجلسات )Authenticity ،)وإقفالها )Lockout ،)وإنهاء مهلتها )Timeout.)",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-3-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",


                        ],
                        [
                            "short_name" => "TCC 2-3-1-5",
                            "long_name" => "TCC 2-3-1-5",
                            "description" => "تقييد تفعيل الخصائص والخدمات في أنظمة العمل عن بعد حسب الحاجة،\r\nعىل أن يتم تحليل المخاطر السيربانية المحتملة في حال الحاجة لتفعيلها.",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-3-1-5",
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
                    "short_name" => "TCC 2-4-1",
                    "long_name" => "TCC 2-4-1",
                    "description" => "بالاضافة للضوابط الفرعية ضمن الضابط 2-5-3 في الضوابط الاساسية للامن السيرباين، يجب\r\nأن تغطي متطلبات اللمن السيرباني إلادارة أمن شبكات الجهة للعمل عن بعد",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-4-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Networks Security Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "TCC 2-4-1-1",
                            "long_name" => "TCC 2-4-1-1",
                            "description" => "تقييد منافذ وبروتوكوالت وخدمات الشبكة المستخدمة لعمليات الدخول عن\r\nبعد، وخصوصاً على الانظمة الداخلية، وفتحها حسب الحاجة",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-4-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "TCC 2-4-1-2",
                            "long_name" => "TCC 2-4-1-2",
                            "description" => "مراجعة إعدادات وقوائم جدار الحامية )Rules Firewall )ذات العلاقة\r\nبأنظمة العمل عن بعد؛ مرة واحدة كل سنة على الاقل",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-4-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "TCC 2-4-1-3",
                            "long_name" => "TCC 2-4-1-3",
                            "description" => "الحامية من هجامت تعطيل الشبكات ))DDoS (Service of Denial Distributed )\r\nعلى أنظمة العمل عن بعد للحد من المخاطر الناتجة عن هجامت تعطيل الشبكات",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-4-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "TCC 2-4-1-4",
                            "long_name" => "TCC 2-4-1-4",
                            "description" => "الحامية من التهديدات المتقدمة المستمرة عىل مستوى الشبكة ألانظمة العمل\r\nعن بعد )APT Network.",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-4-1-4",
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
                    "short_name" => "TCC 2-5-1",
                    "long_name" => "TCC 2-5-1",
                    "description" => "بالاضافة للضوابط الفرعية ضمن الضابط 2-6-3 يف الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي متطلبات الامن السيرباني الخاصة بأمن الاجهزة المحمولة للعمل عن بعد في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-5-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "TCC 2-5-1-1",
                            "long_name" => "TCC 2-5-1-1",
                            "description" => "إدارة الاجهزة المحمولة وأجهزة )BYOD )مركزياً باستخدام نظام إدارة الاجهزة\r\nالمحمولة ))MDM (Management Device Mobile.)",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-5-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "TCC 2-5-1-2",
                            "long_name" => "TCC 2-5-1-2",
                            "description" => "تطبيق حزم التحديثات، والاصلاحات األمنية للأجهزة المحمولة، مرة واحدة\r\nشهريا، على الاقل",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-5-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],

                    ]

                ],

                [
                    "short_name" => "TCC 2-6-1",
                    "long_name" => "TCC 2-6-1",
                    "description" => "بالاضافة للضوابط الفرعية ضمن الضابط 2-7-3 يف الضوابط الاساسية للامن السيرباني، يجب\r\nأن تغطي متطلبات الامن السيرباني لحامية البيانات والمعومات للعمل عن بعد في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-6-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "TCC 2-6-1-1",
                            "long_name" => "TCC 2-6-1-1",
                            "description" => "تحديد البيانات المصنفة، حسب الترشيعات ذات العلاقة، التي ميكن استخدامها\r\nأو الوصول إليها أو التعامل معها من خلال أنظمة العمل عن بعد",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-6-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "TCC 2-6-1-2",
                            "long_name" => "TCC 2-6-1-2",
                            "description" => "حامية البيانات المصنفة، التي تم تحديدها في الضابط 2-6-1-1 ،باستخدام\r\nضوابط مثل منع استخدام نوع من البيانات المصنفة أو تقنيات مثل منع\r\nترسيب البيانات )Prevention Leakage Data .)وميكن تحديد هذه الضوابط\r\nوالتقنيات عن طريق تحليل المخاطر السيربانية للجهة",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-6-1-2",
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
                    "short_name" => "TCC 2-7-1",
                    "long_name" => "TCC 2-7-1",
                    "description" => "بالاضافة للضوابط الفرعية ضمن الضابط 2-8-3 في الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي متطلبات الامن السيرباني الخاصة بالتشفر لدى المشرتكين،",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-7-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cryptography'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "TCC 2-7-1-1",
                            "long_name" => "TCC 2-7-1-1",
                            "description" => "استخدام طرق وخوارزميات محدثة وآمنة للتشفري على كامل الاتصال الشبيك\r\nالمستخدم للعمل عن بعد وفقاً للمستوى المتقدم )Advanced )ضمن المعايري\r\nالوطنية للتشفري )2020:1 – NCS.)",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-7-1-1",
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
                    "short_name" => "TCC 2-8-1",
                    "long_name" => "TCC 2-8-1",
                    "description" => "بالاضافة للضوابط الفرعية ضمن الضابط 2-9-3 في الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي متطلبات الامن السيرباني إلادارة النسخ الاحتياطية ألانظمة العمل عن بعد في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-8-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "TCC 2-8-1-1",
                            "long_name" => "TCC 2-8-1-1",
                            "description" => "عمل النسخ الاحتياطي على فرتات زمنية مخطط لها؛ بناء عىل تقييم المخاطر\r\nللجهة، لأنظمة العمل عن بعد. وتوصي الهيئة بأن يتم عمل النسخ الاحتياطية،\r\nلانظمة العمل عن بعد مرة واحدة كل أسبوع",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-8-1-1",
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
                    "short_name" => "TCC 2-8-2",
                    "long_name" => "TCC 2-8-2",
                    "description" => "رجوعاً للضابط 2-9-3-3 في الضوابط الاساسية الامن السيرباني، يجب إجراء فحص دوري؛ كل\r\nستة أشهر على الاقل، لتحديد مدى فعالية استعادة النسخ الاحتياطية، الخاصة بأنظمة العمل\r\nعن بعد",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-8-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "TCC 2-9-1",
                    "long_name" => "TCC 2-9-1",
                    "description" => "بالاضافة للضوابط الفرعية ضمن الضابط 2-10-3 في الضوابط الاساسية الامن السيرباني، يجب\r\nأن تغطي متطلبات الامن السيرباني إلادارة الثغرات الأصول التقنية وأنظمة العمل عن بعد",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-9-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "TCC 2-9-1-1",
                            "long_name" => "TCC 2-9-1-1",
                            "description" => "فحص الثغرات واكتشافها على أنظمة العمل عن بعد وتصنيفها حسب خطورتها،\r\nمرة واحدة كل ثالثة أشهر على الاقل",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-9-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "TCC 2-9-1-2",
                            "long_name" => "TCC 2-9-1-2",
                            "description" => "معالجة الثغرات عىل أنظمة العمل عن بعد، مرة واحدة كل ثالثة أشهر عىل\r\nاألقل.",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-9-1-2",
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
                    "short_name" => "TCC 2-10-1",
                    "long_name" => "TCC 2-10-1",
                    "description" => "بالاضافة للضوابط الفرعية ضمن الضابط ٢-١١-٣ يف الضوابط الاساسية للامن السيرباني، يجب\r\nأن تغطي متطلبات الامن السيرباني لاختبار ااختراق لانظمة العمل عن بعد،",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-10-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Penetration Testing'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "TCC 2-10-1-1",
                            "long_name" => "TCC 2-10-1-1",
                            "description" => "نطاق عمل اختبارالاختراق، ليشمل جميع المكونات التقنية لانظمة العمل عن\r\nبعد",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-10-1-1",
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
                    "short_name" => "TCC 2-10-2",
                    "long_name" => "TCC 2-10-2",
                    "description" => "رجوعاً للضابط ٢-١١-٣-٢ في الضوابط الاساسية للامن السيرباني، يجب عمل اختبار الاختراق على\r\nأنظمة العمل عن بعد مرة واحدة كل سنة على الاقل",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-10-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Penetration Testing'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [
                    "short_name" => "TCC 2-11-1",
                    "long_name" => "TCC 2-11-1",
                    "description" => "بالاضافة للضوابط الفرعية ضمن الضابط 2-12-3 في الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي متطلبات إدارة سجلات الاحداث، ومراقبة الامن السيرباني لاصول التقنية وأنظمة العمل\r\nعن بعد",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-11-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "TCC 2-11-1-1",
                            "long_name" => "TCC 2-11-1-1",
                            "description" => "تفعيل سجلات الاحداث )Logs Event )الخاصة بالامن السيرباني على الاصول\r\nالتقنية وأنظمة العمل عن بعد",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-11-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "TCC 2-11-1-2",
                            "long_name" => "TCC 2-11-1-2",
                            "description" => "مراقبة سلوك مستخدمي أنظمة العمل عن بعد ))UBA (Analytics Behavior User )\r\nوتحليله",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-11-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "TCC 2-11-1-3",
                            "long_name" => "TCC 2-11-1-3",
                            "description" => "مراقبة سجلات الاحداث، الخاصة بالاصول التقنية وأنظمة العمل عن بعد على\r\nمدار الساعة.",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-11-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "TCC 2-11-1-4",
                            "long_name" => "TCC 2-11-1-4",
                            "description" => "تحديث إجراءات مراقبة الامن السيرباني على مدار الساعة وتطبيقها، بحيث\r\nتشمل مراقبة عمليات الدخول عن بعد، والسيام عمليات الدخول عن بعد من\r\nخارج المملكة والتحقق من صحتها.",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-11-1-4",
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
                    "short_name" => "TCC 2-11-2",
                    "long_name" => "TCC 2-11-2",
                    "description" => "رجوعاً للضابط 2-12-3-5 في الضوابط الاساسية للامن السيرباني، يجب أال تقل مدة الاحتفاظ\r\nبسجلات الاحداث الخاصة بالامن السيرباني ألانظمة العمل عن بعد عن 12 شهراً؛ حسب المتطلبات\r\nالترشيعية والتنظيمية ذات العلاقة.",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-11-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],


                [
                    "short_name" => "TCC 2-12-1",
                    "long_name" => "TCC 2-12-1",
                    "description" => "بالاضافة للضوابط الفرعية ضمن الضابط 2-13-3 في الضوابط الاساسية الامن السيرباني، يجب أن\r\nتغطي متطلبات إدارة حوادث وتهديدات الامن السيرباني في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 2-12-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "TCC 2-12-1-1",
                            "long_name" => "TCC 2-12-1-1",
                            "description" => "تحديث خطط الاستجابة لحوادث الامن السيرباني ومعلومات التواصل داخل\r\nالجهة مبا يتوافق مع حالة العمل عن بعد، ومبا يضمن القدرة عىل التواصل\r\nوجاهزية فرق الاستجابة للحوادث",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-12-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "TCC 2-12-1-2",
                            "long_name" => "TCC 2-12-1-2",
                            "description" => "الحصول على المعلومات الاستباقية )Intelligence Threat )ذات العلاقة\r\nبأنظمة العمل عن بعد بشكل دوري والتعامل معها.",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-12-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "TCC 2-12-1-3",
                            "long_name" => "TCC 2-12-1-3",
                            "description" => "تنفيذ وتطبيق التوصيات والتنبيهات الخاصة بحوادث وتهديدات الامن السيرباني\r\nالصادرة من مرشف القطاع أو الهيئة الوطنية الامن السيرباني",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 2-12-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "TCC 3-1-1",
                    "long_name" => "TCC 3-1-1",
                    "description" => "بالالضافة للضوابط الفرعية ضمن الضابط 4- 2-3 في الضوابط الاساسية الامن السرياني، يجب أن\r\nتغطي متطلبات الامن السيرباني الخاصة باستخدام خدمات الحوسبة السحابية والاستضافة",
                    "supplemental_guidance" => null,
                    "control_number" => "TCC 3-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cloud Computing and hosting Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "TCC 3-1-1-1",
                            "long_name" => "TCC 3-1-1-1",
                            "description" => "موقع استضافة أنظمة العمل عن بعد يجب أن يكون داخل اململكة.",
                            "supplemental_guidance" => null,
                            "control_number" => "TCC 3-1-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cloud Computing and hosting Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ],

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
