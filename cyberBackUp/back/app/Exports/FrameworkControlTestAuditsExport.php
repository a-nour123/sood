<?php

namespace App\Exports;

use App\Models\FrameworkControlTestAudit;
use App\Traits\LaravelExportPropertiesTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class FrameworkControlTestAuditsExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{

    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)
    private $counter = 1;
    private $statusArray = [];

    public function __construct(string $auditType)
    {
        if ($auditType == 'active')
            $this->statusArray = [1, 2, 3, 4];
        else if ($auditType == 'past')
            $this->statusArray = [5];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return FrameworkControlTestAudit::whereIn('status', $this->statusArray)->with('FrameworkControlWithFramworks:id,short_name,family')->orderBy("created_at", "desc")->get()->map(function ($audit) {
            if ($audit->FrameworkControlWithFramworks) {
                $controlName = $audit->FrameworkControlWithFramworks->short_name;
                if ($audit->FrameworkControlWithFramworks->Frameworks()->count()) {
                    $controlName .= ' (' . implode(', ', $audit->FrameworkControlWithFramworks->Frameworks()->pluck('name')->toArray()) . ')';
                }
            } else {
                $controlName = "";
            }

            return (object)[
                'framework' => ($audit->FrameworkControlWithFramworks) ? $audit->FrameworkControlWithFramworks->Frameworks->pluck('name') : [],
                'sub_domain' => ($audit->FrameworkControlWithFramworks) ? $audit->FrameworkControlWithFramworks->Families->pluck('name') : [],
                'control' => $controlName,
                'name' => $audit->name,
                'tester' => ($audit->UserTester) ? $audit->UserTester->name : '',
                'last_date' => $audit->last_date,
                'next_date' => $audit->next_date,
                'Actions' => $audit->id,
            ];
        });
    }

    /**
     * @var FrameworkControlTestAudit $audit
     */
    public function map($audit): array
    {
        $auditFrameworkNames = $audit->framework;
        if (count($auditFrameworkNames))
            // $auditFrameworkNames =  "(" . implode('), (', $auditFrameworkNames->toArray()) . ")";
            $auditFrameworkNames =  implode(', ', $auditFrameworkNames->toArray());
        else
            $auditFrameworkNames = '';

        $auditSubDomainNames = $audit->sub_domain;
        if (count($auditSubDomainNames))
            // $auditSubDomainNames =  "(" . implode('), (', $auditSubDomainNames->toArray()) . ")";
            $auditSubDomainNames =  implode(', ', $auditSubDomainNames->toArray());
        else
            $auditSubDomainNames = '';

        return [
            $this->counter++,
            $auditFrameworkNames,
            $auditSubDomainNames,
            $audit->control,
            $audit->name,
            $audit->tester,
            $audit->last_date,
            $audit->next_date,
        ];
    }


    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.Framework'),
            __('locale.control_sub_domain'),
            __('locale.Control'),
            __('locale.TestName'),
            __('locale.Tester'),
            __('locale.LastTestDate'),
            __('locale.NextTestDate')
        ];
    }
}
