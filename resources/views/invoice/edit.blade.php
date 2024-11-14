@extends('master')

@section('konten')
<style type="text/css">
.mb-0 {
    margin-bottom: 0;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-16">
            <div class="card">
                <div class="card-body">
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-16">
                            <form action="{{ route('invoice.update', ['id' => $invoice->id]) }}" method="post">
                                @csrf
                                <input type="hidden" name="_method" value="PUT" class="form-control">
                                <div class="row">
                                    <div class="col-md-3 form-group mb-0">
                                        <label for="">Gender</label>
                                        <input type="text" name="genre"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}"
                                            value="{{ old('gender') }}">
                                        <p class="text-danger">{{ $errors->first('gender') }}</p>
                                    </div>
                                    <div class="col-md-3 form-group mb-0">
                                        <label>Name</label>
                                        <input type="text" name="name"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}"
                                            value="{{ old('name') }}">
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    </div>
                                    <div class="col-md-3 form-group mb-0">
                                        <label>Booking Code</label>
                                        <input type="text" name="booking_code"
                                            class="form-control {{ $errors->has('booking_code') ? 'is-invalid':'' }}"
                                            value="{{ old('booking_code') }}">
                                        <p class="text-danger">{{ $errors->first('booking_code') }}</p>
                                    </div>
                                    <div class="col-md-3 form-group mb-0">
                                        <label>Airlines Code</label>
                                        <select name="airline_id" class="form-control">
                                            <option value="">Select Airline</option>
                                            @foreach ($airlines as $airline)
                                            <option value="{{ $airline->id }}">{{ $airline->airlines_code }} -
                                                {{ $airline->airlines_name }}</option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger">{{ $errors->first('airlines_id') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 form-group mb-0">
                                        <label>Airlines No</label>
                                        <input type="text" name="airlines_no"
                                            class="form-control {{ $errors->has('airlines_no') ? 'is-invalid':'' }}"
                                            value="{{ old('airlines_no') }}">
                                        <p class="text-danger">{{ $errors->first('airlines_no') }}</p>
                                    </div>
                                    <div class="col-md-3 form-group mb-0">
                                        <label>Class</label>
                                        <input type="text" name="class"
                                            class="form-control {{ $errors->has('class') ? 'is-invalid':'' }}"
                                            value="{{ old('class') }}">
                                        <p class="text-danger">{{ $errors->first('class') }}</p>
                                    </div>
                                    <div class="col-md-3 form-group mb-0">
                                        <label>Ticket No</label>
                                        <input type="text" name="ticket_no" min="0" max="1000000000"
                                            class="form-control {{ $errors->has('ticket_no') ? 'is-invalid':'' }}"
                                            value="{{ old('ticket_no') }}">
                                        <p class="text-danger">{{ $errors->first('ticket_no') }}</p>
                                    </div>
                                    <div class="col-md-3 form-group mb-0">
                                        <label>Route</label>
                                        <input type="text" name="route"
                                            class="form-control {{ $errors->has('route') ? 'is-invalid':'' }}"
                                            value="{{ old('route') }}">
                                        <p class="text-danger">{{ $errors->first('route') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 form-group mb-0">
                                        <label>Depart Date</label>
                                        <input type="date" name="depart_date"
                                            class="form-control {{ $errors->has('depart_date') ? 'is-invalid':'' }}"
                                            value="{{ old('depart_date') }}">
                                        <p class="text-danger">{{ $errors->first('depart_date') }}</p>
                                    </div>
                                    <div class="col-md-3 form-group mb-0">
                                        <label>Return Date</label>
                                        <input type="date" name="return_date"
                                            class="form-control {{ $errors->has('return_date') ? 'is-invalid':'' }}"
                                            value="{{ old('return_date') }}">
                                        <p class="text-danger">{{ $errors->first('return_date') }}</p>
                                    </div>
                                    <div class="col-md-3 form-group mb-0">
                                        <label>Pax Paid</label>
                                        <input type="text" name="pax_paid" min="0"
                                            class="form-control {{ $errors->has('pax_paid') ? 'is-invalid':'' }}"
                                            value="{{ old('pax_paid') }}">
                                        <p class="text-danger">{{ $errors->first('pax_paid') }}</p>
                                    </div>
                                    <div class="col-md-3 form-group mb-0">
                                        <label>Price</label>
                                        <input type="text" name="price" min="0"
                                            class="form-control {{ $errors->has('price') ? 'is-invalid':'' }}"
                                            value="{{ old('price') }}">
                                        <p class="text-danger">{{ $errors->first('price') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 form-group mb-0">
                                        <label>Discount</label>
                                        <input type="text" name="discount" min="0"
                                            class="form-control {{ $errors->has('discount') ? 'is-invalid':'' }}"
                                            value="{{ old('discount') }}">
                                        <p class="text-danger">{{ $errors->first('discount') }}</p>
                                    </div>
                                    <div class="col-md-3 form-group mb-0">
                                        <label>NTA</label>
                                        <input type="text" name="nta" min="0"
                                            class="form-control {{ $errors->has('nta') ? 'is-invalid':'' }}"
                                            value="{{ old('nta') }}">
                                        <p class="text-danger">{{ $errors->first('nta') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group mb-0">
                                        <button id="addBtn" class="btn btn-success btn-sm">Tambah</button>
                                        <button name="redirect" value="true" class="btn btn-primary btn-sm">Simpan</button>
                                        <button id="update-button" class="btn btn-warning btn-sm" style="display: none;">Ubah</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-16">
                            <div class="text-center">
                                <img src="{{ asset('lghani.png') }}" alt="" width="350px" height="150px">
                            </div>
                        </div>
                        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <td width="30%">Nama Booker</td>
                                    <td>:</td>
                                    <td>{{ $invoice->customer->booker }}</td>
                                </tr>
                                <tr>
                                    <td>No Telp</td>
                                    <td>:</td>
                                    <td>{{ $invoice->customer->phone }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td>{{ $invoice->customer->email }}</td>
                                </tr>
                                <tr>
                                    <td>Payment</td>
                                    <td>:</td>
                                    <td>{{ $invoice->customer->payment }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table style="float: right;">
                                <tr>
                                    <td>Perusahaan</td>
                                    <td>:</td>
                                    <td>Lghani Tour & Travel</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>: </td>
                                    <td>Komplek permata 2 blok M6 No 2, Tanimulya, Ngamprah</td>
                                </tr>
                                <tr>
                                    <td>No Telp</td>
                                    <td>:</td>
                                    <td>+62 856-2151-280</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td>lghani_travel@ymail.com</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-16">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Gender</td>
                                        <td>Name</td>
                                        <td>Booking Code</td>
                                        <td>Airlines Code</td>
                                        <td>Airlines No</td>
                                        <td>Class</td>
                                        <td>Ticket No</td>
                                        <td>Route</td>
                                        <td>Depart Date</td>
                                        <td>Return Date</td>
                                        <td>Pax Paid</td>
                                        <td>Price</td>
                                        <td>Discount</td>
                                        <td>NTA</td>
                                        <td>Profit</td>
                                        <th colspan="2" style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 1;
                                    $totalPaxPaid = 0;
                                    @endphp
                                    @foreach ($invoice->detail as $detail)
                                    @php $totalPaxPaid += $detail->pax_paid; @endphp
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $detail->genre }}</td>
                                        <td>{{ $detail->name }}</td>
                                        <td>{{ $detail->booking_code }}</td>
                                        <td>{{ $comboAirline[ $detail->airline_id ]['airlines_code'] }}</td>
                                        <td>{{ $detail->airlines_no }}</td>
                                        <td>{{ $detail->class }}</td>
                                        <td>{{ $detail->ticket_no }}</td>
                                        <td>{{ $detail->route }}</td>
                                        <td>{{ $detail->depart_date }}</td>
                                        <td>{{ $detail->return_date }}</td>
                                        <td>Rp {{ number_format ($detail->pax_paid) }}</td>
                                        <td>Rp {{ number_format($detail->price) }}</td>
                                        <td>Rp {{ number_format($detail->discount) }}</td>
                                        <td>Rp {{ number_format($detail->nta) }}</td>
                                        <td>Rp {{ number_format($detail->profit) }}</td>
                                        <td>
                                            <a href="#" class="btn btn-warning btn-sm edit-button"
                                                data-genre="{{ $detail->genre }}" data-name="{{ $detail->name }}"
                                                data-booking-code="{{ $detail->booking_code }}"
                                                data-airline-id="{{ $detail->airline_id }}"
                                                data-airlines-no="{{ $detail->airlines_no }}"
                                                data-class="{{ $detail->class }}"
                                                data-ticket-no="{{ $detail->ticket_no }}"
                                                data-route="{{ $detail->route }}"
                                                data-depart-date="{{ $detail->depart_date }}"
                                                data-return-date="{{ $detail->return_date }}"
                                                data-pax-paid="{{ $detail->pax_paid }}"
                                                data-price="{{ $detail->price }}"
                                                data-discount="{{ $detail->discount }}" data-nta="{{ $detail->nta }}"
                                                data-profit="{{ $detail->profit }}">Ubah</a>
                                        </td>
                                        <td>
                                            <form action="{{ route('invoice.delete_product', ['id' => $detail->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="_method" value="DELETE" class="form-control">
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="return confirmDelete()">Hapus</button>
                                            </form>
                                            <script>
                                            function confirmDelete() {
                                                return confirm("Apakah Anda yakin ingin menghapus data ini?");
                                            }
                                            </script>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4 offset-md-8">
                            <table class="table table-hover table-bordered">

                                <tr>
                                    <td>Total</td>
                                    <td>:</td>
                                    <td>Rp {{ number_format($totalPaxPaid) }}</td>
                                </tr>
                            </table>
                            
                            <script>
                                function saveAndRedirect(e) {
                                    const btn = document.query('#addBtn');
                                    console.log(btn)
                                }
                            $(document).ready(function() {
                                // Menangani klik tombol Edit
                                $(".edit-button").click(function() {
                                    // Mendapatkan data dari data-attributes
                                    var genre = $(this).data("genre");
                                    var name = $(this).data("name");
                                    var bookingCode = $(this).data("booking-code");
                                    var airlineId = $(this).data("airline-id");
                                    var airlinesNo = $(this).data("airlines-no");
                                    var classVal = $(this).data("class");
                                    var ticketNo = $(this).data("ticket-no");
                                    var route = $(this).data("route");
                                    var departDate = $(this).data("depart-date");
                                    var returnDate = $(this).data("return-date");
                                    var paxPaid = $(this).data("pax-paid");
                                    var price = $(this).data("price");
                                    var discount = $(this).data("discount");
                                    var nta = $(this).data("nta");
                                    var profit = $(this).data("profit");

                                    // Mengisi kolom input dengan data yang diambil
                                    $("input[name='genre']").val(genre);
                                    $("input[name='name']").val(name);
                                    $("input[name='booking_code']").val(bookingCode);
                                    $("select[name='airline_id']").val(
                                        airlineId); // Memilih opsi di select
                                    $("input[name='airlines_no']").val(airlinesNo);
                                    $("input[name='class']").val(classVal);
                                    $("input[name='ticket_no']").val(ticketNo);
                                    $("input[name='route']").val(route);
                                    $("input[name='depart_date']").val(departDate);
                                    $("input[name='return_date']").val(returnDate);
                                    $("input[name='pax_paid']").val(paxPaid);
                                    $("input[name='price']").val(price);
                                    $("input[name='discount']").val(discount);
                                    $("input[name='nta']").val(nta);
                                    $("input[name='profit']").val(profit);
                                });
                            });
                            </script>
                           ...
<script>
$(document).ready(function() {
    // Menangani klik tombol Edit
    $(".edit-button").click(function() {
        // ... (Kode lainnya untuk mengisi kolom input)
    
        // Mengganti tombol "Tambah" menjadi tombol "Update"
        $("#update-button").css("display", "inline-block");
    
        isEditing = true; // Menandai bahwa sedang dalam mode pengeditan
    });
    
    // Menangani klik tombol Update
    $("#update-button").click(function() {
        // ... (Kode lainnya untuk mengambil data input dan mengirimkannya ke server)
    
        // Setelah mengirim data ke server dan berhasil diupdate
        // Mengganti tombol "Update" menjadi tombol "Tambah" kembali
        $("#tambah-button").show();
        $("#update-button").hide();
    
        // Menandai bahwa sudah selesai mengedit
        isEditing = false;
    });
    // Menangani klik tombol Tambah (untuk mode penambahan data)
    $("#tambah-button").click(function() {
        if (!isEditing) {
            // ... (Kode lainnya untuk menambah data baru)

            // Setelah berhasil menambah data
            // Reset kolom input dan tampilkan tombol "Tambah" lagi
            $("input[name='genre']").val('');
            $("input[name='name']").val('');
            // ... (Reset kolom input lainnya)

            $("#tambah-button").show();
        }
    });
});
</script>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection