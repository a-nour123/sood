<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
trait RiskControlTrait
{

    /**
     * check type
     *
     * @return true
     */
    public function RiskControl($type, $filter = [])
    {
        $row = [];
        if ($type == 0) {
            //RisksByControl
            return $this->RisksByControl($filter);
        } else {
            //ControlsByRisk
            return $this->ControlsByRisk();
        }

    }

    public function RisksByControl($filters)
    {
        $select = "SELECT  fc.id as gr_id, b.*, c.calculated_risk, fc.short_name control_short_name, fc.long_name control_long_name, fc.id control_id
                , fc.control_number, fc.mitigation_percent, fc.supplemental_guidance, GROUP_CONCAT(DISTINCT f.name) framework_names, cc.name control_class_name
                , cph.name control_phase_name, cpr.name control_priority_name, cf.name control_family_name, cu.name control_owner_name
                , GROUP_CONCAT(DISTINCT l.name) location
                , GROUP_CONCAT(DISTINCT t.name) team
                , DATEDIFF(IF(b.status != 'Closed', NOW(), o.closure_date) , b.submission_date) days_open";
        $where_sql = " ";
        $order = "fc.long_name";
        $query = $select . "
                FROM mitigations a
                    INNER JOIN risks b ON a.risk_id = b.id
                    INNER JOIN `mitigation_to_controls` mtc ON a.id=mtc.mitigation_id
                    INNER JOIN framework_controls fc ON mtc.control_id=fc.id AND fc.deleted=0
                    LEFT JOIN risk_scorings c ON b.id = c.id
                    LEFT JOIN risk_to_locations rtl ON b.id=rtl.risk_id
                    LEFT JOIN locations l ON rtl.location_id=l.id
                    LEFT JOIN risk_to_teams rtt ON b.id=rtt.risk_id
                    LEFT JOIN teams t ON rtt.team_id=t.id
                    LEFT JOIN closures o ON b.close_id = o.id
                    LEFT JOIN `framework_control_mappings` m on fc.id=m.framework_control_id

                    LEFT JOIN `frameworks` f on m.framework_id=f.id AND f.status=1
                    LEFT JOIN `control_phases` cph on fc.control_phase=cph.id
                    LEFT JOIN `control_classes` cc on fc.control_class=cc.id
                    LEFT JOIN `control_priorities` cpr on fc.control_priority=cpr.id
                    LEFT JOIN `families` cf on fc.family=cf.id
                    LEFT JOIN `users` cu on fc.control_owner=cu.id
                WHERE 1 {$where_sql}
                GROUP BY
                    b.id, fc.id
            ORDER BY
        {$order}, c.calculated_risk DESC
        ;
        ";
        $rows = DB::select($query);
        return $rows;
    }
    public function ControlsByRisk()
    {
        $select = "SELECT b.id gr_id, b.*, c.calculated_risk, fc.short_name control_short_name, fc.long_name control_long_name, fc.id control_id
                , GROUP_CONCAT(DISTINCT l.name) location
                , GROUP_CONCAT(DISTINCT t.name) team
                , DATEDIFF(IF(b.status != 'Closed', NOW(), o.closure_date) , b.submission_date) days_open
        ";
        $where_sql = " ";
        $order = "fc.long_name";
        $query = $select . "
                FROM mitigations a
                    INNER JOIN risks b ON a.risk_id = b.id
                    INNER JOIN `mitigation_to_controls` mtc ON a.id=mtc.mitigation_id
                    INNER JOIN framework_controls fc ON mtc.control_id=fc.id AND fc.deleted=0
                    LEFT JOIN risk_scorings c ON b.id = c.id
                    LEFT JOIN risk_to_locations rtl ON b.id=rtl.risk_id
                    LEFT JOIN locations l ON rtl.location_id=l.id
                    LEFT JOIN risk_to_teams rtt ON b.id=rtt.risk_id
                    LEFT JOIN teams t ON rtt.team_id=t.id
                    LEFT JOIN closures o ON b.close_id = o.id
                    LEFT JOIN `framework_control_mappings` m on fc.id=m.framework_control_id
                    LEFT JOIN `frameworks` f on m.framework_id=f.id AND f.status=1
                    LEFT JOIN `control_phases` cph on fc.control_phase=cph.id
                    LEFT JOIN `control_classes` cc on fc.control_class=cc.id
                    LEFT JOIN `control_priorities` cpr on fc.control_priority=cpr.id
                    LEFT JOIN `families` cf on fc.family=cf.id
                    LEFT JOIN `users` cu on fc.control_owner=cu.id
                WHERE 1 {$where_sql}
                GROUP BY
                    b.id, fc.id
            ORDER BY
        {$order}, c.calculated_risk DESC;
        ";
        $rows = DB::select($query);
        return $rows;
    }

}
