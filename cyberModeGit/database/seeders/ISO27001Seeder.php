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

class ISO27001Seeder extends Seeder
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
                'name' => 'ISO-27001-2022',
                'description' => "ISO/IEC 27001 is is the world’s best-known standard for information security management systems (ISMS) and their requirements. Additional best practice in data protection and cyber resilience are covered by more than a dozen standards in the ISO/IEC 27000 family. Together, they enable organizations of all sectors and sizes to manage the security of assets such as financial information, intellectual property, employee data and information entrusted by third parties.",
                'icon' => 'fa-user-circle',
                'status' => '1',
                'regulator_id' => $this->regulatorId,

            ]);


            // Main domains with their subdomains
            $mainDomains = [
                [

                    'name' => 'Context of the organization',
                    'order' => '10',
                    'subdomains' => [
                        [
                            'name' => 'Understanding the organization and its context',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Understanding the needs and expectations of interested parties',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Determining the scope of the information security management system',
                            'order' => '3',
                        ],
                        [
                            'name' => 'Information security management system',
                            'order' => '4',
                        ]
                    ]
                ],
                [
                    'name' => 'Leadership',
                    'order' => '11',
                    'subdomains' => [
                        [
                            'name' => 'Leadership and commitment',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Policy',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Organizational roles, responsibilities and authorities',
                            'order' => '3',
                        ]
                    ]
                ],
                [
                    'name' => 'Planning',
                    'order' => '12',
                    'subdomains' => [
                        [
                            'name' => 'Actions to address risks and opportunities- general',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Actions to address risks and opportunities- Information security risk assessment',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Actions to address risks and opportunities-Information security risk treatment',
                            'order' => '3',
                        ],
                        [
                            'name' => 'Information security objectives and planning to achieve them',
                            'order' => '4',
                        ],
                        [
                            'name' => 'Planning of changes',
                            'order' => '5',
                        ]
                    ]
                ],
                [
                    'name' => ' Support',
                    'order' => '13',
                    'subdomains' => [
                        [
                            'name' => 'Resources',
                            'order' => '1',
                        ],
                        [
                            'name' => 'RDocumented information-General',
                            'order' => '8',
                        ],
                        [
                            'name' => 'Competence',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Awareness',
                            'order' => '3',
                        ],
                        [
                            'name' => 'Communication',
                            'order' => '4',
                        ],
                        [
                            'name' => 'Documented information-General',
                            'order' => '5',
                        ],
                        [
                            'name' => 'Documented information- Creating and updating',
                            'order' => '6',
                        ],
                        [
                            'name' => 'Documented information- Control of documented information',
                            'order' => '7',
                        ],
                        [
                            'name' => 'RDocumented information-General',
                            'order' => '8',
                        ],
                    ]
                ],
                [
                    'name' => 'Operation',
                    'order' => '14',
                    'subdomains' => [
                        [
                            'name' => 'Operational planning and control',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Information security risk assessment',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Information security risk treatment',
                            'order' => '3',
                        ]
                    ]
                ],
                [
                    'name' => 'Performance evaluation',
                    'order' => '15',
                    'subdomains' => [
                        [
                            'name' => 'Monitoring, measurement, analysis and evaluation',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Internal audit-General',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Internal audit-Internal audit programme',
                            'order' => '3',
                        ],
                        [
                            'name' => 'Management review-General',
                            'order' => '4',
                        ],
                        [
                            'name' => 'Management review-Management review inputs',
                            'order' => '5',
                        ],
                        [
                            'name' => 'Management review-Management review results',
                            'order' => '6',
                        ]
                    ]
                ],
                [
                    'name' => ' Improvement',
                    'order' => '16',
                    'subdomains' => [
                        [
                            // 'name' => 'Secure areas',
                            'name' => 'Continual improvement',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Nonconformity and corrective action',
                            'order' => '2',
                        ]
                    ]
                ],
                [
                    'name' => 'Organizational controls',
                    'order' => '17',
                    'subdomains' => [
                        [
                            'name' => 'Policies for information security',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Information security roles and responsibilities',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Segregation of duties',
                            'order' => '3',
                        ],
                        [
                            'name' => 'Management responsibilities',
                            'order' => '4',
                        ],
                        [
                            'name' => 'Contact with authorities',
                            'order' => '5',
                        ],
                        [
                            'name' => 'Contact with special interest groupst',
                            'order' => '6',
                        ],
                        [
                            'name' => 'Threat intelligence',
                            'order' => '7',
                        ],
                        [
                            'name' => 'Information security in project management',
                            'order' => '8',
                        ],
                        [
                            'name' => 'Inventory of information and other associated assets',
                            'order' => '9',
                        ],
                        [
                            'name' => 'Acceptable use of information and other associated assets',
                            'order' => '10',
                        ],
                        [
                            'name' => 'Return of assets',
                            'order' => '11',
                        ],
                        [
                            'name' => 'Classification of information',
                            'order' => '12',
                        ],
                        [
                            'name' => 'Labelling of information',
                            'order' => '13',
                        ],
                        [
                            'name' => 'Information transfer',
                            'order' => '14',
                        ],
                        [
                            'name' => 'Access control',
                            'order' => '15',
                        ],
                        [
                            'name' => 'Identity management',
                            'order' => '16',
                        ],
                        [
                            'name' => 'Authentication information',
                            'order' => '17',
                        ],
                        [
                            'name' => 'Access rights',
                            'order' => '18',
                        ],
                        [
                            'name' => 'Information security in supplier relationships',
                            'order' => '19',
                        ],
                        [
                            'name' => 'Addressing information security within supplier agreements',
                            'order' => '20',
                        ],
                        [
                            'name' => 'Managing information security in the information and commu nication technology (ICT) supply chain',
                            'order' => '21',
                        ],
                        [
                            'name' => 'Monitoring, review and change management of supplier services',
                            'order' => '22',
                        ],
                        [
                            'name' => 'Information security for use of cloud services',
                            'order' => '23',
                        ],
                        [
                            'name' => 'Information security incident management planning and prepa ration',
                            'order' => '24',
                        ],
                        [
                            'name' => 'Assessment and decision on in formation security events',
                            'order' => '25',
                        ],
                        [
                            'name' => 'Response to information security incidents',
                            'order' => '26',
                        ],
                        [
                            'name' => 'Learning from information se curity incidents',
                            'order' => '27',
                        ],
                        [
                            'name' => 'Collection of evidence',
                            'order' => '28',
                        ],
                        [
                            'name' => 'Information security during disruption',
                            'order' => '29',
                        ],
                        [
                            'name' => 'ICT readiness for business con tinuity',
                            'order' => '30',
                        ],
                        [
                            'name' => 'Legal, statutory, regulatory and contractual requirements',
                            'order' => '31',
                        ],
                        [
                            'name' => 'Intellectual property rights',
                            'order' => '32',
                        ],
                        [
                            'name' => 'Protection of records',
                            'order' => '33',
                        ],
                        [
                            'name' => 'Privacy and protection of person al identifiable information (PII)',
                            'order' => '34',
                        ],
                        [
                            'name' => 'Independent review of information security',
                            'order' => '35',
                        ],
                        [
                            'name' => 'Compliance with policies, rules and standards for information security',
                            'order' => '36',
                        ],
                        [
                            'name' => 'security Documented operating procedures',
                            'order' => '37',
                        ],
                        [
                            'name' => 'Contact with special interest groups',
                            'order' => '38',
                        ],
                        [
                            'name' => 'Collection of evidence',
                            'order' => '39',
                        ],
                    ]
                ],
                [
                    'name' => 'People controls',
                    'order' => '18',
                    'subdomains' => [
                        [
                            'name' => 'Screening',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Terms and conditions of employment',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Information security awareness, education and training',
                            'order' => '3',
                        ],
                        [
                            'name' => 'Disciplinary process',
                            'order' => '4',
                        ],
                        [
                            'name' => 'Responsibilities after termination or change of employment',
                            'order' => '5',
                        ],
                        [
                            'name' => 'Confidentiality or non-disclosure agreements',
                            'order' => '6',
                        ],
                        [
                            'name' => 'Remote working',
                            'order' => '7',
                        ],
                        [
                            'name' => 'Information security event re porting',
                            'order' => '8',
                        ]
                    ]
                ],

                [
                    'name' => 'Annex A.14 – System Acquisition, Development & Maintenance',
                    'order' => '19',
                    'subdomains' => [
                        [
                            'name' => 'Security Requirements of Information Systems',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Security in Development and Support Processes',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Test data',
                            'order' => '3',
                        ]
                    ]
                ],
                [
                    'name' => 'Physical controls',
                    'order' => '20',
                    'subdomains' => [
                        [
                            'name' => 'Physical security perimeters',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Physical entry',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Securing offices, rooms and facilities',
                            'order' => '3',
                        ],
                        [
                            'name' => 'Physical security monitoring',
                            'order' => '4',
                        ],
                        [
                            'name' => 'Protecting against physical and environmental threats',
                            'order' => '5',
                        ],
                        [
                            'name' => 'Working in secure areas',
                            'order' => '6',
                        ],
                        [
                            'name' => 'Clear desk and clear screen',
                            'order' => '7',
                        ],
                        [
                            'name' => 'Equipment siting and protection',
                            'order' => '8',
                        ],
                        [
                            'name' => 'Security of assets off-premises',
                            'order' => '9',
                        ],
                        [
                            'name' => 'Storage media',
                            'order' => '10',
                        ],
                        [
                            'name' => 'Supporting utilities',
                            'order' => '11',
                        ],
                        [
                            'name' => 'Cabling security',
                            'order' => '12',
                        ],
                        [
                            'name' => 'Equipment maintenance',
                            'order' => '13',
                        ],
                        [
                            'name' => 'Secure disposal or re-use of equipment',
                            'order' => '14',
                        ]
                    ]
                ],
                [
                    'name' => 'Technological controls',
                    'order' => '21',
                    'subdomains' => [
                        [
                            // 'name' => 'Management of Information Security incidents and improvements',
                            'name' => 'User end point devices',
                            'order' => '1',
                        ],
                        [
                            'name' => 'Privileged access rights',
                            'order' => '2',
                        ],
                        [
                            'name' => 'Information access restriction',
                            'order' => '3',
                        ],
                        [
                            'name' => 'Access to source code',
                            'order' => '4',
                        ],
                        [
                            'name' => 'Secure authentication',
                            'order' => '5',
                        ],
                        [
                            'name' => 'Capacity management',
                            'order' => '6',
                        ],
                        [
                            'name' => 'Protection against malware',
                            'order' => '7',
                        ],
                        [
                            'name' => 'Management of technical vul nerabilities',
                            'order' => '8',
                        ],
                        [
                            'name' => 'Configuration management',
                            'order' => '9',
                        ],
                        [
                            'name' => 'Information deletion',
                            'order' => '10',
                        ],
                        [
                            'name' => 'Data masking',
                            'order' => '11',
                        ],
                        [
                            'name' => 'Data leakage prevention',
                            'order' => '12',
                        ],
                        [
                            'name' => 'Information backup',
                            'order' => '13',
                        ],
                        [
                            'name' => 'Redundancy of information processing facilities',
                            'order' => '14',
                        ],
                        [
                            'name' => 'Logging',
                            'order' => '15',
                        ],
                        [
                            'name' => 'Monitoring activities',
                            'order' => '16',
                        ],
                        [
                            'name' => 'Clock synchronization',
                            'order' => '17',
                        ],
                        [
                            'name' => 'Use of privileged utility programs',
                            'order' => '18',
                        ],
                        [
                            'name' => 'Installation of software on op erational systems',
                            'order' => '19',
                        ],
                        [
                            'name' => 'Networks security',
                            'order' => '20',
                        ],
                        [
                            'name' => 'Security of network services',
                            'order' => '21',
                        ],
                        [
                            'name' => 'Segregation of networks',
                            'order' => '22',
                        ],
                        [
                            'name' => 'Web filtering',
                            'order' => '23',
                        ],
                        [
                            'name' => 'Use of cryptography',
                            'order' => '24',
                        ],
                        [
                            'name' => 'Secure development life cycle',
                            'order' => '25',
                        ],
                        [
                            'name' => 'Application security requirements',
                            'order' => '26',
                        ],
                        [
                            'name' => 'Secure system architecture and engineering principles',
                            'order' => '27',
                        ],
                        [
                            'name' => 'Secure coding',
                            'order' => '28',
                        ],
                        [
                            'name' => 'Security testing in development and acceptance',
                            'order' => '29',
                        ],
                        [
                            'name' => 'Outsourced development',
                            'order' => '30',
                        ],
                        [
                            'name' => 'Separation of development, test and production environments',
                            'order' => '31',
                        ],
                        [
                            'name' => 'Change management',
                            'order' => '32',
                        ],
                        [
                            'name' => 'Test information',
                            'order' => '33',
                        ],
                        [
                            'name' => 'Protection of information sys tems during audit testing',
                            'order' => '34',
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
                    "short_name" => "ISO Clause 4-1",
                    "long_name" => "Clause 4-1",
                    "description" => "The organization shall determine external and internal issues that are relevant to its purpose and that affect its ability to achieve the intended outcome(s) of its information security management system.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 4-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Understanding the organization and its context'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [

                    "short_name" => "ISO Clause 4-2",
                    "long_name" => "Clause  4-2",
                    "description" => "The organization shall determine: 
a) interested parties that are relevant to the information security management system. 
b) the relevant requirements of these interested parties.
 c) which of these requirements will be addressed through the information security management system.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause  4-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Understanding the needs and expectations of interested parties'), // Dynamically get family ID
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [

                    "short_name" => "ISO Clause 4-3",
                    "long_name" => "Clause  4-3",
                    "description" => "The organization shall determine the boundaries and applicability of the information security 
management system to establish its scope.
 When determining this scope, the organization shall consider:
 a) the external and internal issues referred to in 4.1;
 b) the requirements referred to in 4.2; 
