<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;


class AuditExport  implements FromArray
{
    public function array(): array
    {
        $data = get_audit_trail();
        return $data;
    }
}
