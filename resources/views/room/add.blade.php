@extends('master')

@section('konten')
<div class="container" style="font-family: 'poppins', sans-serif;">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Data Kamar</h3>
                </div>
                <div class="card-body">
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ url('/room') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Hotel</label>
                            <select name="hotel_id" class="form-control {{ $errors->has('hotel_id') ? 'is-invalid':'' }}" required>
                                <option value="">Pilih</option>
                                @foreach ($hotels as $hotel) 
                                    <option value="{{ $hotel->id }}">{{ $hotel->hotel_name }} @if ($hotel->region != '') | Region {{ $hotel->region }} @endif</option>
                                @endforeach
                            </select>
                            <p class="text-danger">{{ $errors->first('hotel_id') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Room Code</label>
                            <input type="text" name="room_code" class="form-control {{ $errors->has('room_code') ? 'is-invalid':'' }}" placeholder="Masukkan Kode Kamar">
                            <p class="text-danger">{{ $errors->first('room_code') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Room Name</label>
                            <input type="text" name="room_name" class="form-control {{ $errors->has('room_name') ? 'is-invalid':'' }}" placeholder="Masukkan Nama Kamar">
                            <p class="text-danger">{{ $errors->first('room_name') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Room Type</label>
                            <input type="text" name="room_type" class="form-control {{ $errors->has('room_type') ? 'is-invalid':'' }}" placeholder="Masukkan Tipe Kamar">
                            <p class="text-danger">{{ $errors->first('room_type') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Bed Type</label>
                            <input type="text" name="bed_type" class="form-control {{ $errors->has('bed_type') ? 'is-invalid':'' }}" placeholder="Masukkan Tipe Bed">
                            <p class="text-danger">{{ $errors->first('bed_type') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Weekday Price</label>
                            <input type="text" name="weekday_price" class="form-control {{ $errors->has('weekday_price') ? 'is-invalid':'' }}" placeholder="Masukkan Harga Weekday">
                            <p class="text-danger">{{ $errors->first('weekday_price') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Weekday NTA</label>
                            <input type="text" name="weekday_nta" class="form-control {{ $errors->has('weekday_nta') ? 'is-invalid':'' }}" placeholder="Masukkan NTA Weekday">
                            <p class="text-danger">{{ $errors->first('weekday_nta') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Weekend Price</label>
                            <input type="text" name="weekend_price" class="form-control {{ $errors->has('weekend_price') ? 'is-invalid':'' }}" placeholder="Masukkan Harga Weekend">
                            <p class="text-danger">{{ $errors->first('weekend_price') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Weekend NTA</label>
                            <input type="text" name="weekend_nta" class="form-control {{ $errors->has('weekend_nta') ? 'is-invalid':'' }}" placeholder="Masukkan NTA Weekend">
                            <p class="text-danger">{{ $errors->first('weekend_nta') }}</p>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection