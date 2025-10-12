<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([

            "value" => '5',
            "name" => 'alert_timeout'
        ]);
        Setting::create([
            "value" => '1',
            "name" => 'allow_ownermanager_to_risk'
        ]);
        Setting::create([
            "value" => '1',
            "name" => 'allow_owner_to_risk'
        ]);
        Setting::create([
            "value" => '1',
            "name" => 'allow_stakeholder_to_risk'
        ]);
        Setting::create([
            "value" => '1',
            "name" => 'allow_submitter_to_risk'
        ]);
        Setting::create([
            "value" => '1',
            "name" => 'allow_team_member_to_risk'
        ]);
        Setting::create([
            "value" => '0',
            "name" => 'auto_verify_new_assets'
        ]);
        Setting::create([
            "value" => 'true',
            "name" => 'backup_auto'
        ]);
        Setting::create([
            "value" => '1',
            "name" => 'backup_remove'
        ]);
        Setting::create([
            "value" => 'daily',
            "name" => 'backup_schedule'
        ]);
        Setting::create([
            "value" => 'cdn',
            "name" => 'bootstrap_delivery_method'
        ]);
        Setting::create([
            "value" => '5',
            "name" => 'closed_audit_status'
        ]);
        Setting::create([
            "value" => '0',
            "name" => 'content_security_policy'
        ]);
        Setting::create([
            "value" => '$',
            "name" => 'currency'
        ]);
        Setting::create([
            "value" => '20211115-001',
            "name" => 'db_version'
        ]);
        Setting::create([
            "value" => '0',
            "name" => 'debug_logging'
        ]);
        Setting::create([
            "value" => '/tmp/debug_log',
            "name" => 'debug_log_file'
        ]);
        Setting::create([
            "value" => '5',
            "name" => 'default_asset_valuation'
        ]);
        Setting::create([
            "value" => '0',
            "name" => 'default_current_maturity'
        ]);
        Setting::create([
            "value" => 'MM/DD/YYYY',
            "name" => 'default_date_format'
        ]);
        Setting::create([
            "value" => '3',
            "name" => 'default_desired_maturity'
        ]);
        Setting::create([
            "value" => 'en',
            "name" => 'default_language'
        ]);
        Setting::create([
            "value" => '10',
            "name" => 'default_risk_score'
        ]);
        Setting::create([
            "value" => 'Asia/Riyadh',
            "name" => 'default_timezone'
        ]);
        Setting::create([
            "value" => 'cdn',
            "name" => 'highcharts_delivery_method'
        ]);
        Setting::create([
            "value" => 'WtrZ7UYyt7XdoRsTKftzHI9uv5mdXFKPCRcZf83ZoUYRu0pxXZ',
            "name" => 'instance_id'
        ]);
        Setting::create([
            "value" => 'cdn',
            "name" => 'jquery_delivery_method'
        ]);
        Setting::create([
            "value" => '300',
            "name" => 'maximum_risk_subject_length'
        ]);
        Setting::create([
            "value" => '5120000',
            "name" => 'max_upload_size'
        ]);
        Setting::create([
            "value" => 'InherentRisk',
            "name" => 'next_review_date_uses'
        ]);
        Setting::create([
            "value" => 'true',
            "name" => 'NOTIFY_ADDITIONAL_STAKEHOLDERS'
        ]);
        Setting::create([
            "value" => '1',
            "name" => 'pass_policy_alpha_required'
        ]);
        Setting::create([
            "value" => '0',
            "name" => 'pass_policy_attempt_lockout'
        ]);
        Setting::create([
            "value" => '10',
            "name" => 'pass_policy_attempt_lockout_time'
        ]);
        Setting::create([
            "value" => '1',
            "name" => 'pass_policy_digits_required'
        ]);
        Setting::create([
            "value" => '1',
            "name" => 'pass_policy_enabled'
        ]);
        Setting::create([
            "value" => '1',
            "name" => 'pass_policy_lower_required'
        ]);
        Setting::create([
            "value" => '0',
            "name" => 'pass_policy_max_age'
        ]);
        Setting::create([
            "value" => '0',
            "name" => 'pass_policy_min_age'
        ]);
        Setting::create([
            "value" => '8',
            "name" => 'pass_policy_min_chars'
        ]);
        Setting::create([
            "value" => '0',
            "name" => 'pass_policy_reuse_limit'
        ]);
        Setting::create([
            "value" => '0',
            "name" => 'pass_policy_re_use_tracking'
        ]);
        Setting::create([
            "value" => '1',
            "name" => 'pass_policy_special_required'
        ]);
        Setting::create([
            "value" => '1',
            "name" => 'pass_policy_upper_required'
        ]);
        Setting::create([
            "value" => 'noreply@simplerisk.it',
            "name" => 'phpmailer_from_email'
        ]);
        Setting::create([
            "value" => 'SimpleRisk',
            "name" => 'phpmailer_from_name'
        ]);
        Setting::create([
            "value" => 'smtp1.example.com',
            "name" => 'phpmailer_host'
        ]);
        Setting::create([
            "value" => 'secret',
            "name" => 'phpmailer_password'
        ]);
        Setting::create([
            "value" => '587',
            "name" => 'phpmailer_port'
        ]);
        Setting::create([
            "value" => '[SIMPLERISK]',
            "name" => 'phpmailer_prepend'
        ]);
        Setting::create([
            "value" => 'noreply@simplerisk.it',
            "name" => 'phpmailer_replyto_email'
        ]);
        Setting::create([
            "value" => 'SimpleRisk',
            "name" => 'phpmailer_replyto_name'
        ]);
        Setting::create([
            "value" => 'false',
            "name" => 'phpmailer_smtpauth'
        ]);
        Setting::create([
            "value" => 'true',
            "name" => 'phpmailer_smtpautotls'
        ]);
        Setting::create([
            "value" => 'none',
            "name" => 'phpmailer_smtpsecure'
        ]);
        Setting::create([
            "value" => 'sendmail',
            "name" => 'phpmailer_transport'
        ]);
        Setting::create([
            "value" => 'user@example.com',
            "name" => 'phpmailer_username'
        ]);
        Setting::create([
            "value" => '0',
            "name" => 'plan_projects_show_all'
        ]);
        Setting::create([
            "value" => '0',
            "name" => 'registration_registered'
        ]);
        Setting::create([
            "value" => '0',
            "name" => 'risk_appetite'
        ]);
        Setting::create([
            "value" => '0',
            "name" => 'risk_mapping_required'
        ]);
        Setting::create([
            "value" => '3',
            "name" => 'risk_model'
        ]);
        Setting::create([
            "value" => '28800',
            "name" => 'session_absolute_timeout'
        ]);
        Setting::create([
            "value" => '3600',
            "name" => 'session_activity_timeout'
        ]);
        Setting::create([
            "value" => 'http://localhost:8000',
            "name" => 'simplerisk_base_url'
        ]);
        Setting::create([
            "value" => '1',
            "name" => 'strict_user_validation'
        ]);

        // ldap setting
        Setting::create([
            "value" => "www.zflexldap.com",
            "name" => 'LDAP_DEFAULT_HOSTS'
        ]);
        Setting::create([
            "value" => "389",
            "name" => 'LDAP_DEFAULT_PORT'
        ]);
        Setting::create([
            "value" => "dc=zflexsoftware,dc=com",
            "name" => "LDAP_DEFAULT_BASE_DN"
        ]);
        Setting::create([
            "value" => "cn=ro_admin,ou=sysadmins,dc=zflexsoftware,dc=com",
            "name" => 'LDAP_DEFAULT_USERNAME'
        ]);
        Setting::create([
            "value" => "",
            "name" => 'LDAP_USER_FLITER'
        ]);
        Setting::create([
            "value" => "zflexpass",
            "name" => 'LDAP_DEFAULT_PASSWORD'
        ]);
        Setting::create([
            "value" => "false",
            "name" => 'LDAP_DEFAULT_SSL'
        ]);
        Setting::create([
            "value" => "false",
            "name" => 'LDAP_DEFAULT_TLS'
        ]);
        Setting::create([
            "value" => "3",
            "name" => 'LDAP_DEFAULT_VSERSION'
        ]);
        Setting::create([
            "value" => "5",
            "name" => 'LDAP_DEFAULT_TIMEOUT'
        ]);
        Setting::create([
            "value" => "false",
            "name" => 'LDAP_DEFAULT_Follow'
        ]);
        Setting::create([
            "value" => "",
            "name" => 'LDAP_name'
        ]);
        Setting::create([
            "value" => "",
            "name" => 'LDAP_email'
        ]);
        Setting::create([
            "value" => "",
            "name" => 'LDAP_username'
        ]);
        Setting::create([
            "value" => "",
            "name" => 'LDAP_password'
        ]);
        Setting::create([
            "value" => "",
            "name" => 'LDAP_dapartment'
        ]);
        Setting::create([
            "value" => "Cyber Mode",
            "name" => 'APP_NAME'
        ]);
        Setting::create([

            "value" => "Cyber Mode",
            "name" => 'APP_AUTHOR_EN'
        ]);
        Setting::create([

            "value" => "Cyber Mode",
            "name" => 'APP_AUTHOR_AR'
        ]);
        Setting::create([
            "value" => "Cyber Mode",
            "name" => 'APP_AUTHOR_ABBR_EN'
        ]);
        Setting::create([
            "value" => "Cyber Mode",
            "name" => 'APP_AUTHOR_ABBR_AR'
        ]);
        Setting::create([
            "value" => "https://www.advancedcontrols.sa",
            "name" => 'APP_AUTHOR_WEBSITE'
        ]);
        Setting::create([
            "value" => "Cyber Mode",
            "name" => 'APP_OWNER_EN'
        ]);
        Setting::create([
            "value" => "Cyber Mode",
            "name" => 'APP_OWNER_AR'
        ]);
        Setting::create([
            "value" => "images/logo/1667651514.png", // logo file name on server (for default value)
            "name" => 'APP_LOGO'
        ]);
        Setting::create([
            "value" => "images/ico/favicon.ico",
            "name" => 'APP_FAVICON'
        ]);
        Setting::create([
            "value" => "images/ico/risk_photo.png",
            "name" => 'risk_photo'
        ]);
        Setting::create([
            "value" => "images/ico/institution_photo.png",
            "name" => 'institution_photo'
        ]);
        Setting::create([
            "value" => "images/ico/favicon.ico",
            "name" => 'cybermode_logo'
        ]);
        Setting::create([
            "value" => "images/ico/lock.png",
            "name" => 'lock_logo'
        ]);
        
        Setting::create([
            "value" => "",
            "name" => 'change_requests_responsible_department_id'
        ]);
    }
}
