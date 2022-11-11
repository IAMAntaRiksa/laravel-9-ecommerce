<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Invoice;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $invoices  = Invoice::when(request()->q, function ($invoices) {
            $invoices = $invoices->where('invoce', 'like', '%' . request()->q . '%');
        })->where('customer_id', auth()->user()->id)->latest()->paginate(5);

        return OrderResource::collection($invoices);
    }
    public function show($snap_token)
    {
        $invoice = Invoice::where('customer_id', auth()->user()->id)->where('snap_token', $snap_token)->first();
        if ($invoice) {
            return new OrderResource($invoice);
        } else {
            return response()->json(['message' => 'Not Found'], 404);
        }
    }
}