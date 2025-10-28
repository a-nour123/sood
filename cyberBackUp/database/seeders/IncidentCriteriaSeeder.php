<?php

namespace Database\Seeders;

use App\Models\IncidentClassify;
use App\Models\IncidentCriteria;
use App\Models\IncidentScore;
use Illuminate\Database\Seeder;

class IncidentCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $incident1 =  IncidentCriteria::create([
            'name' => 'Impact',
            'description' => 'How does the incident affect business operations, data integrity, and users?'
        ]);
        IncidentScore::create([
            'title' => 'Critical',
            'point' => 4,
            'incident_criteria_id' => $incident1->id
        ]);
        IncidentScore::create([
            'title' => 'High',
            'point' => 3,
            'incident_criteria_id' => $incident1->id
        ]);
        IncidentScore::create([
            'title' => 'Medium',
            'point' => 2,
            'incident_criteria_id' => $incident1->id
        ]);
        IncidentScore::create([
            'title' => 'Low',
            'point' => 1,
            'incident_criteria_id' => $incident1->id
        ]);


        $incident2 =  IncidentCriteria::create([
            'name' => 'Scope',
            'description' => 'How many systems, applications, or users are affected?'
        ]);
        IncidentScore::create([
            'title' => 'Organization-wide',
            'point' => 4,
            'incident_criteria_id' => $incident2->id
        ]);
        IncidentScore::create([
            'title' => 'Departmental',
            'point' => 3,
            'incident_criteria_id' => $incident2->id
        ]);
        IncidentScore::create([
            'title' => 'Limited',
            'point' => 2,
            'incident_criteria_id' => $incident2->id
        ]);
        IncidentScore::create([
            'title' => 'Isolated',
            'point' => 1,
            'incident_criteria_id' => $incident2->id
        ]);


        $incident3 =  IncidentCriteria::create([
            'name' => 'Duration',
            'description' => 'How long has the incident been occurring, or how long could it last?'
        ]);
        IncidentScore::create([
            'title' => 'Less than 1 hour',
            'point' => 4,
            'incident_criteria_id' => $incident3->id
        ]);
        IncidentScore::create([
            'title' => '1-4 hours',
            'point' => 3,
            'incident_criteria_id' => $incident3->id
        ]);
        IncidentScore::create([
            'title' => '4-24 hours',
            'point' => 2,
            'incident_criteria_id' => $incident3->id
        ]);
        IncidentScore::create([
            'title' => 'More than 24 hours',
            'point' => 1,
            'incident_criteria_id' => $incident3->id
        ]);


        $incident4 =  IncidentCriteria::create([
            'name' => 'Recoverability',
            'description' => 'How easily can services be restored or data be recovered?'
        ]);
        IncidentScore::create([
            'title' => 'Immediate recovery possible',
            'point' => 4,
            'incident_criteria_id' => $incident4->id
        ]);
        IncidentScore::create([
            'title' => 'Recovery possible within hours',
            'point' => 3,
            'incident_criteria_id' => $incident4->id
        ]);
        IncidentScore::create([
            'title' => 'Recovery possible within days',
            'point' => 2,
            'incident_criteria_id' => $incident4->id
        ]);
        IncidentScore::create([
            'title' => 'Difficult to recover',
            'point' => 1,
            'incident_criteria_id' => $incident4->id
        ]);


        $incident5 =  IncidentCriteria::create([
            'name' => 'Compliance',
            'description' => 'Does the incident have implications for regulatory compliance?'
        ]);
        IncidentScore::create([
            'title' => 'Critical compliance breach',
            'point' => 4,
            'incident_criteria_id' => $incident5->id
        ]);
        IncidentScore::create([
            'title' => 'High compliance risk',
            'point' => 3,
            'incident_criteria_id' => $incident5->id
        ]);
        IncidentScore::create([
            'title' => 'Moderate compliance impact',
            'point' => 2,
            'incident_criteria_id' => $incident5->id
        ]);
        IncidentScore::create([
            'title' => 'No compliance impact',
            'point' => 1,
            'incident_criteria_id' => $incident5->id
        ]);


        IncidentClassify::create([
            'priority' => 'P1 (Critical)',
            'value' => 20,
            'color' => '#00c732',
            'sla' => 3,
            'description' => 'P1 (Critical): Description'
        ]);
        IncidentClassify::create([
            'priority' => 'P2 (High)',
            'value' =>14,
            'color' => '#b8b8b7',
            'sla' => 5,
            'description' => 'P2 (High): Description'
        ]);
        IncidentClassify::create([
            'priority' => 'P3 (Medium)',
            'value' => 9,
            'color' => '#e6ca3d',
            'sla' => 2,
            'description' => 'P3 (Medium): Description'
        ]);
        IncidentClassify::create([
            'priority' => 'P1 (Critical)',
            'value' => 4,
            'color' => '#ff0000',
            'sla' => 3,
            'description' => 'P4 (Low): Description'
        ]);

    }
}
