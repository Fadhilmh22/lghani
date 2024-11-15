<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;

class HotelController extends Controller
{
    public function index(Request $request)
{
    $hotels = Hotel::orderBy('created_at', 'DESC');

    $search = $request->input('search');

    // Jika ada kriteria pencarian, tambahkan ke dalam query
    if ($search) {
        $hotels->where('hotel_name', 'like', "%$search%")
               ->orWhere('region', 'like', "%$search%");
    }

    // Ambil data dengan pagination
    $hotels = $hotels->paginate(10);

    return view('hotel.index', ['hotels' => $hotels, 'search' => $search]);
}


    public function create()
    {
        return view('hotel.add');
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'hotel_code' => 'required|nullable|string',
            'hotel_name' => 'required|nullable|string',
            'region' => 'nullable|string',
            'address' => 'required|nullable|string',
            'phone' => 'required|max:13',
            'fax' => 'nullable|string'
        ]);

        try {
            $hotel = Hotel::create([
                'hotel_code' => $request->hotel_code,
                'hotel_name' => $request->hotel_name,
                'region' => $request->region,
                'address' => $request->address,
                'phone' => $request->phone,
                'fax' => $request->fax
            ]);
            return redirect('/hotel')->with(['success' => '<strong>' . $hotel->hotel_name . '</strong>  telah berhasil ditambahkan']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $hotel = Hotel::find($id);
        return view('hotel.edit', compact('hotel'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'hotel_code' => 'nullable|string',
            'hotel_name' => 'nullable|string',
            'region' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'required|max:13',
            'fax' => 'nullable|string'
        ]);

        try {
            $hotel = Hotel::find($id);
            $hotel->update([
                'hotel_code' => $request->hotel_code,
                'hotel_name' => $request->hotel_name,
                'region' => $request->region,
                'address' => $request->address,
                'phone' => $request->phone,
                'fax' => $request->fax
            ]);
            return redirect('/hotel')->with(['success' =>  '<strong>' . $hotel->hotel_name . '</strong>  telah berhasil diperbaharui']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $hotel = Hotel::find($id);
        $hotel->delete();
        return redirect()->back()->with(['success' => '<strong>' . $hotel->hotel_name . '</strong> telah berhasil dihapus']);
    }
}
