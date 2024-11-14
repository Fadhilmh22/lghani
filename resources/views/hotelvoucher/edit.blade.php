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
                    <h3 class="card-title">Create Hotel Voucher</h3>
                </div>
                <div class="card-body">
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form id="form-data" action="{{ route('hotelvoucher.update', ['id' => $voucher->id]) }}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="PUT" class="form-control">
                        <div class="panel panel-default">
                            <div class="panel-heading">Invoice Detail</div>
                            <div class="panel-body">
                                <div class="form-group">
                                  
                                    <label for="">Customer</label>
                                    <select name="customer_id" class="form-control select2 {{ $errors->has('customer_id') ? 'is-invalid':'' }}" required>
                                        <option value="">Pilih</option>
                                        @foreach ($customers as $customer) 
                                        <option value="{{ $customer->id }}" @if( !empty($invoice) && $invoice->customer_id == $customer->id ) echo selected="selected" @endif>{{ $customer->gender }} - {{ $customer->booker }} - {{ $customer->company }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger">{{ $errors->first('customer_id') }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Due Date Hotel</label>
                                    <input type="date" id="hotel_due_date" name="hotel_due_date" class="form-control" required value="{{ !empty($invoice) ? $invoice->hotel_due_date : '' }}">
                                    <p class="text-danger" id="error-hotel_due_date"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Date Payment</label>
                                    <input type="date" id="payment_date" name="payment_date" class="form-control" required value="{{ !empty($invoice) ? $invoice->payment_date : '' }}">
                                    <p class="text-danger" id="payment_date-error"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Office Code</label>
                                    <input type="text" id="office_code" name="office_code" class="form-control" placeholder="Office Code" required value="{{ !empty($invoice) ? $invoice->office_code : '' }}">
                                    <p class="text-danger" id="office_code-error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Booker Detail</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="">Currency</label>
                                    <select id="currency" name="currency" class="form-control" required>
                                        <option value="">Pilih</option>
                                        @foreach ($currencys as $currCode => $currName) 
                                            <option value="{{ $currCode }}" @if( $currCode == $voucher->currency ) echo selected="selected" @endif>{{ $currName }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger" id="currency-error"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Booker</label>
                                    <input type="text" id="booker" name="booker" class="form-control" placeholder="Masukkan Nama Booker" value="{{ $voucher->booker }}" required>
                                    <p class="text-danger" id="booker-error"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Booker Agent</label>
                                    <input type="text" id="booker_agent" name="booker_agent" class="form-control" placeholder="Masukkan Booker Agent" value="{{ $voucher->booker_agent }}">
                                </div>
                                <div class="form-group">
                                    <label for="">No Booker Agent</label>
                                    <input type="text" id="no_booker_agent" name="no_booker_agent" class="form-control" placeholder="Masukkan No Booker Agent" value="{{ $voucher->no_booker_agent }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Nationality</label>
                                    <input type="text" id="nationality" name="nationality" class="form-control" placeholder="Masukkan Nationality" value="{{ $voucher->nationality }}" required>
                                    <p class="text-danger" id="error-nationality"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Attention</label>
                                    <input type="text" id="attention" name="attention" class="form-control" placeholder="Attention" value="{{ $voucher->attention }}">
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Hotel Detail</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="">Hotel</label>
                                    <select id="hotel_id" name="hotel_id" class="form-control" required>
                                        <option value="">Pilih</option>
                                        @foreach ($hotels as $hotel) 
                                            <option value="{{ $hotel->id }}" data-code="{{ $hotel->hotel_code }}" data-region="{{ $hotel->region }}"  @if( $hotel->id == $voucher->hotel_id ) echo selected="selected" @endif>{{ $hotel->hotel_code }} - {{ $hotel->hotel_name }} @if ($hotel->region != '') | Region {{ $hotel->region }} @endif</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger" id="error-hotel_id"></p>
                                    <input type="hidden" id="hotel_code" name="hotel_code">
                                    <input type="hidden" id="reset_room_and_guest" name="reset_room_and_guest" value="0">
                                </div>
                                <div class="form-group">
                                    <label for="">Region</label>
                                    <input type="text" id="region" name="region" class="form-control" placeholder="" readonly="readonly">
                                </div>
                                <div class="form-group">
                                    <label>Check In</label>
                                    <input type="date" id="check_in" name="check_in" class="form-control" value="{{ $voucher->check_in }}" required>
                                    <p class="text-danger" id="error-check_in"></p>
                                </div>
                                <div class="form-group">
                                    <label>Check Out</label>
                                    <input type="date" id="check_out" name="check_out" class="form-control" value="{{ $voucher->check_out }}" required>
                                    <p class="text-danger" id="error-check_out"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Confirm By</label>
                                    <input type="text" id="confirm_by" name="confirm_by" class="form-control" placeholder="Confirm By" value="{{ $voucher->confirm_by }}" required>
                                    <p class="text-danger" id="error-confirm_by"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Remark</label>
                                    <input type="text" id="remark" name="remark" class="form-control" placeholder="Remark" value="{{ $voucher->remark }}">
                                    <p class="text-danger" id="error-remark"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">RSVN And Payment By</label>
                                    <input type="text" id="rsvn_and_payment_by" name="rsvn_and_payment_by" class="form-control" placeholder="RSVN And Payment By" value="{{ $voucher->rsvn_and_payment_by }}" required>
                                    <p class="text-danger" id="error-rsvn_and_payment_by"></p>
                                </div>
                                <div class="form-group" style="display: none">
                                    <label>How Many Type Room</label>
                                    <input type="number" id="count_type_room" name="count_type_room" class="form-control" placeholder="How Many Type Room" min="1" value="{{ $voucher->count_type_room }}" required>
                                    <p class="text-danger" id="error-count_type_room"></p>
                                </div>
                            </div>
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
<script type="text/javascript">
        
    $('#hotel_id').change(function(e) {
        var id = $(this).val();
        
        var confirmed = true;
        if( e.originalEvent && id != {{ $voucher->hotel_id }}  ) {
            if( confirm("Aksi ini akan menghapus data room dan guest sebelumnya. Lanjutkan?") ) {
                confirmed = true;
            } else {
                confirmed = false;
                $('#reset_room_and_guest').val(1);
                $('#hotel_id').val({{ $voucher->hotel_id }});
                $('#hotel_id').trigger('change');
            }
        } else {
            $('#reset_room_and_guest').val(0);
        }
        
        if( confirmed ) {
            var region = $(this).find('option[value='+ id +']').attr('data-region');
            var code = $(this).find('option[value='+ id +']').attr('data-code');
            $('#region').val(region);
            $('#hotel_code').val(code);
        }
    })

    $('#check_in,#check_out').change(function() {
        if( $('#check_in').val() != '' && $('#check_out').val() != '' ) {
            var check_in = new Date( $('#check_in').val() );
            var check_out = new Date( $('#check_out').val() );
            var daysDiff = Math.round((check_out.getTime() - check_in.getTime()) / (24 * 60 * 60 * 1000));

            if( daysDiff < 1 ) {
                $('#check_in').val('');
                $('#check_out').val('');
                alert("Tanggal check in - check out tidak valid");
            }
        }
    })
    
    $('#hotel_id').trigger('change');
    $('#check_out').trigger('change');
</script>
@endsection