<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Airlines;
use App\Models\Customer;
use App\Models\Invoice_detail;
use App\Models\Invoice;
use App\Models\Hotel_invoice;
use Illuminate\Support\Facades\DB;
use PDF;

class ReportController extends Controller
{
    private $monthName = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    public function index()
    {
        $invoices = Invoice_detail::selectRaw("DISTINCT DATE_FORMAT(created_at,'%Y%m') AS monthlydate")->get()->sortBy('monthlydate')->toArray();
        $months = $this->monthName;
        return view('report.index', compact('invoices', 'months'));
    }

    public function generateReport(Request $request)
    {
        $validationRule = ['report_type' => 'required|integer'];

        if( $request->report_type == 1 ) {
            $validationRule['month'] = 'required|integer';
        } else {
            $validationRule['start_date'] = 'required|date';
            $validationRule['end_date'] = 'required|date';
        }

        $this->validate($request, $validationRule);
        
        if ($request->report_type == 2) {
            if ($request->start_date > $request->end_date) {
                // Jika tanggal awal > tanggal akhir, tampilkan pesan kesalahan dan arahkan kembali
                return redirect()->back()->with(['error' => 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir']);
            }
        
            $today = now(); // Mengambil tanggal hari ini
            if ($request->start_date > $today) {
                // Jika tanggal awal lebih besar dari hari ini, tampilkan pesan kesalahan dan arahkan kembali
                return redirect()->back()->with(['error' => 'Data laporan belum ada']);
            }
        }

        try {
            $field = ["invoice_details.*", "invoices.invoiceno", "invoices.status", "customers.booker", "customers.payment", "airlines.airlines_code", "airlines.airlines_name"];
            $invoices;

            if( $request->report_type == 1 ) {
                $invoices = DB::table('invoice_details')->select($field)
                            ->join('invoices', 'invoice_details.invoice_id', '=', 'invoices.id')
                            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
                            ->join('airlines', 'invoice_details.airline_id', '=', 'airlines.id')
                            ->where(DB::raw("DATE_FORMAT(invoice_details.created_at,'%Y%m')"), $request->month)
                            ->get();
            } else {
                $invoices = DB::table('invoice_details')->select($field)
                            ->join('invoices', 'invoice_details.invoice_id', '=', 'invoices.id')
                            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
                            ->join('airlines', 'invoice_details.airline_id', '=', 'airlines.id')
                            ->where(DB::raw("DATE_FORMAT(invoice_details.created_at,'%Y%m%d')"), ">=", date("Ymd", strtotime($request->start_date)))
                            ->where(DB::raw("DATE_FORMAT(invoice_details.created_at,'%Y%m%d')"), "<=", date("Ymd", strtotime($request->end_date)))
                            ->get();
            }

            $report_type = $request->report_type;
            $month = $request->month;
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $period = "";
            if( $report_type == 1 ) {
                $period = date("M-Y", strtotime($month."01"));
            } else {
                if( $start_date == $end_date ) {
                    $period = date("d-M-Y", strtotime($start_date));
                } else {
                    $period = date("d-M-Y", strtotime($start_date)) . " - " . date("d-M-Y", strtotime($end_date));
                }
            }

            $filename = "Sales Ticket Period " . $period . "_" . date("YmdHis");
            $pdf = PDF::loadView('report.print', compact('invoices', 'period'))->setPaper('a4', 'landscape');
            return $pdf->download($filename.'-report.pdf');
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function hotel()
    {
        $invoices = Hotel_invoice::selectRaw("DISTINCT DATE_FORMAT(created_at,'%Y%m') AS monthlydate")->get()->sortBy('monthlydate')->toArray();
        $months = $this->monthName;
        return view('report.hotel', compact('invoices', 'months'));
    }

    public function generateHotelReport(Request $request)
    {
        $validationRule = ['report_type' => 'required|integer'];

        if( $request->report_type == 1 ) {
            $validationRule['month'] = 'required|integer';
        } else {
            $validationRule['start_date'] = 'required|date';
            $validationRule['end_date'] = 'required|date';
        }

        $this->validate($request, $validationRule);

        try {
            $field = ["hotel_voucher_rooms.hotel_voucher_id", "hotel_voucher_rooms.check_in", "hotel_voucher_rooms.check_out", "hotel_voucher_rooms.room_id", "hotel_voucher_rooms.room_no", "hotel_voucher_rooms.meal_type", "hotel_voucher_rooms.use_allotment", "hotels.hotel_name", "hotel_vouchers.voucher_no", "hotel_invoices.invoiceno", "hotel_invoices.created_at", "hotel_voucher_guests.adult", "hotel_voucher_guests.children", "hotel_rates.room_name", "hotel_rates.weekday_price", "hotel_rates.weekday_nta", "hotel_rates.weekend_price", "hotel_rates.weekend_nta", "hotel_invoices.discount"];
            $invoices;

            if( $request->report_type == 1 ) {
                $invoices = DB::table('hotel_voucher_rooms')->select($field)
                            ->joinSub("SELECT hotel_voucher_room_id, SUM( CASE WHEN guest_type = 'adult' THEN 1 ELSE 0 END ) AS adult, SUM( CASE WHEN guest_type = 'children' THEN 1 ELSE 0 END ) AS children FROM hotel_voucher_guests GROUP BY hotel_voucher_room_id", 'hotel_voucher_guests', 'hotel_voucher_rooms.id', '=', 'hotel_voucher_guests.hotel_voucher_room_id')
                            ->join('hotel_rates', 'hotel_voucher_rooms.room_id', '=', 'hotel_rates.id')
                            ->join('hotels', 'hotel_voucher_rooms.hotel_id', '=', 'hotels.id')
                            ->join('hotel_vouchers', 'hotel_voucher_rooms.hotel_voucher_id', '=', 'hotel_vouchers.id')
                            ->join('hotel_invoices', 'hotel_vouchers.booking_id', '=', 'hotel_invoices.id')
                            ->where(DB::raw("DATE_FORMAT(hotel_invoices.created_at,'%Y%m')"), $request->month)
                            ->get();
            } else {
                $invoices = DB::table('hotel_voucher_rooms')->select($field)
                            ->joinSub("SELECT hotel_voucher_room_id, SUM( CASE WHEN guest_type = 'adult' THEN 1 ELSE 0 END ) AS adult, SUM( CASE WHEN guest_type = 'children' THEN 1 ELSE 0 END ) AS children FROM hotel_voucher_guests GROUP BY hotel_voucher_room_id", 'hotel_voucher_guests', 'hotel_voucher_rooms.id', '=', 'hotel_voucher_guests.hotel_voucher_room_id')
                            ->join('hotel_rates', 'hotel_voucher_rooms.room_id', '=', 'hotel_rates.id')
                            ->join('hotels', 'hotel_voucher_rooms.hotel_id', '=', 'hotels.id')
                            ->join('hotel_vouchers', 'hotel_voucher_rooms.hotel_voucher_id', '=', 'hotel_vouchers.id')
                            ->join('hotel_invoices', 'hotel_vouchers.booking_id', '=', 'hotel_invoices.id')
                            ->where(DB::raw("DATE_FORMAT(hotel_invoices.created_at,'%Y%m%d')"), ">=", date("Ymd", strtotime($request->start_date)))
                            ->where(DB::raw("DATE_FORMAT(hotel_invoices.created_at,'%Y%m%d')"), "<=", date("Ymd", strtotime($request->end_date)))
                            ->get();
            }

            $report_type = $request->report_type;
            $month = $request->month;
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $period = "";
            if( $report_type == 1 ) {
                $period = date("M-Y", strtotime($month."01"));
            } else {
                if( $start_date == $end_date ) {
                    $period = date("d-M-Y", strtotime($start_date));
                } else {
                    $period = date("d-M-Y", strtotime($start_date)) . " - " . date("d-M-Y", strtotime($end_date));
                }
            }

            $filename = "Sales Hotel Period " . $period . "_" . date("YmdHis");
            $pdf = PDF::loadView('report.printhotel', compact('invoices', 'period'))->setPaper('a4', 'landscape');
            return $pdf->download($filename.'-report.pdf');
            // return view('report.printhotel', compact('invoices', 'period'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    
    public function piutang(Request $request)
    {
        $customers = Customer::orderBy('booker', 'ASC')->get();
        $bookerId = $request->input('customer_id');
    
        // Jika customer_id tidak diset, gunakan default sebagai null
        if (!$bookerId) {
            $bookerId = null;
        }
    
        // Total Belum Lunas untuk Booker Tertentu
        $totalBelumLunas = Invoice::when($bookerId, function ($query) use ($bookerId) {
            $query->where('customer_id', $bookerId);
        })
        ->where('status_pembayaran', 'Belum Lunas')
        ->sum('total');
    
        // Dapatkan informasi Booker berdasarkan ID
        $bookerInfo = Customer::find($bookerId);
    
        return view('report.piutang', compact('totalBelumLunas', 'bookerInfo', 'customers'));
    }

    
    /*public function piutang(Request $request)
    {
        $customers = Customer::orderBy('booker', 'ASC')->get();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $bookerId = $request->input('customer_id');

        // Jika tanggal tidak diset, gunakan default sebagai hari ini
        if (!$startDate || !$endDate) {
            $startDate = today()->format('Y-m-d');
            $endDate = today()->format('Y-m-d');
        }

        // Set waktu pada end_date hingga pukul 23:59:59
        $endDate .= ' 23:59:59';

        // Total Belum Lunas dalam Range Tanggal untuk Booker Tertentu
        $totalBelumLunasInRange = Invoice::whereBetween('created_at', [$startDate, $endDate])
            ->where('customer_id', $bookerId)
            ->where('status_pembayaran', 'Belum Lunas')
            ->sum('total');

        // Dapatkan informasi Booker berdasarkan ID
        $bookerInfo = Customer::find($bookerId);

        return view('report.piutang', compact('totalBelumLunasInRange', 'startDate', 'endDate', 'bookerInfo', 'customers'));
    }*/
    
   public function generatePiutang(Request $request)
{
    // Tambahkan validasi untuk customer_id
    $validationRule = [
        'customer_id' => 'required|integer|exists:customers,id',
    ];

    $this->validate($request, $validationRule);

    try {
        // Query untuk menghitung total piutang (Belum Lunas)
        $bookerId = $request->customer_id;
        $totalBelumLunas = Invoice::when($bookerId, function ($query) use ($bookerId) {
            $query->where('customer_id', $bookerId);
        })
        ->where('status_pembayaran', 'Belum Lunas')
        ->sum('total');

        // Query untuk mendapatkan data piutang (Belum Lunas)
        $field = ["invoices.*", "customers.booker", "invoice_details.pax_paid", "invoice_details.name"];

        $invoices = DB::table('invoice_details')->select($field)
            ->join('invoices', 'invoice_details.invoice_id', '=', 'invoices.id')
            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->join('passengers', 'invoice_details.id', '=', 'passengers.id')
            ->where('customers.id', $request->customer_id)
            ->get();

        return view('report.printpiutang', compact('invoices', 'totalBelumLunas'));
    } catch (\Exception $e) {
        return redirect()->back()->with(['error' => $e->getMessage()]);
    }
}


}
