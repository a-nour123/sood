<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsVulnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vulnerabilities', function (Blueprint $table) {
            $table->text('family')->nullable();
             $table->text('acr')->nullable();
            $table->text('aes')->nullable();
            $table->text('repository')->nullable(); // Corrected 'repositry'
            $table->text('mac_address')->nullable();
            $table->text('plugin_output')->nullable();
            $table->text('steps_to_remediate')->nullable(); // Corrected 'step to remedicate'
            $table->text('see_also')->nullable();
            $table->text('risk_factor')->nullable();
            $table->text('stig_severity')->nullable();
            $table->text('vuln_priority_rating')->nullable();
            $table->text('cvss_v2')->nullable(); // Corrected 'cvssv2'
            $table->text('cvss_v3')->nullable(); // Corrected 'cvssv3'
            $table->text('cvss_v2_temporal_score')->nullable(); // Corrected 'cvssv2_teporal_score'
            $table->text('cvss_v3_temporal_score')->nullable(); // Corrected 'cvssv3_teporal_score'
            $table->text('cvss_v2_vector')->nullable();
            $table->text('cpe')->nullable();
            $table->text('bid')->nullable();
            $table->text('cross_reference')->nullable(); // Corrected 'cross_refrence'
            $table->text('severity_end_of_life')->nullable();
            $table->text('patch_publication')->nullable();
            $table->text('plus_modification')->nullable(); // Corrected 'plus_mofification'
            $table->text('exploit_ease')->nullable();
            $table->text('exploit_framework')->nullable(); // Corrected 'exploit_frame'
            $table->text('check_type')->nullable();
            $table->text('version')->nullable();
            $table->text('recast_risk_comment')->nullable();
            $table->text('agent_id')->nullable();
            $table->text('service')->nullable();
            $table->text('department')->nullable(); // Corrected 'departement'
            $table->text('system')->nullable();
        });
    }

    public function down()
    {
        Schema::table('vulnerabilities', function (Blueprint $table) {
            $table->dropColumn([
                'family',
                 'acr',
                'aes',
                'repository',
                'mac_address',
                'plugin_output',
                'steps_to_remediate',
                'see_also',
                'risk_factor',
                'stig_severity',
                'vuln_priority_rating',
                'cvss_v2',
                'cvss_v3',
                'cvss_v2_temporal_score',
                'cvss_v3_temporal_score',
                'cvss_v2_vector',
                'cpe',
                'bid',
                'cross_reference',
                'severity_end_of_life',
                'patch_publication',
                'plus_modification',
                'exploit_ease',
                'exploit_framework',
                'check_type',
                'version',
                'recast_risk_comment',
                'agent_id',
                'service',
                'department',
                'system'
            ]);
        });
    }
}
