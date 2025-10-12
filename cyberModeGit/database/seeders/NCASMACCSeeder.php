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
use Illuminate\Support\Facades\Log;

class NCASMACCSeeder extends Seeder
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
            try {

                if (in_array('install_document', $this->options)) {

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
                }



                // Insert framework data
                $framework = Framework::create([
                    'name' => 'NCA-SMACC',
                    'description' => "Based on the objectives of the National Cybersecurity Authority (NCA) strategy and in continuation of its role in regulating and protecting the Kingdom's cyberspace, NCA has issued the Organizations’ Social Media Accounts Cybersecurity Controls document. These controls were developed after reviewing many international cybersecurity standards, frameworks, controls and international practices in cybersecurity.",
                    'icon' => 'fa-whatsapp',
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

                            ['name' => 'Cybersecurity in Human Resources', 'order' => '9'],
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
                            ['name' => 'Mobile Devices Security', 'order' => '6'],
                            ['name' => 'Data and Information Protection', 'order' => '7'],
                            ['name' => 'Cybersecurity Event Logs and Monitoring Management', 'order' => '12'],
                            ['name' => 'Cybersecurity Incident and Threat Management', 'order' => '13'],
                        ]
                    ],

                    [
                        'name' => 'Third-Party and Cloud Computing Cybersecurity',
                        'order' => '4',
                        'subdomains' => [
                            [
                                'name' => 'Third-Party Cybersecurity',
                                'order' => '1'
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
                        "short_name" => "SMACC 1-1-1",
                        "long_name" => "SMACC 1-1-1",
                        "description" => "رجوعــاً للضابــط 1- 3-1 يف الضوابــط األساســية الامــن الســيرباين، يجــب أن تشــمل سياســات\r\nوإجــراءات الامــن الســيرباني",
                        "supplemental_guidance" => null,
                        "control_number" => "SMACC 1-1-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cybersecurity Policies and Procedures'), // Dynamically get family ID
                        "control_owner" => "1",
                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [

                                "short_name" => "SMACC 1-1-1-1",
                                "long_name" => "SMACC 1-1-1-1",
                                "description" => "رجوعــاً للضابــط 1- 3-1 في الضوابــط الاساســيةالامــن السـيبراني، يجــب أن تشــمل سياســات\r\nوإجــراءات الامــن الســيبراني  تحديــد وتوثيــق متطلبــات وضوابــط الامــن الســيرباني لحســابات التواصــل\r\nاالاجتامعــي ضمــن سياســات الامــن الســيرباني للجهــة",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 1-1-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Policies and Procedures'), // Dynamically get family ID
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],

                        ]
                    ],

                    [

                        "short_name" => "SMACC 1-2-1",
                        "long_name" => "SMACC 1-2-1",
                        "description" => "باإلاضافـة للضوابـط ضمـن المكـون الفرعـي 1 - 5 يف الضوابـط الاساسـية الألمـن السـيرباني، يجـب أن\r\nتشـمل منهجيـة إدارة مخاطـر الامـن السـيرباني",
                        "supplemental_guidance" => null,
                        "control_number" => "SMACC 1-2-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",

                        "children" => [
                            [

                                "short_name" => "SMACC 1-2-1-1",
                                "long_name" => "SMACC 1-2-1-1",
                                "description" => "بالاضافـة للضوابـط ضمـن المكـون الفرعـي 1 - 5 يف الضوابـط الاساسـية الامـن السـيرباني، يجـب أن\r\nتشـمل منهجيـة إدارة مخاطـرالامـن السـيرباين بحـد أدى  تقييــم مخاطــر الامــن الســيرباين لحســابات التواصــل االاجتامعــي، مــرة واحــدة\r\nســنوياً، عــى الاقــل",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 1-2-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "SMACC 1-2-1-2",
                                "long_name" => "SMACC 1-2-1-2",
                                "description" => "بالاضافـة للضوابـط ضمـن المكـون الفرعـي 1 - 5 يف الضوابـط الاساسـيةللامـن السـيرباين، يجـب أن\r\nتشـمل منهجيـة إدارة مخاطـر الامـن السـيرباين بحـد أدى  تقييـم مخاطـرالامـن السـيرباين عنـد التخطيـط وقبـل السـاح باسـتخدام شـبكات\r\nالتواصــل االاجتامعي.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 1-2-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                                "control_owner" => "1",
                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [

                                "short_name" => "SMACC 1-2-1-3",
                                "long_name" => "SMACC 1-2-1-3",
                                "description" => "بالاضافـة للضوابـط ضمـن المكـون الفرعـي 1 - 5 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب أن\r\nتشـمل منهجيـة إدارة مخاطـرالامـن السـيرباين بحـد أدى  تضمــن مخاطــر الامــن الســيرباين الخاصــة بحســابات التواصــل االاجتامعــي\r\nوالخدمــات والانظمــة المســتخدمة يف ذلــك يف ســجل مخاطــر الامــن الســيرباين\r\nالخــاص بالجهــة، ومتابعتــه مــرة واحــدة ســنويا، عــى األقــل",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 1-2-1-3",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                        ]

                    ],


                    [

                        "short_name" => "SMACC 1-3-1",
                        "long_name" => "SMACC 1-3-1",
                        "description" => "بالالضافـة للضوابـط الفرعيــة ضمــن الضابــط 1 – 9 – 4 يف الضوابـط الاساسـيةللامـن السـيرباين،\r\nيجـب أن تشـمل متطلبـات الامـن السـيرباين المتعلقـة بالعاملـين الملسـؤولني عـن إدارة حسـابات\r\nالتواصـل االاجتامعـي للجهـة",
                        "supplemental_guidance" => null,
                        "control_number" => "SMACC 1-3-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),

                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [

                                "short_name" => "SMACC 1-3-1-1",
                                "long_name" => "SMACC 1-3-1-1",
                                "description" => "بالاضافـة للضوابـط الفرعيــة ضمــن الضابــط 1 – 9 – 4 يف الضوابـط الاساسـية للامـن السـيرباين،\r\nيجـب أن تشـمل متطلبـات الامـن السـيرباين المتعلقـة بالعاملـين املسـؤولني عـن إدارة حسـابات\r\nالتواصـل الاجتامعـي للجهـة بحـد أدى  التوعية بالامن السيرباين لحسابات التواصل الاجتامعي",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 1-3-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),

                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [

                                "short_name" => "SMACC 1-3-1-2",
                                "long_name" => "SMACC 1-3-1-2",
                                "description" => "بالاضافـة للضوابـط الفرعيــة ضمــن الضابــط 1 – 9 – 4 يف الضوابـط الاساسـية للامـن السـيرباين،\r\nيجـب أن تشـمل متطلبـات الامـن السـيرباين المتعلقـة بالعامليـن املسـؤولني عـن إدارة حسـابات\r\nالتواصـل الاجتامعـي للجهـة بحـد أدى  تطبيـق متطلبـات الامــن السـيرباين واالالـتــزام بهـا وفقـاً لسياسـات وإجــــراءات\r\nوعمليــات الامــن الســيرباين لحســابات التواصــل الاجتامعــي",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 1-3-1-2",
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
                        "short_name" => "SMACC 1-4-1",
                        "long_name" => "SMACC 1-4-1",
                        "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية للامـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي والاسـتخدام الامـن للحـد مـن هـذه المخاطـر والتهديـدات",
                        "supplemental_guidance" => null,
                        "control_number" => "SMACC 1-4-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),

                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [

                            [
                                "short_name" => "SMACC 1-4-1-1",
                                "long_name" => "SMACC 1-4-1-1",
                                "description" => "الاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية للامـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي والاسـتخدام الامـن للحـد مـن هـذه المخاطـر والتهديـدات، مبـا يف ذلـك  االاسـتخدام الامـن لألجهـزة المخصصـة لحسـابات التواصـل الاجتامعـي والمحافظـة\r\nعليهـا وحاميتهـا. وعـدم احتوائهـا عـى بيانـات مصنفـة أو اسـتخدامها ألاغـراض\r\nشـخصية",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 1-4-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",


                            ],
                            [
                                "short_name" => "SMACC 1-4-1-2",
                                "long_name" => "SMACC 1-4-1-2",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية للامـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي واالاسـتخدام الامـن للحـد مـن هـذه المخاطـر والتهديـدات، مبـا يف ذلـك  التعامل الامن مع هويات الدخول وكلامت المرور والاسئلة الامنية",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 1-4-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "SMACC 1-4-1-3",
                                "long_name" => "SMACC 1-4-1-3",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية للامـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي واالاسـتخدام لامـن للحـد مـن هـذه المخاطـر والتهديـدات، مبـا يف ذلـك  خطة استعادة حسابات التواصل لاجتامعي والتعامل مع الحوادث السيربانية.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 1-4-1-3",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "SMACC 1-4-1-4",
                                "long_name" => "SMACC 1-4-1-4",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية للأمـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي واالاسـتخدام الامـن للحـد مـن هـذه المخاطـر والتهديـدات، مبـا يف ذلـك  التعامــل الامــن مــع التطبيقــات والحلــول المســتخدمة لحســابات التواصــل\r\nالاجتامعــي.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 1-4-1-4",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "SMACC 1-4-1-5",
                                "long_name" => "SMACC 1-4-1-5",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية للامـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي والاسـتخدام الامـن للحـد مـن هـذه المخاطـر والتهديـدات، مبـا يف ذلـك  عـدم اسـتخدام حسـابات التواصـل الاجتامعـي الرسـمية ألغـراض شـخصية مثـل\r\nالتصفـح.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 1-4-1-5",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],

                            [
                                "short_name" => "SMACC 1-4-1-6",
                                "long_name" => "SMACC 1-4-1-6",
                                "description" => "الاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية لألمـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي واالاسـتخدامالامـن للحـد مـن هـذه المخاطـر والتهديـدات، مبـا يف ذلـك تجنــب الدخــول لحســابات التواصــل الاجتامعــي باســتخدام أجهــزة أو شــبكات\r\nعامـة غـر موثوقـة.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 1-4-1-6",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "SMACC 1-4-1-7",
                                "long_name" => "SMACC 1-4-1-7",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية للامـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي والاسـتخدام الامـن للحـد مـن هـذه المخاطـر والتهديـدات، مبـا يف ذلـك التواصــل مبــارشة مــع الادارة لاشــتباه\r\nبتهديـد أمـن سـيرباين.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 1-4-1-7",
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
                        "short_name" => "SMACC 1-4-2",
                        "long_name" => "SMACC 1-4-2",
                        "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 - 4 يف الضوابـط الاساسـية للأمـن السـيرباين،\r\nفإنـه يجـب تدريـب العامليـن المسـؤولني عـن إدارة حسـابات التواص الاجتامعـي للجهـة عـى\r\nالمهــارات التقنيــة والخطــط والاجــراءات الازمــة لضــان تطبيــق متطلبــات ومامرســات الامــن\r\nالســيرباين عنــد اســتخدام حســابات التواصــل الاجتامعــي",
                        "supplemental_guidance" => null,
                        "control_number" => "SMACC 1-4-2",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",

                    ],

                    [
                        "short_name" => "SMACC 2-1-1",
                        "long_name" => "SMACC 2-1-1",
                        "description" => "باإلضافـة للضوابـط ضمـن املكـون الفرعـي 2-1 يف الضوابـط األساسـية لألمـن السـيرباين، يجـب أن\r\nتشـمل متطلبـات األمـن السـيرباين إلدارة األصـول املعلوماتيـة والتقنيـة",
                        "supplemental_guidance" => null,
                        "control_number" => "SMACC 2-1-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Asset Management'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "SMACC 2-1-1-1",
                                "long_name" => "SMACC 2-1-1-1",
                                "description" => "بالاضافـة للضوابـط ضمـن المكـون الفرعـي 2-1 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب أن\r\nتشـمل متطلبـات الامـن السـيرباين إلادارة الاصـول المعلوماتيـة والتقنيـة، بحـد أدى  يجــب تحديــد وحــر حســابات التواصــل الاجتامعــي والاصــول المعلوماتيــة\r\nوالتقنيــة المتعلقــة بهــا، وتحديثهــا مــرة واحــدة، كل ســنة؛ عــى الاقــل.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-1-1-1",
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
                        "short_name" => "SMACC 2-2-1",
                        "long_name" => "SMACC 2-2-1",
                        "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـيةللامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصل الاجتامعـي للجهـة،",
                        "supplemental_guidance" => null,
                        "control_number" => "SMACC 2-2-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Identity and Access Management'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "SMACC 2-2-1-1",
                                "long_name" => "SMACC 2-2-1-1",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط  الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدى  استخدام حسابات التواصل الاجتامعي المخصصة للجهات، وليس الافراد",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-2-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "SMACC 2-2-1-2",
                                "long_name" => "SMACC 2-2-1-2",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدى  التسـجيل باسـتخدام معلومـات رسـمية )بريـد إلالكـروين رسـمي خـاص لوسـائل\r\nالتواصـل الاجتامعـي ورقـم جـوال رسـمي(، وعـدم اسـتخدام معلومات شـخصية",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-2-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "SMACC 2-2-1-3",
                                "long_name" => "SMACC 2-2-1-3",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدى   توثيــق حســابات التواصــل الاجتامعــي والمحافظــة عــى هويــة متســقة يف\r\nجميـع حسـابات التواصـل الاجتامعـي المسـتخدمة؛ لتسـهيل معرفـة الحسـابات\r\nالرســمية، واكتشــاف حســابات االاحتيــال",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-2-1-3",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "SMACC 2-2-1-4",
                                "long_name" => "SMACC 2-2-1-4",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـية للأمـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدىن،  اســتخدام كلمــة مــرور آمنــة وخاصــة لــكل حســابات التواصــل الاجتامعــي.\r\nوتغيــر كلمــة المــرور بشــكل دوري، وعــدم إعــادة اســتخدام كلمــة مــرور تــم\r\nاســتخدامها مــن قبــل.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-2-1-4",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "SMACC 2-2-1-5",
                                "long_name" => "SMACC 2-2-1-5",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـية للأمـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدى  اســتخدام التحقــق مــن الهويــة متعــدد العنــارص )Factor-Multi\r\nAuthentication )لعمليــات الدخــول لحســابات التواصــل الاجتامعــي",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-2-1-5",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "SMACC 2-2-1-6",
                                "long_name" => "SMACC 2-2-1-6",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـية للأمـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدى  تفعيل وتحديث الاسئلة الامنية وتوثيقها في مكان آمن",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-2-1-6",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],

                            [
                                "short_name" => "SMACC 2-2-1-7",
                                "long_name" => "SMACC 2-2-1-7",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـية للأمـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدى   إدارة صلاحيــات المســتخدمين ً لحســابات التواصــل الاجتامعــي بنــاء عــلى\r\nاحتياجــات العمــل، مــع مراعــاة حساســية الحســابات ومســتوى الصلاحيــات،\r\nونوعيــة الاجهــزة والانظمــة المســتخدمة.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-2-1-7",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],

                            [
                                "short_name" => "SMACC 2-2-1-8",
                                "long_name" => "SMACC 2-2-1-8",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدنى صلاحيـات مقدمـي خدمـة إدارة حسـابات التواصـل الاجتامعـي أو المراقبة\r\nاالاليـة لحسـابات التواصـل الاجتامعـي أو حاميـة هويـة الجهـة مـن الانتحال.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-2-1-8",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "SMACC 2-2-1-9",
                                "long_name" => "SMACC 2-2-1-9",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـيةللامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدى  حــر إمكانيــة الدخــول لحســابات التواصــل الاجتامعــي للجهــة مــن أجهــزة\r\nمحــددة.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-2-1-9",
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
                        "short_name" => "SMACC 2-2-2",
                        "long_name" => "SMACC 2-2-2",
                        "description" => "رجوعـاً للضابـط الفرعـي 2-2-3-5 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب مراجعـة هويات\r\nالدخـول والصلاحيـات المسـتخدمة لحسـابات التواصـل الاجتامعـي للجهـة، بحـد أدىن مـرة واحـدة\r\nكل سـنة",
                        "supplemental_guidance" => null,
                        "control_number" => "SMACC 2-2-2",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Identity and Access Management'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                    ],
                    [
                        "short_name" => "SMACC 2-3-1",
                        "long_name" => "SMACC 2-3-1",
                        "description" => "الاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-3-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين لحاميـة حسـابات التواصـل الاجتامعـي للجهـة، والاصـول\r\nالتقنيـة الخاصـة بهـا",
                        "supplemental_guidance" => null,
                        "control_number" => "SMACC 2-3-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "SMACC 2-3-1-1",
                                "long_name" => "SMACC 2-3-1-1",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-3-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين لحاميـة حسـابات التواصـل الاجتامعـي للجهـة، والاصـول\r\nالتقنيـة الخاصـة بهـا، بحـد أدى  تطبيـق حـزم التحديثـات، والصلاحـات الامنيـة لتطبيقـات التواصـل الاجتامعـي،\r\nمـرة واحـدة شـهرياً عـلى الاقـل.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-3-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],

                            [
                                "short_name" => "SMACC 2-3-1-2",
                                "long_name" => "SMACC 2-3-1-2",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-3-3 يف الضوابـط الاساسـيةللامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين لحاميـة حسـابات التواصـل الاجتامعـي للجهـة، والاصـول\r\nالتقنيـة الخاصـة بهـا، بحـد أدى  مراجعـة إعـدادات الحاميـة والتحصـن لحسـابات التواصـل الاجتامعـي للجهـة\r\nوالاصــول التقنيــة الخاصــة بهــا )Hardening and Configuration Secure ،)\r\nمـرة واحـدة كل سـنة عـى الاقـل",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-3-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],

                            [
                                "short_name" => "SMACC 2-3-1-3",
                                "long_name" => "SMACC 2-3-1-3",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-3-3 يف الضوابـطالاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين لحاميـة حسـابات التواصـل الاجتامعـي للجهـة، والاصـول\r\nالتقنيـة الخاصـة بهـا، بحـد أدى  مراجعـة وتحصـن اإلاعـدادات المصنعيـة )Configuration Default )لحسـابات\r\nالتواصــل الاجتامعــي والاصــول التقنيــة، ومنهــا وجــود كلــات مــرور ثابتــة أو\r\nتسـجيل الدخـول المسـبق، وإقفـال الاجهـزة )Lockout",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-3-1-3",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "SMACC 2-3-1-4",
                                "long_name" => "SMACC 2-3-1-4",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-3-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين لحاميـة حسـابات التواصـل الاجتامعـي للجهـة، والاصـول\r\nالتقنيـة الخاصـة بهـا، بحـد أدى   تقييـد تفعيـل الخصائـص والخدمـات يف حسـابات التواصـل الاجتامعـي حسـب\r\nالحاجــة، عــى أن يتــم تحليــل المخاطــر الســيربانية المحتملــة يف حــال الحاجــة\r\nلتفعيلهـا.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-3-1-4",
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
                        "short_name" => "SMACC 2-4-1",
                        "long_name" => "SMACC 2-4-1",
                        "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-6-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطــي متطلبــات الامــن الســيرباين الخاصــة بأمــن الاجهــزة املحمولــة لحســابات التواصــل\r\nالاجتامعـي للجهـة",
                        "supplemental_guidance" => null,
                        "control_number" => "SMACC 2-4-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "SMACC 2-4-1-1",
                                "long_name" => "SMACC 2-4-1-1",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-6-3 يف الضوابـط الاساسـية لألمـن السـيرباين، يجـب\r\nأن تغطــي متطلبــات الامــن الســيرباين الخاصــة بأمــن الاجهــزة المحمولــة لحســابات التواصــل\r\nالا جتامعـي للجهـة، بحـد أدىن،    إدارة الاجهــزة المحمولــة مركزيــاً باســتخدام نظــام إدارة الاجهــزة المحمولــة\r\n)MDM - Management Device M",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-4-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "SMACC 2-4-1-2",
                                "long_name" => "SMACC 2-4-1-2",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-6-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطــي متطلبــات الامــن الســيرباين الخاصــة بأمــن الاجهــزة المحمولــة لحســابات التواصــل\r\nالاجتامعـي للجهـة، بحـد أدى   تطبيـق حـزم التحديثـات، والاصلحات الامنيـة للأجهـزة المحمولـة، مـرة واحـدة\r\nشـهرياً، علـى الاقـل",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-4-1-2",
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
                        "short_name" => "SMACC 2-5-1",
                        "long_name" => "SMACC 2-5-1",
                        "description" => "بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 2-7-3 يف الضوابــط الاساســية للامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات الامـن السـيرباني لحاميـة البيانـات والملعومـات لحسـابات التواصـل\r\nالاجتامعــي للجهــة",
                        "supplemental_guidance" => null,
                        "control_number" => "SMACC 2-5-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Data and Information Protection'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "SMACC 2-5-1-1",
                                "long_name" => "SMACC 2-5-1-1",
                                "description" => "بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 2-7-3 يف الضوابــط الاساســية للامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات الامـن السـيرباين لحاميـة البيانـات والمعلومـات لحسـابات التواصـل\r\nالاجتامعــي للجهــة، بحــد أدى   يجــب أن ال تحتــوي الاصــول التقنيــة الخاصــة بحســابات التواصــل الاجتامعــي\r\nللجهــة عــى بيانــات مصنفــة، حســب الترشيعــات ذات العلاقــة",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-5-1-1",
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
                        "short_name" => "SMACC 2-6-1",
                        "long_name" => "SMACC 2-6-1",
                        "description" => "الاضافــة للضوابــط الفرعيــة ضمــن الضابــط 2-12-3 يف الضوابــط الاساســية للأمــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات إدارة سـجلات الاحـداث، ومراقبـة الامـن السـيرباني لحسـابات التواصـل\r\nالاجتامعـي للجهـة والاصـول التقنيـة التابعـة لهـا",
                        "supplemental_guidance" => null,
                        "control_number" => "SMACC 2-6-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "SMACC 2-6-1-1",
                                "long_name" => "SMACC 2-6-1-1",
                                "description" => "بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 2-12-3 يف الضوابــط الاساســية للامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات إدارة سـجلات الاحـداث، ومراقبـة الامـن السـيرباني لحسـابات التواصـل\r\nالاجتامعـي للجهـة والاصـول التقنيـة التابعـة لهـا، بحـد أدى  تفعيـل جميـع الاشـعارات وتنبيهـات الامـن السـيرباني الخاصة بحسـابات التواصل\r\nالاجتامعـي وسـجلات الاحـداث )Logs Event )الخاصـة باألمـن السـيرباني علـى\r\nالاصـول التقنيـة الخاصـة بحسـابات التواصـل الاجتامعـي",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-6-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "SMACC 2-6-1-2",
                                "long_name" => "SMACC 2-6-1-2",
                                "description" => "بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 2-12-3 يف الضوابــط الاساســية الامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات إدارة سـجلات الاحـداث، ومراقبـة الامـن السـيرباني لحسـابات التواصـل\r\nالاجتامعـي للجهـة والاصـول التقنيـة التابعـة لهـا، بحـد أدى    متابعــة حســابات التواصــل الاجتامعــي و مراقبتهــا للتأكــد مــن عــدم نــر أي\r\nمحتــوى غــر مــرح، أو تســجيل أي دخــول غــر مــرح.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-6-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],

                            [
                                "short_name" => "SMACC 2-6-1-3",
                                "long_name" => "SMACC 2-6-1-3",
                                "description" => "بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 2-12-3 يف الضوابــط الاساســية لألمــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات إدارة سـجلات الاحـداث، ومراقبـة الامـن السـيرباني لحسـابات التواصـل\r\nالاجتامعـي للجهـة والاصـول التقنيـة التابعـة لهـا، بحـد أدى   لمتابعـة شـبكات التواصـل الاجتامعـي ومراقبتهـا للتأكـد مـن عـدم انتحـال هويـة\r\nالجهة.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-6-1-3",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "SMACC 2-6-1-4",
                                "long_name" => "SMACC 2-6-1-4",
                                "description" => "بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 2-12-3 يف الضوابــط الاساســية للامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات إدارة سـجلات الاحـداث، ومراقبـة الامـن السـيرباني لحسـابات التواصـل\r\nالاجتامعـي للجهـة والاصـول التقنيـة التابعـة لهـا، بحـد أدى  المراقبــة الاليــة ألي تغيــر يف منــط الحســابات أو مــؤرشات اخـتـراق أو نــر أي\r\nمحتـوى غـر مـرح أو انتحـال هويـة الجهـة",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-6-1-4",
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
                        "short_name" => "SMACC 2-7-1",
                        "long_name" => "SMACC 2-7-1",
                        "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-13-3 يف الضوابـطالاساسـية للامـن السـيرباني، يجب\r\nأن تغطـي متطلبـات إدارة حـوادث وتهديـدات الامـن السـيرباني في الجهـة",
                        "supplemental_guidance" => null,
                        "control_number" => "SMACC 2-7-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "SMACC 2-7-1-1",
                                "long_name" => "SMACC 2-7-1-1",
                                "description" => "بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-13-3 يف الضوابـط الاساسـية لألمـن السـيرباني، يجب\r\nأن تغطـي متطلبـات إدارة حـوادث وتهديـدات الامـن السـيرباني في الجهـة، بحـد أدى  وضــع خطــة اســتعادة حســابات التواصــل الاجتامعــي والتعامــل مــع الحــوادث\r\nالســيربانية.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 2-7-1-1",
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
                        "short_name" => "SMACC 3-1-1",
                        "long_name" => "SMACC 3-1-1",
                        "description" => "يجــب تقييــم مــدى الحاجــة الســتخدام خدمــات إدارة حســابات التواصــل الاجتامعــي )social\r\nmanagement media )واملراقبـة الاليـة لحسـابات التواصـل الاجتامعـي أو لحاميـة هويـة الجهـة\r\nمـن الانتحـال )protection brand )ومخاطـر الامـن السـيرباني",
                        "supplemental_guidance" => null,
                        "control_number" => "SMACC 3-1-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                    ],
                    [
                        "short_name" => "SMACC 3-1-2",
                        "long_name" => "SMACC 3-1-2",
                        "description" => "بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 4 - 1 - 2 يف الضوابــط الاساســية للامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات الامـن السـيرباني الخاصـة باسـتخدام خدمـات إدارة حسـابات التواصـل\r\nالاجتامعـي )management media social )والمراقبـة الاليـة لحسـابات التواصـل الا جتامعـي أو\r\nلحاميـة هويـة الجهـة مـن الانتحـال )protection b",
                        "supplemental_guidance" => null,
                        "control_number" => "SMACC 3-1-2",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "SMACC 3-1-2-1",
                                "long_name" => "SMACC 3-1-2-1",
                                "description" => "بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 4 - 1 - 2 يف ,الضوابــط الاساســية للامــن الســيرباني\r\nيجـب أن تغطـي متطلبـات الامـن السـيرباني الخاصـة باسـتخدام خدمـات إدارة حسـابات التواصـل\r\nالاجتامعـي )management media social )والمراقبـة الاليـة لحسـابات التواصـل الاجتامعـي أو\r\nلحاميـة هويـة الجهـة مـن الانتحـال )protection brand ،)بحـد أدىن،   بنــود املحافظــة عــى رسيــة المعلومــات )Clauses Disclosure-Non )والحــذف\r\nالامـن مـن قبـل الطـرف الخارجـي لبيانـات الجهـة عنـد انتهـاء الخدمـة",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 3-1-2-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "SMACC 3-1-2-2",
                                "long_name" => "SMACC 3-1-2-2",
                                "description" => "بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 4 - 1 - 2 يف الضوابــط الاساســية للامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات الامـن السـيرباني الخاصـة باسـتخدام خدمـات إدارة حسـابات التواصـل\r\nالاجتامعـي )management media social )والمراقبـة الاليـة لحسـابات التواصـل الاجتامعـي أو\r\nلحاميـة هويـة الجهـة مـن االانتحـال )protection brand ،)بحـد أدى   إجراءات التواصل لإلبالغ عن الثغرات ويف حال اكتشاف حادثة أمن سيرباني.",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 3-1-2-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],

                            [
                                "short_name" => "SMACC 3-1-2-3",
                                "long_name" => "SMACC 3-1-2-3",
                                "description" => "بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 4 - 1 - 2 يف الضوابــط الاساســية للامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات الامـن السـيرباني الخاصـة باسـتخدام خدمـات إدارة حسـابات التواصـل\r\nالاجتامعـي )management media social )والمراقبـة الاليـة لحسـابات التواصـلالاجتامعـي أو\r\nلحاميـة هويـة الجهـة مـن االنتحـال )protection brand ،)بحـد أدى    إلــزام الطــرف الخارجــي بتطبيــق متطلبــات وسياســات الامــن الســيرباني لحاميــة\r\nحســابات التواصــل الاجتامعــي للجهــة والمتطلبــات الترشيعيــة والتنظيميــة ذات\r\nالعلاقــة",
                                "supplemental_guidance" => null,
                                "control_number" => "SMACC 3-1-2-3",
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
            } catch (\Exception $e) {
                Log::error('Error occurred in run method: ' . $e->getMessage(), [
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]);
                throw $e; // Re-throw the exception to ensure transaction rollback
            }
        });
    }

    private function createControlAndTests($controlData, $parentId = null, $frameworkId)
    {
        try {

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
        } catch (\Exception $e) {
            Log::error('Error occurred in createControlAndTests method: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            throw $e; // Re-throw the exception
        }
    }


    private function createOrUpdateDocument($documentData, $controlId)
    {
        try {

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
        } catch (\Exception $e) {
            Log::error('Error occurred in createOrUpdateDocument method: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            throw $e; // Re-throw the exception
        }
    }


    private function getFamilyIdByName($familyName)
    {
        try {

            return Family::where('name', $familyName)->value('id');
        } catch (\Exception $e) {
            Log::error('Error occurred in getFamilyIdByName method: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            throw $e; // Re-throw the exception
        }
    }

    private function getDocumentIdByName($documentTypeName)
    {
        try {

            return DocumentTypes::where('name', $documentTypeName)->value('id');
        } catch (\Exception $e) {
            Log::error('Error occurred in getDocumentIdByName method: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            throw $e; // Re-throw the exception
        }
    }

    public function debugOptions()
    {
        return $this->options;
    }
}