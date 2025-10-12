<?php

namespace App\Exports;

use App\Models\User;
use App\Traits\LaravelExportPropertiesTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class UsersExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{

    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)
    private $counter = 1;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::get();
    }

    /**
     * @var User $user
     */
    public function map($user): array
    {
        return [
            $this->counter++,
            $user->type,
            $user->username,
            $user->name,
            $user->email,
            $user->role->name,
            $user->admin ? '✔' : '✘',
            $user->enabled ? '✔' : '✘',
            $user->department ? $user->department->name : '',
            $user->ldap_region ? $user->ldap_region : '',
        ];
    }


    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.Type'),
            __('locale.Username'),
            __('locale.Name'),
            __('locale.Email'),
            __('locale.Role'),
            __('locale.Admin'),
            __('locale.Active'),
            __('locale.Department'),
            __('configure.Region')
        ];
    }
}
