<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DemosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('migrate:fresh');
        Artisan::call('migrate', [
            '--force' => true, // Ensures the migrations run in production
        ]);
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
        $this->call(UserSeeder::class);
        $this->call(AssetValueSeeder::class);
        /* Start asssessment */
        $this->call(AssessmentSeeder::class);
        $this->call(AssessmentQuestionSeeder::class);
        $this->call(AssessmentQuestionTableSeeder::class);
        $this->call(AssessmentAnswerSeeder::class);
        $this->call(ControlAuditPolicySeeder::class);
        /* End control objectives */

        $this->call(AssetValueCategorySeeder::class);
        $this->call(AssetValueLevelSeeder::class);
        $this->call(AssetValueQuestionSeeder::class);

        /* Start notification settings */
        $this->call(ActionSeeder::class);
        /* End notification settings */

        /* remove question assement not needed seeder repeated*/
        $this->call(RemoveAssessmentQuestionSeeder::class);
        /* remove question assement not needed seeder repeated*/

        // Truncate notifications
        $this->call(TruncateNotificationTable::class);

        $this->call(ActionsForAuditDocumentSeeder::class);


        $this->call(ExceptionSettingSeeder::class);
        $this->call(ThirdPartyConfigrationSeeder::class);
        $this->call(IncidentCriteriaSeeder::class);
        // $this->call(AssetHostRegionSeeder::class);
    }
}
