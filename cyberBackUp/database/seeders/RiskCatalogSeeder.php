<?php

namespace Database\Seeders;

use App\Models\RiskCatalog;
use Illuminate\Database\Seeder;

class RiskCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RiskCatalog::create([
            "id" => 1,
            "number" => 'R-AC-1',
            "risk_grouping_id" => 1,
            "name" => 'Inability to maintain individual accountability',
            "description" => 'There is a failure to maintain asset ownership and it is not possible to have non-repudiation of actions or inactions.',
            "risk_function_id" => 2,
            "order" => 1
        ]);
        RiskCatalog::create([
            "id" => 2,
            "number" => 'R-AC-2',
            "risk_grouping_id" => 1,
            "name" => 'Improper assignment of privileged risk_function_ids',
            "description" => 'There is a failure to implement least privileges.',
            "risk_function_id" => 2,
            "order" => 2
        ]);
        RiskCatalog::create([
            "id" => 3,
            "number" => 'R-AC-3',
            "risk_grouping_id" => 1,
            "name" => 'Privilege escalation',
            "description" => 'Access to privileged risk_function_ids is inadequate or cannot be controlled.',
            "risk_function_id" => 2,
            "order" => 3
        ]);
        RiskCatalog::create([
            "id" => 4,
            "number" => 'R-AC-4',
            "risk_grouping_id" => 1,
            "name" => 'Unauthorized access',
            "description" => 'Access is granted to unauthorized individuals, groups or services.',
            "risk_function_id" => 2,
            "order" => 4
        ]);
        RiskCatalog::create([
            "id" => 5,
            "number" => 'R-AM-1',
            "risk_grouping_id" => 2,
            "name" => 'Lost, damaged or stolen asset(s)',
            "description" => 'Asset(s) is/are lost, damaged or stolen.',
            "risk_function_id" => 2,
            "order" => 5
        ]);
        RiskCatalog::create([
            "id" => 6,
            "number" => 'R-AM-2',
            "risk_grouping_id" => 2,
            "name" => 'Loss of integrity through unauthorized changes ',
            "description" => 'Unauthorized changes corrupt the integrity of the system / application / service.',
            "risk_function_id" => 2,
            "order" => 6
        ]);
        RiskCatalog::create([
            "id" => 7,
            "number" => 'R-BC-1',
            "risk_grouping_id" => 3,
            "name" => 'Business interruption ',
            "description" => 'There is increased latency or a service outage that negatively impacts business operations.',
            "risk_function_id" => 5,
            "order" => 7
        ]);
        RiskCatalog::create([
            "id" => 8,
            "number" => 'R-BC-2',
            "risk_grouping_id" => 3,
            "name" => 'Data loss / corruption ',
            "description" => 'There is a failure to maintain the confidentiality of the data (compromise) or data is corrupted (loss).',
            "risk_function_id" => 5,
            "order" => 8
        ]);
        RiskCatalog::create([
            "id" => 12,
            "number" => 'R-BC-3',
            "risk_grouping_id" => 3,
            "name" => 'Reduction in productivity',
            "description" => 'User productivity is negatively affected by the incident.',
            "risk_function_id" => 2,
            "order" => 12
        ]);
        RiskCatalog::create([
            "id" => 13,
            "number" => 'R-EX-1',
            "risk_grouping_id" => 4,
            "name" => 'Loss of revenue ',
            "description" => 'A financial loss occures from either a loss of clients or inability to generate future revenue.',
            "risk_function_id" => 5,
            "order" => 13
        ]);
        RiskCatalog::create([
            "id" => 14,
            "number" => 'R-EX-2',
            "risk_grouping_id" => 4,
            "name" => 'Cancelled contract',
            "description" => 'A contract is cancelled due to a violation of a contract clause.',
            "risk_function_id" => 5,
            "order" => 14
        ]);
        RiskCatalog::create([
            "id" => 15,
            "number" => 'R-EX-3',
            "risk_grouping_id" => 4,
            "name" => 'Diminished competitive advantage',
            "description" => 'The competitive advantage of the organization is jeapordized.',
            "risk_function_id" => 5,
            "order" => 15
        ]);
        RiskCatalog::create([
            "id" => 16,
            "number" => 'R-EX-4',
            "risk_grouping_id" => 4,
            "name" => 'Diminished reputation ',
            "description" => 'Negative publicity tarnishes the organization\'s reputation.',
            "risk_function_id" => 5,
            "order" => 16
        ]);
        RiskCatalog::create([
            "id" => 17,
            "number" => 'R-EX-5',
            "risk_grouping_id" => 4,
            "name" => 'Fines and judgements',
            "description" => 'Legal and/or financial damages result from statutory / regulatory / contractual non-compliance.',
            "risk_function_id" => 5,
            "order" => 17
        ]);
        RiskCatalog::create([
            "id" => 18,
            "number" => 'R-EX-6',
            "risk_grouping_id" => 4,
            "name" => 'Unmitigated vulnerabilities',
            "description" => 'Umitigated technical vulnerabilities exist without compensating controls or other mitigation actions.',
            "risk_function_id" => 2,
            "order" => 18
        ]);
        RiskCatalog::create([
            "id" => 19,
            "number" => 'R-EX-7',
            "risk_grouping_id" => 4,
            "name" => 'System compromise',
            "description" => 'System / application / service is compromised affects its confidentiality, integrity,  availability and/or safety.',
            "risk_function_id" => 2,
            "order" => 19
        ]);
        RiskCatalog::create([
            "id" => 20,
            "number" => 'R-BC-4',
            "risk_grouping_id" => 3,
            "name" => 'Information loss / corruption or system compromise due to technical attack',
            "description" => 'Malware, phishing, hacking or other technical attacks compromise data, systems, applications or services.',
            "risk_function_id" => 2,
            "order" => 20
        ]);
        RiskCatalog::create([
            "id" => 21,
            "number" => 'R-BC-5',
            "risk_grouping_id" => 3,
            "name" => 'Information loss / corruption or system compromise due to non‐technical attack ',
            "description" => 'Social engineering, sabotage or other non-technical attack compromises data, systems, applications or services.',
            "risk_function_id" => 2,
            "order" => 21
        ]);
        RiskCatalog::create([
            "id" => 22,
            "number" => 'R-GV-1',
            "risk_grouping_id" => 5,
            "name" => 'Inability to support business processes',
            "description" => 'Implemented security /privacy practices are insufficient to support the organization\'s secure technologies & processes requirements.',
            "risk_function_id" => 2,
            "order" => 1
        ]);
        RiskCatalog::create([
            "id" => 24,
            "number" => 'R-GV-4',
            "risk_grouping_id" => 5,
            "name" => 'Inadequate internal practices ',
            "description" => 'Internal practices do not exist or are inadequate. Procedures fail to meet \"reasonable practices\" expected by industry standards.',
            "risk_function_id" => 2,
            "order" => 4
        ]);
        RiskCatalog::create([
            "id" => 25,
            "number" => 'R-GV-5',
            "risk_grouping_id" => 5,
            "name" => 'Inadequate third-party practices',
            "description" => 'Third-party practices do not exist or are inadequate. Procedures fail to meet \"reasonable practices\" expected by industry standards.',
            "risk_function_id" => 2,
            "order" => 5
        ]);
        RiskCatalog::create([
            "id" => 26,
            "number" => 'R-GV-3',
            "risk_grouping_id" => 5,
            "name" => 'Lack of roles & responsibilities',
            "description" => 'Documented security / privacy roles & responsibilities do not exist or are inadequate.',
            "risk_function_id" => 1,
            "order" => 3
        ]);
        RiskCatalog::create([
            "id" => 27,
            "number" => 'R-GV-2',
            "risk_grouping_id" => 5,
            "name" => 'Incorrect controls scoping',
            "description" => 'There is incorrect or inadequate controls scoping, which leads to a potential gap or lapse in security / privacy controls coverage.',
            "risk_function_id" => 1,
            "order" => 2
        ]);
        RiskCatalog::create([
            "id" => 28,
            "number" => 'R-GV-8',
            "risk_grouping_id" => 5,
            "name" => 'Illegal content or abusive action',
            "description" => 'There is abusive content / harmful speech / threats of violence / illegal content that negatively affect business operations.',
            "risk_function_id" => 1,
            "order" => 8
        ]);
        RiskCatalog::create([
            "id" => 29,
            "number" => 'R-SA-1',
            "risk_grouping_id" => 6,
            "name" => 'Inability to maintain situational awareness',
            "description" => 'There is an inability to detect incidents.',
            "risk_function_id" => 3,
            "order" => 29
        ]);
        RiskCatalog::create([
            "id" => 30,
            "number" => 'R-SA-2',
            "risk_grouping_id" => 6,
            "name" => 'Lack of a security-minded workforce',
            "description" => 'The workforce lacks user-level understanding about security & privacy principles.',
            "risk_function_id" => 2,
            "order" => 30
        ]);
        RiskCatalog::create([
            "id" => 31,
            "number" => 'R-GV-6',
            "risk_grouping_id" => 5,
            "name" => 'Lack of oversight of internal controls',
            "description" => 'There is a lack of due diligence / due care in overseeing the organization\'s internal security / privacy controls.',
            "risk_function_id" => 1,
            "order" => 6
        ]);
        RiskCatalog::create([
            "id" => 32,
            "number" => 'R-GV-7',
            "risk_grouping_id" => 5,
            "name" => 'Lack of oversight of third-party controls',
            "description" => 'There is a lack of due diligence / due care in overseeing security / privacy controls operated by third-party service providers.',
            "risk_function_id" => 1,
            "order" => 7
        ]);
        RiskCatalog::create([
            "id" => 33,
            "number" => 'R-IR-1',
            "risk_grouping_id" => 7,
            "name" => 'Inability to investigate / prosecute incidents',
            "description" => 'Response actions either corrupt evidence or impede the ability to prosecute incidents.',
            "risk_function_id" => 4,
            "order" => 1
        ]);
        RiskCatalog::create([
            "id" => 34,
            "number" => 'R-IR-2',
            "risk_grouping_id" => 7,
            "name" => 'Improper response to incidents',
            "description" => 'Response actions fail to act appropriately in a timely manner to properly address the incident.',
            "risk_function_id" => 4,
            "order" => 2
        ]);
        RiskCatalog::create([
            "id" => 35,
            "number" => 'R-IR-3',
            "risk_grouping_id" => 7,
            "name" => 'Ineffective remediation actions',
            "description" => 'There is no oversight to ensure remediation actions are correct and/or effective.',
            "risk_function_id" => 2,
            "order" => 3
        ]);
        RiskCatalog::create([
            "id" => 36,
            "number" => 'R-IR-4',
            "risk_grouping_id" => 7,
            "name" => 'Expense associated with managing a loss event',
            "description" => 'There are financial repercussions from responding to an incident or loss.',
            "risk_function_id" => 4,
            "order" => 4
        ]);
    }
}
