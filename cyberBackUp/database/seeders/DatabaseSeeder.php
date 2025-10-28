<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


/* SEEDING_MODE
    1. production
    2. development
*/

define('SEEDING_MODE', 'development');
define('SEEDING_FRAMEWORKS', [
    'NCA-ECC – 1: 2018',
    'NCA-SMACC',
    'NCA-CCC – 1: 2020',
    'NCA-TCC',
    'NCA-CSCC – 1: 2019',
    'NCA-OTCC-1:2022',
    'NCA-DCC-1:2022',
    'SAMA',
    'ISO-27001'
]);

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(TruncateAllTables::class);

        /* Start Main data */
        // $this->call(AppendAndPermissionAndAction::class);
        $this->call(ServiceDescriptionSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(ImpactSeeder::class);
        $this->call(LikelihoodSeeder::class);
        $this->call(ScoringMethodSeeder::class);
        $this->call(CloseReasonSeeder::class);
        $this->call(SourceSeeder::class);
        $this->call(MitigationEffortSeeder::class);
        $this->call(PlanningStrategySeeder::class);
        $this->call(ControlClassSeeder::class);
        $this->call(ControlPhaseSeeder::class);
        $this->call(DataClassificationSeeder::class);
        $this->call(DocumentStatusSeeder::class);
        // $this->call(FamilySeeder::class);
        $this->call(ControlMaturitySeeder::class);
        $this->call(ControlPrioritySeeder::class);
        $this->call(ControlDesiredMaturitySeeder::class);
        // $this->call(LanguageSeeder::class);
        $this->call(ControlTypeSeeder::class);
        $this->call(NextStepSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(ReviewLevelSeeder::class);
        $this->call(RiskFunctionSeeder::class);
        $this->call(RiskGroupingSeeder::class);
        $this->call(RiskCatalogSeeder::class);
        $this->call(RiskLevelSeeder::class);
        $this->call(RiskModelSeeder::class);
        $this->call(TechnologySeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(TestResultSeeder::class);
        $this->call(TestStatusSeeder::class);
        $this->call(ThreatGroupingSeeder::class);
        $this->call(ThreatCatalogSeeder::class);
        $this->call(PrivacySeeder::class);

        $this->call(DateFormatSeeder::class);
        $this->call(FileTypeExtensionSeeder::class);
        $this->call(FileTypeSeeder::class);
        $this->call(EmailConfigSettingsSeeder::class);
        /* End Main data */

        /* Start role and permission */
        $this->call(PermissionGroupSeeder::class);
        $this->call(SubGroupSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(PermissionToPermissionGroupSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(RoleResponsibilitySeeder::class);
        /* End role and permission */


        /* Start department and user */
        // Only seed if mode isn't production
        if (SEEDING_MODE !== 'production') {
            $this->call(DepartmentColorSeeder::class);
            $this->call(DepartmentSeeder::class);
            $this->call(JobSeeder::class);
        }
        $this->call(UserSeeder::class);
        // $this->call(PermissionToUserSeeder::class); // Isn't used
        /* End department and user */


        // $this->call(ContributingRisksLikelihoodSeeder::class); // Delete for live
        // Only seed if mode isn't production
        $this->call(AssetValueSeeder::class);
        if (SEEDING_MODE !== 'production') {
            $this->call(LocationSeeder::class);
            $this->call(AssetSeeder::class);
            $this->call(AssetGroupSeeder::class);
            $this->call(AssetAssetGroupSeeder::class);
        }

        if (SEEDING_MODE !== 'production') {
            $this->call(TagSeeder::class);
            $this->call(TeamSeeder::class);
        }

        /* Start asssessment */
        $this->call(AssessmentSeeder::class);
        $this->call(AssessmentQuestionSeeder::class);
        $this->call(AssessmentQuestionTableSeeder::class);
        $this->call(AssessmentAnswerSeeder::class);

        // $this->call(AssessmentAnswersToAssetGroupSeeder::class);
        // $this->call(AssessmentAnswersToAssetSeeder::class);
        // $this->call(AssessmentScoringContributingImpactSeeder::class);
        /* End asssessment */

        /* Start risk management */
        if (SEEDING_MODE !== 'production') {
            $this->call(ProjectSeeder::class);
            $this->call(CategorySeeder::class);
            $this->call(ContributingRiskSeeder::class);
            $this->call(RiskSeeder::class);
            $this->call(MitigationSeeder::class);
            $this->call(ClosureSeeder::class);
            $this->call(ContributingRisksImpactSeeder::class);
        }
        /* End risk management */

        /* Start framework and controls */
        if (SEEDING_MODE !== 'production') {
            $this->call(ControlOwnerSeeder::class);
        }

        // $this->call(FrameworkControlSeeder::class);
        // $this->call(FrameworkSeeder::class);
        // $this->call(FrameworkControlMappingSeeder::class);
        // $this->call(FrameworkControlTestSeeder::class);
        // $this->call(DocumentSeeder::class);
        $this->call(ControlAuditPolicySeeder::class);

        if (SEEDING_MODE !== 'production') {
            // $this->call(ItemsToTeamSeeder::class);
            $this->call(MgmtReviewSeeder::class);
            $this->call(RegulationSeeder::class);
            $this->call(RiskScoringSeeder::class);
            $this->call(RiskToLocationSeeder::class);
            $this->call(RiskToTeamSeeder::class);
            $this->call(RiskToTechnologySeeder::class);
            $this->call(RisksToAssetGroupSeeder::class);
            $this->call(RisksToAssetSeeder::class);
            $this->call(UserToTeamSeeder::class);
            $this->call(TaskSeeder::class);
            $this->call(HostRegionsSeeder::class);


        }
        $this->call(TenableWithVulnInfoAndHistory::class);
        /* End framework and controls */


        /* Start control objectives */
        if (SEEDING_MODE !== 'production') {
            $this->call(ControlObjectiveSeeder::class);
        }
        /* End control objectives */

        $this->call(AssetValueCategorySeeder::class);
        $this->call(AssetValueLevelSeeder::class);
        $this->call(AssetValueQuestionSeeder::class);

        /* Start notification settings */
        $this->call(ActionSeeder::class);
        $this->call(AddedPermissionsOfDocumentSeeder::class);
        /* End notification settings */

        /* remove question assement not needed seeder repeated*/
        $this->call(RemoveAssessmentQuestionSeeder::class);
        /* remove question assement not needed seeder repeated*/

        // Truncate notifications
        $this->call(TruncateNotificationTable::class);

        $this->call(ActionsForAuditDocumentSeeder::class);


        $this->call(ExceptionSettingSeeder::class);
        // Phishing Seeders
        if (SEEDING_MODE !== 'production') {
            $this->call(PhishingDomainsSeeder::class);
            $this->call(PhishingSenderProfileSeeder::class);
            $this->call(PhishingCategorySeeder::class);
            $this->call(PhishingWebsitePagesTableSeeder::class);
            $this->call(PhishingLandingPageTableSeeder::class);
            $this->call(PhishingTemplateSeeder::class);
            $this->call(PhishingGroupSeeder::class);
            $this->call(PhishingGroupUsersSeeder::class);
            $this->call(PhishingCampaignSeeder::class);
            $this->call(PhishingCampaignPivotsSeeder::class);
            $this->call(PhishingCampaignTrackingSeeder::class);
        }

        $this->call(ThirdPartyConfigrationSeeder::class);
        $this->call(IncidentCriteriaSeeder::class);
        // $this->call(AssetHostRegionSeeder::class);
        // $this->call(PhysicalCoursesSeeder::class);


    }
}
