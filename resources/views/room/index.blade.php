@extends('master')

@section('konten')
<div class="container" style="font-family: 'poppins', sans-serif;">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="card-title">Rooms</h3>
                        </div>
                        <div class="col-md-9">
                            <a href="{{ url('/room/new') }}" class="btn btn-primary btn-sm float-right">Tambah Data
                                Kamar</a>
                        </div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {!! session('success') !!}
                    </div>
                    @endif
                    <div class="right mb-3 mb-sm-0">
    <form action="{{ url('/room') }}" method="GET" class="form-inline">
        <div class="row">
            <div class="col">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari Nama Hotel" name="search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Hotel</th>
                                <th>Room Code</th>
                                <th>Room Name</th>
                                <th>Room Type</th>
                                <th>Bed Type</th>
                                <th>Weekday Price</th>
                                <th>Weekday NTA</th>
                                <th>Weekend Price</th>
                                <th>Weekend NTA</th>
                                <th colspan="2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = ($rooms->currentPage() - 1) * $rooms->perPage() + 1; @endphp
                            @forelse($rooms as $room)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $comboHotel[$room->hotel_id]['hotel_name'] }}</td>
                                <td>{{ $room->room_code }}</td>
                                <td>{{ $room->room_name }}</td>
                                <td>{{ $room->room_type }}</td>
                                <td>{{ $room->bed_type }}</td>
                                <td>Rp {{ number_format($room->weekday_price) }}</td>
                                <td>Rp {{ number_format($room->weekday_nta) }}</td>
                                <td>Rp {{ number_format($room->weekend_price) }}</td>
                                <td>Rp {{ number_format($room->weekend_nta) }}</td>
                                <td class="actions">
                                    <form action="{{ url('/room/' . $room->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ url('/room/' . $room->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <button class="btn btn-danger btn-sm" onclick="return confirmDelete()">Hapus</button>
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

                   <!-- Tampilkan Tombol Pagination -->
                        <div class="float-right">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link"
                                    href="{{ $rooms->url(1) }}">&lsaquo;&lsaquo;</a></li>

                            @php
                            $startPage = max(1, $rooms->currentPage() - 2);
                            $endPage = min($rooms->lastPage(), $rooms->currentPage() + 2);
                            @endphp

                            @if ($startPage > 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            @foreach (range($startPage, $endPage) as $page)
                            @if ($page == $rooms->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                            <li class="page-item"><a class="page-link"
                                    href="{{ $rooms->url($page) }}">{{ $page }}</a></li>
                            @endif
                            @endforeach

                            @if ($endPage < $rooms->lastPage())
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                <li class="page-item"><a class="page-link"
                                        href="{{ $rooms->url($rooms->lastPage()) }}">&rsaquo;&rsaquo;</a></li>
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

<script>
    function confirmDelete() {
        return confirm("Apakah Anda yakin ingin menghapus data room ini?");
    }
</script>
@endsection
