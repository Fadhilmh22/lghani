@extends('master')

@section('konten')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ubah Data Pelanggan</h3>
                </div>
                <div class="card-body">
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ url('/customer/' . $customer->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="PUT" class="form-control">
                        <div class="form-group">
                            <label for="">Gender</label>
                            <input type="text" name="gender"
                                class="form-control {{ $errors->has('gendergender') ? 'is-invalid':'' }}"
                                value="{{ $customer->gender }}" placeholder="Masukkan Gender Pelanggan">
                            <p class="text-danger">{{ $errors->first('gender') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Booker</label>
                            <input type="text" name="booker"
                                class="form-control {{ $errors->has('booker') ? 'is-invalid':'' }}"
                                value="{{ $customer->booker }}" placeholder="Masukkan nama lengkap">
                            <p class="text-danger">{{ $errors->first('name') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Perusahaan</label>
                            <input type="text" name="company"
                                class="form-control {{ $errors->has('company') ? 'is-invalid':'' }}"
                                value="{{ $customer->company }}" placeholder="Masukkan nama perusahaan">
                            <p class="text-danger">{{ $errors->first('company') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="text" name="phone"
                                class="form-control {{ $errors->has('phone') ? 'is-invalid':'' }}"
                                value="{{ $customer->phone }}">
                            <p class="text-danger">{{ $errors->first('phone') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <input type="text" name="alamat"
                                class="form-control {{ $errors->has('alamat') ? 'is-invalid':'' }}"
                                value="{{ $customer->alamat }}" placeholder="Masukkan Alamat Pelanggan">
                            <p class="text-danger">{{ $errors->first('alamat') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" name="email"
                                class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}"
                                value="{{ $customer->email }}">
                            <p class="text-danger">{{ $errors->first('email') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Payment</label>
                            <select name="payment" class="form-control {{ $errors->has('payment') ? 'is-invalid':'' }}">
                                <option value="" disabled>Pilih Pembayaran Yang Akan Digunakan</option>
                                <option value="Cash" {{ $customer->payment === 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="Credit" {{ $customer->payment === 'Credit' ? 'selected' : '' }}>Credit
                                </option>
                            </select>
                            <p class="text-danger">{{ $errors->first('payment') }}</p>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-warning btn-sm">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection