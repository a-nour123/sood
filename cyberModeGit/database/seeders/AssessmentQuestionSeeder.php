<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssessmentQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Question::create([
            'id' => 2,
            'question' => 'Do you actively manage (inventory, track, and correct) all software on the network so that only authorized software is installed and can execute, and that unauthorized and unmanaged software',
            'answer_type' => 1,
            'control_id' => 8,
            'file_attachment' => 1,
            'question_logic' => 0,
            'risk_assessment' => 1,
            'compliance_assessment' => 1,
            'maturity_assessment' => 1,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-15 12:41:58'
        ]);

        Question::create([
            'id' => 21,
            'question' => '(3.1.1) Do we limit information system access to authorized users, processes acting on behalf of authorized users, or devices? (including other information systems)',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:02:26'
        ]);

        Question::create([
            'id' => 22,
            'question' => '(3.1.2) Do we limit access to the types of transactions and functions that authorized users are permitted to execute?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:09:58'
        ]);

        Question::create([
            'id' => 23,
            'question' => '(3.1.3.) Do we control CUI in accordance with approved authorizations?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:10:05'
        ]);

        Question::create([
            'id' => 24,
            'question' => '(3.1.4) Do we keep duties of individuals separated to reduce the risk of malevolent activity without collusion?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:10:11'
        ]);

        Question::create([
            'id' => 25,
            'question' => '(3.1.5) Do we employ the principle of least privilege, including specific security functions and privileged accounts?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:10:21'
        ]);

        Question::create([
            'id' => 26,
            'question' => '(3.1.6) Do we disallow the organization to use non-privileged accounts or roles when accessing non-security functions?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:10:26'
        ]);

        Question::create([
            'id' => 27,
            'question' => '(3.1.7) Do we prevent non-privileged users from executing privileged functions and audit the execution of such functions?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:14:03'
        ]);

        Question::create([
            'id' => 28,
            'question' => '(3.1.8) Do we limit unsuccessful logon attempts?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:14:13'
        ]);

        Question::create([
            'id' => 29,
            'question' => '(3.1.9) Do we provide privacy and security notices consistent with applicable CUI rules?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:14:19'
        ]);

        Question::create([
            'id' => 30,
            'question' => '(3.1.10) Do we use session lock with pattern hiding displays to prevent access/viewing of data after a period of inactivity?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:14:24'
        ]);

        Question::create([
            'id' => 31,
            'question' => '(3.1.11) Do we terminate a user session after a defined condition or time?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:14:31'
        ]);

        Question::create([
            'id' => 32,
            'question' => '(3.1.12) Do we monitor and control remote access sessions?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:15:03'
        ]);

        Question::create([
            'id' => 33,
            'question' => '(3.1.13) Do we employ cryptographic mechanisms to protect the confidentiality of remote access sessions?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:15:11'
        ]);

        Question::create([
            'id' => 34,
            'question' => '(3.1.14) Do we route remote access through managed access control points?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:15:18'
        ]);

        Question::create([
            'id' => 35,
            'question' => '(3.1.15) Does the system require authorization of remote execution of privileged commands and remote access to security relevant information?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:15:25'
        ]);

        Question::create([
            'id' => 36,
            'question' => '(3.1.16) Do we authorize wireless access prior to allowing such connections?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:15:31'
        ]);

        Question::create([
            'id' => 37,
            'question' => '(3.1.17) Do we protect wireless access using authentication and encryption?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:23:38'
        ]);

        Question::create([
            'id' => 38,
            'question' => '(3.1.18) Do we have guidelines and procedures in place to restrict the operation and connection of mobile devices?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:23:45'
        ]);

        Question::create([
            'id' => 39,
            'question' => '(3.1.19) Do we encrypt CUI on mobile devices?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:23:54'
        ]);

        Question::create([
            'id' => 40,
            'question' => '(3.1.20) Do we verify and control/limit connections to and use of external information systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:24:03'
        ]);

        Question::create([
            'id' => 41,
            'question' => '(3.1.21) Do we limit use of organizational portable storage devices on external information systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:24:11'
        ]);

        Question::create([
            'id' => 42,
            'question' => '(3.1.22) Do we prohibit posting or processing control information on publicly accessible information systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:24:16'
        ]);

        Question::create([
            'id' => 43,
            'question' => '(3.2.1) Do we ensure that managers, systems administrators, and users of organizational information systems are made aware of the security risks associated with their activities and of the ap',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:24:21'
        ]);

        Question::create([
            'id' => 44,
            'question' => '(3.2.2) Do we Ensure that organizational personnel are adequately trained to carry out their assigned information security-related duties and responsibilities?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:24:29'
        ]);

        Question::create([
            'id' => 45,
            'question' => '(3.2.3) Do we provide security awareness training on recognizing and reporting potential indicators of insider threats?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:24:35'
        ]);

        Question::create([
            'id' => 46,
            'question' => '(3.3.1) Do you create, protect, and retain information system audit records to the extent needed to enable the monitoring, analysis, investigations, and reporting of unlawful, unauthorized, o',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:24:40'
        ]);

        Question::create([
            'id' => 47,
            'question' => '(3.3.2) Do we ensure that the actions of individual information system users can be uniquely traced to those users so they can be held accountable for their actions?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:32:52'
        ]);

        Question::create([
            'id' => 48,
            'question' => '(3.3.3) Do we review and update audited events?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:32:58'
        ]);

        Question::create([
            'id' => 49,
            'question' => '(3.3.4) Do we have alerts in the event of an audit process failure?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:33:05'
        ]);

        Question::create([
            'id' => 50,
            'question' => '(3.3.5) Do we use automated mechanisms to integrate and correlate audit review, analysis, and reporting processes for investigation and response to indications of inappropriate, suspicious, o',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:33:11'
        ]);

        Question::create([
            'id' => 51,
            'question' => '(3.3.6) Do we provide audit reduction and report generation to support on-demand analysis and reporting?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:33:19'
        ]);

        Question::create([
            'id' => 52,
            'question' => '(3.3.7) Do we provide an information system capability that compares and synchronizes internal system clocks with an authoritative source to generate time stamps for audit records?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:33:26'
        ]);

        Question::create([
            'id' => 53,
            'question' => '(3.3.8) Do we protect audit information and audit tools from unauthorized access, modification, and deletion?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:33:32'
        ]);

        Question::create([
            'id' => 54,
            'question' => '(3.3.9) Do we limit management of audit functionality to a subset of privileged users?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:33:38'
        ]);

        Question::create([
            'id' => 55,
            'question' => '(3.4.1) Do we establish and maintain baseline configurations and inventories of organizational information systems (including hardware, software, firmware, and documentation) throughout the r',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:33:44'
        ]);

        Question::create([
            'id' => 56,
            'question' => '(3.4.2) Do we establish and enforce security configuration settings for information technology products employed in organizational information systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:33:52'
        ]);

        Question::create([
            'id' => 57,
            'question' => '(3.4.3) Do we track, review, approve/disapprove, and audit changes to information systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:42:19'
        ]);

        Question::create([
            'id' => 58,
            'question' => '(3.4.4) Do we analyze the security impact of changes prior to implementation?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:42:37'
        ]);

        Question::create([
            'id' => 59,
            'question' => '(3.4.5) Do we define, document, approve, and enforce physical and logical access restrictions associated with changes to the information system?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:42:44'
        ]);

        Question::create([
            'id' => 60,
            'question' => '(3.4.6) Do we employ the principle of least functionality by configuring the information system to provide only essential capabilities?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:42:49'
        ]);

        Question::create([
            'id' => 61,
            'question' => '(3.4.7) Do we restrict, disable, and prevent the use of nonessential programs, functions, ports, protocols, and services?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:43:04'
        ]);

        Question::create([
            'id' => 62,
            'question' => '(3.4.8) Do we apply deny-by-exception (blacklist) policy to prevent the use of unauthorized software or deny-all, permit-by-exception (whitelisting) policy to allow the execution of authorize',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:43:12'
        ]);

        Question::create([
            'id' => 63,
            'question' => '(3.4.9) Do we control and monitor user-installed software?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:43:17'
        ]);

        Question::create([
            'id' => 64,
            'question' => '(3.5.1) Do we identify information system users, processes acting on behalf of users, or devices?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:43:24'
        ]);

        Question::create([
            'id' => 65,
            'question' => '(3.5.2) Do we authenticate (or verify) the identities of those users, processes, or devices, as a prerequisite to allowing access to organizational information systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:43:32'
        ]);

        Question::create([
            'id' => 66,
            'question' => '(3.5.3) Do we use multi-factor authentication for local and network access to privileged accounts and for network access to non-privileged accounts?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:43:37'
        ]);

        Question::create([
            'id' => 67,
            'question' => '(3.5.4) Do we employ replay-resistant authentication mechanisms for network access to privileged and non-privileged accounts?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:54:23'
        ]);

        Question::create([
            'id' => 68,
            'question' => '(3.5.5) Do we prevent the reuse of identifiers for a defined period?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:54:30'
        ]);

        Question::create([
            'id' => 69,
            'question' => '(3.5.6) Do we disable identifiers after a defined period of inactivity?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:54:35'
        ]);

        Question::create([
            'id' => 70,
            'question' => '(3.5.7) Do we enforce a minimum password complexity and change of characters when new passwords are created?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:54:51'
        ]);

        Question::create([
            'id' => 71,
            'question' => '(3.5.8) Do we prohibit password reuse for a specified number of generations?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:54:46'
        ]);

        Question::create([
            'id' => 72,
            'question' => '(3.5.9) Do we allow temporary password use for system logons with an immediate change to a permanent password?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:54:57'
        ]);

        Question::create([
            'id' => 73,
            'question' => '(3.5.10) Do we store and transmit only encrypted representation of passwords?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:55:03'
        ]);

        Question::create([
            'id' => 74,
            'question' => '(3.5.11) Do we obscure feedback of authentication information?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:55:16'
        ]);

        Question::create([
            'id' => 75,
            'question' => '(3.6.1) Have we established an operational incident handling capability for organizational information systems that includes adequate preparation, detection, analysis, containment, recovery,',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:55:26'
        ]);

        Question::create([
            'id' => 76,
            'question' => '(3.6.2) Do we track, document, and report incidents to appropriate officials and/or authorities both internal and external to the organizations?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 17:55:32'
        ]);

        Question::create([
            'id' => 77,
            'question' => '(3.6.3) Do we test the organizational incident response capability?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:20:54'
        ]);

        Question::create([
            'id' => 78,
            'question' => '(3.7.1) Do we perform maintenance on organizational information systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:21:06'
        ]);

        Question::create([
            'id' => 79,
            'question' => '(3.7.2) Do we provide effective controls on the tools, techniques, mechanisms, and personnel used to conduct information system maintenance?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:21:17'
        ]);

        Question::create([
            'id' => 80,
            'question' => '(3.7.3) Do we ensure equipment removed for off-site maintenance is sanitized of any CUI?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:21:32'
        ]);

        Question::create([
            'id' => 81,
            'question' => '(3.7.4) Do we check media containing diagnostic and test programs for malicious code before the media are used in the information system?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:21:37'
        ]);

        Question::create([
            'id' => 82,
            'question' => '(3.7.5) Do we require multifaction authentication to establish non-local maintenance sessions via external network connections when non-local maintenance is complete?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:21:47'
        ]);

        Question::create([
            'id' => 83,
            'question' => '(3.7.6) Do we supervise the maintenance activities of maintenance personnel without required access authorization?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:21:52'
        ]);

        Question::create([
            'id' => 84,
            'question' => '(3.8.1) Do we protect (i.e., physically control and securely store) information system media  containing CUI, both paper and digital?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:21:59'
        ]);

        Question::create([
            'id' => 85,
            'question' => '(3.8.2) Do we limit access to CUI on information system media to authorized users?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:22:06'
        ]);

        Question::create([
            'id' => 86,
            'question' => '(3.8.3) Do we sanitize or destroy information system media containing CUI before disposal or release for reuse?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:22:13'
        ]);

        Question::create([
            'id' => 87,
            'question' => '(3.8.4) Do we mark media with the necessary CUI markings and distribution limitations?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:28:23'
        ]);

        Question::create([
            'id' => 88,
            'question' => '(3.8.5) Do we control access to media containing CUI and maintain accountability for media during transport outside of controlled areas?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:28:29'
        ]);

        Question::create([
            'id' => 89,
            'question' => '(3.8.6) Do we implement cryptographic mechanisms to protect the confidentiality of CUI stored on digital media during transport unless otherwise protected by alternative physical safeguards?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:28:35'
        ]);

        Question::create([
            'id' => 90,
            'question' => '(3.8.7) Do we control the use of removable media on information system components?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:28:40'
        ]);

        Question::create([
            'id' => 91,
            'question' => '(3.8.8) Do we prohibit the use of portable storage devices when such devices have no identifiable owner?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:28:45'
        ]);

        Question::create([
            'id' => 92,
            'question' => '(3.8.9) Do we protect the confidentiality of backup CUI as storage locations?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:28:50'
        ]);

        Question::create([
            'id' => 93,
            'question' => '(3.9.1) Do we screen individuals prior to authorizing access to information systems containing CUI?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:28:55'
        ]);

        Question::create([
            'id' => 94,
            'question' => '(3.9.2) Do we ensure that CUI and information systems containing CUI are protected during and after personnel actions such as terminations and transfers?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:29:00'
        ]);

        Question::create([
            'id' => 95,
            'question' => '(3.10.1) Do we limit physical access to organizational information systems, equipment, and the respective operating environments to authorized individuals?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:29:07'
        ]);

        Question::create([
            'id' => 96,
            'question' => '(3.10.2) Do we protect and monitor the physical facility and support infrastructure for those information systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:29:12'
        ]);

        Question::create([
            'id' => 97,
            'question' => '(3.10.3) Do we escort visitors and monitor visitor activity?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:34:32'
        ]);

        Question::create([
            'id' => 98,
            'question' => '(3.10.4) Do we maintain audit logs of physical access?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:34:37'
        ]);

        Question::create([
            'id' => 99,
            'question' => '(3.10.5) Do we control and manage physical access devices?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:34:42'
        ]);

        Question::create([
            'id' => 100,
            'question' => '(3.10.6) Do we enforce safeguarding measures for CUI at alternate work sites? (e.g. telework sites)',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:34:47'
        ]);

        Question::create([
            'id' => 101,
            'question' => '(3.11.1) Do we periodically assess the risk to organizational operations (including mission, functions, image, or reputation), organizational assets, and individuals, resulting from the opera',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:35:03'
        ]);

        Question::create([
            'id' => 102,
            'question' => '(3.11.2) Do we scan for vulnerabilities in the information system and applications periodically and when new vulnerabilities affecting the system are identified?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:35:09'
        ]);

        Question::create([
            'id' => 103,
            'question' => '(3.11.3) Do we remediate vulnerabilities in accordance with assessments of risk?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:35:19'
        ]);

        Question::create([
            'id' => 104,
            'question' => '(3.12.1) Do we periodically assess the security controls in organizational information systems to determine if the controls are effective in their application?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:35:24'
        ]);

        Question::create([
            'id' => 105,
            'question' => '(3.12.2) Do we develop and implement plans of action designed to correct deficiencies and reduce or eliminate vulnerabilities in organizational information systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:35:32'
        ]);

        Question::create([
            'id' => 106,
            'question' => '(3.12.3) Do we monitor information system security controls on an ongoing basis to ensure the continued effectiveness of the controls?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:35:37'
        ]);

        Question::create([
            'id' => 107,
            'question' => '(3.13.1) Do we monitor, control, and protect organizational communications (i.e. information transmitted or received by organizational information systems) at the external boundaries and key',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:41:21'
        ]);

        Question::create([
            'id' => 108,
            'question' => '(3.13.2) Do we employ architectural designs, software development techniques, and systems engineering principles that promote effective information security within organizations information s',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:41:27'
        ]);

        Question::create([
            'id' => 109,
            'question' => '(3.13.3) Do we separate user functionality from information system management functionality?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:41:33'
        ]);

        Question::create([
            'id' => 110,
            'question' => '(3.13.4) Do we prevent unauthorized and unintended information transfer via shared system resources?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:41:37'
        ]);

        Question::create([
            'id' => 111,
            'question' => '(3.13.5) Do we implement subnetworks for publicly accessible system components that are physically or logically separated from internal networks?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:41:42'
        ]);

        Question::create([
            'id' => 112,
            'question' => '(3.13.6) Do we deny network communications traffic by default and allow network communications by exception?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:41:48'
        ]);

        Question::create([
            'id' => 113,
            'question' => '(3.13.7) Do we prevent remote devices from simultaneously establishing non-remote connections with the information system and communicating via some other connection to resources in external',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:41:54'
        ]);

        Question::create([
            'id' => 114,
            'question' => '(3.13.8) Do we implement cryptographic mechanisms to prevent unauthorized disclosure of CUI during transmission unless otherwise protected by alternative physical safeguards?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:42:00'
        ]);

        Question::create([
            'id' => 115,
            'question' => '(3.13.9) Do we terminate network connections associated with communications sessions at the end of the sessions or after a defined period of inactivity?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:42:06'
        ]);

        Question::create([
            'id' => 116,
            'question' => '(3.13.10) Do we establish and manage cryptographic keys for cryptography employed in the information system?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:42:11'
        ]);

        Question::create([
            'id' => 117,
            'question' => '(3.13.12) Do we prohibit remote activation of collaborative computing devices and provide indication of devices in use to users present at the device?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:48:00'
        ]);

        Question::create([
            'id' => 118,
            'question' => '(3.13.13) Do we control and monitor the use of mobile code?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:48:05'
        ]);

        Question::create([
            'id' => 119,
            'question' => '(3.13.14) Do we control and monitor the use of voice over internet protocol (VOIP) technologies?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:48:10'
        ]);

        Question::create([
            'id' => 120,
            'question' => '(3.13.15) Do we protect the authenticity of communications sessions?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:48:16'
        ]);

        Question::create([
            'id' => 121,
            'question' => '(3.13.16) Do we protect the confidentiality of CUI at rest?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:48:21'
        ]);

        Question::create([
            'id' => 122,
            'question' => '(3.14.1) Do we identify, report, and correct information and information system flaws in a timely manner?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:48:28'
        ]);

        Question::create([
            'id' => 123,
            'question' => '(3.14.2) Do we provide protection from malicious code at appropriate locations within organizational information systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:48:33'
        ]);

        Question::create([
            'id' => 124,
            'question' => '(3.14.3) Do we monitor information system security alerts and advisories and take appropriate actions in response?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:48:38'
        ]);

        Question::create([
            'id' => 125,
            'question' => '(3.14.4) Do we update malicious code protection mechanisms when new releases are available?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:48:44'
        ]);

        Question::create([
            'id' => 126,
            'question' => '(3.14.5) Do we perform periodic scans of the information system and real-time scans of files from external sources as files are downloaded, opened, or executed?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 11:44:22',
            'updated_at' => '2023-11-16 18:48:52'
        ]);

        Question::create([
            'id' => 129,
            'question' => 'Have you established and implemented firewall and router configuration standards that include a formal process for approving and testing all network connections and changes to the firewall an',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 13:36:16',
            'updated_at' => '2023-11-14 13:36:16'
        ]);

        Question::create([
            'id' => 131,
            'question' => 'Do you have software-development policies and procedures to prevent cross-site scripting (XSS)?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 13:46:56',
            'updated_at' => '2023-11-14 13:46:56'
        ]);

        Question::create([
            'id' => 134,
            'question' => 'Have you established and implemented firewall and router configuration standards that include a current network diagram that identifies all connections between the cardholder data environment',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 13:54:32',
            'updated_at' => '2023-11-14 13:54:32'
        ]);

        Question::create([
            'id' => 135,
            'question' => 'Have you created a diagram that shows the flow all cardholder data across systems and networks?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 13:55:55',
            'updated_at' => '2023-11-14 13:55:55'
        ]);

        Question::create([
            'id' => 136,
            'question' => ' Do you have procedures to easily distinguish between onsite personnel and visitors to include revoking or terminating onsite personnel and expired visitor identification (such as ID badges)?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 13:57:56',
            'updated_at' => '2023-11-14 13:57:56'
        ]);

        Question::create([
            'id' => 137,
            'question' => 'Are there firewalls in place at each and every internet connection and between any demilitarized zone (DMZ) and any internal network zone?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 13:58:27',
            'updated_at' => '2023-11-14 13:58:27'
        ]);

        Question::create([
            'id' => 138,
            'question' => 'Do you have procedures in place for the description of groups, roles, and responsibilities for management of network components?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:01:06',
            'updated_at' => '2023-11-14 14:01:06'
        ]);

        Question::create([
            'id' => 139,
            'question' => 'Do you have software-development policies and procedures to prevent improper access control (such as insecure direct object references, failure to restrict URL access, directory traversal, an',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:01:24',
            'updated_at' => '2023-11-14 14:01:24'
        ]);

        Question::create([
            'id' => 140,
            'question' => 'Do you have documentation of business justification and approval for use of all services, protocols, and ports allowed, including documentation of security features implemented for those prot',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:03:30',
            'updated_at' => '2023-11-14 14:03:30'
        ]);

        Question::create([
            'id' => 141,
            'question' => 'Do you review firewall and router rule sets at least every six months?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:05:02',
            'updated_at' => '2023-11-14 14:05:02'
        ]);

        Question::create([
            'id' => 142,
            'question' => 'Do you have software-development policies and procedures to prevent improper access control (such as insecure direct object references, failure to restrict URL access, directory traversal, an',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:08:51',
            'updated_at' => '2023-11-14 14:08:51'
        ]);

        Question::create([
            'id' => 143,
            'question' => 'Have you created firewall and router configurations that restrict connections between untrusted networks and any system components in the cardholder data environment?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:09:31',
            'updated_at' => '2023-11-14 14:09:31'
        ]);

        Question::create([
            'id' => 144,
            'question' => 'Do you control physical access for onsite personnel to sensitive areas by ensuring access must be authorized and based on individual job function?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:10:47',
            'updated_at' => '2023-11-14 14:10:47'
        ]);

        Question::create([
            'id' => 145,
            'question' => 'Are there restrictions on inbound and outbound traffic to only that which is necessary for the cardholder data environment, and specifically deny all other traffic?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:11:07',
            'updated_at' => '2023-11-14 14:11:07'
        ]);

        Question::create([
            'id' => 146,
            'question' => 'Are router configuration files kept secure and synchronized?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:12:32',
            'updated_at' => '2023-11-14 14:12:32'
        ]);

        Question::create([
            'id' => 147,
            'question' => 'Do you control physical access for onsite personnel to sensitive areas by ensuring access is revoked immediately upon termination, and all physical access mechanisms, such as keys, access car',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:13:06',
            'updated_at' => '2023-11-14 14:13:06'
        ]);

        Question::create([
            'id' => 148,
            'question' => ' Do you have software-development policies and procedures to prevent cross-site request forgery (CSRF)?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:16:35',
            'updated_at' => '2023-11-14 14:16:35'
        ]);

        Question::create([
            'id' => 149,
            'question' => ' Do you have software-development policies and procedures to prevent the use of broken authentication and session management?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:19:45',
            'updated_at' => '2023-11-14 14:19:45'
        ]);

        Question::create([
            'id' => 150,
            'question' => ' Do you ensure that security policies and operational procedures for developing and maintaining secure systems and applications are documented, in use, and known to all affected parties?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:28:52',
            'updated_at' => '2023-11-14 14:28:52'
        ]);

        Question::create([
            'id' => 151,
            'question' => ' Do you limit access to system components and cardholder data to only those individuals whose job requires such access?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:32:07',
            'updated_at' => '2023-11-14 14:32:07'
        ]);

        Question::create([
            'id' => 152,
            'question' => 'Have you defined access needs for each role, including: System components and data resources that each role needs to access for their job function, Level of privilege required (for example, u',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:35:28',
            'updated_at' => '2023-11-14 14:35:28'
        ]);

        Question::create([
            'id' => 153,
            'question' => 'Do you prohibit direct public access between the internet and any system component in the cardholder data environment?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:35:59',
            'updated_at' => '2023-11-14 14:35:59'
        ]);

        Question::create([
            'id' => 154,
            'question' => 'Do you restrict access to privileged user IDs to least privileges necessary to perform job responsibility?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:37:15',
            'updated_at' => '2023-11-14 14:37:15'
        ]);

        Question::create([
            'id' => 155,
            'question' => 'Have you implemented a DMZ to limit inbound traffic to only system components that provide authorized publicly accessible services, protocols, and ports?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:37:35',
            'updated_at' => '2023-11-14 14:37:35'
        ]);

        Question::create([
            'id' => 156,
            'question' => 'Do you limit inbound internet traffic to IP addresses within the DMZ?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:39:02',
            'updated_at' => '2023-11-14 14:39:02'
        ]);

        Question::create([
            'id' => 157,
            'question' => 'Do you restrict access to privileged user IDs to least privileges necessary to perform job responsibility?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:39:06',
            'updated_at' => '2023-11-14 14:39:06'
        ]);

        Question::create([
            'id' => 158,
            'question' => 'Have you implemented anti-spoofing measures to detect and block forged source IP addresses from entering the network?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:41:03',
            'updated_at' => '2023-11-14 14:41:03'
        ]);

        Question::create([
            'id' => 159,
            'question' => 'Do you disallow unauthorized outbound traffic from the cardholder data environment to the internet?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:42:55',
            'updated_at' => '2023-11-14 14:42:55'
        ]);

        Question::create([
            'id' => 160,
            'question' => 'Do you assign access based on individual personnel',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:43:52',
            'updated_at' => '2023-11-14 14:43:52'
        ]);

        Question::create([
            'id' => 161,
            'question' => 'Do you require documented approval by authorized parties specifying required privileges?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:45:52',
            'updated_at' => '2023-11-14 14:45:52'
        ]);

        Question::create([
            'id' => 162,
            'question' => 'Do you permit only \"established\" connections into the network?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:46:10',
            'updated_at' => '2023-11-14 14:46:10'
        ]);

        Question::create([
            'id' => 163,
            'question' => 'Have you established an access control system(s) for systems components that restricts access based on a user\'s need to know, and is set to',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:47:35',
            'updated_at' => '2023-11-14 14:47:35'
        ]);

        Question::create([
            'id' => 164,
            'question' => 'Have you placed system components that store cardholder data (such as a database) in an internal network zone, segregated from the DMZ and other untrusted networks?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:47:42',
            'updated_at' => '2023-11-14 14:47:42'
        ]);

        Question::create([
            'id' => 165,
            'question' => ' Does your access control system(s) include coverage of all system components?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:48:54',
            'updated_at' => '2023-11-14 14:48:54'
        ]);

        Question::create([
            'id' => 166,
            'question' => 'Are private IP addresses and routing information inaccessible to unauthorized parties?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:49:11',
            'updated_at' => '2023-11-14 14:49:11'
        ]);

        Question::create([
            'id' => 167,
            'question' => ' Does your access control system(s) include assignment of privileges to individuals based on job classification and function?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:50:34',
            'updated_at' => '2023-11-14 14:50:34'
        ]);

        Question::create([
            'id' => 168,
            'question' => 'Have you ensured that security policies and operational procedures for managing firewalls are documented, in use, and known to all affected parties?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:52:02',
            'updated_at' => '2023-11-14 14:52:02'
        ]);

        Question::create([
            'id' => 169,
            'question' => 'Does your access control system(s) include a default \"deny-all\" setting?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:52:13',
            'updated_at' => '2023-11-14 14:52:13'
        ]);

        Question::create([
            'id' => 170,
            'question' => 'Have you changed all vendor-supplied defaults and removed or disabled unnecessary default accounts before installing systems onto the network?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:53:22',
            'updated_at' => '2023-11-14 14:53:22'
        ]);

        Question::create([
            'id' => 171,
            'question' => ' Do you ensure that security policies and operational procedures for restricting access to cardholder data are documented, in use, and known to all affected parties?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:53:29',
            'updated_at' => '2023-11-14 14:53:29'
        ]);

        Question::create([
            'id' => 172,
            'question' => 'Do you change all of the wireless vendor defaults at the time of installation, including but not limited to default wireless encryption keys, passwords, and SNMP community strings?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 1,
            'created_at' => '2023-11-14 14:54:28',
            'updated_at' => '2023-11-15 12:42:17'
        ]);

        Question::create([
            'id' => 173,
            'question' => 'Have you developed configuration standards for all system components, assured that these standards address all known security vulnerabilities and are consistent with industry-accepted system ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:55:48',
            'updated_at' => '2023-11-14 14:55:48'
        ]);

        Question::create([
            'id' => 174,
            'question' => 'Have you implemented only one primary function per server to prevent functions that require different security levels from co-existing on the same server?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:57:02',
            'updated_at' => '2023-11-14 14:57:02'
        ]);

        Question::create([
            'id' => 175,
            'question' => 'Have you defined and implemented policies and procedures to ensure proper user identification management for non-consumer users and administrators on all system components by immediately revo',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:58:14',
            'updated_at' => '2023-11-14 14:58:14'
        ]);

        Question::create([
            'id' => 176,
            'question' => 'Do you enable only necessary services, protocols, daemons, etc., as required to for the function of the system?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:58:16',
            'updated_at' => '2023-11-14 14:58:16'
        ]);

        Question::create([
            'id' => 177,
            'question' => 'Are visitors authorized before entering, and escorted at all times within, areas where cardholder data is processed and maintained?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 14:59:35',
            'updated_at' => '2023-11-14 14:59:35'
        ]);

        Question::create([
            'id' => 178,
            'question' => 'Have you implemented additional security features for any required services, protocols, or daemons that are considered to be insecure?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:00:00',
            'updated_at' => '2023-11-14 15:00:00'
        ]);

        Question::create([
            'id' => 179,
            'question' => ' Do you remove/disable inactive user accounts within 90 days?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:00:20',
            'updated_at' => '2023-11-14 15:00:20'
        ]);

        Question::create([
            'id' => 180,
            'question' => 'Have you configured security parameters to prevent misuse?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:01:22',
            'updated_at' => '2023-11-14 15:01:22'
        ]);

        Question::create([
            'id' => 181,
            'question' => 'Are visitors identified and given a badge or other identification that expires and that visibly distinguished the visitors from onsite personnel?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:01:25',
            'updated_at' => '2023-11-14 15:01:25'
        ]);

        Question::create([
            'id' => 182,
            'question' => ' Do you manage IDs used by third parties to access, support, or maintain system components via remote access by enabling only during the time period needed and disabled when not in use and by',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:02:10',
            'updated_at' => '2023-11-14 15:02:10'
        ]);

        Question::create([
            'id' => 183,
            'question' => 'Have you removed all unnecessary functionality, such as scripts, drivers, features, subsystems, file systems, and unnecessary web servers?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:02:22',
            'updated_at' => '2023-11-14 15:02:22'
        ]);

        Question::create([
            'id' => 184,
            'question' => 'Are visitors asked to surrender the badge or other identification before leaving the facility or at the date of expiration?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:03:15',
            'updated_at' => '2023-11-14 15:03:15'
        ]);

        Question::create([
            'id' => 185,
            'question' => 'Have you encrypted all non-console administrative access using strong cryptography?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:03:30',
            'updated_at' => '2023-11-14 15:03:30'
        ]);

        Question::create([
            'id' => 186,
            'question' => 'Do you make use of a visitor log to maintain a physical audit trail of visitor activity to the facility as well as computer rooms and data centers where cardholder data is stored or transmitt',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:04:59',
            'updated_at' => '2023-11-14 15:04:59'
        ]);

        Question::create([
            'id' => 187,
            'question' => 'Do you maintain an inventory of system components that are in scope for PCI DSS?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:05:23',
            'updated_at' => '2023-11-14 15:05:23'
        ]);

        Question::create([
            'id' => 188,
            'question' => 'Have you ensured that security policies and operational procedures for managing vendor defaults and other security parameters are documented, in use, and known to all affected parties?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:06:30',
            'updated_at' => '2023-11-14 15:06:30'
        ]);

        Question::create([
            'id' => 189,
            'question' => 'Are shared hosting providers protecting each entity\'s hosted environment and cardholder data?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:08:40',
            'updated_at' => '2023-11-14 15:08:40'
        ]);

        Question::create([
            'id' => 190,
            'question' => 'Do you limit repeated access attempts by locking out the user ID after not more than six attempts?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:09:50',
            'updated_at' => '2023-11-14 15:09:50'
        ]);

        Question::create([
            'id' => 191,
            'question' => 'Have you set the lockout duration to a minimum of 30 minutes or until an administrator enables the user ID?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:11:55',
            'updated_at' => '2023-11-14 15:11:55'
        ]);

        Question::create([
            'id' => 192,
            'question' => 'Do you store sensitive authentication data after authorization (even if encrypted)?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:12:16',
            'updated_at' => '2023-11-14 15:12:16'
        ]);

        Question::create([
            'id' => 193,
            'question' => 'If sensitive authentication data is received, do you render all data unrecoverable upon completion of the the authorization request?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:13:26',
            'updated_at' => '2023-11-14 15:13:26'
        ]);

        Question::create([
            'id' => 194,
            'question' => 'If a session has been idle for more than 15 minutes, do you require the user to re-authenticate to re-activate the terminal or session?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:13:40',
            'updated_at' => '2023-11-14 15:13:40'
        ]);

        Question::create([
            'id' => 195,
            'question' => 'Do you store the full contents of any track (from the magnetic stripe located on the back of a card, equivalent data contained on a chip, or elsewhere) after authorization?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:14:56',
            'updated_at' => '2023-11-14 15:14:56'
        ]);

        Question::create([
            'id' => 196,
            'question' => 'Do you use strong cryptography to render all authentication credentials (such as passwords/phrases) unreadable during transmission and storage on all system components?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:15:37',
            'updated_at' => '2023-11-14 15:15:37'
        ]);

        Question::create([
            'id' => 197,
            'question' => 'Do you store the card verification code or value (three-digit or four-digit number printed on the front or back of a payment card used to verify card-not-present transactions) after authoriza',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:16:03',
            'updated_at' => '2023-11-14 15:16:03'
        ]);

        Question::create([
            'id' => 198,
            'question' => 'Do you verify user identity before modifying any authentication credential, for example, performing password resets, provisioning new tokens, or generating new keys?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:17:16',
            'updated_at' => '2023-11-14 15:17:16'
        ]);

        Question::create([
            'id' => 199,
            'question' => 'Do you store the personal identification number (PIN) or the encrypted PIN block after authorization?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:17:16',
            'updated_at' => '2023-11-14 15:17:16'
        ]);

        Question::create([
            'id' => 200,
            'question' => 'Do you physically secure all media?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:17:24',
            'updated_at' => '2023-11-14 15:17:24'
        ]);


        Question::create([
            'id' => 201,
            'question' => 'Do you mask PAN when displayed (the first six and last four digits are the maximum number of digits to be displayed), such that only personnel with legitimate business need can see more than ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:18:19',
            'updated_at' => '2023-11-14 15:18:19'
        ]);



        Question::create([
            'id' => 202,
            'question' => 'If disk encryption is used, is logical access managed separately and independently of native operating system authentication and access control mechanisms? (decryption keys must not be associ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:21:56',
            'updated_at' => '2023-11-14 15:21:56'
        ]);



        Question::create([
            'id' => 203,
            'question' => 'Do you document and implement procedures to protect keys used to secure stored cardholder data against disclosure and misuse?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:23:05',
            'updated_at' => '2023-11-14 15:23:05'
        ]);



        Question::create([
            'id' => 204,
            'question' => 'Do you store media backups in a secure location, preferably an offsite facility, such as an alternate or backup site, or a commercial storage facility and review the location',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:23:46',
            'updated_at' => '2023-11-14 15:23:46'
        ]);



        Question::create([
            'id' => 205,
            'question' => 'Do you restrict access to cryptographic keys to the fewest number of custodians necessary?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:26:08',
            'updated_at' => '2023-11-14 15:26:08'
        ]);



        Question::create([
            'id' => 206,
            'question' => 'Are cryptographic keys stored in the fewest possible locations?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:28:11',
            'updated_at' => '2023-11-14 15:28:11'
        ]);



        Question::create([
            'id' => 207,
            'question' => 'Do you fully document and implement all key-management processes and procedures for cryptographic keys used for encryption of cardholder data including generation of strong cryptographic keys',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:29:12',
            'updated_at' => '2023-11-14 15:29:12'
        ]);



        Question::create([
            'id' => 208,
            'question' => 'Do your passwords/passphrases meet the following requirements, do passwords require a minimum length of at least seven characters and contain both numeric and alphabetic characters?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:29:44',
            'updated_at' => '2023-11-14 15:29:44'
        ]);



        Question::create([
            'id' => 209,
            'question' => 'Do you maintain strict control over the internal or external distribution of any kind of media as well as classify media so the sensitivity of the data can be determined?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:30:00',
            'updated_at' => '2023-11-14 15:30:00'
        ]);



        Question::create([
            'id' => 210,
            'question' => 'Do you fully document and implement all key-management processes and procedures for cryptographic keys used for encryption of cardholder data including secure cryptographic key distribution?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:30:16',
            'updated_at' => '2023-11-14 15:30:16'
        ]);



        Question::create([
            'id' => 211,
            'question' => 'Do you fully document and implement all key-management processes and procedures for cryptographic keys used for encryption of cardholder data including secure cryptographic key storage?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:31:14',
            'updated_at' => '2023-11-14 15:31:14'
        ]);



        Question::create([
            'id' => 212,
            'question' => ' Do you require users to change passwords/passphrases at least once every 90 days?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:31:14',
            'updated_at' => '2023-11-14 15:31:14'
        ]);



        Question::create([
            'id' => 213,
            'question' => 'Do you send media only by secured courier or other delivery method that can be accurately tracked?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:31:30',
            'updated_at' => '2023-11-14 15:31:30'
        ]);



        Question::create([
            'id' => 214,
            'question' => ' Do you disallow an individual to submit a new password/passphrase that is the same as any of the last four passwords/passphrases he or she has used?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:32:34',
            'updated_at' => '2023-11-14 15:32:34'
        ]);



        Question::create([
            'id' => 215,
            'question' => 'Do you perform cryptographic key changes for keys that have reached the end of their cryptoperiod based on industry best practices and guidelines?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:32:58',
            'updated_at' => '2023-11-14 15:32:58'
        ]);



        Question::create([
            'id' => 216,
            'question' => 'Do you ensure management approves any and all media that is moved from a secured area (including when media is distributed to individuals)?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:33:49',
            'updated_at' => '2023-11-14 15:33:49'
        ]);



        Question::create([
            'id' => 217,
            'question' => 'Do you have practices in place for the retirement or replacement of keys as deemed necessary when the integrity of the key has been weakened, or keys are suspected of being compromised?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:34:10',
            'updated_at' => '2023-11-14 15:34:10'
        ]);



        Question::create([
            'id' => 218,
            'question' => ' Do you set passwords/passphrases for first-time use and upon reset to a unique value for each user, and change immediately after the first use?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:34:36',
            'updated_at' => '2023-11-14 15:34:36'
        ]);



        Question::create([
            'id' => 219,
            'question' => 'Do you maintain strict control over the storage and accessibility of media?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:35:12',
            'updated_at' => '2023-11-14 15:35:12'
        ]);



        Question::create([
            'id' => 220,
            'question' => 'Do you secure all individual non-console administrative access and all remote access to the CDE using multi-factor authentication?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:36:19',
            'updated_at' => '2023-11-14 15:36:19'
        ]);



        Question::create([
            'id' => 221,
            'question' => 'If manual clear-text cryptographic key-management operations are used, are these operations being managed by using split knowledge and dual control?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:36:21',
            'updated_at' => '2023-11-14 15:36:21'
        ]);



        Question::create([
            'id' => 222,
            'question' => 'Do you properly maintain inventory logs of all media and conduct media inventories at least annually?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:36:21',
            'updated_at' => '2023-11-14 15:36:21'
        ]);



        Question::create([
            'id' => 223,
            'question' => 'Do you have procedures in places to prevent unauthorized substitution of cryptographic keys?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:37:35',
            'updated_at' => '2023-11-14 15:37:35'
        ]);



        Question::create([
            'id' => 224,
            'question' => 'Do you destroy physical media when it is no longer needed for business or legal reasons by shredding, incinerating, for materials that are to be destroyed?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:38:01',
            'updated_at' => '2023-11-14 15:38:01'
        ]);



        Question::create([
            'id' => 225,
            'question' => 'Do you incorporate multi-factor authentication for all non-console access into the CDE for personnel with administrative access?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:38:02',
            'updated_at' => '2023-11-14 15:38:02'
        ]);



        Question::create([
            'id' => 226,
            'question' => 'Do you require cryptographic key custodians to formally acknowledge that they understand and accept their key-custodian responsibilities?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:38:39',
            'updated_at' => '2023-11-14 15:38:39'
        ]);



        Question::create([
            'id' => 227,
            'question' => 'Do you incorporate multi-factor authentication for all remote network access (both user and administrator, and including third-party access for support or maintenance) originating from outsid',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:39:16',
            'updated_at' => '2023-11-14 15:39:16'
        ]);



        Question::create([
            'id' => 228,
            'question' => 'Do you ensure that security policies and operational procedures for protecting stored cardholder data are documented, in use, and known to all affected parties?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:39:45',
            'updated_at' => '2023-11-14 15:39:45'
        ]);



        Question::create([
            'id' => 229,
            'question' => 'Do you render cardholder data on electronic media unrecoverable so that cardholder data cannot be reconstructed?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:39:55',
            'updated_at' => '2023-11-14 15:39:55'
        ]);



        Question::create([
            'id' => 230,
            'question' => 'Do you document and communicate authentication policies and procedures to all users including guidance on selecting strong authentication credentials?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:40:35',
            'updated_at' => '2023-11-14 15:40:35'
        ]);



        Question::create([
            'id' => 231,
            'question' => 'Do you protect devices that capture payment card data via direct physical interaction with the card from tampering and substitution?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:41:39',
            'updated_at' => '2023-11-14 15:41:39'
        ]);



        Question::create([
            'id' => 232,
            'question' => 'Do you document and communicate authentication policies and procedures to all users including guidance for how users should protect their authentication credentials?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:42:02',
            'updated_at' => '2023-11-14 15:42:02'
        ]);



        Question::create([
            'id' => 233,
            'question' => 'Do you maintain and up-to-date list of devices including make, model of device, location of device, and device serial number or other method of unique identification?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:42:46',
            'updated_at' => '2023-11-14 15:42:46'
        ]);



        Question::create([
            'id' => 234,
            'question' => 'Do you document and communicate authentication policies and procedures to all users including instructions not to reuse previously used passwords?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:43:23',
            'updated_at' => '2023-11-14 15:43:23'
        ]);



        Question::create([
            'id' => 235,
            'question' => 'Do you periodically inspect device surfaces to detect tampering  or substitution ?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:44:13',
            'updated_at' => '2023-11-14 15:44:22'
        ]);



        Question::create([
            'id' => 236,
            'question' => 'Do you document and communicate authentication policies and procedures to all users including instruction to change passwords if there is any suspicion the password could be compromised?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:44:44',
            'updated_at' => '2023-11-14 15:44:44'
        ]);



        Question::create([
            'id' => 237,
            'question' => 'Do you provide training for personnel to be aware of attempted tampering or replacement of devices to include verification of the identity of any third-party persons claiming to be repair or ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:45:39',
            'updated_at' => '2023-11-14 15:45:39'
        ]);



        Question::create([
            'id' => 238,
            'question' => 'Do you prevent the use of group, shared, or generic IDs, passwords, or other authentication methods by use of the following policies and procedures: Generic user IDs are disabled or removed, ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:46:12',
            'updated_at' => '2023-11-14 15:46:12'
        ]);



        Question::create([
            'id' => 239,
            'question' => 'Do you provide training for personnel to be aware of attempted tampering or replacement of devices to include the denial of installation, replacement, and return of devices without verificati',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:47:14',
            'updated_at' => '2023-11-14 15:47:14'
        ]);



        Question::create([
            'id' => 240,
            'question' => 'Additional requirement for service providers only: As a service provider when using remote access to customer premises (for example, for support of POS systems or servers) do you use a unique',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:47:55',
            'updated_at' => '2023-11-14 15:47:55'
        ]);



        Question::create([
            'id' => 241,
            'question' => 'Do you provide training for personnel to be aware of attempted tampering or replacement of devices to include teaching awareness of suspicious behavior around devices ?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:48:27',
            'updated_at' => '2023-11-14 15:48:27'
        ]);



        Question::create([
            'id' => 242,
            'question' => 'When using other authentication mechanisms (for example, physical or logical security tokens, smart cards, certificates, etc.)do you assign authentication mechanisms to an individual account ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:49:05',
            'updated_at' => '2023-11-14 15:49:05'
        ]);



        Question::create([
            'id' => 243,
            'question' => 'Do you provide training for personnel to be aware of attempted tampering or replacement of devices to include instruction to report suspicious behavior and indications of device tampering or ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:49:49',
            'updated_at' => '2023-11-14 15:49:49'
        ]);



        Question::create([
            'id' => 244,
            'question' => 'When using other authentication mechanisms (for example, physical or logical security tokens, smart cards, certificates, etc.) do you ensure physical and/or logical controls must be in place ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:50:36',
            'updated_at' => '2023-11-14 15:50:36'
        ]);



        Question::create([
            'id' => 245,
            'question' => 'Do you ensure all access to any database containing cardholder data (including access by administrators, applications, and all other users) is restricted so that all user access to, user quer',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:51:45',
            'updated_at' => '2023-11-14 15:51:45'
        ]);



        Question::create([
            'id' => 246,
            'question' => 'Do you use strong cryptography and security protocols to safeguard sensitive cardholder data during transmission over open, public networks, including only trusted keys and certificates are a',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:52:16',
            'updated_at' => '2023-11-14 15:52:16'
        ]);



        Question::create([
            'id' => 247,
            'question' => 'Do you use strong cryptography and security protocols to safeguard sensitive cardholder data during transmission over open, public networks, including the protocol in use only supports secure',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:53:35',
            'updated_at' => '2023-11-14 15:53:35'
        ]);



        Question::create([
            'id' => 248,
            'question' => ' Do you ensure all access to any database containing cardholder data uses application IDs for database applications that can only be used by the database application?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:55:48',
            'updated_at' => '2023-11-14 15:55:48'
        ]);



        Question::create([
            'id' => 249,
            'question' => 'Do you ensure that security policies and operational procedures for identification and authentication are documented, in use, and known to all affected parties?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:56:53',
            'updated_at' => '2023-11-14 15:56:53'
        ]);



        Question::create([
            'id' => 250,
            'question' => ' Do you use appropriate facility entry controls to limit and monitor physical access to systems in the cardholder data environment?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:57:50',
            'updated_at' => '2023-11-14 15:57:50'
        ]);


        Question::create([
            'id' => 251,
            'question' => ' Do you use appropriate facility entry controls to limit and monitor physical access to systems in the cardholder data environment?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 15:59:14',
            'updated_at' => '2023-11-14 15:59:14'
        ]);



        Question::create([
            'id' => 252,
            'question' => 'Do you store secret and private keys used to encrypt/decrypt cardholder data in one (or more) of the following forms at all times: Encrypted with a key-encrypting key that is at least as stro',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:06:36',
            'updated_at' => '2023-11-14 16:06:36'
        ]);



        Question::create([
            'id' => 253,
            'question' => 'Additional requirement for service providers only: Do you maintain a documented description of the cryptographic architecture that includes details of all algorithms, protocols, and keys used',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:08:44',
            'updated_at' => '2023-11-14 16:08:44'
        ]);



        Question::create([
            'id' => 254,
            'question' => 'Do you render PAN unreadable anywhere it is stores (including on portable digital media, backup media, and in logs) by any of the following: One-way Hashes based on strong cryptography, trunc',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:09:51',
            'updated_at' => '2023-11-14 16:09:51'
        ]);



        Question::create([
            'id' => 255,
            'question' => 'Do you keep cardholder data storage to a minimum by implementing data retention and disposal policies, procedures and processes that include at least limiting data storage amount and retentio',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:10:59',
            'updated_at' => '2023-11-14 16:10:59'
        ]);



        Question::create([
            'id' => 256,
            'question' => 'Have you installed personal firewall software or equivalent functionality on all portable computing devices (including company and/or employee-owned) that connect to the internet when outside',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:12:02',
            'updated_at' => '2023-11-14 16:12:02'
        ]);



        Question::create([
            'id' => 257,
            'question' => 'Have you installed perimeter firewalls between all wireless networks and the cardholder data environment, and configured these firewalls to deny or, if traffic is necessary for business purpo',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:13:03',
            'updated_at' => '2023-11-14 16:13:03'
        ]);



        Question::create([
            'id' => 258,
            'question' => 'Do you use strong cryptography and security protocols to safeguard sensitive cardholder data during transmission over open, public networks, including encryption strength that is appropriate ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:15:27',
            'updated_at' => '2023-11-14 16:15:27'
        ]);



        Question::create([
            'id' => 259,
            'question' => 'Have you ensured wireless networks transmitting cardholder data or connected to the cardholder data environment, used industry best practices to implement strong encryption for authentication',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:17:35',
            'updated_at' => '2023-11-14 16:17:35'
        ]);



        Question::create([
            'id' => 260,
            'question' => 'Do you send unprotected PANs by end-user messaging technologies?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:18:34',
            'updated_at' => '2023-11-14 16:18:34'
        ]);



        Question::create([
            'id' => 261,
            'question' => 'Have you ensured that security policies and operational procedures for encrypting transmissions of cardholder data are documented, in use, and known to all affected parties?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:19:45',
            'updated_at' => '2023-11-14 16:19:45'
        ]);


        Question::create([
            'id' => 262,
            'question' => 'Have you deployed anti-virus software on all systems commonly affected by malicious software? (Particularly personal computers and servers.)',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:20:44',
            'updated_at' => '2023-11-14 16:20:44'
        ]);



        Question::create([
            'id' => 263,
            'question' => 'Do you ensure that security policies and operational procedures for restricting physical access to cardholder data are documented, in use, and known to all affected parties?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:21:26',
            'updated_at' => '2023-11-14 16:21:26'
        ]);



        Question::create([
            'id' => 264,
            'question' => 'Have you ensured that anti-virus programs are capable of detecting, removing, and protecting against all known types of malicious software?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:21:48',
            'updated_at' => '2023-11-14 16:21:48'
        ]);



        Question::create([
            'id' => 265,
            'question' => 'Do you periodically reevaluate systems considered to not be commonly affected by malicious software in order to confirm whether such systems continue to not require anti-virus software?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:22:47',
            'updated_at' => '2023-11-14 16:22:47'
        ]);



        Question::create([
            'id' => 266,
            'question' => 'Have you implemented audit trails to link all access to system components to each individual user?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:23:51',
            'updated_at' => '2023-11-14 16:23:51'
        ]);



        Question::create([
            'id' => 267,
            'question' => 'Do you ensure all anti-virus mechanisms are kept current?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:24:47',
            'updated_at' => '2023-11-14 16:24:47'
        ]);



        Question::create([
            'id' => 268,
            'question' => 'Have you implemented automated audit trails for all system components to reconstruct all individual user accesses to cardholder data?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:25:24',
            'updated_at' => '2023-11-14 16:25:24'
        ]);



        Question::create([
            'id' => 269,
            'question' => 'Have you implemented automated audit trails for all system components to reconstruct all actions taken by any individual with root or administrative privileges?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:27:26',
            'updated_at' => '2023-11-14 16:27:26'
        ]);



        Question::create([
            'id' => 270,
            'question' => 'Have you implemented automated audit trails for all system components to reconstruct access to all audit trails?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:28:45',
            'updated_at' => '2023-11-14 16:28:45'
        ]);



        Question::create([
            'id' => 271,
            'question' => 'Have you implemented automated audit trails for all system components to reconstruct all invalid logical access attempts?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:30:16',
            'updated_at' => '2023-11-14 16:30:16'
        ]);



        Question::create([
            'id' => 272,
            'question' => 'Have you implemented automated audit trails for all system components to reconstruct use of and changes to identification and authentication mechanisms-including but not limited to creation o',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:31:32',
            'updated_at' => '2023-11-14 16:31:32'
        ]);



        Question::create([
            'id' => 273,
            'question' => 'Have you implemented automated audit trails for all system components to reconstruct initialization, stopping, or pausing of the audit logs?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:32:39',
            'updated_at' => '2023-11-14 16:32:39'
        ]);



        Question::create([
            'id' => 274,
            'question' => 'Have you implemented automated audit trails for all system components to reconstruct creation and deletion of system-level objects?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:33:46',
            'updated_at' => '2023-11-14 16:33:46'
        ]);



        Question::create([
            'id' => 275,
            'question' => 'Do you record audit trail entries for all system components for user identification?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:35:07',
            'updated_at' => '2023-11-14 16:35:07'
        ]);



        Question::create([
            'id' => 276,
            'question' => 'Do you record audit trail entries for all system components and record each type of event?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:36:24',
            'updated_at' => '2023-11-14 16:36:24'
        ]);



        Question::create([
            'id' => 277,
            'question' => 'Do you ensure all anti-virus mechanisms perform periodic scans?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:47:17',
            'updated_at' => '2023-11-14 16:47:17'
        ]);



        Question::create([
            'id' => 278,
            'question' => 'Do you ensure that all anti-virus mechanisms generate audit logs which are retained per PCI DSS requirement 10.7?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:48:31',
            'updated_at' => '2023-11-14 16:48:31'
        ]);



        Question::create([
            'id' => 279,
            'question' => 'Have you ensured that anti-virus mechanisms are actively running and cannot be disabled or altered by users, unless specifically authorized by management on a case-by-case basis for a limited',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:50:05',
            'updated_at' => '2023-11-14 16:50:05'
        ]);



        Question::create([
            'id' => 280,
            'question' => 'Have you ensured that security policies and operational procedures for protecting systems against malware are documented, in use, and known to all affected parties? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:51:10',
            'updated_at' => '2023-11-14 16:51:10'
        ]);



        Question::create([
            'id' => 281,
            'question' => 'Have you established a process to identify security vulnerabilities, using reputable outside sources for security vulnerability information, and as assign a risk ranking to newly discovered s',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:52:10',
            'updated_at' => '2023-11-14 16:52:10'
        ]);



        Question::create([
            'id' => 282,
            'question' => 'Have you ensured that all system components and software are protected from known vulnerabilities by installing applicable vendor-supplied security patches within one month of release?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:53:13',
            'updated_at' => '2023-11-14 16:53:13'
        ]);



        Question::create([
            'id' => 283,
            'question' => 'Have you developed internal and external software applications (including web-based administrative access to applications) securely in accordance with PCI DSS? (for example, secure authentica',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:54:24',
            'updated_at' => '2023-11-14 16:54:24'
        ]);



        Question::create([
            'id' => 284,
            'question' => 'Have you developed internal and external software applications (including web-based administrative access to applications based on industry standards and/or best practices?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:55:22',
            'updated_at' => '2023-11-14 16:55:22'
        ]);



        Question::create([
            'id' => 285,
            'question' => 'Have you developed internal and external software applications (including web-based administrative access to applications incorporating information security throughout the software-developmen',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:56:26',
            'updated_at' => '2023-11-14 16:56:26'
        ]);



        Question::create([
            'id' => 286,
            'question' => 'Do you remove development, test and/or custom application accounts, user IDs, and passwords before applications become active or are released to customers?',
            'answer_type' => 1,
            'control_id' => 35,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 16:57:48',
            'updated_at' => '2023-11-15 12:43:29'
        ]);



        Question::create([
            'id' => 287,
            'question' => 'Do you review custom code prior to release to production or customers in order to identify any potential coding vulnerability (using either manual or automated processes) to include code chan',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:00:10',
            'updated_at' => '2023-11-14 17:00:10'
        ]);



        Question::create([
            'id' => 288,
            'question' => 'Do you review custom code prior to release to production or customers in order to identify any potential coding vulnerability (using either manual or automated processes) to include code revi',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:01:22',
            'updated_at' => '2023-11-14 17:01:22'
        ]);



        Question::create([
            'id' => 289,
            'question' => 'Do you record audit trail entries for all system components and record the data and time of occurrence?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:01:53',
            'updated_at' => '2023-11-14 17:01:53'
        ]);



        Question::create([
            'id' => 290,
            'question' => 'Do you review custom code prior to release to production or customers in order to identify any potential coding vulnerability (using either manual or automated processes) to include appropria',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:02:43',
            'updated_at' => '2023-11-14 17:02:43'
        ]);



        Question::create([
            'id' => 291,
            'question' => 'Do you review custom code prior to release to production or customers in order to identify any potential coding vulnerability (using either manual or automated processes) to include code-revi',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:03:42',
            'updated_at' => '2023-11-14 17:03:42'
        ]);



        Question::create([
            'id' => 292,
            'question' => ' Do you record audit trail entries for all system components and record the success or failure of each operation?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:04:10',
            'updated_at' => '2023-11-14 17:04:10'
        ]);



        Question::create([
            'id' => 293,
            'question' => 'Do you follow change control processes and procedures for all changes to system components?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:05:08',
            'updated_at' => '2023-11-14 17:05:08'
        ]);



        Question::create([
            'id' => 294,
            'question' => ' Do you record audit trail entries for all system components and record the origination of event?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:05:17',
            'updated_at' => '2023-11-14 17:05:17'
        ]);



        Question::create([
            'id' => 295,
            'question' => 'Do you separate development/test environments from production environments, and enforce the separation with access controls?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:06:13',
            'updated_at' => '2023-11-14 17:06:13'
        ]);



        Question::create([
            'id' => 296,
            'question' => 'Do you record audit trail entries for all system components and record the identity or name of affected data, system component, or resource?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:06:44',
            'updated_at' => '2023-11-14 17:06:44'
        ]);



        Question::create([
            'id' => 297,
            'question' => 'Do you have separation of duties between development/test and production environments?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:07:15',
            'updated_at' => '2023-11-14 17:07:15'
        ]);



        Question::create([
            'id' => 298,
            'question' => 'Using time-synchronization technology, do you synchronize all critical system clocks and times and ensure that critical systems have the correct and consistent time?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:07:48',
            'updated_at' => '2023-11-14 17:07:48'
        ]);



        Question::create([
            'id' => 299,
            'question' => 'Using time-synchronization technology, do you synchronize all critical system clocks and times and ensure time data is protected?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:08:52',
            'updated_at' => '2023-11-14 17:08:52'
        ]);



        Question::create([
            'id' => 300,
            'question' => 'Is production data being used for testing and development?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:09:19',
            'updated_at' => '2023-11-14 17:09:19'
        ]);



        Question::create([
            'id' => 301,
            'question' => 'Using time-synchronization technology, do you synchronize all critical system clocks and times and ensure time settings are received from industry-accepted time sources?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:09:51',
            'updated_at' => '2023-11-14 17:09:51'
        ]);



        Question::create([
            'id' => 302,
            'question' => 'Do you ensure removal of test data and accounts from system components before the system becomes active / goes into production? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:10:42',
            'updated_at' => '2023-11-14 17:10:42'
        ]);



        Question::create([
            'id' => 303,
            'question' => 'Do you secure audit trails so they cannot be altered?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:10:50',
            'updated_at' => '2023-11-14 17:10:50'
        ]);



        Question::create([
            'id' => 304,
            'question' => ' Do you limit viewing of audit trails to those with a job-related need?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:12:03',
            'updated_at' => '2023-11-14 17:12:03'
        ]);



        Question::create([
            'id' => 305,
            'question' => 'Do your change control procedures document impact? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:12:33',
            'updated_at' => '2023-11-14 17:12:33'
        ]);



        Question::create([
            'id' => 306,
            'question' => ' Do you protect audit trail files from unauthorized modifications?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:13:08',
            'updated_at' => '2023-11-14 17:13:08'
        ]);



        Question::create([
            'id' => 307,
            'question' => 'Do your change control procedures document change approval by authorized parties?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:14:06',
            'updated_at' => '2023-11-14 17:14:06'
        ]);



        Question::create([
            'id' => 308,
            'question' => 'Do you promptly back up audit trail files to a centralized log server or media that is difficult to alter?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:14:11',
            'updated_at' => '2023-11-14 17:14:11'
        ]);



        Question::create([
            'id' => 309,
            'question' => 'Do your change control procedures functionally test to verify that the change does not adversely impact the security of the system?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:15:09',
            'updated_at' => '2023-11-14 17:15:09'
        ]);



        Question::create([
            'id' => 310,
            'question' => 'Do your change control procedures contain back-out procedures?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:16:06',
            'updated_at' => '2023-11-14 17:16:06'
        ]);



        Question::create([
            'id' => 311,
            'question' => 'Upon completion of a significant change, do you reevaluate all relevant PCI DSS requirements and re-implement the requirements of PCI DSS in all new or changed systems and networks, and docum',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:17:28',
            'updated_at' => '2023-11-14 17:17:28'
        ]);



        Question::create([
            'id' => 312,
            'question' => 'Do you address common coding vulnerabilities in software-development processes by training developers at least annually in up-to-date secure coding techniques, including how to avoid common c',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:18:42',
            'updated_at' => '2023-11-14 17:18:42'
        ]);



        Question::create([
            'id' => 313,
            'question' => 'Have you developed software-development policies and procedures to prevent injection flaws, particularly SQL injection as well as OS Command injection, LDAP and Xpath injection flaws as well ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:20:38',
            'updated_at' => '2023-11-14 17:20:38'
        ]);



        Question::create([
            'id' => 314,
            'question' => 'Do you have software-development policies and procedures to prevent the use of buffer overflows by validating buffer boundaries and truncating input strings?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:21:59',
            'updated_at' => '2023-11-14 17:21:59'
        ]);



        Question::create([
            'id' => 315,
            'question' => ' Do you write logs for external-facing technologies onto a secure, centralized, internal log server or media device?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:22:39',
            'updated_at' => '2023-11-14 17:22:39'
        ]);



        Question::create([
            'id' => 316,
            'question' => 'Do you have software-development policies and procedures to prevent insecure cryptographic storage?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:22:55',
            'updated_at' => '2023-11-14 17:22:55'
        ]);



        Question::create([
            'id' => 317,
            'question' => '(10.5.5) Do you use file-integrity monitoring or change-detection software on logs to ensure that existing log data cannot be changed without generating alerts (although new data being added ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:23:44',
            'updated_at' => '2023-11-14 17:23:44'
        ]);



        Question::create([
            'id' => 318,
            'question' => 'Do you have software-development policies and procedures to prevent the occurrence of insecure communications?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:24:08',
            'updated_at' => '2023-11-14 17:24:08'
        ]);



        Question::create([
            'id' => 319,
            'question' => ' Do you review logs and security events for all system components to identify anomalies or suspicious activity?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:24:54',
            'updated_at' => '2023-11-14 17:24:54'
        ]);



        Question::create([
            'id' => 320,
            'question' => 'Do you review all security events, logs of all system components that store, process, or transmit CHD and/or SAD, logs of all critical system components, and logs of all servers and system co',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:25:51',
            'updated_at' => '2023-11-14 17:25:51'
        ]);



        Question::create([
            'id' => 321,
            'question' => 'Do you have software-development policies and procedures to prevent improper error handling?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:25:55',
            'updated_at' => '2023-11-14 17:25:55'
        ]);



        Question::create([
            'id' => 322,
            'question' => 'Are all \"high risk\" vulnerabilities identified in the vulnerability identification process (as defined in PCI DSS Requirement 6.1)?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:27:03',
            'updated_at' => '2023-11-14 17:27:03'
        ]);



        Question::create([
            'id' => 323,
            'question' => ' Do you review logs of all other system components periodically based on the organization',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:27:44',
            'updated_at' => '2023-11-14 17:27:44'
        ]);



        Question::create([
            'id' => 324,
            'question' => 'Do you have software-development policies and procedures to prevent cross-site scripting (XSS)?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:28:00',
            'updated_at' => '2023-11-14 17:28:00'
        ]);



        Question::create([
            'id' => 325,
            'question' => '(10.6.3) Do you follow up exceptions and anomalies identified during the review process?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:31:43',
            'updated_at' => '2023-11-14 17:31:43'
        ]);



        Question::create([
            'id' => 326,
            'question' => 'Do your usage policies define the use and maintenance of a list of company-approved products?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:32:01',
            'updated_at' => '2023-11-14 17:32:01'
        ]);



        Question::create([
            'id' => 327,
            'question' => 'Do your usage policies require automatic disconnecting of sessions through remote-access technologies after a specific period of inactivity?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:33:32',
            'updated_at' => '2023-11-14 17:33:32'
        ]);



        Question::create([
            'id' => 328,
            'question' => '(10.7) Do you retain audit trail history for at least one year, with a minimum of three months immediately available for analysis (for example, online, archived, or restorable from backup)?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:33:46',
            'updated_at' => '2023-11-14 17:33:46'
        ]);



        Question::create([
            'id' => 329,
            'question' => 'Do your usage policies define the requirement for activation of remote-access technologies for vendors and business partners is to be used only when needed by vendors and business partners, w',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:34:49',
            'updated_at' => '2023-11-14 17:34:49'
        ]);



        Question::create([
            'id' => 330,
            'question' => 'For personnel accessing cardholder data via remote-access technologies, Do you prohibit the copying, moving, and storage of cardholder data onto local hard drives and removable electronic med',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:35:51',
            'updated_at' => '2023-11-14 17:35:51'
        ]);



        Question::create([
            'id' => 331,
            'question' => '(10.8) Additional requirement for service providers only: Have you implemented a process for the timely detection and reporting of failures of critical security control systems, including but',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:37:11',
            'updated_at' => '2023-11-14 17:37:11'
        ]);



        Question::create([
            'id' => 332,
            'question' => 'Where there is an authorized business need, do the usage policies require the data be protected in accordance with all applicable PCI DSS requirements?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:37:19',
            'updated_at' => '2023-11-14 17:37:19'
        ]);



        Question::create([
            'id' => 333,
            'question' => '(10.8.1a) Additional requirement for service providers only: Do you respond to failures of any critical security controls in a timely manner, with processes for responding to failures includi',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:38:44',
            'updated_at' => '2023-11-14 17:38:44'
        ]);



        Question::create([
            'id' => 334,
            'question' => 'Do you ensure that the security policy and procedures clearly define information security responsibilities for all personnel?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:39:03',
            'updated_at' => '2023-11-14 17:39:03'
        ]);



        Question::create([
            'id' => 335,
            'question' => '(10.8.1b) Additional requirement for service providers only: Do you respond to failures of any critical security controls in a timely manner, with processes for responding to failures includi',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:41:36',
            'updated_at' => '2023-11-14 17:41:36'
        ]);



        Question::create([
            'id' => 336,
            'question' => 'Additional requirement for service providers only: Does executive management establish responsibility for the for the protection of cardholder data and a PCI DSS compliance program to include',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:41:53',
            'updated_at' => '2023-11-14 17:41:53'
        ]);



        Question::create([
            'id' => 337,
            'question' => '(10.8.1c) Additional requirement for service providers only: Do you respond to failures of any critical security controls in a timely manner, with processes for responding to failures includi',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:42:40',
            'updated_at' => '2023-11-14 17:42:40'
        ]);



        Question::create([
            'id' => 338,
            'question' => 'Additional requirement for service providers only: Does executive management establish responsibility for the for the protection of cardholder data and a PCI DSS compliance program to include',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:42:56',
            'updated_at' => '2023-11-14 17:42:56'
        ]);



        Question::create([
            'id' => 339,
            'question' => 'Have you assigned an individual or team to the responsibility of establishing, documenting, and distributing security policies and procedures?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:44:15',
            'updated_at' => '2023-11-14 17:44:15'
        ]);



        Question::create([
            'id' => 340,
            'question' => 'Have you assigned an individual or team to the responsibility of monitoring and analyzing security alerts and information, and distributing that information to the appropriate personnel?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:45:41',
            'updated_at' => '2023-11-14 17:45:41'
        ]);



        Question::create([
            'id' => 341,
            'question' => '10.8.1e) Additional requirement for service providers only: Do you respond to failures of any critical security controls in a timely manner, with processes for responding to failures includin',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:46:34',
            'updated_at' => '2023-11-14 17:46:34'
        ]);



        Question::create([
            'id' => 342,
            'question' => 'Have you assigned an individual or team to the responsibility of establishing, documenting, and distributing security incident response and escalation procedures to ensure timely and effectiv',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:46:50',
            'updated_at' => '2023-11-14 17:46:50'
        ]);



        Question::create([
            'id' => 343,
            'question' => '10.8.1f) Additional requirement for service providers only: Do you respond to failures of any critical security controls in a timely manner, with processes for responding to failures includin',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:47:29',
            'updated_at' => '2023-11-14 17:47:29'
        ]);



        Question::create([
            'id' => 344,
            'question' => 'Have you assigned an individual or team to the responsibility of administration of user accounts, including additions, deletions, and modifications?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:47:49',
            'updated_at' => '2023-11-14 17:47:49'
        ]);



        Question::create([
            'id' => 345,
            'question' => '(10.8.1g) Additional requirement for service providers only: Do you respond to failures of any critical security controls in a timely manner, with processes for responding to failures includi',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:49:23',
            'updated_at' => '2023-11-14 17:49:23'
        ]);



        Question::create([
            'id' => 346,
            'question' => 'Have you assigned an individual or team to the responsibility of monitoring and controlling all access to data?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:49:42',
            'updated_at' => '2023-11-14 17:49:42'
        ]);



        Question::create([
            'id' => 347,
            'question' => '(10.9) Do you ensure that security policies and operation procedures for monitoring all access to network resources and cardholder data are documented, in use, and known to all affected parti',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:50:21',
            'updated_at' => '2023-11-14 17:50:21'
        ]);



        Question::create([
            'id' => 348,
            'question' => 'Have you implemented a formal security awareness program to make all personnel aware of the cardholder data security policy and procedures?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:51:01',
            'updated_at' => '2023-11-14 17:51:01'
        ]);



        Question::create([
            'id' => 349,
            'question' => '(11.1) Do you implement processes to test for the presence of wireless access points (802.11), and detect and identify all authorized and unauthorized wireless access points on a quarterly ba',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:52:18',
            'updated_at' => '2023-11-14 17:52:18'
        ]);



        Question::create([
            'id' => 350,
            'question' => 'Do you educate personnel upon hire and at least annually thereafter?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:52:44',
            'updated_at' => '2023-11-14 17:52:44'
        ]);

        Question::create([
            'id' => 351,
            'question' => 'Do you require personnel to acknowledge at least annually that they have read and understood the security policy and procedures?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:53:38',
            'updated_at' => '2023-11-14 17:53:38'
        ]);



        Question::create([
            'id' => 352,
            'question' => '(11.1.1) Do you maintain an inventory of authorized wireless access points including a documented business justification?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:53:53',
            'updated_at' => '2023-11-14 17:53:53'
        ]);



        Question::create([
            'id' => 353,
            'question' => 'o you screen potential personnel prior to hire to minimize the risk of attacks from internal sources (for example, background checks, previous employment history, criminal record, credit hist',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:54:40',
            'updated_at' => '2023-11-14 17:54:40'
        ]);



        Question::create([
            'id' => 354,
            'question' => '(11.1.2) Have you implemented incident response procedures in the event unauthorized wireless access points are detected?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:55:25',
            'updated_at' => '2023-11-14 17:55:25'
        ]);



        Question::create([
            'id' => 355,
            'question' => 'Do you maintain and implement policies and procedures to manage service providers with whom cardholder data is shared, or that could affect the security of cardholder data, and maintain a lis',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:55:41',
            'updated_at' => '2023-11-14 17:55:41'
        ]);



        Question::create([
            'id' => 356,
            'question' => '(11.2) Do you run internal and external network vulnerability scans at least quarterly and after any significant changes in the network (such as new system component installations, changes in',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:56:44',
            'updated_at' => '2023-11-14 17:56:44'
        ]);



        Question::create([
            'id' => 357,
            'question' => 'Do you maintain a list of service providers including a description of the service provided?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:56:52',
            'updated_at' => '2023-11-14 17:56:52'
        ]);



        Question::create([
            'id' => 358,
            'question' => '11.2.1) Do you perform quarterly internal vulnerability scans and address vulnerabilities and perform rescans to verify that all',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:58:04',
            'updated_at' => '2023-11-14 17:58:04'
        ]);



        Question::create([
            'id' => 359,
            'question' => 'Do you maintain a written agreement with service providers that includes an acknowledgement that the service providers are responsible for the security of cardholder data the service provider',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:58:17',
            'updated_at' => '2023-11-14 17:58:17'
        ]);



        Question::create([
            'id' => 360,
            'question' => 'Do you ensure there is an established process for engaging service providers including proper due diligence prior to engagement?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:59:14',
            'updated_at' => '2023-11-14 17:59:14'
        ]);



        Question::create([
            'id' => 361,
            'question' => '(11.2.2) Do you perform quarterly external vulnerability scans, via an Approved Scanning Vendor (ASV) approved by the Payment Card Industry Security Standards Council (PCI SSC) and perform re',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 17:59:23',
            'updated_at' => '2023-11-14 17:59:23'
        ]);



        Question::create([
            'id' => 362,
            'question' => 'Do you maintain a program to monitor service providers',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:00:13',
            'updated_at' => '2023-11-14 18:00:13'
        ]);



        Question::create([
            'id' => 363,
            'question' => '(11.2.3) Do you perform internal and external scans, and rescans as needed, after any significant change and all scans are performed by qualified personnel?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:00:42',
            'updated_at' => '2023-11-14 18:00:42'
        ]);



        Question::create([
            'id' => 364,
            'question' => 'Do you maintain information about which PCI DSS requirements are managed by each service provider, and which are managed by the entity?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:01:41',
            'updated_at' => '2023-11-14 18:01:41'
        ]);



        Question::create([
            'id' => 365,
            'question' => '(11.3a) Have you implemented a methodology for penetration testing that is based on industry-accepted penetration testing approaches (for example, NIST SP800-155)?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:02:07',
            'updated_at' => '2023-11-14 18:02:07'
        ]);



        Question::create([
            'id' => 366,
            'question' => 'Additional requirement for service providers only: Do you acknowledge in writing to customers that you as a service provider are responsible for the security of cardholder data the service pr',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:02:36',
            'updated_at' => '2023-11-14 18:02:36'
        ]);



        Question::create([
            'id' => 367,
            'question' => '(11.3b) Have you implemented a methodology for penetration testing that includes coverage for the entire CDE perimeter and critical systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:03:14',
            'updated_at' => '2023-11-14 18:03:14'
        ]);



        Question::create([
            'id' => 368,
            'question' => 'Have you implemented an incident response plan and are prepared to respond immediately to a system breach?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:03:34',
            'updated_at' => '2023-11-14 18:03:34'
        ]);



        Question::create([
            'id' => 369,
            'question' => '11.3c) Have you implemented a methodology for penetration testing that includes testing from both inside and outside the network?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:04:46',
            'updated_at' => '2023-11-14 18:04:46'
        ]);



        Question::create([
            'id' => 370,
            'question' => '(11.3d) Have you implemented a methodology for penetration testing that includes testing to validate any segmentation and scope-reduction controls?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:05:49',
            'updated_at' => '2023-11-14 18:05:49'
        ]);



        Question::create([
            'id' => 371,
            'question' => 'Have you created an incident response plan to be initiated in the event of system breach?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:05:59',
            'updated_at' => '2023-11-14 18:05:59'
        ]);



        Question::create([
            'id' => 372,
            'question' => 'Does your incident response plan address roles, responsibilities, and communication and contact strategies in the event of a compromise including notification of the payment brands, at a mini',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:06:54',
            'updated_at' => '2023-11-14 18:06:54'
        ]);



        Question::create([
            'id' => 373,
            'question' => 'Does your incident response plan address specific incident response procedures?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:23:37',
            'updated_at' => '2023-11-14 18:23:37'
        ]);



        Question::create([
            'id' => 374,
            'question' => 'Does your incident response plan address business recovery and continuity procedures?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:24:32',
            'updated_at' => '2023-11-14 18:24:32'
        ]);



        Question::create([
            'id' => 375,
            'question' => 'Does your incident response plan address data backup processes?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:25:37',
            'updated_at' => '2023-11-14 18:25:37'
        ]);



        Question::create([
            'id' => 376,
            'question' => 'Does your incident response plan address analysis of legal requirements for reporting compromises?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:26:40',
            'updated_at' => '2023-11-14 18:26:40'
        ]);



        Question::create([
            'id' => 377,
            'question' => 'Does your incident response plan address coverage and responses of all critical system components?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:27:47',
            'updated_at' => '2023-11-14 18:27:47'
        ]);



        Question::create([
            'id' => 378,
            'question' => 'Does your incident response plan have reference to or inclusion of incident response procedures from the payment brands?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:28:43',
            'updated_at' => '2023-11-14 18:28:43'
        ]);



        Question::create([
            'id' => 379,
            'question' => 'Do you review and test the plan, including all elements listed in requirement 12.10.1, at least annually?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:30:33',
            'updated_at' => '2023-11-14 18:30:33'
        ]);



        Question::create([
            'id' => 380,
            'question' => 'Do you designate specific personnel to be available on a 24/7 basis to respond to alerts?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:31:46',
            'updated_at' => '2023-11-14 18:31:46'
        ]);



        Question::create([
            'id' => 381,
            'question' => 'Do you provide appropriate training to staff with security breach response responsibilities?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:32:43',
            'updated_at' => '2023-11-14 18:32:43'
        ]);



        Question::create([
            'id' => 382,
            'question' => 'Do you include alerts from security monitoring systems, including but not limited to intrusion-detection, intrusion-prevention, firewalls, and file-integrity monitoring systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:34:31',
            'updated_at' => '2023-11-14 18:34:31'
        ]);



        Question::create([
            'id' => 383,
            'question' => 'Do you develop a process to modify and evolve the incident response plan according to lessons learned and to incorporate industry developments?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:35:58',
            'updated_at' => '2023-11-14 18:35:58'
        ]);



        Question::create([
            'id' => 384,
            'question' => 'Additional requirement for service providers only: Do you perform reviews at least quarterly to confirm personnel are following security policies and operational procedures?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:37:38',
            'updated_at' => '2023-11-14 18:37:38'
        ]);



        Question::create([
            'id' => 385,
            'question' => 'Additional requirement for service providers only: Do your reviews cover daily log reviews?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:38:42',
            'updated_at' => '2023-11-14 18:38:42'
        ]);



        Question::create([
            'id' => 386,
            'question' => 'Additional requirement for service providers only: Do you review firewall rule-set reviews?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:40:08',
            'updated_at' => '2023-11-14 18:40:08'
        ]);



        Question::create([
            'id' => 387,
            'question' => 'Additional requirement for service providers only: Do you review applying configuration standards to new systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:41:07',
            'updated_at' => '2023-11-14 18:41:07'
        ]);



        Question::create([
            'id' => 388,
            'question' => 'Additional requirement for service providers only: Do you review responses to security alerts?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:42:04',
            'updated_at' => '2023-11-14 18:42:04'
        ]);



        Question::create([
            'id' => 389,
            'question' => 'Additional requirement for service providers only: Do you review change management processes?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:43:00',
            'updated_at' => '2023-11-14 18:43:00'
        ]);



        Question::create([
            'id' => 390,
            'question' => 'Do you use either video cameras or access control mechanisms (or both) to monitor individual physical access to sensitive areas and review collected data to correlate with other entries and s',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:43:28',
            'updated_at' => '2023-11-14 18:43:28'
        ]);



        Question::create([
            'id' => 391,
            'question' => 'Additional requirement for service providers only: Do you maintain documentation of quarterly review processes to include documenting results of the reviews as well as review and sign-off of ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:44:20',
            'updated_at' => '2023-11-14 18:44:20'
        ]);



        Question::create([
            'id' => 392,
            'question' => 'Do you restrict physical access to wireless access points, gateways, handheld devices, networking/communications hardware, and telecommunication lines?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:50:09',
            'updated_at' => '2023-11-14 18:50:09'
        ]);



        Question::create([
            'id' => 393,
            'question' => ' Do you have procedures to easily distinguish between onsite personnel and visitors by identifying onsite personnel and visitors visibly (for example, assigning badges)?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:52:58',
            'updated_at' => '2023-11-14 18:52:58'
        ]);



        Question::create([
            'id' => 394,
            'question' => 'Do you have procedures to easily distinguish between onsite personnel and visitors to include the use of changes to access requirements?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:54:28',
            'updated_at' => '2023-11-14 18:54:28'
        ]);



        Question::create([
            'id' => 395,
            'question' => 'Do you in addition to assigning a unique ID, ensure proper user-authentication management for non-consumer users and administrators on all system components by employing at least one of the f',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 18:59:05',
            'updated_at' => '2023-11-14 18:59:05'
        ]);



        Question::create([
            'id' => 396,
            'question' => 'Have you defined and implemented policies and procedures to ensure proper user identification management for non-consumer users and administrators on all system components by control addition',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:00:36',
            'updated_at' => '2023-11-14 19:00:36'
        ]);



        Question::create([
            'id' => 397,
            'question' => 'Have you defined and implemented policies and procedures to ensure proper user identification management for non-consumer users and administrators on all system components by assigning all us',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:02:03',
            'updated_at' => '2023-11-14 19:02:03'
        ]);



        Question::create([
            'id' => 398,
            'question' => ' Have you implemented a methodology for penetration testing that defines network-layer penetration tests to include components that support network functions as well as operating systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:05:36',
            'updated_at' => '2023-11-14 19:05:36'
        ]);



        Question::create([
            'id' => 399,
            'question' => 'For public-facing web applications, does your organization address new threats and vulnerabilities on an ongoing basis and ensure these applications are protected against known attacks by eit',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:08:05',
            'updated_at' => '2023-11-14 19:08:05'
        ]);



        Question::create([
            'id' => 400,
            'question' => ' Have you implemented a methodology for penetration testing that includes review and consideration of threats and vulnerabilities experienced in the last 12 months?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:13:36',
            'updated_at' => '2023-11-14 19:13:36'
        ]);



        Question::create([
            'id' => 401,
            'question' => ' Have you implemented a methodology for penetration testing that specifies retention of penetration testing results and remediation activities results?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:18:57',
            'updated_at' => '2023-11-14 19:18:57'
        ]);



        Question::create([
            'id' => 402,
            'question' => 'Do you perform external penetration testing at least annually and after any significant infrastructure or application upgrade or modification (such as an operating system upgrade, a sub-netwo',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:20:22',
            'updated_at' => '2023-11-14 19:20:22'
        ]);



        Question::create([
            'id' => 403,
            'question' => 'Do you perform internal penetration testing at least annually and after any significant infrastructure or application upgrade or modification (such as an operating system upgrade, a sub-netwo',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:21:48',
            'updated_at' => '2023-11-14 19:21:48'
        ]);



        Question::create([
            'id' => 404,
            'question' => 'Are exploitable vulnerabilities found during penetration testing corrected and testing repeated to verify the corrections?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:23:20',
            'updated_at' => '2023-11-14 19:23:20'
        ]);



        Question::create([
            'id' => 405,
            'question' => 'If segmentation is used to isolate the CDE from other networks, do you perform penetration tests at least annually and after any changes to segmentation controls/methods to verify that the se',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:24:42',
            'updated_at' => '2023-11-14 19:24:42'
        ]);



        Question::create([
            'id' => 406,
            'question' => 'Additional requirement for service providers only: If segmentation is used, have you confirmed PCI DSS scope by performing penetration testing on segmentation controls at least every six mont',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:25:58',
            'updated_at' => '2023-11-14 19:25:58'
        ]);



        Question::create([
            'id' => 408,
            'question' => 'Do you use intrusion-detection and/or intrusion-prevention techniques to detect and/or prevent intrusion into the network and monitor all traffic at the perimeter of the cardholder data envir',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:32:43',
            'updated_at' => '2023-11-14 19:32:43'
        ]);



        Question::create([
            'id' => 409,
            'question' => 'Do you keep all intrusion-detection and prevention engine, baselines, and signatures up to date?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:34:15',
            'updated_at' => '2023-11-14 19:34:15'
        ]);



        Question::create([
            'id' => 410,
            'question' => ' Have you deployed a change-detection mechanism (for example, file-integrity monitoring tools) to alert personnel to unauthorized modifications (including changes, additions, and deletions) o',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:35:18',
            'updated_at' => '2023-11-14 19:35:18'
        ]);



        Question::create([
            'id' => 411,
            'question' => 'Have you implemented a process to respond to any alerts generated by the change-detection solution?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:36:49',
            'updated_at' => '2023-11-14 19:36:49'
        ]);



        Question::create([
            'id' => 412,
            'question' => 'Do you ensure that security policies and operational procedures for security monitoring and testing are documented, in use, and known to all affected parties?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:38:22',
            'updated_at' => '2023-11-14 19:38:22'
        ]);



        Question::create([
            'id' => 413,
            'question' => ' Have you established, published, maintained, and disseminated a security policy?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:39:41',
            'updated_at' => '2023-11-14 19:39:41'
        ]);



        Question::create([
            'id' => 414,
            'question' => 'Do you review the security policy at least annually and update the police when the environment changes?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:40:55',
            'updated_at' => '2023-11-14 19:40:55'
        ]);



        Question::create([
            'id' => 415,
            'question' => ' Have you implemented a risk-assessment process that is performed at least annually and upon significant changes to the environment (for example, acquisition, merger, relocation, etc.)?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:42:45',
            'updated_at' => '2023-11-14 19:42:45'
        ]);



        Question::create([
            'id' => 416,
            'question' => ' Have you implemented a risk-assessment process that identifies critical assets, threats, and vulnerabilities?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:43:55',
            'updated_at' => '2023-11-14 19:43:55'
        ]);



        Question::create([
            'id' => 417,
            'question' => ' Have you implemented a risk-assessment process that results in a formal, documented analysis of risk?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:45:09',
            'updated_at' => '2023-11-14 19:45:09'
        ]);



        Question::create([
            'id' => 418,
            'question' => 'Do you develop usage policies for critical technologies and define proper use of these technologies?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:46:18',
            'updated_at' => '2023-11-14 19:46:18'
        ]);



        Question::create([
            'id' => 419,
            'question' => 'Do your usage policies require explicit approval by authorized parties for the use of these technologies?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:47:34',
            'updated_at' => '2023-11-14 19:47:34'
        ]);



        Question::create([
            'id' => 420,
            'question' => 'Do your usage policies require authentication for the use of the technology?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:48:45',
            'updated_at' => '2023-11-14 19:48:45'
        ]);



        Question::create([
            'id' => 421,
            'question' => 'Do your usage policies require a list of all such devices and personnel with access is recorded and up to date?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:50:05',
            'updated_at' => '2023-11-14 19:50:05'
        ]);



        Question::create([
            'id' => 422,
            'question' => 'Do you have a method to accurately and readily determine owner, contact information, and purpose of all critical technology users (for example, labeling, coding, and/or inventorying of device',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-14 19:51:07',
            'updated_at' => '2023-11-14 19:51:07'
        ]);



        Question::create([
            'id' => 423,
            'question' => 'Do you actively manage (inventory, track, and correct) all hardware devices on the network so that only authorized devices are given access, and unauthorized and unmanaged devices are found a',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 12:51:49',
            'updated_at' => '2023-11-16 12:51:49'
        ]);



        Question::create([
            'id' => 424,
            'question' => 'Do you actively manage (inventory, track, and correct) all software on the network so that only authorized software is installed and can execute, and that unauthorized and unmanaged software ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 12:53:16',
            'updated_at' => '2023-11-16 12:53:16'
        ]);



        Question::create([
            'id' => 425,
            'question' => 'Do you establish, implement, and actively manage (track, report on, correct) the security configuration of laptops, servers, and workstations using a rigorous configuration management and cha',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 12:54:49',
            'updated_at' => '2023-11-16 12:54:49'
        ]);



        Question::create([
            'id' => 426,
            'question' => 'Do you continuously acquire, assess, and take action on new information in order to identify vulnerabilities, remediate, and minimize the window of opportunity for attackers?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 12:56:37',
            'updated_at' => '2023-11-16 12:56:37'
        ]);



        Question::create([
            'id' => 427,
            'question' => 'Do you have processes and tools to track/control/prevent/correct the use, assignment, and configuration of administrative privileges on computers, networks, and applications?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 12:58:01',
            'updated_at' => '2023-11-16 12:58:01'
        ]);



        Question::create([
            'id' => 428,
            'question' => 'Do you collect, manage, and analyze audit logs of events that could help detect, understand, or recover from an attack?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 12:59:17',
            'updated_at' => '2023-11-16 12:59:17'
        ]);



        Question::create([
            'id' => 429,
            'question' => 'Do you minimize the attack surface and the opportunities for attackers to manipulate human behavior through their interaction with web browsers and emails systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 13:00:40',
            'updated_at' => '2023-11-16 13:00:40'
        ]);



        Question::create([
            'id' => 430,
            'question' => 'Do you control the installation, spread, and execution of malicious code at multiple points in the enterprise, while optimizing the use of automation to enable rapid updating of defense, data',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 13:02:29',
            'updated_at' => '2023-11-16 13:02:29'
        ]);



        Question::create([
            'id' => 431,
            'question' => 'Do you manage (track/control/correct) the ongoing operational use of ports, protocols, and services on networked devices in order to minimize windows of vulnerability available to attackers?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 13:26:09',
            'updated_at' => '2023-11-16 13:26:09'
        ]);



        Question::create([
            'id' => 432,
            'question' => 'Do you have processes and tools to properly back up critical information with a proven methodology for timely recovery of it?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 13:27:21',
            'updated_at' => '2023-11-16 13:27:21'
        ]);



        Question::create([
            'id' => 433,
            'question' => 'Do you establish, implement, and actively manage (track, report on, correct) the security configuration of network infrastructure devices using a rigorous configuration management and change ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 13:28:31',
            'updated_at' => '2023-11-16 13:28:31'
        ]);



        Question::create([
            'id' => 434,
            'question' => 'Do you detect/prevent/correct the flow of information transferring networks of different trust levels with a focus on security-damaging data?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 13:29:54',
            'updated_at' => '2023-11-16 13:29:54'
        ]);



        Question::create([
            'id' => 435,
            'question' => 'Do you have processes and tools to prevent data exfiltration, mitigate the effects of exfiltrated data, and ensure the privacy and integrity of sensitive information?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 13:31:12',
            'updated_at' => '2023-11-16 13:31:12'
        ]);



        Question::create([
            'id' => 436,
            'question' => 'Do you have processes and tools to track/control/prevent/correct secure access to critical assets (e.g., information, resources, systems) according to the formal determination of which person',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 13:32:36',
            'updated_at' => '2023-11-16 13:32:36'
        ]);



        Question::create([
            'id' => 437,
            'question' => 'Do you have processes and tools to track/control/prevent/correct the security use of wireless local area networks (LANS), access points, and wireless client systems?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 13:50:38',
            'updated_at' => '2023-11-16 13:50:38'
        ]);



        Question::create([
            'id' => 438,
            'question' => 'Do you actively manage the life cycle of system and application accounts - their creation, use, dormancy, deletion - in order to minimize opportunities for attackers to leverage them?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 13:54:50',
            'updated_at' => '2023-11-16 13:54:50'
        ]);



        Question::create([
            'id' => 439,
            'question' => 'Do all functional roles in the organization (prioritizing those mission-critical to the business and its security) identiy the specific knowledge, skills, and abilities needed to support defe',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 13:56:23',
            'updated_at' => '2023-11-16 13:56:23'
        ]);



        Question::create([
            'id' => 440,
            'question' => 'Do you manage the security life cycle of all in-house developed and acquired software in order to prevent, detect, and correct security weaknesses?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 13:57:32',
            'updated_at' => '2023-11-16 13:57:32'
        ]);



        Question::create([
            'id' => 441,
            'question' => 'Do you protect the organization\'s information, as well as its reputation, by developing and implementing an incident response infrastructure (e.g., plans, defined roles, training, communicati',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 14:01:15',
            'updated_at' => '2023-11-16 14:01:15'
        ]);



        Question::create([
            'id' => 442,
            'question' => 'Do you test the overall strength of your organization\'s defenses (the technology, the processes, and the people) by simulating the objectives and actions of an attacker?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 14:06:51',
            'updated_at' => '2023-11-16 14:06:51'
        ]);



        Question::create([
            'id' => 443,
            'question' => '§164.502(a) (5)(i) Does the health plan use or disclose for underwriting purposes, \"Genetic Information\" as defined at § 160.103, including family history?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 14:58:51',
            'updated_at' => '2023-11-16 14:58:51'
        ]);



        Question::create([
            'id' => 444,
            'question' => '§164.502(f) Do the covered entity‚Äôs policies and procedures protect the deceased individual\'s PHI consistent with the established performance criterion?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:00:50',
            'updated_at' => '2023-11-16 15:00:50'
        ]);



        Question::create([
            'id' => 446,
            'question' => '§164.502(g) Do the policies and procedures provide for the treatment of an authorized person as a personal representative? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:03:29',
            'updated_at' => '2023-11-16 15:03:29'
        ]);



        Question::create([
            'id' => 447,
            'question' => '§164.502(h) Does the entity provide for and accommodate requests by individuals for confidential communications? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:04:35',
            'updated_at' => '2023-11-16 15:04:35'
        ]);



        Question::create([
            'id' => 448,
            'question' => '§164.502(i) Are uses and disclosures made by the covered entity consistent with its notice of privacy practices? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:07:52',
            'updated_at' => '2023-11-16 15:07:52'
        ]);



        Question::create([
            'id' => 449,
            'question' => ' §164.502(j) (1) Are whistleblower policies and procedures consistent with the requirements of this performance criterion? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:09:40',
            'updated_at' => '2023-11-16 15:09:40'
        ]);



        Question::create([
            'id' => 450,
            'question' => '§164.502(j) (2) Has the covered entity ensured that disclosures by a workforce member related to his or her status as a victim of a crime are consistent with the rule established in the crite',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:11:21',
            'updated_at' => '2023-11-16 15:11:21'
        ]);



        Question::create([
            'id' => 451,
            'question' => '§164.504(e) Does the covered entity enter into business associate contracts as required and do these contracts contain all required elements?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:12:29',
            'updated_at' => '2023-11-16 15:12:29'
        ]);



        Question::create([
            'id' => 452,
            'question' => '§164.504(f) Do group health plan documents restrict the use and disclosure of PHI to the plan sponsor? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:13:32',
            'updated_at' => '2023-11-16 15:13:32'
        ]);



        Question::create([
            'id' => 453,
            'question' => '§164.504(g) For entities that perform multiple covered functions, are uses and disclosures of PHI only for the purpose related to the appropriate functions being performed? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:15:06',
            'updated_at' => '2023-11-16 15:15:06'
        ]);



        Question::create([
            'id' => 454,
            'question' => ' Does the entity have policies and procedures in place for terminating access to ePHI when employment or other arrangements with the workforce member ends? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:18:19',
            'updated_at' => '2023-11-16 15:18:19'
        ]);



        Question::create([
            'id' => 455,
            'question' => 'Does the entity have policies and procedures in place for authorizing access to ePHI that supports the applicable requirements of the Privacy Rule and does the entity authorize access to ePHI',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:24:41',
            'updated_at' => '2023-11-16 15:24:41'
        ]);



        Question::create([
            'id' => 456,
            'question' => 'If the entity is a health care clearinghouse that is part of a larger organization, does the clearinghouse have policies and procedures to protect ePHI from unauthorized access by the larger ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:26:10',
            'updated_at' => '2023-11-16 15:26:10'
        ]);



        Question::create([
            'id' => 457,
            'question' => 'Does the clearinghouse protect ePHI from unauthorized access by the larger organization? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:27:40',
            'updated_at' => '2023-11-16 15:27:40'
        ]);



        Question::create([
            'id' => 458,
            'question' => '§164.506(a) Do policies and procedures exist for the use or disclosure of PHI for treatment, payment, or health care operations? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:28:30',
            'updated_at' => '2023-11-16 15:28:30'
        ]);



        Question::create([
            'id' => 459,
            'question' => '§164.506(b); (b)(1); and (b)(2) Does the entity obtain the individual\'s consent for uses and disclosures? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:29:30',
            'updated_at' => '2023-11-16 15:29:30'
        ]);



        Question::create([
            'id' => 460,
            'question' => ' Does the entity have policies and procedures in place to grant access to ePHI for workforce members?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:29:39',
            'updated_at' => '2023-11-16 15:29:39'
        ]);



        Question::create([
            'id' => 461,
            'question' => 'Does the entity have policies and procedures in place to authorize access and document, review, and modify a user‚Äôs right of access to a workstation, transaction, program, or process as wel',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 0,
            'risk_assessment' => 1,
            'compliance_assessment' => 1,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:31:15',
            'updated_at' => '2023-11-16 15:31:15'
        ]);



        Question::create([
            'id' => 462,
            'question' => '§164.508(a) (1-3) and §164.508(b) (1-2) Do policies and procedures exist to determine when authorization is required?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:32:34',
            'updated_at' => '2023-11-16 15:32:34'
        ]);



        Question::create([
            'id' => 463,
            'question' => 'Does the entity have policies and procedures in place regarding a security awareness and training program as well as practice these policies and procedures?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:33:18',
            'updated_at' => '2023-11-16 15:33:18'
        ]);



        Question::create([
            'id' => 464,
            'question' => '§164.508(b) (3) Does the covered entity use or disclose PHI for the purpose of research, conducts research, provides psychotherapy services, and uses compound authorizations? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:33:33',
            'updated_at' => '2023-11-16 15:33:33'
        ]);



        Question::create([
            'id' => 465,
            'question' => '§164.508(b) (4) Does the covered entity condition treatment, payment, enrollment, or eligibility on receipt of an authorization and if so, does one of the limited exceptions apply? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:34:28',
            'updated_at' => '2023-11-16 15:34:28'
        ]);



        Question::create([
            'id' => 466,
            'question' => 'Does the entity have policies and procedures in place regarding a process to provide periodic security reminders and update?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:35:20',
            'updated_at' => '2023-11-16 15:35:20'
        ]);



        Question::create([
            'id' => 467,
            'question' => 'Does the entity appropriately communicate security updates to all members of its workforce and, if appropriate, contractors periodically?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:36:34',
            'updated_at' => '2023-11-16 15:36:34'
        ]);



        Question::create([
            'id' => 468,
            'question' => 'Does the entity have policies and procedures in place regarding a process to incorporate its procedures to guard against, detect, and report malicious software into its security awareness and',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:38:10',
            'updated_at' => '2023-11-16 15:38:10'
        ]);



        Question::create([
            'id' => 469,
            'question' => ' Does the entity have policies and procedures in place regarding a process to incorporate its procedures to guard against, detect, and report malicious software into its security awareness an',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:39:41',
            'updated_at' => '2023-11-16 15:39:41'
        ]);



        Question::create([
            'id' => 470,
            'question' => 'Does the entity have policies and procedures in place to incorporate procedures for monitoring log-in attempts and reporting discrepancies into its security awareness and training program? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:41:01',
            'updated_at' => '2023-11-16 15:41:01'
        ]);



        Question::create([
            'id' => 471,
            'question' => '§164.508(b) (6) and §164.508(c) (1-4) Does the covered entity document and retain signed, valid authorizations? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:41:35',
            'updated_at' => '2023-11-16 15:41:35'
        ]);



        Question::create([
            'id' => 472,
            'question' => 'Does the entity have policies and procedures in place to address security incidents? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:42:27',
            'updated_at' => '2023-11-16 15:42:27'
        ]);



        Question::create([
            'id' => 473,
            'question' => '§164.510(a) (1) and §164.510(a) (2) Does the entity maintain a directory of individuals in its facility?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:42:40',
            'updated_at' => '2023-11-16 15:42:40'
        ]);



        Question::create([
            'id' => 474,
            'question' => 'Does the entity have policies and procedures in place for identifying, responding to, reporting, and mitigating security incidents?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:43:46',
            'updated_at' => '2023-11-16 15:43:46'
        ]);



        Question::create([
            'id' => 475,
            'question' => '§164.510(a) (3) Do policies and procedures exist to use or disclose PHI for the facility directory in emergency circumstances? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:44:00',
            'updated_at' => '2023-11-16 15:44:00'
        ]);



        Question::create([
            'id' => 476,
            'question' => '§164.510(b) (1) Do policies and procedures exist for disclosing PHI to family members, relatives, close personal friends, or other persons identified by the individual?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:45:05',
            'updated_at' => '2023-11-16 15:45:05'
        ]);



        Question::create([
            'id' => 477,
            'question' => ' Does the entity have policies and procedures in place that include a formal contingency plan for responding to an emergency or other occurrences that damages systems that contain ePHI?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:45:11',
            'updated_at' => '2023-11-16 15:45:11'
        ]);



        Question::create([
            'id' => 478,
            'question' => '§164.510(b) (2) Does the covered entity disclose PHI to persons involved in the individual\'s care when the individual is present and are policies and procedures in place to define the circums',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:46:01',
            'updated_at' => '2023-11-16 15:46:01'
        ]);



        Question::create([
            'id' => 479,
            'question' => '§164.510(b) (3) Do policies and procedures exist for disclosing only information relevant to the person\'s involvement in the individual\'s health care when the individual is not present and in',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:46:51',
            'updated_at' => '2023-11-16 15:46:51'
        ]);



        Question::create([
            'id' => 480,
            'question' => '164.510(b) (4) Do policies and procedures exist for disclosing PHI to a public or private entity authorized by law or by its charter to assist in disaster relief efforts? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:52:03',
            'updated_at' => '2023-11-16 15:52:03'
        ]);



        Question::create([
            'id' => 481,
            'question' => '§164.510(b) (5) Does the covered entity disclose the PHI of deceased individuals in accordance with the established performance criterion?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 15:53:53',
            'updated_at' => '2023-11-16 15:53:53'
        ]);



        Question::create([
            'id' => 482,
            'question' => 'Does the entity have a contingency plan for responding to an emergency or other occurrences that damages systems that contain ePHI?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:10:01',
            'updated_at' => '2023-11-16 16:10:01'
        ]);



        Question::create([
            'id' => 483,
            'question' => 'Does the entity have policies and procedures in place to create and maintain retrievable exact copies of ePHI?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:11:13',
            'updated_at' => '2023-11-16 16:11:13'
        ]);



        Question::create([
            'id' => 485,
            'question' => ' Does the entity create and maintain retrievable exact copies of ePHI?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:12:40',
            'updated_at' => '2023-11-16 16:12:40'
        ]);



        Question::create([
            'id' => 486,
            'question' => 'Does the entity have policies and procedures in place to restore any lost data and 3does the entity restore any lost data? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:15:44',
            'updated_at' => '2023-11-16 16:15:44'
        ]);



        Question::create([
            'id' => 487,
            'question' => '§164.512(a) Does the covered entity use and disclose PHI pursuant to requirements of other law and If so, are such uses and disclosures made consistent with the requirements of this performan',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:24:24',
            'updated_at' => '2023-11-16 16:24:24'
        ]);

        Question::create([
            'id' => 488,
            'question' => '§164.512(b) Are policies and procedures in place that specify how the covered entity uses or disclosures PHI for public health activities consistent with this standard?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:25:30',
            'updated_at' => '2023-11-16 16:25:30'
        ]);



        Question::create([
            'id' => 489,
            'question' => '§164.512(c) Does the covered entity determine whether and how to make disclosures about victims of abuse, neglect, or domestic violence consistent with this standard?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:26:29',
            'updated_at' => '2023-11-16 16:26:29'
        ]);



        Question::create([
            'id' => 490,
            'question' => '§164.512(d) Is PHI used or disclosed for health oversight activities consistent with the established performance criterion? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:29:13',
            'updated_at' => '2023-11-16 16:29:13'
        ]);



        Question::create([
            'id' => 491,
            'question' => 'Does the entity have policies and procedures in place to enable the continuity of critical business processes for the protection of ePHI while operating in emergency mode?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:30:49',
            'updated_at' => '2023-11-16 16:30:49'
        ]);



        Question::create([
            'id' => 492,
            'question' => '§164.512(e) Do policies and procedures exist related to making disclosures in the course of any judicial or administrative proceeding to limit such disclosures to those permitted by the estab',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:31:32',
            'updated_at' => '2023-11-16 16:31:32'
        ]);



        Question::create([
            'id' => 493,
            'question' => 'Does the entity enable the continuity of critical business processes for the protection of ePHI while operating in emergency mode? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:32:21',
            'updated_at' => '2023-11-16 16:32:21'
        ]);



        Question::create([
            'id' => 494,
            'question' => '§164.512(f) (1) Have disclosures made by the covered entity for law enforcement purposes been consistent with the performance criterion? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:32:47',
            'updated_at' => '2023-11-16 16:32:47'
        ]);



        Question::create([
            'id' => 495,
            'question' => ' Does the entity have policies and procedures for periodic testing and revisions of its contingency plans and does the entity periodically test and revise its contingency plans? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:33:37',
            'updated_at' => '2023-11-16 16:33:37'
        ]);



        Question::create([
            'id' => 496,
            'question' => '§164.512(f) (2) Are disclosures made to law enforcement for identification and location purposes by the covered entity consistent with the limitations listed in the established performance cr',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:33:48',
            'updated_at' => '2023-11-16 16:33:48'
        ]);



        Question::create([
            'id' => 497,
            'question' => 'Does the entity have policies and procedures in place to assess the relative criticality of specific applications and data in support of other contingency plan components.',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:34:52',
            'updated_at' => '2023-11-16 16:34:52'
        ]);



        Question::create([
            'id' => 498,
            'question' => '§164.512(f) (3) Are policies and procedures consistent with the established performance criterion regarding the conditions in which the covered entity may disclose PHI of a possible victim of',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:35:15',
            'updated_at' => '2023-11-16 16:35:15'
        ]);



        Question::create([
            'id' => 499,
            'question' => '§164.512(f) (4) Are policies and procedures in place to determine when it is permitted to disclose PHI to law enforcement about an individual who has died as a result of suspected criminal co',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:36:14',
            'updated_at' => '2023-11-16 16:36:14'
        ]);



        Question::create([
            'id' => 500,
            'question' => 'Does the entity assess the relative criticality of specific application and data in support of other contingency plan components?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:36:16',
            'updated_at' => '2023-11-16 16:36:16'
        ]);



        Question::create([
            'id' => 501,
            'question' => '§164.512(f) (5) Are policies and procedures in place to determine when it is permitted to disclose PHI about an individual who may have committed a crime on the premises? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:37:10',
            'updated_at' => '2023-11-16 16:37:10'
        ]);



        Question::create([
            'id' => 502,
            'question' => 'Does the entity have policies and procedures in place to perform periodic technical and nontechnical evaluation, based initially upon the standards implemented under this rule and subsequentl',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:37:33',
            'updated_at' => '2023-11-16 16:37:33'
        ]);



        Question::create([
            'id' => 503,
            'question' => '§164.512(f) (6) Are policies and procedures in place to determine what information about a medical emergency is necessary to disclose to alert law enforcement?  ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:38:38',
            'updated_at' => '2023-11-16 16:38:38'
        ]);



        Question::create([
            'id' => 504,
            'question' => 'Does the entity perform periodic technical and nontechnical evaluation, based initially upon the standards implemented under this rule and subsequently, in response to environmental or operat',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:38:42',
            'updated_at' => '2023-11-16 16:38:42'
        ]);



        Question::create([
            'id' => 505,
            'question' => '§164.512(g) Are policies and procedures consistent with the established performance criterion for disclosing PHI to (1) a coroner or medical examiner; and (2) a funeral director? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:39:56',
            'updated_at' => '2023-11-16 16:39:56'
        ]);



        Question::create([
            'id' => 506,
            'question' => '§164.512(h) Is the covered entity‚Äôs process for disclosing PHI to organ procurement organizations or other entities engaged in the procurement consistent with the established performance cr',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:40:57',
            'updated_at' => '2023-11-16 16:40:57'
        ]);



        Question::create([
            'id' => 507,
            'question' => '§164.512(i) (1) Does the covered entity use or disclose PHI for research purposes in accordance with the established performance criterion? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:42:08',
            'updated_at' => '2023-11-16 16:42:08'
        ]);



        Question::create([
            'id' => 508,
            'question' => '§164.512(i) (2) Do policies and procedures exist to determine what documentation of approval or waiver is needed to permit a use or disclosure and to apply that determination?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:49:41',
            'updated_at' => '2023-11-16 16:49:41'
        ]);



        Question::create([
            'id' => 509,
            'question' => '§164.512(k) (1) Does the covered entity disclose PHI of individuals for military and veterans activities consistent with the established performance criterion?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:50:51',
            'updated_at' => '2023-11-16 16:50:51'
        ]);



        Question::create([
            'id' => 510,
            'question' => '§164.512(k) (2) Does the covered entity respond to a request for PHI from Federal officials for intelligence and other national security activities in accordance with the established performa',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:54:16',
            'updated_at' => '2023-11-16 16:54:16'
        ]);



        Question::create([
            'id' => 511,
            'question' => '§164.512(k) (3) Does the covered entity respond to a request for PHI from Federal officials for the provision of protective services or the conduct of certain investigations in accordance wit',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 16:56:49',
            'updated_at' => '2023-11-16 16:56:49'
        ]);



        Question::create([
            'id' => 512,
            'question' => '§164.512(k) (4) Is the covered entity a component of the Department of State and if so, does the covered entity have policies and procedures consistent with the established performance criter',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:07:14',
            'updated_at' => '2023-11-16 17:07:14'
        ]);



        Question::create([
            'id' => 513,
            'question' => '§164.512(k) (5) Does the covered entity determine whether to disclose PHI to a correctional institution or a law enforcement official with custody of an individual and are policies and proced',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:08:40',
            'updated_at' => '2023-11-16 17:08:40'
        ]);



        Question::create([
            'id' => 514,
            'question' => '§164.512(k) (6) Is the covered entity a health plan that is a government agency administering a government program providing public benefits and if so does the covered entity have policies an',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:10:07',
            'updated_at' => '2023-11-16 17:10:07'
        ]);



        Question::create([
            'id' => 515,
            'question' => '§164.512(l) Are policies and procedures in place regarding disclosure of PHI for the purpose of workers\' compensation, that are consistent with the established performance criterion?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:11:23',
            'updated_at' => '2023-11-16 17:11:23'
        ]);



        Question::create([
            'id' => 516,
            'question' => '§164.514(b) & §164.514(c) Does the covered entity de-identify PHI consistent with the established performance criterion?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:12:22',
            'updated_at' => '2023-11-16 17:12:22'
        ]);



        Question::create([
            'id' => 517,
            'question' => '§164.514(d) (1)§164.514(d) (2) Has the covered entity implemented policies and procedures consistent with the requirements of the established performance criterion to identify need for and li',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:13:26',
            'updated_at' => '2023-11-16 17:13:26'
        ]);



        Question::create([
            'id' => 518,
            'question' => '§164.514(d) (3) Are policies and procedures in place to limit the PHI disclosed to the amount reasonably necessary to achieve the purpose of the disclosure?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:17:48',
            'updated_at' => '2023-11-16 17:17:48'
        ]);



        Question::create([
            'id' => 519,
            'question' => '§164.514(d) (4) Are policies and procedures in place to limit the PHI requested by the entity being audited to the amount minimally necessary to achieve the purpose of the disclosure? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:18:54',
            'updated_at' => '2023-11-16 17:18:54'
        ]);



        Question::create([
            'id' => 520,
            'question' => '§164.514(d) (5) Are policies and procedures in place to address uses, disclosures, or requests for an entire medical record? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:19:57',
            'updated_at' => '2023-11-16 17:19:57'
        ]);



        Question::create([
            'id' => 521,
            'question' => '§164.514(e) Are data use agreements in place between the covered entity and its limited data set recipients, if any? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:21:04',
            'updated_at' => '2023-11-16 17:21:04'
        ]);



        Question::create([
            'id' => 522,
            'question' => '§164.514(f) Is the disclosure of PHI to a business associate or institutionally related foundation limited to the information set forth in the established performance criterion? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:22:07',
            'updated_at' => '2023-11-16 17:22:07'
        ]);



        Question::create([
            'id' => 523,
            'question' => 'Does the entity have policies and procedures in place to obtain satisfactory assurances from its business associates (or business associate subcontractors if the entity is a business associat',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:24:11',
            'updated_at' => '2023-11-16 17:24:11'
        ]);



        Question::create([
            'id' => 524,
            'question' => ' Does the entity have policies and procedures in place to obtain satisfactory assurances from its business associates (or business associate subcontractors if entity is a business associate) ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:25:21',
            'updated_at' => '2023-11-16 17:25:21'
        ]);



        Question::create([
            'id' => 525,
            'question' => ' Does the entity have policies and procedures in place regarding access to and use of facilities and equipment that house ePHI and does the entity limit physical access to its electronic info',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:26:27',
            'updated_at' => '2023-11-16 17:26:27'
        ]);



        Question::create([
            'id' => 526,
            'question' => ' Does the entity have policies and procedures in place that allow facility access for the restoration of lost data under the Disaster Recovery Plan and Emergency Mode Operations Plan?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:27:34',
            'updated_at' => '2023-11-16 17:27:34'
        ]);



        Question::create([
            'id' => 527,
            'question' => 'Does the entity allow facility access for the restoration of lost data under the Disaster Recover Plan and Emergency Mode Operation Plan in the event of an emergency?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:28:48',
            'updated_at' => '2023-11-16 17:28:48'
        ]);



        Question::create([
            'id' => 528,
            'question' => ' Does the entity have policies and procedures in place to safeguard the facility and equipment therein from unauthorized physical access, tampering, and theft?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:29:58',
            'updated_at' => '2023-11-16 17:29:58'
        ]);



        Question::create([
            'id' => 529,
            'question' => 'Does the entity safeguard the facility and equipment therein from unauthorized physical access, tampering, and theft?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:31:06',
            'updated_at' => '2023-11-16 17:31:06'
        ]);



        Question::create([
            'id' => 530,
            'question' => '§164.514(g) Does the health plan have policies and procedures consistent with the established performance criterion addressing limitations on the use and disclosure of PHI received for underw',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:31:31',
            'updated_at' => '2023-11-16 17:31:31'
        ]);



        Question::create([
            'id' => 531,
            'question' => 'Does the entity have policies and procedures in place for controlling a person‚Äôs access to facilities based on their role or function including visitor control and control of access to soft',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:32:11',
            'updated_at' => '2023-11-16 17:32:11'
        ]);



        Question::create([
            'id' => 532,
            'question' => ' Does the entity control a person\'s access to facilities based on their role or function including visitor control and control of access to software programs for testing and revision? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:33:23',
            'updated_at' => '2023-11-16 17:33:23'
        ]);



        Question::create([
            'id' => 533,
            'question' => 'Does the entity have policies and procedures in place to document repairs and modifications to the physical components of a facility which are related to security?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:34:27',
            'updated_at' => '2023-11-16 17:34:27'
        ]);



        Question::create([
            'id' => 534,
            'question' => 'Does the entity document repairs and modifications to the physical components of a facility which are related to security? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:35:34',
            'updated_at' => '2023-11-16 17:35:34'
        ]);



        Question::create([
            'id' => 535,
            'question' => 'Does the entity have policies and procedures in place that specifies the proper functions to be performed and the physical attributes of the surroundings of a specific workstation or class of',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:36:41',
            'updated_at' => '2023-11-16 17:36:41'
        ]);



        Question::create([
            'id' => 536,
            'question' => ' Does the entity specify the proper functions to be performed and the physical attributes of the surroundings of a specific workstation or class of workstation that can access ePHI?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:37:55',
            'updated_at' => '2023-11-16 17:37:55'
        ]);



        Question::create([
            'id' => 537,
            'question' => ' Does the entity have policies and procedures that document how workstations are physically restricted to limit access to only authorized personnel?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:39:06',
            'updated_at' => '2023-11-16 17:39:06'
        ]);



        Question::create([
            'id' => 538,
            'question' => '§164.514(h) Are policies and procedures consistent with the established performance criterion in place to verify the identity of persons who request PHI?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:39:29',
            'updated_at' => '2023-11-16 17:39:29'
        ]);



        Question::create([
            'id' => 539,
            'question' => ' Are the entity workstations that access electronic protected health information restricted to authorized users?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:40:06',
            'updated_at' => '2023-11-16 17:40:06'
        ]);



        Question::create([
            'id' => 540,
            'question' => '§164.520(a) (1) & (b)(1) Does the covered entity have a notice of privacy practice, If yes, does the current notice contain all the required elements as seen in the established criterion?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:40:52',
            'updated_at' => '2023-11-16 17:40:52'
        ]);



        Question::create([
            'id' => 541,
            'question' => 'Does the entity have policies and procedures in place that govern the receipt and removal of hardware and electronic media that contain ePHI, into and out of a facility, and the movement of t',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:41:09',
            'updated_at' => '2023-11-16 17:41:09'
        ]);



        Question::create([
            'id' => 542,
            'question' => '§164.520(c) (1) Does the health plan provide its notice of privacy practices consistent with the established performance criterion? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:42:24',
            'updated_at' => '2023-11-16 17:42:24'
        ]);



        Question::create([
            'id' => 543,
            'question' => 'Does the entity govern the receipt and removal of hardware and electronic media that contain ePHI, into and out of a facility, and the movement of these items within facility? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:42:29',
            'updated_at' => '2023-11-16 17:42:29'
        ]);



        Question::create([
            'id' => 544,
            'question' => 'Does the entity have policies and procedures that address the disposal ePHI data, hardware or electronic media on which it is stored?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:43:37',
            'updated_at' => '2023-11-16 17:43:37'
        ]);



        Question::create([
            'id' => 545,
            'question' => '§164.520(c) (2) Does a covered health care provider with direct treatment relationships with individuals provide its notice of privacy practices consistent with the established performance cr',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:43:40',
            'updated_at' => '2023-11-16 17:43:40'
        ]);



        Question::create([
            'id' => 546,
            'question' => 'Does the entity address the disposal ePHI data, hardware or electronic media on which it is stored? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:44:40',
            'updated_at' => '2023-11-16 17:44:40'
        ]);



        Question::create([
            'id' => 547,
            'question' => 'Does the entity have policies and procedures established to remove ePHI before reusing electronic media?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:46:02',
            'updated_at' => '2023-11-16 17:46:02'
        ]);



        Question::create([
            'id' => 548,
            'question' => '§164.520(c) (3) Does a covered entity that maintains a web site prominently post its notice?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:46:07',
            'updated_at' => '2023-11-16 17:46:07'
        ]);



        Question::create([
            'id' => 549,
            'question' => '§164.520(c) (3) Does the covered entity implement policies and procedures, if any, to provide the notice electronically consistent with the standard? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:47:17',
            'updated_at' => '2023-11-16 17:47:17'
        ]);



        Question::create([
            'id' => 550,
            'question' => ' Does the entity have policies and procedures established to record who is responsible for the overseeing these ePHI removal processes?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:47:24',
            'updated_at' => '2023-11-16 17:47:24'
        ]);



        Question::create([
            'id' => 551,
            'question' => '§164.520(d) For covered entities that participate in organized health care arrangement, does the entity use a joint notice of privacy practices and If a joint notice is utilized, does the joi',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:48:49',
            'updated_at' => '2023-11-16 17:48:49'
        ]);



        Question::create([
            'id' => 552,
            'question' => ' Does the entity have policies and procedures established to record who is responsible for the overseeing these ePHI removal processes?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:49:08',
            'updated_at' => '2023-11-16 17:49:08'
        ]);



        Question::create([
            'id' => 553,
            'question' => 'Does the entity remove ePHI before reusing electronic media?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:50:10',
            'updated_at' => '2023-11-16 17:50:10'
        ]);



        Question::create([
            'id' => 554,
            'question' => '§164.520(e) Is the documentation of notice of privacy practices and the acknowledgement of receipt by individuals of the notice of privacy practices maintained in electronic or written form a',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:50:58',
            'updated_at' => '2023-11-16 17:50:58'
        ]);



        Question::create([
            'id' => 555,
            'question' => 'Does the entity record who is responsible for the overseeing those processes? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:51:21',
            'updated_at' => '2023-11-16 17:51:21'
        ]);



        Question::create([
            'id' => 556,
            'question' => '§164.522(a) (1) Does the covered entity have policies and procedures consistent with the established performance criterion to permit an individual to request that the entity restrict uses or ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:52:06',
            'updated_at' => '2023-11-16 17:52:06'
        ]);



        Question::create([
            'id' => 557,
            'question' => 'Does the entity have policies and procedures to record the movements of hardware and electronic media and any person responsible therefore?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:52:20',
            'updated_at' => '2023-11-16 17:52:20'
        ]);



        Question::create([
            'id' => 558,
            'question' => 'does the entity record the movements of hardware and electronic media and any person responsible therefore?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:53:19',
            'updated_at' => '2023-11-16 17:53:19'
        ]);



        Question::create([
            'id' => 559,
            'question' => '§164.522(a) (2) Are policies and procedures in place to terminate restrictions on the use and/or disclosure of PHI, consistent with the established performance criterion?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:54:29',
            'updated_at' => '2023-11-16 17:54:29'
        ]);



        Question::create([
            'id' => 560,
            'question' => ' Does the entity have policies and procedures in place to create a retrievable, exact copy of ePHI when needed, before movement of equipment?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:54:32',
            'updated_at' => '2023-11-16 17:54:32'
        ]);



        Question::create([
            'id' => 561,
            'question' => ' Does the entity create a retrievable, exact copy of ePHI when needed, before movement of equipment? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:55:35',
            'updated_at' => '2023-11-16 17:55:35'
        ]);



        Question::create([
            'id' => 562,
            'question' => '§164.522(a) (3) Does the covered entity, consistent with the established performance criterion, maintain documentation of restrictions in electronic or written form for a period of six years?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:55:55',
            'updated_at' => '2023-11-16 17:55:55'
        ]);



        Question::create([
            'id' => 563,
            'question' => ' Has the entity implemented technical policies and procedure for the electronic information systems that maintain ePHI to allow access only to authorized users?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:57:03',
            'updated_at' => '2023-11-16 17:57:03'
        ]);



        Question::create([
            'id' => 564,
            'question' => '§164.522(b) (1) Does the covered entity have policies and procedures in place to permit individuals to request alternative means or alternative locations to receive communications of PHI cons',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 17:58:23',
            'updated_at' => '2023-11-16 17:58:23'
        ]);



        Question::create([
            'id' => 565,
            'question' => '§164.524(a) (1), (b)(1), (b)(2), (c)(2), (c)(3), (c)(4), (d)(1), (d)(3) Does the covered entity enable the access rights of an individual in accordance with the established criterion? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:04:51',
            'updated_at' => '2023-11-16 18:04:51'
        ]);



        Question::create([
            'id' => 566,
            'question' => '§164.524(d) (2) Has the covered entity implemented policies and procedures that ensure that an individual receives a timely, written denial that contains all mandated elements? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:05:58',
            'updated_at' => '2023-11-16 18:05:58'
        ]);



        Question::create([
            'id' => 567,
            'question' => '§164.524(a) (2) Do policies and procedures exist that dictate the circumstances under which denials of requests for access are unreviewable?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:07:39',
            'updated_at' => '2023-11-16 18:07:39'
        ]);



        Question::create([
            'id' => 568,
            'question' => '§164.524(a) (3) Are policies and procedures in place regarding review of denials of access? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:08:53',
            'updated_at' => '2023-11-16 18:08:53'
        ]);



        Question::create([
            'id' => 569,
            'question' => '§164.524(a) (4) & (d)(4) Do policies and procedures address request for and fulfillment of review of instances of access denial?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:10:28',
            'updated_at' => '2023-11-16 18:10:28'
        ]);



        Question::create([
            'id' => 570,
            'question' => 'Does the entity only allow access to those persons or software programs that have been granted access rights as specified in § 164.308(a)(4) to electronic information systems that maintain el',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:17:00',
            'updated_at' => '2023-11-16 18:17:00'
        ]);



        Question::create([
            'id' => 571,
            'question' => 'Does the entity have polices and procedures regarding the assignment of unique user IDs to track user identity?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:18:16',
            'updated_at' => '2023-11-16 18:18:16'
        ]);



        Question::create([
            'id' => 572,
            'question' => 'Does the entity assign unique user IDs to track user identity? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:19:36',
            'updated_at' => '2023-11-16 18:19:36'
        ]);



        Question::create([
            'id' => 573,
            'question' => 'Does the entity have polices and procedures in place to provide access to ePHI during an emergency and does the entity provide access to ePHI during an emergency?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:20:43',
            'updated_at' => '2023-11-16 18:20:43'
        ]);



        Question::create([
            'id' => 574,
            'question' => ' Does the entity provide access to ePHI during an emergency? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:21:43',
            'updated_at' => '2023-11-16 18:21:43'
        ]);



        Question::create([
            'id' => 575,
            'question' => 'Does the entity have policies and procedures in place to automatically terminates an electronic session after a predetermined time of inactivity?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:22:49',
            'updated_at' => '2023-11-16 18:22:49'
        ]);



        Question::create([
            'id' => 576,
            'question' => 'Does the entity have policies and procedures in place to encrypt and decrypt ePHI including processes regarding the use and management of the confidential process or key used to encrypt and d',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:24:21',
            'updated_at' => '2023-11-16 18:24:21'
        ]);



        Question::create([
            'id' => 577,
            'question' => 'Does the entity encrypt and decrypt ePHI including processes regarding the use and management of the confidential process or key used to encrypt and decrypt ePHI? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:25:24',
            'updated_at' => '2023-11-16 18:25:24'
        ]);



        Question::create([
            'id' => 578,
            'question' => 'Does the entity have policies and procedures in place to implement hardware, software and/or procedural mechanisms to record and examine activity in information systems that contain or use eP',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:26:35',
            'updated_at' => '2023-11-16 18:26:35'
        ]);



        Question::create([
            'id' => 579,
            'question' => 'Does the entity have hardware, software and/or procedural mechanism to record and examine activity in information systems that contain or use ePHI?  ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:27:47',
            'updated_at' => '2023-11-16 18:27:47'
        ]);



        Question::create([
            'id' => 580,
            'question' => 'Does the entity have policies and procedures in place to protect ePHI from improper alteration or destruction?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:28:52',
            'updated_at' => '2023-11-16 18:28:52'
        ]);



        Question::create([
            'id' => 581,
            'question' => 'Does the entity protect ePHI form improper alteration or destruction?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:29:52',
            'updated_at' => '2023-11-16 18:29:52'
        ]);



        Question::create([
            'id' => 582,
            'question' => ' Does the entity have policies and procedures in place regarding the implementation of electronic mechanisms to corroborate that ePHI has not been altered or destroyed in an unauthorized mann',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:30:58',
            'updated_at' => '2023-11-16 18:30:58'
        ]);



        Question::create([
            'id' => 583,
            'question' => 'Does the entity have electronic mechanism to corroborate that ePHI has not been altered or destroyed in an unauthorized manner? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:32:04',
            'updated_at' => '2023-11-16 18:32:04'
        ]);



        Question::create([
            'id' => 584,
            'question' => 'Does the entity have policies and procedures in place to verify that a person or entity seeking access to ePHI is the one claimed?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:33:07',
            'updated_at' => '2023-11-16 18:33:07'
        ]);



        Question::create([
            'id' => 585,
            'question' => 'Does the entity verify that a person or entity seeking access to ePHI is the one claimed? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:35:42',
            'updated_at' => '2023-11-16 18:35:42'
        ]);



        Question::create([
            'id' => 586,
            'question' => '§164.524(e) Does the covered entity document the following and retain the documentation as required by §164.530(j): (1) the designated record sets that are subject to access by individuals; a',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:36:57',
            'updated_at' => '2023-11-16 18:36:57'
        ]);



        Question::create([
            'id' => 587,
            'question' => 'Does the entity have policies and procedures in place to implement technical security controls to guard against unauthorized access to ePHI transmitted over electronic communications networks',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:38:42',
            'updated_at' => '2023-11-16 18:38:42'
        ]);



        Question::create([
            'id' => 588,
            'question' => '§164.526(a) (1) Has the covered entity implemented policies and procedures consistent with the established performance criterion regarding an individual\'s right to amend their PHI in a design',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:39:15',
            'updated_at' => '2023-11-16 18:39:15'
        ]);



        Question::create([
            'id' => 589,
            'question' => 'Does the entity have security controls to guard against unauthorized access to ePHI transmitted over electronic communications networks?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:40:02',
            'updated_at' => '2023-11-16 18:40:02'
        ]);



        Question::create([
            'id' => 590,
            'question' => ' Does the entity have policies and procedures in place to implement security measures to ensure that electronically transmitted ePHI cannot be improperly modified without detection until disp',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:41:09',
            'updated_at' => '2023-11-16 18:41:09'
        ]);



        Question::create([
            'id' => 591,
            'question' => ' Does the entity have policies and procedures in place to implement an encryption mechanism to encrypt ePHI whenever deemed appropriate?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:42:15',
            'updated_at' => '2023-11-16 18:42:15'
        ]);



        Question::create([
            'id' => 592,
            'question' => ' Does the entity have encryption mechanism to encrypt ePHI whenever deemed necessary?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:43:17',
            'updated_at' => '2023-11-16 18:43:17'
        ]);



        Question::create([
            'id' => 593,
            'question' => 'Does the entity have policies and procedures in place regarding its contractual arrangements with contractors or other entities to which it discloses ePHI for use on its behalf? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:44:20',
            'updated_at' => '2023-11-16 18:44:20'
        ]);



        Question::create([
            'id' => 594,
            'question' => 'Does the entity have policies and procedures in place regarding the content of its business associate contracts to ensure that its business associates will comply with applicable requirements',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:45:22',
            'updated_at' => '2023-11-16 18:45:22'
        ]);



        Question::create([
            'id' => 595,
            'question' => ' Does the entity have policies and procedures in place requiring that its business associate contracts or other arrangements require that subcontractors that create, receive, maintain or tran',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:46:44',
            'updated_at' => '2023-11-16 18:46:44'
        ]);



        Question::create([
            'id' => 596,
            'question' => ' Does the entity have policies and procedures in place regarding the content of its business associate contracts to ensure that its business associates will report any security incident of wh',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:47:55',
            'updated_at' => '2023-11-16 18:47:55'
        ]);



        Question::create([
            'id' => 597,
            'question' => 'Does the entity have policies and procedures in place regarding other arrangements to have in place (e.g., a Memorandum of Understanding if the covered entity and business associate are gover',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:49:11',
            'updated_at' => '2023-11-16 18:49:11'
        ]);



        Question::create([
            'id' => 598,
            'question' => 'Does the entity have policies and procedures in place regarding business associate contracts or other arrangements with its subcontractors such that the requirements of 45 CFR § 164.314(a)(2)',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:50:19',
            'updated_at' => '2023-11-16 18:50:19'
        ]);



        Question::create([
            'id' => 599,
            'question' => 'Does the group health plan have policies and procedures in place to ensure that its plan documents provide that the plan sponsor will reasonably and appropriately safeguard ePHI created, rece',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:51:26',
            'updated_at' => '2023-11-16 18:51:26'
        ]);



        Question::create([
            'id' => 600,
            'question' => 'Do the plan documents of the group health plan include language that requires the sponsor to implement administrative, physical, and technical safeguards that reasonably and appropriately pro',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:52:35',
            'updated_at' => '2023-11-16 18:52:35'
        ]);



        Question::create([
            'id' => 601,
            'question' => 'Do the plan documents of the group health plan incorporate provisions to ensure that adequate separation required by 45 CFR § 164.504(f)(2) (iii) is supported by reasonable and appropriate se',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:53:37',
            'updated_at' => '2023-11-16 18:53:37'
        ]);



        Question::create([
            'id' => 602,
            'question' => '(3.14.6) Do we monitor the information system including inbound and outbound communications traffic, to detect attacks and indicators of potential attacks?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:55:07',
            'updated_at' => '2023-11-16 18:55:07'
        ]);



        Question::create([
            'id' => 603,
            'question' => '§164.526(a) (2) Has the covered entity implemented policies and procedures consistent with the established performance criterion for determining grounds for denying requests? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:55:16',
            'updated_at' => '2023-11-16 18:55:16'
        ]);



        Question::create([
            'id' => 604,
            'question' => '(3.14.7) Do we identify unauthorized use of the information system?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:55:51',
            'updated_at' => '2023-11-16 18:55:51'
        ]);



        Question::create([
            'id' => 605,
            'question' => 'Do the plan documents of the group health plan incorporate provisions to include language that requires the sponsors to ensure that any agent to whom it provides this information agrees to im',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:55:52',
            'updated_at' => '2023-11-16 18:55:52'
        ]);



        Question::create([
            'id' => 606,
            'question' => '§164.526(c) Does the covered entity have policies and procedures consistent with the established performance criterion for accepting requests for amendments? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:56:48',
            'updated_at' => '2023-11-16 18:56:48'
        ]);



        Question::create([
            'id' => 607,
            'question' => ' Do the plan documents of the group health plan incorporate provisions to include language that requires plan sponsors to report to the group health plan any security incident of which it bec',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:56:49',
            'updated_at' => '2023-11-16 18:56:49'
        ]);



        Question::create([
            'id' => 608,
            'question' => ' Does the entity have policies and procedures in place to implement reasonable and appropriate policies and procedures to comply with the standards, implementation specification or other requ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:57:44',
            'updated_at' => '2023-11-16 18:57:44'
        ]);



        Question::create([
            'id' => 609,
            'question' => '§164.526(d) Has the covered entity implemented policies and procedures regarding provision of denial consistent with the established performance criterion? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:58:04',
            'updated_at' => '2023-11-16 18:58:04'
        ]);



        Question::create([
            'id' => 610,
            'question' => 'Does the entity have policies and procedures to maintain written policies and procedures related to the security rule and written documents of (if any) actions, activities, or assessments req',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:58:50',
            'updated_at' => '2023-11-16 18:58:50'
        ]);



        Question::create([
            'id' => 611,
            'question' => '§164.528(a) Does the covered entity have policies and procedures consistent with the established performance criterion for implementing an individual‚Äôs right to an accounting of disclosures',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:59:09',
            'updated_at' => '2023-11-16 18:59:09'
        ]);



        Question::create([
            'id' => 612,
            'question' => ' Does the entity have policies and procedures in place regarding the retention of required documentation for six (6) years from the date of its creation or the date when it last was in effect',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 18:59:43',
            'updated_at' => '2023-11-16 18:59:43'
        ]);



        Question::create([
            'id' => 613,
            'question' => '§164.528(b) Does the covered entity have policies and procedures consistent with the established performance criterion to provide an accounting that contains the content listed? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:00:23',
            'updated_at' => '2023-11-16 19:00:23'
        ]);



        Question::create([
            'id' => 614,
            'question' => 'Does the entity have policies and procedures in place requiring that documentation be made available to the workforce members responsible for implementing applicable Security Rule policies an',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:00:51',
            'updated_at' => '2023-11-16 19:00:51'
        ]);



        Question::create([
            'id' => 615,
            'question' => '§164.528(c) Does the covered entity have policies and procedures consistent with the established performance criterion to provide an individual with a requested accounting of PHI with in the ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:01:34',
            'updated_at' => '2023-11-16 19:01:34'
        ]);



        Question::create([
            'id' => 616,
            'question' => ' Does the entity have policies and procedures in place to perform periodic reviews and updates to Security Rule policies and procedures?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:01:53',
            'updated_at' => '2023-11-16 19:01:53'
        ]);



        Question::create([
            'id' => 617,
            'question' => '§164.528(d) Does the covered entity document requests for and fulfillment of accounting of disclosures consistent with the established performance criterion?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:02:42',
            'updated_at' => '2023-11-16 19:02:42'
        ]);



        Question::create([
            'id' => 618,
            'question' => 'Has the covered entity adequately implemented the required 164.530 provisions as they relate to the Breach Notification Rule?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:02:51',
            'updated_at' => '2023-11-16 19:02:51'
        ]);



        Question::create([
            'id' => 619,
            'question' => 'Has the covered entity trained its workforce on the applicable provisions established in the audit criterion?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:03:50',
            'updated_at' => '2023-11-16 19:03:50'
        ]);



        Question::create([
            'id' => 620,
            'question' => '§164.530(a) Has the covered entity designated a privacy official and a contact person consistent with the established performance criterion? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:03:54',
            'updated_at' => '2023-11-16 19:03:54'
        ]);



        Question::create([
            'id' => 621,
            'question' => 'Has the covered entity sanctioned any workforce members for failing to comply with its policies and procedures as they relate to the Breach Notification Rule?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:06:37',
            'updated_at' => '2023-11-16 19:06:37'
        ]);



        Question::create([
            'id' => 622,
            'question' => 'Does the covered entity have appropriate policies and procedures in place to prohibit retaliation against any individual for exercising a right or participating in a process (e.g., assisting ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:07:39',
            'updated_at' => '2023-11-16 19:07:39'
        ]);



        Question::create([
            'id' => 623,
            'question' => '§164.530(b) Does the covered entity train its work force and have a policies and procedures to ensure all members of the workforce receive necessary and appropriate training in a timely manne',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:08:21',
            'updated_at' => '2023-11-16 19:08:21'
        ]);



        Question::create([
            'id' => 624,
            'question' => ' Does the covered entity have appropriate policies and procedures in place to prohibit it from requiring an individual to waive any right under the Breach Notification Rule as a condition of ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:08:31',
            'updated_at' => '2023-11-16 19:08:31'
        ]);



        Question::create([
            'id' => 625,
            'question' => '§164.530(c) Has the covered entity implemented administrative, technical, and physical safeguards to protect all PHI from any intentional or unintentional use or disclosure that is in violati',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:09:25',
            'updated_at' => '2023-11-16 19:09:25'
        ]);



        Question::create([
            'id' => 626,
            'question' => ' Does the covered entity have policies and procedures that are consistent with the requirements of the Breach Notification Rule?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:09:34',
            'updated_at' => '2023-11-16 19:09:34'
        ]);



        Question::create([
            'id' => 627,
            'question' => '§164.530(d) (1) Does the covered entity have a process for individuals to make complaints, consistent with the requirements of the established performance criterion?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:10:17',
            'updated_at' => '2023-11-16 19:10:17'
        ]);



        Question::create([
            'id' => 628,
            'question' => ' Does the covered entity have policies and procedures for maintaining documentation consistent with the requirements at §164.530(j)?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:10:33',
            'updated_at' => '2023-11-16 19:10:33'
        ]);



        Question::create([
            'id' => 629,
            'question' => 'Does the covered entity have policies and procedures for determining whether an impermissible use or disclosure requires notifications under the Breach Notification Rule?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:11:41',
            'updated_at' => '2023-11-16 19:11:41'
        ]);



        Question::create([
            'id' => 630,
            'question' => '§164.530(d) (2) Has the covered entity documented all complaints received and their disposition consistent with the performance criteria? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:13:24',
            'updated_at' => '2023-11-16 19:13:24'
        ]);



        Question::create([
            'id' => 631,
            'question' => '§164.530(e) (1) Does the covered entity apply appropriate sanctions against members of the workforce who fail to comply with the privacy policies and procedures of the entity or the Privacy R',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:14:28',
            'updated_at' => '2023-11-16 19:14:28'
        ]);



        Question::create([
            'id' => 632,
            'question' => '§164.530(f) Does the covered entity mitigate any harmful effect that is known to the covered entity of a use or disclosure of PHI by the covered entity or its business associates, in violatio',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:15:28',
            'updated_at' => '2023-11-16 19:15:28'
        ]);



        Question::create([
            'id' => 633,
            'question' => 'Does the covered entity have a process for conducting a breach risk assessment when an impermissible use or disclosure of PHI is discovered, to determine whether there is a low probability th',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:15:49',
            'updated_at' => '2023-11-16 19:15:49'
        ]);



        Question::create([
            'id' => 634,
            'question' => 'If not, does the covered entity have a policy and procedure that requires notification without conducting a risk assessment for all or specific types of incidents that result in impermissible',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:16:45',
            'updated_at' => '2023-11-16 19:16:45'
        ]);



        Question::create([
            'id' => 635,
            'question' => '§164.530(g) Has the covered entity implemented policies and procedures addressing the prevention of intimidating or retaliatory actions against any individual for the exercise by the individu',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:17:54',
            'updated_at' => '2023-11-16 19:17:54'
        ]);



        Question::create([
            'id' => 636,
            'question' => 'Did the covered entity or business associate determine that an acquisition, access, use or disclosure of protected health information in violation of the Privacy Rule did not require notifica',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:17:59',
            'updated_at' => '2023-11-16 19:17:59'
        ]);



        Question::create([
            'id' => 637,
            'question' => '§164.530(h) Has the covered entity required individuals to waive their right to complain to the Secretary of HHS about a covered entity or business associate not complying with these Rules, a',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:18:49',
            'updated_at' => '2023-11-16 19:18:49'
        ]);



        Question::create([
            'id' => 638,
            'question' => ' If yes, did the covered entity or business associate determine that one of the regulatory exceptions to the definition of breach at §164.402(1) apply?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:19:09',
            'updated_at' => '2023-11-16 19:19:09'
        ]);



        Question::create([
            'id' => 639,
            'question' => '§164.530(i) Has the covered entity implemented policies and procedures with respect to PHI that are designed to comply with the standards, implementation specifications, and other requirement',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:19:37',
            'updated_at' => '2023-11-16 19:19:37'
        ]);



        Question::create([
            'id' => 640,
            'question' => ' If yes, did the covered entity or business associate determine that the breach did not require notification, under §§164.404-410, because the PHI was not unsecured PHI, i.e., it was rendered',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:20:18',
            'updated_at' => '2023-11-16 19:20:18'
        ]);



        Question::create([
            'id' => 641,
            'question' => '§164.530(j) Does the entity maintain all required policies and procedures, written communication, and documentation in written or electronic form and are such documentations retained for the ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:20:24',
            'updated_at' => '2023-11-16 19:20:24'
        ]);



        Question::create([
            'id' => 642,
            'question' => '§164.306(a) Does the covered entity or business associate ensure confidentiality, integrity and availability of ePHI?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:21:28',
            'updated_at' => '2023-11-16 19:21:28'
        ]);



        Question::create([
            'id' => 643,
            'question' => '§164.306(a) Does the covered entity or business associate protect against reasonably anticipated threats or hazards to the security or integrity of ePHI? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:22:21',
            'updated_at' => '2023-11-16 19:22:21'
        ]);



        Question::create([
            'id' => 644,
            'question' => '§164.306(a) Does the covered entity or business associate protect against reasonably anticipated uses or disclosures of ePHI that are not permitted or required by the Privacy Rule? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:23:17',
            'updated_at' => '2023-11-16 19:23:17'
        ]);



        Question::create([
            'id' => 645,
            'question' => '§164.306(a) Does the covered entity or business associate ensure compliance with Security Rule by its workforce?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:24:14',
            'updated_at' => '2023-11-16 19:24:14'
        ]);



        Question::create([
            'id' => 646,
            'question' => '§164.306(b) Does the covered entity comply with Security Rule accounting for Size, Technical Infrastructure, and Cost, as well as the probability of potential risks to electronic protected he',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:25:10',
            'updated_at' => '2023-11-16 19:25:10'
        ]);



        Question::create([
            'id' => 647,
            'question' => '§164.308(a) Does the entity have written policies and procedures in place to prevent, detect, contain and correct security violations? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:26:43',
            'updated_at' => '2023-11-16 19:26:52'
        ]);



        Question::create([
            'id' => 648,
            'question' => '§164.308(a) (1)(ii)(A) Does the entity have policies and procedures in place to conduct an accurate and thorough assessment of the potential risks and vulnerabilities to the confidentiality, ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:27:41',
            'updated_at' => '2023-11-16 19:27:41'
        ]);



        Question::create([
            'id' => 649,
            'question' => '§164.308(a) (1)(ii)(B) Does the entity have policies and procedures in place regarding a risk management process sufficient to reduce risks and vulnerabilities to a reasonable and appropriate',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:28:51',
            'updated_at' => '2023-11-16 19:28:51'
        ]);



        Question::create([
            'id' => 650,
            'question' => '§164.308(a) (1)(ii)(C) Does the entity have policies and procedures in place regarding sanctions to apply to workforce members who fail to comply with the entity\'s security policies and proce',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:29:43',
            'updated_at' => '2023-11-16 19:29:43'
        ]);



        Question::create([
            'id' => 651,
            'question' => '§164.308(a) (1)(ii)(D) Does the entity have policies and procedures in place regarding the regular review of information system activity and does the entity regularly review records of inform',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:30:34',
            'updated_at' => '2023-11-16 19:30:34'
        ]);



        Question::create([
            'id' => 652,
            'question' => '§164.308(a) (2) Does the entity have policies and procedures in place regarding the establishment of a security official? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:31:26',
            'updated_at' => '2023-11-16 19:31:26'
        ]);



        Question::create([
            'id' => 653,
            'question' => '§164.308(a) (3)(i) Does the entity have policies and procedures in place to ensure all members of its workforce have appropriate access to ePHI?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:32:16',
            'updated_at' => '2023-11-16 19:33:02'
        ]);



        Question::create([
            'id' => 654,
            'question' => '§164.308(a) (3)(ii)(A) Does the entity have policies and procedures in place regarding the authorization and/or supervision of workforce members who work with ePHI or in locations where it mi',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:33:19',
            'updated_at' => '2023-11-16 19:33:19'
        ]);



        Question::create([
            'id' => 655,
            'question' => 'Does the covered entity have policies and procedures for notifying individuals of a breach of their protected health information?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:41:53',
            'updated_at' => '2023-11-16 19:41:53'
        ]);



        Question::create([
            'id' => 656,
            'question' => 'Are individuals notified of breaches within the required time period in accordance with the established criterion?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:42:56',
            'updated_at' => '2023-11-16 19:42:56'
        ]);



        Question::create([
            'id' => 657,
            'question' => 'Are individuals notified of breaches within the required time period in accordance with the established criterion?',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:43:55',
            'updated_at' => '2023-11-16 19:43:55'
        ]);



        Question::create([
            'id' => 658,
            'question' => 'Does the covered entity have policies and procedures for notifying an individual, an individual\'s next of kin, or a personal representative of a breach? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:45:49',
            'updated_at' => '2023-11-16 19:45:49'
        ]);



        Question::create([
            'id' => 659,
            'question' => ' Does the covered entity have policies and procedures for notifying media outlets of breaches affecting more than 500 residents of a State or jurisdiction? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:47:09',
            'updated_at' => '2023-11-16 19:47:09'
        ]);



        Question::create([
            'id' => 660,
            'question' => 'Does the covered entity have policies and procedures for notifying the Secretary of breaches involving 500 or more individuals? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:48:39',
            'updated_at' => '2023-11-16 19:48:39'
        ]);



        Question::create([
            'id' => 661,
            'question' => 'Did the business associate or subcontractor determine that there were any breaches of unsecured PHI within the specified period? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:49:38',
            'updated_at' => '2023-11-16 19:49:38'
        ]);



        Question::create([
            'id' => 662,
            'question' => 'Does the covered entity or business associate have policies and procedures regarding how the covered entity or business associate would respond to a law enforcement statement that a notice or',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:50:44',
            'updated_at' => '2023-11-16 19:50:44'
        ]);



        Question::create([
            'id' => 663,
            'question' => 'Has the covered entity or business associate delayed notification of a breach of unsecured PHI pursuant to such a law enforcement statement? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:52:11',
            'updated_at' => '2023-11-16 19:52:11'
        ]);



        Question::create([
            'id' => 664,
            'question' => ' Does the covered entity or business associate, as applicable, have policies and procedures in place to accept the burden of demonstrating that all notifications were made as required by the ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:53:31',
            'updated_at' => '2023-11-16 19:53:31'
        ]);



        Question::create([
            'id' => 665,
            'question' => ' Does the covered entity have a process in place for individuals to complain about its compliance with the Breach Notification Rule? ',
            'answer_type' => 1,
            'control_id' => NULL,
            'file_attachment' => 0,
            'question_logic' => 1,
            'risk_assessment' => 1,
            'compliance_assessment' => 0,
            'maturity_assessment' => 0,
            'created_at' => '2023-11-16 19:56:07',
            'updated_at' => '2023-11-16 19:56:07'
        ]);

        //         Question::create([
        //             "id" => 1,
        //             "question" => 'Do you actively manage (inventory, track, and correct) all hardware devices on the network so that only authorized devices are given access, and unauthorized and unmanaged devices are found and prevented from gaining access?',
        // //            "order" => 1
        //         ]);
        //         Question::create([
        //             "id" => 2,
        //             "question" => 'Do you actively manage (inventory, track, and correct) all software on the network so that only authorized software is installed and can execute, and that unauthorized and unmanaged software is found and prevented from installation or execution?',
        // //            "order" => 2
        //         ]);
        //         Question::create([
        //             "id" => 3,

        //             "question" => 'Do you establish, implement, and actively manage (track, report on, correct) the security configuration of laptops, servers, and workstations using a rigorous configuration management and change control process in order to prevent attackers from exploiting vulnerable services and settings?',
        // //            "order" => 3
        //         ]);
        //         Question::create([
        //             "id" => 4,

        //             "question" => 'Do you continuously acquire, assess, and take action on new information in order to identify vulnerabilities, remediate, and minimize the window of opportunity for attackers?',
        // //            "order" => 4
        //         ]);
        //         Question::create([
        //             "id" => 5,

        //             "question" => 'Do you have processes and tools to track/control/prevent/correct the use, assignment, and configuration of administrative privileges on computers, networks, and applications?',
        // //            "order" => 5
        //         ]);
        //         Question::create([
        //             "id" => 6,

        //             "question" => 'Do you collect, manage, and analyze audit logs of events that could help detect, understand, or recover from an attack?',
        // //            "order" => 6
        //         ]);
        //         Question::create([
        //             "id" => 7,

        //             "question" => 'Do you minimize the attack surface and the opportunities for attackers to manipulate human behavior through their interaction with web browsers and emails systems?',
        // //            "order" => 7
        //         ]);
        //         Question::create([
        //             "id" => 8,

        //             "question" => 'Do you control the installation, spread, and execution of malicious code at multiple points in the enterprise, while optimizing the use of automation to enable rapid updating of defense, data gathering, and corrective action?',
        // //            "order" => 8
        //         ]);
        //         Question::create([
        //             "id" => 9,

        //             "question" => 'Do you manage (track/control/correct) the ongoing operational use of ports, protocols, and services on networked devices in order to minimize windows of vulnerability available to attackers?',
        // //            "order" => 9
        //         ]);
        //         Question::create([
        //             "id" => 10,

        //             "question" => 'Do you have processes and tools to properly back up critical information with a proven methodology for timely recovery of it?',
        // //            "order" => 10
        //         ]);
        //         Question::create([
        //             "id" => 11,

        //             "question" => 'Do you establish, implement, and actively manage (track, report on, correct) the security configuration of network infrastructure devices using a rigorous configuration management and change control process in order to prevent attackers from exploiting vulnerable services and settings?',
        // //            "order" => 11
        //         ]);
        //         Question::create([
        //             "id" => 12,

        //             "question" => 'Do you detect/prevent/correct the flow of information transferring networks of different trust levels with a focus on security-damaging data?',
        // //            "order" => 12
        //         ]);
        //         Question::create([
        //             "id" => 13,

        //             "question" => 'Do you have processes and tools to prevent data exfiltration, mitigate the effects of exfiltrated data, and ensure the privacy and integrity of sensitive information?',
        // //            "order" => 13
        //         ]);
        //         Question::create([
        //             "id" => 14,

        //             "question" => 'Do you have processes and tools to track/control/prevent/correct secure access to critical assets (e.g., information, resources, systems) according to the formal determination of which persons, computers, and applications have a need and right to access these critical assets based on an approved classification?',
        // //            "order" => 14
        //         ]);
        //         Question::create([
        //             "id" => 15,

        //             "question" => 'Do you have processes and tools to track/control/prevent/correct the security use of wireless local area networks (LANS), access points, and wireless client systems?',
        // //            "order" => 15
        //         ]);
        //         Question::create([
        //             "id" => 16,

        //             "question" => 'Do you actively manage the life cycle of system and application accounts - their creation, use, dormancy, deletion - in order to minimize opportunities for attackers to leverage them?',
        // //            "order" => 16
        //         ]);
        //         Question::create([
        //             "id" => 17,

        //             "question" => 'Do all functional roles in the organization (prioritizing those mission-critical to the business and its security) identiy the specific knowledge, skills, and abilities needed to support defense of the enterprise; develop and execute an integrated plan to assess, identify gaps, and remediate through policy, organizational planning, training, and awareness programs?',
        // //            "order" => 17
        //         ]);
        //         Question::create([
        //             "id" => 18,

        //             "question" => 'Do you manage the security life cycle of all in-house developed and acquired software in order to prevent, detect, and correct security weaknesses?',
        // //            "order" => 18
        //         ]);
        //         Question::create([
        //             "id" => 19,

        //             "question" => 'Do you protect the organization\'s information, as well as its reputation, by developing and implementing an incident response infrastructure (e.g., plans, defined roles, training, communications, management oversight) for quickly discovering an attack and then effectively containing the damage, eradicating the attacker\'s presence, and restoring the integrity of the network and systems?',
        // //            "order" => 19
        //         ]);
        //         Question::create([
        //             "id" => 20,

        //             "question" => 'Do you test the overall strength of your organization\'s defenses (the technology, the processes, and the people) by simulating the objectives and actions of an attacker?',
        // //            "order" => 20
        //         ]);
        //         //  "assessment_id" => 1,

        //         $assessment = Assessment::query()->find(1);
        //         for ($x = 1; $x <= 20; $x++) {
        //             $assessment->questions()->attach($x);
        //         }


        //         Question::create([
        //             "id" => 21,

        //             "question" => '(3.1.1) Do we limit information system access to authorized users, processes acting on behalf of authorized users, or devices? (including other information systems)',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 22,

        //             "question" => '(3.1.2) Do we limit access to the types of transactions and functions that authorized users are permitted to execute?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 23,

        //             "question" => '(3.1.3.) Do we control CUI in accordance with approved authorizations?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 24,

        //             "question" => '(3.1.4) Do we keep duties of individuals separated to reduce the risk of malevolent activity without collusion?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 25,

        //             "question" => '(3.1.5) Do we employ the principle of least privilege, including specific security functions and privileged accounts?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 26,

        //             "question" => '(3.1.6) Do we disallow the organization to use non-privileged accounts or roles when accessing non-security functions?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 27,

        //             "question" => '(3.1.7) Do we prevent non-privileged users from executing privileged functions and audit the execution of such functions?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 28,

        //             "question" => '(3.1.8) Do we limit unsuccessful logon attempts?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 29,

        //             "question" => '(3.1.9) Do we provide privacy and security notices consistent with applicable CUI rules?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 30,

        //             "question" => '(3.1.10) Do we use session lock with pattern hiding displays to prevent access/viewing of data after a period of inactivity?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 31,

        //             "question" => '(3.1.11) Do we terminate a user session after a defined condition or time?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 32,

        //             "question" => '(3.1.12) Do we monitor and control remote access sessions?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 33,

        //             "question" => '(3.1.13) Do we employ cryptographic mechanisms to protect the confidentiality of remote access sessions?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 34,

        //             "question" => '(3.1.14) Do we route remote access through managed access control points?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 35,

        //             "question" => '(3.1.15) Does the system require authorization of remote execution of privileged commands and remote access to security relevant information?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 36,

        //             "question" => '(3.1.16) Do we authorize wireless access prior to allowing such connections?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 37,

        //             "question" => '(3.1.17) Do we protect wireless access using authentication and encryption?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 38,

        //             "question" => '(3.1.18) Do we have guidelines and procedures in place to restrict the operation and connection of mobile devices?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 39,

        //             "question" => '(3.1.19) Do we encrypt CUI on mobile devices?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 40,

        //             "question" => '(3.1.20) Do we verify and control/limit connections to and use of external information systems?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 41,

        //             "question" => '(3.1.21) Do we limit use of organizational portable storage devices on external information systems?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 42,

        //             "question" => '(3.1.22) Do we prohibit posting or processing control information on publicly accessible information systems?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 43,

        //             "question" => '(3.2.1) Do we ensure that managers, systems administrators, and users of organizational information systems are made aware of the security risks associated with their activities and of the applicable policies, standards, and procedures related to the security of organizational information systems?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 44,

        //             "question" => '(3.2.2) Do we Ensure that organizational personnel are adequately trained to carry out their assigned information security-related duties and responsibilities?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 45,

        //             "question" => '(3.2.3) Do we provide security awareness training on recognizing and reporting potential indicators of insider threats?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 46,

        //             "question" => '(3.3.1) Do you create, protect, and retain information system audit records to the extent needed to enable the monitoring, analysis, investigations, and reporting of unlawful, unauthorized, or inappropriate information system activity?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 47,

        //             "question" => '(3.3.2) Do we ensure that the actions of individual information system users can be uniquely traced to those users so they can be held accountable for their actions?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 48,

        //             "question" => '(3.3.3) Do we review and update audited events?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 49,

        //             "question" => '(3.3.4) Do we have alerts in the event of an audit process failure?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 50,

        //             "question" => '(3.3.5) Do we use automated mechanisms to integrate and correlate audit review, analysis, and reporting processes for investigation and response to indications of inappropriate, suspicious, or unusual activity?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 51,

        //             "question" => '(3.3.6) Do we provide audit reduction and report generation to support on-demand analysis and reporting?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 52,

        //             "question" => '(3.3.7) Do we provide an information system capability that compares and synchronizes internal system clocks with an authoritative source to generate time stamps for audit records?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 53,

        //             "question" => '(3.3.8) Do we protect audit information and audit tools from unauthorized access, modification, and deletion?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 54,

        //             "question" => '(3.3.9) Do we limit management of audit functionality to a subset of privileged users?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 55,

        //             "question" => '(3.4.1) Do we establish and maintain baseline configurations and inventories of organizational information systems (including hardware, software, firmware, and documentation) throughout the respective system development life cycles?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 56,

        //             "question" => '(3.4.2) Do we establish and enforce security configuration settings for information technology products employed in organizational information systems?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 57,

        //             "question" => '(3.4.3) Do we track, review, approve/disapprove, and audit changes to information systems?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 58,

        //             "question" => '(3.4.4) Do we analyze the security impact of changes prior to implementation?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 59,

        //             "question" => '(3.4.5) Do we define, document, approve, and enforce physical and logical access restrictions associated with changes to the information system?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 60,

        //             "question" => '(3.4.6) Do we employ the principle of least functionality by configuring the information system to provide only essential capabilities? ',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 61,

        //             "question" => '(3.4.7) Do we restrict, disable, and prevent the use of nonessential programs, functions, ports, protocols, and services?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 62,

        //             "question" => '(3.4.8) Do we apply deny-by-exception (blacklist) policy to prevent the use of unauthorized software or deny-all, permit-by-exception (whitelisting) policy to allow the execution of authorized software?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 63,

        //             "question" => '(3.4.9) Do we control and monitor user-installed software?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 64,

        //             "question" => '(3.5.1) Do we identify information system users, processes acting on behalf of users, or devices?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 65,

        //             "question" => '(3.5.2) Do we authenticate (or verify) the identities of those users, processes, or devices, as a prerequisite to allowing access to organizational information systems?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 66,

        //             "question" => '(3.5.3) Do we use multi-factor authentication for local and network access to privileged accounts and for network access to non-privileged accounts?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 67,

        //             "question" => '(3.5.4) Do we employ replay-resistant authentication mechanisms for network access to privileged and non-privileged accounts?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 68,

        //             "question" => '(3.5.5) Do we prevent the reuse of identifiers for a defined period?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 69,

        //             "question" => '(3.5.6) Do we disable identifiers after a defined period of inactivity?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 70,

        //             "question" => '(3.5.7) Do we enforce a minimum password complexity and change of characters when new passwords are created?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 71,

        //             "question" => '(3.5.8) Do we prohibit password reuse for a specified number of generations?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 72,

        //             "question" => '(3.5.9) Do we allow temporary password use for system logons with an immediate change to a permanent password?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 73,

        //             "question" => '(3.5.10) Do we store and transmit only encrypted representation of passwords?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 74,

        //             "question" => '(3.5.11) Do we obscure feedback of authentication information?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 75,

        //             "question" => '(3.6.1) Have we established an operational incident handling capability for organizational information systems that includes adequate preparation, detection, analysis, containment, recovery, and user response activities?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 76,

        //             "question" => '(3.6.2) Do we track, document, and report incidents to appropriate officials and/or authorities both internal and external to the organizations? ',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 77,

        //             "question" => '(3.6.3) Do we test the organizational incident response capability? ',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 78,

        //             "question" => '(3.7.1) Do we perform maintenance on organizational information systems?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 79,

        //             "question" => '(3.7.2) Do we provide effective controls on the tools, techniques, mechanisms, and personnel used to conduct information system maintenance?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 80,

        //             "question" => '(3.7.3) Do we ensure equipment removed for off-site maintenance is sanitized of any CUI?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 81,

        //             "question" => '(3.7.4) Do we check media containing diagnostic and test programs for malicious code before the media are used in the information system?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 82,

        //             "question" => '(3.7.5) Do we require multifaction authentication to establish non-local maintenance sessions via external network connections when non-local maintenance is complete? ',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 83,

        //             "question" => '(3.7.6) Do we supervise the maintenance activities of maintenance personnel without required access authorization?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 84,

        //             "question" => '(3.8.1) Do we protect (i.e., physically control and securely store) information system media  containing CUI, both paper and digital?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 85,

        //             "question" => '(3.8.2) Do we limit access to CUI on information system media to authorized users?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 86,

        //             "question" => '(3.8.3) Do we sanitize or destroy information system media containing CUI before disposal or release for reuse?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 87,

        //             "question" => '(3.8.4) Do we mark media with the necessary CUI markings and distribution limitations?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 88,

        //             "question" => '(3.8.5) Do we control access to media containing CUI and maintain accountability for media during transport outside of controlled areas?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 89,

        //             "question" => '(3.8.6) Do we implement cryptographic mechanisms to protect the confidentiality of CUI stored on digital media during transport unless otherwise protected by alternative physical safeguards?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 90,

        //             "question" => '(3.8.7) Do we control the use of removable media on information system components?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 91,

        //             "question" => '(3.8.8) Do we prohibit the use of portable storage devices when such devices have no identifiable owner?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 92,

        //             "question" => '(3.8.9) Do we protect the confidentiality of backup CUI as storage locations?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 93,

        //             "question" => '(3.9.1) Do we screen individuals prior to authorizing access to information systems containing CUI?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 94,

        //             "question" => '(3.9.2) Do we ensure that CUI and information systems containing CUI are protected during and after personnel actions such as terminations and transfers?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 95,

        //             "question" => '(3.10.1) Do we limit physical access to organizational information systems, equipment, and the respective operating environments to authorized individuals?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 96,

        //             "question" => '(3.10.2) Do we protect and monitor the physical facility and support infrastructure for those information systems?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 97,

        //             "question" => '(3.10.3) Do we escort visitors and monitor visitor activity?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 98,

        //             "question" => '(3.10.4) Do we maintain audit logs of physical access?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 99,

        //             "question" => '(3.10.5) Do we control and manage physical access devices?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 100,

        //             "question" => '(3.10.6) Do we enforce safeguarding measures for CUI at alternate work sites? (e.g. telework sites)',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 101,

        //             "question" => '(3.11.1) Do we periodically assess the risk to organizational operations (including mission, functions, image, or reputation), organizational assets, and individuals, resulting from the operation of organizational information systems and the associated processing, storage, or transmission of CUI?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 102,

        //             "question" => '(3.11.2) Do we scan for vulnerabilities in the information system and applications periodically and when new vulnerabilities affecting the system are identified?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 103,

        //             "question" => '(3.11.3) Do we remediate vulnerabilities in accordance with assessments of risk?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 104,

        //             "question" => '(3.12.1) Do we periodically assess the security controls in organizational information systems to determine if the controls are effective in their application?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 105,

        //             "question" => '(3.12.2) Do we develop and implement plans of action designed to correct deficiencies and reduce or eliminate vulnerabilities in organizational information systems?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 106,

        //             "question" => '(3.12.3) Do we monitor information system security controls on an ongoing basis to ensure the continued effectiveness of the controls?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 107,

        //             "question" => '(3.13.1) Do we monitor, control, and protect organizational communications (i.e. information transmitted or received by organizational information systems) at the external boundaries and key internal boundaries of the information systems?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 108,

        //             "question" => '(3.13.2) Do we employ architectural designs, software development techniques, and systems engineering principles that promote effective information security within organizations information systems?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 109,

        //             "question" => '(3.13.3) Do we separate user functionality from information system management functionality?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 110,

        //             "question" => '(3.13.4) Do we prevent unauthorized and unintended information transfer via shared system resources?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 111,

        //             "question" => '(3.13.5) Do we implement subnetworks for publicly accessible system components that are physically or logically separated from internal networks?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 112,

        //             "question" => '(3.13.6) Do we deny network communications traffic by default and allow network communications by exception?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 113,

        //             "question" => '(3.13.7) Do we prevent remote devices from simultaneously establishing non-remote connections with the information system and communicating via some other connection to resources in external networks?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 114,

        //             "question" => '(3.13.8) Do we implement cryptographic mechanisms to prevent unauthorized disclosure of CUI during transmission unless otherwise protected by alternative physical safeguards?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 115,

        //             "question" => '(3.13.9) Do we terminate network connections associated with communications sessions at the end of the sessions or after a defined period of inactivity?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 116,

        //             "question" => '(3.13.10) Do we establish and manage cryptographic keys for cryptography employed in the information system?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 117,

        //             "question" => '(3.13.12) Do we prohibit remote activation of collaborative computing devices and provide indication of devices in use to users present at the device?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 118,

        //             "question" => '(3.13.13) Do we control and monitor the use of mobile code? ',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 119,

        //             "question" => '(3.13.14) Do we control and monitor the use of voice over internet protocol (VOIP) technologies?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 120,

        //             "question" => '(3.13.15) Do we protect the authenticity of communications sessions?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 121,

        //             "question" => '(3.13.16) Do we protect the confidentiality of CUI at rest?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 122,

        //             "question" => '(3.14.1) Do we identify, report, and correct information and information system flaws in a timely manner?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 123,

        //             "question" => '(3.14.2) Do we provide protection from malicious code at appropriate locations within organizational information systems?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 124,

        //             "question" => '(3.14.3) Do we monitor information system security alerts and advisories and take appropriate actions in response?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 125,

        //             "question" => '(3.14.4) Do we update malicious code protection mechanisms when new releases are available?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 126,

        //             "question" => '(3.14.5) Do we perform periodic scans of the information system and real-time scans of files from external sources as files are downloaded, opened, or executed?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 127,

        //             "question" => '(3.14.6) Do we monitor the information system including inbound and outbound communications traffic, to detect attacks and indicators of potential attacks?',
        // //            "order" => 999999
        //         ]);
        //         Question::create([
        //             "id" => 128,

        //             "question" => '(3.14.7) Do we identify unauthorized use of the information system?',
        // //            "order" => 999999
        //         ]);

        //         $assessment = Assessment::query()->find(2);
        //         for ($y = 21; $y <= 128; $y++) {
        //             $assessment->questions()->attach($y);
        //         }
        //         // Question::create([
        //         //     "id" => 129,
        //         //
        //         //     "question" => '(1.1.1) Have you established and implemented firewall and router configuration standards that include a formal process for approving and testing all network connections and changes to the firewall and router configurations?',
        // //        //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 130,
        //         //
        //         //     "question" => '(1.1.2) Have you established and implemented firewall and router configuration standards that include a current network diagram that identifies all connections between the cardholder data environment and other networks, including any wireless networks?',
        // //        //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 131,
        //         //
        //         //     "question" => '(1.1.3) Have you created a diagram that shows the flow all cardholder data across systems and networks?',
        // //        //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 132,
        //         //
        //         //     "question" => '(1.1.4) Are there firewalls in place at each and every internet connection and between any demilitarized zone (DMZ) and any internal network zone? ',
        // //        //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 133,
        //         //
        //         //     "question" => '(1.1.5) Do you have procedures in place for the description of groups, roles, and responsibilities for management of network components?',
        // //        //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 134,
        //         //
        //         //     "question" => '(1.1.6) Do you have documentation of business justification and approval for use of all services, protocols, and ports allowed, including documentation of security features implemented for those protocols considered to be insecure?',
        // //        //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 135,
        //         //
        //         //     "question" => '(1.1.7) Do you review firewall and router rule sets at least every six months?',
        // //        //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 136,
        //         //
        //         //     "question" => '(1.2) Have you created firewall and router configurations that restrict connections between untrusted networks and any system components in the cardholder data environment?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 137,
        //         //
        //         //     "question" => '(1.2.1) Are there restrictions on inbound and outbound traffic to only that which is necessary for the cardholder data environment, and specifically deny all other traffic?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 138,
        //         //
        //         //     "question" => '(1.2.2) Are router configuration files kept secure and synchronized?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 139,
        //         //
        //         //     "question" => '(1.2.3) Have you installed perimeter firewalls between all wireless networks and the cardholder data environment, and configured these firewalls to deny or, if traffic is necessary for business purposes, permit only authorized traffic between the wireless environment and the cardholder data environment?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 140,
        //         //
        //         //     "question" => '(1.3) Do you prohibit direct public access between the internet and any system component in the cardholder data environment?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 141,
        //         //
        //         //     "question" => '(1.3.1) Have you implemented a DMZ to limit inbound traffic to only system components that provide authorized publicly accessible services, protocols, and ports?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 142,
        //         //
        //         //     "question" => '(1.3.2) Do you limit inbound internet traffic to IP addresses within the DMZ?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 143,
        //         //
        //         //     "question" => '(1.3.3) Have you implemented anti-spoofing measures to detect and block forged source IP addresses from entering the network?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 144,
        //         //
        //         //     "question" => '(1.3.4) Do you disallow unauthorized outbound traffic from the cardholder data environment to the internet?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 145,
        //         //
        //         //     "question" => '(1.3.5) Do you permit only \"established\" connections into the network?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 146,
        //         //
        //         //     "question" => '(1.3.6) Have you placed system components that store cardholder data (such as a database) in an internal network zone, segregated from the DMZ and other untrusted networks?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 147,
        //         //
        //         //     "question" => '(1.3.7) Are private IP addresses and routing information inaccessible to unauthorized parties?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 148,
        //         //
        //         //     "question" => '(1.4) Have you installed personal firewall software or equivalent functionality on all portable computing devices (including company and/or employee-owned) that connect to the internet when outside the network (for example, laptops used by employees), and which are also used to access the CDE?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 149,
        //         //
        //         //     "question" => '(1.5) Have you ensured that security policies and operational procedures for managing firewalls are documented, in use, and known to all affected parties?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 150,
        //         //
        //         //     "question" => '(2.1) Have you changed all vendor-supplied defaults and removed or disabled unnecessary default accounts before installing systems onto the network?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 151,
        //         //
        //         //     "question" => '(2.1.1) Do you change all of the wireless vendor defaults at the time of installation, including but not limited to default wireless encryption keys, passwords, and SNMP community strings?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 152,
        //         //
        //         //     "question" => '(2.2) Have you developed configuration standards for all system components, assured that these standards address all known security vulnerabilities and are consistent with industry-accepted system hardening standards?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 153,
        //         //
        //         //     "question" => '(2.2.1) Have you implemented only one primary function per server to prevent functions that require different security levels from co-existing on the same server?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 154,
        //         //
        //         //     "question" => '(2.2.2) Do you enable only necessary services, protocols, daemons, etc., as required to for the function of the system?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 155,
        //         //
        //         //     "question" => '(2.2.3) Have you implemented additional security features for any required services, protocols, or daemons that are considered to be insecure?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 156,
        //         //
        //         //     "question" => '(2.2.4) Have you configured security parameters to prevent misuse?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 157,
        //         //
        //         //     "question" => '(2.2.5) Have you removed all unnecessary functionality, such as scripts, drivers, features, subsystems, file systems, and unnecessary web servers?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 158,
        //         //
        //         //     "question" => '(2.3) Have you encrypted all non-console administrative access using strong cryptography?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 159,
        //         //
        //         //     "question" => '(2.4) Do you maintain an inventory of system components that are in scope for PCI DSS?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 160,
        //         //
        //         //     "question" => '(2.5) Have you ensured that security policies and operational procedures for managing vendor defaults and other security parameters are documented, in use, and known to all affected parties?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 161,
        //         //
        //         //     "question" => '(2.6) Are shared hosting providers protecting each entity\'s hosted environment and cardholder data?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 162,
        //         //
        //         //     "question" => '(3.1) Do you keep cardholder data storage to a minimum by implementing data retention and disposal policies, procedures and processes that include at least limiting data storage amount and retention time, processes for secure deletion of data when no longer needed, specific retention requirements for cardholder data, and a quarterly process for identifying and securely deleting stored cardholder data that exceeds defined retention?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 163,
        //         //
        //         //     "question" => '(3.2a) Do you store sensitive authentication data after authorization (even if encrypted)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 164,
        //         //
        //         //     "question" => '(3.2b) If sensitive authentication data is received, do you render all data unrecoverable upon completion of the the authorization request?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 165,
        //         //
        //         //     "question" => '(3.2.1) Do you store the full contents of any track (from the magnetic stripe located on the back of a card, equivalent data contained on a chip, or elsewhere) after authorization?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 166,
        //         //
        //         //     "question" => '(3.2.2) Do you store the card verification code or value (three-digit or four-digit number printed on the front or back of a payment card used to verify card-not-present transactions) after authorization?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 167,
        //         //
        //         //     "question" => '(3.2.3) Do you store the personal identification number (PIN) or the encrypted PIN block after authorization?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 168,
        //         //
        //         //     "question" => '(3.3) Do you mask PAN when displayed (the first six and last four digits are the maximum number of digits to be displayed), such that only personnel with legitimate business need can see more than the first six/last four digits of the PAN?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 169,
        //         //
        //         //     "question" => '(3.4) Do you render PAN unreadable anywhere it is stores (including on portable digital media, backup media, and in logs) by any of the following: One-way Hashes based on strong cryptography, truncation, index tokens and pads, strong cryptography with associated key-management processes and procedures?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 170,
        //         //
        //         //     "question" => '(3.4.1) If disk encryption is used, is logical access managed separately and independently of native operating system authentication and access control mechanisms? (decryption keys must not be associated with user accounts.)',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 171,
        //         //
        //         //     "question" => '(3.5) Do you document and implement procedures to protect keys used to secure stored cardholder data against disclosure and misuse?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 172,
        //         //
        //         //     "question" => '(3.5.1) Additional requirement for service providers only: Do you maintain a documented description of the cryptographic architecture that includes details of all algorithms, protocols, and keys used for the protection of card holder data, including key strength and expiry date, description of the key usage for each key, inventory of any HSMs and other SCDs used for key management?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 173,
        //         //
        //         //     "question" => '(3.5.2) Do you restrict access to cryptographic keys to the fewest number of custodians necessary?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 174,
        //         //
        //         //     "question" => '(3.5.3) Do you store secret and private keys used to encrypt/decrypt cardholder data in one (or more) of the following forms at all times: Encrypted with a key-encrypting key that is at least as strong as the data encrypting key, and that is stored separately from the data-encrypting key. Within a secure cryptographic device. As at least two full-length key components or key shares, in accordance with an industry-accepted method?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 175,
        //         //
        //         //     "question" => '(3.5.4) Are cryptographic keys stored in the fewest possible locations?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 176,
        //         //
        //         //     "question" => '(3.6.1) Do you fully document and implement all key-management processes and procedures for cryptographic keys used for encryption of cardholder data including generation of strong cryptographic keys?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 177,
        //         //
        //         //     "question" => '(3.6.2) Do you fully document and implement all key-management processes and procedures for cryptographic keys used for encryption of cardholder data including secure cryptographic key distribution?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 178,
        //         //
        //         //     "question" => '(3.6.3) Do you fully document and implement all key-management processes and procedures for cryptographic keys used for encryption of cardholder data including secure cryptographic key storage?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 179,
        //         //
        //         //     "question" => '(3.6.4) Do you perform cryptographic key changes for keys that have reached the end of their cryptoperiod based on industry best practices and guidelines?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 180,
        //         //
        //         //     "question" => '(3.6.5) Do you have practices in place for the retirement or replacement of keys as deemed necessary when the integrity of the key has been weakened, or keys are suspected of being compromised?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 181,
        //         //
        //         //     "question" => '(3.6.6) If manual clear-text cryptographic key-management operations are used, are these operations being managed by using split knowledge and dual control?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 182,
        //         //
        //         //     "question" => '(3.6.7) Do you have procedures in places to prevent unauthorized substitution of cryptographic keys?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 183,
        //         //
        //         //     "question" => '(3.6.8) Do you require cryptographic key custodians to formally acknowledge that they understand and accept their key-custodian responsibilities?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 184,
        //         //
        //         //     "question" => '(3.7) Do you ensure that security policies and operational procedures for protecting stored cardholder data are documented, in use, and known to all affected parties?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 185,
        //         //
        //         //     "question" => '(4.1a) Do you use strong cryptography and security protocols to safeguard sensitive cardholder data during transmission over open, public networks, including only trusted keys and certificates are accepted?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 186,
        //         //
        //         //     "question" => '(4.1b) Do you use strong cryptography and security protocols to safeguard sensitive cardholder data during transmission over open, public networks, including the protocol in use only supports secure versions or configurations?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 187,
        //         //
        //         //     "question" => '(4.1c) Do you use strong cryptography and security protocols to safeguard sensitive cardholder data during transmission over open, public networks, including encryption strength that is appropriate for the encryption methodology in use?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 188,
        //         //
        //         //     "question" => '(4.1.1) Have you ensured wireless networks transmitting cardholder data or connected to the cardholder data environment, used industry best practices to implement strong encryption for authentication and transmission?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 189,
        //         //
        //         //     "question" => '(4.2) Do you send unprotected PANs by end-user messaging technologies?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 190,
        //         //
        //         //     "question" => '(4.3) Have you ensured that security policies and operational procedures for encrypting transmissions of cardholder data are documented, in use, and known to all affected parties?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 191,
        //         //
        //         //     "question" => '(5.1) Have you deployed anti-virus software on all systems commonly affected by malicious software? (Particularly personal computers and servers.)',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 192,
        //         //
        //         //     "question" => '(5.1.1) Have you ensured that anti-virus programs are capable of detecting, removing, and protecting against all known types of malicious software?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 193,
        //         //
        //         //     "question" => '(5.1.2) Do you periodically reevaluate systems considered to not be commonly affected by malicious software in order to confirm whether such systems continue to not require anti-virus software?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 194,
        //         //
        //         //     "question" => '(5.2a) Do you ensure all anti-virus mechanisms are kept current?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 195,
        //         //
        //         //     "question" => '(5.2b) Do you ensure all anti-virus mechanisms perform periodic scans?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 196,
        //         //
        //         //     "question" => '(5.2c) Do you ensure that all anti-virus mechanisms generate audit logs which are retained per PCI DSS requirement 10.7?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 197,
        //         //
        //         //     "question" => '(5.3) Have you ensured that anti-virus mechanisms are actively running and cannot be disabled or altered by users, unless specifically authorized by management on a case-by-case basis for a limited time period?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 198,
        //         //
        //         //     "question" => '(5.4) Have you ensured that security policies and operational procedures for protecting systems against malware are documented, in use, and known to all affected parties? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 199,
        //         //
        //         //     "question" => '(6.1) Have you established a process to identify security vulnerabilities, using reputable outside sources for security vulnerability information, and as assign a risk ranking to newly discovered security vulnerabilities?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 200,
        //         //
        //         //     "question" => '(6.2) Have you ensured that all system components and software are protected from known vulnerabilities by installing applicable vendor-supplied security patches within one month of release?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 201,
        //         //
        //         //     "question" => '(6.3a) Have you developed internal and external software applications (including web-based administrative access to applications) securely in accordance with PCI DSS? (for example, secure authentication and logging)',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 202,
        //         //
        //         //     "question" => '(6.3b) Have you developed internal and external software applications (including web-based administrative access to applications based on industry standards and/or best practices?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 203,
        //         //
        //         //     "question" => '(6.3c) Have you developed internal and external software applications (including web-based administrative access to applications incorporating information security throughout the software-development life cycle?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 204,
        //         //
        //         //     "question" => '(6.3.1) Do you remove development, test and/or custom application accounts, user IDs, and passwords before applications become active or are released to customers?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 205,
        //         //
        //         //     "question" => '(6.3.2a) Do you review custom code prior to release to production or customers in order to identify any potential coding vulnerability (using either manual or automated processes) to include code changes are reviewed by individuals other than the originating code author, and by individuals knowledgeable about code-review techniques and secure coding practices?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 206,
        //         //
        //         //     "question" => '(6.3.2b) Do you review custom code prior to release to production or customers in order to identify any potential coding vulnerability (using either manual or automated processes) to include code reviews to ensure code is developed according to secure coding guidelines?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 207,
        //         //
        //         //     "question" => '(6.3.2c) Do you review custom code prior to release to production or customers in order to identify any potential coding vulnerability (using either manual or automated processes) to include appropriate corrections are implemented prior to release?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 208,
        //         //
        //         //     "question" => '(6.3.2d) Do you review custom code prior to release to production or customers in order to identify any potential coding vulnerability (using either manual or automated processes) to include code-review results are reviewed and approved by management prior to release?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 209,
        //         //
        //         //     "question" => '(6.4) Do you follow change control processes and procedures for all changes to system components?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 210,
        //         //
        //         //     "question" => '(6.4.1) Do you separate development/test environments from production environments, and enforce the separation with access controls?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 211,
        //         //
        //         //     "question" => '(6.4.2) Do you have separation of duties between development/test and production environments?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 212,
        //         //
        //         //     "question" => '(6.4.3) Is production data being used for testing and development?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 213,
        //         //
        //         //     "question" => '(6.4.4) Do you ensure removal of test data and accounts from system components before the system becomes active / goes into production? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 214,
        //         //
        //         //     "question" => '(6.4.5.1) Do your change control procedures document impact? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 215,
        //         //
        //         //     "question" => '(6.4.5.2) Do your change control procedures document change approval by authorized parties?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 216,
        //         //
        //         //     "question" => '(6.4.5.3) Do your change control procedures functionally test to verify that the change does not adversely impact the security of the system?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 217,
        //         //
        //         //     "question" => '(6.4.5.4) Do your change control procedures contain back-out procedures?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 218,
        //         //
        //         //     "question" => '(6.4.6) Upon completion of a significant change, do you reevaluate all relevant PCI DSS requirements and re-implement the requirements of PCI DSS in all new or changed systems and networks, and documentation updated as applicable?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 219,
        //         //
        //         //     "question" => '(6.5) Do you address common coding vulnerabilities in software-development processes by training developers at least annually in up-to-date secure coding techniques, including how to avoid common coding vulnerabilities?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 220,
        //         //
        //         //     "question" => '(6.5.1) Have you developed software-development policies and procedures to prevent injection flaws, particularly SQL injection as well as OS Command injection, LDAP and Xpath injection flaws as well as other injection flaws?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 221,
        //         //
        //         //     "question" => '(6.5.2) Do you have software-development policies and procedures to prevent the use of buffer overflows by validating buffer boundaries and truncating input strings?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 222,
        //         //
        //         //     "question" => '(6.5.3) Do you have software-development policies and procedures to prevent insecure cryptographic storage?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 223,
        //         //
        //         //     "question" => '(6.5.4) Do you have software-development policies and procedures to prevent the occurrence of insecure communications?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 224,
        //         //
        //         //     "question" => '(6.5.5) Do you have software-development policies and procedures to prevent improper error handling?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 225,
        //         //
        //         //     "question" => '(6.5.6) Are all \"high risk\" vulnerabilities identified in the vulnerability identification process (as defined in PCI DSS Requirement 6.1)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 226,
        //         //
        //         //     "question" => '(6.5.7) Do you have software-development policies and procedures to prevent cross-site scripting (XSS)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 227,
        //         //
        //         //     "question" => '(6.5.8) Do you have software-development policies and procedures to prevent improper access control (such as insecure direct object references, failure to restrict URL access, directory traversal, and failure to restrict user access to functions)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 228,
        //         //
        //         //     "question" => '(6.5.9) Do you have software-development policies and procedures to prevent cross-site request forgery (CSRF)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 229,
        //         //
        //         //     "question" => '(6.5.10) Do you have software-development policies and procedures to prevent the use of broken authentication and session management?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 230,
        //         //
        //         //     "question" => '(6.6) For public-facing web applications, does your organization address new threats and vulnerabilities on an ongoing basis and ensure these applications are protected against known attacks by either reviewing public-facing web applications via manual or automated application vulnerability security assessment tools or methods, at least annually and after any change or by installing an automated technical solution that detects and prevents web-based attacks (for example, a web-application firewall) in front of public facing web applications, to continually check all traffic?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 231,
        //         //
        //         //     "question" => '(6.7) Do you ensure that security policies and operational procedures for developing and maintaining secure systems and applications are documented, in use, and known to all affected parties?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 232,
        //         //
        //         //     "question" => '(7.1) Do you limit access to system components and cardholder data to only those individuals whose job requires such access?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 233,
        //         //
        //         //     "question" => '(7.1.1) Have you defined access needs for each role, including: System components and data resources that each role needs to access for their job function, Level of privilege required (for example, user, administrator, etc.) for accessing resources?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 234,
        //         //
        //         //     "question" => '(7.1.2) Do you restrict access to privileged user IDs to least privileges necessary to perform job responsibility?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 235,
        //         //
        //         //     "question" => '(7.1.3) Do you assign access based on individual personnel',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 236,
        //         //
        //         //     "question" => '(7.1.4) Do you require documented approval by authorized parties specifying required privileges?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 237,
        //         //
        //         //     "question" => '(7.2) Have you established an access control system(s) for systems components that restricts access based on a user\'s need to know, and is set to ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 238,
        //         //
        //         //     "question" => '(7.2.1) Does your access control system(s) include coverage of all system components?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 239,
        //         //
        //         //     "question" => '(7.2.2) Does your access control system(s) include assignment of privileges to individuals based on job classification and function?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 240,
        //         //
        //         //     "question" => '(7.2.3) Does your access control system(s) include a default \"deny-all\" setting?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 241,
        //         //
        //         //     "question" => '(7.3) Do you ensure that security policies and operational procedures for restricting access to cardholder data are documented, in use, and known to all affected parties?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 242,
        //         //
        //         //     "question" => '(8.1.1) Have you defined and implemented policies and procedures to ensure proper user identification management for non-consumer users and administrators on all system components by assigning all users a unique ID before allowing them to access system components or cardholder data?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 243,
        //         //
        //         //     "question" => '(8.1.2) Have you defined and implemented policies and procedures to ensure proper user identification management for non-consumer users and administrators on all system components by control addition, deletion, and modification of user IDs, credentials, and other identifier objects?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 244,
        //         //
        //         //     "question" => '(8.1.3) Have you defined and implemented policies and procedures to ensure proper user identification management for non-consumer users and administrators on all system components by immediately revoking access for any terminated users?(',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 245,
        //         //
        //         //     "question" => '(8.1.4) Do you remove/disable inactive user accounts within 90 days?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 246,
        //         //
        //         //     "question" => '(8.1.5) Do you manage IDs used by third parties to access, support, or maintain system components via remote access by enabling only during the time period needed and disabled when not in use and by monitoring when in use?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 247,
        //         //
        //         //     "question" => '(8.1.6) Do you limit repeated access attempts by locking out the user ID after not more than six attempts?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 248,
        //         //
        //         //     "question" => '(8.1.7) Have you set the lockout duration to a minimum of 30 minutes or until an administrator enables the user ID?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 249,
        //         //
        //         //     "question" => '(8.1.8) If a session has been idle for more than 15 minutes, do you require the user to re-authenticate to re-activate the terminal or session?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 250,
        //         //
        //         //     "question" => '(8.2) Do you in addition to assigning a unique ID, ensure proper user-authentication management for non-consumer users and administrators on all system components by employing at least one of the following method to authenticate all users? 1) Something you know, such as a password or passphrase, 2) Something you have, such as a token device or smart card, 3) Something you are, such as a biometric.',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 251,
        //         //
        //         //     "question" => '(8.2.1) Do you use strong cryptography to render all authentication credentials (such as passwords/phrases) unreadable during transmission and storage on all system components?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 252,
        //         //
        //         //     "question" => '(8.2.2) Do you verify user identity before modifying any authentication credential, for example, performing password resets, provisioning new tokens, or generating new keys?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 253,
        //         //
        //         //     "question" => '(8.2.3) Do your passwords/passphrases meet the following requirements, do passwords require a minimum length of at least seven characters and contain both numeric and alphabetic characters?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 254,
        //         //
        //         //     "question" => '(8.2.4) Do you require users to change passwords/passphrases at least once every 90 days?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 255,
        //         //
        //         //     "question" => '(8.2.5) Do you disallow an individual to submit a new password/passphrase that is the same as any of the last four passwords/passphrases he or she has used?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 256,
        //         //
        //         //     "question" => '(8.2.6) Do you set passwords/passphrases for first-time use and upon reset to a unique value for each user, and change immediately after the first use?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 257,
        //         //
        //         //     "question" => '(8.3) Do you secure all individual non-console administrative access and all remote access to the CDE using multi-factor authentication?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 258,
        //         //
        //         //     "question" => '(8.3.1) Do you incorporate multi-factor authentication for all non-console access into the CDE for personnel with administrative access?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 259,
        //         //
        //         //     "question" => '(8.3.2) Do you incorporate multi-factor authentication for all remote network access (both user and administrator, and including third-party access for support or maintenance) originating from outside the entity',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 260,
        //         //
        //         //     "question" => '(8.4a) Do you document and communicate authentication policies and procedures to all users including guidance on selecting strong authentication credentials?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 261,
        //         //
        //         //     "question" => '(8.4b) Do you document and communicate authentication policies and procedures to all users including guidance for how users should protect their authentication credentials?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 262,
        //         //
        //         //     "question" => '(8.4c) Do you document and communicate authentication policies and procedures to all users including instructions not to reuse previously used passwords?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 263,
        //         //
        //         //     "question" => '(8.4d) Do you document and communicate authentication policies and procedures to all users including instruction to change passwords if there is any suspicion  the password could be compromised?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 264,
        //         //
        //         //     "question" => '(8.5) Do you prevent the use of group, shared, or generic IDs, passwords, or other authentication methods by use of the following policies and procedures: Generic user IDs are disabled or removed, shared user IDs do not exist for system administration and other critical functions, Shared and generic user IDs are not used to administer any system components?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 265,
        //         //
        //         //     "question" => '(8.5.1) Additional requirement for service providers only: As a service provider when using remote access to customer premises (for example, for support of POS systems or servers) do you use a unique authentication credential (such as a password/phrase) for each customer?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 266,
        //         //
        //         //     "question" => '(8.6a) When using other authentication mechanisms (for example, physical or logical security tokens, smart cards, certificates, etc.)do you assign authentication mechanisms to an individual account and not share among multiple accounts?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 267,
        //         //
        //         //     "question" => '(8.6b) When using other authentication mechanisms (for example, physical or logical security tokens, smart cards, certificates, etc.) do you ensure physical and/or logical controls must be in place to require that only the intended account can use that mechanism to gain access?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 268,
        //         //
        //         //     "question" => '(8.7a) Do you ensure all access to any database containing cardholder data (including access by administrators, applications, and all other users) is restricted so that all user access to, user queries of, and user actions on databases are through programmatic methods?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 269,
        //         //
        //         //     "question" => '(8.7b) Do you ensure all access to any database containing cardholder data is restricted to only database administrators having the ability to directly access or query databases?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 270,
        //         //
        //         //     "question" => '(8.7c) Do you ensure all access to any database containing cardholder data uses application IDs for database applications that can only be used by the database application?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 271,
        //         //
        //         //     "question" => '(8.8) Do you ensure that security policies and operational procedures for identification and authentication are documented, in use, and known to all affected parties?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 272,
        //         //
        //         //     "question" => '(9.1) Do you use appropriate facility entry controls to limit and monitor physical access to systems in the cardholder data environment?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 273,
        //         //
        //         //     "question" => '(9.1.1) Do you use either video cameras or access control mechanisms (or both) to monitor individual physical access to sensitive areas and review collected data to correlate with other entries and store this data for at least three months, unless otherwise restricted by law?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 274,
        //         //
        //         //     "question" => '(9.1.2) Do you restrict physical access to wireless access points, gateways, handheld devices, networking/communications hardware, and telecommunication lines?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 275,
        //         //
        //         //     "question" => '(9.2a) Do you have procedures to easily distinguish between onsite personnel and visitors by identifying onsite personnel and visitors visibly (for example, assigning badges)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 276,
        //         //
        //         //     "question" => '(9.2b) Do you have procedures to easily distinguish between onsite personnel and visitors to include the use of changes to access requirements?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 277,
        //         //
        //         //     "question" => '(9.2c) Do you have procedures to easily distinguish between onsite personnel and visitors to include revoking or terminating onsite personnel and expired visitor identification (such as ID badges)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 278,
        //         //
        //         //     "question" => '(9.3a) Do you control physical access for onsite personnel to sensitive areas by ensuring access must be authorized and based on individual job function?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 279,
        //         //
        //         //     "question" => '(9.3b) Do you control physical access for onsite personnel to sensitive areas by ensuring access is revoked immediately upon termination, and all physical access mechanisms, such as keys, access cards, etc., are returned or disabled?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 280,
        //         //
        //         //     "question" => '(9.4.1) Are visitors authorized before entering, and escorted at all times within, areas where cardholder data is processed and maintained?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 281,
        //         //
        //         //     "question" => '(9.4.2) Are visitors identified and given a badge or other identification that expires and that visibly distinguished the visitors from onsite personnel?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 282,
        //         //
        //         //     "question" => '(9.4.3) Are visitors asked to surrender the badge or other identification before leaving the facility or at the date of expiration?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 283,
        //         //
        //         //     "question" => '(9.4.4) Do you make use of a visitor log to maintain a physical audit trail of visitor activity to the facility as well as computer rooms and data centers where cardholder data is stored or transmitted by documenting the visitor',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 284,
        //         //
        //         //     "question" => '(9.5) Do you physically secure all media?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 285,
        //         //
        //         //     "question" => '(9.5.1) Do you store media backups in a secure location, preferably an offsite facility, such as an alternate or backup site, or a commercial storage facility and review the location',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 286,
        //         //
        //         //     "question" => '(9.6.1) Do you maintain strict control over the internal or external distribution of any kind of media as well as classify media so the sensitivity of the data can be determined?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 287,
        //         //
        //         //     "question" => '(9.6.2) Do you send media only by secured courier or other delivery method that can be accurately tracked?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 288,
        //         //
        //         //     "question" => '(9.6.3) Do you ensure management approves any and all media that is moved from a secured area (including when media is distributed to individuals)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 289,
        //         //
        //         //     "question" => '(9.7) Do you maintain strict control over the storage and accessibility of media?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 290,
        //         //
        //         //     "question" => '(9.7.1) Do you properly maintain inventory logs of all media and conduct media inventories at least annually?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 291,
        //         //
        //         //     "question" => '(9.8.1) Do you destroy physical media when it is no longer needed for business or legal reasons by shredding, incinerating, or reducing to pulp hard copy materials so that cardholder data cannot be reconstructed and use secure storage containers for materials that are to be destroyed?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 292,
        //         //
        //         //     "question" => '(9.8.2) Do you render cardholder data on electronic media unrecoverable so that cardholder data cannot be reconstructed?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 293,
        //         //
        //         //     "question" => '(9.9) Do you protect devices that capture payment card data via direct physical interaction with the card from tampering and substitution?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 294,
        //         //
        //         //     "question" => '(9.9.1) Do you maintain and up-to-date list of devices including make, model of device, location of device, and device serial number or other method of unique identification?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 295,
        //         //
        //         //     "question" => '(9.9.2) Do you periodically inspect device surfaces to detect tampering (for example, addition of card skimmers to devices), or substitution (for example, by checking the serial number or other device characteristics to verify it has not been swapped with a fraudulent device)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 296,
        //         //
        //         //     "question" => '(9.9.3a) Do you provide training for personnel to be aware of attempted tampering or replacement of devices to include verification of the identity of any third-party persons claiming to be repair or maintenance personnel, prior to granting them access to modify or troubleshoot devices?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 297,
        //         //
        //         //     "question" => '(9.9.3b) Do you provide training for personnel to be aware of attempted tampering or replacement of devices to include the denial of installation, replacement, and return of devices without verification?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 298,
        //         //
        //         //     "question" => '(9.9.3c) Do you provide training for personnel to be aware of attempted tampering or replacement of devices to include teaching awareness of suspicious behavior around devices (for example, attempts by unknown persons to unplug or open devices.)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 299,
        //         //
        //         //     "question" => '(9.9.3d) Do you provide training for personnel to be aware of attempted tampering or replacement of devices to include instruction to report suspicious behavior and indications of device tampering or substitution to appropriate personnel (for example, to a manager or security officer.)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 300,
        //         //
        //         //     "question" => '(9.10) Do you ensure that security policies and operational procedures for restricting physical access to cardholder data are documented, in use, and known to all affected parties?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 301,
        //         //
        //         //     "question" => '(10.1) Have you implemented audit trails to link all access to system components to each individual user?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 302,
        //         //
        //         //     "question" => '(10.2.1) Have you implemented automated audit trails for all system components to reconstruct all individual user accesses to cardholder data?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 303,
        //         //
        //         //     "question" => '(10.2.2) Have you implemented automated audit trails for all system components to reconstruct all actions taken by any individual with root or administrative privileges?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 304,
        //         //
        //         //     "question" => '(10.2.3) Have you implemented automated audit trails for all system components to reconstruct access to all audit trails?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 305,
        //         //
        //         //     "question" => '(10.2.4) Have you implemented automated audit trails for all system components to reconstruct all invalid logical access attempts?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 306,
        //         //
        //         //     "question" => '(10.2.5) Have you implemented automated audit trails for all system components to reconstruct use of and changes to identification and authentication mechanisms-including but not limited to creation of new accounts and elevation of privileges-and all changes, additions, or deletions to accounts with root or administrative privileges?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 307,
        //         //
        //         //     "question" => '(10.2.6) Have you implemented automated audit trails for all system components to reconstruct initialization, stopping, or pausing of the audit logs?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 308,
        //         //
        //         //     "question" => '(10.2.7) Have you implemented automated audit trails for all system components to reconstruct creation and deletion of system-level objects?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 309,
        //         //
        //         //     "question" => '(10.3.1) Do you record audit trail entries for all system components for user identification?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 310,
        //         //
        //         //     "question" => '(10.3.2) Do you record audit trail entries for all system components and record each type of event?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 311,
        //         //
        //         //     "question" => '(10.3.3) Do you record audit trail entries for all system components and record the data and time of occurrence?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 312,
        //         //
        //         //     "question" => '(10.3.4) Do you record audit trail entries for all system components and record the success or failure of each operation?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 313,
        //         //
        //         //     "question" => '(10.3.5) Do you record audit trail entries for all system components and record the origination of event?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 314,
        //         //
        //         //     "question" => '(10.3.6) Do you record audit trail entries for all system components and record the identity or name of affected data, system component, or resource?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 315,
        //         //
        //         //     "question" => '(10.4.1) Using time-synchronization technology, do you synchronize all critical system clocks and times and ensure that critical systems have the correct and consistent time?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 316,
        //         //
        //         //     "question" => '(10.4.2) Using time-synchronization technology, do you synchronize all critical system clocks and times and ensure time data is protected?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 317,
        //         //
        //         //     "question" => '(10.4.3) Using time-synchronization technology, do you synchronize all critical system clocks and times and ensure time settings are received from industry-accepted time sources?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 318,
        //         //
        //         //     "question" => '(10.5) Do you secure audit trails so they cannot be altered?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 319,
        //         //
        //         //     "question" => '(10.5.1) Do you limit viewing of audit trails to those with a job-related need?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 320,
        //         //
        //         //     "question" => '(10.5.2) Do you protect audit trail files from unauthorized modifications?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 321,
        //         //
        //         //     "question" => '(10.5.3) Do you promptly back up audit trail files to a centralized log server or media that is difficult to alter?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 322,
        //         //
        //         //     "question" => '(10.5.4) Do you write logs for external-facing technologies onto a secure, centralized, internal log server or media device?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 323,
        //         //
        //         //     "question" => '(10.5.5) Do you use file-integrity monitoring or change-detection software on logs to ensure that existing log data cannot be changed without generating alerts (although new data being added should not cause an alert)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 324,
        //         //
        //         //     "question" => '(10.6) Do you review logs and security events for all system components to identify anomalies or suspicious activity?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 325,
        //         //
        //         //     "question" => '(10.6.1) Do you review all security events, logs of all system components that store, process, or transmit CHD and/or SAD, logs of all critical system components, and logs of all servers and system components that perform security functions at least daily?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 326,
        //         //
        //         //     "question" => '(10.6.2) Do you review logs of all other system components periodically based on the organization',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 327,
        //         //
        //         //     "question" => '(10.6.3) Do you follow up exceptions and anomalies identified during the review process?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 328,
        //         //
        //         //     "question" => '(10.7) Do you retain audit trail history for at least one year, with a minimum of three months immediately available for analysis (for example, online, archived, or restorable from backup)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 329,
        //         //
        //         //     "question" => '(10.8) Additional requirement for service providers only: Have you implemented a process for the timely detection and reporting of failures of critical security control systems, including but not limited to failure of firewalls, IDS/IPS, FIM, anti-virus, physical access controls, logical access controls, audit logging mechanisms, and segmentation controls?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 330,
        //         //
        //         //     "question" => '(10.8.1a) Additional requirement for service providers only: Do you respond to failures of any critical security controls in a timely manner, with processes for responding to failures including restoring security functions?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 331,
        //         //
        //         //     "question" => '(10.8.1b) Additional requirement for service providers only: Do you respond to failures of any critical security controls in a timely manner, with processes for responding to failures including identifying and documenting the duration (date and time start to end)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 332,
        //         //
        //         //     "question" => '(10.8.1c) Additional requirement for service providers only: Do you respond to failures of any critical security controls in a timely manner, with processes for responding to failures including identifying and documenting cause(s) of failure, including root cause, and documenting remediation required to address the root cause?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 333,
        //         //
        //         //     "question" => '(10.8.1d) Additional requirement for service providers only: Do you respond to failures of any critical security controls in a timely manner, with processes for responding to failures including identifying and addressing any security issues that arose during the failure?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 334,
        //         //
        //         //     "question" => '(10.8.1e) Additional requirement for service providers only: Do you respond to failures of any critical security controls in a timely manner, with processes for responding to failures including performing a risk assessment to determine whether further actions are required as a result of the security failure?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 335,
        //         //
        //         //     "question" => '(10.8.1f) Additional requirement for service providers only: Do you respond to failures of any critical security controls in a timely manner, with processes for responding to failures including implementing controls to prevent the cause of failure from reoccurring?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 336,
        //         //
        //         //     "question" => '(10.8.1g) Additional requirement for service providers only: Do you respond to failures of any critical security controls in a timely manner, with processes for responding to failures including resuming monitoring of security of controls?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 337,
        //         //
        //         //     "question" => '(10.9) Do you ensure that security policies and operation procedures for monitoring all access to network resources and cardholder data are documented, in use, and known to all affected parties?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 338,
        //         //
        //         //     "question" => '(11.1) Do you implement processes to test for the presence of wireless access points (802.11), and detect and identify all authorized and unauthorized wireless access points on a quarterly basis?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 339,
        //         //
        //         //     "question" => '(11.1.1) Do you maintain an inventory of authorized wireless access points including a documented business justification?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 340,
        //         //
        //         //     "question" => '(11.1.2) Have you implemented incident response procedures in the event unauthorized wireless access points are detected?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 341,
        //         //
        //         //     "question" => '(11.2) Do you run internal and external network vulnerability scans at least quarterly and after any significant changes in the network (such as new system component installations, changes in network topology, firewall rule modifications, product upgrades)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 342,
        //         //
        //         //     "question" => '(11.2.1) Do you perform quarterly internal vulnerability scans and address vulnerabilities and perform rescans to verify that all ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 343,
        //         //
        //         //     "question" => '(11.2.2) Do you perform quarterly external vulnerability scans, via an Approved Scanning Vendor (ASV) approved by the Payment Card Industry Security Standards Council (PCI SSC) and perform rescans as needed, until passing scans are achieved?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 344,
        //         //
        //         //     "question" => '(11.2.3) Do you perform internal and external scans, and rescans as needed, after any significant change and all scans are performed by qualified personnel?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 345,
        //         //
        //         //     "question" => '(11.3a) Have you implemented a methodology for penetration testing that is based on industry-accepted penetration testing approaches (for example, NIST SP800-155)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 346,
        //         //
        //         //     "question" => '(11.3b) Have you implemented a methodology for penetration testing that includes coverage for the entire CDE perimeter and critical systems?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 347,
        //         //
        //         //     "question" => '(11.3c) Have you implemented a methodology for penetration testing that includes testing from both inside and outside the network?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 348,
        //         //
        //         //     "question" => '(11.3d) Have you implemented a methodology for penetration testing that includes testing to validate any segmentation and scope-reduction controls?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 349,
        //         //
        //         //     "question" => '(11.3e) Have you implemented a methodology for penetration testing that defines application-layer penetration tests include, at a minimum, the vulnerabilities listed in requirement 6.5?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 350,
        //         //
        //         //     "question" => '(11.3f) Have you implemented a methodology for penetration testing that defines network-layer penetration tests to include components that support network functions as well as operating systems?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 351,
        //         //
        //         //     "question" => '(11.3g) Have you implemented a methodology for penetration testing that includes review and consideration of threats and vulnerabilities experienced in the last 12 months?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 352,
        //         //
        //         //     "question" => '(11.3h) Have you implemented a methodology for penetration testing that specifies retention of penetration testing results and remediation activities results?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 353,
        //         //
        //         //     "question" => '(11.3.1) Do you perform external penetration testing at least annually and after any significant infrastructure or application upgrade or modification (such as an operating system upgrade, a sub-network added to the environment, or a web server added to the environment)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 354,
        //         //
        //         //     "question" => '(11.3.2) Do you perform internal penetration testing at least annually and after any significant infrastructure or application upgrade or modification (such as an operating system upgrade, a sub-network added to the environment, or a web server added to the environment)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 355,
        //         //
        //         //     "question" => '(11.3.3) Are exploitable vulnerabilities found during penetration testing corrected and testing repeated to verify the corrections?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 356,
        //         //
        //         //     "question" => '(11.3.4) If segmentation is used to isolate the CDE from other networks, do you perform penetration tests at least annually and after any changes to segmentation controls/methods to verify that the segmentation methods are operational and effective, and isolate all out-of-scope systems from systems in the CDE?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 357,
        //         //
        //         //     "question" => '(11.3.4.1) Additional requirement for service providers only: If segmentation is used, have you confirmed PCI DSS scope by performing penetration testing on segmentation controls at least every six months and after any changes to segmentation controls/methods?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 358,
        //         //
        //         //     "question" => '(11.4a) Do you use intrusion-detection and/or intrusion-prevention techniques to detect and/or prevent intrusion into the network and monitor all traffic at the perimeter of the cardholder data environment as well as at critical points in the cardholder data environment, and alert personnel to suspected compromises?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 359,
        //         //
        //         //     "question" => '(11.5b) Do you keep all intrusion-detection and prevention engine, baselines, and signatures up to date?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 360,
        //         //
        //         //     "question" => '(11.5) Have you deployed a change-detection mechanism (for example, file-integrity monitoring tools) to alert personnel to unauthorized modifications (including changes, additions, and deletions) of critical system files, configuration files, or content files; and configure the software to perform critical file comparisons at least weekly?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 361,
        //         //
        //         //     "question" => '(11.5.1) Have you implemented a process to respond to any alerts generated by the change-detection solution?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 362,
        //         //
        //         //     "question" => '(11.6) Do you ensure that security policies and operational procedures for security monitoring and testing are documented, in use, and known to all affected parties?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 363,
        //         //
        //         //     "question" => '(12.1) Have you established, published, maintained, and disseminated a security policy?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 364,
        //         //
        //         //     "question" => '(12.1.1) Do you review the security policy at least annually and update the police when the environment changes?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 365,
        //         //
        //         //     "question" => '(12.2a) Have you implemented a risk-assessment process that is performed at least annually and upon significant changes to the environment (for example, acquisition, merger, relocation, etc.)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 366,
        //         //
        //         //     "question" => '(12.2b) Have you implemented a risk-assessment process that identifies critical assets, threats, and vulnerabilities?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 367,
        //         //
        //         //     "question" => '(12.2c) Have you implemented a risk-assessment process that results in a formal, documented analysis of risk?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 368,
        //         //
        //         //     "question" => '(12.3) Do you develop usage policies for critical technologies and define proper use of these technologies?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 369,
        //         //
        //         //     "question" => '(12.3.1) Do your usage policies require explicit approval by authorized parties for the use of these technologies?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 370,
        //         //
        //         //     "question" => '(12.3.2) Do your usage policies require authentication for the use of the technology?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 371,
        //         //
        //         //     "question" => '(12.3.3) Do your usage policies require a list of all such devices and personnel with access is recorded and up to date?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 372,
        //         //
        //         //     "question" => '(12.3.4) Do you have a method to accurately and readily determine owner, contact information, and purpose of all critical technology users (for example, labeling, coding, and/or inventorying of devices)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 373,
        //         //
        //         //     "question" => '(12.3.5) Do your usage policies define acceptable uses of the technology?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 374,
        //         //
        //         //     "question" => '(12.3.6) Do your usage policies define acceptable network locations for the technologies?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 375,
        //         //
        //         //     "question" => '(12.3.7) Do your usage policies define the use and maintenance of a list of company-approved products?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 376,
        //         //
        //         //     "question" => '(12.3.8) Do your usage policies require automatic disconnecting of sessions through remote-access technologies after a specific period of inactivity?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 377,
        //         //
        //         //     "question" => '(12.3.9) Do your usage policies define the requirement for activation of remote-access technologies for vendors and business partners is to be used only when needed by vendors and business partners, with immediate deactivation after use?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 378,
        //         //
        //         //     "question" => '(12.3.10a) For personnel accessing cardholder data via remote-access technologies, Do you prohibit the copying, moving, and storage of cardholder data onto local hard drives and removable electronic media, unless explicitly authorized for a defined business need?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 379,
        //         //
        //         //     "question" => '(12.3.10b) Where there is an authorized business need, do the usage policies require the data be protected in accordance with all applicable PCI DSS requirements?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 380,
        //         //
        //         //     "question" => '(12.4) Do you ensure that the security policy and procedures clearly define information security responsibilities for all personnel?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 381,
        //         //
        //         //     "question" => '(12.4.1a) Additional requirement for service providers only: Does executive management establish responsibility for the for the protection of cardholder data and a PCI DSS compliance program to include overall accountability for maintaining PCI DSS compliance? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 382,
        //         //
        //         //     "question" => '(12.4.1b) Additional requirement for service providers only: Does executive management establish responsibility for the for the protection of cardholder data and a PCI DSS compliance program to include definition of a charter for a PCI DSS compliance program and communication to executive management? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 383,
        //         //
        //         //     "question" => '(12.5.1) Have you assigned an individual or team to the responsibility of establishing, documenting, and distributing security policies and procedures?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 384,
        //         //
        //         //     "question" => '(12.5.2) Have you assigned an individual or team to the responsibility of monitoring and analyzing security alerts and information, and distributing that information to the appropriate personnel?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 385,
        //         //
        //         //     "question" => '(12.5.3) Have you assigned an individual or team to the responsibility of establishing, documenting, and distributing security incident response and escalation procedures to ensure timely and effective handling of all situations?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 386,
        //         //
        //         //     "question" => '(12.5.4) Have you assigned an individual or team to the responsibility of administration of user accounts, including additions, deletions, and modifications?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 387,
        //         //
        //         //     "question" => '(12.5.5) Have you assigned an individual or team to the responsibility of monitoring and controlling all access to data?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 388,
        //         //
        //         //     "question" => '(12.6) Have you implemented a formal security awareness program to make all personnel aware of the cardholder data security policy and procedures?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 389,
        //         //
        //         //     "question" => '(12.6.1) Do you educate personnel upon hire and at least annually thereafter?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 390,
        //         //
        //         //     "question" => '(12.6.2) Do you require personnel to acknowledge at least annually that they have read and understood the security policy and procedures?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 391,
        //         //
        //         //     "question" => '(12.7) Do you screen potential personnel prior to hire to minimize the risk of attacks from internal sources (for example, background checks, previous employment history, criminal record, credit history, and reference checks)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 392,
        //         //
        //         //     "question" => '(12.8) Do you maintain and implement policies and procedures to manage service providers with whom cardholder data is shared, or that could affect the security of cardholder data, and maintain a list of service providers?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 393,
        //         //
        //         //     "question" => '(12.8.1) Do you maintain a list of service providers including a description of the service provided?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 394,
        //         //
        //         //     "question" => '(12.8.2) Do you maintain a written agreement with service providers that includes an acknowledgement that the service providers are responsible for the security of cardholder data the service providers possess or otherwise store, process or transmit on behalf of the customer, or to the extent that they could impact the security of the customer',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 395,
        //         //
        //         //     "question" => '(12.8.3) Do you ensure there is an established process for engaging service providers including proper due diligence prior to engagement?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 396,
        //         //
        //         //     "question" => '(12.8.4) Do you maintain a program to monitor service providers',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 397,
        //         //
        //         //     "question" => '(12.8.5) Do you maintain information about which PCI DSS requirements are managed by each service provider, and which are managed by the entity?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 398,
        //         //
        //         //     "question" => '(12.9) Additional requirement for service providers only: Do you acknowledge in writing to customers that you as a service provider are responsible for the security of cardholder data the service provider possesses or otherwise stores, processes, or transmits on behalf of the customer, or to the extent that they could impact the security of the customer',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 399,
        //         //
        //         //     "question" => '(12.10) Have you implemented an incident response plan and are prepared to respond immediately to a system breach?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 400,
        //         //
        //         //     "question" => '(12.10.1a) Have you created an incident response plan to be initiated in the event of system breach?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 401,
        //         //
        //         //     "question" => '(12.10.1b) Does your incident response plan address roles, responsibilities, and communication and contact strategies in the event of a compromise including notification of the payment brands, at a minimum?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 402,
        //         //
        //         //     "question" => '(12.10.1c) Does your incident response plan address specific incident response procedures?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 403,
        //         //
        //         //     "question" => '(12.10.1d) Does your incident response plan address business recovery and continuity procedures?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 404,
        //         //
        //         //     "question" => '(12.10.1e) Does your incident response plan address data backup processes?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 405,
        //         //
        //         //     "question" => '(12.10.1f) Does your incident response plan address analysis of legal requirements for reporting compromises?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 406,
        //         //
        //         //     "question" => '(12.10.1g) Does your incident response plan address coverage and responses of all critical system components?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 407,
        //         //
        //         //     "question" => '(12.10.1h) Does your incident response plan have reference to or inclusion of incident response procedures from the payment brands?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 408,
        //         //
        //         //     "question" => '(12.10.2) Do you review and test the plan, including all elements listed in requirement 12.10.1, at least annually?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 409,
        //         //
        //         //     "question" => '(12.10.3) Do you designate specific personnel to be available on a 24/7 basis to respond to alerts?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 410,
        //         //
        //         //     "question" => '(12.10.4) Do you provide appropriate training to staff with security breach response responsibilities?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 411,
        //         //
        //         //     "question" => '(12.10.5) Do you include alerts from security monitoring systems, including but not limited to intrusion-detection, intrusion-prevention, firewalls, and file-integrity monitoring systems?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 412,
        //         //
        //         //     "question" => '(12.10.6) Do you develop a process to modify and evolve the incident response plan according to lessons learned and to incorporate industry developments?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 413,
        //         //
        //         //     "question" => '(12.11a) Additional requirement for service providers only: Do you perform reviews at least quarterly to confirm personnel are following security policies and operational procedures?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 414,
        //         //
        //         //     "question" => '(12.11b) Additional requirement for service providers only: Do your reviews cover daily log reviews?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 415,
        //         //
        //         //     "question" => '(12.11c) Additional requirement for service providers only: Do you review firewall rule-set reviews?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 416,
        //         //
        //         //     "question" => '(12.11d) Additional requirement for service providers only: Do you review applying configuration standards to new systems?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 417,
        //         //
        //         //     "question" => '(12.11e) Additional requirement for service providers only: Do you review responses to security alerts?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 418,
        //         //
        //         //     "question" => '(12.11f) Additional requirement for service providers only: Do you review change management processes?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 419,
        //         //
        //         //     "question" => '(12.11.1) Additional requirement for service providers only: Do you maintain documentation of quarterly review processes to include documenting results of the reviews as well as review and sign-off of results by personnel assigned responsibility for the PCI DSS compliance program?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 420,
        //         //
        //         //     "question" => '§164.502(a) (5)(i) Does the health plan use or disclose for underwriting purposes, \"Genetic Information\" as defined at § 160.103, including family history?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 421,
        //         //
        //         //     "question" => '§164.502(f) Do the covered entity‚Äôs policies and procedures protect the deceased individual\'s PHI consistent with the established performance criterion?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 422,
        //         //
        //         //     "question" => '§164.502(g) Do the policies and procedures provide for the treatment of an authorized person as a personal representative? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 423,
        //         //
        //         //     "question" => '§164.502(h) Does the entity provide for and accommodate requests by individuals for confidential communications? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 424,
        //         //
        //         //     "question" => '§164.502(i) Are uses and disclosures made by the covered entity consistent with its notice of privacy practices? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 425,
        //         //
        //         //     "question" => ' §164.502(j) (1) Are whistleblower policies and procedures consistent with the requirements of this performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 426,
        //         //
        //         //     "question" => '§164.502(j) (2) Has the covered entity ensured that disclosures by a workforce member related to his or her status as a victim of a crime are consistent with the rule established in the criterion?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 427,
        //         //
        //         //     "question" => '§164.504(e) Does the covered entity enter into business associate contracts as required and do these contracts contain all required elements?\n ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 428,
        //         //
        //         //     "question" => '§164.504(f) Do group health plan documents restrict the use and disclosure of PHI to the plan sponsor? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 429,
        //         //
        //         //     "question" => '§164.504(g) For entities that perform multiple covered functions, are uses and disclosures of PHI only for the purpose related to the appropriate functions being performed? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 430,
        //         //
        //         //     "question" => '§164.506(a) Do policies and procedures exist for the use or disclosure of PHI for treatment, payment, or health care operations? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 431,
        //         //
        //         //     "question" => '§164.506(b); (b)(1); and (b)(2) Does the entity obtain the individual\'s consent for uses and disclosures? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 432,
        //         //
        //         //     "question" => '§164.508(a) (1-3) and §164.508(b) (1-2) Do policies and procedures exist to determine when authorization is required?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 433,
        //         //
        //         //     "question" => '§164.508(b) (3) Does the covered entity use or disclose PHI for the purpose of research, conducts research, provides psychotherapy services, and uses compound authorizations? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 434,
        //         //
        //         //     "question" => '§164.508(b) (4) Does the covered entity condition treatment, payment, enrollment, or eligibility on receipt of an authorization and if so, does one of the limited exceptions apply? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 435,
        //         //
        //         //     "question" => '§164.508(b) (6) and §164.508(c) (1-4) Does the covered entity document and retain signed, valid authorizations? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 436,
        //         //
        //         //     "question" => '§164.510(a) (1) and §164.510(a) (2) Does the entity maintain a directory of individuals in its facility?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 437,
        //         //
        //         //     "question" => '§164.510(a) (3) Do policies and procedures exist to use or disclose PHI for the facility directory in emergency circumstances? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 438,
        //         //
        //         //     "question" => '§164.510(b) (1) Do policies and procedures exist for disclosing PHI to family members, relatives, close personal friends, or other persons identified by the individual?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 439,
        //         //
        //         //     "question" => '§164.510(b) (2) Does the covered entity disclose PHI to persons involved in the individual\'s care when the individual is present and are policies and procedures in place to define the circumstances in which this can be done? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 440,
        //         //
        //         //     "question" => '§164.510(b) (3) Do policies and procedures exist for disclosing only information relevant to the person\'s involvement in the individual\'s health care when the individual is not present and in related situations? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 441,
        //         //
        //         //     "question" => '§164.510(b) (4) Do policies and procedures exist for disclosing PHI to a public or private entity authorized by law or by its charter to assist in disaster relief efforts? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 442,
        //         //
        //         //     "question" => '§164.510(b) (5) Does the covered entity disclose the PHI of deceased individuals in accordance with the established performance criterion?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 443,
        //         //
        //         //     "question" => '§164.512(a) Does the covered entity use and disclose PHI pursuant to requirements of other law and If so, are such uses and disclosures made consistent with the requirements of this performance criterion as well as the applicable requirements related to victims of abuse, neglect or domestic violence, pursuant to judicial and administrative proceedings and law enforcement purposes of this section?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 444,
        //         //
        //         //     "question" => '§164.512(b) Are policies and procedures in place that specify how the covered entity uses or disclosures PHI for public health activities consistent with this standard?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 445,
        //         //
        //         //     "question" => '§164.512(c) Does the covered entity determine whether and how to make disclosures about victims of abuse, neglect, or domestic violence consistent with this standard?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 446,
        //         //
        //         //     "question" => '§164.512(d) Is PHI used or disclosed for health oversight activities consistent with the established performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 447,
        //         //
        //         //     "question" => '§164.512(e) Do policies and procedures exist related to making disclosures in the course of any judicial or administrative proceeding to limit such disclosures to those permitted by the established performance criterion?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 448,
        //         //
        //         //     "question" => '§164.512(f) (1) Have disclosures made by the covered entity for law enforcement purposes been consistent with the performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 449,
        //         //
        //         //     "question" => '§164.512(f) (2) Are disclosures made to law enforcement for identification and location purposes by the covered entity consistent with the limitations listed in the established performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 450,
        //         //
        //         //     "question" => '§164.512(f) (3) Are policies and procedures consistent with the established performance criterion regarding the conditions in which the covered entity may disclose PHI of a possible victim of a crime in response to a law enforcement official\'s request? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 451,
        //         //
        //         //     "question" => '§164.512(f) (4) Are policies and procedures in place to determine when it is permitted to disclose PHI to law enforcement about an individual who has died as a result of suspected criminal conduct?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 452,
        //         //
        //         //     "question" => '§164.512(f) (5) Are policies and procedures in place to determine when it is permitted to disclose PHI about an individual who may have committed a crime on the premises? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 453,
        //         //
        //         //     "question" => '§164.512(f) (6) Are policies and procedures in place to determine what information about a medical emergency is necessary to disclose to alert law enforcement?  ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 454,
        //         //
        //         //     "question" => '§164.512(g) Are policies and procedures consistent with the established performance criterion for disclosing PHI to (1) a coroner or medical examiner; and (2) a funeral director? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 455,
        //         //
        //         //     "question" => '§164.512(h) Is the covered entity‚Äôs process for disclosing PHI to organ procurement organizations or other entities engaged in the procurement consistent with the established performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 456,
        //         //
        //         //     "question" => '§164.512(i) (1) Does the covered entity use or disclose PHI for research purposes in accordance with the established performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 457,
        //         //
        //         //     "question" => '§164.512(i) (2) Do policies and procedures exist to determine what documentation of approval or waiver is needed to permit a use or disclosure and to apply that determination?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 458,
        //         //
        //         //     "question" => '§164.512(k) (1) Does the covered entity disclose PHI of individuals for military and veterans activities consistent with the established performance criterion?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 459,
        //         //
        //         //     "question" => '§164.512(k) (2) Does the covered entity respond to a request for PHI from Federal officials for intelligence and other national security activities in accordance with the established performance criterion?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 460,
        //         //
        //         //     "question" => '§164.512(k) (3) Does the covered entity respond to a request for PHI from Federal officials for the provision of protective services or the conduct of certain investigations in accordance with the established performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 461,
        //         //
        //         //     "question" => '§164.512(k) (4) Is the covered entity a component of the Department of State and if so, does the covered entity have policies and procedures consistent with the established performance criterion to use and disclose PHI for the purposes described in the established performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 462,
        //         //
        //         //     "question" => '§164.512(k) (5) Does the covered entity determine whether to disclose PHI to a correctional institution or a law enforcement official with custody of an individual and are policies and procedures in place to determine whether the use or disclosure of PHI to a correctional institution or law enforcement official is permitted? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 463,
        //         //
        //         //     "question" => '§164.512(k) (6) Is the covered entity a health plan that is a government agency administering a government program providing public benefits and if so does the covered entity have policies and procedures consistent with the established performance criterion in place to disclose PHI for the purposes listed? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 464,
        //         //
        //         //     "question" => '§164.512(l) Are policies and procedures in place regarding disclosure of PHI for the purpose of workers\' compensation, that are consistent with the established performance criterion?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 465,
        //         //
        //         //     "question" => '§164.514(b) & §164.514(c) Does the covered entity de-identify PHI consistent with the established performance criterion?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 466,
        //         //
        //         //     "question" => '§164.514(d) (1)§164.514(d) (2) Has the covered entity implemented policies and procedures consistent with the requirements of the established performance criterion to identify need for and limit use of PHI?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 467,
        //         //
        //         //     "question" => '§164.514(d) (3) Are policies and procedures in place to limit the PHI disclosed to the amount reasonably necessary to achieve the purpose of the disclosure?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 468,
        //         //
        //         //     "question" => '§164.514(d) (4) Are policies and procedures in place to limit the PHI requested by the entity being audited to the amount minimally necessary to achieve the purpose of the disclosure? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 469,
        //         //
        //         //     "question" => '§164.514(d) (5) Are policies and procedures in place to address uses, disclosures, or requests for an entire medical record? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 470,
        //         //
        //         //     "question" => '§164.514(e) Are data use agreements in place between the covered entity and its limited data set recipients, if any? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 471,
        //         //
        //         //     "question" => '§164.514(f) Is the disclosure of PHI to a business associate or institutionally related foundation limited to the information set forth in the established performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 472,
        //         //
        //         //     "question" => '§164.514(g) Does the health plan have policies and procedures consistent with the established performance criterion addressing limitations on the use and disclosure of PHI received for underwriting and other purposes? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 473,
        //         //
        //         //     "question" => '§164.514(h) Are policies and procedures consistent with the established performance criterion in place to verify the identity of persons who request PHI?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 474,
        //         //
        //         //     "question" => '§164.520(a) (1) & (b)(1) Does the covered entity have a notice of privacy practice, If yes,  does the current notice contain all the required elements as seen in the established criterion?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 475,
        //         //
        //         //     "question" => '§164.520(c) (1) Does the health plan provide its notice of privacy practices consistent with the established performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 476,
        //         //
        //         //     "question" => '§164.520(c) (2) Does a covered health care provider with direct treatment relationships with individuals provide its notice of privacy practices consistent with the established performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 477,
        //         //
        //         //     "question" => '§164.520(c) (3) Does a covered entity that maintains a web site prominently post its notice?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 478,
        //         //
        //         //     "question" => '§164.520(c) (3) Does the covered entity implement policies and procedures, if any, to provide the notice electronically consistent with the standard? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 479,
        //         //
        //         //     "question" => '§164.520(d) For covered entities that participate in organized health care arrangement, does the entity use a joint notice of privacy practices and If a joint notice is utilized, does the joint notice meet the specific additional criteria for a joint notice? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 480,
        //         //
        //         //     "question" => '§164.520(e) Is the documentation of notice of privacy practices and the acknowledgement of receipt by individuals of the notice of privacy practices maintained in electronic or written form and retained for a period of 6 years?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 481,
        //         //
        //         //     "question" => '§164.522(a) (1) Does the covered entity have policies and procedures consistent with the established performance criterion to permit an individual to request that the entity restrict uses or disclosures of PHI for treatment, payment, and health care operations, and disclosures permitted pursuant to §164.510(b)? \n',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 482,
        //         //
        //         //     "question" => '§164.522(a) (2) Are policies and procedures in place to terminate restrictions on the use and/or disclosure of PHI, consistent with the established performance criterion?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 483,
        //         //
        //         //     "question" => '§164.522(a) (3) Does the covered entity, consistent with the established performance criterion, maintain documentation of restrictions in electronic or written form for a period of six years? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 484,
        //         //
        //         //     "question" => '§164.522(b) (1) Does the covered entity have policies and procedures in place to permit individuals to request alternative means or alternative locations to receive communications of PHI consistent with the established performance criterion and if so, does the covered entity have policies and procedures in place to accommodate such requests consistent with the established performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 485,
        //         //
        //         //     "question" => '§164.524(a) (1), (b)(1), (b)(2), (c)(2), (c)(3), (c)(4), (d)(1), (d)(3) Does the covered entity enable the access rights of an individual in accordance with the established criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 486,
        //         //
        //         //     "question" => '§164.524(d) (2) Has the covered entity implemented policies and procedures that ensure that an individual receives a timely, written denial that contains all mandated elements? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 487,
        //         //
        //         //     "question" => '§164.524(a) (2) Do policies and procedures exist that dictate the circumstances under which denials of requests for access are unreviewable?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 488,
        //         //
        //         //     "question" => '§164.524(a) (3) Are policies and procedures in place regarding review of denials of access? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 489,
        //         //
        //         //     "question" => '§164.524(a) (4) & (d)(4) Do policies and procedures address request for and fulfillment of review of instances of access denial?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 490,
        //         //
        //         //     "question" => '§164.524(e) Does the covered entity document the following and retain the documentation as required by §164.530(j): (1) the designated record sets that are subject to access by individuals; and (2) the titles of the persons or offices responsible for receiving and processing requests for access by individuals?\n',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 491,
        //         //
        //         //     "question" => '§164.526(a) (1) Has the covered entity implemented policies and procedures consistent with the established performance criterion regarding an individual\'s right to amend their PHI in a designated record set?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 492,
        //         //
        //         //     "question" => '§164.526(a) (2) Has the covered entity implemented policies and procedures consistent with the established performance criterion for determining grounds for denying requests? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 493,
        //         //
        //         //     "question" => '§164.526(c) Does the covered entity have policies and procedures consistent with the established performance criterion for accepting requests for amendments? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 494,
        //         //
        //         //     "question" => '§164.526(d) Has the covered entity implemented policies and procedures regarding provision of denial consistent with the established performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 495,
        //         //
        //         //     "question" => '§164.528(a) Does the covered entity have policies and procedures consistent with the established performance criterion for implementing an individual‚Äôs right to an accounting of disclosures of PHI? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 496,
        //         //
        //         //     "question" => '§164.528(b) Does the covered entity have policies and procedures consistent with the established performance criterion to provide an accounting that contains the content listed? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 497,
        //         //
        //         //     "question" => '§164.528(c) Does the covered entity have policies and procedures consistent with the established performance criterion to provide an individual with a requested accounting of PHI with in the time and fee limitations specified? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 498,
        //         //
        //         //     "question" => '§164.528(d) Does the covered entity document requests for and fulfillment of accounting of disclosures consistent with the established performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 499,
        //         //
        //         //     "question" => '§164.530(a) Has the covered entity designated a privacy official and a contact person consistent with the established performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 500,
        //         //
        //         //     "question" => '§164.530(b) Does the covered entity train its work force and have a policies and procedures to ensure all members of the workforce receive necessary and appropriate training in a timely manner as provided for by the established performance criterion? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 501,
        //         //
        //         //     "question" => '§164.530(c) Has the covered entity implemented administrative, technical, and physical safeguards to protect all PHI from any intentional or unintentional use or disclosure that is in violation of the standards, implementation specifications or other requirements of this subpart and does the covered entity reasonably safeguard protected health information to limit incidental uses or disclosures made pursuant to an otherwise permitted or required use or disclosure? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 502,
        //         //
        //         //     "question" => '§164.530(d) (1) Does the covered entity have a process for individuals to make complaints, consistent with the requirements of the established performance criterion?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 503,
        //         //
        //         //     "question" => '§164.530(d) (2) Has the covered entity documented all complaints received and their disposition consistent with the performance criteria? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 504,
        //         //
        //         //     "question" => '§164.530(e) (1) Does the covered entity apply appropriate sanctions against members of the workforce who fail to comply with the privacy policies and procedures of the entity or the Privacy Rule? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 505,
        //         //
        //         //     "question" => '§164.530(f) Does the covered entity mitigate any harmful effect that is known to the covered entity of a use or disclosure of PHI by the covered entity or its business associates, in violation of its policies and procedures?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 506,
        //         //
        //         //     "question" => '§164.530(g) Has the covered entity implemented policies and procedures addressing the prevention of intimidating or retaliatory actions against any individual for the exercise by the individual of any right established, or for participation in any process provided, for filing complaints against the covered entity? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 507,
        //         //
        //         //     "question" => '§164.530(h) Has the covered entity required individuals to waive their right to complain to the Secretary of HHS about a covered entity or business associate not complying with these Rules, as a condition of the provision of treatment, payment, enrollment in a health plan, or eligibility for benefits?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 508,
        //         //
        //         //     "question" => '§164.530(i) Has the covered entity implemented policies and procedures with respect to PHI that are designed to comply with the standards, implementation specifications, and other requirements of the HIPAA Privacy Rule? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 509,
        //         //
        //         //     "question" => '§164.530(j) Does the entity maintain all required policies and procedures, written communication, and documentation in written or electronic form and are such documentations retained for the required time period?\n ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 510,
        //         //
        //         //     "question" => '§164.306(a) Does the covered entity or business associate ensure confidentiality, integrity and availability of ePHI?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 511,
        //         //
        //         //     "question" => '§164.306(a) Does the covered entity or business associate protect against reasonably anticipated threats or hazards to the security or integrity of ePHI? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 512,
        //         //
        //         //     "question" => '§164.306(a) Does the covered entity or business associate protect against reasonably anticipated uses or disclosures of ePHI that are not permitted or required by the Privacy Rule? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 513,
        //         //
        //         //     "question" => '§164.306(a) Does the covered entity or business associate ensure compliance with Security Rule by its workforce?\n',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 514,
        //         //
        //         //     "question" => '§164.306(b) Does the covered entity comply with Security Rule accounting for Size, Technical Infrastructure, and Cost, as well as the probability of potential risks to electronic protected health information in accordance with the established criterion?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 515,
        //         //
        //         //     "question" => '§164.308(a) Does the entity have written policies and procedures in place to prevent, detect, contain and correct security violations? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 516,
        //         //
        //         //     "question" => '§164.308(a) (1)(ii)(A) Does the entity have policies and procedures in place to conduct an accurate and thorough assessment of the potential risks and vulnerabilities to the confidentiality, integrity, and availability of all the electronic protected health information (ePHI) it creates, receives, maintains, or transmits? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 517,
        //         //
        //         //     "question" => '§164.308(a) (1)(ii)(B) Does the entity have policies and procedures in place regarding a risk management process sufficient to reduce risks and vulnerabilities to a reasonable and appropriate level? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 518,
        //         //
        //         //     "question" => '§164.308(a) (1)(ii)(C) Does the entity have policies and procedures in place regarding sanctions to apply to workforce members who fail to comply with the entity\'s security policies and procedures? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 519,
        //         //
        //         //     "question" => '§164.308(a) (1)(ii)(D) Does the entity have policies and procedures in place regarding the regular review of information system activity and does the entity regularly review records of information system activity? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 520,
        //         //
        //         //     "question" => '§164.308(a) (2) Does the entity have policies and procedures in place regarding the establishment of a security official? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 521,
        //         //
        //         //     "question" => '§164.308(a) (3)(i) Does the entity have policies and procedures in place to ensure all members of its workforce have appropriate access to ePHI?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 522,
        //         //
        //         //     "question" => '§164.308(a) (3)(ii)(A) Does the entity have policies and procedures in place regarding the authorization and/or supervision of workforce members who work with ePHI or in locations where it might be accessed? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 523,
        //         //
        //         //     "question" => '§164.308(a) (3)(ii)(B) Does the entity have policies and procedures in place to determine that a workforce member‚Äôs access to ePHI is appropriate?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 524,
        //         //
        //         //     "question" => '§164.308(a) (3)(ii)(B) Does the entity determine whether a workforce member\'s access to ePHI is appropriate? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 525,
        //         //
        //         //     "question" => '§164.308(a) (3)(ii)(C) Does the entity have policies and procedures in place for terminating access to ePHI when employment or other arrangements with the workforce member ends? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 526,
        //         //
        //         //     "question" => '§164.308(a) (4)(i) Does the entity have policies and procedures in place for authorizing access to ePHI that supports the applicable requirements of the Privacy Rule and does the entity authorize access to ePHI that supports the applicable requirements of the Privacy Rule? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 527,
        //         //
        //         //     "question" => '§164.308(a) (4)(ii)(A) If the entity is a health care clearinghouse that is part of a larger organization, does the clearinghouse have policies and procedures to protect ePHI from unauthorized access by the larger organization?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 528,
        //         //
        //         //     "question" => '§164.308(a) (4)(ii)(A) Does the clearinghouse protect ePHI from unauthorized access by the larger organization? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 529,
        //         //
        //         //     "question" => '§164.308(a) (4)(ii)(B) Does the entity have policies and procedures in place to grant access to ePHI for workforce members?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 530,
        //         //
        //         //     "question" => '§164.308(a) (4)(ii)(C) Does the entity have policies and procedures in place to authorize access and document, review, and modify a user‚Äôs right of access to a workstation, transaction, program, or process as well as practice these policies and procedures?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 531,
        //         //
        //         //     "question" => '§164.308(a) (5)(i) Does the entity have policies and procedures in place regarding a security awareness and training program as well as practice these policies and procedures?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 532,
        //         //
        //         //     "question" => '§164.308(a) (5)(ii)(A) Does the entity have policies and procedures in place regarding a process to provide periodic security reminders and update?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 533,
        //         //
        //         //     "question" => '§164.308(a) (5)(ii)(A) Does the entity appropriately communicate security updates to all members of its workforce and, if appropriate, contractors periodically?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 534,
        //         //
        //         //     "question" => '§164.308(a) (5)(ii)(B) Does the entity have policies and procedures in place regarding a process to incorporate its procedures to guard against, detect, and report malicious software into its security awareness and training program?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 535,
        //         //
        //         //     "question" => '§164.308(a) (5)(ii)(C) Does the entity have policies and procedures in place regarding a process to incorporate its procedures to guard against, detect, and report malicious software into its security awareness and training program? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 536,
        //         //
        //         //     "question" => '§164.308(a) (5)(ii)(D) Does the entity have policies and procedures in place to incorporate procedures for monitoring log-in attempts and reporting discrepancies into its security awareness and training program? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 537,
        //         //
        //         //     "question" => '§164.308(a) (6)(i) Does the entity have policies and procedures in place to address security incidents? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 538,
        //         //
        //         //     "question" => '§164.308(a) (6)(ii) Does the entity have policies and procedures in place for identifying, responding to, reporting, and mitigating security incidents?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 539,
        //         //
        //         //     "question" => '§164.308(a) (7)(i) Does the entity have policies and procedures in place that include a formal contingency plan for responding to an emergency or other occurrences that damages systems that contain ePHI?\n',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 540,
        //         //
        //         //     "question" => '§164.308(a) (7)(i) Does the entity have a contingency plan for responding to an emergency or other occurrences that damages systems that contain ePHI?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 541,
        //         //
        //         //     "question" => '§164.308(a) (7)(ii)(A) Does the entity have policies and procedures in place to create and maintain retrievable exact copies of ePHI?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 542,
        //         //
        //         //     "question" => '§164.308(a) (7)(ii)(A) Does the entity create and maintain retrievable exact copies of ePHI?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 543,
        //         //
        //         //     "question" => '§164.308(a) (7)(ii)(B) Does the entity have policies and procedures in place to restore any lost data and 3does the entity restore any lost data? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 544,
        //         //
        //         //     "question" => '§164.308(a) (7)(ii)(C) Does the entity have policies and procedures in place to enable the continuity of critical business processes for the protection of ePHI while operating in emergency mode?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 545,
        //         //
        //         //     "question" => '§164.308(a) (7)(ii)(C) Does the entity enable the continuity of critical business processes for the protection of ePHI while operating in emergency mode? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 546,
        //         //
        //         //     "question" => '§164.308(a) (7)(ii)(D) Does the entity have policies and procedures for periodic testing and revisions of its contingency plans and does the entity periodically test and revise its contingency plans? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 547,
        //         //
        //         //     "question" => '§164.308(a) (7)(ii)(A) Does the entity have policies and procedures in place to assess the relative criticality of specific applications and data in support of other contingency plan components.',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 548,
        //         //
        //         //     "question" => '§164.308(a) (7)(ii)(A) Does the entity assess the relative criticality of specific application and data in support of other contingency plan components?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 549,
        //         //
        //         //     "question" => '§164.308(a) (8) Does the entity have policies and procedures in place to perform periodic technical and nontechnical evaluation, based initially upon the standards implemented under this rule and subsequently, in response to environmental or operational changes or newly recognized risk affecting the security of ePH?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 550,
        //         //
        //         //     "question" => '§164.308(a) (8) Does the entity perform periodic technical and nontechnical evaluation, based initially upon the standards implemented under this rule and subsequently, in response to environmental or operational changes or newly recognized risk affecting the security of ePHI?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 551,
        //         //
        //         //     "question" => '§164.308(b) (1) Does the entity have policies and procedures in place to obtain satisfactory assurances from its business associates (or business associate subcontractors if the entity is a business associate) and to review the satisfactory assurances to ensure the applicable requirements at § 164.314(a) are included in the business associate contract or other arrangement? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 552,
        //         //
        //         //     "question" => '§164.308(b) (3) Does the entity have policies and procedures in place to obtain satisfactory assurances from its business associates (or business associate subcontractors if entity is a business associate) and to review the satisfactory assurances to ensure the applicable requirements at § 164.314(a) is included in the written contract or other arrangement?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 553,
        //         //
        //         //     "question" => '§164.310(a) (1) Does the entity have policies and procedures in place regarding access to and use of facilities and equipment that house ePHI and does the entity limit physical access to its electronic information systems and the facility or facilities in which they are housed, while ensuring properly authorized access is allowed? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 554,
        //         //
        //         //     "question" => '§164.310(a) (2)(i) Does the entity have policies and procedures in place that allow facility access for the restoration of lost data under the Disaster Recovery Plan and Emergency Mode Operations Plan?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 555,
        //         //
        //         //     "question" => '§164.310(a) (2)(i) Does the entity allow facility access for the restoration of lost data under the Disaster Recover Plan and Emergency Mode Operation Plan in the event of an emergency?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 556,
        //         //
        //         //     "question" => '§164.310(a) (2)(ii) Does the entity have policies and procedures in place to safeguard the facility and equipment therein from unauthorized physical access, tampering, and theft?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 557,
        //         //
        //         //     "question" => '§164.310(a) (2)(ii) Does the entity safeguard the facility and equipment therein from unauthorized physical access, tampering, and theft?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 558,
        //         //
        //         //     "question" => '§164.310(a) (2)(iii) Does the entity have policies and procedures in place for controlling a person‚Äôs access to facilities based on their role or function including visitor control and control of access to software programs for testing and revision?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 559,
        //         //
        //         //     "question" => '§164.310(a) (2)(iii) Does the entity control a person\'s access to facilities based on their role or function including visitor control and control of access to software programs for testing and revision? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 560,
        //         //
        //         //     "question" => '§164.310(a) (2)(iv) Does the entity have policies and procedures in place to document repairs and modifications to the physical components of a facility which are related to security?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 561,
        //         //
        //         //     "question" => '§164.310(a) (2)(iv) Does the entity document repairs and modifications to the physical components of a facility which are related to security? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 562,
        //         //
        //         //     "question" => '§164.310(b) Does the entity have policies and procedures in place that specifies the proper functions to be performed and the physical attributes of the surroundings of a specific workstation or class of workstation that can access ePHI?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 563,
        //         //
        //         //     "question" => '§164.310(b) Does the entity specify the proper functions to be performed and the physical attributes of the surroundings of a specific workstation or class of workstation that can access ePHI?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 564,
        //         //
        //         //     "question" => '§164.310(c) Does the entity have policies and procedures that document how workstations are physically restricted to limit access to only authorized personnel?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 565,
        //         //
        //         //     "question" => '§164.310(c) Are the entity workstations that access electronic protected health information restricted to authorized users?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 566,
        //         //
        //         //     "question" => '§164.310(d) (1) Does the entity have policies and procedures in place that govern the receipt and removal of hardware and electronic media that contain ePHI, into and out of a facility, and the movement of these items within the facility?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 567,
        //         //
        //         //     "question" => '§164.310(d) (1) Does the entity govern the receipt and removal of hardware and electronic media that contain ePHI, into and out of a facility, and the movement of these items within facility? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 568,
        //         //
        //         //     "question" => '§164.310(d) (2)(i) Does the entity have policies and procedures that address the disposal ePHI data, hardware or electronic media on which it is stored?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 569,
        //         //
        //         //     "question" => '§164.310(d) (2)(i) Does the entity address the disposal ePHI data, hardware or electronic media on which it is stored? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 570,
        //         //
        //         //     "question" => '§164.310(d) (2)(ii) Does the entity have policies and procedures established to remove ePHI before reusing electronic media?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 571,
        //         //
        //         //     "question" => '§164.310(d) (2)(ii) Does the entity have policies and procedures established to record who is responsible for the overseeing these ePHI removal processes?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 572,
        //         //
        //         //     "question" => '§164.310(d) (2)(ii) Does the entity remove ePHI before reusing electronic media?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 573,
        //         //
        //         //     "question" => '§164.310(d) (2)(ii) Does the entity record who is responsible for the overseeing those processes? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 574,
        //         //
        //         //     "question" => '§164.310(d) (2)(iii) Does the entity have policies and procedures to record the movements of hardware and electronic media and any person responsible therefore?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 575,
        //         //
        //         //     "question" => '§164.310(d) (2)(iii) does the entity record the movements of hardware and electronic media and any person responsible therefore?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 576,
        //         //
        //         //     "question" => '§164.310(d) (2)(iv) Does the entity have policies and procedures in place to create a retrievable, exact copy of ePHI when needed, before movement of equipment?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 577,
        //         //
        //         //     "question" => '§164.310(d) (2)(iv) Does the entity create a retrievable, exact copy of ePHI when needed, before movement of equipment? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 578,
        //         //
        //         //     "question" => '§164.312(a) (1) Has the entity implemented technical policies and procedure for the electronic information systems that maintain ePHI to allow access only to authorized users?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 579,
        //         //
        //         //     "question" => '§164.312(a) (1) Does the entity only allow access to those persons or software programs that have been granted access rights as specified in § 164.308(a)(4) to electronic information systems that maintain electronic protected health information?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 580,
        //         //
        //         //     "question" => '§164.312(a) (2)(i) Does the entity have polices and procedures regarding the assignment of unique user IDs to track user identity?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 581,
        //         //
        //         //     "question" => '§164.312(a) (2)(i) Does the entity assign unique user IDs to track user identity? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 582,
        //         //
        //         //     "question" => '§164.312(a) (2)(ii) Does the entity have polices and procedures in place to provide access to ePHI during an emergency and does the entity provide access to ePHI during an emergency? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 583,
        //         //
        //         //     "question" => '§164.312(a) (2)(ii) Does the entity provide access to ePHI during an emergency? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 584,
        //         //
        //         //     "question" => '§164.312(a) (2)(iii) Does the entity have policies and procedures in place to automatically terminates an electronic session after a predetermined time of inactivity?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 585,
        //         //
        //         //     "question" => '§164.312(a) (2)(iii) Does the entity automatically terminates an electronic session after a predetermined time of inactivity?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 586,
        //         //
        //         //     "question" => '§164.312(a) (2)(iv) Does the entity have policies and procedures in place to encrypt and decrypt ePHI including processes regarding the use and management of the confidential process or key used to encrypt and decrypt ePHI?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 587,
        //         //
        //         //     "question" => '§164.312(a) (2)(iv) Does the entity encrypt and decrypt ePHI including processes regarding the use and management of the confidential process or key used to encrypt and decrypt ePHI? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 588,
        //         //
        //         //     "question" => '§164.312(b) Does the entity have policies and procedures in place to implement hardware, software and/or procedural mechanisms to record and examine activity in information systems that contain or use ePHI?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 589,
        //         //
        //         //     "question" => '§164.312(b) Does the entity have hardware, software and/or procedural mechanism to record and examine activity in information systems that contain or use ePHI?  ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 590,
        //         //
        //         //     "question" => '§164.312(c) (1) Does the entity have policies and procedures in place to protect ePHI from improper alteration or destruction?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 591,
        //         //
        //         //     "question" => '§164.312(c) (1) Does the entity protect ePHI form improper alteration or destruction?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 592,
        //         //
        //         //     "question" => '§164.312(c) (2) Does the entity have policies and procedures in place regarding the implementation of electronic mechanisms to corroborate that ePHI has not been altered or destroyed in an unauthorized manner?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 593,
        //         //
        //         //     "question" => '§164.312(c) (2) Does the entity have electronic mechanism to corroborate that ePHI has not been altered or destroyed in an unauthorized manner? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 594,
        //         //
        //         //     "question" => '§164.312(d) Does the entity have policies and procedures in place to verify that a person or entity seeking access to ePHI is the one claimed?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 595,
        //         //
        //         //     "question" => '§164.312(d) Does the entity verify that a person or entity seeking access to ePHI is the one claimed? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 596,
        //         //
        //         //     "question" => '§164.312(e) (1) Does the entity have policies and procedures in place to implement technical security controls to guard against unauthorized access to ePHI transmitted over electronic communications networks?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 597,
        //         //
        //         //     "question" => '§164.312(e) (1) Does the entity have security controls to guard against unauthorized access to ePHI transmitted over electronic communications networks?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 598,
        //         //
        //         //     "question" => '§164.312(e) (2)(i) Does the entity have policies and procedures in place to implement security measures to ensure that electronically transmitted ePHI cannot be improperly modified without detection until disposed of?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 599,
        //         //
        //         //     "question" => '§164.312(e) (2)(ii) Does the entity have policies and procedures in place to implement an encryption mechanism to encrypt ePHI whenever deemed appropriate?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 600,
        //         //
        //         //     "question" => '§164.312(e) (2)(ii) Does the entity have encryption mechanism to encrypt ePHI whenever deemed necessary?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 601,
        //         //
        //         //     "question" => '§164.314(a) (1) Does the entity have policies and procedures in place regarding its contractual arrangements with contractors or other entities to which it discloses ePHI for use on its behalf? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 602,
        //         //
        //         //     "question" => '§164.314(a) (2)(i)(A) Does the entity have policies and procedures in place regarding the content of its business associate contracts to ensure that its business associates will comply with applicable requirements of Subpart C of 45 CFR Part 164?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 603,
        //         //
        //         //     "question" => '§164.314(a) (2)(i)(B) Does the entity have policies and procedures in place requiring that its business associate contracts or other arrangements require that subcontractors that create, receive, maintain or transmit ePHI on behalf of its business associates agree to comply with the applicable parts of Subpart C of 45 CFR Part 164 by entering into a business associate contract or other arrangement that complies with 45 CFR § 164.314(a)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 604,
        //         //
        //         //     "question" => '§164.314(a) (2)(i)(C) Does the entity have policies and procedures in place regarding the content of its business associate contracts to ensure that its business associates will report any security incident of which it becomes aware, including breaches of unsecured PHI, as required by 45 CFR § 164.410? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 605,
        //         //
        //         //     "question" => '§164.314(a) (2)(ii) Does the entity have policies and procedures in place regarding other arrangements to have in place (e.g., a Memorandum of Understanding if the covered entity and business associate are government agencies) that meet the requirements of 45 CFR § 164.504(e)(3)? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 606,
        //         //
        //         //     "question" => '§164.314(a) (2)(iii) Does the entity have policies and procedures in place regarding business associate contracts or other arrangements with its subcontractors such that the requirements of 45 CFR § 164.314(a)(2) (i)-(ii) would apply to the business associate and its subcontractors in the same manner as such requirements apply to a covered entity and its business associates? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 607,
        //         //
        //         //     "question" => '§164.314(b) (1) Does the group health plan have policies and procedures in place to ensure that its plan documents provide that the plan sponsor will reasonably and appropriately safeguard ePHI created, received, maintained or transmitted to or by the plan sponsor on behalf of the group health plan?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 608,
        //         //
        //         //     "question" => '§164.314(b) (2)(i) Do the plan documents of the group health plan include language that requires the sponsor to implement administrative, physical, and technical safeguards that reasonably and appropriately protect the confidentiality, integrity, and availability of the ePHI that it creates, receives, maintains, or transmits on behalf of the group health plan? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 609,
        //         //
        //         //     "question" => '§164.314(b) (2)(ii) Do the plan documents of the group health plan incorporate provisions to ensure that adequate separation required by 45 CFR § 164.504(f)(2) (iii) is supported by reasonable and appropriate security measures? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 610,
        //         //
        //         //     "question" => '§164.314(b) (2)(iii) Do the plan documents of the group health plan incorporate provisions to include language that requires the sponsors to ensure that any agent to whom it provides this information agrees to implement reasonable and appropriate security measures to protect the information?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 611,
        //         //
        //         //     "question" => '§164.314(b) (2)(iv) Do the plan documents of the group health plan incorporate provisions to include language that requires plan sponsors to report to the group health plan any security incident of which it becomes aware? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 612,
        //         //
        //         //     "question" => '§164.316(a) Does the entity have policies and procedures in place to implement reasonable and appropriate policies and procedures to comply with the standards, implementation specification or other requirements of the Security Rule? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 613,
        //         //
        //         //     "question" => '§164.316(b) (1) Does the entity have policies and procedures to maintain written policies and procedures related to the security rule and written documents of (if any) actions, activities, or assessments required of the security rule? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 614,
        //         //
        //         //     "question" => '§164.316(b) (2) (i) Does the entity have policies and procedures in place regarding the retention of required documentation for six (6) years from the date of its creation or the date when it last was in effect? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 615,
        //         //
        //         //     "question" => '§164.316(b) (2) (ii) Does the entity have policies and procedures in place requiring that documentation be made available to the workforce members responsible for implementing applicable Security Rule policies and procedures?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 616,
        //         //
        //         //     "question" => '§164.316(b) (2) (iii) Does the entity have policies and procedures in place to perform periodic reviews and updates to Security Rule policies and procedures?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 617,
        //         //
        //         //     "question" => '§164.414(a) Has the covered entity adequately implemented the required 164.530 provisions as they relate to the Breach Notification Rule?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 618,
        //         //
        //         //     "question" => '§164.530(b) Has the covered entity trained its workforce on the applicable provisions established in the audit criterion?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 619,
        //         //
        //         //     "question" => '§164.530(d) Does the covered entity have a process in place for individuals to complain about its compliance with the Breach Notification Rule? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 620,
        //         //
        //         //     "question" => '§164.530(e) Has the covered entity sanctioned any workforce members for failing to comply with its policies and procedures as they relate to the Breach Notification Rule?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 621,
        //         //
        //         //     "question" => '§164.530(g) Does the covered entity have appropriate policies and procedures in place to prohibit retaliation against any individual for exercising a right or participating in a process (e.g., assisting in an investigation by HHS or other appropriate authority or for filing a complaint) or for opposing an act or practice that the person believes in good faith violates the Breach Notification Rule? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 622,
        //         //
        //         //     "question" => '§164.530(h) Does the covered entity have appropriate policies and procedures in place to prohibit it from requiring an individual to waive any right under the Breach Notification Rule as a condition of the provision of treatment, payment, enrollment in a health plan, or eligibility for benefits? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 623,
        //         //
        //         //     "question" => '§164.530(i) Does the covered entity have policies and procedures that are consistent with the requirements of the Breach Notification Rule?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 624,
        //         //
        //         //     "question" => '§164.530(j) Does the covered entity have policies and procedures for maintaining documentation consistent with the requirements at §164.530(j)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 625,
        //         //
        //         //     "question" => '§164.402 Does the covered entity have policies and procedures for determining whether an impermissible use or disclosure requires notifications under the Breach Notification Rule? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 626,
        //         //
        //         //     "question" => '§164.402 Does the covered entity have a process for conducting a breach risk assessment when an impermissible use or disclosure of PHI is discovered, to determine whether there is a low probability that PHI has been compromised?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 627,
        //         //
        //         //     "question" => '§164.402 If not, does the covered entity have a policy and procedure that requires notification without conducting a risk assessment for all or specific types of incidents that result in impermissible uses or disclosures of PHI?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 628,
        //         //
        //         //     "question" => '§164.402 Did the covered entity or business associate determine that an acquisition, access, use or disclosure of protected health information in violation of the Privacy Rule did not require notifications under §§164.404-164.410 within the specified period?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 629,
        //         //
        //         //     "question" => '§164.402 If yes, did the covered entity or business associate determine that one of the regulatory exceptions to the definition of breach at §164.402(1) apply?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 630,
        //         //
        //         //     "question" => '§164.402 If yes, did the covered entity or business associate determine that the breach did not require notification, under §§164.404-410, because the PHI was not unsecured PHI, i.e., it was rendered unusable, unreadable, or indecipherable to unauthorized persons through the use of a technology or methodology specified in the applicable guidance?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 631,
        //         //
        //         //     "question" => '§164.404(a) Does the covered entity have policies and procedures for notifying individuals of a breach of their protected health information?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 632,
        //         //
        //         //     "question" => '§164.404(b) Are individuals notified of breaches within the required time period in accordance with the established criterion?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 633,
        //         //
        //         //     "question" => '§164.404(c) (1) Does the covered entity have policies and procedures for providing individuals with notifications that meet the content requirements of §164.404(c)?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 634,
        //         //
        //         //     "question" => '§164.404(d) Does the covered entity have policies and procedures for notifying an individual, an individual\'s next of kin, or a personal representative of a breach? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 635,
        //         //
        //         //     "question" => '§164.406 Does the covered entity have policies and procedures for notifying media outlets of breaches affecting more than 500 residents of a State or jurisdiction? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 636,
        //         //
        //         //     "question" => '§164.408 Does the covered entity have policies and procedures for notifying the Secretary of breaches involving 500 or more individuals? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 637,
        //         //
        //         //     "question" => '§164.410 Did the business associate or subcontractor determine that there were any breaches of unsecured PHI within the specified period? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 638,
        //         //
        //         //     "question" => '§164.412 Does the covered entity or business associate have policies and procedures regarding how the covered entity or business associate would respond to a law enforcement statement that a notice or posting would impede a criminal investigation or damage national security?',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 639,
        //         //
        //         //     "question" => '§164.412 Has the covered entity or business associate delayed notification of a breach of unsecured PHI pursuant to such a law enforcement statement? ',
        //         //     "order" => 999999
        //         // ]);
        //         // Question::create([
        //         //     "id" => 640,
        //         //
        //         //     "question" => '§164.414(b) Does the covered entity or business associate, as applicable, have policies and procedures in place to accept the burden of demonstrating that all notifications were made as required by the subpart or that the use or disclosure did not constitute a breach as defined at §164.402?',
        //         //     "order" => 999999
        //         // ]);
    }
}
