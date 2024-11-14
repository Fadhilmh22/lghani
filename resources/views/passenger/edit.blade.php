@extends('master')

@section('konten')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Data Penumpang</h3>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif

                        <form action="{{ url('/passenger/' . $passenger->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" class="form-control">
                            <div class="form-group">
                                <label for="">Nama Penumpang</label>
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" value="{{ $passenger->name }}" placeholder="Masukkan Nama Lengkap">
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">ID Card</label>
                                <input type="text" name="id_card" class="form-control {{ $errors->has('id_card') ? 'is-invalid':'' }}" value="{{ $passenger->id_card }}" placeholder="Masukkan No KTP">
                                <p class="text-danger">{{ $errors->first('id_card') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Date Birth</label>
                                <input type="date" name="date_birth" class="form-control {{ $errors->has('date_birth') ? 'is-invalid':'' }}" value="{{ $passenger->date_birth }}" placeholder="Masukkan Nama Lengkap">
                                <p class="text-danger">{{ $errors->first('date_birth') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Garuda Frequent Flyer</label>
                                <input type="text" name="gff" class="form-control {{ $errors->has('gff') ? 'is-invalid':'' }}" value="{{ $passenger->gff }}" placeholder="Masukkan No GFF">
                                <p class="text-danger">{{ $errors->first('gff') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Phone</label>
                                <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid':'' }}" value="{{ $passenger->phone }}">
                                <p class="text-danger">{{ $errors->first('phone') }}</p>
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