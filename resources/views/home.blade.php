@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="custom-padding">Selamat Datang, <b>{{ Auth::user()->name }}</b>. Anda Login
        sebagai <b>{{ Auth::user()->role }}</b>.
    </h4>
    @if (auth()->user()->role=="Owner")
    <div class="row mt-4 custom-padding">
        <div class="col-md-12">
            <form action="{{ route('home') }}" method="GET" class="form-inline">
                <div class="form-row align-items-center">
                    <div class="form-group col-md-3">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ $startDate }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                    </div>
                    <div class="form-group col-md-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h5><b>Total Invoice</b></h5>
                    <p>{{ $totalInvoiceInRange }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h5><b>Total Penjualan</b></h5>
                    <p>Rp{{ number_format( $totalPenjualanInRange) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h5><b>Total Penjualan Bulan Ini</b></h5>
                    <p>Rp{{ number_format($totalPenjualanBulanIni) }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="text-center mt-4">
        <img src="lghani.png" class="d-block w-100" alt="" width="850px" height="350px">
    </div>
</div>

<style>
.custom-padding {
    padding-bottom: 30px;
    /* Sesuaikan nilai sesuai kebutuhan */
}
</style>
@endsection