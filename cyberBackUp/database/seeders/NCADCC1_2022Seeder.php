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

class NCADCC1_2022Seeder extends Seeder
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
                'name' => 'NCA-DCC-1:2022',
                'description' => "In continuation of its role in regulating and protecting the Kingdom's cyberspace, NCA has issued the Data Cybersecurity Controls (DCC-1:2022). These controls have been developed after conducting a comprehensive study of multiple national and international cybersecurity standards, frameworks and controls, studying related laws and regulations, reviewing cybersecurity best practices and analyzing cybersecurity risks, threats, previous incidents and attacks at the national level.",
                'icon' => 'fa-usb',
                'status' => '1',
                'regulator_id' => $this->regulatorId,

            ]);


            // Main domains with their subdomains
            $mainDomains = [
                [
                    'name' => 'Cybersecurity Governance',
                    'order' => '1',
                    'subdomains' => [

                        ['name' => 'Cybersecurity Periodical Assessment and Audit', 'order' => '8'],
                        ['name' => 'Cybersecurity in Human Resources', 'order' => '9'],
                        ['name' => 'Cybersecurity Awareness and Training Program', 'order' => '10'],
                    ]
                ],
                [
                    'name' => 'Cybersecurity Defense',
                    'order' => '2',
                    'subdomains' => [
                        ['name' => 'Identity and Access Management', 'order' => '2'],
                        ['name' => 'Information System and Processing Facilities Protection', 'order' => '3'],
                        ['name' => 'Mobile Devices Security', 'order' => '6'],
                        ['name' => 'Data and Information Protection', 'order' => '7'],
                        ['name' => 'Cryptography', 'order' => '8'],
                        [
                            'name' => 'secure Data Disposal',
                            'order' => '21',
                        ],
                        [
                            'name' =>
                            'Cybersecurity for printers,scanners and Copy machines',
                            'order' => '22',
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
                    "short_name" => "DCC 1-1-1",
                    "long_name" => "DCC 1-1-1",
                    "description" => "رجوعا للضابط ‎١-١-١‏ في الضوابط الأساسية للأمن السيبراني. فإنه يجب على الإدارة المعنية\r\n\r\n‏بالأمن السيبراني في الجهة مراجعة تطبيق ضوابط الأمن السيبراني للبيانات حسب المدة كل سنة على الأقل\r\nالمحددة لكل مستوى",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 1-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Periodical Assessment and Audit'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [

                    "short_name" => "DCC 1-1-2",
                    "long_name" => "DCC 1-1-2",
                    "description" => "حا رجوعًا للضابط ‎3-0-١‏ في الضوابط الأساسية للأمن السيبراني يجب أن تتم مراجعة كل سنتان\r\nتطبيق ضوابط الأمن السيبراني للبيانات من قبل أطراف مستقلة عن الإدارة المعنية بالأمن",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 1-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Periodical Assessment and Audit'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [

                    "short_name" => "DCC 1-2-1",
                    "long_name" => "DCC 1-2-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-٢-١‏ في الضوابط الأساسية للأمن السيبراني يجب\r\nأن تغطي متطلبات الأمن السيبراني المتعلقة بالموارد البشرية لتشمل خلال وبعد إنتهاء\/إنهاء\r\nالعلاقة الوظيفية في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 1-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "DCC 1-2-1-1",
                            "long_name" => "DCC 1-2-1-1",
                            "description" => "إجراء المسح الأمني (screening 5) للعاملين في الوظائف ذات\r\nالعلاقة بالتعامل مع البيانات",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 1-2-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'), // Dynamically get family ID
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 1-2-1-2",
                            "long_name" => "DCC 1-2-1-2",
                            "description" => "تعهد العاملين في الجهة بعدم استخدام تطبيقات التراسل أو التواصل\r\nالإجتماعي أو خدمات التخزين السحابية الشخصية لإنشاء أو تخزين أو\r\nمشاركة البيانات الخاصة بالجهة. باستثناء تطبيقات التراسل الآمنة المعتمدة\r\nمن الجهات ذات العلاقة.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 1-2-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'), // Dynamically get family ID
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],

                    ]

                ],


                [

                    "short_name" => "DCC 1-3-1",
                    "long_name" => "DCC 1-3-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-١٠-١‏ في الضوابط الأساسية للأمن السيبراني. فإنه\r\nيجب أن يغطي برنامج التوعية بالأمن السيبراني المحاور المتعلقة بحماية البيانات",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 1-3-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "DCC 1-3-1-1",
                            "long_name" => "DCC 1-3-1-1",
                            "description" => "مخاطر التسريب والوصول غير المصرح به للبيانات خلال دورة حياتها.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 1-3-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 1-3-1-2",
                            "long_name" => "DCC 1-3-1-2",
                            "description" => "التعامل الآمن مع البيانات المصنفة خلال السفر والتواجد خارج مكان العمل",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 1-3-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 1-3-1-3",
                            "long_name" => "DCC 1-3-1-3",
                            "description" => "التعامل الآمن مع البيانات خلال الاجتماعات (الافتراضية والحضورية).",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 1-3-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 1-3-1-4",
                            "long_name" => "DCC 1-3-1-4",
                            "description" => "الاستخدام الآمن للطابعات والماسحات الضوئية وآلات التصوير.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 1-3-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 1-3-1-5",
                            "long_name" => "DCC 1-3-1-5",
                            "description" => "إجراءات الإتلاف الآمن للبيانات.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 1-3-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 1-3-1-6",
                            "long_name" => "DCC 1-3-1-6",
                            "description" => "مخاطر مشاركة الوثائق والمعلومات من خلال قنوات تواصل غير مؤمنة",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 1-3-1-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 1-3-1-7",
                            "long_name" => "DCC 1-3-1-7",
                            "description" => "المخاطر السيبرانية المتعلقة باستخدام وسائط التخزين الخارجية",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 1-3-1-7",
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

                    "short_name" => "DCC 2-1-1",
                    "long_name" => "DCC 2-1-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-٢-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب\r\n\r\n‏أن تغطي متطلبات الأمن السيبراني المتعلقة بإدارة هويات الدخول والصلاحيات",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 2-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "DCC 2-1-1-1",
                            "long_name" => "DCC 2-1-1-1",
                            "description" => "التقييد الحازم بالسماح للحد الأدنى من العاملين للوصول والاطلاع ومشاركة\r\nالبيانات بناء على قوائم صلاحيات مقتصرة على موظفين سعوديين إلا بموجب\r\nاستثناء من قبل صاحب الصلاحية (رئيس الجهة أو من يفوضه) وعاى أن يتم\r\nإعتمادهذه القوائم من قبل صاحب الصلاحية",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-1-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 2-1-1-2",
                            "long_name" => "DCC 2-1-1-2",
                            "description" => "منع مشاركة قوائم الصلاحيات المعتمدة مع الأشخاص غير المصرح لهم.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-1-1-2",
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
                    "short_name" => "DCC 2-1-2",
                    "long_name" => "DCC 2-1-2",
                    "description" => "إدارة هويات الدخول وصلاحيات الاطلاع على البيانات باستخدام أنظمة إدارة الصلاحيات\r\nالهامة والحساسة",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 2-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "DCC 2-1-3",
                    "long_name" => "DCC 2-1-3",
                    "description" => "بالإضافة للضابط الفرعي ‎٥-٢-٢-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب مراجعة قوائم\r\nالصلاحيات المعتمدة والصلاحيات المستخدمة",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 2-1-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [
                    "short_name" => "DCC 2-2-1",
                    "long_name" => "DCC 2-2-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط ‎2-7-١‏ في الضوابط الأساسية للأمن السيبراني",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 2-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "DCC 2-2-1-1",
                            "long_name" => "DCC 2-2-1-1",
                            "description" => "تطبيق حزم التحديثات. والإصلاحات الأمنية من وقت إطلاقها للأنظمة\r\nالمستخدمة للتعامل مع البيانات حسب المدة المحددة لكل مستوى.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-2-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 2-2-1-2",
                            "long_name" => "DCC 2-2-1-2",
                            "description" => "مراجعة إعدادات الحماية والتحصين للأنظمة المستخدمة للتعامل مع البيانات\r\n) ھ منم ) حسب المدة المحددة لكل\r\n‏مستوى.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-2-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 2-2-1-3",
                            "long_name" => "DCC 2-2-1-3",
                            "description" => "مراجعة وتحصين الإعدادات المصنعية",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-2-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 2-2-1-4",
                            "long_name" => "DCC 2-2-1-4",
                            "description" => "تعطيل خاصية تصوير الشاشة  ) للأجهزة\r\nالتي تنشئ أو تعالج الوثائق",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-2-1-4",
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
                    "short_name" => "DCC 2-3-1",
                    "long_name" => "DCC 2-3-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط 2-7-3 في الضوابط الأساسية للأمن السيبراني. يجب\r\nأن تغطي متطلبات الأمن السيبراني الخاصة بأمن الأجهزة المحمولة",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 2-3-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "DCC 2-3-1-1",
                            "long_name" => "DCC 2-3-1-1",
                            "description" => "إدارة الأجهزة المحمولة المملوكة للجهة مركزيا باستخدام نظام إدارة الأجهزة\r\nالمحمولة ) - س ء علنم”) وتفعيل خاصية\r\nالحذف عن بعد.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-3-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 2-3-1-2",
                            "long_name" => "DCC 2-3-1-2",
                            "description" => "إدارة أجهزة (ط0ل8) مركزيا باستخدام نظام إدارة الأجهزة المحمولة\r\n) - ه ء علناه”) وتفعيل خاصية الحذف عن يمنع إستخدام\r\nبعد. أجهزة",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-3-1-2",
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
                    "short_name" => "DCC 2-4-1",
                    "long_name" => "DCC 2-4-1",
                    "description" => "استخدام خاصية العلامات المائية لترميز كامل الوثيقة عند الإنشاء والتخزين\r\n‏والطباعة وعلى الشاشة وعلى كل نسخة",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 2-4-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "DCC 2-4-1-1",
                            "long_name" => "DCC 2-4-1-1",
                            "description" => "استخدام خاصية العلامات المائية لترميز كامل الوثيقة عند الإنشاء والتخزين\r\n\r\n‏والطباعة وعلى الشاشة وعلى كل نسخة بحيث يكون الرمز يمكن تتبعه على\r\n‏1 4 4\r\nمستوى المستخدم أو الجهاز",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-4-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 2-4-1-2",
                            "long_name" => "DCC 2-4-1-2",
                            "description" => "استخدام تقنيات منع تسريب البيانات )مم (\r\nوتقنيات إدارة الصلاحيات",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-4-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 2-4-1-3",
                            "long_name" => "DCC 2-4-1-3",
                            "description" => "ظر استخدام البيانات في أي بيئة غير بيئة الإنتاج ) منع\r\n( للمخاطر وتطبيق ضوابط لحماية تلك",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-4-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 2-4-1-4",
                            "long_name" => "DCC 2-4-1-4",
                            "description" => "استخدام خدمة حماية العلامة التجارية لحماية هوية الجهة من الانتحال\r\n) (.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-4-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Data and Information Protection'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ],


                ],
                [
                    "short_name" => "DCC 2-5-1",
                    "long_name" => "DCC 2-5-1",
                    "description" => "بالإضافة للضوابط الفرعية ضمن الضابط 7-8-3 في الضوابط الأساسية للأمن السيبراني. يجب\r\nأن تغطي متطلبات الأمن السيبراني للتشفير في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 2-5-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cryptography'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "DCC 2-5-1-1",
                            "long_name" => "DCC 2-5-1-1",
                            "description" => "ستخدام طرق وخوارزميات محدثة وآمنة للتشفير عند الإنشاء والتخزين\r\nوالمشاركة وعلى كامل الاتصال الشبكي المستخدم لنقل البيانات وفقا للمستوى\r\nالمتقدم (لع2صة٧4)‏ ضمن المعايير الوطنية للتشفير (1:2020 - 0108.\r\nاستخدام طرق وخوارزميات محدثة وآمنة للتشفير عند الإنشاء والتخزين\r\nوالمشاركة وعلى كامل الاتصال الشبكي المستخدم لنقل البيانات وفقا للمستوى\r\nالمتوسط (ءء4٥)‏ ضمن المعايير الوطنية للتشفير",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-5-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cryptography'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 2-5-1-2",
                            "long_name" => "DCC 2-5-1-2",
                            "description" => "استخدام طرق وخوارزميات محدثة وآمنة للتشفير عند الإنشاء والتخزين\r\nوالمشاركة وعلى كامل الاتصال الشبكي المستخدم لنقل البيانات وفقا للمستوى\r\nالمتقدم (لع2صة٧4)‏ ضمن المعايير الوطنية للتشفير (1:2020 - 0108.\r\nاستخدام طرق وخوارزميات محدثة وآمنة للتشفير عند الإنشاء والتخزين\r\nوالمشاركة وعلى كامل الاتصال الشبكي المستخدم لنقل البيانات وفقا للمستوى\r\nالمتوسط (ءء4٥)‏ ضمن المعايير الوطنية للتشفير",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-5-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cryptography'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],

                    ],


                ],

                [
                    "short_name" => "DCC 2-6-1",
                    "long_name" => "DCC 2-6-1",
                    "description" => "يجب أن تغطي متطلبات الإتلاف الآمن للبيانات",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 2-6-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('secure Data Disposal'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "DCC 2-6-1-1",
                            "long_name" => "DCC 2-6-1-1",
                            "description" => "ديد التقنيات والأدوات والإجراءات لتنفيذ عمليات الإتلاف الآمن للبيانات\r\nحسب مستوى تصنيف البيا",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-6-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('secure Data Disposal'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 2-6-1-2",
                            "long_name" => "DCC 2-6-1-2",
                            "description" => "عند انتهاء الحاجة لاستخدام وسائط التخزين بشكل نهائي. يجب أن يتم\r\nالإتلاف الآمن (لةهمنط ©5007) لوسائط التخزين وذلك باستخدام\r\nالتقنيات والأدوات وبإتباع الإجراءات التي تم تحديدها في الضابط رقم ‎-٦-٢‏\r\n‎.١-١‏",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-6-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('secure Data Disposal'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "DCC 2-6-1-3",
                            "long_name" => "DCC 2-6-1-3",
                            "description" => "عند الحاجة لإعادة استخدام وسائط التخزين. يجب أن يتم الحذف الآمن\r\nللبيانات). بحيث لا يمكن استرجاعها",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-6-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('secure Data Disposal'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 2-6-1-4",
                            "long_name" => "DCC 2-6-1-4",
                            "description" => "جب أن يتم التحقق من تنفيذ عمليات الإتلاف أو الحذف الآمن للبيانات\r\nالمشار إليها في الضابطين رقم 7-1-7-7 و٢-٦-١۔٣.‏",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-6-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('secure Data Disposal'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "DCC 2-6-1-5",
                            "long_name" => "DCC 2-6-1-5",
                            "description" => "الاحتفاظ بسجل لعمليات الإتلاف أو الحذف الآمن للبيانات التي تم تنفيذها.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-6-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('secure Data Disposal'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],

                    ],

                ],
                [
                    "short_name" => "DCC 2-6-2",
                    "long_name" => "DCC 2-6-2",
                    "description" => "يجب مراجعة تطبيق متطلبات الإتلاف الآمن للبيانات في الجهة حسب المدة المحددة",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 2-6-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('secure Data Disposal'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "DCC 2-7-1",
                    "long_name" => "DCC 2-7-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الآمن السيبراني لحماية الطابعات والماسحات الضوئية\r\nوآلات التصوير في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 2-7-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity for printers,scanners and Copy machines'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [
                    "short_name" => "DCC 2-7-2",
                    "long_name" => "DCC 2-7-2",
                    "description" => "يجب تطبيق متطلبات الأمن السيبراني للطابعات والما سحات الضوئية وآلات الة صوير في\r\nالجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 2-7-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity for printers,scanners and Copy machines'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "DCC 2-7-3",
                    "long_name" => "DCC 2-7-3",
                    "description" => "يجب أن تغطي متطلبات الأمن السيبراني للطابعات والما سحات الضوئية وآلات التصوير",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 2-7-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity for printers,scanners and Copy machines'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                    "children" => [
                        [
                            "short_name" => "DCC 2-7-3-1",
                            "long_name" => "DCC 2-7-3-1",
                            "description" => "تعطيل خاصية التخزين المؤقت",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-7-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity for printers,scanners and Copy machines'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 2-7-3-2",
                            "long_name" => "DCC 2-7-3-2",
                            "description" => "تفعيل خاصية التحقق من الهوية في الطابعات واما سحات الضوئية والآت\r\nالتصوير المركزية قبل بدء عمليات الطباعة والتصوير والمسح الضوفي",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-7-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity for printers,scanners and Copy machines'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 2-7-3-3",
                            "long_name" => "DCC 2-7-3-3",
                            "description" => "الاحتفاظ بطريقة آمنة بسجل الكتروني للعمليات الخاصة با ستخدام\r\nالطابعات والماسحات الضوئية والآت التصوير. لفترة لا تقل عن ‎١٢‏ شهرا.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-7-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity for printers,scanners and Copy machines'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 2-7-3-4",
                            "long_name" => "DCC 2-7-3-4",
                            "description" => "تفعيل وحماية سجلات المراقبة لأنظمة 00177 على مواقع أجهزة الطباعة\r\nالمركزية والماسحات الضوئية والآت التصوير",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-7-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity for printers,scanners and Copy machines'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 2-7-3-5",
                            "long_name" => "DCC 2-7-3-5",
                            "description" => "استخدام أجهزة تمزيق الوثائق الورقية (صنكعحطك 0:088). لإتلاف الوثائق\r\nفي حال الانتهاء من استخدامها نهائيا",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 2-7-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity for printers,scanners and Copy machines'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ],

                ],


                [
                    "short_name" => "DCC 2-7-4",
                    "long_name" => "DCC 2-7-4",
                    "description" => "يجب مراجعة تطبيق متطلبات الأمن السيبراني للطابعات والماسحات الضوئية وآلات التصوير\r\nفي الجهة حسب المدة المحددة لكل مستوى",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 2-7-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity for printers,scanners and Copy machines'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [
                    "short_name" => "DCC 3-1-1",
                    "long_name" => "DCC 3-1-1",
                    "description" => "بالإضافة للضوابط ضمن المكون الفرعي ‎١-٤‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتشمل متطلبات الأمن السيبراني المتعلقة بالأطراف الخارجية",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 3-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "DCC 3-1-1-1",
                            "long_name" => "DCC 3-1-1-1",
                            "description" => "إجراء المسح الأمني SCREENING) لموظفي الأطراف الخارجية\r\nالذين لديهم صلاحيات الاطلاع على البيانات.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 3-1-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 3-1-1-2",
                            "long_name" => "DCC 3-1-1-2",
                            "description" => "‏وجود ضمانات تعاقدية للقدرة على حذف بيانات الجهة بطرق آمنة لدى\r\nالطرف الخارجي عند الانتهاء\/إنهاء العلاقة التعاقدية مع تقديم الأدلة على\r\nذلك",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 3-1-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 3-1-1-3",
                            "long_name" => "DCC 3-1-1-3",
                            "description" => "‏توثيق كافة عمليات مشاركة البيانات مع الأطراف الخارجية. على أن يشمل\r\nذلك مبررات مشاركة البيانات",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 3-1-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 3-1-1-4",
                            "long_name" => "DCC 3-1-1-4",
                            "description" => "‏عند مشاركة البيانات خارج المملكة يجب التحقق من قدرة الجهة المستضيفة\r\nعلى حماية تلك البيانات والحصول على موافقة صاحب الصلاحية بالإضافة إلى\r\nالالتزام بالمتطلبات التشريعية والتنظيمية ذات العلاقة.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 3-1-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 3-1-1-5",
                            "long_name" => "DCC 3-1-1-5",
                            "description" => "إلزام الأطراف الخارجية بإبلاغ الجهة مباشرة عند حدوث حادثة أمن سيبراني قد\r\nي تمت مشاركتها أو إنشائها",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 3-1-1-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "DCC 3-1-1-6",
                            "long_name" => "DCC 3-1-1-6",
                            "description" => "عادة تصنيف البيانات إلى أقل مستوى يحقق الهدف. قبل مشاركتها مع الأطراف\r\nالخارجية وذلك باستخدام تقنيات تعتيم البيانات أو تقنيات\r\nمزج البيانات",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 3-1-1-6",
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
                    "short_name" => "DCC 3-1-2",
                    "long_name" => "DCC 3-1-2",
                    "description" => "يتوافق مع المتطلبات التشريعية والتنظيمية ذات العلاقة. وبالإضافة إلى ما ينطبق من\r\nالضوابط الأساسية للأمن السيبراني والضوابط ضمن المكونات الرئيسية رقم ‎\r\n‏يجب أن تغطي متطلبات الأمن السيبراني عند التعامل مع الجهات الاستشارية\r\n‏للمشاريع الاستراتيجية ذات الحساسية العالية على المستوى الوطني",
                    "supplemental_guidance" => null,
                    "control_number" => "DCC 3-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "DCC 3-1-2-1",
                            "long_name" => "DCC 3-1-2-1",
                            "description" => "‏إجراء المسح الأمني  لموظفي شركات الخدمات الاستشارية الذين لديهم صلاحيات الاطلاع على البيانات",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 3-1-2-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "DCC 3-1-2-2",
                            "long_name" => "DCC 3-1-2-2",
                            "description" => "‏وجود ضمانات تعاقدية تشمل إلزام موظفي الخدمات الاستشارية بعدم إفشاء\r\nالمعلومات وكذلك القدرة على حذف بيانات الجهة بطرق آمنة لدى شركات\r\nالخدمات الاستشارية عند الانتهاء\/إنهاء العلاقة التعاقدية مع تقديم الأدلة على\r\nذلك",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 3-1-2-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "DCC 3-1-2-3",
                            "long_name" => "DCC 3-1-2-3",
                            "description" => "‏توثيق كافة عمليات مشاركة البيانات مع شركات الخدمات الاستشارية. على أن\r\nيشمل ذلك مبررات مشاركة البيانات.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 3-1-2-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "DCC 3-1-2-4",
                            "long_name" => "DCC 3-1-2-4",
                            "description" => "‏إلزام شركات الخدمات الاستشارية بإبلاغ الجهة مباشرة عند حدوث حادثة أمن\r\nسيبراني قد تؤثر على البيانات التي تمت مشاركتها أو إنشائها.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 3-1-2-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "DCC 3-1-2-5",
                            "long_name" => "DCC 3-1-2-5",
                            "description" => "إعادة تصنيف البيانات إلى أقل مستوى يحقق الهدف. قبل مشاركتها مع شركات\r\nالخدمات الاستشارية وذلك باستخدام تقنيات تعتيم البيانات",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 3-1-2-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "DCC 3-1-2-6",
                            "long_name" => "DCC 3-1-2-6",
                            "description" => "‏تخصيص قاعة مغلقة لموظفي شركات الخدمات الاستشارية لأداء أعمالهم. مع\r\nتوفير أجهزة مخصصة مملوكة للجهة يتم من خلالها مشاركة البيانات ومعالجتها.",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 3-1-2-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "DCC 3-1-2-7",
                            "long_name" => "DCC 3-1-2-7",
                            "description" => "تفعيل أنظمة التحكم بالدخول والخروج من القاعة المغلقة. على أن يكون\r\nللمصرح لهم فقط",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 3-1-2-7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "DCC 3-1-2-8",
                            "long_name" => "DCC 3-1-2-8",
                            "description" => "منع خروج الأجهزة ووحدات التخزين والوثائق من القاعة المغلقة. ومنع إدخال\r\nأي أجهزة إلكترونية للقاعة",
                            "supplemental_guidance" => null,
                            "control_number" => "DCC 3-1-2-8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
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