@extends('master')

@section('konten')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Manajemen Maskapai</h3>
                        </div>
                        <div class="col-md-7">
                            <a href="{{ url('/airline/new') }}" class="btn btn-primary btn-sm float-right">Tambah
                                Maskapai</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {!! session('success') !!}
                    </div>
                    @endif
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Maskapai </th>
                                <th>Nama Maskapai</th>
                                <th>Tanggal Pembuatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($airlines as $airline)
                            <tr>
                                <td>{{ $airline->airlines_code }}</td>
                                <td class="uppercase-text">{{ $airline->airlines_name }}</td>
                                <td>{{ $airline->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <form action="{{ url('/airline/' . $airline->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="_method" value="DELETE" class="form-control">
                                        <a href="{{ url('/airline/' . $airline->id) }}"
                                            class="btn btn-warning btn-sm">Ubah</a>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirmDelete()">Hapus</button>
                                    </form>
                                </td>
                                <script>
                                function confirmDelete() {
                                    return confirm("Apakah Anda yakin ingin menghapus maskapai ini?");
                                }
                                </script>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="6">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <style>
                    .uppercase-text {
                        text-transform: uppercase;
                    }
                    </style>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection