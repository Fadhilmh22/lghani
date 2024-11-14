@extends('master')

@section('konten')
<div class="container">
    <div class="row">
        <div class="col-md-15">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="card-title">List Pelanggan</h3>
                        </div>
                        <div class="col-md-9">
                            <a href="{{ url('/customer/new') }}" class="btn btn-primary btn-sm float-right">Tambah
                                Pelanggan</a>
                        </div>
                        <div class="right mb-3 mb-sm-0">
                            <form action="{{ url('/customer') }}" method="GET" class="form-inline">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari nama pelanggan"
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
                                <th>Gender</th>
                                <th>Nama Booker</th>
                                <th>Nama Perusahaan</th>
                                <th>No Telp</th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>Payment</th>
                                <th colspan="2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                            <tr>
                                <td class="uppercase-text">{{ $customer->gender }}</td>
                                <td class="uppercase-text">{{ $customer->booker }}</td>
                                <td>{{ $customer->company }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->alamat }}</td>
                                <td><a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></td>
                                <td>{{ $customer->payment }}</td>
                                <td class="actions">
                                    <form action="{{ url('/customer/' . $customer->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ url('/customer/' . $customer->id) }}"
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
                                <td>
                                    <form action="{{ route('invoice.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="customer_id" value="{{ $customer->id }}"
                                            class="form-control">
                                        <button class="btn btn-primary btn-sm">Buat Invoice</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="5">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="float-right">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link"
                                    href="{{ $customers->url(1) }}">&lsaquo;&lsaquo;</a></li>

                            @php
                            $startPage = max(1, $customers->currentPage() - 2);
                            $endPage = min($customers->lastPage(), $customers->currentPage() + 2);
                            @endphp

                            @if ($startPage > 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            @foreach (range($startPage, $endPage) as $page)
                            @if ($page == $customers->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                            <li class="page-item"><a class="page-link"
                                    href="{{ $customers->url($page) }}">{{ $page }}</a></li>
                            @endif
                            @endforeach

                            @if ($endPage < $customers->lastPage())
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                <li class="page-item"><a class="page-link"
                                        href="{{ $customers->url($customers->lastPage()) }}">&rsaquo;&rsaquo;</a></li>
                        </ul>
                    </div>
                    <style>
                    .actions {
                        white-space: nowrap; /* Mencegah teks pindah ke baris baru */
                    }
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