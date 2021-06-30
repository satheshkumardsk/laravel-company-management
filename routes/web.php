<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanyExportController;
use App\Http\Controllers\CompanyImportController;
use App\Http\Controllers\EmployeeExportController;
use App\Http\Controllers\EmployeeImportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('companies', CompanyController::class);
Route::resource('employees', EmployeeController::class);

Route::post('companies/update_data', [CompanyController::class, 'update_data'])->name('companies.update_data');
Route::get('companies/destroy_data/{id}',[CompanyController::class, 'destroy_data']);


Route::post('employees/update_data', [EmployeeController::class, 'update_data'])->name('employees.update_data');
Route::get('employees/destroy_data/{id}',[EmployeeController::class, 'destroy_data']);


Route::get('companies_data/export',[CompanyExportController::class, 'export'])->name('companies_data.export');
Route::get('companies_data/import_show',[CompanyImportController::class, 'import_show'])->name('companies_data.import_show');
Route::post('companies_data/import_store',[CompanyImportController::class, 'import_store'])->name('companies_data.import_store');

Route::get('employees_data/export',[EmployeeExportController::class, 'export'])->name('employees_data.export');
Route::get('employees_data/import_show',[EmployeeImportController::class, 'import_show'])->name('employees_data.import_show');
Route::post('employees_data/import_store',[EmployeeImportController::class, 'import_store'])->name('employees_data.import_store');


