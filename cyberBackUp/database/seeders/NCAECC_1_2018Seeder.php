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

class NCAECC_1_2018Seeder extends Seeder
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

        if($regulatorId){
             // Split the string into an array using comma as the delimiter
             $this->regulatorId = json_decode($regulatorId, true) ?: [];
        }else{
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

                DocumentTypes::updateOrCreate(
                    ['name' => 'معايير الأمن السيبراني'],
                    ['icon' => 'fas fa-lock']
                );

                DocumentTypes::updateOrCreate(
                    ['name' => 'الاجراءات'],
                    ['icon' => 'fas fa-bug']
                );

                DocumentTypes::updateOrCreate(
                    ['name' => 'صمود الأمن السيبراني'],
                    ['icon' => 'fas fa-unlink']
                );
            }
             
 

            // Insert framework data
            $framework = Framework::create([
                'name' => 'NCA-ECC – 1: 2018',
                'description' => 'The National Cybersecurity Authority “NCA” has developed the Essential Cybersecurity Controls (ECC – 1: 2018) to set the minimum cybersecurity requirements based on best practices and standards to minimize the cybersecurity risks to the information and technical assets of organizations that originate from internal and external threats. The Essential Cybersecurity Controls consist of 114 main controls, divided into five main domains.',
                'icon' => 'fa-universal-access',
                'status' => '1',
                'regulator_id'=>$this->regulatorId,

            ]);

            // Main domains with their subdomains
            $mainDomains = [
                [
                    'name' => 'حوكمة الأمن السيبراني CyberSecurity Governance',
                    'order' => '1',
                    'subdomains' => [
                        [
                            'name' => 'إستراتيجية الأمن السيبراني CyberSecurity Strategy',
                            'order' => '1',
                        ],
                        [
                            'name' => 'إدارة الأمن السيبراني CyberSecurity Management',
                            'order' => '2',
                        ],
                        [
                            'name' => 'سياسات وإجراءات الأمن السيبراني CyberSecurity Policies and Procedures',
                            'order' => '3',
                        ],
                        [
                            'name' => 'أدارة ومسئوليات الأمن السيبراني CyberSecurity Role and Responsibilities',
                            'order' => '4',
                        ],
                        [
                            'name' => 'إدارة مخاطر الأمن السيبراني CyberSecurity Risk Management',
                            'order' => '5',
                        ],
                        [
                            'name' => 'الأمن السيبراني ضمن إدارة المشاريع المعلوماتية والتقنية CyberSecurity in Information Technology Projects',
                            'order' => '6',
                        ],
                        [
                            'name' => 'اﻹلتزام بتشريعات وتنظيمات ومعايير الأمن السيبراني CyberSecurity Regulatory Compliance',
                            'order' => '7',
                        ],
                        [
                            'name' => 'المراجعة والتدقيق الدورى للأمن السيبراني CyberSecurity Periodical Assessment and Audit',
                            'order' => '8',
                        ],
                        [
                            'name' => 'الأمن السيبراني المتعلق بالموارد البشرية CyberSecurity in Human Resources',
                            'order' => '9',
                        ],
                        [
                            'name' => 'برنامج التوعية والتدريب بالأمن السيبراني CyberSecurity Awareness and Training Program',
                            'order' => '10',
                        ]
                    ]
                ],
                [
                    'name' => 'تعزيز الأمن السيبراني CyberSecurity Defense',
                    'order' => '2',
                    'subdomains' => [
                        [
                            'name' => 'إدارة اﻷصول Asset Management',
                            'order' => '1',
                        ],
                        [
                            'name' => 'إدارة هويات الدخول والصلاحيات Identity and Access Management',
                            'order' => '2',
                        ],
                        [
                            'name' =>
                            'حماية اﻷنظمة وأجهزة معالجة المعلومات Information System and Processing Facilities Protection',
                            'order' => '3',
                        ],
                        [
                            'name' => 'حماية البريد اﻹلكترونى Email Protection',
                            'order' => '4',
                        ],
                        [
                            'name' => 'إدارة أمن الشبكات Networks Security Management',
                            'order' => '5',
                        ],
                        [
                            'name' => 'أمن اﻷجهزة المحمولة Mobile Devices Security',
                            'order' => '6',
                        ],
                        [
                            'name' => 'حماية البيانات والمعلومات Data and Information Protection',
                            'order' => '7',
                        ],
                        [
                            'name' => 'التشفير Cryptography',
                            'order' => '8',
                        ],
                        [
                            'name' => 'إدارة النسخ الاحتياطية Backup and Recovery Management',
                            'order' => '9',
                        ],
                        [
                            'name' => 'إدارة الثغرات Vulnerabilities Management',
                            'order' => '10',
                        ],
                        [
                            'name' => 'إختبار الاختراق Penetration Testing',
                            'order' => '11',
                        ],
                        [
                            'name' =>
                            'إدارة سجلات اﻷحداث ومراقبة اﻷمن السيبرانى CyberSecurity Event Logs and Monitoring Management',
                            'order' => '12',
                        ],
                        [
                            'name' => 'إدارة حوادث وتهديدات اﻷمن السيبراني CyberSecurity Incident and Threat Management',
                            'order' => '13',
                        ],
                        [
                            'name' => 'اﻷمن المادى Physical Security',
                            'order' => '14',
                        ],
                        [
                            'name' => 'حماية تطبيقات الويب Web Application Security',
                            'order' => '15',
                        ],
 
                    ]
                ],
                [
                    'name' => 'صمود الأمن السيبراني CyberSecurity Resilience',
                    'order' => '3',
                    'subdomains' => [
                        [
                            'name' => 'جوانب صمود اﻷمن السيبراني فى إدارة استمرارية اﻷعمال CyberSecurity Resilience aspects of Business Continuity Management (BCM)', 'order' => '1',
                        ]
                    ]
                ],
                [
                    'name' => 'الأمن السيبراني المتعلق باﻷطراف الخارجية والحوسبة السحابية Third-Party and Cloud Computing CyberSecurity',
                    'order' => '4',
                    'subdomains' => [
                        [
                            'name' => 'الأمن السيبراني المتعلق باﻷطراف الخارجية Third-Party CyberSecurity',
                            'order' => '1',
                        ],
                        [
                            'name' => 'الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة Cloud Computing and hosting CyberSecurity',
                            'order' => '2',
                        ]
                       
                    ]
                ],
                [
                    'name' => 'الأمن السيبراني ﻷنظمة التحكم الصناعي ICS CyberSecurity',
                    'order' => '5',
                    'subdomains' => [
                        [
                            'name' => 'حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection', 'order' => '1',
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
                    "short_name" => "ECC 1-1-1",
                    "long_name" => "ECC 1-1-1",
                    "description" => "يجب تحديد وتوثيق واعتماد إستراتيجية الامـن السيبراني للجهة ودعمها من قبل رئيس الجهة أو من\r\nينيبه ويشار له في هذه الضوابط بـاسم »صاحب الصلاحية« وأن تتماشى الاهداف الاستراتيجية للامن\r\nالسيبراني للجهة مع المتطلبات التشريعية والتنظيمية ذات العلاقة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إستراتيجية الأمن السيبراني CyberSecurity Strategy'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get family ID
                            'privacy' => 2,
                            'document_name' => 'استراتيجية الأمن السيبراني',
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

                    "short_name" => "ECC 1-1-2",
                    "long_name" => "ECC 1-1-2",
                    "description" => "يجب العمل على تنفيذ خطة عمل لتطبيق إستراتيجية الامن السيبراني من قبل الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إستراتيجية الأمن السيبراني CyberSecurity Strategy'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [

                    "short_name" => "ECC 1-1-3",
                    "long_name" => "ECC 1-1-3",
                    "description" => "يجب مراجعة إستراتيجية الامن السيبراني على فترات زمنية مخطط لها أو في حالة حدوث تغييرات في\r\nالمتطلبات التشريعية والتنظيمية ذات العلاقة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-1-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إستراتيجية الأمن السيبراني CyberSecurity Strategy'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [

                    "short_name" => "ECC 1-2-1",
                    "long_name" => "ECC 1-2-1",
                    "description" => "يجب إنشاء إدارة معنية بالامن السيبراني في الجهة مستقلة عن إدارة تقنية المعلومات والاتصالات وفقا للأمر السامي الكريم  رقم 37140  وتاريخ 14 \/ 8 \/ 1438 هـ. ويفضل ارتباطها مباشرة برئيس (ICT\/ IT)\r\n وفقا للجهة أو من ينيبه، مع الاخذ بالاعتبار عدم تعارض المصالح.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة الأمن السيبراني CyberSecurity Management'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'الهيكل التنظيمي للأمن السيبراني',
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

                    "short_name" => "ECC 1-2-2",
                    "long_name" => "ECC 1-2-2",
                    "description" => "يجب أن يشغل رئاسة الادارة المعنية بالامن السيبراني والوظائف الاشرافية والحساسة بها مواطنون\r\n متفرغون وذو كفاءة عالية في مجال الامن السيبراني.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-2-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة الأمن السيبراني CyberSecurity Management'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [

                    "short_name" => "ECC 1-2-3",
                    "long_name" => "ECC 1-2-3",
                    "description" => "يجب إنشاء لجنة إشرافية للامن السيبراني بتوجيه من صاحب الصلاحية للجهة لضمان التزام ودعم ومتابعة\r\nتطبيق برامج وتشريعات الامن السيبراني، ويتم تحديد وتوثيق واعتماد أعضاء اللجنة ومسؤولياتها وإطار\r\nحوكمة أعمالها على أن يكون رئيس الادارة المعنية بالامن السيبراني أحد أعضائها. ويفضل ارتباطها مباشرة\r\nبرئيس الجهة أو من ينيبه، مع الاخذ بالاعتبار عدم تعارض المصالح",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-2-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة الأمن السيبراني CyberSecurity Management'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'الوثيقة المنظمة للجنة الإشرافية للأمن السيبراني',
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

                    "short_name" => "ECC 1-3-1",
                    "long_name" => "ECC 1-3-1",
                    "description" => "يجب على الادارة المعنية بالامن السيبراني في الجهة تحديد سياسات وإجـراءات الامن السيبراني وما\r\nتشمله من ضوابط ومتطلبات الامن السيبراني، وتوثيقها واعتمادها من قبل صاحب الصلاحية في الجهة،\r\nكما يجب نشرها إلى ذوي العلاقة من العاملين في الجهة والاطراف المعنية بها.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-3-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('سياسات وإجراءات الأمن السيبراني CyberSecurity Policies and Procedures'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'السياسة العامة للأمن السيبراني',
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

                    "short_name" => "ECC 1-3-2",
                    "long_name" => "ECC 1-3-2",
                    "description" => "يجب على الادارة المعنية بالامن السيبراني ضمان تطبيق سياسات وإجراءات الامن السيبراني في الجهة\r\nوما تشمله من ضوابط ومتطلبات.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-3-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('سياسات وإجراءات الأمن السيبراني CyberSecurity Policies and Procedures'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة أمن قواعد البيانات',
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

                    "short_name" => "ECC 1-3-3",
                    "long_name" => "ECC 1-3-3",
                    "description" => "يجب أن تكون سياسات وإجراءات الامن السيبراني مدعومة بمعايير تقنية أمنية )على سبيل المثال => المعايير\r\n التقنية المنية لجدار الحماية وقواعد البيانات، وأنظمة التشغيل، إلخ(",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-3-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('سياسات وإجراءات الأمن السيبراني CyberSecurity Policies and Procedures'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار حماية البريد الإلكتروني',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار إدارة سجلات الأحداث ومراقبة الأمن السيبراني',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار أمن الأجهزة المحمولة',
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
                    "short_name" => "ECC 1-3-4",
                    "long_name" => "ECC 1-3-4",
                    "description" => "يجب مراجعة سياسات وإجــراءات ومعايير الامـن السيبراني وتحديثها على فترات زمنية مخطط لها )أو\r\nفي حالة حدوث تغييرات في المتطلبات التشريعية والتنظيمية والمعايير ذات العلاقة(، كما يجب توثيق\r\nالتغييرات واعتمادها.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-3-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('سياسات وإجراءات الأمن السيبراني CyberSecurity Policies and Procedures'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 1-4-1",
                    "long_name" => "ECC 1-4-1",
                    "description" => "يجب على صاحب الصلاحية تحديد وتوثيق واعتماد الهيكل التنظيمي للحوكمة والادوار والمسؤوليات\r\nالخاصة بالامن السيبراني للجهة، وتكليف الاشخاص المعنيين بها، كما يجب تقديم الدعم اللزم لنفاذ\r\nذلك، مع الاخذ بالاعتبار عدم تعارض المصالح",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-4-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('أدارة ومسئوليات الأمن السيبراني CyberSecurity Role and Responsibilities'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'أدوار ومسؤوليات الأمن السيبراني',
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
                    "short_name" => "ECC 1-4-2",
                    "long_name" => "ECC 1-4-2",
                    "description" => "يجب مراجعة أدوار ومسؤوليات الامن السيبراني في الجهة وتحديثها على فترات زمنية مخطط لها )أو في\r\n حالة حدوث تغييرات في المتطلبات التشريعية والتنظيمية ذات العلقة(.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-4-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('أدارة ومسئوليات الأمن السيبراني CyberSecurity Role and Responsibilities'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 1-5-1",
                    "long_name" => "ECC 1-5-1",
                    "description" => "يجب على الادارة المعنية بالامن السيبراني في الجهة تحديد وتوثيق واعتماد منهجية وإجـراءات إدارة\r\nمخاطر الامن السيبراني في الجهة. وذلك وفقاً لعتبارات السرية وتوافر وسلامة الاصول المعلوماتية\r\nوالتقنية",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-5-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة مخاطر الأمن السيبراني CyberSecurity Risk Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة إدارة مخاطر الأمن السيبراني',
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
                    "short_name" => "ECC 1-5-2",
                    "long_name" => "ECC 1-5-2",
                    "description" => "يجب على الادارة المعنية بالامن السيبراني تطبيق منهجية وإجـراءات إدارة مخاطر الامن السيبراني في\r\nالجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-5-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة مخاطر الأمن السيبراني CyberSecurity Risk Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 1-5-3",
                    "long_name" => "ECC 1-5-3",
                    "description" => "يجب تنفيذ إجراءات تقييم مخاطر الامن السيبراني",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-5-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة مخاطر الأمن السيبراني CyberSecurity Risk Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 1-5-3-1",
                            "long_name" => "ECC 1-5-3-1",
                            "description" => "يجب تنفيذ إجراءات تقييم مخاطر الامن السيبراني في مرحلة مبكرة من المشاريع التقنية",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-5-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة مخاطر الأمن السيبراني CyberSecurity Risk Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 1-5-3-2",
                            "long_name" => "ECC 1-5-3-2",
                            "description" => "يجب تنفيذ إجراءات تقييم مخاطر الامن السيبراني   قبل إجراء تغيير جوهري في البنية التقنية",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-5-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة مخاطر الأمن السيبراني CyberSecurity Risk Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 1-5-3-3",
                            "long_name" => "ECC 1-5-3-3",
                            "description" => "يجب تنفيذ إجراءات تقييم مخاطر الامن السيبراني عند التخطيط للحصول على خدمات طرف خارجي",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-5-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة مخاطر الأمن السيبراني CyberSecurity Risk Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 1-5-3-4",
                            "long_name" => "ECC 1-5-3-4",
                            "description" => "يجب تنفيذ إجراءات تقييم مخاطر الأمن السيبراني  عند التخطيط وقبل إطلق منتجات وخدمات تقنية جديدة.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-5-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة مخاطر الأمن السيبراني CyberSecurity Risk Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 1-5-4",
                    "long_name" => "ECC 1-5-4",
                    "description" => "يجب مراجعة منهجية وإجراءات إدارة مخاطر الامن السيبراني وتحديثها على فترات زمنية مخطط لها )أو\r\nفي حالة حدوث تغييرات في المتطلبات التشريعية والتنظيمية والمعايير ذات العلاقة(، كما يجب توثيق\r\nالتغييرات واعتمادها.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-5-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة مخاطر الأمن السيبراني CyberSecurity Risk Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 1-6-1",
                    "long_name" => "ECC 1-6-1",
                    "description" => "يجب تضمين متطلبات الامـن السيبراني في منهجية وإجــراءات إدارة المشاريع وفي إدارة التغيير على\r\nالاصول المعلوماتية والتقنية في الجهة لضمان تحديد مخاطر الامن السيبراني ومعالجتها كجزء من دورة\r\nحياة المشروع التقني، وأن تكون متطلبات الامن السيبراني جزء أساسي من متطلبات المشاريع التقنية.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-6-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني ضمن إدارة المشاريع المعلوماتية والتقنية CyberSecurity in Information Technology Projects'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 1-6-2",
                    "long_name" => "ECC 1-6-2",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة المشاريع والتغييرات على الاصول المعلوماتية والتقنية\r\nللجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-6-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني ضمن إدارة المشاريع المعلوماتية والتقنية CyberSecurity in Information Technology Projects'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 1-6-2-1",
                            "long_name" => "ECC 1-6-2-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة المشاريع \r\n والتغييرات على الاصول المعلوماتية والتقنية  تقييم الثغرات ومعالجتها",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-6-2-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني ضمن إدارة المشاريع المعلوماتية والتقنية CyberSecurity in Information Technology Projects'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 1-6-2-2",
                            "long_name" => "ECC 1-6-2-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة المشاريع والتغييرات على الاصول المعلوماتية والتقنية\r\nللجهة  وحـزم( Secure Confguration and Hardening( والتحصين لـإعـدادات مراجعة اجــراء \r\nالتحديثات قبل إطلق وتدشين المشاريع والتغييرات.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-6-2-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني ضمن إدارة المشاريع المعلوماتية والتقنية CyberSecurity in Information Technology Projects'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة الإعدادات والتحصين',
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
                    ]
                ],

                [
                    "short_name" => "ECC 1-6-3",
                    "long_name" => "ECC 1-6-3",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-6-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني ضمن إدارة المشاريع المعلوماتية والتقنية CyberSecurity in Information Technology Projects'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 1-6-3-1",
                            "long_name" => "ECC 1-6-3-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة بحد أدنى )Secure Coding Standards( للتطبيقات الامن التطوير معايير ا",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-6-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني ضمن إدارة المشاريع المعلوماتية والتقنية CyberSecurity in Information Technology Projects'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'معيار التطوير الآمن للتطبيقات',
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
                            "short_name" => "ECC 1-6-3-2",
                            "long_name" => "ECC 1-6-3-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة بحد أدنى استخدام مصادر مرخصة وموثوقة لادوات تطوير التطبيقات والمكتبات الخاصة بها )Libraries.)",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-6-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني ضمن إدارة المشاريع المعلوماتية والتقنية CyberSecurity in Information Technology Projects'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 1-6-3-3",
                            "long_name" => "ECC 1-6-3-3",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة بحد أدنى اجراء اختبار للتحقق من مدى استيفاء التطبيقات للمتطلبات الامنية السيبرانية للجهة.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-6-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني ضمن إدارة المشاريع المعلوماتية والتقنية CyberSecurity in Information Technology Projects'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 1-6-3-4",
                            "long_name" => "ECC 1-6-3-4",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة بحد أدنى  التطبيقات بين( Integration( التكامل أم",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-6-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني ضمن إدارة المشاريع المعلوماتية والتقنية CyberSecurity in Information Technology Projects'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 1-6-3-5",
                            "long_name" => "ECC 1-6-3-5",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة بحد أدنى وحـزم( Secure Confguration and Hardening( والتحصين لـإعـدادات مراجعة اج التحديثات قبل إطلق وتدشين التطبيقات",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-6-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني ضمن إدارة المشاريع المعلوماتية والتقنية CyberSecurity in Information Technology Projects'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة الإعدادات والتحصين',
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
                    ]
                ],

                [
                    "short_name" => "ECC 1-7-1",
                    "long_name" => "ECC 1-7-1",
                    "description" => "يجب على الجهة الالتزام بالمتطلبات التشريعية والتنظيمية الوطنية المتعلقة بالامن السيبراني",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-7-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('اﻹلتزام بتشريعات وتنظيمات ومعايير الأمن السيبراني CyberSecurity Regulatory Compliance'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة الالتزام بتشريعات وتنظيمات الأمن السيبراني',
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
                    "short_name" => "ECC 1-7-2",
                    "long_name" => "ECC 1-7-2",
                    "description" => "في حال وجود اتفاقيات أو إلتزامات دولية معتمدة محلياً تتضمن متطلبات خاصة بالامن السيبراني، فيجب\r\nعلى الجهة الالتزام بتلك المتطلبات.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-7-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('اﻹلتزام بتشريعات وتنظيمات ومعايير الأمن السيبراني CyberSecurity Regulatory Compliance'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 1-8-1",
                    "long_name" => "ECC 1-8-1",
                    "description" => "يجب على الادارة المعنية بالامن السيبراني في الجهة مراجعة تطبيق ضوابط الامن السيبراني دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-8-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('المراجعة والتدقيق الدورى للأمن السيبراني CyberSecurity Periodical Assessment and Audit'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة مراجعة وتدقيق الأمن السيبراني',
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
                    "short_name" => "ECC 1-8-2",
                    "long_name" => "ECC 1-8-2",
                    "description" => "يجب مراجعة وتدقيق تطبيق ضوابط الامن السيبراني في الجهة، من قبل أطراف مستقلة عن الادارة\r\nالمعنية بالمن السيبراني )مثل الادارة المعنية بالمراجعة في الجهة(. على أن تتم المراجعة والتدقيق\r\nبشكل مستقل يراعى فيه مبدأ عدم تعارض المصالح، وذلك وفقاً للمعايير العامة المقبولة للمراجعة\r\nوالتدقيق والمتطلبات التشريعية والتنظيمية ذات العلاقة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-8-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('المراجعة والتدقيق الدورى للأمن السيبراني CyberSecurity Periodical Assessment and Audit'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 1-8-3",
                    "long_name" => "ECC 1-8-3",
                    "description" => "يجب توثيق نتائج مراجعة وتدقيق الامـن السيبراني، وعرضها على اللجنة الشرافية للامن السيبراني\r\nوصاحب الصلاحية. كما يجب أن تشتمل النتائج على نطاق المراجعة والتدقيق، والملاحظات المكتشفة،\r\nوالتوصيات والجراءات التصحيحية، وخطة معالجة الملاحظات.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-8-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('المراجعة والتدقيق الدورى للأمن السيبراني CyberSecurity Periodical Assessment and Audit'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 1-9-1",
                    "long_name" => "ECC 1-9-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني المتعلقة بالعاملين قبل توظيفهم وأثناء عملهم\r\nوعند انتهاء\/إنهاء عملهم في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-9-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالموارد البشرية CyberSecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة الأمن السيبراني للموارد البشرية',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'أدوار ومسؤوليات الأمن السيبراني',
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
                    "short_name" => "ECC 1-9-2",
                    "long_name" => "ECC 1-9-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني المتعلقة بالعاملين في الجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-9-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالموارد البشرية CyberSecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 1-9-3",
                    "long_name" => "ECC 1-9-3",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني قبل بدء علاقة العاملين المهنية بالجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-9-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالموارد البشرية CyberSecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 1-9-3-1",
                            "long_name" => "ECC 1-9-3-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني قبل بدء علاقة العاملين المهنية بالجهة تـضـمـيـن مــســؤولــيــات الامـــــن الــســيــبــرانــي وبـــنـــود الــمــحــافــظــة عــلــى ســريــة الـمـعـلـومـات\r\n)Clauses Disclosure-Non )في عقود العاملين في الجهة )لتشمل خلال وبعد انتهاء\/إنهاء\r\nالعلقة الوظيفية مع الجهة(",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-9-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالموارد البشرية CyberSecurity in Human Resources'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 1-9-3-2",
                            "long_name" => "ECC 1-9-3-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني قبل بدء علاقة العاملين المهنية بالجهة   إجراء المسح الامني )Vetting or Screening )للعاملين في وظائف الامن السيبراني والوظائف\r\nالتقنية ذات الصلاحيات الهامة والحساسة",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-9-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالموارد البشرية CyberSecurity in Human Resources'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 1-9-4",
                    "long_name" => "ECC 1-9-4",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني خلل علاقة العاملين المهنية بالجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-9-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالموارد البشرية CyberSecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 1-9-4-1",
                            "long_name" => "ECC 1-9-4-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني خلل علاقة العاملين المهنية بالجهة  التوعية بالامن السيبراني )عند بداية المهنة الوظيفية وخلالها(.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-9-4-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالموارد البشرية CyberSecurity in Human Resources'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 1-9-4-2",
                            "long_name" => "ECC 1-9-4-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني خلل علاقة العاملين المهنية بالجهة  تطبيق متطلبات الامـن السيبراني والالـتـزام بها وفقاً لسياسات وإجـــراءات وعمليات الامن\r\nالسيبراني للجهة",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-9-4-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالموارد البشرية CyberSecurity in Human Resources'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 1-9-5",
                    "long_name" => "ECC 1-9-5",
                    "description" => "يجب مراجعة وإلغاء الصلاحيات للعاملين مباشرة بعد انتهاء\/إنهاء الخدمة المهنية لهم بالجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-9-5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالموارد البشرية CyberSecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 1-9-6",
                    "long_name" => "ECC 1-9-6",
                    "description" => "يجب مراجعة متطلبات الامن السيبراني المتعلقة بالعاملين في الجهة دوري",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-9-6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالموارد البشرية CyberSecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 1-10-1",
                    "long_name" => "ECC 1-10-1",
                    "description" => "يجب تطوير واعتماد برنامج للتوعية بالامن السيبراني في الجهة من خلل قنوات متعددة دورياً، وذلك لتعزيز الوعي بالامن السيبراني وتهديداته ومخاطره، وبناء ثقافة إيجابية للامن السيبراني.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-10-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('برنامج التوعية والتدريب بالأمن السيبراني CyberSecurity Awareness and Training Program'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 1-10-2",
                    "long_name" => "ECC 1-10-2",
                    "description" => "يجب تطبيق البرنامج المعتمد للتوعية بالامن السيبراني في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-10-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('برنامج التوعية والتدريب بالأمن السيبراني CyberSecurity Awareness and Training Program'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 1-10-3",
                    "long_name" => "ECC 1-10-3",
                    "description" => "يجب أن يغطي برنامج التوعية بالامن السيبراني كيفية حماية الجهة من أهم المخاطر والتهديدات السيبرانية\r\nوما يستجد منها",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-10-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('برنامج التوعية والتدريب بالأمن السيبراني CyberSecurity Awareness and Training Program'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 1-10-3-1",
                            "long_name" => "ECC 1-10-3-1",
                            "description" => "يجب أن يغطي برنامج التوعية بالامن السيبراني كيفية حماية الجهة من أهم المخاطر والتهديدات السيبرانية\r\nوما يستجد منها بما في ذلك => التعامل الامن مع خدمات البريد اللكتروني خصوصاً مع رسائل التصيد الالكتروني",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-10-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('برنامج التوعية والتدريب بالأمن السيبراني CyberSecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 1-10-3-2",
                            "long_name" => "ECC 1-10-3-2",
                            "description" => "يجب أن يغطي برنامج التوعية بالامن السيبراني كيفية حماية الجهة من أهم المخاطر والتهديدات السيبرانية\r\nوما يستجد منها، بما في ذلك التعامل الامن مع الجهزة المحمولة ووسائط التخزين.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-10-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('برنامج التوعية والتدريب بالأمن السيبراني CyberSecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 1-10-3-4",
                            "long_name" => "ECC 1-10-3-4",
                            "description" => "يجب أن يغطي برنامج التوعية بالامن السيبراني كيفية حماية الجهة من أهم المخاطر والتهديدات السيبرانية\r\nوما يستجد منها، بما في ذلك التعامل الامن مع وسائل التواصل الاجتماعي.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-10-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('برنامج التوعية والتدريب بالأمن السيبراني CyberSecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 1-10-4",
                    "long_name" => "ECC 1-10-4",
                    "description" => "يجب توفير المهارات المتخصصة والتدريب الازم للعاملين في المجلالت الوظيفية ذات العلاقة المباشرة\r\nبالامن السيبراني في الجهة، وتصنيفها بما يتماشى مع مسؤولياتهم الوظيفية فيما يتعلق بالامن\r\nالسيبراني",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-10-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('برنامج التوعية والتدريب بالأمن السيبراني CyberSecurity Awareness and Training Program'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 1-10-4-1",
                            "long_name" => "ECC 1-10-4-1",
                            "description" => "يجب توفير المهارات المتخصصة والتدريب اللزم للعاملين في المجالت الوظيفية ذات العلقة المباشرة\r\nبالامن السيبراني في الجهة، وتصنيفها بما يتماشى مع مسؤولياتهم الوظيفية فيما يتعلق بالامن\r\nالسيبراني، بما في ذلك  موظفو الادارة المعنية بالامن السيبراني",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-10-4-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('برنامج التوعية والتدريب بالأمن السيبراني CyberSecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 1-10-4-3",
                            "long_name" => "ECC 1-10-4-3",
                            "description" => "جب توفير المهارات المتخصصة والتدريب الازم للعاملين في المجلالت الوظيفية ذات العلقة المباشرة\r\nبالامن السيبراني في الجهة، وتصنيفها بما يتماشى مع مسؤولياتهم الوظيفية فيما يتعلق بالامن\r\nالسيبراني، بما في ذلك الاشرافية الوظائف",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-10-4-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('برنامج التوعية والتدريب بالأمن السيبراني CyberSecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 1-10-4-2",
                            "long_name" => "ECC 1-10-4-2",
                            "description" => "يجب توفير المهارات المتخصصة والتدريب اللازم للعاملين في المجالت الوظيفية ذات العلاقة المباشرة\r\nبالامن السيبراني في الجهة، وتصنيفها بما يتماشى مع مسؤولياتهم الوظيفية فيما يتعلق بالامن\r\nالسيبراني، بما في ذلك الموظفون العاملون في تطوير البرامج والتطبيقات والموظفون المشغلون للاصول المعلوماتية\r\nوالتقنية للجهة",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-10-4-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('برنامج التوعية والتدريب بالأمن السيبراني CyberSecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 1-10-5",
                    "long_name" => "ECC 1-10-5",
                    "description" => "يجب مراجعة تطبيق برنامج التوعية بالامن السيبراني في الجهة دوريا",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-10-5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('برنامج التوعية والتدريب بالأمن السيبراني CyberSecurity Awareness and Training Program'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-1-1",
                    "long_name" => "ECC 2-1-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني الادارة الاصول المعلوماتية والتقنية للجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة اﻷصول Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة اختبار الاختراق',
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
                    "short_name" => "ECC 2-1-2",
                    "long_name" => "ECC 2-1-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني الادارة الاصول المعلوماتية والتقنية للجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة اﻷصول Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-1-3",
                    "long_name" => "ECC 2-1-3",
                    "description" => "يجب تحديد وتوثيق واعتماد ونشر سياسة الستخدام المقبول للاصول المعلوماتية والتقنية للجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-1-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة اﻷصول Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة الاستخدام المقبول للأصول',
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
                    "short_name" => "ECC 2-1-4",
                    "long_name" => "ECC 2-1-4",
                    "description" => "يجب تطبيق سياسة الاستخدام المقبول للاصول المعلوماتية والتقنية للجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-1-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة اﻷصول Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-1-5",
                    "long_name" => "ECC 2-1-5",
                    "description" => "يجب تصنيف الاصول المعلوماتية والتقنية للجهة وترميزها )Labeling )والتعامل معها وفقاً للمتطلبات\r\nالتشريعية والتنظيمية ذات العلاقة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-1-5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة اﻷصول Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-1-6",
                    "long_name" => "ECC 2-1-6",
                    "description" => "يجب مراجعة متطلبات الامن السيبراني لادارة الاصول المعلوماتية والتقنية للجهة دورياً",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-1-6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة اﻷصول Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-2-1",
                    "long_name" => "ECC 2-2-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لادارة هويات الدخول والصلاحيات في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة هويات الدخول والصلاحيات Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة إدارة هويات الدخول والصلاحيات',
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
                    "short_name" => "ECC 2-2-2",
                    "long_name" => "ECC 2-2-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني لادارة هويات الدخول والصلاحيات في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-2-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة هويات الدخول والصلاحيات Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-2-3",
                    "long_name" => "ECC 2-2-3",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-2-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة هويات الدخول والصلاحيات Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-2-3-1",
                            "long_name" => "ECC 2-2-3-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة بحد\r\nأدنى  بناء( User Authentication( المستخدم هوية من ا  على إدارة تسجيل المستخدم وإدارة كلمة المرور",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-2-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة هويات الدخول والصلاحيات Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-2-3-2",
                            "long_name" => "ECC 2-2-3-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة بحد\r\nأدنى  التحقق من الهوية متعدد العناصر )Authentication Factor-Multi )لعمليات الدخول عن بعد",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-2-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة هويات الدخول والصلاحيات Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-2-3-3",
                            "long_name" => "ECC 2-2-3-3",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة بحد\r\nأدنى   إدارة تصاريح وصلاحيات المستخدمين )Authorization )بناء على مبادئ التحكم بالدخول ،\"Need-to-know and Need-to-use\" والستخدام المعرفة إلى الحاجة مبدأ )و  ومـبـدأ الحد الادنــى مـن الصلاحيات والامـتـيـازات \"Privilege Least ،\"ومـبـدأ فصل المهام  .)\"Segregation of Duties\"",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-2-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة هويات الدخول والصلاحيات Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-2-3-4",
                            "long_name" => "ECC 2-2-3-4",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة بحد\r\nأدنى  .)Privileged Access Management( والحساسة الهامة الاصلاحى  .)Privileged Access Management( والحساسة الهامة الصلاحيايات الإدارة",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-2-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة هويات الدخول والصلاحيات Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-2-3-5",
                            "long_name" => "ECC 2-2-3-5",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة بحد\r\nأدنى  المراجعة الدورية لهويات الدخول والصلاحيات",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-2-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة هويات الدخول والصلاحيات Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 2-2-4",
                    "long_name" => "ECC 2-2-4",
                    "description" => "يجب مراجعة تطبيق متطلبات الامن السيبراني لادارة هويات الدخول والصلاحيات في الجهة دورياً",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-2-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة هويات الدخول والصلاحيات Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ECC 2-3-1",
                    "long_name" => "ECC 2-3-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-3-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية اﻷنظمة وأجهزة معالجة المعلومات Information System and Processing Facilities Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة الحماية من البرمجيات الضارة',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة أمن الخوادم',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة أمن أجهزة المستخدمين والأجهزة المحمولة والأجهزة الشخصية',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار أمن أجهزة المستخدمين',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار أمن الخوادم',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار أمن قواعد البيانات',
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
                    "short_name" => "ECC 2-3-2",
                    "long_name" => "ECC 2-3-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-3-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية اﻷنظمة وأجهزة معالجة المعلومات Information System and Processing Facilities Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-3-3",
                    "long_name" => "ECC 2-3-3",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-3-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية اﻷنظمة وأجهزة معالجة المعلومات Information System and Processing Facilities Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-3-3-1",
                            "long_name" => "ECC 2-3-3-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة بحد أدنى  الحماية من الفيروسات والبرامج والنشطة المشبوهة والبرمجيات الضارة )Malware )على\r\nأجهزة المستخدمين والخوادم باستخدام تقنيات وآليات الحماية الحديثة والمتقدمة، وإدارتها\r\nبشكل آمن",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-3-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية اﻷنظمة وأجهزة معالجة المعلومات Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'معيار الحماية من البرمجيات الضارة',
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
                            "short_name" => "ECC 2-3-3-2",
                            "long_name" => "ECC 2-3-3-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة بحد أدنى  التقييد الحازم لستخدام أجهزة وسائط التخزين الخارجية والامن المتعلق بها.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-3-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية اﻷنظمة وأجهزة معالجة المعلومات Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [

                            "short_name" => "ECC 2-3-3-3",
                            "long_name" => "ECC 2-3-3-3",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة بحد أدنى إدارة حزم التحديثات والصلاحات للمنظمة والتطبيقات والاجهزة )Management Patch.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-3-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية اﻷنظمة وأجهزة معالجة المعلومات Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة إدارة حزم التحديثات والإصلاحات',
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

                            "short_name" => "ECC 2-3-3-4",
                            "long_name" => "ECC 2-3-3-4",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة بحد أدنى  مزامنة التوقيت )Synchronization Clock )مركزياً ومن مصدر دقيق وموثوق، ومن هذه\r\nالمصادر ما توفره الهيئة السعودية للمواصفات والمقاييس والجودة.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-3-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية اﻷنظمة وأجهزة معالجة المعلومات Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة أمن قواعد البيانات',
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
                    ]
                ],

                [
                    "short_name" => "ECC 2-3-4",
                    "long_name" => "ECC 2-3-4",
                    "description" => "يجب مراجعة متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة دورياً",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-3-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية اﻷنظمة وأجهزة معالجة المعلومات Information System and Processing Facilities Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-4-1",
                    "long_name" => "ECC 2-4-1",
                    "description" => "جب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-4-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية البريد اﻹلكترونى Email Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة أمن البريد الإلكتروني',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار حماية البريد الإلكتروني',
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
                    "short_name" => "ECC 2-4-2",
                    "long_name" => "ECC 2-4-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-4-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية البريد اﻹلكترونى Email Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-4-3",
                    "long_name" => "ECC 2-4-3",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-4-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية البريد اﻹلكترونى Email Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-4-3-1",
                            "long_name" => "ECC 2-4-3-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة بحد أدنى  تحليل وتصفية )Filtering ) ّ رسـائـل البريد الالكتروني )وخـصـوصـاً رسـائـل التصيد الالكتروني\r\n»Emails Phishing »والرسائل القتحامية »Emails Spam )»باستخدام تقنيات وآليات\r\nالحماية الحديثة والمتقدمة للبريد الالكتروني.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-4-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية البريد اﻹلكترونى Email Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-4-3-2",
                            "long_name" => "ECC 2-4-3-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة بحد أدنى التحقق من الهوية متعدد العناصر )Authentication Factor-Multi )للدخول عن بعد والدخول\r\nعن طريق صفحة موقع البريد الالكتروني )Webmail.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-4-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية البريد اﻹلكترونى Email Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-4-3-3",
                            "long_name" => "ECC 2-4-3-3",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة بحد أدنى النسخ الاحتياطي والرشفة للبريد الالكتروني.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-4-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية البريد اﻹلكترونى Email Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-4-3-4",
                            "long_name" => "ECC 2-4-3-4",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة بحد أدنى لحماية من التهديدات المتقدمة المستمرة )Protection APT ،)التي تستخدم عادة الفيروسات\r\nوالبرمجيات الضارة غير المعروفة مسبقاً )Malware Day-Zero ،)وإدارتها بشكل آمن",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-4-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية البريد اﻹلكترونى Email Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-4-3-5",
                            "long_name" => "ECC 2-4-3-5",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة بحد أدنى توثيق مجال البريد الالكتروني للجهة بالطرق التقنية، مثل طريقة إطار سياسة المرسل )Sender\r\n.)Policy Framework",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-4-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية البريد اﻹلكترونى Email Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 2-4-4",
                    "long_name" => "ECC 2-4-4",
                    "description" => "يجب مراجعة تطبيق متطلبات الامن السيبراني الخاصة بحماية البريد الالكتروني للجهة دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-4-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية البريد اﻹلكترونى Email Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-5-1",
                    "long_name" => "ECC 2-5-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لادارة أمن شبكات الجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-5-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة أمن الشبكات Networks Security Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة أمن الشبكات',
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
                        ],  [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار أمن الشبكات',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار أمن الشبكات اللاسلكية',
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
                    "short_name" => "ECC 2-5-2",
                    "long_name" => "ECC 2-5-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني لادارة أمن شبكات الجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-5-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة أمن الشبكات Networks Security Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-5-3",
                    "long_name" => "ECC 2-5-3",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-5-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة أمن الشبكات Networks Security Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-5-3-1",
                            "long_name" => "ECC 2-5-3-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى العزل والتقسيم المادي أو المنطقي لجزاء الشبكات بشكل آمن، والالزم للسيطرة على مخاطر\r\nالامن السيبراني ذات العلاقة، باستخدام جدار الحماية )Firewall )ومبدأ الدفاع الامني متعدد\r\n.)Defense-in-Depth( الامر",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة أمن الشبكات Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة أمن الشبكات',
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
                            "short_name" => "ECC 2-5-3-2",
                            "long_name" => "ECC 2-5-3-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى  عزل شبكة بيئة النتاج عن شبكات بيئات التطوير والاختبار",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة أمن الشبكات Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-5-3-3",
                            "long_name" => "ECC 2-5-3-3",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى أمن التصفح والاتصال بالانترنت، ويشمل ذلك التقييد الحازم للمواقع الالكترونية المشبوهة،\r\nومواقع مشاركة وتخزين الملفات، ومواقع الدخول عن بعد",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة أمن الشبكات Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-5-3-4",
                            "long_name" => "ECC 2-5-3-4",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى أمن الشبكات الالسلكية وحمايتها باستخدام وسائل آمنة للتحقق من الهوية والتشفير، وعدم\r\nً على دراسة متكاملة للمخاطر المترتبة\r\nربط الشبكات الالسلكية بشبكة الجهة الداخلية إل بناء\r\nعلى ذلك والتعامل معها بما يضمن حماية الاصول التقنية للجهة",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة أمن الشبكات Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-5-3-5",
                            "long_name" => "ECC 2-5-3-5",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى قيود وإدارة منافذ وبروتوكولت وخدمات الشبكة",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة أمن الشبكات Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة حماية تطبيقات الويب',
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
                            "short_name" => "ECC 2-5-3-6",
                            "long_name" => "ECC 2-5-3-6",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى )Intrusion Prevention Systems( الختراقات ومنع لكتشاف المتقدمة الحماية أ",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة أمن الشبكات Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-5-3-7",
                            "long_name" => "ECC 2-5-3-7",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى .)DNS( النطاقات أسماء نظام أ",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة أمن الشبكات Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-5-3-8",
                            "long_name" => "ECC 2-5-3-8",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى حماية قناة تصفح الانترنت من التهديدات المتقدمة المستمرة )Protection APT ،)التي\r\nتستخدم عادة الفيروسات والبرمجيات الضارة غير المعروفة مسبقاً )Malware Day-Zero ،)\r\nوإدارتها بشكل آمن.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة أمن الشبكات Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة أمن الشبكات',
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
                    ]
                ],

                [
                    "short_name" => "ECC 2-5-4",
                    "long_name" => "ECC 2-5-4",
                    "description" => "يجب مراجعة تطبيق متطلبات الامن السيبراني لادارة أمن شبكات الجهة دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-5-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة أمن الشبكات Networks Security Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-6-1",
                    "long_name" => "ECC 2-6-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني الخاصة بأمن الجهزة المحمولة والاجهزة الشخصية\r\n للعاملين )BYOD )عند ارتباطها بشبكة الجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-6-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('أمن اﻷجهزة المحمولة Mobile Devices Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [

                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة أمن أجهزة المستخدمين والأجهزة المحمولة والأجهزة الشخصية',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار أمن الأجهزة المحمولة',
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
                    "short_name" => "ECC 2-6-2",
                    "long_name" => "ECC 2-6-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني الخاصة بأمن الجهزة المحمولة وأجهزة )BYOD )للجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-6-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('أمن اﻷجهزة المحمولة Mobile Devices Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-6-3",
                    "long_name" => "ECC 2-6-3",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني الخاصة بأمن الاجهزة المحمولة وأجهزة )BYOD )للجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-6-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('أمن اﻷجهزة المحمولة Mobile Devices Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-6-3-1",
                            "long_name" => "ECC 2-6-3-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني الخاصة بأمن الاجهزة المحمولة وأجهزة )BYOD )للجهة بحد\r\nأدنى فصل وتشفير البيانات والمعلومات )الخاصة بالجهة( المخزنة على الجهزة المحمولة وأجهزة\r\n.)BYOD(",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-6-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('أمن اﻷجهزة المحمولة Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-6-3-2",
                            "long_name" => "ECC 2-6-3-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني الخاصة بأمن الاجهزة المحمولة وأجهزة )BYOD )للجهة بحد\r\nأدنى  الستخدام المحدد والمقيد بناء  على ما تتطلبه مصلحة أعمال الجهة",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-6-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('أمن اﻷجهزة المحمولة Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-6-3-3",
                            "long_name" => "ECC 2-6-3-3",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني الخاصة بأمن الاجهزة المحمولة وأجهزة )BYOD )للجهة بحد\r\nأدنى حذف البيانات والمعلومات )الخاصة بالجهة( المخزنة على الجهزة المحمولة وأجهزة )BYOD )\r\nعند فقدان الجهزة أو بعد انتهاء\/إنهاء العلقة الوظيفية مع الجهة.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-6-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('أمن اﻷجهزة المحمولة Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-6-3-4",
                            "long_name" => "ECC 2-6-3-4",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني الخاصة بأمن الاجهزة المحمولة وأجهزة )BYOD )للجهة بحد\r\nأدنى  لمستخدمين الامنية ا",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-6-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('أمن اﻷجهزة المحمولة Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 2-6-4",
                    "long_name" => "ECC 2-6-4",
                    "description" => "يجب مراجعة تطبيق متطلبات الامن السيبراني الخاصة لامن الاجهزة المحمولة وأجهزة )BYOD )للجهة\r\n.ًدوري",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-6-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('أمن اﻷجهزة المحمولة Mobile Devices Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-7-1",
                    "long_name" => "ECC 2-7-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لحماية بيانات ومعلومات الجهة، والتعامل معها\r\n وفقاً للمتطلبات التشريعية والتنظيمية ذات العلاقة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-7-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية البيانات والمعلومات Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-7-2",
                    "long_name" => "ECC 2-7-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني لحماية بيانات ومعلومات الجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-7-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية البيانات والمعلومات Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-7-3",
                    "long_name" => "ECC 2-7-3",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية البيانات والمعلومات",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-7-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية البيانات والمعلومات Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-7-3-1",
                            "long_name" => "ECC 2-7-3-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية البيانات والمعلومات بحد أدنى .والمعلومات البيانات ملكية",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-7-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية البيانات والمعلومات Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-7-3-2",
                            "long_name" => "ECC 2-7-3-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية البيانات والمعلومات بحد أدنى )Classifcation and Labeling Mechanisms( ترميزها وآلية والمعلومات البيانات ت",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-7-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية البيانات والمعلومات Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-7-3-3",
                            "long_name" => "ECC 2-7-3-3",
                            "description" => "جب أن تغطي متطلبات الامن السيبراني لحماية البيانات والمعلومات بحد أدنى والمعلومات البيانات خصوصية",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-7-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية البيانات والمعلومات Data and Information Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 2-7-4",
                    "long_name" => "ECC 2-7-4",
                    "description" => "يجب مراجعة تطبيق متطلبات الامن السيبراني لحماية بيانات ومعلومات الجهة دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-7-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية البيانات والمعلومات Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-8-1",
                    "long_name" => "ECC 2-8-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني للتشفير في الجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-8-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('التشفير Cryptography'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة التشفير',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار التشفير',
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
                    "short_name" => "ECC 2-8-2",
                    "long_name" => "ECC 2-8-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني للتشفير في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-8-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('التشفير Cryptography'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة التشفير',
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
                    "short_name" => "ECC 2-8-3",
                    "long_name" => "ECC 2-8-3",
                    "description" => "جب أن تغطي متطلبات الامن السيبراني للتشفير",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-8-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('التشفير Cryptography'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [

                        [
                            "short_name" => "ECC 2-8-3-1",
                            "long_name" => "ECC 2-8-3-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني للتشفير بحد أدنى معايير حلول التشفير المعتمدة والقيود المطبقة عليها )تقنياً وتنظيمياً(.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-8-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('التشفير Cryptography'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة التشفير',
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
                            "short_name" => "ECC 2-8-3-2",
                            "long_name" => "ECC 2-8-3-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني للتشفير بحد أدنى الادارة الامنة لمفاتيح التشفير خلل عمليات دورة حياتها.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-8-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('التشفير Cryptography'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-8-3-3",
                            "long_name" => "ECC 2-8-3-3",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني للتشفير بحد أدنى  تشفير البيانات أثناء النقل والتخزين بناء على تصنيفها وحسب المتطلبات التشريعية والتنظيمية\r\nذات العلاقة",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-8-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('التشفير Cryptography'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة أمن الخوادم',
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
                    ]
                ],

                [
                    "short_name" => "ECC 2-8-4",
                    "long_name" => "ECC 2-8-4",
                    "description" => "جب مراجعة تطبيق متطلبات الامن السيبراني للتشفير في الجهة دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-8-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('التشفير Cryptography'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة التشفير',
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
                    "short_name" => "ECC 2-9-1",
                    "long_name" => "ECC 2-9-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لادارة النسخ الاحتياطية للجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-9-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة النسخ الاحتياطية Backup and Recovery Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-9-2",
                    "long_name" => "ECC 2-9-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني لادارة النسخ الاحتياطية للجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-9-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة النسخ الاحتياطية Backup and Recovery Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-9-3",
                    "long_name" => "ECC 2-9-3",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة النسخ الاحتياطية",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-9-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة النسخ الاحتياطية Backup and Recovery Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-9-3-1",
                            "long_name" => "ECC 2-9-3-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة النسخ الاحتياطية بحد أدنى  1 نطاق النسخ الااحتياطية وشموليتها للصول المعلوماتية والتقنية الحساسة.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-9-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة النسخ الاحتياطية Backup and Recovery Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-9-3-2",
                            "long_name" => "ECC 2-9-3-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة النسخ الاحتياطية بحد أدنى  القدرة السريعة على استعادة البيانات والانظمة بعد التعرض لحوادث الامن السيبراني",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-9-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة النسخ الاحتياطية Backup and Recovery Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-9-3-3",
                            "long_name" => "ECC 2-9-3-3",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة النسخ الاحتياطية بحد أدنى إجراء فحص دوري لمدى فعالية استعادة النسخ الاحتياطية.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-9-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة النسخ الاحتياطية Backup and Recovery Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]
                ],

                [
                    "short_name" => "ECC 2-9-4",
                    "long_name" => "ECC 2-9-4",
                    "description" => "يجب مراجعة تطبيق متطلبات الامن السيبراني لادارة النسخ الاحتياطية للجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-9-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة النسخ الاحتياطية Backup and Recovery Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-10-1",
                    "long_name" => "ECC 2-10-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لادارة الثغرات التقنية للجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-10-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة الثغرات Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة إدارة الثغرات',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار إدارة الثغرات',
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
                    "short_name" => "ECC 2-10-2",
                    "long_name" => "ECC 2-10-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني لادارة الثغرات التقنية للجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-10-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة الثغرات Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-10-3",
                    "long_name" => "ECC 2-10-3",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة الثغرات",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-10-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة الثغرات Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-10-3-1",
                            "long_name" => "ECC 2-10-3-1",
                            "description" => "يجب أن تغطي متطلبات المن السيبراني لدارة الثغرات بحد أدنى  فحص واكتشاف الثغرات دورياً.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-10-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة الثغرات Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة إدارة الثغرات',
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
                            "short_name" => "ECC 2-10-3-2",
                            "long_name" => "ECC 2-10-3-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة الثغرات بحد أدنى تصنيف الثغرات حسب خطورتها",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-10-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة الثغرات Vulnerabilities Management'),
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
                            "short_name" => "ECC 2-10-3-3",
                            "long_name" => "ECC 2-10-3-3",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة الثغرات بحد أدنى على تصنيفها والمخاطر السيبرانية المترتبة عليها.\r\nبناء الثغرات م",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-10-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة الثغرات Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-10-3-4",
                            "long_name" => "ECC 2-10-3-4",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة الثغرات بحد أدنى   إدارة حزم التحديثات والصلاحيات الامنية لمعالجة الثغرات",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-10-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة الثغرات Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-10-3-5",
                            "long_name" => "ECC 2-10-3-5",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لادارة الثغرات بحد أدنى  التواصل والاشتراك مع مصادر موثوقة فيما يتعلق بالتنبيهات المتعلقة بالثغرات الجديدة\r\nوالمحدثة.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-10-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة الثغرات Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة إدارة الثغرات',
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
                    ]
                ],

                [
                    "short_name" => "ECC 2-10-4",
                    "long_name" => "ECC 2-10-4",
                    "description" => "يجب مراجعة تطبيق متطلبات الامن السيبراني لادارة الثغرات التقنية للجهة دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-10-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة الثغرات Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-11-1",
                    "long_name" => "ECC 2-11-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لعمليات اختبار الاختراق في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-11-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إختبار الاختراق Penetration Testing'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة اختبار الاختراق',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار اختبار الاختراق',
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
                    "short_name" => "ECC 2-11-2",
                    "long_name" => "ECC 2-11-2",
                    "description" => "يجب تنفيذ عمليات اختبار الاختراق في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-11-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إختبار الاختراق Penetration Testing'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-11-3",
                    "long_name" => "ECC 2-11-3",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني لختبار الاختراق",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-11-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إختبار الاختراق Penetration Testing'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-11-3-1",
                            "long_name" => "ECC 2-11-3-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لختبار الاختراق بحد أدنى نطاق عمل اختبار الاخـتـراق، ليشمل جميع الخدمات المقدمة خارجياً )عـن طريق الانترنت(\r\nومكوناتها التقنية، ومنها => البنية التحتية، المواقع الالكترونية، تطبيقات الويب، تطبيقات الهواتف\r\nالذكية والاوحية، البريد الالكتروني والدخول عن بعد.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-11-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إختبار الاختراق Penetration Testing'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-11-3-2",
                            "long_name" => "ECC 2-11-3-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لختبار الاختراق بحد أدنى عمل اختبار الاختراق دورياً",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-11-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إختبار الاختراق Penetration Testing'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 2-11-4",
                    "long_name" => "ECC 2-11-4",
                    "description" => "يجب مراجعة تطبيق متطلبات الامن السيبراني لعمليات اختبار الاختراق في الجهة دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-11-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إختبار الاختراق Penetration Testing'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة اختبار الاختراق',
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
                    "short_name" => "ECC 2-12-1",
                    "long_name" => "ECC 2-12-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات إدارة سجلت الاحداث ومراقبة الامن السيبراني للجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-12-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة سجلات اﻷحداث ومراقبة اﻷمن السيبرانى CyberSecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة إدارة سجلات الأحداث ومراقبة الأمن السيبراني',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار إدارة سجلات الأحداث ومراقبة الأمن السيبراني',
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
                    "short_name" => "ECC 2-12-2",
                    "long_name" => "ECC 2-12-2",
                    "description" => "يجب تطبيق متطلبات إدارة سجلت الاحداث ومراقبة الامن السيبراني للجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-12-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة سجلات اﻷحداث ومراقبة اﻷمن السيبرانى CyberSecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-12-3",
                    "long_name" => "ECC 2-12-3",
                    "description" => "يجب أن تغطي متطلبات إدارة سجلت الاحداث ومراقبة الامن السيبراني",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-12-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة سجلات اﻷحداث ومراقبة اﻷمن السيبرانى CyberSecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-12-3-1",
                            "long_name" => "ECC 2-12-3-1",
                            "description" => "يجب أن تغطي متطلبات إدارة سجلت الأحداث ومراقبة الامن السيبراني بحد أدنى",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-12-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة سجلات اﻷحداث ومراقبة اﻷمن السيبرانى CyberSecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [

                            "short_name" => "ECC 2-12-3-2",
                            "long_name" => "ECC 2-12-3-2",
                            "description" => "يجب أن تغطي متطلبات إدارة سجلت الاحداث ومراقبة الامن السيبراني بحد أدنى تفعيل سجلت الاحـداث الخاصة بالحسابات ذات الصلاحيات الهامة والحساسة على الاصول\r\nالمعلوماتية وأحداث عمليات الدخول عن بعد لدى الجهة",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-12-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة سجلات اﻷحداث ومراقبة اﻷمن السيبرانى CyberSecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [

                            "short_name" => "ECC 2-12-3-3",
                            "long_name" => "ECC 2-12-3-3",
                            "description" => "يجب أن تغطي متطلبات إدارة سجلات الاحداث ومراقبة الامن السيبراني بحد أدنى تحديد التقنيات الازمة )SIEM )لجمع سجلات الاحداث الخاصة بالامن السيبراني",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-12-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة سجلات اﻷحداث ومراقبة اﻷمن السيبرانى CyberSecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [

                            "short_name" => "ECC 2-12-3-4",
                            "long_name" => "ECC 2-12-3-4",
                            "description" => "يجب أن تغطي متطلبات إدارة سجلات الاحداث ومراقبة الامن السيبراني بحد أدنى المراقبة المستمرة لسجلات الاحداث الخاصة بالامن السيبراني.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-12-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة سجلات اﻷحداث ومراقبة اﻷمن السيبرانى CyberSecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [

                            "short_name" => "ECC 2-12-3-5",
                            "long_name" => "ECC 2-12-3-5",
                            "description" => "يجب أن تغطي متطلبات إدارة سجلات الاحداث ومراقبة الامن السيبراني بحد أدنى مدة الاحتفاظ بسجلات الاحداث الخاصة بالامن السيبراني )على أل تقل عن 12 شهر(.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-12-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة سجلات اﻷحداث ومراقبة اﻷمن السيبرانى CyberSecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 2-12-4",
                    "long_name" => "ECC 2-12-4",
                    "description" => "يجب مراجعة تطبيق متطلبات إدارة سجلات الاحداث ومراقبة الامن السيبراني في الجهة دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-12-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة سجلات اﻷحداث ومراقبة اﻷمن السيبرانى CyberSecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة إدارة حوادث وتهديدات الأمن السيبراني',
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
                    "short_name" => "ECC 2-13-1",
                    "long_name" => "ECC 2-13-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات إدارة حوادث وتهديدات الامن السيبراني في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-13-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة حوادث وتهديدات اﻷمن السيبراني CyberSecurity Incident and Threat Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة إدارة حوادث وتهديدات الأمن السيبراني',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار إدارة حوادث وتهديدات الأمن السيبراني',
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
                    "short_name" => "ECC 2-13-2",
                    "long_name" => "ECC 2-13-2",
                    "description" => "يجب تطبيق متطلبات إدارة حوادث وتهديدات الامن السيبراني في الجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-13-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة حوادث وتهديدات اﻷمن السيبراني CyberSecurity Incident and Threat Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-13-3",
                    "long_name" => "ECC 2-13-3",
                    "description" => "يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-13-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة حوادث وتهديدات اﻷمن السيبراني CyberSecurity Incident and Threat Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-13-3-1",
                            "long_name" => "ECC 2-13-3-1",
                            "description" => "يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني بحد أدنى  وضع خطط الاستجابة للحوادث الامنية وآليات التصعيد.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-13-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة حوادث وتهديدات اﻷمن السيبراني CyberSecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة إدارة حوادث وتهديدات الأمن السيبراني',
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
                            "short_name" => "ECC 2-13-3-2",
                            "long_name" => "ECC 2-13-3-2",
                            "description" => "يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني بحد أدنى تصنيف حوادث الامن السيبراني",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-13-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة حوادث وتهديدات اﻷمن السيبراني CyberSecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة إدارة حوادث وتهديدات الأمن السيبراني',
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
                            "short_name" => "ECC 2-13-3-3",
                            "long_name" => "ECC 2-13-3-3",
                            "description" => "يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني بحد أدنى  تبليغ الهيئة عند حدوث حادثة أمن سيبراني",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-13-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة حوادث وتهديدات اﻷمن السيبراني CyberSecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة إدارة حوادث وتهديدات الأمن السيبراني',
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
                            "short_name" => "ECC 2-13-3-4",
                            "long_name" => "ECC 2-13-3-4",
                            "description" => "يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني بحد أدنى مشاركة التنبيهات والمعلومات الستباقية ومؤشرات الاختراق وتقارير حوادث الامن السيبراني\r\nمع الهيئة",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-13-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة حوادث وتهديدات اﻷمن السيبراني CyberSecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة إدارة حوادث وتهديدات الأمن السيبراني',
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
                            "short_name" => "ECC 2-13-3-5",
                            "long_name" => "ECC 2-13-3-5",
                            "description" => "يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني بحد أدنى الحصول على المعلومات الاستباقية )Intelligence Threat )والتعامل معها.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-13-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('إدارة حوادث وتهديدات اﻷمن السيبراني CyberSecurity Incident and Threat Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة إدارة حوادث وتهديدات الأمن السيبراني',
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
                    ]
                ],

                [
                    "short_name" => "ECC 2-13-4",
                    "long_name" => "ECC 2-13-4",
                    "description" => "يجب مراجعة تطبيق متطلبات إدارة حوادث وتهديدات الامن السيبراني في الجهة دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-13-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('إدارة حوادث وتهديدات اﻷمن السيبراني CyberSecurity Incident and Threat Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-14-1",
                    "long_name" => "ECC 2-14-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من\r\nالوصول المادي غير المصرح به والفقدان والسرقة والتخريب.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-14-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('اﻷمن المادى Physical Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة الأمن السيبراني المتعلق بالأمن المادي',
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
                    "short_name" => "ECC 2-14-2",
                    "long_name" => "ECC 2-14-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-14-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('اﻷمن المادى Physical Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-14-3",
                    "long_name" => "ECC 2-14-3",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-14-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('اﻷمن المادى Physical Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-14-3-1",
                            "long_name" => "ECC 2-14-3-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب بحد أدنى  الدخول المصرح به للاماكن الحساسة في الجهة )مثل => مركز بيانات الجهة، مركز التعافي من\r\nالكوارث، أماكن معالجة المعلومات الحساسة، مركز المراقبة المنية، غرف اتصالات الشبكة،\r\nمناطق المداد الخاصة بالجهزة والاعداد التقنية، وغيرها(.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-14-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('اﻷمن المادى Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-14-3-2",
                            "long_name" => "ECC 2-14-3-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب بحد أدنى  .)CCTV( والمراقبة الدخول س",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-14-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('اﻷمن المادى Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-14-3-3",
                            "long_name" => "ECC 2-14-3-3",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب بحد أدنى  حماية معلومات سجلات الدخول والمراقبة",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-14-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('اﻷمن المادى Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-14-3-4",
                            "long_name" => "ECC 2-14-3-4",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب بحد أدنى  أمن إتلف وإعادة استخدام الاصول المادية التي تحوي معلومات مصنفة )وتشمل => الوثائق\r\nالورقية ووسائط الحفظ والتخزين(.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-14-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('اﻷمن المادى Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-14-3-5",
                            "long_name" => "ECC 2-14-3-5",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب بحد أدنى أمن الجهزة والمعدات داخل مباني الجهة وخارجها.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-14-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('اﻷمن المادى Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 2-14-4",
                    "long_name" => "ECC 2-14-4",
                    "description" => "جب مراجعة متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\n غير المصرح به والفقدان والسرقة والتخريب دوريا",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-14-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('اﻷمن المادى Physical Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-15-1",
                    "long_name" => "ECC 2-15-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة من المخاطر\r\nالسيبرانية",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-15-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية تطبيقات الويب Web Application Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة حماية تطبيقات الويب',
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
                        ],
                        [
                            'document_type' => $this->getDocumentIdByName('معايير الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'معيار حماية تطبيقات الويب',
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
                    "short_name" => "ECC 2-15-2",
                    "long_name" => "ECC 2-15-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-15-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية تطبيقات الويب Web Application Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-15-3",
                    "long_name" => "ECC 2-15-3",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-15-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية تطبيقات الويب Web Application Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-15-3-1",
                            "long_name" => "ECC 2-15-3-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة بحد أدنى .)Web Application Firewall( الويب لتطبيقات الحماية جدار ا",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-15-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية تطبيقات الويب Web Application Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة حماية تطبيقات الويب',
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
                            "short_name" => "ECC 2-15-3-2",
                            "long_name" => "ECC 2-15-3-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة بحد أدنى .)Multi-tier Architecture( المستويات متعددة المعمارية مبدأ ا",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-15-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية تطبيقات الويب Web Application Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة حماية تطبيقات الويب',
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
                            "short_name" => "ECC 2-15-3-3",
                            "long_name" => "ECC 2-15-3-3",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة بحد أدنى  استخدام بروتوكولات آمنة )مثل بروتوكول HTTPS.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-15-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية تطبيقات الويب Web Application Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-15-3-4",
                            "long_name" => "ECC 2-15-3-4",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة بحد أدنى توضيح سياسة الاستخدام الامن للمستخدمين.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-15-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية تطبيقات الويب Web Application Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة حماية تطبيقات الويب',
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
                            "short_name" => "ECC 2-15-3-5",
                            "long_name" => "ECC 2-15-3-5",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة بحد أدنى التحقق مـن الهوية متعدد العناصر )Authentication Factor-Multi )لعمليات دخـول\r\nالمستخدمين",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-15-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية تطبيقات الويب Web Application Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 2-15-4",
                    "long_name" => "ECC 2-15-4",
                    "description" => "يجب مراجعة متطلبات الامن السيبراني لحماية تطبيقات الويب للجهة من المخاطر السيبرانية دوريا",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-15-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية تطبيقات الويب Web Application Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة حماية تطبيقات الويب',
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
                    "short_name" => "ECC 3-1-1",
                    "long_name" => "ECC 3-1-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني ضمن إدارة استمرارية أعمال الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 3-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('جوانب صمود اﻷمن السيبراني فى إدارة استمرارية اﻷعمال CyberSecurity Resilience aspects of Business Continuity Management (BCM)'),
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
                    ]
                ],
                [
                    "short_name" => "ECC 3-1-2",
                    "long_name" => "ECC 3-1-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني ضمن إدارة استمرارية أعمال الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 3-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('جوانب صمود اﻷمن السيبراني فى إدارة استمرارية اﻷعمال CyberSecurity Resilience aspects of Business Continuity Management (BCM)'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 3-1-3",
                    "long_name" => "ECC 3-1-3",
                    "description" => "يجب أن تغطي إدارة استمرارية العمال في الجهة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 3-1-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('جوانب صمود اﻷمن السيبراني فى إدارة استمرارية اﻷعمال CyberSecurity Resilience aspects of Business Continuity Management (BCM)'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 3-1-3-1",
                            "long_name" => "ECC 3-1-3-1",
                            "description" => "يجب أن تغطي إدارة استمرارية العمال في الجهة بحد أدنى التأكد من استمرارية الانظمة والجراءات المتعلقة بالامن السيبراني.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 3-1-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('جوانب صمود اﻷمن السيبراني فى إدارة استمرارية اﻷعمال CyberSecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 3-1-3-2",
                            "long_name" => "ECC 3-1-3-2",
                            "description" => "يجب أن تغطي إدارة استمرارية العمال في الجهة بحد أدنى وضع خطط الستجابة لحوداث الامن السيبراني التي قد تؤثر على استمرارية أعمال الجهة.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 3-1-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('جوانب صمود اﻷمن السيبراني فى إدارة استمرارية اﻷعمال CyberSecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 3-1-3-3",
                            "long_name" => "ECC 3-1-3-3",
                            "description" => "يجب أن تغطي إدارة استمرارية العمال في الجهة بحد أدنى .)Disaster Recovery Plan( الكوارث من التعافي خطط و",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 3-1-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('جوانب صمود اﻷمن السيبراني فى إدارة استمرارية اﻷعمال CyberSecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 3-1-4",
                    "long_name" => "ECC 3-1-4",
                    "description" => "يجب مراجعة متطلبات الامن السيبراني ضمن إدارة استمرارية أعمال الجهة دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 3-1-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('جوانب صمود اﻷمن السيبراني فى إدارة استمرارية اﻷعمال CyberSecurity Resilience aspects of Business Continuity Management (BCM)'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 4-1-1",
                    "long_name" => "ECC 4-1-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني ضمن العقود والتفاقيات مع الاطـراف الخارجية\r\nللجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق باﻷطراف الخارجية Third-Party CyberSecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة الأمن السيبراني المتعلّق بالأطراف الخارجية',
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
                    "short_name" => "ECC 4-1-2",
                    "long_name" => "ECC 4-1-2",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني ضمن العقود والتفاقيات )مثل اتفاقية مستوى الخدمة SLA )مع\r\nالاطراف الخارجية التي قد تتأثر بإصابتها بيانات الجهة أو الخدمات المقدمة له",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق باﻷطراف الخارجية Third-Party CyberSecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 4-1-2-1",
                            "long_name" => "ECC 4-1-2-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني ضمن العقود والتفاقيات )مثل اتفاقية مستوى الخدمة SLA )مع\r\nالاطراف الخارجية التي قد تتأثر بإصابتها بيانات الجهة أو الخدمات المقدمة لها بحد أدنى   بنود المحافظة على سرية المعلومات )Clauses Disclosure-Non ) َ و الحذف الامن من قِ بل\r\nالطرف الخارجي لبيانات الجهة عند انتهاء الخدمة",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 4-1-2-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق باﻷطراف الخارجية Third-Party CyberSecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 4-1-2-2",
                            "long_name" => "ECC 4-1-2-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني ضمن العقود والتفاقيات )مثل اتفاقية مستوى الخدمة SLA )مع\r\nالاطراف الخارجية التي قد تتأثر بإصابتها بيانات الجهة أو الخدمات المقدمة لها بحد أدنى   إجراءات التواصل في حال حدوث حادثة أمن سيبراني.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 4-1-2-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق باﻷطراف الخارجية Third-Party CyberSecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 4-1-2-3",
                            "long_name" => "ECC 4-1-2-3",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني ضمن العقود والتفاقيات )مثل اتفاقية مستوى الخدمة SLA )مع\r\nالاطراف الخارجية التي قد تتأثر بإصابتها بيانات الجهة أو الخدمات المقدمة لها بحد أدنى   إلزام الطرف الخارجي بتطبيق متطلبات وسياسات الامن السيبراني للجهة والمتطلبات التشريعية\r\nوالاتنظيمية ذات العلاقة",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 4-1-2-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق باﻷطراف الخارجية Third-Party CyberSecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 4-1-3",
                    "long_name" => "ECC 4-1-3",
                    "description" => "يجب أن تغطي متطلبات الامن السيبراني مع الاطراف الخارجية التي تقدم خدمات إسناد لتقنية المعلومات،\r\nأو خدمات مدارة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-1-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق باﻷطراف الخارجية Third-Party CyberSecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 4-1-3-1",
                            "long_name" => "ECC 4-1-3-1",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني مع الاطراف الخارجية التي تقدم خدمات إسناد لتقنية المعلومات،\r\nأو خدمات مدارة بحد أدنى  إجراء تقييم لمخاطر الامن السيبراني، والتأكد من وجود مايضمن السيطرة على تلك المخاطر، قبل\r\nتوقيع العقود والتفاقيات أو عند تغيير المتطلبات التشريعية والاتنظيمية ذات العلاقة.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 4-1-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق باﻷطراف الخارجية Third-Party CyberSecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 4-1-3-2",
                            "long_name" => "ECC 4-1-3-2",
                            "description" => "يجب أن تغطي متطلبات الامن السيبراني مع الاطراف الخارجية التي تقدم خدمات إسناد لتقنية المعلومات،\r\nأو خدمات مدارة بحد أدنى  أن تكون مراكز عمليات خدمات الامن السيبراني المدارة للتشغيل والمراقبة، والتي تستخدم طريقة\r\nالوصول عن بعد، موجودة بالكامل داخل المملكة.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 4-1-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق باﻷطراف الخارجية Third-Party CyberSecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة الأمن السيبراني المتعلّق بالأطراف الخارجية',
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
                    ]
                ],

                [
                    "short_name" => "ECC 4-1-4",
                    "long_name" => "ECC 4-1-4",
                    "description" => "يجب مراجعة متطلبات الامن السيبراني مع الاطراف الخارجية دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-1-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق باﻷطراف الخارجية Third-Party CyberSecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 4-2-1",
                    "long_name" => "ECC 4-2-1",
                    "description" => "يجب تحديد وتوثيق واعتماد متطلبات الامـن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية\r\nوالاستضافة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة Cloud Computing and hosting CyberSecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة',
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
                    "short_name" => "ECC 4-2-2",
                    "long_name" => "ECC 4-2-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني الخاصة بخدمات الحوسبة السحابية والاستضافة للجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-2-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة Cloud Computing and hosting CyberSecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 4-2-3",
                    "long_name" => "ECC 4-2-3",
                    "description" => "بما يتوافق مع المتطلبات التشريعية والاتنظيمية ذات العالقة، وبالضافة إلى ما ينطبق من الضوابط ضمن\r\nالمكونات الرئيسية رقم )1 )و )2 )و )3 )والمكون الفرعي رقم )4-1 )الضرورية لحماية بيانات الجهة أو الخدمات\r\nالمقدمة لها، يجب أن تغطي متطلبات الامـن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية\r\nوالاستضافة",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-2-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة Cloud Computing and hosting CyberSecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 4-2-3-1",
                            "long_name" => "ECC 4-2-3-1",
                            "description" => "بما يتوافق مع المتطلبات التشريعية والاتنظيمية ذات العلاقة، وبالضافة إلى ما ينطبق من الضوابط ضمن\r\nالمكونات الرئيسية رقم )1 )و )2 )و )3 )والمكون الفرعي رقم )4-1 )الضرورية لحماية بيانات الجهة أو الخدمات\r\nالمقدمة لها، يجب أن تغطي متطلبات الامـن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية\r\nوالستضافة بحد أدنى   تصنيف البيانات قبل استضافتها لدى مقدمي خدمات الحوسبة السحابية والستضافة، وإعادتها\r\nللجهة )بصيغة قابلة للستخدام( عند إنتهاء الخدمة",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 4-2-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة Cloud Computing and hosting CyberSecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة',
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
                            "short_name" => "ECC 4-2-3-2",
                            "long_name" => "ECC 4-2-3-2",
                            "description" => "بما يتوافق مع المتطلبات التشريعية والاتنظيمية ذات العلاقة، وبالاضافة إلى ما ينطبق من الضوابط ضمن\r\nالمكونات الرئيسية رقم )1 )و )2 )و )3 )والمكون الفرعي رقم )4-1 )الضرورية لحماية بيانات الجهة أو الخدمات\r\nالمقدمة لها، يجب أن تغطي متطلبات الامـن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية\r\nوالاستضافة بحد أدنى  فصل البيئة الخاصة بالجهة )وخصوصاً الخوادم الفتراضية( عن غيرها من البيئات التابعة لجهات\r\nأخرى في خدمات الحوسبة السحابية",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 4-2-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة Cloud Computing and hosting CyberSecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة',
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
                            "short_name" => "ECC 4-2-3-3",
                            "long_name" => "ECC 4-2-3-3",
                            "description" => "بما يتوافق مع المتطلبات التشريعية والاتنظيمية ذات العلاقة، وبالاضافة إلى ما ينطبق من الضوابط ضمن\r\nالمكونات الرئيسية رقم )1 )و )2 )و )3 )والمكون الفرعي رقم )4-1 )الضرورية لحماية بيانات الجهة أو الخدمات\r\nالمقدمة لها، يجب أن تغطي متطلبات الامـن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية\r\nوالاستضافة بحد أدنى  موقع استضافة وتخزين معلومات الجهة يجب أن يكون داخل المملكة.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 4-2-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة Cloud Computing and hosting CyberSecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة',
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
                    ]
                ],

                [
                    "short_name" => "ECC 4-2-4",
                    "long_name" => "ECC 4-2-4",
                    "description" => "يجب مراجعة متطلبات الامن السيبراني الخاصة بخدمات الحوسبة السحابية والاستضافة دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-2-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة Cloud Computing and hosting CyberSecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 5-1-1",
                    "long_name" => "ECC 5-1-1",
                    "description" => "يجب تحديد وتـوثـيـق واعـتـمـاد متطلبات الامــن السيبراني لحماية أجـهـزة وأنـظـمـة التحكم الصناعي\r\n.للجهة( OT\/ICS(",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 5-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة الأمن السيبراني لأنظمة التحكم الصناعي',
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
                    "short_name" => "ECC 5-1-2",
                    "long_name" => "ECC 5-1-2",
                    "description" => "يجب تطبيق متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي )ICS\/OT )للجهة.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 5-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 5-1-3",
                    "long_name" => "ECC 5-1-3",
                    "description" => "بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\/O",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 5-1-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 5-1-3-1",
                            "long_name" => "ECC 5-1-3-1",
                            "description" => "بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\/OT )يجب أن تغطي بحد أدنى  1 الـتـقـيـيـد الــحــازم والـتـقـسـيـم الــمــادي والـمـنـطـقـي عــنــد ربــــط شــبــكــات النــتــاج الـصـنـاعـيـة\r\n)ICS\/OT )مــع الـشـبـكـات الخــــرى الـتـابـعـة لـلـجـهـة، مـثـل => شبكة الاعــمــال الـداخـلـيـة للجهة\r\n.\"Corporate Network\"",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 5-1-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 5-1-3-2",
                            "long_name" => "ECC 5-1-3-2",
                            "description" => "بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\/OT )يجب أن تغطي بحد أدنى  التقييد الحازم والتقسيم المادي والمنطقي عند ربط الانظمة أو الشبكات الصناعية مع شبكات\r\nخارجية، مثل => الانترنت أو الدخول عن بعد أو الاتصال الاسلكي",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 5-1-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة الأمن السيبراني لأنظمة التحكم الصناعي',
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
                            "short_name" => "ECC 5-1-3-3",
                            "long_name" => "ECC 5-1-3-3",
                            "description" => "بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\/OT )يجب أن تغطي بحد أدنى  تفعيل سجلات الاحداث )logs Event )الخاصة بالامن السيبراني للشبكة الصناعية والاتصالت\r\nالمرتبطة بها ما أمكن ذلك، والمراقبة المستمرة لها.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 5-1-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة الأمن السيبراني لأنظمة التحكم الصناعي',
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
                            "short_name" => "ECC 5-1-3-4",
                            "long_name" => "ECC 5-1-3-4",
                            "description" => "بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\/OT )يجب أن تغطي بحد أدنى  .)Safety Instrumented System “SIS”( السلمة معدات أنظمة ع",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 5-1-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 5-1-3-5",
                            "long_name" => "ECC 5-1-3-5",
                            "description" => "بالاضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\/OT )يجب أن تغطي بحد أدنى  التقييد الحازم لستخدام وسائط التخزين الخارجية",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 5-1-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة الأمن السيبراني لأنظمة التحكم الصناعي',
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
                            "short_name" => "ECC 5-1-3-6",
                            "long_name" => "ECC 5-1-3-6",
                            "description" => "الضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\/OT )يجب أن تغطي بحد أدنى   التقييد الحازم لتوصيل الجهزة المحمولة على شبكة النتاج الصناعية.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 5-1-3-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 5-1-3-7",
                            "long_name" => "ECC 5-1-3-7",
                            "description" => "بالاضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\/OT )يجب أن تغطي بحد أدنى   مراجعة إعدادات وتحصين النظمة الصناعية، وأنظمة الدعم والاجهزة اللية الصناعية )Secure\r\n.ًدوريا( Confguration and Hardening",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 5-1-3-7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة الأمن السيبراني لأنظمة التحكم الصناعي',
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
                            "short_name" => "ECC 5-1-3-8",
                            "long_name" => "ECC 5-1-3-8",
                            "description" => "بالاضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\/OT )يجب أن تغطي بحد أدنى   )OT\/ICS Vulnerability Management( الصناعية اللانظمة ثغرات إدارة",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 5-1-3-8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'document' => [
                                [
                                    'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                                    'privacy' => 2,
                                    'document_name' => 'سياسة الأمن السيبراني لأنظمة التحكم الصناعي',
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
                            "short_name" => "ECC 5-1-3-9",
                            "long_name" => "ECC 5-1-3-9",
                            "description" => "بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\/OT )يجب أن تغطي بحد أدنى  إدارة حــــــــــزم الـــــتـــــحـــــديـــــثـــــات والصــــــــــــلحــــــــــــات المــــــنــــــيــــــة لـــــانـــــظـــــمـــــة الــــصــــنــــاعــــيــــة\r\n.)OT\/ICS Patch Management(",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 5-1-3-9",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 5-1-3-10",
                            "long_name" => "ECC 5-1-3-10",
                            "description" => "الضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\/OT )يجب أن تغطي بحد أدنى   إدارة البرامج الخاصة بالامن السيبراني الصناعي للحماية من الفيروسات والبرمجيات المشبوهة\r\nوالضارة.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 5-1-3-10",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 5-1-4",
                    "long_name" => "ECC 5-1-4",
                    "description" => "يجب مراجعة متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي )ICS\/OT )للجهة دورياً.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 5-1-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'document' => [
                        [
                            'document_type' => $this->getDocumentIdByName('نماذج سياسات الأمن السيبراني'), // Dynamically get document idID
                            'privacy' => 2,
                            'document_name' => 'سياسة الأمن السيبراني لأنظمة التحكم الصناعي',
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
                    "short_name" => "ECC 1-6-4",
                    "long_name" => "ECC 1-6-4",
                    "description" => "يجب مراجعة متطلبات الأمن السيبراني في إدارة المشاريع في الجهة دوريًا",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-6-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('الأمن السيبراني ضمن إدارة المشاريع المعلوماتية والتقنية CyberSecurity in Information Technology Projects'),
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