c) interfaces and dependencies between activities performed by the organization, and those that are 
performed by other organizations.
 The scope shall be available as documented information.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause  4-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Determining the scope of the information security management system'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],


                [

                    "short_name" => "ISO Clause 4-4",
                    "long_name" => "Clause 4-4",
                    "description" => "The organization shall establish, implement, maintain and continually improve an information security management system, including the processes needed and their interactions, in accordance with the requirements of this document.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 4-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information security management system'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [

                    "short_name" => "ISO Clause 5-1",
                    "long_name" => "Clause 5-1",
                    "description" => "CTop management shall demonstrate leadership and commitment with respect to the information security management system by: 
a) ensuring the information security policy and the information security objectives are established and are compatible with the strategic direction of the organization;
 b) ensuring the integration of the information security management system requirements into the organization’s processes; 
c) ensuring that the resources needed for the information security management system are available;
 d) communicating the importance of effective information security management and of conforming to the information security management system requirements;
 e) ensuring that the information security management system achieves its intended outcome(s);
 f) directing and supporting persons to contribute to the effectiveness of the information security management system; 
g) promoting continual improvement; and 
h) supporting other relevant management roles to demonstrate their leadership as it applies to their areas of responsibility.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 5-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Leadership and commitment'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Clause  5-2",
                    "long_name" => "Clause  5-2",
                    "description" => "Top management shall establish an information security policy that:  
