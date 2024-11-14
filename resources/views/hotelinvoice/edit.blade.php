@extends('master')

@section('konten')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2();
    });
</script>
<style type="text/css">
    #sample-room,
    #sample-room-detail,
    #sample-guest {
        display: none !important;
    }
</style>
<div class="container" style="font-family: 'poppins', sans-serif;">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Hotel Invoice</h3>
                </div>
                <div class="card-body">
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form id="form-data" action="{{ route('hotelinvoice.update', ['id' => $invoice->id]) }}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="PUT" class="form-control">
                        <div class="form-group">
                            <label for="">Customer</label>
                                <select name="customer_id" class="form-control select2 {{ $errors->has('customer_id') ? 'is-invalid':'' }}" required>
                                <option value="">Pilih</option>
                                @foreach ($customers as $customer) 
                                <option value="{{ $customer->id }}" @if( $customer->id == $invoice->customer_id ) echo selected="selected" @endif>{{ $customer->gender }} - {{ $customer->booker }} - {{ $customer->company }}</option>
                                @endforeach
                            </select>
                            <p class="text-danger">{{ $errors->first('customer_id') }}</p>
                        </div>
                        <div class="form-group">
                            <label>Due Date Hotel</label>
                            <input type="date" id="hotel_due_date" name="hotel_due_date" class="form-control" value="{{ $invoice->hotel_due_date }}" required>
                            <p class="text-danger" id="error-hotel_due_date"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Date Payment</label>
                            <input type="date" id="payment_date" name="payment_date" class="form-control" value="{{ $invoice->payment_date }}" required>
                            <p class="text-danger" id="payment_date-error"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Office Code</label>
                            <input type="text" id="office_code" name="office_code" class="form-control" value="{{ $invoice->office_code }}" placeholder="Office Code" required>
                            <p class="text-danger" id="office_code-error"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Diskon</label>
                            <input type="text" id="discount" name="discount" class="form-control" value="{{ isset($invoice) ? $invoice->discount : '' }}" placeholder="Diskon" required>
                            <p class="text-danger" id="discount-error"></p>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-sm" id="btnSave">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection