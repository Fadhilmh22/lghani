<!-- resources/views/piutang.blade.php -->

@extends('master')

@section('konten')
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
            <div class="container mt-4">
            <h3 class="card-title">Total Belum Lunas</h3>
            <div class="row mt-4 custom-padding">
            <div class="col-md-12">
            <form action="{{ url('/report/piutang') }}" method="GET" class="form-inline">
                @csrf
                <div class="form-row align-items-center">
                    <div class="form-group col-md-4">
                                <select name="customer_id" class="form-control select2 {{ $errors->has('customer_id') ? 'is-invalid':'' }}" required>
                                        <option value="">Pilih</option>
                                        @foreach ($customers as $customer) 
                                        <option value="{{ $customer->id }}" @if( !empty($invoice) && $invoice->customer_id == $customer->id ) echo selected="selected" @endif>{{ $customer->booker }} - {{ $customer->company }}</option>
                                        @endforeach
                                </select>
                                <p class="text-danger">{{ $errors->first('customer_id') }}</p>
                            </div>
                            <div class="form-group col-md-10">
                                <button class="btn btn-primary btn-sm">Submit</button>
                                <a href="javascript:void(0);" class="btn btn-success btn-sm btn-print">Print</a>
                            </div>
                        </form>
                        </div>
                        </div>
                        
                        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h5><b>Total Belum Lunas</b></h5>
                    <p>Rp {{ number_format($totalBelumLunas) }}</p>
                </div>
            </div>
        </div>     <!-- Tambahkan logika atau tampilan lain sesuai kebutuhan -->
</div>
<script>
    function printInvoice() {
        // Mendapatkan id pelanggan dari dropdown
        var selectedCustomerId = $('select[name="customer_id"]').val();

        // Cek apakah pelanggan sudah dipilih
        if (!selectedCustomerId) {
            alert('Pilih pelanggan terlebih dahulu');
            return;
        }

        // Membuat URL untuk print hanya invoice pelanggan yang dipilih
        var printUrl = "{{ url('/report/printpiutang') }}" + "?customer_id=" + selectedCustomerId;

        // Membuka tab baru dengan URL print yang sesuai
        window.open(printUrl, '_blank');
    }
</script>


<script type="text/javascript">
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2();
        
    $('.btn-print').click(function() {
            printInvoice();
        });
    });
</script>
@endsection
