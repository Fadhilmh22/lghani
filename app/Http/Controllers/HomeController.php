<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Jika tanggal tidak diset, gunakan default sebagai hari ini
    if (!$startDate || !$endDate) {
        $startDate = today()->format('Y-m-d');
        $endDate = today()->format('Y-m-d');
    }

    // Set waktu pada end_date hingga pukul 23:59:59
    $endDate .= ' 23:59:59';

    // Total Invoice dalam Range Tanggal (yang memiliki total != 0 dan customer_id yang berbeda)
    $totalInvoiceInRange = Invoice::whereBetween('created_at', [$startDate, $endDate])
        ->where('total', '!=', 0)
        
        ->count();

    // Total Penjualan dalam Range Tanggal (yang memiliki total != 0 dan customer_id yang berbeda)
    $totalPenjualanInRange = Invoice::whereBetween('created_at', [$startDate, $endDate])
        ->where('total', '!=', 0)
        
        ->sum('total');

    // Total Penjualan Bulan Ini (yang memiliki total != 0 dan customer_id yang berbeda)
    $totalPenjualanBulanIni = DB::table('invoice_details')
        ->join('invoices', 'invoice_details.invoice_id', '=', 'invoices.id')
        ->whereYear('invoices.created_at', now()->year)
        ->whereMonth('invoices.created_at', now()->month)
        ->where('invoices.total', '!=', 0)
        
        ->sum('invoice_details.pax_paid');

    return view('home', compact('totalInvoiceInRange', 'totalPenjualanInRange', 'totalPenjualanBulanIni', 'startDate', 'endDate'));
}




}
