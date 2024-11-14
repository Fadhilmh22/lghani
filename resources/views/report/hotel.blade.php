@extends('master')

@section('konten')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="card-title">Laporan Hotel</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('report.printhotel') }}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="GET" class="form-control">

                            <div class="form-group">
                                <label for="">Tipe Laporan</label>
                                <select name="report_type" id="report_type" class="form-control {{ $errors->has('report_type') ? 'is-invalid':'' }}" required>
                                    <option value="">Pilih</option>
                                    <option value="1" <?php if( old('report_type') == 1 ) echo 'selected=selected'; ?>>Bulanan</option>
                                    <option value="2" <?php if( old('report_type') == 2 ) echo 'selected=selected'; ?>>Periode Tanggal</option>
                                </select>
                                <p class="text-danger">{{ $errors->first('report_type') }}</p>
                            </div>
                            <div class="form-group" id="report_month" style="display: none;">
                                <label for="">Bulan</label>
                                <select name="month" class="form-control {{ $errors->has('month') ? 'is-invalid':'' }}">
                                    <option value="">Pilih</option>
                                    @foreach ($invoices as $invoice) 
                                    <option value="{{ $invoice['monthlydate'] }}">{{ $months[ intval(substr($invoice['monthlydate'], 4, 2)) - 1 ] }} - {{ substr($invoice['monthlydate'], 0, 4) }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger">{{ $errors->first('month') }}</p>
                            </div>
                            <div class="form-group" id="report_start_date" style="display: none;">
                                <label for="">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control {{ $errors->has('start_date') ? 'is-invalid':'' }}">
                                <p class="text-danger">{{ $errors->first('start_date') }}</p>
                            </div>
                            <div class="form-group" id="report_end_date" style="display: none;">
                                <label for="">Tanggal Mulai</label>
                                <input type="date" name="end_date" class="form-control {{ $errors->has('end_date') ? 'is-invalid':'' }}">
                                <p class="text-danger">{{ $errors->first('end_date') }}</p>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-sm">Print</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function reportTypeChange() {
            var value = document.getElementById("report_type").value;

            if( value == 1 ) {
                document.getElementById("report_month").style.display = 'block';
                document.getElementById("report_month").setAttribute('required', 'required');

                document.getElementById("report_start_date").style.display = 'none';
                document.getElementById("report_start_date").removeAttribute('required');
                document.getElementById("report_end_date").style.display = 'none';
                document.getElementById("report_end_date").removeAttribute('required');
            } else if( value == 2 ) {
                document.getElementById("report_month").style.display = 'none';
                document.getElementById("report_month").removeAttribute('required');

                document.getElementById("report_start_date").style.display = 'block';
                document.getElementById("report_start_date").setAttribute('required', 'required');
                document.getElementById("report_end_date").style.display = 'block';
                document.getElementById("report_end_date").setAttribute('required', 'required');
            } else {
                document.getElementById("report_month").style.display = 'none';
                document.getElementById("report_month").removeAttribute('required');
                document.getElementById("report_start_date").style.display = 'none';
                document.getElementById("report_start_date").removeAttribute('required');
                document.getElementById("report_end_date").style.display = 'none';
                document.getElementById("report_end_date").removeAttribute('required');
            }
        }

        document.getElementById("report_type").onchange = function() {
            reportTypeChange();
        };

        reportTypeChange();
    </script>
@endsection