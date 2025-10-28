<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Framework;
use Faker\Factory as Faker;

class FrameworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // NCA-ECC – 1: 2018
        if (in_array('NCA-ECC – 1: 2018', SEEDING_FRAMEWORKS)) {
            $framework = Framework::create([
                'name' => 'NCA-ECC – 1: 2018',
                'description' => 'The National Cybersecurity Authority “NCA” has developed the Essential Cybersecurity Controls (ECC – 1: 2018) to set the minimum cybersecurity requirements based on best practices and standards to minimize the cybersecurity risks to the information and technical assets of organizations that originate from internal and external threats. The Essential Cybersecurity Controls consist of 114 main controls, divided into five main domains.',
                'icon' => 'fa-universal-access',
                'status' => '1',
            ]);

            $domains = [
                // Domain id
                1, 2, 3, 4, 5
            ];

            $framework->families()->attach($domains); // attach domains to framework

            $subDomains = [24, 25, 26, 27, 28, 29, 30, 31, 32, 33];

            $framework->families()->attach($subDomains, ['parent_family_id' => 1]); // attach sub-domains to framework

            $subDomains = [34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48];

            $framework->families()->attach($subDomains, ['parent_family_id' => 2]); // attach sub-domains to framework

            $subDomains = [49];

            $framework->families()->attach($subDomains, ['parent_family_id' => 3]); // attach sub-domains to framework

            $subDomains = [50, 51];

            $framework->families()->attach($subDomains, ['parent_family_id' => 4]); // attach sub-domains to framework

            $subDomains = [52];

            $framework->families()->attach($subDomains, ['parent_family_id' => 5]); // attach sub-domains to frameworku
        }

        // NCA-SMACC
        if (in_array('NCA-SMACC', SEEDING_FRAMEWORKS)) {
            $framework = Framework::create([
                'name' => 'NCA-SMACC',
                'description' => "Based on the objectives of the National Cybersecurity Authority (NCA) strategy and in continuation of its role in regulating and protecting the Kingdom's cyberspace, NCA has issued the Organizations’ Social Media Accounts Cybersecurity Controls document. These controls were developed after reviewing many international cybersecurity standards, frameworks, controls and international practices in cybersecurity.",
                'icon' => 'fa-whatsapp',
                'status' => '1',
            ]);

            $domains = [
                // Domain id
                1, 2, 4
            ];

            $framework->families()->attach($domains); // attach domains to framework

            $subDomains = [26, 28, 32, 33];

            $framework->families()->attach($subDomains, ['parent_family_id' => 1]); // attach sub-domains to framework

            $subDomains = [34, 35, 36, 39, 40, 45, 46];

            $framework->families()->attach($subDomains, ['parent_family_id' => 2]); // attach sub-domains to framework

            $subDomains = [50];

            $framework->families()->attach($subDomains, ['parent_family_id' => 4]); // attach sub-domains to framework
        }

        // NCA-CCC – 1: 2020
        if (in_array('NCA-CCC – 1: 2020', SEEDING_FRAMEWORKS)) {
            $framework = Framework::create([
                'name' => 'NCA-CCC – 1: 2020',
                'description' => "The National Cybersecurity Authority “NCA” has developed the Cloud Cybersecurity Controls (CCC – 1: 2020) as an extension and a complement to Essential Cybersecurity Controls (ECC – 1: 2018). The CCC aims to set cybersecurity requirements for cloud computing from the perspective of Cloud Service Providers (CSPs) and Cloud Service Tenants (CSTs); to meet the security needs and raise the CSPs’ and the CSTs’ preparedness towards reducing cybersecurity risks on all cloud computing services. The Cloud Cybersecurity Controls consist of 37 main controls and 96 subcontrols for CSPs, and 18 main controls and 26 subcontrols for CSTs, divided into four main domains.",
                'icon' => 'fa-warning',
                'status' => '1',
            ]);

            $domains = [
                // Domain id
                1, 2, 3, 4
            ];

            $framework->families()->attach($domains); // attach domains to framework

            $subDomains = [27, 28, 30, 32, 120];

            $framework->families()->attach($subDomains, ['parent_family_id' => 1]); // attach sub-domains to framework

            $subDomains = [34, 35, 36, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 121, 123, 124];

            $framework->families()->attach($subDomains, ['parent_family_id' => 2]); // attach sub-domains to framework

            $subDomains = [49];

            $framework->families()->attach($subDomains, ['parent_family_id' => 3]); // attach sub-domains to framework

            $subDomains = [50];

            $framework->families()->attach($subDomains, ['parent_family_id' => 4]); // attach sub-domains to framework
        }

        // NCA-TCC
        if (in_array('NCA-TCC', SEEDING_FRAMEWORKS)) {
            $framework = Framework::create([
                'name' => 'NCA-TCC',
                'description' => "Based on the objectives of the National Cybersecurity Authority (NCA) strategy and in continuation of its role in regulating and protecting the Kingdom's cyberspace, NCA has issued the Telework Cybersecurity Controls (TCC) document. These controls were developed after reviewing many international cybersecurity standards, frameworks, controls and international practices in cybersecurity. The document aims to contribute to raising the level of cybersecurity at the national level by enabling the organization to perform its work remotely in a secure manner and adapt to the changes in the business environment and telework systems, and enhancing the organization’s cybersecurity capabilities and resilience against cyber threats when providing remote work. These controls are an extension to the Essential Cybersecurity Controls (ECC).",
                'icon' => 'fa-user-times',
                'status' => '1',
            ]);

            $domains = [
                // Domain id
                1, 2, 4
            ];

            $framework->families()->attach($domains); // attach domains to framework

            $subDomains = [26, 28, 33];

            $framework->families()->attach($subDomains, ['parent_family_id' => 1]); // attach sub-domains to framework

            $subDomains = [34, 35, 36, 38, 39, 40, 41, 42, 43, 44, 45, 46];

            $framework->families()->attach($subDomains, ['parent_family_id' => 2]); // attach sub-domains to framework

            $subDomains = [51];

            $framework->families()->attach($subDomains, ['parent_family_id' => 4]); // attach sub-domains to framework
        }

        // NCA-CSCC – 1: 2019
        if (in_array('NCA-CSCC – 1: 2019', SEEDING_FRAMEWORKS)) {
            $framework = Framework::create([
                'name' => 'NCA-CSCC – 1: 2019',
                'description' => "The National Cybersecurity Authority “NCA” has developed the Critical Systems Cybersecurity Controls (CSCC – 1: 2019), as an extension and a complement to the Essential Cybersecurity Controls (ECC), to fit the cybersecurity needs for national critical systems. The Critical Systems Cybersecurity Controls consist of 32 main controls and 73 subcontrols, divided into four main domains.",
                'icon' => 'fa-lock',
                'status' => '1',
            ]);

            $domains = [
                // Domain id
                1, 2, 3, 4
            ];

            $framework->families()->attach($domains); // attach domains to framework

            $subDomains = [24, 28, 29, 31, 32];

            $framework->families()->attach($subDomains, ['parent_family_id' => 1]); // attach sub-domains to framework

            $subDomains = [34, 35, 36, 38, 39, 40, 41, 42, 43, 44, 45, 48, 122];

            $framework->families()->attach($subDomains, ['parent_family_id' => 2]); // attach sub-domains to framework

            $subDomains = [49];

            $framework->families()->attach($subDomains, ['parent_family_id' => 3]); // attach sub-domains to framework

            $subDomains = [50, 51];

            $framework->families()->attach($subDomains, ['parent_family_id' => 4]); // attach sub-domains to framework
        }

        // NCA-OTCC-1:2022
        if (in_array('NCA-OTCC-1:2022', SEEDING_FRAMEWORKS)) {
            $framework = Framework::create([
                'name' => 'NCA-OTCC-1:2022',
                'description' => "In continuation of its role in regulating and protecting the Kingdom's cyberspace, and in line with the Kingdom’s Vision 2030, NCA publishes the Operational Technology Cybersecurity Controls (OTCC-1:2022). These controls are aligned with related international cybersecurity standards, frameworks, controls, and best practices.
    
                The controls aim to raise the cybersecurity level of OT systems in the Kingdom by setting the minimum cybersecurity requirements for organizations to protect their Industrial Control systems (ICS) from cyber threats that could result in negative impacts. These controls are an extension to the NCA’s Essential Cybersecurity Controls (ECC).",
                'icon' => 'fa-upload',
                'status' => '1',
            ]);

            $domains = [
                // Domain id
                1, 2, 3, 4
            ];

            $framework->families()->attach($domains); // attach domains to framework

            $subDomains = [26, 27, 28, 29, 31, 32, 33, 120];

            $framework->families()->attach($subDomains, ['parent_family_id' => 1]); // attach sub-domains to framework

            $subDomains = [34, 35, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 125];

            $framework->families()->attach($subDomains, ['parent_family_id' => 2]); // attach sub-domains to framework

            $subDomains = [49];

            $framework->families()->attach($subDomains, ['parent_family_id' => 3]); // attach sub-domains to framework

            $subDomains = [50];

            $framework->families()->attach($subDomains, ['parent_family_id' => 4]); // attach sub-domains to framework
        }

        // NCA-DCC-1:2022
        if (in_array('NCA-DCC-1:2022', SEEDING_FRAMEWORKS)) {
            $framework = Framework::create([
                'name' => 'NCA-DCC-1:2022',
                'description' => "In continuation of its role in regulating and protecting the Kingdom's cyberspace, NCA has issued the Data Cybersecurity Controls (DCC-1:2022). These controls have been developed after conducting a comprehensive study of multiple national and international cybersecurity standards, frameworks and controls, studying related laws and regulations, reviewing cybersecurity best practices and analyzing cybersecurity risks, threats, previous incidents and attacks at the national level.",
                'icon' => 'fa-usb',
                'status' => '1',
            ]);

            $domains = [
                // Domain id
                1, 2, 4
            ];

            $framework->families()->attach($domains); // attach domains to framework

            $subDomains = [31, 32, 33];

            $framework->families()->attach($subDomains, ['parent_family_id' => 1]); // attach sub-domains to framework

            $subDomains = [35, 36, 39, 40, 41, 126, 127];

            $framework->families()->attach($subDomains, ['parent_family_id' => 2]); // attach sub-domains to framework

            $subDomains = [50];

            $framework->families()->attach($subDomains, ['parent_family_id' => 4]); // attach sub-domains to framework
        }

        // SAMA
        if (in_array('SAMA', SEEDING_FRAMEWORKS)) {
            $framework = Framework::create([
                'name' => 'SAMA',
                'description' => "SAMA established a Cyber Security Framework (“the Framework”) to enable Financial Institutions regulated by SAMA (“the Member Organizations”) to effectively identify and address risks related to cyber security. To maintain the protection of information assets and online services, the Member Organizations must adopt the Framework.",
                'icon' => 'fa-eye',
                'status' => '1',
            ]);

            $domains = [
                // Domain id
                6, 7, 8, 9
            ];

            $framework->families()->attach($domains); // attach domains to framework

            $subDomains = [53, 54, 55, 56, 57, 58, 59];

            $framework->families()->attach($subDomains, ['parent_family_id' => 6]); // attach sub-domains to framework

            $subDomains = [60, 61, 62, 63, 64];

            $framework->families()->attach($subDomains, ['parent_family_id' => 7]); // attach sub-domains to framework

            $subDomains = [65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81];

            $framework->families()->attach($subDomains, ['parent_family_id' => 8]); // attach sub-domains to framework

            $subDomains = [82, 83, 84];

            $framework->families()->attach($subDomains, ['parent_family_id' => 9]); // attach sub-domains to framework
        }

        // ISO-27001
        if (in_array('ISO-27001', SEEDING_FRAMEWORKS)) {
            $framework = Framework::create([
                'name' => 'ISO-27001',
                'description' => "ISO/IEC 27001 is is the world’s best-known standard for information security management systems (ISMS) and their requirements. Additional best practice in data protection and cyber resilience are covered by more than a dozen standards in the ISO/IEC 27000 family. Together, they enable organizations of all sectors and sizes to manage the security of assets such as financial information, intellectual property, employee data and information entrusted by third parties.",
                'icon' => 'fa-user-circle',
                'status' => '1',
            ]);

            $domains = [
                // Domain id
                10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23
            ];

            $framework->families()->attach($domains); // attach domains to framework

            $subDomains = [85];

            $framework->families()->attach($subDomains, ['parent_family_id' => 10]); // attach sub-domains to framework

            $subDomains = [86, 87];

            $framework->families()->attach($subDomains, ['parent_family_id' => 11]); // attach sub-domains to framework

            $subDomains = [88, 89, 90];

            $framework->families()->attach($subDomains, ['parent_family_id' => 12]); // attach sub-domains to framework

            $subDomains = [91, 92, 93];

            $framework->families()->attach($subDomains, ['parent_family_id' => 13]); // attach sub-domains to framework

            $subDomains = [94, 95, 96, 97];

            $framework->families()->attach($subDomains, ['parent_family_id' => 14]); // attach sub-domains to framework

            $subDomains = [98];

            $framework->families()->attach($subDomains, ['parent_family_id' => 15]); // attach sub-domains to framework

            $subDomains = [99, 100];

            $framework->families()->attach($subDomains, ['parent_family_id' => 16]); // attach sub-domains to framework

            $subDomains = [101, 102, 103, 104, 105, 106, 107];

            $framework->families()->attach($subDomains, ['parent_family_id' => 17]); // attach sub-domains to framework

            $subDomains = [108, 109];

            $framework->families()->attach($subDomains, ['parent_family_id' => 18]); // attach sub-domains to framework

            $subDomains = [110, 111, 112];

            $framework->families()->attach($subDomains, ['parent_family_id' => 19]); // attach sub-domains to framework

            $subDomains = [113, 114];

            $framework->families()->attach($subDomains, ['parent_family_id' => 20]); // attach sub-domains to framework

            $subDomains = [115];

            $framework->families()->attach($subDomains, ['parent_family_id' => 21]); // attach sub-domains to framework

            $subDomains = [116, 117];

            $framework->families()->attach($subDomains, ['parent_family_id' => 22]); // attach sub-domains to framework

            $subDomains = [118, 119];

            $framework->families()->attach($subDomains, ['parent_family_id' => 23]); // attach sub-domains to framework
        }
    }
}
