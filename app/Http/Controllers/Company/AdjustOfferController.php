<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdjustOfferController extends Controller
{
    public function __invoke(Request $request, int $operator)
    {
        $operator = operators()->firstWhere('id', $operator);
        abort_if(!$operator, 404);

        $request->session()->put('selected_operator', $operator['id']);
        return view('company.adjust', compact('operator'));
    }
}
