<?php

namespace Database\Seeders;

use App\Models\DocumentTypes;
use App\Models\Family;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlMapping;
use App\Models\FrameworkControlTest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CmaSeeder extends Seeder
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
                    ['name' => 'Cybersecurity Policies'], // Attributes to search for
                );

                DocumentTypes::updateOrCreate(
                    ['name' => 'Cybersecurity Procedures'],
                );

                DocumentTypes::updateOrCreate(
                    ['name' => 'Cybersecurity Standards'],
                );

                DocumentTypes::updateOrCreate(
                    ['name' => 'Cyber​​security Strategy'],
                );
            }



            // Insert framework data
            $framework = Framework::create([
                'name' => 'Cma',
                'description' => 'Cybersecurity Guidelines for Capital Market Institutions (Hereinafter referred to as "the Guidelines") aims to define cybersecurity controls for market institutions that help in improving Cybersecurity risk management by adopting global best practices and local Cybersecurity legislations.',
                'icon' => 'fa-warning',
                'status' => '1',
                'regulator_id' => $this->regulatorId,
            ]);



            // Main domains with their subdomains
            $mainDomains = [
                [
                    'name' => 'Cybersecurity Governance',
                    'order' => '301', // Updated order value
                    'subdomains' => [
                        ['name' => 'Leadership and Responsibilities', 'order' => '304'],
                        ['name' => 'Data Governance and Security', 'order' => '305'],
                        ['name' => 'Strategy and Policies', 'order' => '307'],
                        ['name' => 'Training and Awareness', 'order' => '309'],
                        ['name' => 'Human Resources Cybersecurity', 'order' => '311'],
                    ]
                ],
                [
                    'name' => 'Cybersecurity Risk Management, Review and Audit',
                    'order' => '302', // Updated order value
                    'subdomains' => [
                        ['name' => 'Cybersecurity Risk Management', 'order' => '301'],
                        ['name' => 'Cybersecurity Review And Audit', 'order' => '302'],
                    ]
                ],
                [
                    'name' => 'Operational Cybersecurity Controls',
                    'order' => '303', // Updated order value
                    'subdomains' => [
                        ['name' => 'Cybersecurity Architecture', 'order' => '310'],
                        ['name' => 'Infrastructure Security', 'order' => '311'],
                        ['name' => 'Change Management and Project Management', 'order' => '312'],
                        ['name' => 'Identity And Access Management', 'order' => '313'],
                        ['name' => 'Information and Technical Assets Management', 'order' => '314'],
                        ['name' => 'Safe Destroying', 'order' => '315'],
                        ['name' => 'Cybersecurity Incidents Management', 'order' => '316'],
                        ['name' => 'Cybersecurity Event Logs Management', 'order' => '317'],
                        ['name' => 'Cybersecurity Threat Management', 'order' => '318'],
                        ['name' => 'Applications Protection', 'order' => '319'],
                        ['name' => 'Encryption', 'order' => '320'],
                        ['name' => 'Vulnerability Management', 'order' => '321'],
                        ['name' => 'Online Trading Services', 'order' => '322'],
                        ['name' => 'Physical Security', 'order' => '323'],
                        ['name' => 'Business Continuity Management', 'order' => '324'],
                        ['name' => 'Use of BYOD', 'order' => '325'],
                    ]
                ],
                [
                    'name' => 'Third Party Cybersecurity',
                    'order' => '304', // Updated order value
                    'subdomains' => [
                        ['name' => 'Contracts and Suppliers Management', 'order' => '330'],
                        ['name' => 'Outsourcing', 'order' => '331'],
                        ['name' => 'Cloud Computing', 'order' => '332'],
                    ]
                ]
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

                // Attach the main domain to the framework with parent_family_id
                $framework->families()->attach($domain->id, ['parent_family_id' => $domain->parent_id]);

                // Attach the subdomains to the framework with parent_family_id
                foreach ($subDomainFamilies as $subDomainId => $parentId) {
                    $framework->families()->attach($subDomainId, ['parent_family_id' => $parentId]);
                }
            }




            $frameworkControls = [

                [

                    "short_name" => "4.1.1.1",
                    "long_name" => "4.1.1.1",
                    "description" => "Establish a cybersecurity department separated from IT department , with taking the non-conflict of interest principle into the consideration.",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.1.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],

                [

                    "short_name" => "4.1.1.2",
                    "long_name" => "4.1.1.2",
                    "description" => "Cybersecurity Department shall be headed by a full-time, qualified Saudi employee and shall be referred as Head of Cybersecurity Department",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.1.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],


                [

                    "short_name" => "4.1.1.3",
                    "long_name" => "4.1.1.3",
                    "description" => "Allocate and approve an adequate budget to implement the cybersecurity tasks and functions by the market instition's BOD",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.1.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [

                    "short_name" => "4.1.1.4",
                    "long_name" => "4.1.1.4",
                    "description" => "Review cybersecurity roles and responsibilities periodically or in case of changes",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.1.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [

                    "short_name" => "4.1.1.5",
                    "long_name" => "4.1.1.5",
                    "description" => "Form a cybersecurity committee associated with CEO of the entity or his representative, with taking the non-conflict of interest principle into the consideratio",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.1.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [

                    "short_name" => "4.1.1.6",
                    "long_name" => "4.1.1.6",
                    "description" => "Cybersecurity Committee shall comprise of Head of Cybersecurity department and Heads of relevant departments.",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.1.6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],


                [

                    "short_name" => "4.1.1.7",
                    "long_name" => "4.1.1.7",
                    "description" => "Regulations of Cybersecurity Committee shall be prepared, documented and approved by an authorized person who clarify relevant objectives, roles and responsibilities.",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.1.7",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [

                    "short_name" => "4.1.1.8",
                    "long_name" => "4.1.1.8",
                    "description" => "Responsibilities of cybersecurity committee include",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.1.8",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.1.1.8.1",
                            "long_name" => "4.1.1.8.1",
                            "description" => "Monitor, review and report market institution’s cybersecurity risks appetite periodically or in case of substantial change regarding risk appetite",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.8.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.1.8.2",
                            "long_name" => "4.1.1.8.2",
                            "description" => "Periodic review of cybersecurity strategy to ensure being in support of the market institution's objectives",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.8.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.1.8.3",
                            "long_name" => "4.1.1.8.3",
                            "description" => "Adopt and provide necessary support and oversight on: Cybersecurity Governance; Cybersecurity Strategy; Cybersecurity Policies; Cybersecurity Programs (such as awareness programs, data classification program, data privacy and data breach prevention); Cybersecurity Risk Management; and Cybersecurity Key Risk Indicators and KPIs",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.8.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ],

                ],
                [

                    "short_name" => "4.1.1.9",
                    "long_name" => "4.1.1.9",
                    "description" => "Responsibilities of Market Institution’s BOD include, in addition to the above-mentioned ,the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.1.9",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.1.1.9.1",
                            "long_name" => "4.1.1.9.1",
                            "description" => "Ensure that standards and procedures reflect cybersecurity requirements",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.9.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.1.9.2",
                            "long_name" => "4.1.1.9.2",
                            "description" => "Ensure that staff accept and comply with cybersecurity policies, and support standards and procedures when issuing and updating the same;",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.9.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.1.9.3",
                            "long_name" => "4.1.1.9.3",
                            "description" => "Ensure that cybersecurity responsibilities are included in job descriptions of relevant positions and cybersecurity positions",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.9.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ],

                ],
                [

                    "short_name" => "4.1.1.10",
                    "long_name" => "4.1.1.10",
                    "description" => "Periodic review of cybersecurity strategy to ensure being in support of the market institution's objectives",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.1.10",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.1.1.10.1",
                            "long_name" => "4.1.1.10.1",
                            "description" => "Submit to cybersecurity committee any development and update of: Cybersecurity Strategy; Cybersecurity Policies; Cybersecurity Structure; and Cybersecurity Risk Management.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.10.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.1.10.2",
                            "long_name" => "4.1.1.10.2",
                            "description" => "Ensure that cybersecurity standards and procedures are identified, documented, approved and implemented",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.10.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.1.10.3",
                            "long_name" => "4.1.1.10.3",
                            "description" => "Ensure development and training of cybersecurity personnel;",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.10.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.1.10.4",
                            "long_name" => "4.1.1.10.4",
                            "description" => "Monitor cybersecurity activities (Monitor Security Operations Center)",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.10.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.1.10.5",
                            "long_name" => "4.1.1.10.5",
                            "description" => "Monitor compliance with cybersecurity policies, standards and procedures",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.10.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.1.10.6",
                            "long_name" => "4.1.1.10.6",
                            "description" => "Oversee investigation of cybersecurity incidents",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.10.6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.1.10.7",
                            "long_name" => "4.1.1.10.7",
                            "description" => "Obtain and deal with proactive information (Threat Intelligence)",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.10.7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.1.10.8",
                            "long_name" => "4.1.1.10.8",
                            "description" => "Review and audit cybersecurity program",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.10.8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.1.10.9",
                            "long_name" => "4.1.1.10.9",
                            "description" => "Effective support for other cybersecurity-related positions, including: Classifying systems and information; Defining cybersecurity controls for important projects; and Reviewing cybersecurity controls",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.10.9",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.1.10.10",
                            "long_name" => "4.1.1.10.10",
                            "description" => "Develop and implement cybersecurity awareness programs",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.10.10",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID
                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.1.10.11",
                            "long_name" => "4.1.1.10.11",
                            "description" => "Measure and report key risk indicators and KPIs on: Cybersecurity strategy; Compliance with cybersecurity policies; Cybersecurity standards and procedures; and Cybersecurity programs (Such as awareness programs and data classification program)",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.10.11",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",

                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.1.10.12",
                            "long_name" => "4.1.1.10.12",
                            "description" => "non-conflict of interest principle into the consideration. All market institution's personnel are responsible for complying with cybersecurity policies, standards and procedures",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.1.10.12",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Leadership and Responsibilities'), // Dynamically get family ID

                            "control_owner" => "1",
                            "submission_date" => $currentDateTime,
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]

                ],

                [
                    "short_name" => "4.1.2.1",
                    "long_name" => "4.1.2.1",
                    "description" => "Develop and design Data Governance Program",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.2.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data Governance and Security'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "4.1.2.3",
                    "long_name" => "4.1.2.3",
                    "description" => "Identify sensitive data elements within data fields.",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.2.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data Governance and Security'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],

                [
                    "short_name" => "4.1.2.4",
                    "long_name" => "4.1.2.4",
                    "description" => "Determine classification and mechanism of data encoding according to level of importance	",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.2.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data Governance and Security'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.2.5",
                    "long_name" => "4.1.2.5",
                    "description" => "Identify privacy of data and information",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.2.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data Governance and Security'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.2.6",
                    "long_name" => "4.1.2.6",
                    "description" => "Create centralized platform for managing and controlling changes and providing access to sensitive data assets.",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.2.6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data Governance and Security'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.2.7",
                    "long_name" => "4.1.2.7",
                    "description" => "Specify mechanism to measure level of data protection.",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.2.7",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data Governance and Security'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.2.8",
                    "long_name" => "4.1.2.8",
                    "description" => "Identify and implement workflow plans of governance structure and key data elements and fields.",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.2.8",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data Governance and Security'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],

                [
                    "short_name" => "4.1.2.9",
                    "long_name" => "4.1.2.9",
                    "description" => "Observe, monitor, and report workflow procedures.",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.2.9",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data Governance and Security'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.3.1",
                    "long_name" => "4.1.3.1",
                    "description" => "Set out, document, implement, approve and periodically update cybersecurity strategy",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.3.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.3.2",
                    "long_name" => "4.1.3.2",
                    "description" => "The cybersecurity strategy shall be aligned with the overall objectives of market institution and any related regulatory requirements",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.3.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.3.3",
                    "long_name" => "4.1.3.3",
                    "description" => "Cybersecurity strategy shall include the following",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.3.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID

                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.1.3.3.1",
                            "long_name" => "4.1.3.3.1",
                            "description" => "Importance of cybersecurity for the market institutions...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.3.3.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.3.3.2",
                            "long_name" => "4.1.3.3.2",
                            "description" => "The expected cybersecurity state of market institutions...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.3.3.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.2.3.3",
                            "long_name" => "4.1.2.3.3",
                            "description" => "Develop a time plan to implement cybersecurity initiatives...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.2.3.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]
                ],
                [
                    "short_name" => "4.1.3.4",
                    "long_name" => "4.1.3.4",
                    "description" => "Set out, document, implement, and approve cybersecurity...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.3.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.3.5",
                    "long_name" => "4.1.3.5",
                    "description" => "Review cybersecurity policies periodically in accordance...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.3.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.3.6",
                    "long_name" => "4.1.3.6",
                    "description" => "Support cybersecurity policies with detailed security...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.3.6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.3.7",
                    "long_name" => "4.1.3.7",
                    "description" => "Cybersecurity policies shall include the following...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.3.7",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.1.3.7.1",
                            "long_name" => "4.1.3.7.1",
                            "description" => "Definition of Cybersecurity.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.3.7.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.3.7.2",
                            "long_name" => "4.1.3.7.2",
                            "description" => "The scope and objectives of the capital market institutions...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.3.7.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.3.7.3",
                            "long_name" => "4.1.3.7.3",
                            "description" => "Support of senior management to cybersecurity program...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.3.7.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.3.7.4",
                            "long_name" => "4.1.3.7.4",
                            "description" => "Identification of cybersecurity responsibilities...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.3.7.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.3.7.5",
                            "long_name" => "4.1.3.7.5",
                            "description" => "Indication of the reference of applicable cybersecurity...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.3.7.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.3.7.6",
                            "long_name" => "4.1.3.7.6",
                            "description" => "Cybersecurity controls shall include the following...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.3.7.6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Strategy and Policies'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ],
                ],
                [
                    "short_name" => "4.1.4.1",
                    "long_name" => "4.1.4.1",
                    "description" => "Develop, approve, document, and implement a Cybersecurity...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.4.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness Program'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.4.2",
                    "long_name" => "4.1.4.2",
                    "description" => "The Cybersecurity Awareness Program aims to provide...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.4.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness Program'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.4.3",
                    "long_name" => "4.1.4.3",
                    "description" => "Cybersecurity Awareness Program shall be launched...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.4.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness Program'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.4.4",
                    "long_name" => "4.1.4.4",
                    "description" => "Cybersecurity and Awareness Program includes protection...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.4.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness Program'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.1.4.4.1",
                            "long_name" => "4.1.4.4.1",
                            "description" => "Cybersecurity roles and responsibilities.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.4.4.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness Program'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.4.4.2",
                            "long_name" => "4.1.4.4.2",
                            "description" => "Information about cybersecurity incidents and threats...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.4.4.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness Program'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.4.4.3",
                            "long_name" => "4.1.4.4.3",
                            "description" => "Secure handling of mobile devices and storage media...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.4.4.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness Program'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.4.4.4",
                            "long_name" => "4.1.4.4.4",
                            "description" => "Secure browsing of internet.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.4.4.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness Program'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.4.4.4",
                            "long_name" => "4.1.4.4.4",
                            "description" => "Safe use of social media.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.4.4.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Awareness Program'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ]
                    ]
                ],

                [
                    "short_name" => "4.1.4.5",
                    "long_name" => "4.1.4.5",
                    "description" => "Evaluate Cybersecurity Awareness Program to measure...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.4.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness Program'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.4.6",
                    "long_name" => "4.1.4.6",
                    "description" => "Provide specialized training to cybersecurity personnel...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.4.6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Awareness Program'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.5.1",
                    "long_name" => "4.1.5.1",
                    "description" => "Set out, document, implement and approve Cybersecurity...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.5.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Operations'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.5.2",
                    "long_name" => "4.1.5.2",
                    "description" => "Monitor effectiveness of cybersecurity controls re...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.5.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Operations'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.1.5.3",
                    "long_name" => "4.1.5.3",
                    "description" => "HR cybersecurity controls shall include the following...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.1.5.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Human Resources Cybersecurity'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.1.5.3.1",
                            "long_name" => "4.1.5.3.1",
                            "description" => "Cybersecurity Responsibilities and Non-Disclosure...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.5.3.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Human Resources Cybersecurity'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.5.3.2",
                            "long_name" => "4.1.5.3.2",
                            "description" => "Conduct a cybersecurity awareness at the beginning...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.5.3.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Human Resources Cybersecurity'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.5.3.3",
                            "long_name" => "4.1.5.3.3",
                            "description" => "Applicability of disciplinary measures.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.5.3.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Human Resources Cybersecurity'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.5.3.4",
                            "long_name" => "4.1.5.3.4",
                            "description" => "Security screening of staff by entities authorized...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.5.3.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Human Resources Cybersecurity'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.1.5.3.5",
                            "long_name" => "4.1.5.3.5",
                            "description" => "Requirements for cybersecurity controls after ending...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.1.5.3.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Human Resources Cybersecurity'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.2.1.1",
                    "long_name" => "4.2.1.1",
                    "description" => "Set up, document, approve, implement and periodically review cybersecurity risk management policies and processes.",
                    "supplemental_guidance" => null,
                    "control_number" => "4.2.1.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.2.1.2",
                    "long_name" => "4.2.1.2",
                    "description" => "Cybersecurity risk management methodology aims to assess and manage risks.",
                    "supplemental_guidance" => null,
                    "control_number" => "4.2.1.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.2.1.3",
                    "long_name" => "4.2.1.3",
                    "description" => "Cybersecurity risk management methodology shall be...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.2.1.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.2.1.4",
                    "long_name" => "4.2.1.4",
                    "description" => "Document Cybersecurity risk management methodology...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.2.1.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.2.1.5",
                    "long_name" => "4.2.1.5",
                    "description" => "Cybersecurity risk management methodology includes...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.2.1.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.2.1.6",
                    "long_name" => "4.2.1.6",
                    "description" => "Apply cybersecurity risk assessment procedures in...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.2.1.6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.2.1.6.1",
                            "long_name" => "4.2.1.6.1",
                            "description" => "Early stage of the project.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.2.1.6.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.2.1.6.2",
                            "long_name" => "4.2.1.6.2",
                            "description" => "Before making any material change in technology in...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.2.1.6.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.2.1.6.3",
                            "long_name" => "4.2.1.6.3",
                            "description" => "Before obtaining third party’s services.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.2.1.6.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.2.1.6.4",
                            "long_name" => "4.2.1.6.4",
                            "description" => "Before launching new products and technologies.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.2.1.6.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.2.1.7",
                    "long_name" => "4.2.1.7",
                    "description" => "Set out and document cybersecurity risks in unifie...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.2.1.7",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.2.1.8",
                    "long_name" => "4.2.1.8",
                    "description" => "Document options list of risk processing (i.e. acc...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.2.1.8",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.2.1.9",
                    "long_name" => "4.2.1.9",
                    "description" => "Give highest priority to and closely monitor highe...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.2.1.9",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.2.2.1",
                    "long_name" => "4.2.2.1",
                    "description" => "Perform review and audit for cybersecurity control...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.2.2.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.2.2.2",
                    "long_name" => "4.2.2.2",
                    "description" => "Document results and remarks of review and recomme...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.2.2.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.2.2.3",
                    "long_name" => "4.2.2.3",
                    "description" => "Perform Cybersecurity audit by parties independent...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.2.2.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.2.2.4",
                    "long_name" => "4.2.2.4",
                    "description" => "Review application of cybersecurity controls in ac...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.2.2.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Risk Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.1.1",
                    "long_name" => "4.3.1.1",
                    "description" => "Set out, document, approve, implement and monitor ...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.1.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Architecture'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.1.2",
                    "long_name" => "4.3.1.2",
                    "description" => "Cybersecurity Architecture shall include the follo...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.1.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Architecture'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.1.2.1",
                    "long_name" => "4.3.1.2.1",
                    "description" => "Strategic planning and setting out cybersecurity c...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.1.2.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Architecture'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.1.2.2",
                    "long_name" => "4.3.1.2.2",
                    "description" => "Following necessary design principles in order to ...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.1.2.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Architecture'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.1.2.3",
                    "long_name" => "4.3.1.2.3",
                    "description" => "Review Cybersecurity Architecture periodically.",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.1.2.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Architecture'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.2.1",
                    "long_name" => "4.3.2.1",
                    "description" => "Set out, document, approve, implement and monitor ...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.2.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.2.2",
                    "long_name" => "4.3.2.2",
                    "description" => "Infrastructure cybersecurity controls include main...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.2.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.2.3",
                    "long_name" => "4.3.2.3",
                    "description" => "Infrastructure cybersecurity controls shall cover ...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.2.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.2.4",
                    "long_name" => "4.3.2.4",
                    "description" => "E-mail cybersecurity controls include the followin...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.2.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.2.4.1",
                            "long_name" => "4.3.2.4.1",
                            "description" => "Anti-spam Filtering.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.4.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "0",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.4.2",
                            "long_name" => "4.3.2.4.2",
                            "description" => "Multi-Factor Authentication for remote and webmail...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.4.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.4.3",
                            "long_name" => "4.3.2.4.3",
                            "description" => "Email archiving and backup.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.4.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.4.4",
                            "long_name" => "4.3.2.4.4",
                            "description" => "Validation of email service domains in technological...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.4.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.2.5",
                    "long_name" => "4.3.2.5",
                    "description" => "Infrastructure Cybersecurity Controls include:",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.2.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "0",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.2.5.1",
                            "long_name" => "4.3.2.5.1",
                            "description" => "Implementing cybersecurity controls (e.g. monitoring...)",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.5.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.5.2",
                            "long_name" => "4.3.2.5.2",
                            "description" => "Separation of duties principle (supported by approval...)",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.5.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.5.3",
                            "long_name" => "4.3.2.5.3",
                            "description" => "Separation of duties principle (supported by approval...)",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.5.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.5.4",
                            "long_name" => "4.3.2.5.4",
                            "description" => "Use genuine and licensed programs and safe IPs.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.5.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.5.5",
                            "long_name" => "4.3.2.5.5",
                            "description" => "Logical or physical segregation and segmentation of...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.5.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.5.6",
                            "long_name" => "4.3.2.5.6",
                            "description" => "Protection against malware and viruses (allow a li...)",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.5.6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.5.7",
                            "long_name" => "4.3.2.5.7",
                            "description" => "Management of update packages and patching of vulnerabilities.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.5.7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.5.8",
                            "long_name" => "4.3.2.5.8",
                            "description" => "Protection against DDOS including: Use of Scrubbi...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.5.8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.5.9",
                            "long_name" => "4.3.2.5.9",
                            "description" => "Secure browsing and internet connectivity including...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.5.9",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.5.10",
                            "long_name" => "4.3.2.5.10",
                            "description" => "DNS security.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.5.10",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.5.11",
                            "long_name" => "4.3.2.5.11",
                            "description" => "Clock Synchronization with an accurate and trusted...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.5.11",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.5.12",
                            "long_name" => "4.3.2.5.12",
                            "description" => "Conduct data backup and recovery.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.5.12",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.5.13",
                            "long_name" => "4.3.2.5.13",
                            "description" => "Restricted use of external storage media.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.5.13",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.2.5.14",
                            "long_name" => "4.3.2.5.14",
                            "description" => "Review compliance with Cybersecurity controls periodically.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.2.5.14",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Infrastructure Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.3.1",
                    "long_name" => "4.3.3.1",
                    "description" => "Set out, document, approve, implement, monitor and...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.3.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Change Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.3.2",
                    "long_name" => "4.3.3.2",
                    "description" => "Change management methodology and procedures shall...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.3.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Change Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.3.2.1",
                            "long_name" => "4.3.3.2.1",
                            "description" => "Cybersecurity controls to manage emergency changes...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.3.2.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Change Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.3.2.2",
                            "long_name" => "4.3.3.2.2",
                            "description" => "Security testing, which shall include: Penetration...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.3.2.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Change Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.3.2.3",
                            "long_name" => "4.3.3.2.3",
                            "description" => "Changes shall be approved by the authorized person...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.3.2.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Change Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.3.2.4",
                            "long_name" => "4.3.3.2.4",
                            "description" => "The approval of Cybersecurity Department on the ma...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.3.2.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Change Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.3.2.5",
                            "long_name" => "4.3.3.2.5",
                            "description" => "Review how far the change is acceptable after impl...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.3.2.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Change Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.3.2.6",
                            "long_name" => "4.3.3.2.6",
                            "description" => "Segregation of duties.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.3.2.6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Change Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.3.2.7",
                            "long_name" => "4.3.3.2.7",
                            "description" => "Segregate of production environment from developme...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.3.2.7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Change Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.3.2.8",
                            "long_name" => "4.3.3.2.8",
                            "description" => "Conduct emergency changes and repairs.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.3.2.8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Change Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.3.2.9",
                            "long_name" => "4.3.3.2.9",
                            "description" => "Fallback and Rollback.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.3.2.9",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Change Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.3.3",
                    "long_name" => "4.3.3.3",
                    "description" => "Set out, document, approve, implement, monitor and...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.3.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Change Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.3.4",
                    "long_name" => "4.3.3.4",
                    "description" => "Project management methodology shall include cyber...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.3.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Change Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.3.5",
                    "long_name" => "4.3.3.5",
                    "description" => "Project management methodology shall include the f...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.3.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Change Management and Project Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.3.5.1",
                            "long_name" => "4.3.3.5.1",
                            "description" => "Include cybersecurity objectives within the projec...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.3.5.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Change Management and Project Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.3.5.2",
                            "long_name" => "4.3.3.5.2",
                            "description" => "Consider cybersecurity management as a part of pro...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.3.5.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Change Management and Project Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.3.5.3",
                            "long_name" => "4.3.3.5.3",
                            "description" => "Assess risks at the beginning of project in order ...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.3.5.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Change Management and Project Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.3.5.4",
                            "long_name" => "4.3.3.5.4",
                            "description" => "Document Cybersecurity risks in project risk recor...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.3.5.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Change Management and Project Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.3.5.5",
                            "long_name" => "4.3.3.5.5",
                            "description" => "Identify and assign cybersecurity responsibilities...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.3.5.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Change Management and Project Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.3.5.6",
                            "long_name" => "4.3.3.5.6",
                            "description" => "Review cybersecurity by an independent internal or...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.3.5.6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Change Management and Project Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.3.6",
                    "long_name" => "4.3.3.6",
                    "description" => "Project and change management methodology includes...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.3.6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Change Management and Project Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.4.1",
                    "long_name" => "4.3.4.1",
                    "description" => "Set out, document, approve, implement and monitor ...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.4.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity And Access Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.4.2",
                    "long_name" => "4.3.4.2",
                    "description" => "Measure and periodically evaluate effectiveness of...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.4.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity And Access Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.4.3",
                    "long_name" => "4.3.4.3",
                    "description" => "Access Identity And Access Management policy s...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.4.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity And Access Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.4.3.1",
                            "long_name" => "4.3.4.3.1",
                            "description" => "Access control according to work requirements (pri...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.4.3.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity And Access Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.4.3.2",
                            "long_name" => "4.3.4.3.2",
                            "description" => "Users Access Management. Covering all users (empl...)",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.4.3.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity And Access Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.4.3.3",
                            "long_name" => "4.3.4.3.3",
                            "description" => "User Access Management shall be automated",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.4.3.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity And Access Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.4.3.4",
                            "long_name" => "4.3.4.3.4",
                            "description" => "Provide uniform systems for access identity and pr...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.4.3.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity And Access Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.4.3.5",
                            "long_name" => "4.3.4.3.5",
                            "description" => "Multi-Factor Authentication for access to sensitiv...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.4.3.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity And Access Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.4.3.6",
                            "long_name" => "4.3.4.3.6",
                            "description" => "Management controls of high and sensitive privileg...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.4.3.6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Identity And Access Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.5.1",
                    "long_name" => "4.3.5.1",
                    "description" => "Set out, document, approve, implement, monitor and...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.5.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Access Control'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.5.2",
                    "long_name" => "4.3.5.2",
                    "description" => "Information and technology asset management includ...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.5.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.5.2.1",
                            "long_name" => "4.3.5.2.1",
                            "description" => "Unified record including information and technolog...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.5.2.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Asset Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.5.2.2",
                            "long_name" => "4.3.5.2.2",
                            "description" => "Ownership of Information and technology assets.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.5.2.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Asset Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.5.2.3",
                            "long_name" => "4.3.5.2.3",
                            "description" => "Classification, labeling and handling of informati...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.5.2.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Asset Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.5.2.4",
                            "long_name" => "4.3.5.2.4",
                            "description" => "Maintaining backup of assets records and keeping t...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.5.2.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Asset Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.5.3",
                    "long_name" => "4.3.5.3",
                    "description" => "Set out, document, approve, implement, circulate a...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.5.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Asset Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.6.1",
                    "long_name" => "4.3.6.1",
                    "description" => "Set out, document, approve and implement safe disp...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.6.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Disposal Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.6.2",
                    "long_name" => "4.3.6.2",
                    "description" => "Safe disposal standards cover digital and hard cop...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.6.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Disposal Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.6.3",
                    "long_name" => "4.3.6.3",
                    "description" => "Monitor compliance with safe disposal standards an...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.6.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Disposal Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.6.4",
                    "long_name" => "4.3.6.4",
                    "description" => "Measure and periodically evaluate effectiveness of...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.6.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Disposal Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.6.5",
                    "long_name" => "4.3.6.5",
                    "description" => "Dispose of information assets when they are no lon...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.6.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Disposal Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.6.6",
                    "long_name" => "4.3.6.6",
                    "description" => "Destroy sensitive information using certain techno...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.6.6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Disposal Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.6.7",
                    "long_name" => "4.3.6.7",
                    "description" => "Ensure that third-party service providers comply w...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.6.7",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Disposal Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.7.1",
                    "long_name" => "4.3.7.1",
                    "description" => "Develop, document, approve and implement cybersecu...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.7.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.7.2",
                    "long_name" => "4.3.7.2",
                    "description" => "Disaster recovery plan includes different scenario...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.7.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.7.3",
                    "long_name" => "4.3.7.3",
                    "description" => "Measure and periodically evaluate effectiveness of...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.7.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.7.4",
                    "long_name" => "4.3.7.4",
                    "description" => "Cybersecurity incident management controls shall i...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.7.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.7.4.1",
                            "long_name" => "4.3.7.4.1",
                            "description" => "A team in charge of cybersecurity incident managem...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.4.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.4.2",
                            "long_name" => "4.3.7.4.2",
                            "description" => "Provision of well-qualified employees and trainers...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.4.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.4.3",
                            "long_name" => "4.3.7.4.3",
                            "description" => "Restricted area for Cybersecurity Emergency Respon...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.4.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.4.4",
                            "long_name" => "4.3.7.4.4",
                            "description" => "Setting response plan for security incidents and e...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.4.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.4.5",
                            "long_name" => "4.3.7.4.5",
                            "description" => "Classifying of Cybersecurity incidents.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.4.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.4.6",
                            "long_name" => "4.3.7.4.6",
                            "description" => "Addressing Cybersecurity incidents in a timely man...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.4.6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.4.7",
                            "long_name" => "4.3.7.4.7",
                            "description" => "Protecting related evidence and records.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.4.7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.4.8",
                            "long_name" => "4.3.7.4.8",
                            "description" => "Criminal analysis of cybersecurity incidents.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.4.8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.4.9",
                            "long_name" => "4.3.7.4.9",
                            "description" => "Maintaining cybersecurity incidents record",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.4.9",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.7.5",
                    "long_name" => "4.3.7.5",
                    "description" => "Coordinating with CMA before any media action conc...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.7.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.7.6",
                    "long_name" => "4.3.7.6",
                    "description" => "Report National Cybersecurity Authority of CMA imm...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.7.6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.7.7",
                    "long_name" => "4.3.7.7",
                    "description" => "Provide official report on security incident to CM...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.7.7",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.7.7.1",
                            "long_name" => "4.3.7.7.1",
                            "description" => "Name of Cybersecurity incident.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.7.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.7.2",
                            "long_name" => "4.3.7.7.2",
                            "description" => "Classification of Cybersecurity incident (mild or ...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.7.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.7.3",
                            "long_name" => "4.3.7.7.3",
                            "description" => "Date and time of Cybersecurity incident.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.7.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.7.4",
                            "long_name" => "4.3.7.7.4",
                            "description" => "Date and time when the Cybersecurity incident is d...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.7.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.7.5",
                            "long_name" => "4.3.7.7.5",
                            "description" => "Information assets affected.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.7.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.7.6",
                            "long_name" => "4.3.7.7.6",
                            "description" => "Technical details of Cybersecurity incident.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.7.6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.7.7",
                            "long_name" => "4.3.7.7.7",
                            "description" => "Analysis of reasons and motivations.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.7.7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.7.8",
                            "long_name" => "4.3.7.7.8",
                            "description" => "Analysis of reasons and motivations.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.7.8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.7.9",
                            "long_name" => "4.3.7.7.9",
                            "description" => "Description of damage caused (e.g. data loss, serv...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.7.9",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.7.10",
                            "long_name" => "4.3.7.7.10",
                            "description" => "Total cost estimated for the Cybersecurity inciden...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.7.10",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.7.11",
                            "long_name" => "4.3.7.7.11",
                            "description" => "Estimated cost for corrective procedures.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.7.11",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.7.7.12",
                            "long_name" => "4.3.7.7.12",
                            "description" => "The report shall be sent to following mail: Cyber....",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.7.7.12",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.8.1",
                    "long_name" => "4.3.8.1",
                    "description" => "Define, document, approve and implement security e...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.8.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.8.2",
                    "long_name" => "4.3.8.2",
                    "description" => "assure and periodically evaluate the effectiveness...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.8.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.8.3",
                    "long_name" => "4.3.8.3",
                    "description" => "Define, document, approve and implement control st...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.8.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.8.4",
                    "long_name" => "4.3.8.4",
                    "description" => "Identify event standards to be monitored based on ...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.8.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.8.5",
                    "long_name" => "4.3.8.5",
                    "description" => "Monitor cybersecurity event logs for accounts with...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.8.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.8.6",
                    "long_name" => "4.3.8.6",
                    "description" => "Retention period for cybersecurity event logs must...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.8.6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.8.7",
                    "long_name" => "4.3.8.7",
                    "description" => "Event logs management shall include the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.8.7",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.8.7.1",
                            "long_name" => "4.3.8.7.1",
                            "description" => "Form a teamwork in charge of security control (Sec...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.7.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.8.7.2",
                            "long_name" => "4.3.8.7.2",
                            "description" => "Well-trained and qualified citizen employees.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.7.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.8.7.3",
                            "long_name" => "4.3.8.7.3",
                            "description" => "A restricted area dedicated for SOC related activi...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.7.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.8.7.4",
                            "long_name" => "4.3.8.7.4",
                            "description" => "Resources required for constant monitor of securit...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.7.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.8.7.5",
                            "long_name" => "4.3.8.7.5",
                            "description" => "Retrieving the source code and detecting malware.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.7.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.8.7.6",
                            "long_name" => "4.3.8.7.6",
                            "description" => "Detecting suspicious security events and addressin...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.7.6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.8.7.7",
                            "long_name" => "4.3.8.7.7",
                            "description" => "Using solutions to analyze network packages.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.7.7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.8.7.8",
                            "long_name" => "4.3.8.7.8",
                            "description" => "Protecting cybersecurity event records.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.7.8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.8.7.9",
                            "long_name" => "4.3.8.7.9",
                            "description" => "Periodical monitoring of compliance with cybersecu...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.7.9",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.8.7.10",
                            "long_name" => "4.3.8.7.10",
                            "description" => "Using automated and central analysis of security l...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.7.10",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.8.7.11",
                            "long_name" => "4.3.8.7.11",
                            "description" => "Reporting cybersecurity incidents.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.7.11",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.8.7.12",
                            "long_name" => "4.3.8.7.12",
                            "description" => "Conducting a periodic and independent test to veri...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.7.12",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.8.8",
                    "long_name" => "4.3.8.8",
                    "description" => "In case of any major cybersecurity incident:",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.8.8",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.8.8.1",
                            "long_name" => "4.3.8.8.1",
                            "description" => "A crisis management team comprising an employee of...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.8.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.8.8.2",
                            "long_name" => "4.3.8.8.2",
                            "description" => "Disclosure of cybersecurity incidents shall be mad...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.8.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.8.8.3",
                            "long_name" => "4.3.8.8.3",
                            "description" => "An improvement and development plan shall be devel...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.8.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.8.8.4",
                            "long_name" => "4.3.8.8.4",
                            "description" => "Ensure that the incident has ended with all suppor...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.8.8.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.9.1",
                    "long_name" => "4.3.9.1",
                    "description" => "Define, document, approve and implement Cybersecur...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.9.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.9.2",
                    "long_name" => "4.3.9.2",
                    "description" => "Periodically measure and evaluate effectiveness of...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.9.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.9.3",
                    "long_name" => "4.3.9.3",
                    "description" => "Cybersecurity Threats Management process shall inc...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.9.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Threats Management'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.9.3.1",
                            "long_name" => "4.3.9.3.1",
                            "description" => "Using the internal sources, such as access and app...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.9.3.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Threats Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.9.3.2",
                            "long_name" => "4.3.9.3.2",
                            "description" => "Utilizing reliable external sources that are relat...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.9.3.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Threats Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.9.3.3",
                            "long_name" => "4.3.9.3.3",
                            "description" => "Develop a certain methodology to periodically anal...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.9.3.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Threats Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.9.3.4",
                            "long_name" => "4.3.9.3.4",
                            "description" => "Details related to certain threats, such as work m...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.9.3.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Threats Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.9.3.5",
                            "long_name" => "4.3.9.3.5",
                            "description" => "Sharing the relevant threat intelligence with the ...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.9.3.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Threats Management'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.10.1",
                    "long_name" => "4.3.10.1",
                    "description" => "Define, document, approve and implement applicatio...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.10.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.10.2",
                    "long_name" => "4.3.10.2",
                    "description" => "Monitor compliance with cybersecurity controls to ...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.10.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.10.3",
                    "long_name" => "4.3.10.3",
                    "description" => "Periodically measure and evaluate effectiveness of...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.10.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.10.4",
                    "long_name" => "4.3.10.4",
                    "description" => "Follow the adopted methodology on Software Develop...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.10.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.10.5",
                    "long_name" => "4.3.10.5",
                    "description" => "Applications Cybersecurity controls shall include ...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.10.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.10.5.1",
                            "long_name" => "4.3.10.5.1",
                            "description" => "Adoption of Applications’ Secure Coding Standards.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.10.5.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.10.5.2",
                            "long_name" => "4.3.10.5.2",
                            "description" => "Applicable cybersecurity controls (Configuration P...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.10.5.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.10.5.3",
                            "long_name" => "4.3.10.5.3",
                            "description" => "Using reliable and approved sources and libraries.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.10.5.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.10.5.4",
                            "long_name" => "4.3.10.5.4",
                            "description" => "Using Multi-tier Architecture Principle, Multi-Fac...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.10.5.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.10.5.5",
                            "long_name" => "4.3.10.5.5",
                            "description" => "Conducting penetration testing for all external (O...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.10.5.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.10.5.6",
                            "long_name" => "4.3.10.5.6",
                            "description" => "Application integration security.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.10.5.6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.10.5.7",
                            "long_name" => "4.3.10.5.7",
                            "description" => "Acceptable Use Policy",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.10.5.7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.10.5.8",
                            "long_name" => "4.3.10.5.8",
                            "description" => "Segregation of Duties supported by the approved ma...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.10.5.8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.10.5.9",
                            "long_name" => "4.3.10.5.9",
                            "description" => "Protecting and dealing with data according to the ...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.10.5.9",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.10.5.10",
                            "long_name" => "4.3.10.5.10",
                            "description" => "Manage vulnerability, updates package and security...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.10.5.10",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.10.5.11",
                            "long_name" => "4.3.10.5.11",
                            "description" => "Backups and data recovery procedures.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.10.5.11",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.10.5.12",
                            "long_name" => "4.3.10.5.12",
                            "description" => "Periodic review of compliance with cybersecurity c...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.10.5.12",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Application Security'), // Dynamically get family ID
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.11.1",
                    "long_name" => "4.3.11.1",
                    "description" => "Define, document, approve and implement encryption...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.11.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Encryption'), // Dynamically get family ID for Encryption
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.11.2",
                    "long_name" => "4.3.11.2",
                    "description" => "Monitor compliance with encryption standards.",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.11.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Encryption'), // Dynamically get family ID for Encryption
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.11.3",
                    "long_name" => "4.3.11.3",
                    "description" => "Periodically measure and evaluate effectiveness of...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.11.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Encryption'), // Dynamically get family ID for Encryption
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.11.4",
                    "long_name" => "4.3.11.4",
                    "description" => "Encryption standard shall include the following:",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.11.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Encryption'), // Dynamically get family ID for Encryption
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.11.4.1",
                            "long_name" => "4.3.11.4.1",
                            "description" => "General review of approved encryption solutions an...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.11.4.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Encryption'), // Dynamically get family ID for Encryption
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.11.4.2",
                            "long_name" => "4.3.11.4.2",
                            "description" => "Cases to which the approved encryption solutions s...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.11.4.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Encryption'), // Dynamically get family ID for Encryption
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.11.4.3",
                            "long_name" => "4.3.11.4.3",
                            "description" => "Managing encryption keys, including managing their...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.11.4.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Encryption'), // Dynamically get family ID for Encryption
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.11.4.4",
                            "long_name" => "4.3.11.4.4",
                            "description" => "Encrypting data during transfer and storage based ...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.11.4.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Encryption'), // Dynamically get family ID for Encryption
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.12.1",
                    "long_name" => "4.3.12.1",
                    "description" => "Set out, document, approve and implement vulnerability...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.12.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerability Management'), // Dynamically get family ID for Vulnerability Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.12.2",
                    "long_name" => "4.3.12.2",
                    "description" => "Measure and evaluate effectiveness of vulnerability...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.12.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerability Management'), // Dynamically get family ID for Vulnerability Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.12.3",
                    "long_name" => "4.3.12.3",
                    "description" => "The vulnerabilities management process shall inclu...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.12.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Vulnerability Management'), // Dynamically get family ID for Vulnerability Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.12.3.1",
                            "long_name" => "4.3.12.3.1",
                            "description" => "All information and technical assets;",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.12.3.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerability Management'), // Dynamically get family ID for Vulnerability Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.12.3.2",
                            "long_name" => "4.3.12.3.2",
                            "description" => "Periodic vulnerability scan.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.12.3.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerability Management'), // Dynamically get family ID for Vulnerability Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.12.3.3",
                            "long_name" => "4.3.12.3.3",
                            "description" => "Classifying security vulnerabilities;",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.12.3.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerability Management'), // Dynamically get family ID for Vulnerability Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.12.3.4",
                            "long_name" => "4.3.12.3.4",
                            "description" => "Setting timelines to patch vulnerabilities, based ...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.12.3.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerability Management'), // Dynamically get family ID for Vulnerability Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.12.3.5",
                            "long_name" => "4.3.12.3.5",
                            "description" => "Setting priorities for classified information and ...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.12.3.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerability Management'), // Dynamically get family ID for Vulnerability Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.12.3.6",
                            "long_name" => "4.3.12.3.6",
                            "description" => "Managing security patching and implementation meth...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.12.3.6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerability Management'), // Dynamically get family ID for Vulnerability Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.12.3.7",
                            "long_name" => "4.3.12.3.7",
                            "description" => "Communicating and cooperating with trusted sources...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.12.3.7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Vulnerability Management'), // Dynamically get family ID for Vulnerability Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.13.1",
                    "long_name" => "4.3.13.1",
                    "description" => "Set out, document, approve and implement cybersecurity...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.13.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID for Cybersecurity Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.13.2",
                    "long_name" => "4.3.13.2",
                    "description" => "Monitor compliance with e-trading services cybersecurity...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.13.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID for Cybersecurity Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.13.3",
                    "long_name" => "4.3.13.3",
                    "description" => "Measure and evaluate effectiveness of e-trading services...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.13.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID for Cybersecurity Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.13.4",
                    "long_name" => "4.3.13.4",
                    "description" => "E-Trading Services Cybersecurity Controls shall in...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.13.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID for Cybersecurity Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.13.4.1",
                            "long_name" => "4.3.13.4.1",
                            "description" => "E-services protection, including social media.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.13.4.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID for Cybersecurity Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.13.4.2",
                            "long_name" => "4.3.13.4.2",
                            "description" => "E-trading protection via smart devices and mobile...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.13.4.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID for Cybersecurity Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.13.5",
                    "long_name" => "4.3.13.5",
                    "description" => "Instant notification via SMS:",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.13.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID for Cybersecurity Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.13.5.1",
                            "long_name" => "4.3.13.5.1",
                            "description" => "No \"SMS\" shall contain sensitive data (such as cus...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.13.5.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID for Cybersecurity Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.13.5.2",
                            "long_name" => "4.3.13.5.2",
                            "description" => "SMS notice shall be sent to customer's phone numbe...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.13.5.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID for Cybersecurity Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.13.5.3",
                            "long_name" => "4.3.13.5.3",
                            "description" => "SMS notice shall be sent to customer's phone numbe...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.13.5.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cybersecurity Management'), // Dynamically get family ID for Cybersecurity Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.14.1",
                    "long_name" => "4.3.14.1",
                    "description" => "Set out, document, approve, and implement physical...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.14.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical Security'), // Dynamically get family ID for Physical Security
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.14.2",
                    "long_name" => "4.3.14.2",
                    "description" => "Measure, monitor effectiveness, and periodically e...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.14.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical Security'), // Dynamically get family ID for Physical Security
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.14.3",
                    "long_name" => "4.3.14.3",
                    "description" => "Ensure that trading services are protected against...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.14.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical Security'), // Dynamically get family ID for Physical Security
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.14.4",
                    "long_name" => "4.3.14.4",
                    "description" => "Monitor fire alarms on an ongoing basis, test them...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.14.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical Security'), // Dynamically get family ID for Physical Security
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.14.5",
                    "long_name" => "4.3.14.5",
                    "description" => "Mitigate the impact of natural disasters.",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.14.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical Security'), // Dynamically get family ID for Physical Security
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.14.6",
                    "long_name" => "4.3.14.6",
                    "description" => "The physical security process includes, but not li...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.14.6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical Security'), // Dynamically get family ID for Physical Security
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.14.6.1",
                            "long_name" => "4.3.14.6.1",
                            "description" => "Physical entry controls (including visitor securit...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.14.6.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'), // Dynamically get family ID for Physical Security
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.14.6.2",
                            "long_name" => "4.3.14.6.2",
                            "description" => "Surveillance and monitoring (using \"CCTV\" systems,...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.14.6.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'), // Dynamically get family ID for Physical Security
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.14.6.3",
                            "long_name" => "4.3.14.6.3",
                            "description" => "Protecting data centers, data rooms and power supp...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.14.6.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'), // Dynamically get family ID for Physical Security
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.14.6.4",
                            "long_name" => "4.3.14.6.4",
                            "description" => "Protection against environmental hazards.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.14.6.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'), // Dynamically get family ID for Physical Security
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.14.6.5",
                            "long_name" => "4.3.14.6.5",
                            "description" => "Protect information assets during their life cycle...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.14.6.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'), // Dynamically get family ID for Physical Security
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.14.6.6",
                            "long_name" => "4.3.14.6.6",
                            "description" => "Train personnel on use of fire extinguishers and o...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.14.6.6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Physical Security'), // Dynamically get family ID for Physical Security
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.15.3",
                            "long_name" => "4.3.15.3",
                            "description" => "Identify standards, legislation and regulations to...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.15.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Business Continuity Management'), // Dynamically get family ID for Business Continuity Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.3.15.1",
                    "long_name" => "4.3.15.1",
                    "description" => "Set out, document, approve and update a business c...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.15.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Business Continuity Management'), // Dynamically get family ID for Business Continuity Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.15.2",
                    "long_name" => "4.3.15.2",
                    "description" => "Review business continuity policy on an annual bas...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.15.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Business Continuity Management'), // Dynamically get family ID for Business Continuity Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],

                [
                    "short_name" => "4.3.15.4",
                    "long_name" => "4.3.15.4",
                    "description" => "Conduct BIA, through which all key processes and s...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.15.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Business Continuity Management'), // Dynamically get family ID for Business Continuity Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.15.5",
                    "long_name" => "4.3.15.5",
                    "description" => "Conduct BIA on an annual basis to identify scope o...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.15.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Business Continuity Management'), // Dynamically get family ID for Business Continuity Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.15.6",
                    "long_name" => "4.3.15.6",
                    "description" => "Prepare a Business Continuity Management Strategy ...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.15.6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Business Continuity Management'), // Dynamically get family ID for Business Continuity Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.15.7",
                    "long_name" => "4.3.15.7",
                    "description" => "Establish a Crisis Management Team, comprising rep...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.15.7",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Business Continuity Management'), // Dynamically get family ID for Business Continuity Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.15.8",
                    "long_name" => "4.3.15.8",
                    "description" => "The business continuity plan includes clear and sp...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.15.8",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Business Continuity Management'), // Dynamically get family ID for Business Continuity Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.15.9",
                    "long_name" => "4.3.15.9",
                    "description" => "Test Business Continuity Management and Disaster R...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.15.9",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Business Continuity Management'), // Dynamically get family ID for Business Continuity Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.15.10",
                    "long_name" => "4.3.15.10",
                    "description" => "Ensure that employees entrusted with developing Bu...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.15.10",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Business Continuity Management'), // Dynamically get family ID for Business Continuity Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.15.11",
                    "long_name" => "4.3.15.11",
                    "description" => "Provide general training and awareness required fo...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.15.11",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Business Continuity Management'), // Dynamically get family ID for Business Continuity Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.16.1",
                    "long_name" => "4.3.16.1",
                    "description" => "Set, document, approve and apply a BYOD cybersecur...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.16.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Use of BYOD'), // Dynamically get family ID for Use of BYOD
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.16.2",
                    "long_name" => "4.3.16.2",
                    "description" => "Monitor compliance with the Use of BYOD pol...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.16.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Use of BYOD'), // Dynamically get family ID for Use of BYOD
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.16.3",
                    "long_name" => "4.3.16.3",
                    "description" => "Measure effectiveness of Use of BYOD contro...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.16.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Use of BYOD'), // Dynamically get family ID for Use of BYOD
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.3.16.4",
                    "long_name" => "4.3.16.4",
                    "description" => "Use of BYOD policy shall include the follow...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.3.16.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Use of BYOD'), // Dynamically get family ID for Use of BYOD
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.3.16.4.1",
                            "long_name" => "4.3.16.4.1",
                            "description" => "User responsibilities including training and raisi...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.16.4.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Use of BYOD'), // Dynamically get family ID for Use of BYOD
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.16.4.2",
                            "long_name" => "4.3.16.4.2",
                            "description" => "Indication of restrictions imposed, and consequenc...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.16.4.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Use of BYOD'), // Dynamically get family ID for Use of BYOD
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.16.4.3",
                            "long_name" => "4.3.16.4.3",
                            "description" => "Separate market data and information from personal...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.16.4.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Use of BYOD'), // Dynamically get family ID for Use of BYOD
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.16.4.4",
                            "long_name" => "4.3.16.4.4",
                            "description" => "Rule of use of genuine mobile applications related...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.16.4.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Use of BYOD'), // Dynamically get family ID for Use of BYOD
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.3.16.4.5",
                            "long_name" => "4.3.16.4.5",
                            "description" => "Use of Mobile Device Management (MDM) to apply rem...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.3.16.4.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Use of BYOD'), // Dynamically get family ID for Use of BYOD
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.4.1.1",
                    "long_name" => "4.4.1.1",
                    "description" => "Set out, document, approve, apply and circulate Cy...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.4.1.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Contracts and Suppliers Management'), // Dynamically get family ID for Contracts and Suppliers Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.4.1.2",
                    "long_name" => "4.4.1.2",
                    "description" => "Monitor compliance with Contracts and Suppliers Ma...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.4.1.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Contracts and Suppliers Management'), // Dynamically get family ID for Contracts and Suppliers Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.4.1.3",
                    "long_name" => "4.4.1.3",
                    "description" => "Measure and periodically evaluate effectiveness of...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.4.1.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Contracts and Suppliers Management'), // Dynamically get family ID for Contracts and Suppliers Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.4.1.4",
                    "long_name" => "4.4.1.4",
                    "description" => "Contracts and Suppliers Management process shall i...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.4.1.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Contracts and Suppliers Management'), // Dynamically get family ID for Contracts and Suppliers Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.4.1.4.1",
                            "long_name" => "4.4.1.4.1",
                            "description" => "Inclusion of the minimum cybersecurity controls th...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.1.4.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Contracts and Suppliers Management'), // Dynamically get family ID for Contracts and Suppliers Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.4.1.4.2",
                            "long_name" => "4.4.1.4.2",
                            "description" => "Authority to conduct periodic cybersecurity audit ...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.1.4.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Contracts and Suppliers Management'), // Dynamically get family ID for Contracts and Suppliers Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                    ]
                ],

                [
                    "short_name" => "4.4.1.5",
                    "long_name" => "4.4.1.5",
                    "description" => "Contracts Management process shall include:",
                    "supplemental_guidance" => null,
                    "control_number" => "4.4.1.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Contracts and Suppliers Management'), // Dynamically get family ID for Contracts and Suppliers Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.4.1.5.1",
                            "long_name" => "4.4.1.5.1",
                            "description" => "Evaluate Cybersecurity risks as a part of signing ...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.1.5.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Contracts and Suppliers Management'), // Dynamically get family ID for Contracts and Suppliers Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.4.1.5.2",
                            "long_name" => "4.4.1.5.2",
                            "description" => "Define Cybersecurity controls as a part of bidding...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.1.5.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Contracts and Suppliers Management'), // Dynamically get family ID for Contracts and Suppliers Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.4.1.5.3",
                            "long_name" => "4.4.1.5.3",
                            "description" => "Evaluate responses of potential suppliers accordin...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.1.5.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Contracts and Suppliers Management'), // Dynamically get family ID for Contracts and Suppliers Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.4.1.5.4",
                            "long_name" => "4.4.1.5.4",
                            "description" => "Test the agreed cybersecurity controls (Risks-Base...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.1.5.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Contracts and Suppliers Management'), // Dynamically get family ID for Contracts and Suppliers Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.4.1.5.5",
                            "long_name" => "4.4.1.5.5",
                            "description" => "Identify communication and escalation procedures i...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.1.5.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Contracts and Suppliers Management'), // Dynamically get family ID for Contracts and Suppliers Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.4.1.5.6",
                            "long_name" => "4.4.1.5.6",
                            "description" => "Lay down Non-Disclosure Clauses.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.1.5.6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Contracts and Suppliers Management'), // Dynamically get family ID for Contracts and Suppliers Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.4.1.5.7",
                            "long_name" => "4.4.1.5.7",
                            "description" => "Safe disposal by the third party of market institu...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.1.5.7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Contracts and Suppliers Management'), // Dynamically get family ID for Contracts and Suppliers Management
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],

                    ]
                ],
                [
                    "short_name" => "4.4.1.6",
                    "long_name" => "4.4.1.6",
                    "description" => "Suppliers Management Process includes preparing, r...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.4.1.6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Contracts and Suppliers Management'), // Dynamically get family ID for Contracts and Suppliers Management
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.4.2.1",
                    "long_name" => "4.4.2.1",
                    "description" => "Set out, document, approve and apply cybersecurity...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.4.2.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Policies and Compliance'), // Dynamically get family ID for Cybersecurity Policies and Compliance
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.4.2.2",
                    "long_name" => "4.4.2.2",
                    "description" => "Measure and periodically evaluate cybersecurity co...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.4.2.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Policies and Compliance'), // Dynamically get family ID for Cybersecurity Policies and Compliance
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.4.2.3",
                    "long_name" => "4.4.2.3",
                    "description" => "Outsourcing includes engagement of Cybersecurity D...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.4.2.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Policies and Compliance'), // Dynamically get family ID for Cybersecurity Policies and Compliance
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.4.2.4",
                    "long_name" => "4.4.2.4",
                    "description" => "Compliance with related national laws and regulati...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.4.2.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Policies and Compliance'), // Dynamically get family ID for Cybersecurity Policies and Compliance
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.4.2.5",
                    "long_name" => "4.4.2.5",
                    "description" => "Outsourcing is limited to providing security opera...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.4.2.5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cybersecurity Policies and Compliance'), // Dynamically get family ID for Cybersecurity Policies and Compliance
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.4.3.1",
                    "long_name" => "4.4.3.1",
                    "description" => "Set out, document, approve and apply cybersecurity...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.4.3.1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cloud Computing'), // Dynamically get family ID for Cloud Computing
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.4.3.2",
                    "long_name" => "4.4.3.2",
                    "description" => "Monitor compliance with Cloud Computing Policy",
                    "supplemental_guidance" => null,
                    "control_number" => "4.4.3.2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cloud Computing'), // Dynamically get family ID for Cloud Computing
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.4.3.3",
                    "long_name" => "4.4.3.3",
                    "description" => "Measure and periodically evaluate cybersecurity co...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.4.3.3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cloud Computing'), // Dynamically get family ID for Cloud Computing
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                ],
                [
                    "short_name" => "4.4.3.4",
                    "long_name" => "4.4.3.4",
                    "description" => "Cybersecurity controls related to Cloud Computing ...",
                    "supplemental_guidance" => null,
                    "control_number" => "4.4.3.4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cloud Computing'), // Dynamically get family ID for Cloud Computing
                    "control_owner" => "1", // Example control owner
                    "submission_date" => now(),
                    "status" => "1",
                    "deleted" => "0",
                    "children" => [
                        [
                            "short_name" => "4.4.3.4.1",
                            "long_name" => "4.4.3.4.1",
                            "description" => "Approval of cloud computing services, which includ...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.3.4.1",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cloud Computing'), // Dynamically get family ID for Cloud Computing
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.4.3.4.2",
                            "long_name" => "4.4.3.4.2",
                            "description" => "Conduct data classification before hosting.",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.3.4.2",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cloud Computing'), // Dynamically get family ID for Cloud Computing
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.4.3.4.3",
                            "long_name" => "4.4.3.4.3",
                            "description" => "Data hosting location, i.e. to use cloud-computing...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.3.4.3",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cloud Computing'), // Dynamically get family ID for Cloud Computing
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.4.3.4.4",
                            "long_name" => "4.4.3.4.4",
                            "description" => "Data hosting location, i.e. to use cloud-computing...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.3.4.4",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cloud Computing'), // Dynamically get family ID for Cloud Computing
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.4.3.4.5",
                            "long_name" => "4.4.3.4.5",
                            "description" => "Protection; Cloud Computing Service Provider shall...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.3.4.5",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cloud Computing'), // Dynamically get family ID for Cloud Computing
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.4.3.4.6",
                            "long_name" => "4.4.3.4.6",
                            "description" => "Segregation of data; to properly separate market i...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.3.4.6",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cloud Computing'), // Dynamically get family ID for Cloud Computing
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.4.3.4.7",
                            "long_name" => "4.4.3.4.7",
                            "description" => "Business Continuity; to meet business continuity r...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.3.4.7",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cloud Computing'), // Dynamically get family ID for Cloud Computing
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.4.3.4.8",
                            "long_name" => "4.4.3.4.8",
                            "description" => "The market institution shall have the right to con...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.3.4.8",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cloud Computing'), // Dynamically get family ID for Cloud Computing
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
                            "status" => "1",
                            "deleted" => "0",
                        ],
                        [
                            "short_name" => "4.4.3.4.9",
                            "long_name" => "4.4.3.4.9",
                            "description" => "Termination, which includes: The market instituti...",
                            "supplemental_guidance" => null,
                            "control_number" => "4.4.3.4.9",
                            "control_status" => "Not Implemented",
                            "family" => $this->getFamilyIdByName('Cloud Computing'), // Dynamically get family ID for Cloud Computing
                            "control_owner" => "1", // Example control owner
                            "submission_date" => now(),
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