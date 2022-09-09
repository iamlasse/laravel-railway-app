<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class AdminCompanyController extends Controller
{
    public function index(Request $request)
    {
        $companies = collect();
        return view('admin.companies.index', compact('companies'));
    }

    public function edit(Request $request, Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }
}
