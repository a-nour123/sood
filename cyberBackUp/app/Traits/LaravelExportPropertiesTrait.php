<?php

namespace App\Traits;

trait LaravelExportPropertiesTrait
{
    public function properties(): array
    {
        return [
            'creator'        => 'Cyber Mode',
            'lastModifiedBy' => getSystemSetting('APP_NAME'),
            'title'          => 'Assets Export',
            'description'    => 'Latest Assets',
            'subject'        => 'Assets',
            'keywords'       => 'Assets,export,spreadsheet',
            'category'       => 'Assets',
            'manager'        => getSystemSetting('APP_NAME'),
            'company'        => 'Maatwebsite',
        ];
    }
}
