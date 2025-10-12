<?php

namespace App\Exports;

use App\Models\Incident;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IncidentExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Incident::query();

        if (!empty($this->filters['direction_id'])) {
            $query->where('direction_id', $this->filters['direction_id']);
        }
        if (!empty($this->filters['attack_id'])) {
            $query->where('attack_id', $this->filters['attack_id']);
        }
        if (!empty($this->filters['detected_id'])) {
            $query->where('detected_id', $this->filters['detected_id']);
        }
        if (!empty($this->filters['play_book_id'])) {
            $query->where('play_book_id', $this->filters['play_book_id']);
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }
        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        return $query->with(['occurrence', 'direction', 'attack', 'detected', 'tlpLevel', 'papLevel'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Summary',
            'Occurrence',
            'Direction',
            'Attack',
            'Detected By',
            'Detected On',
            'TLP',
            'PAP',
            'Priority',
            'Status',
            'Created At',
        ];
    }

    public function map($incident): array
    {
        return [
            $incident->id,
            $incident->summary,
            optional($incident->occurrence)->name,
            optional($incident->direction)->name,
            optional($incident->attack)->name,
            optional($incident->detected)->name,
            $incident->detected_on,
            optional($incident->tlpLevel)->name,
            optional($incident->papLevel)->name,
            $incident->total_score,
            $incident->status,
            $incident->created_at->format('Y-m-d H:i:s'),
        ];
    }
}