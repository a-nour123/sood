<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\AssetGroup;
use App\Models\Risk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

use Session;


class ImportData implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    // public static $newletterArr = [];
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        // dd(session()->get('table'));
        if (session()->get('table') == 'assets') {

            return new Asset([
                "ip" => $row[0],
                "name" => $row[1],
                "asset_value_id" => $row[2],
                "location_id" => $row[3],
                "teams" => $row[4],
                "details" => $row[5],
                'start_date' => $row[6],
                "verified" => $row[7],
                'expiration_date' => $row[8],
            ]);
        } elseif (session()->get('table') == 'risks') {
            return new Risk([
                "status" => $row[0],
                'subject' => $row[1],
                'reference_id' =>  $row[2],
                'regulation' => $row[3],
                'control_id' =>  $row[4],
                // 'source' =>  $row[5],
                'category_id' => $row[5],
                'owner_id' =>   $row[6],
                'manager_id' =>   $row[7],
                'assessment' =>   $row[8],
                'notes' =>   $row[9],
                // 'submission_date' => $row[10],
                // 'last_update' =>  $row[1],
                'review_date' =>   $row[10],
                'mitigation_id' =>   $row[11],
                'mgmt_review' =>   $row[12],
                'project_id' =>  $row[13],
                'close_id' =>   $row[14],
                'submitted_by' =>  $row[15],
                'risk_catalog_mapping' =>  $row[16],
                'threat_catalog_mapping' => $row[17],
                'template_group_id' =>   $row[17],
            ]);
        }elseif(session()->get('table') == 'asset_groups'){
            return new AssetGroup([
                "id"=>$row[0],
                "name"=>$row[1]
            ]);

        }
    }
}
