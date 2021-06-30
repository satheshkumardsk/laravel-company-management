<?php

namespace App\Http\Controllers;

use App\Exports\CompaniesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CompanyExportController extends Controller
{
    public function export(){
        return (new CompaniesExport)->download('companies.xlsx');
    }
}
