<?php

namespace Database\Seeders;

use App\Models\ControlControlObjective;
use App\Models\ControlObjective;
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

class NCAECC_2_2024Seeder extends Seeder
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
                'name' => 'NCA-ECC – 2: 2024',
                'description' => 'The National Cybersecurity Authority “NCA” has developed the Essential Cybersecurity Controls (ECC – 1: 2018) to set the minimum cybersecurity requirements based on best practices and standards to minimize the cybersecurity risks to the information and technical assets of organizations that originate from internal and external threats. The Essential Cybersecurity Controls consist of 114 main controls, divided into five main domains.',
                'icon' => 'fa-universal-access',
                'status' => '1',
                'regulator_id' => $this->regulatorId,

            ]);

            // Main domains with their subdomains
            $mainDomains = [
                [
                    'name' => 'Cybersecurity Governance',
                    'order' => '1',
                    'subdomains' => [
                        [
                            'name' => 'Cybersecurity Strategy',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Cybersecurity Management',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Cybersecurity Policies and Procedures',
                            'order' => '3',
                        ],
                        [
                            'name' => 'Cybersecurity Role and Responsibilities',
                            'order' => '4',
                        ],
                        [
                            'name' => 'Cybersecurity Risk Management',
                            'order' => '5',
                        ],
                        [
                            'name' => 'Cybersecurity in Information Technology Projects',
                            'order' => '6',
                        ],
                        [
                            'name' => 'Cybersecurity Regulatory Compliance',
                            'order' => '7',
                        ],
                        [
                            'name' => 'Cybersecurity Periodical Assessment and Audit',
                            'order' => '8',
                        ],
                        [
                            'name' => 'Cybersecurity in Human Resources',
                            'order' => '9',
                        ],
                        [
                            'name' => 'Cybersecurity Awareness and Training Program',
                            'order' => '10',
                        ]
                    ]
                ],
                [
                    'name' => 'Cybersecurity Defense',
                    'order' => '2',
                    'subdomains' => [
                        [
                            'name' => 'Asset Management',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Identity and Access Management',
                            'order' => '2',
                        ],
                        [
                            'name' =>
                            'Information System and Processing Facilities Protection',
                            'order' => '3',
                        ],
                        [
                            'name' => 'Email Protection',
                            'order' => '4',
                        ],
                        [
                            'name' => 'Networks Security Management',
                            'order' => '5',
                        ],
                        [
                            'name' => 'Mobile Devices Security',
                            'order' => '6',
                        ],
                        [
                            'name' => 'Data and Information Protection',
                            'order' => '7',
                        ],
                        [
                            'name' => 'Cryptography',
                            'order' => '8',
                        ],
                        [
                            'name' => 'Backup and Recovery Management',
                            'order' => '9',
                        ],
                        [
                            'name' => 'Vulnerabilities Management',
                            'order' => '10',
                        ],
                        [
                            'name' => 'Penetration Testing',
                            'order' => '11',
                        ],
                        [
                            'name' =>
                            'Cybersecurity Event Logs and Monitoring Management',
                            'order' => '12',
                        ],
                        [
                            'name' => 'Cybersecurity Incident and Threat Management',
                            'order' => '13',
                        ],
                        [
                            'name' => 'Physical Security',
                            'order' => '14',
                        ],
                        [
                            'name' => 'Web Application Security',
                            'order' => '15',
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
                            'order' => '1',
                        ],
                        [
                            'name' => 'Cloud Computing and hosting Cybersecurity',
                            'order' => '2',
                        ]

                    ]
                ],
                [
                    'name' => 'ICS CyberSecurity',
                    'order' => '5',
                    'subdomains' => [
                        [
                            'name' => 'Industrial Control Systems (ICS) Protection',
                            'order' => '1',
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
                    "description" => "A cybersecurity strategy must be defined, documented and approved. It must be supported by the head of the organization or his/her delegate (referred to in this document as Authorizing Official). The strategy goals must be in-line with related laws and regulations.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Strategy'), // Dynamically get family ID
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
                    ],
                    'requirement' => [
                        [
                            'name' => "ECC 1-1-1 ( R1 )",
                            'description' => "Approved Cybersecurity Strategy Document for the Organization",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => "ECC 1-1-1 ( R2 )",
                            'description' => "Evidence Confirming Approval of the Cybersecurity Strategy by the Competent Authority in the Organization",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ]
                    ]
                ],
                [

                    "short_name" => "ECC 1-1-2",
                    "long_name" => "ECC 1-1-2",
                    "description" => "A roadmap must be executed to implement the cybersecurity strategy.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Strategy'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => " ECC 1-1-2 ( R1 )",
                            'description' => "Action Plan for Implementing the Organization's Cybersecurity Strategy",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ]
                    ]

                ],
                [

                    "short_name" => "ECC 1-1-3",
                    "long_name" => "ECC 1-1-3",
                    "description" => "The cybersecurity strategy must be reviewed periodically according to planned
intervals or upon changes to related laws and regulations.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-1-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Strategy'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => " ECC 1-1-3 ( R1 )",
                            'description' => "Evidence Confirming Regular Review of the Organization's Cybersecurity Strategy",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ]
                    ]
                ],
                [

                    "short_name" => "ECC 1-2-1",
                    "long_name" => "ECC 1-2-1",
                    "description" => "A dedicated cybersecurity function (e.g., division, department) must be established
within the organization. This function must be independent from the Information
Technology/Information Communication and Technology (IT/ICT) functions (as
per the Royal Decree number 37140 dated 14/8/1438H). It is highly recommended
that this cybersecurity function reports directly to the head of the organization or
his/her delegate while ensuring that this does not result in a conflict of interest.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
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
                    ],
                    'requirement' => [
                        [
                            'name' => " ECC 1-2-1 ( R1 )",
                            'description' => "Approved Organizational Structure of the Organization.",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ]
                    ]
                ],
                [

                    "short_name" => "ECC 1-2-2",
                    "long_name" => "ECC 1-2-2",
                    "description" => "All cybersecurity positions must be filled by full-time, qualified citizens with expertise in the field of cybersecurity.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-2-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => " ECC 1-2-2 ( R1 )",
                            'description' => "Organization's Cybersecurity Department structure",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => " ECC 1-2-2 ( R2 )",
                            'description' => "Organization's IT Department structure",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => " ECC 1-2-2 ( R3 )",
                            'description' => "List of Employees' Contract in the Organization's Cybersecurity and IT Departments.",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => " ECC 1-2-2 ( R4 )",
                            'description' => "List of Employees in the Organization's Cybersecurity Department",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => " ECC 1-2-2 ( R5 )",
                            'description' => "Jobe Description for Organization's Cybersecurity Department's Manger and Employees.",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ]
                ],
                [

                    "short_name" => "ECC 1-2-3",
                    "long_name" => "ECC 1-2-3",
                    "description" => "A cybersecurity steering committee must be established by the Authorizing Official
to ensure the support and implementation of the cybersecurity programs and
initiatives within the organization. Committee members, roles and responsibilities,
and governance framework must be defined, documented and approved. The
committee must include the head of the cybersecurity function as one of its members.
It is highly recommended that the committee reports directly to the head of the
organization or his/her delegate while ensuring that this does not result in a conflict
of interest.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-2-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
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
                    ],
                    'requirement' => [
                        [
                            'name' => " ECC 1-2-3 ( R1 )",
                            'description' => "Approved Document for the Establishment of the Organization's Cybersecurity Committee, specifying the committee's establishment date, reference, and approval by the competent authority in the organization.",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => " ECC 1-2-3 ( R2 )",
                            'description' => "List of Members of the Organization's Cybersecurity Committee",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => " ECC 1-2-3 ( R3 )",
                            'description' => "Cybersecurity Committee Charter",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => " ECC 1-2-3 ( R4 )",
                            'description' => "Minutes of the Last Meeting of the Organization's Cybersecurity Committee (MoM)",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ]
                    ]
                ],
                [

                    "short_name" => "ECC 1-3-1",
                    "long_name" => "ECC 1-3-1",
                    "description" => "Cybersecurity policies and procedures must be defined and documented by the
cybersecurity function, approved by the Authorizing Official, and disseminated to
relevant parties inside and outside the organization.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-3-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Policies and Procedures'), // Dynamically get family ID

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
                    ],
                    'requirement' => [
                        [
                            'name' => " ECC 1-3-1 ( R1 )",
                            'description' => "Documented and approved cybersecurity policies and procedures",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => " ECC 1-3-1 ( R2 )",
                            'description' => "Evidence of approval of the policies and procedures by the competent authority in the organization",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => " ECC 1-3-1 ( R3 )",
                            'description' => "Proof that the organization has disseminated the policies and procedures to its employees",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ],
                ],
                [

                    "short_name" => "ECC 1-3-2",
                    "long_name" => "ECC 1-3-2",
                    "description" => "The cybersecurity function must ensure that the cybersecurity policies and procedures are implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-3-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Policies and Procedures'), // Dynamically get family ID

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
                    ],
                    'requirement' => [
                        [
                            'name' => " ECC 1-3-2 ( R1 )",
                            'description' => "Report (proof, screenshot) confirming the application of technical cybersecurity standards.",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ]
                ],
                [

                    "short_name" => "ECC 1-3-3",
                    "long_name" => "ECC 1-3-3",
                    "description" => "The cybersecurity policies and procedures must be supported by technical security
standards (e.g., operating systems, databases and firewall technical security
standards).",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-3-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Policies and Procedures'), // Dynamically get family ID

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
                    ],
                    'requirement' => [
                        [
                            'name' => " ECC 1-3-3 ( R1 )",
                            'description' => "Report (proof, screenshot) confirming the application of technical cybersecurity standards.",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => " ECC 1-3-3 ( R2 )",
                            'description' => "Documented and approved technical cybersecurity standards",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ]
                ],
                [
                    "short_name" => "ECC 1-3-4",
                    "long_name" => "ECC 1-3-4",
                    "description" => "The cybersecurity policies and procedures must be reviewed periodically according to
planned intervals or upon changes to related laws and regulations. Changes and
reviews must be approved and documented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-3-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Policies and Procedures'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => " ECC 1-3-4 ( R1 )",
                            'description' => "Evidence of regular review of the organization's cybersecurity policies, procedures, and standards",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ]
                    ]

                ],
                [
                    "short_name" => "ECC 1-4-1",
                    "long_name" => "ECC 1-4-1",
                    "description" => "Cybersecurity organizational structure and related roles and responsibilities must be
defined, documented, approved, supported and assigned by the Authorizing Official
while ensuring that this does not result in a conflict of interest.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-4-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Role and Responsibilities'),
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
                    ],
                    'requirement' => [
                        [
                            'name' => " ECC 1-4-1 ( R1 )",
                            'description' => "Cybersecurity governance structure of the organization",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => " ECC 1-4-1 ( R2 )",
                            'description' => "Approved document outlining cybersecurity roles and responsibilities within the organization",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => " ECC 1-4-1 ( R3 )",
                            'description' => "A comprehensive job description matrix outlining the responsibilities of all cybersecurity roles within the organization (Cybersecurity Job Descriptions) such as: Developing and updating cybersecurity policies and standards",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ]
                    ]

                ],
                [
                    "short_name" => "ECC 1-4-2",
                    "long_name" => "ECC 1-4-2",
                    "description" => "The cybersecurity roles and responsibilities must be reviewed periodically according
to planned intervals or upon changes to related laws and regulations.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-4-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Role and Responsibilities'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => " ECC 1-4-2 ( R1 )",
                            'description' => "Evidence of regular review of cybersecurity roles and responsibilities",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ]
                ],
                [
                    "short_name" => "ECC 1-5-1",
                    "long_name" => "ECC 1-5-1",
                    "description" => "Cybersecurity risk management methodology and procedures must be defined,
documented and approved as per confidentiality, integrity and availability
considerations of information and technology assets.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-5-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
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
                    ],
                    'requirement' => [
                        [
                            'name' => " ECC 1-5-1 ( R1 )",
                            'description' => "The adopted methodology and procedures for managing cybersecurity risks in the organization",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ]
                ],
                [
                    "short_name" => "ECC 1-5-2",
                    "long_name" => "ECC 1-5-2",
                    "description" => "The cybersecurity risk management methodology and procedures must be
implemented by the cybersecurity function.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-5-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => " ECC 1-5-2 ( R1 )",
                            'description' => "Organization's cybersecurity risk register",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => " ECC 1-5-2 ( R2 )",
                            'description' => "Cybersecurity risk treatment plan",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ],
                ],
                [
                    "short_name" => "ECC 1-5-3",
                    "long_name" => "ECC 1-5-3",
                    "description" => "The cybersecurity risk assessment procedures must be implemented at least in the
following cases:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-5-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => " ECC 1-5-3 ( R1 )",
                            'description' => "Cybersecurity risk treatment plan",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ],
                    "children" => [
                        [
                            "short_name" => "ECC 1-5-3-1",
                            "long_name" => "ECC 1-5-3-1",
                            "description" => "The cybersecurity risk assessment procedures must be implemented at least in the following cases:
Early stages of technology projects.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-5-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'requirement' => [
                                [
                                    'name' => " ECC 1-5-3-1 ( R1 )",
                                    'description' => "Report detailing the identification and assessment of cybersecurity risks throughout the information technology project lifecycle in the organization",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                            ],
                        ],
                        [
                            "short_name" => "ECC 1-5-3-2",
                            "long_name" => "ECC 1-5-3-2",
                            "description" => "The cybersecurity risk assessment procedures must be implemented at least in the following cases: Before making major changes to technology infrastructure.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-5-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'requirement' => [
                                [
                                    'name' => " ECC 1-5-3-2 ( R1 )",
                                    'description' => "Report detailing the risk assessment of a significant change made to the production environment of the organization's information and technology assets",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                            ],
                        ],
                        [
                            "short_name" => "ECC 1-5-3-3",
                            "long_name" => "ECC 1-5-3-3",
                            "description" => "The cybersecurity risk assessment procedures must be implemented at least in the following cases: During the planning phase of obtaining third party services.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-5-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'requirement' => [
                                [
                                    'name' => " ECC 1-5-3-3 ( R1 )",
                                    'description' => "Report detailing the identification and assessment of cybersecurity risks for external parties providing IT support or managed services to the organization",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                            ],
                        ],
                        [
                            "short_name" => "ECC 1-5-3-4",
                            "long_name" => "ECC 1-5-3-4",
                            "description" => "The cybersecurity risk assessment procedures must be implemented at least in the following cases: During the planning phase and before going live for new technology
services and products.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-5-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'requirement' => [
                                [
                                    'name' => " ECC 1-5-3-4 ( R1 )",
                                    'description' => "Report detailing the identification and assessment of cybersecurity risks when planning and before launching new technology products and services into the production environment.",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                            ],
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 1-5-4",
                    "long_name" => "ECC 1-5-4",
                    "description" => "The cybersecurity risk management methodology and procedures must be reviewed
periodically according to planned intervals or upon changes to related laws and
regulations. Changes and reviews must be approved and documented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-5-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => " ECC 1-5-4 ( R1 )",
                            'description' => "Evidence of regular review of the organization's cybersecurity risk management methodology.",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ],
                ],
                [
                    "short_name" => "ECC 1-6-1",
                    "long_name" => "ECC 1-6-1",
                    "description" => "Cybersecurity requirements must be included in project and asset (information/
technology) change management methodology and procedures to identify and
manage cybersecurity risks as part of project management lifecycle. The cybersecurity
requirements must be a key part of the overall requirements of technology projects.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-6-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => " ECC 1-6-1 ( R1 )",
                            'description' => "Organization's project management methodology and process document",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => " ECC 1-6-1 ( R2 )",
                            'description' => "Organization's change management process document for information and technology assets.",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ],
                ],
                [
                    "short_name" => "ECC 1-6-2",
                    "long_name" => "ECC 1-6-2",
                    "description" => "The cybersecurity requirements in project and assets (information/technology)
change management must include at least the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-6-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                    "children" => [
                        [
                            "short_name" => "ECC 1-6-2-1",
                            "long_name" => "ECC 1-6-2-1",
                            "description" => "The cybersecurity requirements in project and assets (information/technology) change management must include at least the following: Vulnerability assessment and remediation.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-6-2-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'requirement' => [
                                [
                                    'name' => " ECC 1-6-2-1 ( R1 )",
                                    'description' => "Report detailing the assessment and remediation of cybersecurity vulnerabilities throughout the project management and change management lifecycle for the organization's information and technology assets",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ]
                            ],
                        ],
                        [
                            "short_name" => "ECC 1-6-2-2",
                            "long_name" => "ECC 1-6-2-2",
                            "description" => "The cybersecurity requirements in project and assets (information/technology) change management must include at least the following: Conducting a configurations ’ review, secure configuration and
hardening and patching before changes or going live for technology
projects.",
                            "supplemental_guidance" => null,
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-6-2-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
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
                            ],
                            'requirement' => [
                                [
                                    'name' => " ECC 1-6-2-2 ( R1 )",
                                    'description' => "Report detailing the assessment, review, and patching of system configurations throughout the project management and change management lifecycle for the organization's information and technology assets.",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ]
                            ],
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 1-6-3",
                    "long_name" => "ECC 1-6-3",
                    "description" => "The cybersecurity requirements related to software and application development
projects must include at least the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-6-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 1-6-3-1",
                            "long_name" => "ECC 1-6-3-1",
                            "description" => "The cybersecurity requirements related to software and application development projects must include at least the following: Using secure coding standards.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-6-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'requirement' => [
                                [
                                    'name' => " ECC 1-6-3-1 ( R1 )",
                                    'description' => "Approved secure coding standards",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                            ],
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
                            "description" => "The cybersecurity requirements related to software and application development projects must include at least the following: Using trusted and licensed sources for software development tools and
libraries.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-6-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'requirement' => [
                                [
                                    'name' => " ECC 1-6-3-2 ( R1 )",
                                    'description' => "List of licensed and documented software used for application development tools and their associated libraries.",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                            ],
                        ],
                        [
                            "short_name" => "ECC 1-6-3-3",
                            "long_name" => "ECC 1-6-3-3",
                            "description" => "The cybersecurity requirements related to software and application development projects must include at least the following: Conducting compliance test for software against the defined
organizational cybersecurity requirements.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-6-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'requirement' => [
                                [
                                    'name' => " ECC 1-6-3-3 ( R1 )",
                                    'description' => "List of security tests conducted to verify application compliance with the organization's cybersecurity requirements and associated reports",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                            ],
                        ],
                        [
                            "short_name" => "ECC 1-6-3-4",
                            "long_name" => "ECC 1-6-3-4",
                            "description" => "The cybersecurity requirements related to software and application development projects must include at least the following: Secure integration between software components.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-6-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'requirement' => [
                                [
                                    'name' => " ECC 1-6-3-4 ( R1 )",
                                    'description' => "Report detailing the testing and assessment of secure integration between the organization's technical applications.",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                            ],
                        ],
                        [
                            "short_name" => "ECC 1-6-3-5",
                            "long_name" => "ECC 1-6-3-5",
                            "description" => "The cybersecurity requirements related to software and application development projects must include at least the following: Conducting a configurations ’ review, secure configuration and
hardening and patching before going live for software products.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-6-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
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
                            ],
                            'requirement' => [
                                [
                                    'name' => " ECC 1-6-3-5 ( R1 )",
                                    'description' => "Evidence of secure configuration and hardening and patch management reviews prior to application deployment.",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                            ],
                        ],
                    ]
                ],
                [
                    "short_name" => "ECC 1-6-4",
                    "long_name" => "ECC 1-6-4",
                    "description" => "يجب مراجعة متطلبات الأمن السيبراني في إدارة المشاريع في الجهة دوريًا",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-6-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Information Technology Projects'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => " ECC 1-6-4 ( R1 )",
                            'description' => "Evidence of regular review of cybersecurity requirements in project management and change management for the organization's information and technology assets.",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ],
                ],
                [
                    "short_name" => "ECC 1-7-1",
                    "long_name" => "ECC 1-7-1",
                    "description" => "If there are internationally recognized agreements or commitments that include specific cybersecurity requirements and are locally adopted, the organization must identify those requirements and comply with them.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-7-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Regulatory Compliance'),
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
                    ],
                    'requirement' => [
                        [
                            'name' => "ECC 1-7-1 ( R1 )",
                            'description' => "A list identifying the national laws and regulations applicable to the entity",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => "ECC 1-7-1 ( R2 )",
                            'description' => "A report demonstrating the entity's level of compliance with applicable national laws and regulations",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ],
                ],
                [
                    "short_name" => "ECC 1-8-1",
                    "long_name" => "ECC 1-8-1",
                    "description" => "Cybersecurity reviews must be conducted periodically by the cybersecurity function
                        in the organization to assess the compliance with the cybersecurity controls in the
                        organization.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-8-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Periodical Assessment and Audit'),
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
                    ],
                    'requirement' => [
                        [
                            'name' => "ECC 1-8-1 ( R1 )",
                            'description' => "Regular review reports on the implementation of cybersecurity controls within the organization",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ]
                ],
                [
                    "short_name" => "ECC 1-8-2",
                    "long_name" => "ECC 1-8-2",
                    "description" => "Cybersecurity audits and reviews must be conducted by independent parties outside
the cybersecurity function (e.g., Internal Audit function) to assess the compliance
with the cybersecurity controls in the organization. Audits and reviews must be
conducted independently, while ensuring that this does not result in a conflict of interest, as per the Generally Accepted Auditing Standard controls (GAAS), and
related laws and regulations.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-8-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Periodical Assessment and Audit'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => "ECC 1-8-2 ( R1 )",
                            'description' => "Internal audit reports (by the internal audit department or compliance department) / external audit reports (by an independent external auditor) on the organization's cybersecurity requirementsn",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ]
                ],
                [
                    "short_name" => "ECC 1-8-3",
                    "long_name" => "ECC 1-8-3",
                    "description" => "Results from the cybersecurity audits and reviews must be documented and presented
to the cybersecurity steering committee and Authorizing Official. Results must
include the audit/review scope, observations, recommendations and remediation
plans.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-8-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Periodical Assessment and Audit'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => "ECC 1-8-3 ( R1 )",
                            'description' => "Evidence of presentation of cybersecurity audit and review results to the cybersecurity oversight committee and the competent authority in the organization",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ]
                ],
                [
                    "short_name" => "ECC 1-9-1",
                    "long_name" => "ECC 1-9-1",
                    "description" => "Personnel cybersecurity requirements (prior to employment, during employment and
after termination/separation) must be defined, documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-9-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
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
                    ],
                    'requirement' => [
                        [
                            'name' => "ECC 1-9-1 ( R1 )",
                            'description' => "Documented and approved cybersecurity human resource policy",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ]
                ],
                [
                    "short_name" => "ECC 1-9-2",
                    "long_name" => "ECC 1-9-2",
                    "description" => "The personnel cybersecurity requirements must be implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-9-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => "ECC 1-9-2 ( R1 )",
                            'description' => "Sample of an employment contract for one of the organization's employees (signed copy).",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => "ECC 1-9-2 ( R2 )",
                            'description' => "Sample of an employment contract for one of the organization's employees (signed copy).",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                        [
                            'name' => "ECC 1-9-2 ( R3 )",
                            'description' => "Evidence of security screening or vetting for employees in cybersecurity roles and technical positions with significant and sensitive privileges.",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ]
                ],
                [
                    "short_name" => "ECC 1-9-3",
                    "long_name" => "ECC 1-9-3",
                    "description" => "The personnel cybersecurity requirements prior to employment must include at least
the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-9-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 1-9-3-1",
                            "long_name" => "ECC 1-9-3-1",
                            "description" => "The personnel cybersecurity requirements prior to employment must include at least the following: Inclusion of personnel cybersecurity responsibilities and non-disclosure
clauses (covering the cybersecurity requirements during employment and
after termination/ separation) in employment contracts.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-9-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'requirement' => [
                                [
                                    'name' => "ECC 1-9-3-1 ( R1 )",
                                    'description' => "Sample of an employment contract for one of the organization's employees (signed copy).",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                                [
                                    'name' => "ECC 1-9-3-1 ( R2 )",
                                    'description' => "Sample of an employment contract for one of the organization's employees (signed copy).",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                            ]
                        ],
                        [
                            "short_name" => "ECC 1-9-3-2",
                            "long_name" => "ECC 1-9-3-2",
                            "description" => "The personnel cybersecurity requirements prior to employment must include at least the following: Screening or vetting candidates of cybersecurity and critical/privileged
positions.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-9-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'requirement' => [

                                [
                                    'name' => "ECC 1-9-3-2 ( R1 )",
                                    'description' => "Evidence of security screening or vetting for employees in cybersecurity roles and technical positions with significant and sensitive privileges.",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                            ]
                        ],
                    ],

                ],

                [
                    "short_name" => "ECC 1-9-4",
                    "long_name" => "ECC 1-9-4",
                    "description" => "The personnel cybersecurity requirements during employment must include at least
the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-9-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 1-9-4-1",
                            "long_name" => "ECC 1-9-4-1",
                            "description" => "The personnel cybersecurity requirements during employment must include at least the following: Cybersecurity awareness (during on-boarding and during employment).",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-9-4-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'requirement' => [
                                [
                                    'name' => "ECC 1-9-4-1 ( R1 )",
                                    'description' => "Evidence of providing cybersecurity awareness content to employees before they start working in the organization and granting them access privileges",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                            ]
                        ],
                        [
                            "short_name" => "ECC 1-9-4-2",
                            "long_name" => "ECC 1-9-4-2",
                            "description" => "The personnel cybersecurity requirements during employment must include at least the following: Implementation of and compliance with the cybersecurity requirements as per the organizational cybersecurity policies and procedures.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-9-4-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'requirement' => [
                                [
                                    'name' => "ECC 1-9-4-2 ( R1 )",
                                    'description' => "Sample of an employee acknowledgment of cybersecurity policies (signed copy)",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                            ]
                        ],
                    ]
                ],

                [
                    "short_name" => "ECC 1-9-5",
                    "long_name" => "ECC 1-9-5",
                    "description" => "Personnel privileges must be reviewed and revoked immediately after the end or termination of the employment relationship with the organization.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-9-5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => "ECC 1-9-5 ( R1 )",
                            'description' => "Termination process (including a signed and approved sample application of the process)",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ],
                ],
                [
                    "short_name" => "ECC 1-9-6",
                    "long_name" => "ECC 1-9-6",
                    "description" => "Personnel cybersecurity requirements must be reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-9-6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 1-10-1",
                    "long_name" => "ECC 1-10-1",
                    "description" => "A cybersecurity awareness program must be developed and approved. The program
must be conducted periodically through multiple channels to strengthen the
awareness about cybersecurity, cyber threats and risks, and to build a positive
cybersecurity awareness culture.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-10-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => "ECC 1-10-1 ( R1 )",
                            'description' => "Approved cybersecurity awareness program document",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ],
                ],
                [
                    "short_name" => "ECC 1-10-2",
                    "long_name" => "ECC 1-10-2",
                    "description" => "The cybersecurity awareness program must be implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-10-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => "ECC 1-10-2 ( R1 )",
                            'description' => "Approved cybersecurity awareness program implementation plan",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ],
                ],
                [
                    "short_name" => "ECC 1-10-3",
                    "long_name" => "ECC 1-10-3",
                    "description" => "The cybersecurity awareness program must cover the latest cyber threats and how to
protect against them, and must include at least the following subjects:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-10-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'requirement' => [
                        [
                            'name' => "ECC 1-10-3 ( R1 )",
                            'description' => "Approved cybersecurity awareness program implementation plan",
                            'framework_id' => $framework->id,
                            'responsible_type' => "user",
                            'responsible_id' => '1',
                            'due_date' => now()
                        ],
                    ],
                    "children" => [
                        [
                            "short_name" => "ECC 1-10-3-1",
                            "long_name" => "ECC 1-10-3-1",
                            "description" => "The cybersecurity awareness program must cover the latest cyber threats and how to protect against them, and must include at least the following subjects: Secure handling of email services, especially phishing emails.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-10-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'requirement' => [
                                [
                                    'name' => "ECC 1-10-3-1 ( R1 )",
                                    'description' => "Evidence of providing awareness content on the secure handling of email services, especially phishing emails",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                            ],
                        ],
                        [
                            "short_name" => "ECC 1-10-3-2",
                            "long_name" => "ECC 1-10-3-2",
                            "description" => "The cybersecurity awareness program must cover the latest cyber threats and how to protect against them, and must include at least the following subjects: Secure handling of mobile devices and storage media.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-10-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                            'requirement' => [
                                [
                                    'name' => "ECC 1-10-3-2 ( R1 )",
                                    'description' => "Evidence of providing awareness content on the secure handling of mobile devices and storage media",
                                    'framework_id' => $framework->id,
                                    'responsible_type' => "user",
                                    'responsible_id' => '1',
                                    'due_date' => now()
                                ],
                            ],
                        ],
                        [
                            "short_name" => "ECC 1-10-3-4",
                            "long_name" => "ECC 1-10-3-4",
                            "description" => "The cybersecurity awareness program must cover the latest cyber threats and how to
protect against them, and must include at least the following subjects: Secure use of social media.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-10-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
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
                    "description" => "Essential and customized (i.e., tailored to job functions as it relates to cybersecurity)
training and access to professional skillsets must be made available to personnel
working directly on tasks related to cybersecurity including:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-10-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 1-10-4-1",
                            "long_name" => "ECC 1-10-4-1",
                            "description" => "Essential and customized (i.e., tailored to job functions as it relates to cybersecurity)
training and access to professional skillsets must be made available to personnel
working directly on tasks related to cybersecurity including:
Cybersecurity function's personnel.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-10-4-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 1-10-4-2",
                            "long_name" => "ECC 1-10-4-2",
                            "description" => "Essential and customized (i.e., tailored to job functions as it relates to cybersecurity) training and access to professional skillsets must be made available to personnel working directly on tasks related to cybersecurity including: Personnel working on software/application development. and
information and technology assets operations.",
                            "supplemental_guidance" => null,
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-10-4-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 1-10-4-3",
                            "long_name" => "ECC 1-10-4-3",
                            "description" => "Essential and customized (i.e., tailored to job functions as it relates to cybersecurity) training and access to professional skillsets must be made available to personnel working directly on tasks related to cybersecurity including: Executive and supervisory positions..",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 1-10-4-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
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
                    "description" => "The implementation of the cybersecurity awareness program must be reviewed
periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 1-10-5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness and Training Program'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-1-1",
                    "long_name" => "ECC 2-1-1",
                    "description" => "Cybersecurity requirements for managing information and technology assets must be
defined, documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'),
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
                    "description" => "The cybersecurity requirements for managing information and technology assets must
be implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-1-3",
                    "long_name" => "ECC 2-1-3",
                    "description" => "Acceptable use policy of information and technology assets must be defined,
documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-1-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'),
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
                    "description" => "Acceptable use policy of information and technology assets must be implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-1-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-1-5",
                    "long_name" => "ECC 2-1-5",
                    "description" => "Information and technology assets must be classified, labeled and handled as per related
law and regulatory requirements.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-1-5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-1-6",
                    "long_name" => "ECC 2-1-6",
                    "description" => "The cybersecurity requirements for managing information and technology assets must
be reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-1-6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-2-1",
                    "long_name" => "ECC 2-2-1",
                    "description" => "Cybersecurity requirements for identity and access management must be defined,
documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),
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
                    "description" => "Cybersecurity requirements for identity and access management must be defined,
documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-2-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-2-3",
                    "long_name" => "ECC 2-2-3",
                    "description" => "The cybersecurity requirements for identity and access management must include at
least the following :",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-2-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-2-3-1",
                            "long_name" => "ECC 2-2-3-1",
                            "description" => "Single-factor authentication based on user registration management and password management.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-2-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-2-3-2",
                            "long_name" => "ECC 2-2-3-2",
                            "description" => "Multi-factor authentication must be implemented, including the identification of appropriate authentication factors, their number, and suitable authentication technologies, based on the results of an assessment of the potential impact of authentication failure or bypass. This applies to remote access and accounts with critical and sensitive privileges.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-2-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-2-3-3",
                            "long_name" => "ECC 2-2-3-3",
                            "description" => "The cybersecurity requirements for identity and access management must include at least the following : User authorization based on identity and access control principles: Need-to-Know and Need-to-Use, Least Privilege and Segregation of Duties.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-2-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-2-3-4",
                            "long_name" => "ECC 2-2-3-4",
                            "description" => "The cybersecurity requirements for identity and access management must include at least the following : Privileged access management.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-2-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-2-3-5",
                            "long_name" => "ECC 2-2-3-5",
                            "description" => "The cybersecurity requirements for identity and access management must include at least the following : Periodic review of users' identities and access rights.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-2-3-5",
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
                    "short_name" => "ECC 2-2-4",
                    "long_name" => "ECC 2-2-4",
                    "description" => "The Implementation of the cybersecurity requirements for identity and access management must be reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-2-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ECC 2-3-1",
                    "long_name" => "ECC 2-3-1",
                    "description" => "Cybersecurity requirements for protecting information systems and information
processing facilities must be defined, documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-3-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
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
                    "description" => "The cybersecurity requirements for protecting information systems and information
processing facilities must be implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-3-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-3-3",
                    "long_name" => "ECC 2-3-3",
                    "description" => "The cybersecurity requirements for protecting information systems and information
processing facilities must include at least the following:.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-3-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-3-3-1",
                            "long_name" => "ECC 2-3-3-1",
                            "description" => "The cybersecurity requirements for protecting information systems and information processing facilities must include at least the following: Advanced, up-to-date and secure management of malware and virus
protection on servers and workstations.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-3-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
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
                            "description" => "The cybersecurity requirements for protecting information systems and information processing facilities must include at least the following: Restricted use and secure handling of external storage media.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-3-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [

                            "short_name" => "ECC 2-3-3-3",
                            "long_name" => "ECC 2-3-3-3",
                            "description" => "The cybersecurity requirements for protecting information systems and information processing facilities must include at least the following: Patch management for information systems, software and devices.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-3-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
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
                            "description" => "The cybersecurity requirements for protecting information systems and information processing facilities must include at least the following: Centralized clock synchronization with an accurate and trusted source (e.g.,
Saudi Standard controls, Metrology and Quality Organization (SASO)).",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-3-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
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
                    "description" => "The cybersecurity requirements for protecting information systems and information
