@extends('master')

@section('konten')
<div class="container" style="font-family: 'poppins', sans-serif;">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h3 class="card-title">Hotel Voucher</h3>
                            </div>
                            
                            <div class="col-md-7 mb-15">
                                <a href="{{ url('/hotel-voucher/new') }}" class="btn btn-primary btn-sm float-right">Tambah Data Voucher</a>
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
                                    <th>Voucher ID</th>
                                    <th>Booking ID</th>
                                    <th>Booker</th>
                                    <th>Nationality</th>
                                    <th>Created At</th>
                                    <th colspan="2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @forelse($hotelVouchers as $voucher)
                                <tr>
                                    <td>{{ $voucher -> id }}</td>
                                    <td>{{ $voucher->voucher_no }}</td>
                                    <td>{{ $voucher->booking_no }}</td>
                                    <td>{{ $voucher->booker }}</td>
                                    <td>{{ $voucher->nationality }}</td>
                                    <td>{{ $voucher->created_at }}</td>
                                    <td>
                                        <form action="{{ url('/hotel-voucher/' . $voucher->id . '/delete') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('hotelvoucher.print', $voucher->id) }}" class="btn btn-primary btn-sm">Print</a>
                                            <a href="{{ url('/hotel-voucher/' . $voucher->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="{{ url('/hotel-voucher/room/' . $voucher->id) }}" class="btn btn-info btn-sm">Room</a>
                                            <button class="btn btn-danger btn-sm" onclick="return confirmDelete()">Hapus</button>
                                        </form>
                                    </td>
                                    <script>
                                        function confirmDelete() {
                                            return confirm("Apakah Anda yakin ingin menghapus data voucher ini?");
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
                                    href="{{ $hotelVouchers->url(1) }}">&lsaquo;&lsaquo;</a></li>

                            @php
                            $startPage = max(1, $hotelVouchers->currentPage() - 2);
                            $endPage = min($hotelVouchers->lastPage(), $hotelVouchers->currentPage() + 2);
                            @endphp

                            @if ($startPage > 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            @foreach (range($startPage, $endPage) as $page)
                            @if ($page == $hotelVouchers->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                            <li class="page-item"><a class="page-link"
                                    href="{{ $hotelVouchers->url($page) }}">{{ $page }}</a></li>
                            @endif
                            @endforeach

                            @if ($endPage < $hotelVouchers->lastPage())
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                <li class="page-item"><a class="page-link"
                                        href="{{ $hotelVouchers->url($hotelVouchers->lastPage()) }}">&rsaquo;&rsaquo;</a></li>
                        </ul>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
