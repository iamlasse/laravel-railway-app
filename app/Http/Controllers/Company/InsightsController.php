<?php

namespace App\Http\Controllers\Company;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InsightsController extends Controller
{
    public function __invoke()
    {
        $companyData = DB::table('companies')
            ->select('companies.id')
            ->selectRaw(DB::raw('(SELECT COUNT(*) FROM subscriptions WHERE subscriptions.company_id = companies.id AND subscriptions.type = ?) as m_count'), ['M'])
            ->selectRaw(DB::raw('(SELECT COUNT(*) FROM subscriptions WHERE subscriptions.company_id = companies.id AND subscriptions.type = ?) as mb_count'), ['MB'])
            ->selectRaw(DB::raw('(SELECT COUNT(*) FROM subscriptions WHERE subscriptions.company_id = companies.id AND subscriptions.type = ?) as dk_count'), ['DK'])
            ->selectRaw(DB::raw('(SELECT COUNT(*) FROM subscriptions WHERE subscriptions.company_id = companies.id AND subscriptions.vaxel_user = ?) as uses_vaxel_count'), [true])
            ->selectRaw(DB::raw('(SELECT COUNT(*) FROM subscriptions WHERE subscriptions.company_id = companies.id AND subscriptions.to_be_cancelled = ? and (subscriptions.status = ? OR subscriptions.status = ?)) as to_be_cancelled_count'), [true, 1, 0])
            ->selectRaw(DB::raw('(SELECT SUM(current_plan_usage) FROM subscriptions WHERE subscriptions.company_id = companies.id) as data_usage'))
            ->selectRaw(DB::raw('(SELECT SUM(current_plan_data) FROM subscriptions WHERE subscriptions.company_id = companies.id) as total_data'))
            ->selectRaw(DB::raw('(SELECT count(*) from subscriptions where subscriptions.company_id = companies.id) as subscriptions_count'))
            ->where('companies.id', company()->id)->first();
        return view('company.insikter', compact('companyData'));
    }
}
