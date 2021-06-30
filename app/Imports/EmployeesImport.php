<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class EmployeesImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure, ShouldQueue, WithChunkReading
{

    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Employee([
            'id'     => $row['id'],
            'first_name'    => $row['first_name'],
            'last_name'    => $row['last_name'],
            'company_id'    => $row['company_id'],
            'email'    => $row['email'],
            'phone'    => $row['phone'],
            'designation'    => $row['designation'],
            'active_status'    => $row['active_status'],
        ]);
    }

    public function rules(): array
    {
    return [];
    }

    public function onFailure(Failure ...$failure)
    {
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
