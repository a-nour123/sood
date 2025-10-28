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

class NCACCCTSeeder extends Seeder
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
                'name' => 'NCA-CCC-T – 2: 2024',
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
                    "short_name" => "CCC 1-1-T-1",
                    "long_name" => "CCC 1-1-T-1",
                    "description" => "In addition to the ECC control 1-4-1, the Authorizing Official shall also identify, document and approve:",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 1-1-T-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Role and Responsibilities'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                            [
                                "short_name" => "CCC 1-1-T-1-1",
                                "long_name" => "CCC 1-1-T-1-1",
                                "description" => "In addition to the ECC control 1-4-1, the Authorizing Official shall also identify, document and approve:
                                    Cybersecurity roles and RACI assignment for all stakeholders of the cloud
                                    services including Authorizing Official’s roles and responsibilities.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 1-1-T-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Role and Responsibilities'), // Dynamically get family ID
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ]

                    ],

                ],
                [

                    "short_name" => "CCC 1-2-T-1",
                    "long_name" => "CCC 1-2-T-1",
                    "description" => "Cybersecurity risk management methodology mentioned in the ECC Subdomain 1-5, shall
also include for the CST, as a minimum:",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 1-2-T-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "CCC 1-2-T-1-1",
                            "long_name" => "CCC 1-2-T-1-1",
                            "description" => " Cybersecurity risk management methodology mentioned in the ECC Subdomain 1-5, shall
also include for the CST, as a minimum:
Defining acceptable risk levels for the cloud services",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC 1-2-T-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],     
                        [

                            "short_name" => "CCC 1-2-T-1-2",
                            "long_name" => "CCC 1-2-T-1-2",
                            "description" => "Cybersecurity risk management methodology mentioned in the ECC Subdomain 1-5 shall
also include for the CST, as a minimum: Considering data and information classification accredited by CST in
cybersecurity risk management methodology.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC 1-2-T-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                             [

                            "short_name" => "CCC 1-2-T-1-3",
                            "long_name" => "CCC 1-2-T-1-3",
                            "description" => "Cybersecurity risk management methodology mentioned in the ECC Subdomain 1-5 shall
also include for the CST, as a minimum: Developing cybersecurity risk register for cloud services, and monitoring it
periodically according to the risks.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC 1-2-T-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ],

                ],

                [

                    "short_name" => "CCC 1-3-T-1",
                    "long_name" => "CCC 1-3-T-1",
                    "description" => "In addition to the ECC control 1-7-1, the CST legislative and regulatory compliance should
include as a minimum with the following requirements:",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 1-3-T-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Regulatory Compliance'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "CCC 1-3-T-1-1",
                            "long_name" => "CCC 1-3-T-1-1",
                            "description" => "In addition to the ECC control 1-7-1, the CST legislative and regulatory compliance should
include as a minimum with the following requirements:
 Continuous or real-time compliance monitoring of the CSP with relevant
cybersecurity legislation and contract clauses.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC 1-3-T-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Regulatory Compliance'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                      
                    ],

                ],

                [

                    "short_name" => "CCC 1-4-T-1",
                    "long_name" => "CCC 1-4-T-1",
                    "description" => "In addition to subcontrols in the ECC control 1-9-3, the following requirements should be
covered prior the professional relationship of staff with the CST shall cover, at a minimum:",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 1-4-T-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "CCC 1-4-T-1-1",
                            "long_name" => "CCC 1-4-T-1-1",
                            "description" => "In addition to subcontrols in the ECC control 1-9-3, the following requirements should be
covered prior the professional relationship of staff with the CST shall cover, at a minimum:
 Screening or vetting candidates of personnel with access to Cloud Service
sensitive functions (Key Management, Service Administration, Access
Control).",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC 1-4-T-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        
                    ],

                ],

                [
                    "short_name" => "CCC 2-1-T-1",
                    "long_name" => "CCC 2-1-T-1",
                    "description" => "In addition to controls in the ECC control 2-1, the CST shall cover the following additional
controls for cybersecurity requirements for cybersecurity event logs and monitoring management, as a minimum:",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-1-T-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "CCC 2-1-T-1-1",
                            "long_name" => "CCC 2-1-T-1-1",
                            "description" => "In addition to controls in the ECC control 2-1, the CST shall cover the following additional
controls for cybersecurity requirements for cybersecurity event logs and monitoring management, as a minimum:
 Inventory of all cloud services and information and technology assets related to the cloud services.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC 2-1-T-1-1",
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
                    "short_name" => "CCC 2-2-T-1",
                    "long_name" => "CCC 2-2-T-1",
                    "description" => "In addition to subcontrols in the ECC control 2-2-3, the CST shall cover the following
additional subcontrols for cybersecurity requirements for identity and access management
requirements, as a minimum:",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-2-T-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "CCC 2-2-T-1-1",
                            "long_name" => "CCC 2-2-T-1-1",
                            "description" => "In addition to subcontrols in the ECC control 2-2-3, the CST shall cover the following
additional subcontrols for cybersecurity requirements for identity and access management
requirements, as a minimum:
 Identity and access management for all cloud credentials along their full
lifecycle.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC 2-2-T-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC 2-2-T-1-2",
                            "long_name" => "CCC 2-2-T-1-2",
                            "description" => "In addition to subcontrols in the ECC control 2-2-3, the CST shall cover the following additional subcontrols for cybersecurity requirements for identity and access management requirements, as a minimum: Confidentiality of cloud user identification, cloud credential and cloud
access rights information, including the requirement on users to keep them
private (for employed, third party and CST personnel).",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC 2-2-T-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC 2-2-T-1-3",
                            "long_name" => "CCC 2-2-T-1-3",
                            "description" => "In addition to subcontrols in the ECC control 2-2-3, the CST shall cover the following additional subcontrols for cybersecurity requirements for identity and access management requirements, as a minimum: Secure session management, including session authenticity, session lockout,
and session timeout termination on the cloud.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC 2-2-T-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC 2-2-T-1-4",
                            "long_name" => "CCC 2-2-T-1-4",
                            "description" => "In addition to subcontrols in the ECC control 2-2-3, the CST shall cover the following additional subcontrols for cybersecurity requirements for identity and access management requirements, as a minimum: Multi-factor authentication for privileged cloud users.",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC 2-2-T-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity and Access Management'),
                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [
                            "short_name" => "CCC 2-2-T-1-5",
                            "long_name" => "CCC 2-2-T-1-5",
                            "description" => "In addition to subcontrols in the ECC control 2-2-3, the CST shall cover the following
additional subcontrols for cybersecurity requirements for identity and access management
requirements, as a minimum: Formal process to detect and prevent unauthorized access to cloud (such as
a threshold of unsuccessful login attempts).",
                            "supplemental_guidance" => null,
                            "control_number" => "CCC 2-2-T-1-5",
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
                    "short_name" => "CCC 2-3-T-1",
                    "long_name" => "CCC 2-3-T-1",
                    "description" => "In addition to subcontrols in the ECC control 2-3-3, the CST shall cover the following additional subcontrols for cybersecurity requirements for information system and processing
facilities protection requirements, as a minimum:",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-3-T-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                    "short_name" => "CCC 2-3-T-1-1",
                    "long_name" => "CCC 2-3-T-1-1",
                    "description" => "In addition to subcontrols in the ECC control 2-3-3, the CST shall cover the following additional subcontrols for cybersecurity requirements for information system and processing
facilities protection requirements, as a minimum:
Verifying that the CSP isolates the community cloud services provided to
CSTs (government organizations and CNI organizations) from any other
cloud computing provided to organizations outside the scope of work.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-3-T-1-1",
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
                    "short_name" => "CCC 2-4-T-1",
                    "long_name" => "CCC 2-4-T-1",
                    "description" => "In addition to subcontrols in the ECC control 2-5-3, the CST shall cover the following
additional subcontrols for cybersecurity requirements for networks security management
requirements, as a minimum:",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-4-T-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Networks Security Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                    "short_name" => "CCC 2-4-T-1-1",
                    "long_name" => "CCC 2-4-T-1-1",
                    "description" => "In addition to subcontrols in the ECC control 2-5-3, the CST shall cover the following
additional subcontrols for cybersecurity requirements for networks security management
requirements, as a minimum:
 Protecting the connection channel with CSP",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-4-T-1-1",
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
                    "short_name" => "CCC 2-5-T-1",
                    "long_name" => "CCC 2-5-T-1",
                    "description" => "In addition to subcontrols in the ECC control 2-6-3, the CST shall cover the following
additional subcontrols for cybersecurity requirements for mobile device security, as a minimum:",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-5-T-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                    "short_name" => "CCC 2-5-T-1-1",
                    "long_name" => "CCC 2-5-T-1-1",
                    "description" => "In addition to subcontrols in the ECC control 2-6-3, the CST shall cover the following
additional subcontrols for cybersecurity requirements for mobile device security, as a minimum:
 Data sanitation and secure disposal for end-user devices with access to the
cloud services",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-5-T-1-1",
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
                    "short_name" => "CCC 2-6-T-1",
                    "long_name" => "CCC 2-6-T-1",
                    "description" => "In addition to subcontrols in the ECC control 2-7-3, the CST shall cover the following
additional subcontrols for cybersecurity requirements for protecting CST’s data and information in cloud computing , as a minimum:",
                    "supplemental_guidance" => null,
                    "control_number" =>"CCC 2-6-T-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                            "short_name" => "CCC 2-6-T-1-1",
                    "long_name" => "CCC 2-6-T-1-1",
                    "description" => "In addition to subcontrols in the ECC control 2-7-3, the CST shall cover the following
additional subcontrols for cybersecurity requirements for protecting CST’s data and information in cloud computing , as a minimum: Exit Strategy to ensure means for secure disposal of data on termination or
expiry of the contract with the CSP.",
                    "supplemental_guidance" => null,
                    "control_number" =>"CCC 2-6-T-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data and Information Protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                        ],
                        [
                            "short_name" => "CCC 2-6-T-1-2",
                    "long_name" => "CCC 2-6-T-1-2",
                    "description" => "In addition to subcontrols in the ECC control 2-7-3, the CST shall cover the following additional subcontrols for cybersecurity requirements for protecting CST’s data and information in cloud computing , as a minimum: Using secure means to export and transfer data and virtual infrastructure.",
                    "supplemental_guidance" => null,
                    "control_number" =>"CCC 2-6-T-1-2",
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
                    "short_name" => "CCC 2-7-T-1",
                    "long_name" => "CCC 2-7-T-1",
                    "description" => "In addition to subcontrols in the ECC control 2-8-3, the CST shall cover the following additional subcontrols for cryptography, as a minimum:",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-7-T-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cryptography'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    'children' => [
                        [
                    "short_name" => "CCC 2-7-T-1-1",
                    "long_name" => "CCC 2-7-T-1-1",
                    "description" => "In addition to subcontrols in the ECC control 2-8-3, the CST shall cover the following additional subcontrols for cryptography, as a minimum:
 Technical mechanisms and cryptographic primitives for strong encryption,
in according to the advanced level in the National Cryptographic Standards
(NCS-1:2020).",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-7-T-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cryptography'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                        ],
                    [
                    "short_name" => "CCC 2-7-T-1-2",
                    "long_name" => "CCC 2-7-T-1-2",
                    "description" => "In addition to subcontrols in the ECC control 2-8-3, the CST shall cover the following additional subcontrols for cryptography, as a minimum: Encryption of data and information transferred to or transferred out of the
cloud according to the relevant law and regulatory requirements.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-7-T-1-2",
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
                    "short_name" => "CCC 2-9-T-1",
                    "long_name" => "CCC 2-9-T-1",
                    "description" => "In addition to subcontrols in the ECC control 2-10-3, the CST shall cover the following
additional subcontrols for cybersecurity requirements for vulnerability management requirements, as a minimum:",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-9-T-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                      "short_name" => "CCC 2-9-T-1-1",
                    "long_name" => "CCC 2-9-T-1-1",
                    "description" => "In addition to subcontrols in the ECC control 2-10-3, the CST shall cover the following
additional subcontrols for cybersecurity requirements for vulnerability management requirements, as a minimum:
Assessing and remediating vulnerabilities cloud services and at least once
every three months.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-9-T-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                        ],
                    [
                      "short_name" => "CCC 2-9-T-1-2",
                    "long_name" => "CCC 2-9-T-1-2",
                    "description" => "In addition to subcontrols in the ECC control 2-10-3, the CST shall cover the following additional subcontrols for cybersecurity requirements for vulnerability management requirements, as a minimum: Management of CSP-notified vulnerabilities safeguards in place.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-9-T-1-2",
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
                    "short_name" => "CCC 2-11-T-1",
                    "long_name" => "CCC 2-11-T-1",
                    "description" => "In addition to subcontrols in the ECC control 2-12-3, the CST shall cover the following additional subcontrols for cybersecurity requirements for cybersecurity event logs and monitoring management, as a minimum:",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-11-T-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                    "short_name" => "CCC 2-11-T-1-1",
                    "long_name" => "CCC 2-11-T-1-1",
                    "description" => "In addition to subcontrols in the ECC control 2-12-3, the CST shall cover the following additional subcontrols for cybersecurity requirements for cybersecurity event logs and monitoring management, as a minimum: Activating and collecting of login event logs, and cybersecurity event logs
on assets related to cloud services.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-11-T-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                        ],
                                                [
                    "short_name" => "CCC 2-11-T-1-2",
                    "long_name" => "CCC 2-11-T-1-2",
                    "description" => "In addition to subcontrols in the ECC control 2-12-3, the CST shall cover the following additional subcontrols for cybersecurity requirements for cybersecurity event logs and monitoring management, as a minimum:  Monitoring shall include all activated cybersecurity logs on the cloud services of the CST.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-11-T-1-2",
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
                    "short_name" => "CCC 2-15-T-1",
                    "long_name" => "CCC 2-15-T-1",
                    "description" => "Cybersecurity requirements for key management within the CST shall be identified, documented and approved.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-15-T-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Key management'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "CCC 2-15-T-2",
                    "long_name" => "CCC 2-15-T-2",
                    "description" => "Cybersecurity requirements for key management within the CST shall applied.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-15-T-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Key management'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "CCC 2-15-T-3",
                    "long_name" => "CCC 2-15-T-3",
                    "description" => "In addition to the ECC subcontrol 2-8-3-2, cybersecurity requirements for key management within the CST shall cover, at minimum, the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-15-T-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Key management'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                    "short_name" => "CCC 2-15-T-3-1",
                    "long_name" => "CCC 2-15-T-3-1",
                    "description" => "In addition to the ECC subcontrol 2-8-3-2, cybersecurity requirements for key management within the CST shall cover, at minimum, the following: Ensure well-defined ownership for cryptographic keys.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-15-T-3-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Key management'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                        ],
                                                [
                    "short_name" => "CCC 2-15-T-3-2",
                    "long_name" => "CCC 2-15-T-3-2",
                    "description" => "In addition to the ECC subcontrol 2-8-3-2, cybersecurity requirements for key management within the CST shall cover, at minimum, the following: A secure data retrieval mechanism in case of cryptographic encryption key
lost (such as backup of keys and enforcement of trusted key storage, strictly
external to cloud).",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-15-T-3-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Key management'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                        ],
                    ],
                ],
                [
                    "short_name" => "CCC 2-15-T-4",
                    "long_name" => "CCC 2-15-T-4",
                    "description" => "Cybersecurity requirements for key management within the CST shall be applied and reviewed periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 2-15-T-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Key management'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                
                [
                    "short_name" => "CCC 3-1-T-1",
                    "long_name" => "CCC 3-1-T-1",
                    "description" => "In addition to subcontrols in the ECC control 3-1-3, the CST shall cover the following additional subcontrols for cybersecurity requirements for cybersecurity resilience aspects of
business continuity management, as a minimum:",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 3-1-T-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => 
                    [
                    
                        [
                    "short_name" => "CCC 3-1-T-1-1",
                    "long_name" => "CCC 3-1-T-1-1",
                    "description" => "In addition to subcontrols in the ECC control 3-1-3, the CST shall cover the following additional subcontrols for cybersecurity requirements for cybersecurity resilience aspects of
business continuity management, as a minimum:
 Developing and implementing disaster recovery and business continuity
procedures related to cloud computing, in a secure manner.",
                    "supplemental_guidance" => null,
                    "control_number" => "CCC 3-1-T-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
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

        $requirementData = $dataToInsert['requirement'] ?? []; // Store requirement data separately
        unset($dataToInsert['requirement']);

        // Ensure that 'parent_id' is set correctly
        $dataToInsert['parent_id'] = $parentId;

        $dataToInsert['description'] = ['en' => $controlData['description'], 'ar' => $controlData['description']];
        // Create the FrameworkControl record
        $control = FrameworkControl::create($dataToInsert);

        if (!empty($requirementData) && in_array('install_requirement', $this->options)) {
            // foreach ($requirementData as $reqData) {
            //     // First try to find existing objective
            //     $objective = ControlObjective::where('name', $reqData['name'])->first();

            //     if ($objective) {
            //         // Update existing objective - handle comma-separated values
            //         $frameworkIds = $objective->framework_id ? explode(',', $objective->framework_id) : [];
            //         if (!in_array($reqData['framework_id'], $frameworkIds)) {
            //             $frameworkIds[] = $reqData['framework_id'];
            //         }

            //         $controlIds = $objective->control_id ? explode(',', $objective->control_id) : [];
            //         if (!in_array($control->id, $controlIds)) {
            //             $controlIds[] = $control->id;
            //         }

            //         $objective->update([
            //             'description' => $reqData['description'],
            //             'framework_id' => implode(',', $frameworkIds),
            //             'control_id' => implode(',', $controlIds)
            //         ]);
            //     } else {
            //         // Create new objective with single IDs (no need to implode)
            //         $objective = ControlObjective::create([
            //             'name' => $reqData['name'],
            //             'description' => $reqData['description'],
            //             'framework_id' => $reqData['framework_id'], // Single ID
            //             'control_id' => $control->id // Single ID
            //         ]);
            //     }

            //     // Then create the pivot record
            //     ControlControlObjective::updateOrCreate(
            //         [
            //             'control_id' => $control->id,
            //             'objective_id' => $objective->id
            //         ],
            //         [
            //             'responsible_type' => $reqData['responsible_type'],
            //             'responsible_id' => $reqData['responsible_id'],
            //             'due_date' => $reqData['due_date']
            //         ]
            //     );
            // }
        }

        // Handle associated documents
        if (in_array('install_document', $this->options)) {
            // if (isset($documentData) && !empty($documentData)) {
            //     foreach ($documentData as $docData) {

            //         $this->createOrUpdateDocument($docData, $control->id);
            //     }
            // }
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


    // private function createOrUpdateDocument($documentData, $controlId)
    // {
    //     if (isset($documentData) && !empty($documentData)) {
    //         \Log::info('Processing document data:', $documentData);

    //         $documentName = $documentData['document_name'];
    //         \Log::info('Document Name:', ['document_name' => $documentName]);

    //         $document = Document::where('document_name', $documentName)->first();

    //         if ($document) {
    //             // Ensure control_ids is a string or an array, depending on your schema
    //             $existingControlIds = $document->control_ids ? explode(',', $document->control_ids) : [];
    //             if (!in_array($controlId, $existingControlIds)) {
    //                 $existingControlIds[] = $controlId;
    //             }
    //             \Log::info('Updating document with ID:', ['id' => $document->id, 'control_ids' => $existingControlIds]);
    //             $document->control_ids = implode(',', $existingControlIds); // Convert back to a string if necessary
    //             $document->save();
    //         } else {
    //             \Log::info('Creating new document with name:', ['document_name' => $documentName]);
    //             Document::create([
    //                 'document_type' => $documentData['document_type'],
    //                 'privacy' => $documentData['privacy'],
    //                 'document_name' => $documentName,
    //                 'document_status' => $documentData['document_status'],
    //                 'creation_date' => $documentData['creation_date'],
    //                 'last_review_date' => $documentData['last_review_date'],
    //                 'review_frequency' => $documentData['review_frequency'],
    //                 'next_review_date' => $documentData['next_review_date'],
    //                 'control_ids' => implode(',', [$controlId]), // Ensure this is a string if needed
    //                 'framework_ids' => $documentData['framework_ids'],
    //                 'document_owner' => $documentData['document_owner'],
    //                 'additional_stakeholders' => $documentData['additional_stakeholders'],
    //                 'team_ids' => $documentData['team_ids'],
    //                 'created_by' => $documentData['created_by']
    //             ]);
    //         }
    //     } else {
    //         \Log::info('Document data is empty or not set.');
    //     }
    // }


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