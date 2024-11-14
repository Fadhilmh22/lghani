@extends('master')

@section('konten')
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

                    <form id="form-data" action="{{ route('hotelinvoice.save') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Customer</label>
                            <select name="customer_id" class="form-control {{ $errors->has('customer_id') ? 'is-invalid':'' }}" required>
                                <option value="">Pilih</option>
                                @foreach ($customers as $customer) 
                                <option value="{{ $customer->id }}">{{ $customer->booker }} - {{ $customer->email }}</option>
                                @endforeach
                            </select>
                            <p class="text-danger">{{ $errors->first('customer_id') }}</p>
                        </div>
                        <div class="form-group">
                            <label>Due Date Hotel</label>
                            <input type="date" id="hotel_due_date" name="hotel_due_date" class="form-control" required>
                            <p class="text-danger" id="error-hotel_due_date"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Date Payment</label>
                            <input type="date" id="payment_date" name="payment_date" class="form-control" required>
                            <p class="text-danger" id="payment_date-error"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Office Code</label>
                            <input type="text" id="office_code" name="office_code" class="form-control" placeholder="Office Code" required>
                            <p class="text-danger" id="office_code-error"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Discount</label>
                            <input type="text" id="discount" name="discount" class="form-control" placeholder="Discount" required>
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