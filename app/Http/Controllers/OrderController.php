<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $datas = Invoice::when(request()->q, function ($invoices) {
            $invoices = $invoices->where('invoice', 'like', '%' . request()->q . '%');
        })->orderBy('id', 'DESC')->latest()->paginate(5);

        dd($datas);
        return view('page.order.index', compact('datas'));
    }

    public function show(Invoice $invoice)
    {
        return view('page.ordes.show', compact('invoice'));
    }
}