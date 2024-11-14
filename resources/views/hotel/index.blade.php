@extends('master')

@section('konten')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <h3 class="card-title">Data Hotel</h3>
                            </div>
                            
                            <div class="col-md-9">
                                <a href="{{ url('/hotel/new') }}" class="btn btn-primary btn-sm float-right">Tambah Data Hotel</a>
                            </div>
                            <div class="right mb-3 mb-sm-0">
                            <form action="{{ url('/hotel') }}" method="GET" class="form-inline">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari Nama Hotel"
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
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Hotel</th>
                                    <th>Nama Hotel</th>
                                    <th>Region</th>
                                    <th>Address</th>
                                    <th>No Telp</th>
                                    <th>Fax</th>
                                    <th colspan="2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @forelse($hotels as $hotel)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $hotel->hotel_code }}</td>
                                    <td>{{ $hotel->hotel_name }}</td>
                                    <td>{{ $hotel->region }}</td>
                                    <td>{{ $hotel->address }}</td>
                                    <td>{{ $hotel->phone }}</td>
                                    <td>{{ $hotel->fax }}</td>
                                    <td class="actions">
                                        <form action="{{ url('/hotel/' . $hotel->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ url('/hotel/' . $hotel->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <button class="btn btn-danger btn-sm" onclick="return confirmDelete()">Hapus</button>
                                        </form>
                                    </td>
                                    <script>
                                        function confirmDelete() {
                                            return confirm("Apakah Anda yakin ingin menghapus data hotel ini?");
                                        }
                                    </script>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="5">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
<!-- Tampilkan Tombol Pagination -->
                        <div class="float-right">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link"
                                    href="{{ $hotels->url(1) }}">&lsaquo;&lsaquo;</a></li>

                            @php
                            $startPage = max(1, $hotels->currentPage() - 2);
                            $endPage = min($hotels->lastPage(), $hotels->currentPage() + 2);
                            @endphp

                            @if ($startPage > 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            @foreach (range($startPage, $endPage) as $page)
                            @if ($page == $hotels->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                            <li class="page-item"><a class="page-link"
                                    href="{{ $hotels->url($page) }}">{{ $page }}</a></li>
                            @endif
                            @endforeach

                            @if ($endPage < $hotels->lastPage())
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                                <li class="page-item"><a class="page-link"
                                        href="{{ $hotels->url($hotels->lastPage()) }}">&rsaquo;&rsaquo;</a></li>
                        </ul>
                    </div>
                    </div>
                    <style>
                    .actions {
                        white-space: nowrap; /* Mencegah teks pindah ke baris baru */
                    }
                    </style>
                </div>
            </div>
        </div>
    </div>
@endsection