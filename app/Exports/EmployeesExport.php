<?php

namespace App\Exports;

use App\Models\Employee;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Employee::all();
    }

    public function map($employee): array
    {
        return [
            $employee->id,
            $employee->first_name,
            $employee->last_name,
            $employee->company_id,
            $employee->email,
            $employee->phone,
            $employee->designation,
            $employee->active_status
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'first_name',
            'last_name',
            'company_id',
            'email',
            'phone',
            'designation',
            'active_status'
        ];
    }
}
