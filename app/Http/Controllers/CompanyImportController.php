<?php

namespace App\Http\Controllers;

use App\Imports\CompaniesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CompanyImportController extends Controller
{
    public function import_show(){

    }

    public function import_store(Request $request){
        $file=$request->file('file')->store('company_imports');

        // $import=new CompaniesImport;
        // $import->import($file);
        Excel::import(new CompaniesImport,$file);
        return back()->withStatus('Import Successful');
    }

}
