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

class SAMASeeder extends Seeder
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
                'name' => 'SAMA',
                'description' => "SAMA established a Cyber Security Framework (“the Framework”) to enable Financial Institutions regulated by SAMA (“the Member Organizations”) to effectively identify and address risks related to cyber security. To maintain the protection of information assets and online services, the Member Organizations must adopt the Framework.",
                'icon' => 'fa-eye',
                'status' => '1',
                'regulator_id' => $this->regulatorId,
            ]);




            // Main domains with their subdomains
            $mainDomains = [
                [
                    'name' => 'Cyber Security Leadership and Governance',
                    'order' => '6',
                    'subdomains' => [
                        [
                            'name' => 'Cyber Security Governance',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Cyber Security Strategy',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Cyber Security Policy',
                            'order' => '3',
                        ],
                        [
                            'name' => 'Cyber Security Roles and Responsibilities',
                            'order' => '4',
                        ],
                        [
                            'name' => 'Cyber Security in Project Management',
                            'order' => '5',
                        ],
                        [
                            'name' => 'Cyber Security Awareness',
                            'order' => '6',
                        ],
                        [
                            'name' => 'Cyber Security Training',
                            'order' => '7',
                        ]
                    ]
                ],
                [
                    'name' => 'Cyber Security Risk Management and Compliance',
                    'order' => '7',
                    'subdomains' => [
                        [
                            'name' => 'Cyber Security Risk Management',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Regulatory Compliance',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Compliance with (inter)national industry standards',
                            'order' => '3',
                        ],
                        [
                            'name' => 'Cyber Security Review',
                            'order' => '4',
                        ],
                        [
                            'name' => 'Cyber Security Audits',
                            'order' => '5',
                        ]
                    ]
                ],
                [
                    'name' => 'Cyber Security Operations and Technology',
                    'order' => '8',
                    'subdomains' => [
                        [
                            'name' => 'Human Resources',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Physical Security',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Asset Management',
                            'order' => '3',
                        ],
                        [
                            'name' => 'Cyber Security Architecture',
                            'order' => '4',
                        ],
                        [
                            'name' => 'Identity and Access Management',
                            'order' => '5',
                        ],
                        [
                            'name' => 'Application Security',
                            'order' => '6',
                        ],
                        [
                            'name' => 'Change Management',
                            'order' => '7',
                        ],
                        [
                            'name' => 'Infrastructure Security',
                            'order' => '8',
                        ],
                        [
                            'name' => 'Cryptography',
                            'order' => '9',
                        ],
                        [
                            'name' => 'Bring Your Own Device (BYOD)',
                            'order' => '10',
                        ],
                        [
                            'name' => 'Secure Disposal of Information Assets',
                            'order' => '11',
                        ],
                        [
                            'name' => 'Payment Systems',
                            'order' => '12',
                        ],
                        [
                            'name' => 'Electronic Banking Services',
                            'order' => '13',
                        ],
                        [
                            'name' => 'Cyber Security Event Management',
                            'order' => '14',
                        ],
                        [
                            'name' => 'Cyber Security Incident Management',
                            'order' => '15',
                        ],
                        [
                            'name' => 'Threat Management',
                            'order' => '16',
                        ],
                        [
                            'name' => 'Vulnerability Management',
                            'order' => '17',
                        ]
                    ]
                ],
                [
                    'name' => 'Third Party Cyber Security',
                    'order' => '9',
                    'subdomains' => [
                        [
                            'name' => 'Contract and Vendor Management',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Outsourcing',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Cloud Computing',
                            'order' => '3',
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
                    "short_name" => "SAMA 3-1-1",
                    "long_name" => "SAMA 3-1-1",
                    "description" => "To direct and control the overall approach to cyber security within the Member Organization",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cyber Security Governance'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [

                    "short_name" => "SAMA 3-1-2",
                    "long_name" => "SAMA 3-1-2",
                    "description" => "To ensure that cyber security initiatives and projects within the Member Organization contribute to the\r\nMember Organization’s strategic objectives and are aligned with the Banking Sector’s cyber security\r\nstrategy.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cyber Security Strategy'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [

                    "short_name" => "SAMA 3-1-3",
                    "long_name" => "SAMA 3-1-3",
                    "description" => "To document the Member Organization’s commitment and objectives of cyber security, and to\r\ncommunicate this to the relevant stakeholders.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-1-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cyber Security Policy'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],


                [

                    "short_name" => "SAMA 3-1-4",
                    "long_name" => "SAMA 3-1-4",
                    "description" => "To ensure that relevant stakeholders are aware of the responsibilities with regard to cyber security and\r\napply cyber security controls throughout the Member Organization.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-1-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cyber Security Roles and Responsibilities'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [

                    "short_name" => "SAMA 3-1-5",
                    "long_name" => "SAMA 3-1-5",
                    "description" => "To ensure that the all the Member Organization’s projects meet cyber security requirements.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-1-5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cyber Security in Project Management'),

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [
                    "short_name" => "SAMA 3-1-6",
                    "long_name" => "SAMA 3-1-6",
                    "description" => "To create a cyber security risk-aware culture where the Member Organization’s staff, third parties and\r\ncustomers make effective risk-based decisions which protect the Member Organization’s information",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-1-6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cyber Security Awareness'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "SAMA 3-1-7",
                    "long_name" => "SAMA 3-1-7",
                    "description" => "To ensure that staff of the Member Organization are equipped with the skills and required knowledge to\r\nprotect the Member Organization’s information assets and to fulfil their cyber security responsibilities",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-1-7",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cyber Security Training'),

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [
                    "short_name" => "SAMA 3-2-1",
                    "long_name" => "SAMA 3-2-1",
                    "description" => "To ensure cyber security risks are properly managed to protect the confidentiality, integrity and\r\navailability of the Member Organization’s information assets, and to ensure the cyber security risk\r\nmanagement process is aligned with the Member Organization’s enterprise risk management process.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cyber Security Risk Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [

                            "short_name" => "SAMA 3-2-1-1",
                            "long_name" => "SAMA 3-2-1-1",
                            "description" => "Cyber Security Risk Identification :\r\n  To find, recognize and describe the Member Organization’s cyber security risks",
                            "supplemental_guidance" => null,
                            "control_number" => "SAMA 3-2-1-1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cyber Security Risk Management'),
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "SAMA 3-2-1-2",
                            "long_name" => "SAMA 3-2-1-2",
                            "description" => "Cyber Security Risk Analysis  => \r\nTo analyze and determine the nature and the level of the identified cyber security risks.",
                            "supplemental_guidance" => null,
                            "control_number" => "SAMA 3-2-1-2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cyber Security Risk Management'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "SAMA 3-2-1-3",
                            "long_name" => "SAMA 3-2-1-3",
                            "description" => "Cyber Security Risk Response  => \r\nTo ensure cyber security risks are treated (i.e., accepted, avoided, transferred or mitigated).",
                            "supplemental_guidance" => null,
                            "control_number" => "SAMA 3-2-1-3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cyber Security Risk Management'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                        [

                            "short_name" => "SAMA 3-2-1-4",
                            "long_name" => "SAMA 3-2-1-4",
                            "description" => "Cyber Risk Monitoring and Review  => To ensure that the cyber security risk treatment is performed according to the treatment plans. To ensure\r\nthat the revised or newly implemented cyber security controls are effective.",
                            "supplemental_guidance" => null,
                            "control_number" => "SAMA 3-2-1-4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cyber Security Risk Management'),

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",

                        ],
                    ],

                ],
                [
                    "short_name" => "SAMA 3-2-2",
                    "long_name" => "SAMA 3-2-2",
                    "description" => "To comply with regulations affecting cyber security of the Member Organization.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-2-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Regulatory Compliance'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [
                    "short_name" => "SAMA 3-2-3",
                    "long_name" => "SAMA 3-2-3",
                    "description" => "To comply with mandatory (inter)national industry standards",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-2-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Compliance with (inter)national industry standards'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",



                ],
                [
                    "short_name" => "SAMA 3-2-4",
                    "long_name" => "SAMA 3-2-4",
                    "description" => "To ascertain whether the cyber security controls are securely designed and implemented, and the\r\neffectiveness of these controls is being monitored.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-2-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cyber Security Review'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",



                ],

                [
                    "short_name" => "SAMA 3-2-5",
                    "long_name" => "SAMA 3-2-5",
                    "description" => "To ascertain with reasonable assurance whether the cyber security controls are securely designed and\r\nimplemented, and whether the effectiveness of these controls is being monitored",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-2-5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cyber Security Audits'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [
                    "short_name" => "SAMA 3-3-1",
                    "long_name" => "SAMA 3-3-1",
                    "description" => "To ensure that Member Organization staff’s cyber security responsibilities are embedded in staff\r\nagreements and staff are being screened before and during their employment lifecycle.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Human Resources'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "SAMA 3-3-2",
                    "long_name" => "SAMA 3-3-2",
                    "description" => "To prevent unauthorized physical access to the Member Organization information assets and to ensure its protection.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical Security'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [
                    "short_name" => "SAMA 3-3-3",
                    "long_name" => "SAMA 3-3-3",
                    "description" => "To support the Member Organization in having an accurate and up-to-date inventory and central insight\r\nin the physical \/ logical location and relevant details of all available information assets, in order to support\r\nits processes, such as financial, procurement, IT and cyber security processes",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "SAMA 3-3-4",
                    "long_name" => "SAMA 3-3-4",
                    "description" => "To support the Member Organization in achieving a strategic, consistent, cost effective and end-to-end\r\ncyber security architecture.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cyber Security Architecture'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",



                ],


                [
                    "short_name" => "SAMA 3-3-5",
                    "long_name" => "SAMA 3-3-5",
                    "description" => "To ensure that the Member Organization only provides authorized and sufficient access privileges to\r\napproved users",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity and Access Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [
                    "short_name" => "SAMA 3-3-6",
                    "long_name" => "SAMA 3-3-6",
                    "description" => "To ensure that sufficient cyber security controls are formally documented and implemented for all\r\napplications, and that the compliance is monitored and its effectiveness is evaluated periodically within\r\nthe Member Organization.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Application Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [
                    "short_name" => "SAMA 3-3-7",
                    "long_name" => "SAMA 3-3-7",
                    "description" => "To ensure that all change in the information assets within the Member Organization follow a strict change control process.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-7",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Change Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "SAMA 3-3-8",
                    "long_name" => "SAMA 3-3-8",
                    "description" => "To support that all cyber security controls within the infrastructure are formally documented and the\r\ncompliance is monitored and its effectiveness is evaluated periodically within the Member Organization",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-8",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Infrastructure Security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "SAMA 3-3-9",
                    "long_name" => "SAMA 3-3-9",
                    "description" => "To ensure that access to and integrity of sensitive information is protected and the originator of\r\ncommunication or transactions can be confirmed",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-9",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cryptography'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "SAMA 3-3-10",
                    "long_name" => "SAMA 3-3-10",
                    "description" => "To ensure that business and sensitive information of the Member Organization is securely handled by\r\nstaff and protected during transmission and storage, when using personal devices.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-10",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Bring Your Own Device (BYOD)'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "SAMA 3-3-11",
                    "long_name" => "SAMA 3-3-11",
                    "description" => "To ensure that the Member Organization’s business, customer and other sensitive information are\r\nprotected from leakage or unauthorized disclosure when disposed",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-11",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Secure Disposal of Information Assets'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "SAMA 3-3-12",
                    "long_name" => "SAMA 3-3-12",
                    "description" => "To ensure the Member Organization safeguards the confidentiality and integrity of shared banking\r\nsystems.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-12",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Payment Systems'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "SAMA 3-3-13",
                    "long_name" => "SAMA 3-3-13",
                    "description" => "To ensure the Member Organization safeguards the confidentiality and integrity of the customer\r\ninformation and transactions.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-13",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Electronic Banking Services'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "SAMA 3-3-14",
                    "long_name" => "SAMA 3-3-14",
                    "description" => "To ensure timely identification and response to anomalies or suspicious events within regard to\r\ninformation assets",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-14",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cyber Security Event Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "SAMA 3-3-15",
                    "long_name" => "SAMA 3-3-15",
                    "description" => "To ensure timely identification and handling of cyber security incidents in order to reduce the (potential)\r\nbusiness impact for the Member Organization.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-15",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cyber Security Incident Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "SAMA 3-3-16",
                    "long_name" => "SAMA 3-3-16",
                    "description" => "To obtain an adequate understanding of the Member Organization’s emerging threat posture.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-16",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Threat Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "SAMA 3-3-17",
                    "long_name" => "SAMA 3-3-17",
                    "description" => "To ensure timely identification and effective mitigation of application and infrastructure vulnerabilities in order to reduce the likelihood and business impact for the Member Organization.",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-3-17",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerability Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "SAMA 3-4-1",
                    "long_name" => "SAMA 3-4-1",
                    "description" => "To ensure that the Member Organization’s approved cyber security requirements are appropriately\r\naddressed before signing the contract, and the compliance with the cyber security requirements is being monitored and evaluated during the contract life-cycle",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-4-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Contract and Vendor Management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "SAMA 3-4-2",
                    "long_name" => "SAMA 3-4-2",
                    "description" => "To ensure that the Member Organization’s cyber security requirements are appropriately addressed\r\nbefore, during and while exiting outsourcing contracts",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-4-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Outsourcing'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "SAMA 3-4-3",
                    "long_name" => "SAMA 3-4-3",
                    "description" => "To ensure that all functions and staff within the Member Organization are aware of the agreed direction\r\nand position on hybrid and public cloud services, the required process to apply for hybrid and public cloud\r\nservices, the risk appetite on hybrid and public cloud services and the specific cyber security requirements\r\nfor hybrid and public cloud services",
                    "supplemental_guidance" => null,
                    "control_number" => "SAMA 3-4-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cloud Computing'),
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