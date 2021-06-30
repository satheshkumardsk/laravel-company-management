<?php

namespace App\Imports;

use App\Models\Company;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;

class CompaniesImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure, ShouldQueue, WithChunkReading
{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Company([
            'id'     => $row['id'],
            'company_name'    => $row['company_name'],
            'company_email'    => $row['company_email'],
            'company_logo'    => $row['company_logo'],
            'company_website'    => $row['company_website'],
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