processing facilities must be reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-3-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-4-1",
                    "long_name" => "ECC 2-4-1",
                    "description" => "Cybersecurity requirements for protecting email service must be defined, documented
and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-4-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Email Protection'),
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
                    "description" => "The cybersecurity requirements for email service must be implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-4-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Email Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-4-3",
                    "long_name" => "ECC 2-4-3",
                    "description" => "The cybersecurity requirements for protecting the email service must include at the
least the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-4-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Email Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-4-3-1",
                            "long_name" => "ECC 2-4-3-1",
                            "description" => "The cybersecurity requirements for protecting the email service must include at the least the following: Analyzing and filtering email messages (specifically phishing emails and
spam) using advanced and up-to-date email protection techniques.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-4-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Email Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-4-3-2",
                            "long_name" => "ECC 2-4-3-2",
                            "description" => "Multi-factor authentication must be implemented, including the identification of appropriate authentication factors, their quantity, and suitable authentication technologies, based on the results of an assessment of the potential impact of authentication failure or bypass. This applies to remote access and access through the webmail interface.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-4-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Email Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-4-3-3",
                            "long_name" => "ECC 2-4-3-3",
                            "description" => "The cybersecurity requirements for protecting the email service must include at the least the following: 
 Email archiving and backup.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-4-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Email Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-4-3-4",
                            "long_name" => "ECC 2-4-3-4",
                            "description" => "The cybersecurity requirements for protecting the email service must include at the least the following: Secure management and protection against Advanced Persistent Threats