a) is appropriate to the purpose of the organization;
 b) includes information security objectives (see 6.2) or provides the framework for setting information security objectives;
 c) includes a commitment to satisfy applicable requirements related to information security;
 d) includes a commitment to continual improvement of the information security management system. The information security policy shall: 
e) be available as documented information; 
f) be communicated within the organization;
 g) be available to interested parties, as appropriate.
",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause  5-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Policy'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "ISO Clause  5-3",
                    "long_name" => "Clause  5-3",
                    "description" => "Top management shall ensure that the responsibilities and authorities for roles relevant to information security are assigned and communicated within the organization. Top management shall assign the responsibility and authority for: 
a) ensuring that the information security management system conforms to the requirements of this document;
 b) reporting on the performance of the information security management system to top management.
",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause  5-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Organizational roles, responsibilities and authorities'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Clause  6-1-1",
                    "long_name" => "Clause  6-1-1",
                    "description" => "When planning for the information security management system, the organization shall consider the issues referred to in 4.1 and the requirements referred to in 4.2 and determine the risks and opportunities that need to be addressed to: 
a) ensure the information security management system can achieve its intended outcome(s);
 b) prevent, or reduce, undesired effects; 
c) achieve continual improvement. The organization shall plan:
 d) actions to address these risks and opportunities; and 
e) how to 
1) integrate and implement the actions into its information security management system processes; and
 2) evaluate the effectiveness of these actions.
",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause  6-1-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Actions to address risks and opportunities- general'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [
                    "short_name" => "ISO Clause  6-1-2",
                    "long_name" => "Clause  6-1-2",
                    "description" => "The organization shall define and apply an information security risk assessment process that: 
a) establishes and maintains information security risk criteria that include:
 1) the risk acceptance criteria; and 
2) criteria for performing information security risk assessments; 
b) ensures that repeated information security risk assessments produce consistent, valid and comparable results; 
c) identifies the information security risks:
 1) apply the information security risk assessment process to identify risks associated with the loss of confidentiality, integrity and availability for information within the scope of the information security management system; and
 2) identify the risk owners;
 d) analyses the information security risks:
1) assess the potential consequences that would result if the risks identified in 6.1.2 c) 1) were to materialize;
 2) assess the realistic likelihood of the occurrence of the risks identified in 6.1.2 c) 1); and 
