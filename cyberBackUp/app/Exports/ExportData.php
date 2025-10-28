<?php

namespace App\Exports;

use App\Models\Asset;
use App\Models\Risk;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportData implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // dd(session()->get('table'));
        if (session()->get('table') == 'assets') {

            return Asset::with('location', 'assetValue')->get();
        } elseif (session()->get('table') == 'risks') {
            // dd(Risk::all());
            return Risk::all();
        }
    }

    public function map($query): array
    {
        if (session()->get('table') == 'assets') {
            return [
                $query->id,
                $query->ip,
                $query->name,
                $query->assetValue->min_value,
                $query->assetValue->max_value,
                $query->location->name,
                $query->teams,
                $query->details,

                // $query->user->plus_one,
                // Carbon::parse($query->event_date)->toFormattedDateString(),
                // Carbon::parse($query->created_at)->toFormattedDateString()
            ];
        } elseif (session()->get('table') == 'risks') {
            return [
                $query->id,
                $query->subject,
                $query->status,
                $query->regulation,
                $query->subject,
                $query->reference_id,
                $query->regulatio,
                $query->control_id,
                $query->category_id,
                $query->owner_id,
                $query->manager_id,
                $query->assessment,
                $query->notes,
                $query->review_date,
                $query->mitigation_id,
                $query->mgmt_review,
                $query->project_id,
                $query->close_id,
                $query->submitted_by,
                $query->risk_catalog_mapping,
                $query->threat_catalog_mapping,
                $query->template_group_id
            ];
        }
    }

    public function headings(): array
    {
        if (session()->get('table') == 'assets') {
            return [
                '#',
                'ip',
                'name',
                'asset min value',
                'asset max value',
                'location',
                'team',
                'details',
            ];
        } elseif (session()->get('table') == 'risks') {
            return [
                '#',
                'subject',
                'status',
                'regulation',
                'subject',
                'reference_id',
                'regulatio',
                'control_id',
                'category_id',
                'owner_id',
                'manager_id',
                'assessment',
                'notes',
                'review_date',
                'mitigation_id',
                'mgmt_review',
                'project_id',
                'close_id',
                'submitted_by',
                'risk_catalog_mapping',
                'threat_catalog_mapping',
                'template_group_id'
            ];
        }
    }
}
