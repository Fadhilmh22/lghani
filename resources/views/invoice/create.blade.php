@extends('master')

@section('konten')
    <script type="text/javascript" src="{{ asset('js/datepicker.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Buat Invoice</h3>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('invoice.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Pelanggan</label>
                                <select name="customer_id" class="form-control select2 {{ $errors->has('customer_id') ? 'is-invalid':'' }}" required>
                                    <option value="">Pilih</option>
                                    @foreach ($customers as $customer) 
                                    <option value="{{ $customer->id }}">{{ $customer->gender }} - {{ $customer->booker }} - {{ $customer->company }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger">{{ $errors->first('customer_id') }}</p>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-sm">Buat</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2();

            $('[name=depart_date]').datepicker({
                format: 'dd-mm-yyyy',
                startDate: new Date()
            });

            $('[name=return_date]').datepicker({
                format: 'dd-mm-yyyy',
                startDate: new Date()
            });
        });
    </script>
@endsection
