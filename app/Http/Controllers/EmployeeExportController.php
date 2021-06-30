<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeExportController extends Controller
{
    public function export(){
        return (new EmployeesExport)->download('employees.xlsx');
    }
}
