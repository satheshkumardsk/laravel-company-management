<?php

namespace App\Exports;

use App\Models\Company;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompaniesExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Company::all();
    }

    public function map($company): array
    {
        return [
            $company->id,
            $company->company_name,
            $company->company_email,
            $company->company_logo,
            $company->company_website,
            $company->active_status
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'company_name',
            'company_email',
            'company_logo',
            'company_website',
            'active_status'
        ];
    }
}
