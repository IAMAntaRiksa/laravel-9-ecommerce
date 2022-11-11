<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $month = date('m');
        $year = date('Y');
        try {
            $success = Invoice::where('status', 'success')->count();
            $pending = Invoice::where('status', 'pending')->count();
            $failed = Invoice::where('status', 'failed')->count();
            $expired = Invoice::where('status', 'expired')->count();


            $revenueMonth = Invoice::where('status', 'success')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', $year)->sum('grand_total');

            $revenueYear = Invoice::where('status', 'success')
                ->whereYear('created_at', $year)->sum('grand_total');

            $revenueAll = Invoice::where('status', 'success')
                ->sum('grand_total');
        } catch (\Exception $error) {
            $error->getMessage();
        }
        return view('page.dashboard.index', compact('success', 'pending', 'failed', 'expired', 'revenueMonth', 'revenueYear', 'revenueAll'));
    }
}