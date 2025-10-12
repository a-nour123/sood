<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskScoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_scorings', function (Blueprint $table) {
            // $table->id();
            $table->foreignId('id')->constrained('risks')->onDelete('cascade'); // Risk id
            $table->integer('scoring_method');
            // $table->foreignId('scoring_method')->constrained('scoring_methods'); // column name must be scoring_method_id
            $table->float('calculated_risk')->index('calculated_risk');
            $table->float('CLASSIC_likelihood')->default(5);
            $table->float('CLASSIC_impact')->default(5);
            $table->string('CVSS_AccessVector', 3)->default('N');
            $table->string('CVSS_AccessComplexity', 3)->default('L');
            $table->string('CVSS_Authentication', 3)->default('N');
            $table->string('CVSS_ConfImpact', 3)->default('C');
            $table->string('CVSS_IntegImpact', 3)->default('C');
            $table->string('CVSS_AvailImpact', 3)->default('C');
            $table->string('CVSS_Exploitability', 3)->default('ND');
            $table->string('CVSS_RemediationLevel', 3)->default('ND');
            $table->string('CVSS_ReportConfidence', 3)->default('ND');
            $table->string('CVSS_CollateralDamagePotential', 3)->default('ND');
            $table->string('CVSS_TargetDistribution', 3)->default('ND');
            $table->string('CVSS_ConfidentialityRequirement', 3)->default('ND');
            $table->string('CVSS_IntegrityRequirement', 3)->default('ND');
            $table->string('CVSS_AvailabilityRequirement', 3)->default('ND');
            $table->integer('DREAD_DamagePotential')->default(10);
            $table->integer('DREAD_Reproducibility')->default(10);
            $table->integer('DREAD_Exploitability')->default(10);
            $table->integer('DREAD_AffectedUsers')->default(10);
            $table->integer('DREAD_Discoverability')->default(10);
            $table->integer('OWASP_SkillLevel')->default(10);
            $table->integer('OWASP_Motive')->default(10);
            $table->integer('OWASP_Opportunity')->default(10);
            $table->integer('OWASP_Size')->default(10);
            $table->integer('OWASP_EaseOfDiscovery')->default(10);
            $table->integer('OWASP_EaseOfExploit')->default(10);
            $table->integer('OWASP_Awareness')->default(10);
            $table->integer('OWASP_IntrusionDetection')->default(10);
            $table->integer('OWASP_LossOfConfidentiality')->default(10);
            $table->integer('OWASP_LossOfIntegrity')->default(10);
            $table->integer('OWASP_LossOfAvailability')->default(10);
            $table->integer('OWASP_LossOfAccountability')->default(10);
            $table->integer('OWASP_FinancialDamage')->default(10);
            $table->integer('OWASP_ReputationDamage')->default(10);
            $table->integer('OWASP_NonCompliance')->default(10);
            $table->integer('OWASP_PrivacyViolation')->default(10);
            $table->float('Custom')->default(10);
            $table->integer('Contributing_Likelihood')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_scorings');
    }
}
