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

class NCACCCPSeeder extends Seeder
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
                    'name' => 'NCA-CCC-P – 2: 2024',
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
                        "short_name" => "CCC 1-1-P-1",
                        "long_name" => "CCC 1-1-P-1",
                        "description" => "In addition to the ECC control 1-4-1, the Authorizing Official shall also identify, document and approve:
                        Cybersecurity roles and RACI assignment for all stakeholders of the cloud
                        services including Authorizing Official’s roles and responsibilities.",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 1-1-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cybersecurity Role and Responsibilities'), // Dynamically get family ID
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",

                    ],
                    [

                        "short_name" => "CCC 1-2-P-1",
                        "long_name" => "CCC 1-2-P-1",
                        "description" => "Cybersecurity risk management methodology mentioned in the ECC Subdomain 1-5, shall
                        also include for the CSP, as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 1-2-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [

                                "short_name" => "CCC 1-2-P-1-1",
                                "long_name" => "CCC 1-2-P-1-1",
                                "description" => " Cybersecurity risk management methodology mentioned in the ECC Subdomain 1-5, shall
                            also include for the CSP, as a minimum:
                            Defining acceptable risk levels for the cloud services, and clarifying them to
                            the CST if they are related to the CST.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 1-2-P-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [

                                "short_name" => "CCC 1-2-P-1-2",
                                "long_name" => "CCC 1-2-P-1-2",
                                "description" => "Cybersecurity risk management methodology mentioned in the ECC Subdomain 1-5, shall
                            also include for the CSP, as a minimum: Considering data and information classification in cybersecurity risk
                            management methodology.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 1-2-P-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [

                                "short_name" => "CCC 1-2-P-1-3",
                                "long_name" => "CCC 1-2-P-1-3",
                                "description" => "Cybersecurity risk management methodology mentioned in the ECC Subdomain 1-5, shall
                            also include for the CSP, as a minimum: Developing cybersecurity risk register for cloud services, and monitoring it
                            periodically according to the risks.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 1-2-P-1-3",
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

                        "short_name" => "CCC 1-3-P-1",
                        "long_name" => "CCC 1-3-P-1",
                        "description" => "In addition to the ECC control 1-7-1, the CSP legislative and regulatory compliance should
                        include as a minimum with the following requirements:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 1-3-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cybersecurity Regulatory Compliance'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [

                                "short_name" => "CCC 1-3-P-1-1",
                                "long_name" => "CCC 1-3-P-1-1",
                                "description" => "In addition to the ECC control 1-7-1, the CSP legislative and regulatory compliance should
                        include as a minimum with the following requirements:
                        Continuous compliance with all laws, regulations, instructions, decisions,
                        regulatory frameworks and controls, and mandates regarding cybersecurity
                        in KSA.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 1-3-P-1-1",
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

                        "short_name" => "CCC 1-4-P-1",
                        "long_name" => "CCC 1-4-P-1",
                        "description" => "In addition to subcontrols in the ECC controls 1-9-3 and 1-9-4, the following requirements
                        should be covered prior and during the professional relationship of personnel with the CSP
                        as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 1-4-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [

                                "short_name" => "CCC 1-4-P-1-1",
                                "long_name" => "CCC 1-4-P-1-1",
                                "description" => "In addition to subcontrols in the ECC controls 1-9-3 and 1-9-4, the following requirements
                        should be covered prior and during the professional relationship of personnel with the CSP
                        as a minimum:
                        Positions of cybersecurity functions in CSP’s data centers within the KSA
                        must be filled with qualified and suitable Saudi nationals.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 1-4-P-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),

                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [

                                "short_name" => "CCC 1-4-P-1-2",
                                "long_name" => "CCC 1-4-P-1-2",
                                "description" => "In addition to subcontrols in the ECC controls 1-9-3 and 1-9-4, the following requirements
                        should be covered prior and during the professional relationship of personnel with the CSP
                        as a minimum: Screening or vetting candidates of personnel working inside KSA who have
                        access to Cloud Technology Stack, periodically.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 1-4-P-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),

                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [

                                "short_name" => "CCC 1-4-P-1-3",
                                "long_name" => "CCC 1-4-P-1-3",
                                "description" => "In addition to subcontrols in the ECC controls 1-9-3 and 1-9-4, the following requirements
                            should be covered prior and during the professional relationship of personnel with the CSP
                            as a minimum: Cybersecurity policies as a prerequisite to access to Cloud Technology Stack,
                            signed and appropriately approved.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 1-4-P-1-3",
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

                        "short_name" => "CCC 1-4-P-2",
                        "long_name" => " CCC 1-4-P-2",
                        "description" => "In addition to subcontrols in the ECC control 1-9-5, the following requirements should be
                        in place, as a minimum, for the termination/completion of a human resource’s professional
                        relationship with the CSP:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 1-4-P-2",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cybersecurity in Human Resources'),

                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "CCC 1-4-P-2-1",
                                "long_name" => "CCC 1-4-P-2-1",
                                "description" => "In addition to subcontrols in the ECC control 1-9-5, the following requirements should be
                            in place, as a minimum, for the termination/completion of a human resource’s professional
                            relationship with the CSP:
                            Assurance that assets owned by the organization (especially those with
                            security exposure) are accounted for and returned upon termination.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 1-4-P-2-1",
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
                        "short_name" => "CCC 1-5-P-1",
                        "long_name" => "CCC 1-5-P-1",
                        "description" => "Cybersecurity requirements for change management within the CSP shall be identified,
                        documented and approved.",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 1-5-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),

                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",

                    ],
                    [
                        "short_name" => "CCC 1-5-P-2",
                        "long_name" => "CCC 1-5-P-2",
                        "description" => "Cybersecurity requirements for change management within the CSP shall be applied.",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 1-5-P-2",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",


                    ],
                    [
                        "short_name" => "CCC 1-5-P-3",
                        "long_name" => "CCC 1-5-P-3",
                        "description" => "Cybersecurity for change management in the CSP shall cover, as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 1-5-P-3",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "CCC 1-5-P-3-1",
                                "long_name" => "CCC 1-5-P-3-1",
                                "description" => "Cybersecurity for change management in the CSP shall cover, as a minimum:
                        Processes and procedures to securely implement changes (planned works) in
                        production systems, with priority given to cybersecurity observations.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 1-5-P-3-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 1-5-P-3-2",
                                "long_name" => "CCC 1-5-P-3-2",
                                "description" => "Cybersecurity for change management in the CSP shall cover, as a minimum: Process for the implementation of cybersecurity exceptional changes (e.g.:
                        changes during incident restoration).",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 1-5-P-3-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                        ],
                    ],
                    [
                        "short_name" => "CCC 1-5-P-4",
                        "long_name" => "CCC 1-5-P-4",
                        "description" => "Cybersecurity requirements for change management within the CSP shall be applied and
                        reviewed periodically.",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 1-5-P-4",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Management Change in Cybersecurity'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",

                    ],

                    [
                        "short_name" => "CCC 2-1-P-1",
                        "long_name" => "CCC 2-1-P-1",
                        "description" => "In addition to controls in the ECC control 2-1, the CSP shall cover the following additional
                        controls for cybersecurity requirements for cybersecurity event logs and monitoring management, as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-1-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Asset Management'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "CCC 2-1-P-1-1",
                                "long_name" => "CCC 2-1-P-1-1",
                                "description" => "In addition to controls in the ECC control 2-1, the CSP shall cover the following additional
                            controls for cybersecurity requirements for cybersecurity event logs and monitoring management, as a minimum:
                            Inventory of all information and technology assets using suitable techniques
                            such as Configuration Management Database (CMDB) or similar capability
                            containing an inventory of all technical assets.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-1-P-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Asset Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-1-P-1-2",
                                "long_name" => "CCC 2-1-P-1-2",
                                "description" => "In addition to controls in the ECC control 2-1, the CSP shall cover the following additional
                            controls for cybersecurity requirements for cybersecurity event logs and monitoring management, as a minimum: Identifying assets owners and involving them in the asset management lifecycle.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-1-P-1-2",
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
                        "short_name" => "CCC 2-2-P-1",
                        "long_name" => "CCC 2-2-P-1",
                        "description" => "In addition to subcontrols in the ECC control 2-2-3, the CSP shall cover the following
                    additional subcontrols for cybersecurity requirements for identity and access management
                    requirements, as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-2-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Identity and Access Management'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "CCC 2-2-P-1-1",
                                "long_name" => "CCC 2-2-P-1-1",
                                "description" => "In addition to subcontrols in the ECC control 2-2-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for identity and access management requirements, as a minimum:
                            Identity and access management of generic accounts credentials for accountability cannot be assigned for a specific individual.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-2-P-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-2-P-1-2",
                                "long_name" => "CCC 2-2-P-1-2",
                                "description" => "In addition to subcontrols in the ECC control 2-2-3, the CSP shall cover the following
                            additional subcontrols for cybersecurity requirements for identity and access management
                            requirements, as a minimum: Secure session management, including session authenticity, session lockout,
                            and session timeout termination.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-2-P-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-2-P-1-3",
                                "long_name" => "CCC 2-2-P-1-3",
                                "description" => "In addition to subcontrols in the ECC control 2-2-3, the CSP shall cover the following
                            additional subcontrols for cybersecurity requirements for identity and access management
                            requirements, as a minimum: Multi-factor authentication for privileged users, and candidates of personnel
                            with access to Cloud Technology Stack.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-2-P-1-3",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-2-P-1-4",
                                "long_name" => "CCC 2-2-P-1-4",
                                "description" => "In addition to subcontrols in the ECC control 2-2-3, the CSP shall cover the following
                            additional subcontrols for cybersecurity requirements for identity and access management
                            requirements, as a minimum: Formal process to detect and prevent unauthorized access (e.g. unsuccessful
                            login attempt threshold).",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-2-P-1-4",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-2-P-1-5",
                                "long_name" => "CCC 2-2-P-1-5",
                                "description" => "In addition to subcontrols in the ECC control 2-2-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for identity and access management requirements, as a minimum: Utilizing secure methods and algorithms for saving and processing passwords, such as: Secure Hashing functions.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-2-P-1-5",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-2-P-1-6",
                                "long_name" => "CCC 2-2-P-1-6",
                                "description" => "IIn addition to subcontrols in the ECC control 2-2-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for identity and access management requirements, as a minimum:  Secure management of third party personnel’s accounts.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-2-P-1-6",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-2-P-1-7",
                                "long_name" => "CCC 2-2-P-1-7",
                                "description" => "In addition to subcontrols in the ECC control 2-2-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for identity and access management requirements, as a minimum: Access control enforced to management systems, administrative consoles.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-2-P-1-7",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-2-P-1-8",
                                "long_name" => "CCC 2-2-P-1-8",
                                "description" => "In addition to subcontrols in the ECC control 2-2-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for identity and access management requirements, as a minimum: Masking of displayed authentication inputs, especially passwords, to prevent shoulder surfing.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-2-P-1-8",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-2-P-1-9",
                                "long_name" => "CCC 2-2-P-1-9",
                                "description" => "In addition to subcontrols in the ECC control 2-2-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for identity and access management requirements, as a minimum: Getting CST’s approval before accessing any CST-related asset by the CSP
                            or CSP’s third parties.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-2-P-1-9",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC ٠2-2-P-1-10",
                                "long_name" => "CCC ٠2-2-P-1-10",
                                "description" => "In addition to subcontrols in the ECC control 2-2-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for identity and access management requirements, as a minimum: Capability to immediately interrupt a remote access session and prevent any
                            future access for a user.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC ٠2-2-P-1-10",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-2-P-1-11",
                                "long_name" => "CCC 2-2-P-1-11",
                                "description" => "In addition to subcontrols in the ECC control 2-2-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for identity and access management requirements, as a minimum: Provision to CSTs of Multi-factor authentication services for privileged
                            cloud users.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-2-P-1-11",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Identity and Access Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-2-P-1-12",
                                "long_name" => "CCC 2-2-P-1-12",
                                "description" => "In addition to subcontrols in the ECC control 2-2-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for identity and access management requirements, as a minimum: Assurance of restricted and controlled access to storage systems and means
                                (such as Storage Area Network (SAN)).",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-2-P-1-12",
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
                        "short_name" => "CCC  2-3-P-1",
                        "long_name" => "CCC  2-3-P-1",
                        "description" => "In addition to subcontrols in the ECC control 2-3-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for information system and processing
                    facilities protection requirements, as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC  2-3-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        'children' => [
                            [
                                "short_name" => "CCC 2-3-P-1-1",
                                "long_name" => "CCC 2-3-P-1-1",
                                "description" => "In addition to subcontrols in the ECC control 2-3-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for information system and processing
                            facilities protection requirements, as a minimum:
                            Ensuring that all configurations are applied in accordance to CSP’s cybersecurity standards.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-3-P-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-3-P-1-2",
                                "long_name" => "CCC 2-3-P-1-2",
                                "description" => "In addition to subcontrols in the ECC control 2-3-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for information system and processing facilities protection requirements, as a minimum: Assurance of separation and isolation of data, environments and information
                            systems across CSTs, to prevent data commingling.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-3-P-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC  2-3-P-1-3",
                                "long_name" => "CCC  2-3-P-1-3",
                                "description" => "In addition to subcontrols in the ECC control 2-3-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for information system and processing facilities protection requirements, as a minimum: Adopting of cybersecurity principles for technical system configurations
                            adhering to the minimum functionality principle.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC  2-3-P-1-3",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-3-P-1-4",
                                "long_name" => "CCC 2-3-P-1-4",
                                "description" => "In addition to subcontrols in the ECC control 2-3-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for information system and processing facilities protection requirements, as a minimum: Ability of the Cloud Technology Stacks to securely handle input validation,
                                exceptions and failure.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-3-P-1-4",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-3-P-1-5",
                                "long_name" => "CCC 2-3-P-1-5",
                                "description" => "In addition to subcontrols in the ECC control 2-3-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for information system and processing facilities protection requirements, as a minimum: Full isolation of security functions and applications from other functions
                                and applications in the Cloud Technology Stack.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-3-P-1-5",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-3-P-1-6",
                                "long_name" => "CCC 2-3-P-1-6",
                                "description" => "In addition to subcontrols in the ECC control 2-3-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for information system and processing facilities protection requirements, as a minimum: Notification to CSTs with cybersecurity requirements provided by the CSP
                            that are useable by the CST.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-3-P-1-6",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-3-P-1-7",
                                "long_name" => "CCC 2-3-P-1-7",
                                "description" => "In addition to subcontrols in the ECC control 2-3-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for information system and processing facilities protection requirements, as a minimum: Detection and prevention of unauthorized changes to softwares, and systems.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-3-P-1-7",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-3-P-1-8",
                                "long_name" => "CCC 2-3-P-1-8",
                                "description" => "In addition to subcontrols in the ECC control 2-3-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for information system and processing facilities protection requirements, as a minimum: Complete isolation and protection of multiple guest environments.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-3-P-1-8",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-3-P-1-9",
                                "long_name" => "CCC 2-3-P-1-9",
                                "description" => "In addition to subcontrols in the ECC control 2-3-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for information system and processing facilities protection requirements, as a minimum: The community cloud services provided to CSTs (government organizations and CNI organizations) shall be isolated from any other cloud computing provided to organizations outside the scope of work.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-3-P-1-9",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-3-P-1-10",
                                "long_name" => "CCC 2-3-P-1-10",
                                "description" => "In addition to subcontrols in the ECC control 2-3-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for information system and processing facilities protection requirements, as a minimum: Modern technologies, such as Endpoint Detection and Response (EDR)
                            technologies, to ensure that the information servers and devices of CSP’s
                            information processing systems and devices of are ready for rapid response
                            to incidents.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-3-P-1-10",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Information System and Processing Facilities Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ]

                        ],
                    ],
                    [
                        "short_name" => "CCC 2-4-P-1",
                        "long_name" => "CCC 2-4-P-1",
                        "description" => "In addition to subcontrols in the ECC control 2-5-3, the CSP shall cover the following
                    additional subcontrols for cybersecurity requirements for networks security management
                    requirements, as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-4-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Networks Security Management'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        'children' => [
                            [
                                "short_name" => "CCC 2-4-P-1-1",
                                "long_name" => "CCC 2-4-P-1-1",
                                "description" => "In addition to subcontrols in the ECC control 2-5-3, the CSP shall cover the following
                            additional subcontrols for cybersecurity requirements for networks security management
                            requirements, as a minimum:
                            Monitoring of traffic across the external and internal networks to detect
                            anomalies.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-4-P-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Networks Security Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-4-P-1-2",
                                "long_name" => "CCC 2-4-P-1-2",
                                "description" => "In addition to subcontrols in the ECC control 2-5-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for networks security management requirements, as a minimum: Network isolation and protection of Cloud Technology Stack network from
                            other internal and external networks.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-4-P-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Networks Security Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-4-P-1-3",
                                "long_name" => "CCC 2-4-P-1-3",
                                "description" => "In addition to subcontrols in the ECC control 2-5-3, the CSP shall cover the following
                            additional subcontrols for cybersecurity requirements for networks security management
                            requirements, as a minimum: Protection from denial of service attacks (including Distributed Denial of
                            Service (DDoS)).",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-4-P-1-3",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Networks Security Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-4-P-1-4",
                                "long_name" => "CCC 2-4-P-1-4",
                                "description" => "In addition to subcontrols in the ECC control 2-5-3, the CSP shall cover the following
                            additional subcontrols for cybersecurity requirements for networks security management
                            requirements, as a minimum: Protection of data transmitted through the network; from and to the Cloud
                            Technology Stack network using cryptography primitives; for management
                            and administrative access.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-4-P-1-4",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Networks Security Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-4-P-1-5",
                                "long_name" => "CCC 2-4-P-1-5",
                                "description" => "In addition to subcontrols in the ECC control 2-5-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for networks security management requirements, as a minimum: Access control between different network segments.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-4-P-1-5",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Networks Security Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-4-P-1-6",
                                "long_name" => "CCC 2-4-P-1-6",
                                "description" => "In addition to subcontrols in the ECC control 2-5-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for networks security management requirements, as a minimum: Isolation between cloud service delivery network, cloud management network and CSP enterprise network.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-4-P-1-6",
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
                        "short_name" => "CCC 2-5-P-1",
                        "long_name" => "CCC 2-5-P-1",
                        "description" => "In addition to subcontrols in the ECC control 2-6-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for mobile device security, as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-5-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        'children' => [
                            [
                                "short_name" => "CCC 2-5-P-1-1",
                                "long_name" => "CCC 2-5-P-1-1",
                                "description" => "In addition to subcontrols in the ECC control 2-6-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for mobile device security, as a minimum:
                            Inventory of all end user and mobile devices",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-5-P-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-5-P-1-2",
                                "long_name" => "CCC 2-5-P-1-2",
                                "description" => "In addition to subcontrols in the ECC control 2-6-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for mobile device security, as a minimum:  Centralized mobile device security management.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-5-P-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-5-P-1-3",
                                "long_name" => "CCC 2-5-P-1-3",
                                "description" => "In addition to subcontrols in the ECC control 2-6-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for mobile device security, as a minimum: Screen locking for end user devices.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-5-P-1-3",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Mobile Devices Security'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-5-P-1-4",
                                "long_name" => "CCC 2-5-P-1-4",
                                "description" => "In addition to subcontrols in the ECC control 2-6-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for mobile device security, as a minimum: Data sanitation and secure disposal for end-user devices, especially for
                            those with exposure to the Cloud Technology Stack.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-5-P-1-4",
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
                        "short_name" => "CCC 2-6-P-1",
                        "long_name" => "CCC 2-6-P-1",
                        "description" => "In addition to subcontrols in the ECC control 2-7-3, the CSP shall cover the following
                    additional subcontrols for cybersecurity requirements for data and information protection
                    requirements, as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-6-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Data and Information Protection'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        'children' => [
                            [
                                "short_name" => "CCC 2-6-P-1-1",
                                "long_name" => "CCC 2-6-P-1-1",
                                "description" => "In addition to subcontrols in the ECC control 2-7-3, the CSP shall cover the following
                                additional subcontrols for cybersecurity requirements for data and information protection
                                requirements, as a minimum:
                                Prohibiting the use of Cloud Technology Stack’s data in any environment
                                other than production environment, except after applying strict controls for
                                protecting that data, such as: data masking or data scrambling techniques.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-6-P-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Data and Information Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",


                            ],
                            [
                                "short_name" => "CCC 2-6-P-1-2",
                                "long_name" => "CCC 2-6-P-1-2",
                                "description" => "In addition to subcontrols in the ECC control 2-7-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for data and information protection requirements, as a minimum: Provision to CSTs of securely data storage processes, procedures, and technologies to comply with related legal and regulatory requirements.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-6-P-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Data and Information Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",


                            ],
                            [

                                "short_name" => "CCC 2-6-P-1-3",
                                "long_name" => "CCC 2-6-P-1-3",
                                "description" => "In addition to subcontrols in the ECC control 2-7-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for data and information protection requirements, as a minimum: Disposal of CST’s data should be performed in a secure manner on termination or expiry of the contract with the CSP.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-6-P-1-3",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Data and Information Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [

                                "short_name" => "CCC 2-6-P-1-4",
                                "long_name" => "CCC 2-6-P-1-4",
                                "description" => "In addition to subcontrols in the ECC control 2-7-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for data and information protection requirements, as a minimum: Commitment to maintain the confidentiality of the CST’s data and information, according to related legal and regulatory requirements.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-6-P-1-4",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Data and Information Protection'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-6-P-1-5",
                                "long_name" => "CCC 2-6-P-1-5",
                                "description" => "In addition to subcontrols in the ECC control 2-7-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for data and information protection requirements, as a minimum: Providing CSTs with secure means to export and transfer data and virtual
                            infrastructure.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-6-P-1-5",
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
                        "short_name" => "CCC 2-7-P-1",
                        "long_name" => "CCC 2-7-P-1",
                        "description" => "In addition to subcontrols in the ECC control 2-8-3, the CSP shall cover the following additional subcontrols for cryptography, as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-7-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cryptography'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        'children' => [
                            [
                                "short_name" => "CCC 2-7-P-1-1",
                                "long_name" => "CCC 2-7-P-1-1",
                                "description" => "In addition to subcontrols in the ECC control 2-8-3, the CSP shall cover the following additional subcontrols for cryptography, as a minimum: Technical mechanisms and cryptographic primitives for strong encryption,
                                in according to the advanced level in the National Cryptographic Standards
                                (NCS-1:2020).",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-7-P-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cryptography'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-7-P-1-2",
                                "long_name" => "CCC 2-7-P-1-2",
                                "description" => "In addition to subcontrols in the ECC control 2-8-3, the CSP shall cover the following additional subcontrols for cryptography, as a minimum:  Certification authority and issuance capability in a secure manner, or usage
                            of certificates from a trusted certification authority.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-7-P-1-2",
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
                        "short_name" => "CCC 2-8-P-1",
                        "long_name" => "CCC 2-8-P-1",
                        "description" => "In addition to subcontrols in the ECC control 2-9-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for backup and recovery management,
                        as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-8-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            
                                [
                                    "short_name" => "CCC 2-8-P-1-1",
                                    "long_name" => "CCC 2-8-P-1-1",
                                    "description" => "In addition to subcontrols in the ECC control 2-9-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for backup and recovery management, as a minimum: Securing access, storage and transfer of CST’s data backups and its mediums, and protecting it against damage, amendment or unauthorized access.",
                                    "supplemental_guidance" => null,
                                    "control_number" => "CCC 2-8-P-1-1",
                                    "control_status" => "Not Implemented",
                                    "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                                    "control_owner" => "1",

                                    "submission_date" => $currentDateTime,
                                    "status" => "1",
                                    "deleted" => "0",
                                ],
                                [
                                    "short_name" => "CCC 2-8-P-1-2",
                                    "long_name" => "CCC 2-8-P-1-2",
                                    "description" => "In addition to subcontrols in the ECC control 2-9-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for backup and recovery management, as a minimum: Securing access, storage and transfer of Cloud Technology Stack backups and its mediums, and protecting it against damage, amendment or unauthorized access.",
                                    "supplemental_guidance" => null,
                                    "control_number" => "CCC 2-8-P-1-2",
                                    "control_status" => "Not Implemented",
                                    "family" => $this->getFamilyIdByName('Backup and Recovery Management'),
                                    "control_owner" => "1",

                                    "submission_date" => $currentDateTime,
                                    "status" => "1",
                                    "deleted" => "0",
                                ],

                            
                        ],
                    ],

                    [
                        "short_name" => "CCC 2-9-P-1",
                        "long_name" => "CCC 2-9-P-1",
                        "description" => "In addition to subcontrols in the ECC control 2-10-3, the CSP shall cover the following
                    additional subcontrols for cybersecurity requirements for vulnerability management requirements, as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-9-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "CCC 2-9-P-1-1",
                                "long_name" => "CCC 2-9-P-1-1",
                                "description" => "In addition to subcontrols in the ECC control 2-10-3, the CSP shall cover the following
                            additional subcontrols for cybersecurity requirements for vulnerability management requirements, as a minimum:
                            Assessing and remediating vulnerabilities on external components of Cloud
                            Technology Stack at least once every month, and at least once every three
                            months for internal components of Cloud Technology Stack.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-9-P-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Vulnerabilities Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-9-P-1-2",
                                "long_name" => "CCC 2-9-P-1-2",
                                "description" => "In addition to subcontrols in the ECC control 2-10-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for vulnerability management requirements, as a minimum: Notification to CSTs of identified vulnerabilities that may affecting them,
                            and safeguards in place.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-9-P-1-2",
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
                        "short_name" => "CCC 2-10-P-1",
                        "long_name" => "CCC 2-10-P-1",
                        "description" => "In addition to subcontrols in the ECC control2-11-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for penetration testing, as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-10-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Penetration Testing'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "CCC 2-10-P-1-1",
                                "long_name" => "CCC 2-10-P-1-1",
                                "description" => "In addition to subcontrols in the ECC control2-11-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for penetration testing, as a minimum:
                            Scope of penetration tests must cover Cloud Technology Stack and must be
                            conducted at least once every six months.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-10-P-1-1",
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
                        "short_name" => "CCC 2-11-P-1",
                        "long_name" => "CCC 2-11-P-1",
                        "description" => "In addition to subcontrols in the ECC control 2-12-3, the CSP shall cover the following
                            additional subcontrols for cybersecurity requirements for cybersecurity event logs and
                            monitoring management, as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-11-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "CCC 2-11-P-1-1",
                                "long_name" => "CCC 2-11-P-1-1",
                                "description" => "In addition to subcontrols in the ECC control 2-12-3, the CSP shall cover the following
                                additional subcontrols for cybersecurity requirements for cybersecurity event logs and
                                monitoring management, as a minimum:
                                Activating and protecting event logs and audit trails of Cloud Technology
                                Stack.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-11-P-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-11-P-1-2",
                                "long_name" => "CCC 2-11-P-1-2",
                                "description" => "In addition to subcontrols in the ECC control 2-12-3, the CSP shall cover the following
                                additional subcontrols for cybersecurity requirements for cybersecurity event logs and
                                monitoring management, as a minimum:
                                Activating and collecting of login attempts history.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-11-P-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-11-P-1-3",
                                "long_name" => "CCC 2-11-P-1-3",
                                "description" => "In addition to subcontrols in the ECC control 2-12-3, the CSP shall cover the following
                            additional subcontrols for cybersecurity requirements for cybersecurity event logs and
                            monitoring management, as a minimum: Activating and protecting all event logs of activities and operations performed by the CSP at the tenant level in order to support forensic analysis.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-11-P-1-3",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-11-P-1-4",
                                "long_name" => "CCC 2-11-P-1-4",
                                "description" => "In addition to subcontrols in the ECC control 2-12-3, the CSP shall cover the following
                            additional subcontrols for cybersecurity requirements for cybersecurity event logs and
                            monitoring management, as a minimum: Protecting cybersecurity event logs from alteration, disclosure, destruction
                            and unauthorized access and unauthorized release, in accordance with regulatory, or law requirements.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-11-P-1-4",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-11-P-1-5",
                                "long_name" => "CCC 2-11-P-1-5",
                                "description" => "In addition to subcontrols in the ECC control 2-12-3, the CSP shall cover the following
                            additional subcontrols for cybersecurity requirements for cybersecurity event logs and
                            monitoring management, as a minimum:Continuous cybersecurity events monitoring using SIEM technique covering the full Cloud Technology Stack.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-11-P-1-5",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-11-P-1-6",
                                "long_name" => "CCC 2-11-P-1-6",
                                "description" => "In addition to subcontrols in the ECC control 2-12-3, the CSP shall cover the following
                            additional subcontrols for cybersecurity requirements for cybersecurity event logs and
                            monitoring management, as a minimum: Reviewing cybersecurity event logs and audit trails periodically, covering
                            CSP events in the Cloud Technology Stack.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-11-P-1-6",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-11-P-1-7",
                                "long_name" => "CCC 2-11-P-1-7",
                                "description" => "In addition to subcontrols in the ECC control 2-12-3, the CSP shall cover the following
                                additional subcontrols for cybersecurity requirements for cybersecurity event logs and
                                monitoring management, as a minimum:
                                Automated monitoring and logging of remote access sessions event logs.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-11-P-1-7",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Event Logs and Monitoring Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-11-P-1-8",
                                "long_name" => "CCC 2-11-P-1-8",
                                "description" => "In addition to subcontrols in the ECC control 2-12-3, the CSP shall cover the following
                            additional subcontrols for cybersecurity requirements for cybersecurity event logs and
                            monitoring management, as a minimum: Secure handling of user-related data found in the audit trails and the cybersecurity event logs.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-11-P-1-8",
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
                        "short_name" => "CCC 2-12-P-1",
                        "long_name" => "CCC 2-12-P-1",
                        "description" => "In addition to subcontrols in the ECC control 2-13-3, the CSP shall cover the following
                        additional subcontrols for cybersecurity requirements for cybersecurity incident and threat
                        management, as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-12-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "CCC 2-12-P-1-1",
                                "long_name" => "CCC 2-12-P-1-1",
                                "description" => "In addition to subcontrols in the ECC control 2-13-3, the CSP shall cover the following
                                additional subcontrols for cybersecurity requirements for cybersecurity incident and threat
                                management, as a minimum: Subscribing in authorized and specialized organizations and groups to stay
                                up-to-date on cybersecurity threats, common practices and key know-how.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-12-P-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-12-P-1-2",
                                "long_name" => "CCC 2-12-P-1-2",
                                "description" => "In addition to subcontrols in the ECC control 2-13-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for cybersecurity incident and threat management, as a minimum: Training for employees and third-party personnel to respond to cybersecurity incidents, in line with their roles and responsibilities.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-12-P-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-12-P-1-3",
                                "long_name" => "CCC 2-12-P-1-3",
                                "description" => "In addition to subcontrols in the ECC control 2-13-3, the CSP shall cover the following
                                additional subcontrols for cybersecurity requirements for cybersecurity incident and threat
                                management, as a minimum: Periodically testing the incident response capability.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-12-P-1-3",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-12-P-1-4",
                                "long_name" => "CCC 2-12-P-1-4",
                                "description" => "In addition to subcontrols in the ECC control 2-13-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for cybersecurity incident and threat management, as a minimum: Root Cause Analysis of cybersecurity incidents and developing plans to
                            address them.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-12-P-1-4",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-12-P-1-5",
                                "long_name" => "CCC 2-12-P-1-5",
                                "description" => "In addition to subcontrols in the ECC control 2-13-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for cybersecurity incident and threat management, as a minimum: Support the CST in cases legal proceedings and forensics, protecting the
                                        chain of custody that falls under the management and responsibility of the
                                        CSP, in accordance with the related law and regulatory requirements.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-12-P-1-5",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-12-P-1-6",
                                "long_name" => "CCC 2-12-P-1-6",
                                "description" => "In addition to subcontrols in the ECC control 2-13-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for cybersecurity incident and threat management, as a minimum: Real-time reporting to the CST of incidents that may affect CST; if the incident is discovered.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-12-P-1-6",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-12-P-1-7",
                                "long_name" => "CCC 2-12-P-1-7",
                                "description" => "In addition to subcontrols in the ECC control 2-13-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for cybersecurity incident and threat management, as a minimum: Support for CSTs to handle security incidents according to the agreement
                                    between the CSP and CST.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-12-P-1-7",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Incident and Threat Management'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-12-P-1-8",
                                "long_name" => "CCC 2-12-P-1-8",
                                "description" => "In addition to subcontrols in the ECC control 2-13-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for cybersecurity incident and threat management, as a minimum: Measuring and monitoring cybersecurity incident metrics and monitor
                                    compliance with contracts and legislative requirements.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-12-P-1-8",
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
                        "short_name" => "CCC 2-13-P-1",
                        "long_name" => "CCC 2-13-P-1",
                        "description" => "In addition to subcontrols in the ECC control 2-14-3, the CSP shall cover the following
                        additional subcontrols for cybersecurity requirements for physical security, as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-13-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Physical Security'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "CCC 2-13-P-1-1",
                                "long_name" => "CCC 2-13-P-1-1",
                                "description" => "In addition to subcontrols in the ECC control 2-14-3, the CSP shall cover the following
                                additional subcontrols for cybersecurity requirements for physical security, as a minimum:
                                Continual monitoring of access to CSP’s sites and buildings.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-13-P-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Physical Security'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-13-P-1-2",
                                "long_name" => "CCC 2-13-P-1-2",
                                "description" => "In addition to subcontrols in the ECC control 2-14-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for physical security, as a minimum: Preventing unauthorized access to devices in the Cloud Technology Stack.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-13-P-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Physical Security'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 2-13-P-1-3",
                                "long_name" => "CCC 2-13-P-1-3",
                                "description" => "In addition to subcontrols in the ECC control 2-14-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for physical security, as a minimum: Disposal of cloud infrastructure hardware, in particular, storage equipment
                                (external or internal), by adopting relevant legislation and best practices.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-13-P-1-3",
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
                        "short_name" => "CCC 2-14-P-1",
                        "long_name" => "CCC 2-14-P-1",
                        "description" => "In addition to subcontrols in the ECC control 2-15-3, the CSP shall cover the following
                            additional subcontrols for cybersecurity requirements for web application security, as a
                            minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-14-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Web Application Security'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "CCC 2-14-P-1-1",
                                "long_name" => "CCC 2-14-P-1-1",
                                "description" => "In addition to subcontrols in the ECC control 2-15-3, the CSP shall cover the following
                                    additional subcontrols for cybersecurity requirements for web application security, as a
                                    minimum: Protecting information involved in application service transactions against
                                    possible risks (e.g.: incomplete transmission, mis-routing, unauthorized
                                    message alteration, unauthorized disclosure….).",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-14-P-1-1",
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
                        "short_name" => "CCC 2-15-P-1",
                        "long_name" => "CCC 2-15-P-1",
                        "description" => "Cybersecurity requirements for key management process within the CSP shall be identified,
                            documented and approved.",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-15-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Key management'),
                        "control_owner" => "1",
                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",

                    ],
                    [
                        "short_name" => "CCC 2-15-P-2",
                        "long_name" => "CCC 2-15-P-2",
                        "description" => "Cybersecurity requirements for key management process within the CSP shall be applied.",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-15-P-2",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Key management'),
                        "control_owner" => "1",
                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",

                    ],
                    [
                        "short_name" => "CCC 2-15-P-3",
                        "long_name" => "CCC 2-15-P-3",
                        "description" => "In addition to the ECC subcontrol 2-8-3-2, cybersecurity requirements for key management within the CSP shall cover, at minimum, the following:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-15-P-3",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Key management'),
                        "control_owner" => "1",
                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "CCC 2-15-P-3-1",
                                "long_name" => "CCC 2-15-P-3-1",
                                "description" => "In addition to the ECC subcontrol 2-8-3-2, cybersecurity requirements for key management within the CSP shall cover, at minimum, the following:
                                    Ensure well-defined ownership for cryptographic keys.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-15-P-3-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Key management'),
                                "control_owner" => "1",
                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-15-P-3-2",
                                "long_name" => "CCC 2-15-P-3-2",
                                "description" => "In addition to the ECC subcontrol 2-8-3-2, cybersecurity requirements for key management within the CSP shall cover, at minimum, the following: A secure cryptographic key retrieval mechanism in case of cryptographic
                                        key lost (such as backup of keys and enforcement of trusted key storage,
                                        strictly external to cloud).",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-15-P-3-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Key management'),
                                "control_owner" => "1",
                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-15-P-3-3",
                                "long_name" => "CCC 2-15-P-3-3",
                                "description" => "In addition to the ECC subcontrol 2-8-3-2, cybersecurity requirements for key management within the CSP shall cover, at minimum, the following:
                                    Ensure well-defined ownership for cryptographic keys.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-15-P-3-3",
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
                        "short_name" => "CCC 2-15-P-4",
                        "long_name" => "CCC 2-15-P-4",
                        "description" => "Cybersecurity requirements for key management within the CSP shall be reviewed periodically.",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-15-P-4",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Key management'),
                        "control_owner" => "1",
                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",

                    ],
                    [
                        "short_name" => "CCC 2-16-P-1",
                        "long_name" => "CCC 2-16-P-1",
                        "description" => "Cybersecurity requirements for system development within the CSP shall be identified,
                            documented and approved.",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-16-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('System Development Security'),
                        "control_owner" => "1",
                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",

                    ],

                    [
                        "short_name" => "CCC 2-16-P-2",
                        "long_name" => "CCC 2-16-P-2",
                        "description" => "Cybersecurity requirements for system development within the CSP shall be applied.",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-16-P-2",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('System Development Security'),
                        "control_owner" => "1",
                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",

                    ],
                    [
                        "short_name" => "CCC 2-16-P-3",
                        "long_name" => "CCC 2-16-P-3",
                        "description" => "Cybersecurity requirements for system development within the CSP shall include as a minimum the following controls along the development lifecycle:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-16-P-3",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('System Development Security'),
                        "control_owner" => "1",
                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "CCC 2-16-P-3-1",
                                "long_name" => "CCC 2-16-P-3-1",
                                "description" => "Cybersecurity requirements for system development within the CSP shall include as a minimum the following controls along the development lifecycle: Considering cybersecurity requirements of the Cloud Technology Stack
                                and relevant systems in the design and implementation of the cloud computing services.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-16-P-3-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('System Development Security'),
                                "control_owner" => "1",
                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-16-P-3-2",
                                "long_name" => "CCC 2-16-P-3-2",
                                "description" => "Cybersecurity requirements for system development within the CSP shall include as a minimum the following controls along the development lifecycle: Protecting system development environments, testing environments (including data used in testing environment), and integration platforms.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-16-P-3-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('System Development Security'),
                                "control_owner" => "1",
                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],

                        ],
                    ],
                    [
                        "short_name" => "CCC 2-16-P-4",
                        "long_name" => "CCC 2-16-P-4",
                        "description" => "Cybersecurity requirements for system development within the CSP shall be applied and
                        reviewed periodically.",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-16-P-4",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Key management'),
                        "control_owner" => "1",
                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",

                    ],
                    [
                        "short_name" => "CCC 2-17-P-1",
                        "long_name" => "CCC 2-17-P-1",
                        "description" => "Cybersecurity requirements for usage of information and data media within the CSP shall
                        be identified, documented and approved.",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-17-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Storage Media Security'),
                        "control_owner" => "1",
                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",

                    ],
                    [
                        "short_name" => "CCC 2-17-P-2",
                        "long_name" => "CCC 2-17-P-2",
                        "description" => "Cybersecurity requirements for usage of information and data media within the CSP shall
                            be applied.",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-17-P-2",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Storage Media Security'),
                        "control_owner" => "1",
                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",

                    ],
                    [
                        "short_name" => "CCC 2-17-P-3",
                        "long_name" => "CCC 2-17-P-3",
                        "description" => "Cybersecurity requirements for usage of information and data media within the CSP shall
                        cover, at minimum, the following:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-17-P-3",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Storage Media Security'),
                        "control_owner" => "1",
                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "CCC 2-17-P-3-1",
                                "long_name" => "CCC 2-17-P-3-1",
                                "description" => "Cybersecurity requirements for usage of information and data media within the CSP shall
                                    cover, at minimum, the following:
                                    Enforcement of sanitization of media, prior to disposal or reuse.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-17-P-3-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Storage Media Security'),
                                "control_owner" => "1",
                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-17-P-3-2",
                                "long_name" => "CCC 2-17-P-3-2",
                                "description" => "Cybersecurity requirements for usage of information and data media within the CSP shall
                                cover, at minimum, the following: Using secure means when disposing of media.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-17-P-3-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Storage Media Security'),
                                "control_owner" => "1",
                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-17-P-3-3",
                                "long_name" => "CCC 2-17-P-3-3",
                                "description" => "Cybersecurity requirements for usage of information and data media within the CSP shall
                                    cover, at minimum, the following: Provision to maintain confidentiality and integrity of data on removable
                                    media.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-17-P-3-3",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Storage Media Security'),
                                "control_owner" => "1",
                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-17-P-3-4",
                                "long_name" => "CCC 2-17-P-3-4",
                                "description" => "Cybersecurity requirements for usage of information and data media within the CSP shall cover, at minimum, the following:  Human readable labelling of media, to explain its classification and the sensitivity of the information it contains.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-17-P-3-4",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Storage Media Security'),
                                "control_owner" => "1",
                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-17-P-3-5",
                                "long_name" => "CCC 2-17-P-3-5",
                                "description" => "Cybersecurity requirements for usage of information and data media within the CSP shall cover, at minimum, the following: Controlled and physically secure storage of removable media.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-17-P-3-5",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Storage Media Security'),
                                "control_owner" => "1",
                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],
                            [
                                "short_name" => "CCC 2-17-P-3-6",
                                "long_name" => "CCC 2-17-P-3-6",
                                "description" => "Cybersecurity requirements for usage of information and data media within the CSP shall cover, at minimum, the following: Restriction and control of usage of portable media inside the Cloud Technology Stack.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 2-17-P-3-6",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Storage Media Security'),
                                "control_owner" => "1",
                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",

                            ],

                        ],
                    ],
                    [
                        "short_name" => "CCC 2-17-P-4",
                        "long_name" => "CCC 2-17-P-4",
                        "description" => "Cybersecurity requirements for usage of information and data media within the CSP shall
                                be applied and reviewed periodically.",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 2-17-P-4",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Storage Media Security'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",

                    ],
                    [
                        "short_name" => "CCC 3-1-P-1",
                        "long_name" => "CCC 3-1-P-1",
                        "description" => "In addition to subcontrols in the ECC control 3-1-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for cybersecurity resilience aspects of
                            business continuity management, as a minimum:",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 3-1-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "CCC 3-1-P-1-1",
                                "long_name" => "CCC 3-1-P-1-1",
                                "description" => "In addition to subcontrols in the ECC control 3-1-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for cybersecurity resilience aspects of
                                    business continuity management, as a minimum:
                                    Developing and implementing disaster recovery and business continuity
                                    procedures in a secure manner.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 3-1-P-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Cybersecurity Resilience aspects of Business Continuity Management (BCM)'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 3-1-P-1-2",
                                "long_name" => "CCC 3-1-P-1-2",
                                "description" => "In addition to subcontrols in the ECC control 3-1-3, the CSP shall cover the following additional subcontrols for cybersecurity requirements for cybersecurity resilience aspects of
                                    business continuity management, as a minimum: Developing and implementing procedures to ensure resilience and
                                    continuity of cybersecurity systems dedicated to the protection of Cloud
                                    Technology Stack.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 3-1-P-1-2",
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
                        "short_name" => "CCC 4-1-P-1",
                        "long_name" => "CCC 4-1-P-1",
                        "description" => "In addition to implementing the ECC controls4-1-2and4-1-3, the CSP shall cover the folllowing additional subcontrols for third-party cybersecurity requirements, as a minimum",
                        "supplemental_guidance" => null,
                        "control_number" => "CCC 4-1-P-1",
                        "control_status" => "Not Implemented",
                        "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                        "control_owner" => "1",

                        "submission_date" => $currentDateTime,
                        "status" => "1",
                        "deleted" => "0",
                        "children" => [
                            [
                                "short_name" => "CCC 4-1-P-1-1",
                                "long_name" => "CCC 4-1-P-1-1",
                                "description" => "In addition to implementing the ECC controls4-1-2and4-1-3, the CSP shall cover the following additional subcontrols for third-party cybersecurity requirements, as a minimum:
                                    Ensure that the CSP fulfills NCA's requests to remove software or services,
                                    provided by third-party providers that may be considered a cybersecurity
                                    threat to national organizations, from the marketplace provided to CSTs..",
                                "control_number" => "CCC 4-1-P-1-1",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 4-1-P-1-2",
                                "long_name" => "CCC 4-1-P-1-2",
                                "description" => "In addition to implementing the ECC controls4-1-2and4-1-3, the CSP shall cover the following additional subcontrols for third-party cybersecurity requirements, as a minimum: Requirement to provide security documentation for any equipment or
                                services from suppliers and third-party providers.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 4-1-P-1-2",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 4-1-P-1-3",
                                "long_name" => "CCC 4-1-P-1-3",
                                "description" => "In addition to implementing the ECC controls4-1-2and4-1-3, the CSP shall cover the following additional subcontrols for third-party cybersecurity requirements, as a minimum: Third party providers compliant with law and regulatory requirements relevant to their scope.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 4-1-P-1-3",
                                "control_status" => "Not Implemented",
                                "family" => $this->getFamilyIdByName('Third-Party Cybersecurity'),
                                "control_owner" => "1",

                                "submission_date" => $currentDateTime,
                                "status" => "1",
                                "deleted" => "0",
                            ],
                            [
                                "short_name" => "CCC 4-1-P-1-4",
                                "long_name" => "CCC 4-1-P-1-4",
                                "description" => "In addition to implementing the ECC controls4-1-2and4-1-3, the CSP shall cover the following additional subcontrols for third-party cybersecurity requirements, as a minimum: Risk management and security governance on third-party providers as part
                                of general cybersecurity risk management and governance.",
                                "supplemental_guidance" => null,
                                "control_number" => "CCC 4-1-P-1-4",
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