3) determine the levels of risk; e) evaluates the information security risks: 1) compare the results of risk analysis with the risk criteria established in 6.1.2 a); and 2) prioritize the analyzed risks for risk treatment. The organization shall retain documented information about the information security risk assessment process.
",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause  6-1-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Actions to address risks and opportunities- Information security risk assessment'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Clause 6-1-3",
                    "long_name" => "Clause 6-1-3",
                    "description" => "The organization shall define and apply an information security risk treatment process to:
 a) select appropriate information security risk treatment options, taking account of the risk 
assessment results;
 b) determine all controls that are necessary to implement the information security risk treatment 
option(s) chosen;
 NOTE 1 Organizations can design controls as required, or identify them from any source.
 c) compare the controls determined in 6.1.3 b) above with those in Annex A and verify that no 
necessary controls have been omitted;
 NOTE 2 Annex A contains a list of possible information security controls. Users of this document are 
directed to Annex A to ensure that no necessary information security controls are overlooked.
 NOTE 3 The information security controls listed in Annex A are not exhaustive and additional information 
security controls can be included if needed.
 d) produce a Statement of Applicability that contains:
 — the necessary controls (see 6.1.3 b) and c));— justification for their inclusion;
 — whether the necessary controls are implemented or not; and
 — the justification for excluding any of the Annex A controls.
 e) formulate an information security risk treatment plan; and
 f) obtain risk owners’ approval of the information security risk treatment plan and acceptance of the 
residual information security risks.
 The organization shall retain documented information about the information security risk treatment 
process.",
                    "supplemental_guidance" => null,
                    "control_number" => "IClause 6-1-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Actions to address risks and opportunities-Information security risk treatment'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [
                    "short_name" => "ISO Clause 6-2",
                    "long_name" => "Clause 6-2",
                    "description" => "The organization shall establish information security objectives at relevant functions and levels. The information security objectives shall:
 a) be consistent with the information security policy;
 b) be measurable (if practicable); 
c) take into account applicable information security requirements, and results from risk assessment and risk treatment;
 d) be monitored;
 e) be communicated;
 f) be updated as appropriate;
 g) be available as documented information. The organization shall retain documented information on the information security objectives. When planning how to achieve its information security objectives, the organization shall determine: 
h) what will be done;
 i)  what resources will be required;
j) who will be responsible; 
k) when it will be completed; and 
l)  how the results will be evaluated.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 6-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information security objectives and planning to achieve them'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Clause  6-3",
                    "long_name" => "Clause  6-3",
                    "description" => "When the organization determines the need for changes to the information security management system, the changes shall be carried out in a planned manner.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause  6-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Planning of changes'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Clause 7-1",
                    "long_name" => "Clause 7-1",
                    "description" => "The organization shall determine and provide the resources needed for the establishment, implementation, maintenance and continual improvement of the information security management system.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 7-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Resources'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [
                    "short_name" => "ISO Clause 7-2",
                    "long_name" => "Clause 7-2",
                    "description" => "The organization shall:
 a) determine the necessary competence of person(s) doing work under its control that affects its information security performance; 
b) ensure that these persons are competent on the basis of appropriate education, training, or experience; c) where applicable, take actions to acquire the necessary competence, and evaluate the effectiveness of the actions taken; and
 d) retain appropriate documented information as evidence of competence.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 7-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Competence'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "ISO Clause 7-3",
                    "long_name" => "Clause 7-3",
                    "description" => "Persons doing work under the organization’s control shall be aware of:
 a) the information security policy;
 b) their contribution to the effectiveness of the information security management system, including 
the benefits of improved information security performance; and
 c) the implications of not conforming with the information security management system 
requirements.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 7-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Awareness'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Clause 7-4",
                    "long_name" => "Clause 7-4",
                    "description" => " The organization shall determine the need for internal and external communications relevant to the 
information security management system including:
 a) on what to communicate;
 b) when to communicate;
 c) with whom to communicate;
 d) how to communicate.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 7-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Communication'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],

                [
                    "short_name" => "ISO Clause 7-5-1",
                    "long_name" => "Clause 7-5-1",
                    "description" => "The organization’s information security management system shall include:
 a) documented information required by this document; and 
b) documented information determined by the organization as being necessary for the effectiveness 
of the information security management system.
",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 7-5-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('RDocumented information-General'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "ISO Clause 7-5-2",
                    "long_name" => "Clause 7-5-2",
                    "description" => "When creating and updating documented information the organization shall ensure appropriate:
 a) identification and description (e.g. a title, date, author, or reference number);
 b) format (e.g. language, software version, graphics) and media (e.g. paper, electronic); and 
c) review and approval for suitability and adequacy.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 7-5-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Documented information- Creating and updating'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],


                [
                    "short_name" => "ISO Clause 7-5-3",
                    "long_name" => "Clause 7-5-3",
                    "description" => "Return of assets  => \r\nAll employees and external party users shall return all of the organizational assets in their possession upon termination of their employment, contract or agreement.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 7-5-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Documented information- Control of documented information'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "ISO Clause 8-1",
                    "long_name" => "Clause 8-1",
                    "description" => "The organization shall plan, implement and control the processes needed to meet requirements, and to 
implement the actions determined in Clause 6, by: 
— establishing criteria for the processes; 
— implementing control of the processes in accordance with the criteria. 
Documented information shall be available to the extent necessary to have confidence that the 
processes have been carried out as planned. The organization shall control planned changes and review the consequences of unintended changes, 
taking action to mitigate any adverse effects, as necessary. 
The organization shall ensure that externally provided processes, products or services that are relevant 
to the information security management system are controlled.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 8-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Operational planning and control'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "ISO Clause 8-2",
                    "long_name" => "Clause 8-2",
                    "description" => "The organization shall perform information security risk assessments at planned intervals or when significant changes are proposed or occur, taking account of the criteria established in 6.1.2 a). The organization shall retain documented information of the results of the information security risk assessments.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 8-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information security risk assessment'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "ISO Clause 8-3",
                    "long_name" => "Clause 8-3",
                    "description" => "The organization shall implement the information security risk treatment plan. The organization shall retain documented information of the results of the information security risk treatment.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 8-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information security risk treatment'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [
                    "short_name" => "ISO Clause 9-1",
                    "long_name" => "Clause 9-1",
                    "description" => "The organization shall determine:
 a) what needs to be monitored and measured, including information security processes and controls;
 b) the methods for monitoring, measurement, analysis and evaluation, as applicable, to ensure valid results. The methods selected should produce comparable and reproducible results to be considered valid; c) when the monitoring and measuring shall be performed; 
d) who shall monitor and measure; 
e) when the results from monitoring and measurement shall be analyzed and evaluated; 
f) who shall analyze and evaluate these results. Documented information shall be available as evidence of the results. The organization shall evaluate the information security performance and the effectiveness of the information security management system.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 9-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Monitoring, measurement, analysis and evaluation'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Clause 9-2-1",
                    "long_name" => "Clause 9-2-1",
                    "description" => "The organization shall conduct internal audits at planned intervals to provide information on whether the information security management system: 
a) conforms to 
1) the organization’s own requirements for its information security management system;
 2) the requirements of this document;
 b) is effectively implemented and maintained.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 9-2-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Internal audit-General'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "ISO Clause 9-2-2",
                    "long_name" => "Clause 9-2-2",
                    "description" => "The organization shall plan, establish, implement and maintain an audit program (s), including the frequency, methods, responsibilities, planning requirements and reporting. When establishing the internal audit program(s), the organization shall consider the importance of the processes concerned and the results of previous audits. The organization shall: 
a) define the audit criteria and scope for each audit; 
b) select auditors and conduct audits that ensure objectivity and the impartiality of the audit process;
 c) ensure that the results of the audits are reported to relevant management; Documented information shall be available as evidence of the implementation of the audit program(s) and the audit results.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 9-2-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Internal audit-Internal audit programme'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "ISO Clause 9-3-1",
                    "long_name" => "Clause 9-3-1",
                    "description" => "Top management shall review the organization's information security management system at planned intervals to ensure its continuing suitability, adequacy and effectiveness.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 9-3-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Management review-General'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Clause 9-3-2",
                    "long_name" => "Clause 9-3-2",
                    "description" => "The management review shall include consideration of: 
a) the status of actions from previous management reviews;
 b) changes in external and internal issues that are relevant to the information security management system;
 c) changes in needs and expectations of interested parties that are relevant to the information security management system; 
d) feedback on the information security performance, including trends in:
 1) nonconformities and corrective actions;
 2) monitoring and measurement results; 
3) audit results; 
4) fulfilment of information security objectives; 
e) feedback from interested parties;
 f) results of risk assessment and status of risk treatment plan;
 g) opportunities for continual improvement.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 9-3-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Management review-Management review inputs'),
                    "control_owner" => "1",
                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Clause 9-3-3",
                    "long_name" => "Clause 9-3-3",
                    "description" => "The results of the management review shall include decisions related to continual improvement opportunities and any needs for changes to the information security management system. Documented information shall be available as evidence of the results of management reviews.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 9-3-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Management review-Management review results'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Clause 10-1",
                    "long_name" => "Clause 10-1",
                    "description" => "The organization shall continually improve the suitability, adequacy and effectiveness of the information security management system.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 10-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Continual improvement'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",


                ],
                [
                    "short_name" => "ISO Clause 10-2",
                    "long_name" => "Clause 10-2",
                    "description" => "When a nonconformity occurs, the organization shall: 
a) react to the nonconformity, and as applicable:
 1) take action to control and correct it; 
2) deal with the consequences; 
b) evaluate the need for action to eliminate the causes of nonconformity, in order that it does not recur or occur elsewhere, by: 
1) reviewing the nonconformity; 
2) determining the causes of the nonconformity; and 
3) determining if similar nonconformities exist, or could potentially occur; 
c) implement any action needed; 
d) review the effectiveness of any corrective action taken; and
 e) make changes to the information security management system, if necessary. Corrective actions shall be appropriate to the effects of the nonconformities encountered. Documented information shall be available as evidence of: 
