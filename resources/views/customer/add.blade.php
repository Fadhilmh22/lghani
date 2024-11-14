@extends('master')

@section('konten')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Data Pelanggan</h3>
                </div>
                <div class="card-body">
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ url('/customer') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Gender</label>
                            <input type="text" name="gender" class="form-control {{ $errors->has('gender') ? 'is-invalid':'' }}" placeholder="Masukkan Gender Pelanggan">
                            <p class="text-danger">{{ $errors->first('gender') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Booker</label>
                            <input type="text" name="booker" class="form-control {{ $errors->has('booker') ? 'is-invalid':'' }}" placeholder="Masukkan Nama Lengkap">
                            <p class="text-danger">{{ $errors->first('booker') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Perusahaan</label>
                            <input type="text" name="company" class="form-control {{ $errors->has('company') ? 'is-invalid':'' }}" placeholder="Masukkan Nama Perusahaan">
                            <p class="text-danger">{{ $errors->first('company') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid':'' }}" placeholder="Masukkan Nomor Telepon (Maks. 13 angka)">
                            <p class="text-danger">{{ $errors->first('phone') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <input type="text" name="alamat" class="form-control {{ $errors->has('alamat') ? 'is-invalid':'' }}" placeholder="Masukkan Alamat Pelanggan">
                            <p class="text-danger">{{ $errors->first('alamat') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" placeholder="Masukkan Email Booker">
                            <p class="text-danger">{{ $errors->first('email') }}</p>
                        </div>

                        <div class="form-group">
                            <label for="">Payment</label>
                            <select name="payment" class="form-control {{ $errors->has('currency') ? 'is-invalid':'' }}" placeholder="Pilih Pembayaran Yang Akan Digunakan">
                                <option value="" disabled selected>Pilih Pembayaran Yang Akan Digunakan</option>
                                <option value="Cash">Cash</option>
                                <option value="Credit">Credit</option>
                            </select>                            
                            <p class="text-danger">{{ $errors->first('payment') }}</p>
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