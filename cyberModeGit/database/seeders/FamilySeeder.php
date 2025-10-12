<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Family;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mainDomains = [
            /* NCA DOMAINS */

            // '1 Cybersecurity Governance',
            // '2 Cybersecurity Defense',
            // '3 CyberSecurity Resilience',
            // '4 Third-Party and Cloud Computing Cybersecurity',
            // '5 ICS CyberSecurity',
            [
                'name' => 'Cybersecurity Governance',
                'order' => '1',
            ],
            [
                'name' => 'Cybersecurity Defense',
                'order' => '2',
            ],
            [
                'name' => 'CyberSecurity Resilience',
                'order' => '3',
            ],
            [
                'name' => 'Third-Party and Cloud Computing Cybersecurity',
                'order' => '4',
            ],
            [
                'name' => 'ICS CyberSecurity',
                'order' => '5',
            ],

            /* SAMA DOMAINS */
            [
                'name' => 'Cyber Security Leadership and Governance',
                'order' => '6',
            ],
            [
                'name' => 'Cyber Security Risk Management and Compliance',
                'order' => '7',
            ],
            [
                'name' => 'Cyber Security Operations and Technology',
                'order' => '8',
            ],
            [
                'name' => 'Third Party Cyber Security',
                'order' => '9',
            ],

            /* ISO 27001 DOMAINS */
            [
                'name' => 'Annex A.5 – Information Security Policies',
                'order' => '10',
            ],
            [
                'name' => 'Annex A.6 – Organisation of Information Security',
                'order' => '11',
            ],
            [
                'name' => 'Annex A.7 – Human Resource Security',
                'order' => '12',
            ],
            [
                'name' => 'Annex A.8 – Asset Management',
                'order' => '13',
            ],
            [
                'name' => 'Annex A.9 – Access Control',
                'order' => '14',
            ],
            [
                'name' => 'Annex A.10 – Cryptography',
                'order' => '15',
            ],
            [
                'name' => 'Annex A.11 – Physical & Environmental Security',
                'order' => '16',
            ],
            [
                'name' => 'Annex A.12 – Operations Security',
                'order' => '17',
            ],
            [
                'name' => 'Annex A.13 – Communications Security',
                'order' => '18',
            ],
            [
                'name' => 'Annex A.14 – System Acquisition, Development & Maintenance',
                'order' => '19',
            ],
            [
                'name' => 'Annex A.15 – Supplier Relationships',
                'order' => '20',
            ],
            [
                'name' => 'Annex A.16 – Information Security Incident Management',
                'order' => '21',
            ],
            [
                'name' => 'Annex A.17 – Information Security Aspects of Business Continuity Management',
                'order' => '22',
            ],
            [
                'name' => 'Annex A.18 – Compliance',
                'order' => '23',
            ]
        ];
        foreach ($mainDomains as $mainDomain) {
            Family::create([
                'name' => $mainDomain['name'],
                'order' => $mainDomain['order'],
            ]);
        }

        $subDomains = [
            // '1-1 Cybersecurity Strategy',
            // '1-2 Cybersecurity Management',
            // '1-3 Cybersecurity Policies and Procedures',
            // '1-4 Cybersecurity Role and Responsibilities',
            // '1-5 Cybersecurity Risk Management',
            // '1-6 Cybersecurity in Information Technology Projects',
            // '1-7 Cybersecurity Regulatory Compliance',
            // '1-8 Cybersecurity Periodical Assessment and Audit',
            // '1-9 Cybersecurity in Human Resources',
            // '1-10 Cybersecurity Awareness and Training Program',
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
            // This sub-family added in last of file to match server ids
            // [
            //     'name' => 'Management Change in Cybersecurity',
            //     'order' => '11',
            // ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 1,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // '2-1 Asset Management',
            // '2-2 Identity and Access Management',
            // '2-3 Information System and Processing Facilities Protection',
            // '2-4 Email Protection',
            // '2-5 Networks Security Management',
            // '2-6 Mobile Devices Security',
            // '2-7 Data and Information Protection',
            // '2-8 Cryptography',
            // '2-9 Backup and Recovery Management',
            // '2-10 Vulnerabilities Management',
            // '2-11 Penetration Testing',
            // '2-12 Cybersecurity Event Logs and Monitoring Management',
            // '2-13 إدارة حوادث وتهديدات  اﻷمن السيبراني CyberSecurity Incident and Threat Management',
            // '2-14 Physical Security',
            // '2-15 Web Application Security',
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
            ]
            // Thses sub-families added in last of file to match server ids
            // [
            //     'name' => 'Key management',
            //     'order' => '16',
            // ],
            // [
            //     'name' => 'Application Security',
            //     'order' => '17',
            // ],
            // [
            //     'name' => 'System Development Security',
            //     'order' => '18',
            // ],
            // [
            //     'name' => 'Storage Media Security',
            //     'order' => '19',
            // ],
            // [
            //     'name' => 'Facility Processing and System Protection',
            //     'order' => '20',
            // ],
            // [
            //     'name' => 'secure Data Disposal',
            //     'order' => '21',
            // ],
            // [
            //     'name' =>
            //     'Cybersecurity for printers,scanners and Copy machines',
            //     'order' => '22',
            // ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 2,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // '3-1 Cybersecurity Resilience aspects of Business Continuity Management (BCM)'
            [
                'name' => 'Cybersecurity Resilience aspects of Business Continuity Management (BCM)',
                'order' => '1',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 3,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // '4-1 Third-Party Cybersecurity',
            // '4-2 Cloud Computing and hosting Cybersecurity',

            [
                'name' => 'Third-Party Cybersecurity',
                'order' => '1',
            ],
            [
                'name' => 'Cloud Computing and hosting Cybersecurity',
                'order' => '2',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 4,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // '5-1 Industrial Control Systems (ICS) Protection',
            [
                'name' => 'Industrial Control Systems (ICS) Protection',
                'order' => '1',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 5,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Cyber Security Leadership and Governance (6)
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
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 6,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Cyber Security Risk Management and Compliance (7)
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
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 7,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Cyber Security Operations and Technology (8)
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
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 8,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Third Party Cyber Security (9)
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
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 9,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Annex A.5 – Information Security Policies (10)
            [
                'name' => 'Management direction for information Security',
                'order' => '1',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 10,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Annex A.6 – Organisation of Information Security (11)
            [
                'name' => 'Internal organization',
                'order' => '1',
            ],
            [
                'name' => 'Mobile devices and teleworking',
                'order' => '2',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 11,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Annex A.7 – Human Resource Security (12)
            [
                'name' => 'Prior to employment',
                'order' => '1',
            ],
            [
                'name' => 'During employment',
                'order' => '2',
            ],
            [
                'name' => 'Termination and change of employment',
                'order' => '3',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 12,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Annex A.8 – Asset Management (13)
            [
                'name' => 'Responsibility for assets',
                'order' => '1',
            ],
            [
                'name' => 'Information classification',
                'order' => '2',
            ],
            [
                'name' => 'Media Handling',
                'order' => '3',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 13,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Annex A.9 – Access Control (14)
            [
                'name' => 'Business requirements of access Control',
                'order' => '1',
            ],
            [
                'name' => 'User access Management',
                'order' => '2',
            ],
            [
                'name' => 'User responsibilities',
                'order' => '3',
            ],
            [
                'name' => 'System and application access Control',
                'order' => '4',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 14,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Annex A.10  – Cryptography (15)
            [
                'name' => 'Cryptographic Controls',
                'order' => '1',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 15,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Annex A.11 – Physical & Environmental Security (16)
            [
                // 'name' => 'Secure areas',
                'name' => 'Ensuring Secure Physical and Environmental Areas',
                'order' => '1',
            ],
            [
                'name' => 'Equipment',
                'order' => '2',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 16,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Annex A.12 – Operations Security (17)
            [
                'name' => 'Operational Procedures and Responsibilities',
                'order' => '1',
            ],
            [
                'name' => 'Protection From Malware',
                'order' => '2',
            ],
            [
                'name' => 'Backup',
                'order' => '3',
            ],
            [
                'name' => 'Logging and Monitoring',
                'order' => '4',
            ],
            [
                'name' => 'Control of Operational Software',
                'order' => '5',
            ],
            [
                'name' => 'Technical Vulnerability Management',
                'order' => '6',
            ],
            [
                'name' => 'Information Systems and Audit Considerations',
                'order' => '7',
            ],

        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 17,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Annex A.13 – Communications Security (18)
            [
                'name' => 'Network Security Management',
                'order' => '1',
            ],
            [
                'name' => 'Information Transfer',
                'order' => '2',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 18,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Annex A.14 – System Acquisition, Development & Maintenance (19)
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
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 19,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Annex A.15 – Supplier Relationships (20)
            [
                'name' => 'Information Security in Supplier Relationships',
                'order' => '1',
            ],
            [
                'name' => 'Supplier Service Delivery Management',
                'order' => '2',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 20,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Annex A.16 – Information Security Incident Management (21)
            [
                // 'name' => 'Management of Information Security incidents and improvements',
                'name' => 'Management of Information Security incidents, events and Weaknesses',
                'order' => '1',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 21,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Annex A.17 – Information Security Aspects of Business Continuity Management (22)
            [
                'name' => 'Information Security Continuity',
                'order' => '1',
            ],
            [
                'name' => 'Redundancies',
                'order' => '2',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 22,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            // Annex A.18 – Compliance (23)
            [
                'name' => 'Compliance with legal and Contractual Requirements',
                'order' => '1',
            ],
            [
                'name' => 'Information Security Reviews',
                'order' => '2',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 23,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        // Some another sub-families for match server ids
        $subDomains = [
            [
                'name' => 'Management Change in Cybersecurity',
                'order' => '11',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 1,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }

        $subDomains = [
            [
                'name' => 'Key management',
                'order' => '16',
            ],
            [
                'name' => 'Application Security',
                'order' => '17',
            ],
            [
                'name' => 'System Development Security',
                'order' => '18',
            ],
            [
                'name' => 'Storage Media Security',
                'order' => '19',
            ],
            [
                'name' => 'Facility Processing and System Protection',
                'order' => '20',
            ],
            [
                'name' => 'secure Data Disposal',
                'order' => '21',
            ],
            [
                'name' =>
                'Cybersecurity for printers,scanners and Copy machines',
                'order' => '22',
            ]
        ];

        foreach ($subDomains as $subDomain) {
            Family::create([
                'parent_id' => 2,
                'name' => $subDomain['name'],
                'order' => $subDomain['order'],
            ]);
        }
    }
}