f) the nature of the nonconformities and any subsequent actions taken,
 g) the results of any corrective action.",
                    "supplemental_guidance" => null,
                    "control_number" => "Clause 10-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Nonconformity and corrective action'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "ISO Annex 5-1",
                    "long_name" => "ISO Annex 5-1",
                    "description" => "Information security policy and topic-specific policies shall be de fined, approved by management, published, communicated to and acknowledged by relevant personnel and relevant interested parties, and reviewed at planned intervals and if significant changes occur.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Policies for information secu rity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-2",
                    "long_name" => "ISO Annex 5-2",
                    "description" => "Information security roles and responsibilities shall be defined and allocated according to the organization needs.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information security roles and responsibilities'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-3",
                    "long_name" => "ISO Annex 5-3",
                    "description" => "Conflicting duties and conflicting areas of responsibility shall be seg regated.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Segregation of duties'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-4",
                    "long_name" => "ISO Annex 5-4",
                    "description" => "Management shall require all personnel to apply information security in accordance with the established information security policy, top ic-specific policies and procedures of the organization.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Management responsibilities'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-5",
                    "long_name" => "ISO Annex 5-5",
                    "description" => "The organization shall establish and maintain contact with relevant authorities.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Contact with authorities'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-6",
                    "long_name" => "ISO Annex 5-6",
                    "description" => "The organization shall establish and maintain contact with special interest groups or other specialist security forums and professional associations",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Contact with special interest groups'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-7",
                    "long_name" => "ISO Annex 5-7",
                    "description" => "Information relating to information security threats shall be collected and analysed to produce threat intelligence.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-7",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Threat intelligence'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-8",
                    "long_name" => "ISO Annex 5-8",
                    "description" => "Information security shall be integrated into project management.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-8",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information security in project management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-9",
                    "long_name" => "ISO Annex 5-9",
                    "description" => "An inventory of information and other associated assets, including owners, shall be developed and maintained.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-9",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Inventory of information and other associated assets'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-10",
                    "long_name" => "ISO Annex 5-10",
                    "description" => "An inventory of information and other associated assets, including owners, shall be developed and maintained.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-10",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Acceptable use of information and other associated assets'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-11",
                    "long_name" => "ISO Annex 5-11",
                    "description" => "Personnel and other interested parties as appropriate shall return all the organization’s assets in their possession upon change or termination of their employment, contract or agreement.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-11",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Return of assets'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-12",
                    "long_name" => "ISO Annex 5-12",
                    "description" => "Information shall be classified according to the information security needs of the organization based on confidentiality, integrity, availability and relevant interested party requirements.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-12",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Classification of information'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-13",
                    "long_name" => "ISO Annex 5-13",
                    "description" => "An appropriate set of procedures for information labelling shall be developed and implemented in accordance with the information clas sification scheme adopted by the organization.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-13",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Labelling of information'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-14",
                    "long_name" => "ISO Annex 5-14",
                    "description" => "Information transfer rules, procedures, or agreements shall be in place for all types of transfer facilities within the organization and between the organization and other parties.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-14",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information transfer'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-15",
                    "long_name" => "ISO Annex 5-15",
                    "description" => "Rules to control physical and logical access to information and other associated assets shall be established and implemented based on busi ness and information security requirements.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-15",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Access control'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-16",
                    "long_name" => "ISO Annex 5-16",
                    "description" => "The full life cycle of identities shall be managed.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-16",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Identity management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex  5-17",
                    "long_name" => "ISO Annex  5-17",
                    "description" => "Allocation and management of authentication information shall be controlled by a management process, including advising personnel on appropriate handling of authentication information.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex  5-17",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Authentication information'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-18",
                    "long_name" => "ISO Annex 5-18",
                    "description" => "EAccess rights to information and other associated assets shall be provisioned, reviewed, modified and removed in accordance with the organization’s topic-specific policy on and rules for access control.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-18",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Access rights'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-19",
                    "long_name" => "ISO Annex 5-19",
                    "description" => "Processes and procedures shall be defined and implemented to manage the information security risks associated with the use of supplier’s products or services.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-19",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information security in supplier relationships'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-20",
                    "long_name" => "ISO Annex 5-20",
                    "description" => "Relevant information security requirements shall be established and agreed with each supplier based on the type of supplier relationship.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-20",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Addressing information security within supplier agreements'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-21",
                    "long_name" => "ISO Annex 5-21",
                    "description" => "Processes and procedures shall be defined and implemented to manage the information security risks associated with the ICT products and services supply chain.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-21",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Managing information security in the information and commu nication technology (ICT) supply chain'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-22",
                    "long_name" => "ISO Annex 5-22",
                    "description" => "The organization shall regularly monitor, review, evaluate and manage change in supplier information security practices and service delivery.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-22",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Monitoring, review and change management of supplier services'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-23",
                    "long_name" => "ISO Annex 5-23",
                    "description" => "Processes for acquisition, use, management and exit from cloud services shall be established in accordance with the organization’s information security requirements.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-23",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information security for use of cloud services'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-24",
                    "long_name" => "ISO Annex 5-24",
                    "description" => "The organization shall plan and prepare for managing information secu rity incidents by defining, establishing and communicating information security incident management processes, roles and responsibilities.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-24",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information security incident management planning and prepa ration'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-25",
                    "long_name" => "ISO Annex 5-25",
                    "description" => "The organization shall assess information security events and decide if they are to be categorized as information security incidents.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-25",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Assessment and decision on in formation security events'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-26",
                    "long_name" => "ISO Annex 5-26",
                    "description" => " Information security incidents shall be responded to in accordance with 
