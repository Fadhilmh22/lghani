@extends('master')

@section('konten')
<div class="container">
    <div class="row">
        <div class="col-md-20">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title"> List Penumpang</h3>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ url('/passenger/new') }}" class="btn btn-primary btn-sm float-right">Tambah Data
                                Penumpang</a>
                        </div>
                        <div class="right mb-3 mb-sm-0">
                            <form action="{{ url('/passenger') }}" method="GET" class="form-inline">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari nama penumpang"
                                        name="search">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {!! session('success') !!}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {!! session('error') !!}
                    </div>
                    @endif
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Penumpang</th>
                                <th>ID Card</th>
                                <th>Date Birth</th>
                                <th>Garuda Frequent Flyer</th>
                                <th>No Telp</th>
                                <th colspan="2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($passengers as $passenger)
                            <tr>
                                <td>{{ $passenger->id }}</td>
                                <td class="uppercase-text">{{ $passenger->name }}</td>
                                <td>{{ $passenger->id_card }}</td>
                                <td>{{ \Carbon\Carbon::parse($passenger->date_birth)->format('d-m-Y') }}</td>
                                <td>{{ $passenger->gff }}</td>
                                <td>{{ $passenger->phone }}</td>
                                <td>
                                    <form action="{{ url('/passenger/' . $passenger->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ url('/passenger/' . $passenger->id) }}"
                                            class="btn btn-warning btn-sm">Ubah</a>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirmDelete()">Hapus</button>
                                    </form>
                                </td>
                                <script>
                                function confirmDelete() {
                                    return confirm("Apakah Anda yakin ingin menghapus pelanggan ini?");
                                }
                                </script>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="7">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="float-right">
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="{{ $passengers->url(1) }}">&lsaquo;&lsaquo;</a></li>
        
        @php
        $startPage = max(1, $passengers->currentPage() - 2);
        $endPage = min($passengers->lastPage(), $passengers->currentPage() + 2);
        @endphp

        @if ($startPage > 1)
        <li class="page-item disabled"><span class="page-link">...</span></li>
        @endif

        @foreach (range($startPage, $endPage) as $page)
        @if ($page == $passengers->currentPage())
        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
        @else
        <li class="page-item"><a class="page-link" href="{{ $passengers->url($page) }}">{{ $page }}</a></li>
        @endif
        @endforeach

        @if ($endPage < $passengers->lastPage())
        <li class="page-item disabled"><span class="page-link">...</span></li>
        @endif

        <li class="page-item"><a class="page-link" href="{{ $passengers->url($passengers->lastPage()) }}">&rsaquo;&rsaquo;</a></li>
    </ul>
</div>




                </div>
            </div>
        </div>
    </div>
</div>
<style>
.uppercase-text {
                        text-transform: uppercase;
                    }

.right {

    float: right;

}

.left {

    float: left;

}
</style>
@endsection