(APT), which normally utilize zero-day viruses and malware.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-4-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Email Protection'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-4-3-5",
                            "long_name" => "ECC 2-4-3-5",
                            "description" => "Document the organization’s email domain using Sender Policy Framework (SPF), DomainKeys Identified Mail (DKIM), and Domain-based Message Authentication, Reporting, and Conformance (DMARC).",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-4-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Email Protection'),
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
                    "description" => "The cybersecurity requirements for email service must be reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-4-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Email Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-5-1",
                    "long_name" => "ECC 2-5-1",
                    "description" => "Cybersecurity requirements for network security management must be defined,
documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-5-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Networks Security Management'),
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
                        ],
                        [
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
                    "description" => "Cybersecurity requirements for network security management must be defined,
documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-5-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Networks Security Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-5-3",
                    "long_name" => "ECC 2-5-3",
                    "description" => "The cybersecurity requirements for network security management must be
implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-5-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Networks Security Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-5-3-1",
                            "long_name" => "ECC 2-5-3-1",
                            "description" => "The cybersecurity requirements for network security management must include at least the following: Logical or physical segregation and segmentation of network segments using
firewalls and defense-in-depth principles.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
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
                            "description" => "The cybersecurity requirements for network security management must include at least the following: Network segregation between production, test and development
environments.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-5-3-3",
                            "long_name" => "ECC 2-5-3-3",
                            "description" => "The cybersecurity requirements for network security management must include at least the following: Secure browsing and Internet connectivity including restrictions on the use
of file storage/sharing and remote access websites, and protection against
suspicious websites.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-5-3-4",
                            "long_name" => "ECC 2-5-3-4",
                            "description" => "The cybersecurity requirements for network security management must include at least the following: Wireless network protection using strong authentication and encryption
techniques. A comprehensive risk assessment and management exercise must
be conducted to assess and manage the cyber risks prior to connecting any wireless networks to the organization's internal network.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-5-3-5",
                            "long_name" => "ECC 2-5-3-5",
                            "description" => "The cybersecurity requirements for network security management must include at least the following: Management and restrictions on network services, protocols and ports.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
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
                            "description" => "The cybersecurity requirements for network security management must include at least the following: Intrusion Prevention Systems (IPS).",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-5-3-7",
                            "long_name" => "ECC 2-5-3-7",
                            "description" => "The cybersecurity requirements for network security management must include at least the following: 
 Security of Domain Name Service (DNS).",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-5-3-8",
                            "long_name" => "ECC 2-5-3-8",
                            "description" => "The cybersecurity requirements for network security management must include at least the following: 
                            Secure management and protection of Internet browsing channel against
                            Advanced Persistent Threats (APT), which normally utilize zero-day viruses
                            and malware.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Networks Security Management'),
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
                            "short_name" => "ECC 2-5-3-9",
                            "long_name" => "ECC 2-5-3-9",
                            "description" => "",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-5-3-9",
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
                    "short_name" => "ECC 2-5-4",
                    "long_name" => "ECC 2-5-4",
                    "description" => "The cybersecurity requirements for network security management must be reviewed
periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-5-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Networks Security Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-6-1",
                    "long_name" => "ECC 2-6-1",
                    "description" => "Cybersecurity requirements for mobile devices security and BYOD must be defined,
documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-6-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Mobile Devices Security'),
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
                    "description" => "The cybersecurity requirements for mobile devices security and BYOD must be
implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-6-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-6-3",
                    "long_name" => "ECC 2-6-3",
                    "description" => "The cybersecurity requirements for mobile devices security and BYOD must include at
least the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-6-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-6-3-1",
                            "long_name" => "ECC 2-6-3-1",
                            "description" => "The cybersecurity requirements for mobile devices security and BYOD must include at least the following: Separation and encryption of organization's data and information stored on
mobile devices and BYODs",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-6-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-6-3-2",
                            "long_name" => "ECC 2-6-3-2",
                            "description" => "The cybersecurity requirements for mobile devices security and BYOD must include at least the following: Controlled and restricted use based on job requirements.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-6-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-6-3-3",
                            "long_name" => "ECC 2-6-3-3",
                            "description" => "The cybersecurity requirements for mobile devices security and BYOD must include at least the following: Secure wiping of organization's data and information stored on mobile devices and BYOD in cases of device loss, theft or after
termination/separation from the organization.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-6-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-6-3-4",
                            "long_name" => "ECC 2-6-3-4",
                            "description" => "The cybersecurity requirements for mobile devices security and BYOD must include at least the following: Security awareness for mobile devices users.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-6-3-4",
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
                    "short_name" => "ECC 2-6-4",
                    "long_name" => "ECC 2-6-4",
                    "description" => "The cybersecurity requirements for mobile devices security and BYOD must be
reviewed periodically.",
                    "supplemental_guidance" => null,
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-6-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-7-1",
                    "long_name" => "ECC 2-7-1",
                    "description" => "Cybersecurity requirements for protecting and handling data and information must be
defined, documented and approved as per the related laws and regulations.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-7-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-7-2",
                    "long_name" => "ECC 2-7-2",
                    "description" => "The cybersecurity requirements for protecting and handling data and information must
be implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-7-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-7-3",
                    "long_name" => "ECC 2-7-3",
                    "description" => "The cybersecurity requirements for protecting and handling data and information must
include at least the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-7-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "ECC 2-7-4",
                    "long_name" => "ECC 2-7-4",
                    "description" => "The cybersecurity requirements for protecting and handling data and information must
be reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-7-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-8-1",
                    "long_name" => "ECC 2-8-1",
                    "description" => "Cybersecurity requirements for cryptography must be defined, documented and
approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-8-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cryptography'),
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
                    "description" => "The cybersecurity requirements for cryptography must be implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-8-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cryptography'),
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
                    "description" => "The cybersecurity requirements for cryptography must include at least the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-8-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cryptography'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [

                        [
                            "short_name" => "ECC 2-8-3-1",
                            "long_name" => "ECC 2-8-3-1",
                            "description" => "The cybersecurity requirements for cryptography must include at least the following: Approved cryptographic solutions standard controls and its technical and
regulatory limitations.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-8-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cryptography'),
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
                            "description" => "The cybersecurity requirements for cryptography must include at least the following: Secure management of cryptographic keys during their lifecycles.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-8-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cryptography'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-8-3-3",
                            "long_name" => "ECC 2-8-3-3",
                            "description" => "The cybersecurity requirements for cryptography must include at least the following:
 Encryption of data in-transit and at-rest as per classification and related laws
and regulations.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-8-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cryptography'),
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
                    "description" => "The cybersecurity requirements for cryptography must be reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-8-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cryptography'),
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
                    "description" => "Cybersecurity requirements for backup and recovery management must be defined,
documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-9-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-9-2",
                    "long_name" => "ECC 2-9-2",
                    "description" => "The cybersecurity requirements for backup and recovery management must be
implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-9-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-9-3",
                    "long_name" => "ECC 2-9-3",
                    "description" => "The cybersecurity requirements for backup and recovery management must include
at least the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-9-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-9-3-1",
                            "long_name" => "ECC 2-9-3-1",
                            "description" => "The cybersecurity requirements for backup and recovery management must include at least the following: Scope and coverage of backups to cover critical technology and information
assets.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-9-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-9-3-2",
                            "long_name" => "ECC 2-9-3-2",
                            "description" => "The cybersecurity requirements for backup and recovery management must include at least the following:  Ability to perform quick recovery of data and systems after cybersecurity
incidents.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-9-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-9-3-3",
                            "long_name" => "ECC 2-9-3-3",
                            "description" => "The cybersecurity requirements for backup and recovery management must include at least the following: Periodic tests of backup's recovery effectiveness.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-9-3-3",
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
                    "short_name" => "ECC 2-9-4",
                    "long_name" => "ECC 2-9-4",
                    "description" => "The cybersecurity requirements for backup and recovery management must be
reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-9-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-10-1",
                    "long_name" => "ECC 2-10-1",
                    "description" => "Cybersecurity requirements for technical vulnerabilities management must be defined,
documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-10-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
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
                    "description" => "The cybersecurity requirements for technical vulnerabilities management must be
implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-10-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-10-3",
                    "long_name" => "ECC 2-10-3",
                    "description" => "The cybersecurity requirements for technical vulnerabilities management must
include at least the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-10-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-10-3-1",
                            "long_name" => "ECC 2-10-3-1",
                            "description" => "The cybersecurity requirements for technical vulnerabilities management must include at least the following: Periodic vulnerabilities assessments.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-10-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
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
                            "description" => "The cybersecurity requirements for technical vulnerabilities management must include at least the following: Vulnerabilities classification based on criticality level.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-10-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
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
                            "description" => "The cybersecurity requirements for technical vulnerabilities management must include at least the following: Vulnerabilities remediation based on classification and associated risk
levels.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-10-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-10-3-4",
                            "long_name" => "ECC 2-10-3-4",
                            "description" => "The cybersecurity requirements for technical vulnerabilities management must include at least the following: Security patch management.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-10-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-10-3-5",
                            "long_name" => "ECC 2-10-3-5",
                            "description" => "The cybersecurity requirements for technical vulnerabilities management must include at least the following: Subscription with authorized and trusted cybersecurity resources for upto-date information and notifications on technical vulnerabilities.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-10-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
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
                    "description" => "The cybersecurity requirements for technical vulnerabilities management must be
reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-10-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-11-1",
                    "long_name" => "ECC 2-11-1",
                    "description" => "Cybersecurity requirements for penetration testing exercises must be defined,
documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-11-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Penetration Testing'),
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
                    "description" => "The cybersecurity requirements for penetration testing processes must be
implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-11-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Penetration Testing'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-11-3",
                    "long_name" => "ECC 2-11-3",
                    "description" => "The cybersecurity requirements for penetration testing processes must include at least
the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-11-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Penetration Testing'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-11-3-1",
                            "long_name" => "ECC 2-11-3-1",
                            "description" => "The cybersecurity requirements for penetration testing processes must include at least the following: Scope of penetration tests which must cover Internet-facing services and
its technical components including infrastructure, websites, web
applications, mobile apps, email and remote access.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-11-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Penetration Testing'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-11-3-2",
                            "long_name" => "ECC 2-11-3-2",
                            "description" => "The cybersecurity requirements for penetration testing processes must include at least the following: Conducting penetration tests periodically.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-11-3-2",
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
                    "short_name" => "ECC 2-11-4",
                    "long_name" => "ECC 2-11-4",
                    "description" => "Cybersecurity requirements for penetration testing processes must be reviewed
periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-11-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Penetration Testing'),
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
                    "description" => "Cybersecurity requirements for event logs and monitoring management must be
defined, documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-12-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
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
                    "description" => "The cybersecurity requirements for event logs and monitoring management must be
implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-12-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-12-3",
                    "long_name" => "ECC 2-12-3",
                    "description" => "The cybersecurity requirements for event logs and monitoring management must
include at least the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-12-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-12-3-1",
                            "long_name" => "ECC 2-12-3-1",
                            "description" => "The cybersecurity requirements for event logs and monitoring management must include at least the following: Activation of cybersecurity event logs on critical information assets.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-12-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [

                            "short_name" => "ECC 2-12-3-2",
                            "long_name" => "ECC 2-12-3-2",
                            "description" => "The cybersecurity requirements for event logs and monitoring management must include at least the following: Activation of cybersecurity event logs on remote access and privileged user
accounts.",
                            "supplemental_guidance" => null,
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-12-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [

                            "short_name" => "ECC 2-12-3-3",
                            "long_name" => "ECC 2-12-3-3",
                            "description" => "The cybersecurity requirements for event logs and monitoring management must include at least the following: Identification of required technologies (e.g., SIEM) for cybersecurity event
logs collection.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-12-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [

                            "short_name" => "ECC 2-12-3-4",
                            "long_name" => "ECC 2-12-3-4",
                            "description" => "The cybersecurity requirements for event logs and monitoring management must
include at least the following:
 Continuous monitoring of cybersecurity events.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-12-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [

                            "short_name" => "ECC 2-12-3-5",
                            "long_name" => "ECC 2-12-3-5",
                            "description" => "The cybersecurity requirements for event logs and monitoring management must include at least the following: Retention period for cybersecurity event logs (must be 12 months
minimum).",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-12-3-5",
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
                    "short_name" => "ECC 2-12-4",
                    "long_name" => "ECC 2-12-4",
                    "description" => "The cybersecurity requirements for event logs and monitoring management must be
reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-12-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
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
                    "description" => "Requirements for cybersecurity incidents and threat management must be defined,
documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-13-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
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
                    "description" => "The requirements for cybersecurity incidents and threat management must be
implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-13-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-13-3",
                    "long_name" => "ECC 2-13-3",
                    "description" => "The requirements for cybersecurity incidents and threat management must include at
least the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-13-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-13-3-1",
                            "long_name" => "ECC 2-13-3-1",
                            "description" => "The requirements for cybersecurity incidents and threat management must include at least the following: Cybersecurity incident response plans and escalation procedures.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-13-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
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
                            "description" => "The requirements for cybersecurity incidents and threat management must include at least the following: Cybersecurity incidents classification.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-13-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
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
                            "description" => "The requirements for cybersecurity incidents and threat management must include at least the following: Cybersecurity incidents reporting to NCA.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-13-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
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
                            "description" => "The requirements for cybersecurity incidents and threat management must include at least the following: Sharing incidents notifications, threat intelligence, breach indicators and
reports with NCA.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-13-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
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
                            "description" => "The requirements for cybersecurity incidents and threat management must include at
least the following:
 Collecting and handling threat intelligence feeds.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-13-3-5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
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
                    "description" => "The requirements for cybersecurity incidents and threat management must be
reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-13-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-14-1",
                    "long_name" => "ECC 2-14-1",
                    "description" => "Cybersecurity requirements for physical protection of information and technology
assets must be defined, documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-14-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical Security'),
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
                    "description" => "The cybersecurity requirements for physical protection of information and technology
assets must be implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-14-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-14-3",
                    "long_name" => "ECC 2-14-3",
                    "description" => "The cybersecurity requirements for physical protection of information and technology
assets must include at least the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-14-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-14-3-1",
                            "long_name" => "ECC 2-14-3-1",
                            "description" => "The cybersecurity requirements for physical protection of information and technology assets must include at least the following: Authorized access to sensitive areas within the organization (e.g., data
center, disaster recovery center, sensitive information processing facilities,
security surveillance center, network cabinets).",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-14-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-14-3-2",
                            "long_name" => "ECC 2-14-3-2",
                            "description" => "The cybersecurity requirements for physical protection of information and technology assets must include at least the following: Facility entry/exit records and CCTV monitoring.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-14-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-14-3-3",
                            "long_name" => "ECC 2-14-3-3",
                            "description" => "The cybersecurity requirements for physical protection of information and technology assets must include at least the following: Protection of facility entry/exit and surveillance records.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-14-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-14-3-4",
                            "long_name" => "ECC 2-14-3-4",
                            "description" => "The cybersecurity requirements for physical protection of information and technology assets must include at least the following:  Secure destruction and re-use of physical assets that hold classified
information (including documents and storage media).",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-14-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-14-3-5",
                            "long_name" => "ECC 2-14-3-5",
                            "description" => "The cybersecurity requirements for physical protection of information and technology assets must include at least the following: Security of devices and equipment inside the organization's facilities.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-14-3-5",
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
                    "short_name" => "ECC 2-14-4",
                    "long_name" => "ECC 2-14-4",
                    "description" => "The cybersecurity requirements for physical protection of information and technology
assets must be reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-14-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-15-1",
                    "long_name" => "ECC 2-15-1",
                    "description" => "Cybersecurity requirements for external web applications must be defined,
documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-15-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Web Application Security'),
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
                    "description" => "The cybersecurity requirements for external web applications must be implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-15-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Web Application Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 2-15-3",
                    "long_name" => "ECC 2-15-3",
                    "description" => "The cybersecurity requirements for external web applications must include at least the
following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-15-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Web Application Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 2-15-3-1",
                            "long_name" => "ECC 2-15-3-1",
                            "description" => "The cybersecurity requirements for external web applications must include at least the following: Use of web application firewall.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-15-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Web Application Security'),
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
                            "description" => "The cybersecurity requirements for external web applications must include at least the following: Adoption of the multi-tier architecture principle.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-15-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Web Application Security'),
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
                            "description" => "The cybersecurity requirements for external web applications must include at least the following:  Use of secure protocols (e.g., HTTPS).",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-15-3-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Web Application Security'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 2-15-3-4",
                            "long_name" => "ECC 2-15-3-4",
                            "description" => "The cybersecurity requirements for external web applications must include at least the following: Clarification of the secure usage policy for users.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-15-3-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Web Application Security'),
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
                            "description" => "The cybersecurity requirements for external web applications must include at least the following: Multi-factor authentication for users' access.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 2-15-3-5",
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
                    "short_name" => "ECC 2-15-4",
                    "long_name" => "ECC 2-15-4",
                    "description" => "The cybersecurity requirements for external web applications must be reviewed
periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 2-15-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Web Application Security'),
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
                    "description" => "Cybersecurity requirements for business continuity management must be defined,
documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 3-1-1",
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
                    ]
                ],
                [
                    "short_name" => "ECC 3-1-2",
                    "long_name" => "ECC 3-1-2",
                    "description" => "The cybersecurity requirements for business continuity management must be
implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 3-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 3-1-3",
                    "long_name" => "ECC 3-1-3",
                    "description" => "The cybersecurity requirements for business continuity management must include
at least the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 3-1-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 3-1-3-1",
                            "long_name" => "ECC 3-1-3-1",
                            "description" => "The cybersecurity requirements for business continuity management must include at least the following: Ensuring the continuity of cybersecurity systems and procedures.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 3-1-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 3-1-3-2",
                            "long_name" => "ECC 3-1-3-2",
                            "description" => "The cybersecurity requirements for business continuity management must include at least the following: Developing response plans for cybersecurity incidents that may affect the
business continuity.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 3-1-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 3-1-3-3",
                            "long_name" => "ECC 3-1-3-3",
                            "description" => "The cybersecurity requirements for business continuity management must include at least the following: Developing disaster recovery plans.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 3-1-3-3",
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
                    "short_name" => "ECC 3-1-4",
                    "long_name" => "ECC 3-1-4",
                    "description" => "The cybersecurity requirements for business continuity management must be
reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 3-1-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 4-1-1",
                    "long_name" => "ECC 4-1-1",
                    "description" => "Cybersecurity requirements for contracts and agreements with third-parties must be
identified, documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
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
                    "description" => "The cybersecurity requirements for contracts and agreements with third-parties (e.g.,
Service Level Agreement (SLA)) -which may affect, if impacted, the organization's data 
or services- must include at least the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 4-1-2-1",
                            "long_name" => "ECC 4-1-2-1",
                            "description" => "The cybersecurity requirements for contracts and agreements with third-parties (e.g., Service Level Agreement (SLA)) -which may affect, if impacted, the organization's data or services- must include at least the following: Non-disclosure clauses and secure removal of organization's data by third 
parties upon end of service.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 4-1-2-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 4-1-2-2",
                            "long_name" => "ECC 4-1-2-2",
                            "description" => "The cybersecurity requirements for contracts and agreements with third-parties (e.g., Service Level Agreement (SLA)) -which may affect, if impacted, the organization's data or services- must include at least the following: Communication procedures in case of cybersecurity incidents.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 4-1-2-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 4-1-2-3",
                            "long_name" => "ECC 4-1-2-3",
                            "description" => "The cybersecurity requirements for contracts and agreements with third-parties (e.g., Service Level Agreement (SLA)) -which may affect, if impacted, the organization's data or services- must include at least the following: Requirements for third-parties to comply with related organizational policies
and procedures, laws and regulations.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 4-1-2-3",
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
                    "short_name" => "ECC 4-1-3",
                    "long_name" => "ECC 4-1-3",
                    "description" => "The cybersecurity requirements for contracts and agreements with IT outsourcing and
managed services third-parties must include at least the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-1-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 4-1-3-1",
                            "long_name" => "ECC 4-1-3-1",
                            "description" => "The cybersecurity requirements for contracts and agreements with IT outsourcing and managed services third-parties must include at least the following: Conducting a cybersecurity risk assessment to ensure the availability of risk
mitigation controls before signing contracts and agreements or upon changes
in related regulatory requirements.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 4-1-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "ECC 4-1-3-2",
                            "long_name" => "ECC 4-1-3-2",
                            "description" => "The cybersecurity requirements for contracts and agreements with IT outsourcing and managed services third-parties must include at least the following: Cybersecurity managed services centers for monitoring and operations must
be completely present inside the Kingdom of Saudi Arabia.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 4-1-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
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
                    "description" => "The cybersecurity requirements for contracts and agreements with third-parties must
be reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-1-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 4-2-1",
                    "long_name" => "ECC 4-2-1",
                    "description" => "Cybersecurity requirements related to the use of hosting and cloud computing services
must be defined, documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cloud Computing and hosting Cybersecurity'),
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
                    "description" => "The cybersecurity requirements related to the use of hosting and cloud computing
services must be implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-2-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cloud Computing and hosting Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "ECC 4-2-3",
                    "long_name" => "ECC 4-2-3",
                    "description" => "In line with related and applicable laws and regulations, and in addition to the
applicable ECC controls from main domains (1), (2), (3) and subdomain (4-1), the
cybersecurity requirements related to the use of hosting and cloud computing services
must include at least the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-2-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cloud Computing and hosting Cybersecurity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "ECC 4-2-3-1",
                            "long_name" => "ECC 4-2-3-1",
                            "description" => "In line with related and applicable laws and regulations, and in addition to the applicable ECC controls from main domains (1), (2), (3) and subdomain (4-1), the cybersecurity requirements related to the use of hosting and cloud computing services must include at least the following: Classification of data prior to hosting on cloud or hosting services and
returning data (in a usable format) upon service completion.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 4-2-3-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cloud Computing and hosting Cybersecurity'),
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
                            "description" => "In line with related and applicable laws and regulations, and in addition to the applicable ECC controls from main domains (1), (2), (3) and subdomain (4-1), the cybersecurity requirements related to the use of hosting and cloud computing services must include at least the following: Separation of organization's environments ( specifically virtual servers ) from other environments hosted at the cloud service provider.",
                            "supplemental_guidance" => null,
                            "control_number" => "ECC 4-2-3-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cloud Computing and hosting Cybersecurity'),
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
                        ]
                    ]
                ],

                [
                    "short_name" => "ECC 4-2-4",
                    "long_name" => "ECC 4-2-4",
                    "description" => "The cybersecurity requirements related to the use of hosting and cloud computing
services must be reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "ECC 4-2-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cloud Computing and hosting Cybersecurity'),
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

        $requirementData = $dataToInsert['requirement'] ?? []; // Store requirement data separately
        unset($dataToInsert['requirement']);

        // Ensure that 'parent_id' is set correctly
        $dataToInsert['parent_id'] = $parentId;

        $dataToInsert['description'] = ['en' => $controlData['description'], 'ar' => $controlData['description']];
        // Create the FrameworkControl record
        $control = FrameworkControl::create($dataToInsert);

        if (!empty($requirementData) && in_array('install_requirement', $this->options)) {
            foreach ($requirementData as $reqData) {
                // First try to find existing objective
                $objective = ControlObjective::where('name', $reqData['name'])->first();

                if ($objective) {
                    // Update existing objective - handle comma-separated values
                    $frameworkIds = $objective->framework_id ? explode(',', $objective->framework_id) : [];
                    if (!in_array($reqData['framework_id'], $frameworkIds)) {
                        $frameworkIds[] = $reqData['framework_id'];
                    }

                    $controlIds = $objective->control_id ? explode(',', $objective->control_id) : [];
                    if (!in_array($control->id, $controlIds)) {
                        $controlIds[] = $control->id;
                    }

                    $objective->update([
                        'description' => $reqData['description'],
                        'framework_id' => implode(',', $frameworkIds),
                        'control_id' => implode(',', $controlIds)
                    ]);
                } else {
                    // Create new objective with single IDs (no need to implode)
                    $objective = ControlObjective::create([
                        'name' => $reqData['name'],
                        'description' => $reqData['description'],
                        'framework_id' => $reqData['framework_id'], // Single ID
                        'control_id' => $control->id // Single ID
                    ]);
                }

                // Then create the pivot record
                ControlControlObjective::updateOrCreate(
                    [
                        'control_id' => $control->id,
                        'objective_id' => $objective->id
                    ],
                    [
                        'responsible_type' => $reqData['responsible_type'],
                        'responsible_id' => $reqData['responsible_id'],
                        'due_date' => $reqData['due_date']
                    ]
                );
            }
        }

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
