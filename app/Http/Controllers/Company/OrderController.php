<?php

namespace App\Http\Controllers\Company;

use App\DTO\OrderData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        company()->startOrder(session('selected_operator'));

        return redirect()->route('company.order');
    }

    public function view()
    {
        if (!company()->hasOrder()) {
            redirect()->route('company.dashboard');
        }

        $order = company()->order;

        $order['data'] = collect($order->order_data)->groupBy('is_vaxel_plan')->map(fn($group) => $group->map(fn($data) => OrderData::fromArray($data)));

        return view('company.order-review', compact('order'));
    }
}