the documented procedures.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-26",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Response to information security incidents'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-27",
                    "long_name" => "ISO Annex 5-27",
                    "description" => "Knowledge gained from information security incidents shall be used to strengthen and improve the information security controls.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-27",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Learning from information se curity incidents'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-28",
                    "long_name" => "ISO Annex 5-28",
                    "description" => "The organization shall establish and implement procedures for the iden tification, collection, acquisition and preservation of evidence related to information security events.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-28",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Collection of evidences'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-29",
                    "long_name" => "ISO Annex 5-29",
                    "description" => "The organization shall plan how to maintain information security at an appropriate level during disruption.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-29",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information security during disruption'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-30",
                    "long_name" => "ISO Annex 5-30",
                    "description" => "ICT readiness shall be planned, implemented, maintained and tested based on business continuity objectives and ICT continuity requirements.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-30",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('ICT readiness for business con tinuity'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-31",
                    "long_name" => "ISO Annex 5-31",
                    "description" => "Legal, statutory, regulatory and contractual requirements relevant to information security and the organization’s approach to meet these requirements shall be identified, documented and kept up to date.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-31",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Legal, statutory, regulatory and contractual requirements'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-32",
                    "long_name" => "ISO Annex 5-32",
                    "description" => "The organization shall implement appropriate procedures to protect intellectual property rights.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-32",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Intellectual property rights'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-33",
                    "long_name" => "ISO Annex 5-33",
                    "description" => "Records shall be protected from loss, destruction, falsification, unau thorized access and unauthorized release.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-33",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Protection of records'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-34",
                    "long_name" => "ISO Annex 5-34",
                    "description" => "The organization shall identify and meet the requirements regarding the preservation of privacy and protection of PII according to applicable laws and regulations and contractual requirements.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-34",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Privacy and protection of person al identifiable information (PII)'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-35",
                    "long_name" => "ISO Annex 5-35",
                    "description" => "the organization’s approach to managing information security and 
its implementation including people, processes and technologies shall 
be reviewed independently at planned intervals, or when significant 
changes occur.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-35",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Independent review of information security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-36",
                    "long_name" => "ISO Annex 5-36",
                    "description" => "Compliance with the organization’s information security policy, top ic-specific policies, rules and standards shall be regularly reviewed.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-36",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Compliance with policies, rules and standards for information security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 5-37",
                    "long_name" => "ISO Annex 5-37",
                    "description" => "Operating procedures for information processing facilities shall be documented and made available to personnel who need them.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 5-37",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('security Documented operating procedures'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 6-1",
                    "long_name" => "ISO Annex 6-1",
                    "description" => "Background verification checks on all candidates to become personnel shall be carried out prior to joining the organization and on an ongoing basis taking into consideration applicable laws, regulations and ethics and be proportional to the business requirements, the classification of the information to be accessed and the perceived risks.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 6-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Screening'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 6-2",
                    "long_name" => "ISO Annex 6-2",
                    "description" => "The employment contractual agreements shall state the personnel’s and the organization’s responsibilities for information security.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 6-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Terms and conditions of employment'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 6-3",
                    "long_name" => "ISO Annex 6-3",
                    "description" => "Personnel of the organization and relevant interested parties shall receive appropriate information security awareness, education and training and regular updates of the organization's information security policy, topic-specific policies and procedures, as relevant for their job function.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 6-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information security awareness, education and training'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 6-4",
                    "long_name" => "ISO Annex 6-4",
                    "description" => "A disciplinary process shall be formalized and communicated to take actions against personnel and other relevant interested parties who have committed an information security policy violation.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 6-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Disciplinary process'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 6-5",
                    "long_name" => "ISO Annex 6-5",
                    "description" => "Information security responsibilities and duties that remain valid after termination or change of employment shall be defined, enforced and communicated to relevant personnel and other interested parties.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 6-5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Responsibilities after termination or change of employment'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 6-6",
                    "long_name" => "ISO Annex 6-6",
                    "description" => "Confidentiality or non-disclosure agreements reflecting the organ ization’s needs for the protection of information shall be identified, documented, regularly reviewed and signed by personnel and other relevant interested parties.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 6-6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Confidentiality or non-disclosure agreements'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 6-7",
                    "long_name" => "ISO Annex 6-7",
                    "description" => "Security measures shall be implemented when personnel are working remotely to protect information accessed, processed or stored outside the organization’s premises.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 6-7",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Remote working'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 6-8",
                    "long_name" => "ISO Annex 6-8",
                    "description" => "The organization shall provide a mechanism for personnel to report observed or suspected information security events through appropriate channels in a timely manner.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 6-8",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information security event re porting'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 7-1",
                    "long_name" => "ISO Annex 7-1",
                    "description" => "Security perimeters shall be defined and used to protect areas that contain information and other associated assets.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 7-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical security perimeters'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 7-2",
                    "long_name" => "ISO Annex 7-2",
                    "description" => "Secure areas shall be protected by appropriate entry controls and access points.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 7-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical entry'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 7-3",
                    "long_name" => "ISO Annex 7-3",
                    "description" => "Physical security for offices, rooms and facilities shall be designed and implemented",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 7-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Securing offices, rooms and facilities'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 7-4",
                    "long_name" => "ISO Annex 7-4",
                    "description" => "Premises shall be continuously monitored for unauthorized physical access.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 7-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Physical security monitoring'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 7-5",
                    "long_name" => "ISO Annex 7-5",
                    "description" => "Protection against physical and environmental threats, such as natural disasters and other intentional or unintentional physical threats to infrastructure shall be designed and implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 7-5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Protecting against physical and environmental threats'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 7-6",
                    "long_name" => "ISO Annex 7-6",
                    "description" => "Security measures for working in secure areas shall be designed and implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 7-6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Working in secure areas'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 7-7",
                    "long_name" => "ISO Annex 7-7",
                    "description" => "Clear desk rules for papers and removable storage media and clear screen rules for information processing facilities shall be defined and appropriately enforced.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 7-7",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Clear desk and clear screen'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 7-8",
                    "long_name" => "ISO Annex 7-8",
                    "description" => "Equipment shall be sited securely and protected.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 7-8",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Equipment siting and protection'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 7-9",
                    "long_name" => "ISO Annex 7-9",
                    "description" => "Off-site assets shall be protected.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 7-9",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Security of assets off-premises'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 7-10",
                    "long_name" => "ISO Annex 7-10",
                    "description" => "Storage media shall be managed through their life cycle of acquisition, use, transportation and disposal in accordance with the organization’s classification scheme and handling requirements.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 7-10",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Storage media'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 7-11",
                    "long_name" => "ISO Annex 7-11",
                    "description" => "Information processing facilities shall be protected from power failures and other disruptions caused by failures in supporting utilities.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 7-11",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Supporting utilities'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex  7-12",
                    "long_name" => "ISO Annex  7-12",
                    "description" => "Cables carrying power, data or supporting information services shall be protected from interception, interference or damage.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex  7-12",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Cabling security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 7-13",
                    "long_name" => "ISO Annex 7-13",
                    "description" => "Equipment shall be maintained correctly to ensure availability, integrity and confidentiality of information.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 7-13",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Equipment maintenance'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 7-14",
                    "long_name" => "ISO Annex 7-14",
                    "description" => "Items of equipment containing storage media shall be verified to en sure that any sensitive data and licensed software has been removed or securely overwritten prior to disposal or re-use.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 7-14",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Secure disposal or re-use of equipment'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-1",
                    "long_name" => "ISO Annex 8-1",
                    "description" => "Information stored on, processed by or accessible via user end point devices shall be protected.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-1",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('User end point devices'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-2",
                    "long_name" => "ISO Annex 8-2",
                    "description" => "The allocation and use of privileged access rights shall be restricted and managed.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-2",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Privileged access rights'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-3",
                    "long_name" => "ISO Annex 8-3",
                    "description" => "Access to information and other associated assets shall be restricted in accordance with the established topic-specific policy on access control",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-3",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information access restriction'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],

                [
                    "short_name" => "ISO Annex 8-4",
                    "long_name" => "ISO Annex 8-4",
                    "description" => "Read and write access to source code, development tools and software libraries shall be appropriately managed.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-4",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Access to source code'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-5",
                    "long_name" => "ISO Annex 8-5",
                    "description" => "Secure authentication technologies and procedures shall be implemented based on information access restrictions and the topic-specific policy on access control.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-5",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Secure authentication'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-6",
                    "long_name" => "ISO Annex 8-6",
                    "description" => "The use of resources shall be monitored and adjusted in line with current and expected capacity requirements.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-6",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Capacity management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-7",
                    "long_name" => "ISO Annex 8-7",
                    "description" => "Protection against malware shall be implemented and supported by appropriate user awareness.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-7",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Protection against malware'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-8",
                    "long_name" => "ISO Annex 8-8",
                    "description" => "Information about technical vulnerabilities of information systems in use shall be obtained, the organization’s exposure to such vulnerabilities shall be evaluated and appropriate measures shall be taken.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-8",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Management of technical vul nerabilities'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-9",
                    "long_name" => "ISO Annex 8-9",
                    "description" => "Configurations, including security configurations, of hardware, software, services and networks shall be established, documented, implemented, monitored and reviewed.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-9",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Configuration management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-10",
                    "long_name" => "ISO Annex 8-10",
                    "description" => "Information stored in information systems, devices or in any other storage media shall be deleted when no longer required.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-10",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information deletion'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-11",
                    "long_name" => "ISO Annex 8-11",
                    "description" => "Data masking shall be used in accordance with the organization’s topic-specific policy on access control and other related topic-specific policies, and business requirements, taking applicable legislation into consideration.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-11",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data masking'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-12",
                    "long_name" => "ISO Annex 8-12",
                    "description" => "Data leakage prevention measures shall be applied to systems, net works and any other devices that process, store or transmit sensitive information",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-12",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Data leakage prevention'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-13",
                    "long_name" => "ISO Annex 8-13",
                    "description" => "Backup copies of information, software and systems shall be maintained and regularly tested in accordance with the agreed topic-specific policy on backup.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-13",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Information backup'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-14",
                    "long_name" => "ISO Annex 8-14",
                    "description" => "Information processing facilities shall be implemented with redundancy sufficient to meet availability requirements",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-14",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Redundancy of information processing facilities'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-15",
                    "long_name" => "ISO Annex 8-15",
                    "description" => "Logs that record activities, exceptions, faults and other relevant events shall be produced, stored, protected and analysed.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-15",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Logging'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-16",
                    "long_name" => "ISO Annex 8-16",
                    "description" => "Networks, systems and applications shall be monitored for anomalous behaviour and appropriate actions taken to evaluate potential infor mation security incidents",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-16",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Monitoring activities'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-17",
                    "long_name" => "ISO Annex 8-17",
                    "description" => "The clocks of information processing systems used by the organization shall be synchronized to approved time sources.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-17",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Clock synchronization'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-18",
                    "long_name" => "ISO Annex 8-18",
                    "description" => "The use of utility programs that can be capable of overriding system and application controls shall be restricted and tightly controlled.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-18",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Use of privileged utility programs'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-19",
                    "long_name" => "ISO Annex 8-19",
                    "description" => "Procedures and measures shall be implemented to securely manage software installation on operational systems.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-19",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Installation of software on op erational systems'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-20",
                    "long_name" => "ISO Annex 8-20",
                    "description" => "Networks and network devices shall be secured, managed and controlled to protect information in systems and applications",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-20",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Networks security'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-21",
                    "long_name" => "ISO Annex 8-21",
                    "description" => "Security mechanisms, service levels and service requirements of network services shall be identified, implemented and monitored.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-21",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Security of network services'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-22",
                    "long_name" => "ISO Annex 8-22",
                    "description" => "Groups of information services, users and information systems shall be segregated in the organization’s networks.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-22",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Segregation of networks'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-23",
                    "long_name" => "ISO Annex 8-23",
                    "description" => "TAccess to external websites shall be managed to reduce exposure to malicious content.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-23",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Web filtering'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-24",
                    "long_name" => "ISO Annex 8-24",
                    "description" => "TRules for the effective use of cryptography, including cryptographic key management, shall be defined and implemented.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-24",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Use of cryptography'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-25",
                    "long_name" => "ISO Annex 8-25",
                    "description" => "Rules for the secure development of software and systems shall be established and applied.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-25",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Secure development life cycle'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-26",
                    "long_name" => "ISO Annex 8-26",
                    "description" => "Information security requirements shall be identified, specified and approved when developing or acquiring applications.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-26",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Application security requirements'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-27",
                    "long_name" => "ISO Annex 8-27",
                    "description" => "Principles for engineering secure systems shall be established, docu mented, maintained and applied to any information system development activities",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-27",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Secure system architecture and engineering principles'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-28",
                    "long_name" => "ISO Annex 8-28",
                    "description" => "Secure coding principles shall be applied to software development.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-28",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Secure coding'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-29",
                    "long_name" => "ISO Annex 8-29",
                    "description" => "Security testing processes shall be defined and implemented in the development life cycle.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-29",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Security testing in development and acceptance'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-30",
                    "long_name" => "ISO Annex 8-30",
                    "description" => "The organization shall direct, monitor and review the activities related to outsourced system development.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-30",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Outsourced development'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-31",
                    "long_name" => "ISO Annex 8-31",
                    "description" => "TDevelopment, testing and production environments shall be separated and secured.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-31",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Separation of development, test and production environments'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-32",
                    "long_name" => "ISO Annex 8-32",
                    "description" => "Changes to information processing facilities and information systems shall be subject to change management procedures.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-32",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Change management'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-33",
                    "long_name" => "ISO Annex 8-33",
                    "description" => "Test information shall be appropriately selected, protected and managed.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-33",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Test information'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ],
                [
                    "short_name" => "ISO Annex 8-34",
                    "long_name" => "ISO Annex 8-34",
                    "description" => "Audit tests and other assurance activities involving assessment of op erational systems shall be planned and agreed between the tester and appropriate management.",
                    "supplemental_guidance" => null,
                    "control_number" => "ISO Annex 8-34",
                    "control_status" => "Not Implemented",
                    "family" => $this->getFamilyIdByName('Protection of information sys tems during audit testing'),
                    "control_owner" => "1",

                    "submission_date" => $currentDateTime,
                    "status" => "1",
                    "deleted" => "0",

                ]
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