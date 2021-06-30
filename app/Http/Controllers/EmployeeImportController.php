<?php

namespace App\Http\Controllers;

use App\Imports\EmployeesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeImportController extends Controller
{
    public function import_show(){

    }

    public function import_store(Request $request){
        $file=$request->file('file')->store('employee_imports');
        Excel::import(new EmployeesImport,$file);
        return back()->withStatus('Import Successful');
    }


}
