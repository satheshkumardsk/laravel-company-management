<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_email',
        'company_logo',
        'company_website',
        'active_status'
    ];

    public function employees(){
        return $this->hasMany(Employee::class);
    }
}
