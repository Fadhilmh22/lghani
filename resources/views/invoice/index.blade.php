@extends('master')

@section('konten')

<head>
    <!-- ... -->
    <link href="{{ asset('node_modules/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
</head>
<div class="container">
    <div class="row">
        <div class="col-md-20">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">List Invoice Ticketing</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {!! session('success') !!}
                    </div>
                    @endif
                    <div class="right mb-3 mb-sm-0">
                        <form action="{{ url('/invoice') }}" method="GET" class="form-inline">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari Nama Booker" name="search">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                    
                                </div>
                                 
                            </div>
                        </form>
                    </div>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <th>Tanggal Pembuatan</th>
                                <th>Nama Booker</th>
                                <th>Company</th> <!-- Tambah kolom 'Company' di sini -->
                                <th>No Telp</th>
                                <th>Dicetak Oleh</th>
                                <th>Total</th>
                                <th>Aksi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                             @php
                                $totalBelumLunas = 0;
                            @endphp
                            @forelse ($invoice as $row)
                            
                            @php
                                $totalBelumLunas += ($row->status_pembayaran === 'Belum Lunas') ? $row->total : 0;
                            @endphp
                            <tr>
                                <td><strong>{{ $row->invoiceno }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y H:i:s') }}
                                </td> <!-- Tanggal Cetak -->
                                <td class="wider-column uppercase-text">{{ $row->customer->gender }}.
                                 {{ $row->customer->booker }}</td>
                                <td>{{ $row->customer->company }}</td> <!-- Tampilkan nilai dari kolom 'company' di sini -->
                                <td>{{ $row->customer->phone }}</td>
                                <td>{{ $row->edited }}</td>
                                <td>Rp {{ number_format($row->total) }}</td>
                               <td class="action-buttons">
                                  <form action="{{ route('invoice.destroy', $row->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="{{ route('invoice.print', $row->id) }}" class="btn btn-primary btn-xs">Print</a>
                                    <a href="{{ route('invoice.printdisc', $row->id) }}" class="btn btn-primary btn-xs">Disc</a>
                                    <a href="{{ route('invoice.edit', $row->id) }}" class="btn btn-warning btn-xs">Ubah</a>
                                    <button class="btn btn-danger btn-xs" onclick="return confirmDelete()">Hapus</button>
                                  </form>
                                </td>
                                <td>
                                @php
                                    $dueDate = \Carbon\Carbon::parse($row->due_date);
                                    $isAfter14Days = now()->diffInDays($dueDate) > 14;
                            
                                    if ($isAfter14Days && $row->status_pembayaran !== 'Sudah Lunas') {
                                        // If it's after 14 days and the status is not already 'Sudah Lunas', update the status
                                        $row->status_pembayaran = 'Sudah Lunas';
                                        // You may want to save the updated status to the database here if needed
                                    }
                                @endphp
                            
                                <form method="POST" action="{{ route('invoice.ubah-status', $row->id) }}">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="current_page" value="{{ $invoice->currentPage() }}">
                                    <button class="toggleStatus btn {{ $row->status_pembayaran === 'Sudah Lunas' ? 'btn-success btn-xs' : 'btn-danger btn-xs' }}"
                                            data-invoice-id="{{ $row->id }}">
                                        {{ $row->status_pembayaran }}
                                    </button>
                                </form>
                            </td>
                                <!-- resources/views/pemesanan/index.blade.php -->
                             <script>
    var currentUrl = window.location.href;
    $(document).ready(function () {
        $(".toggleStatus").each(function (index) {
            var $toggleStatusButton = $(this);
            var invoiceId = $toggleStatusButton.data('invoice-id');
            var currentStatus = $toggleStatusButton.text();
            var currentPage = $toggleStatusButton.closest('form').find('[name="current_page"]').val();

            $toggleStatusButton.click(function () {
                var newStatus = (currentStatus === "Belum Lunas") ? "Sudah Lunas" : "Belum Lunas";
                updatePaymentStatus(newStatus, currentPage);

                window.location.href = currentUrl;
            });

            function updatePaymentStatus(newStatus, currentPage) {
                // Kirim status pembayaran ke server menggunakan AJAX
                $.ajax({
                    url: '/update-payment-status/' + invoiceId,
                    method: 'POST',
                    data: {
                        status: newStatus
                    },
                    success: function (response) {
                        // Tindakan apa pun yang perlu dilakukan setelah berhasil
                        $toggleStatusButton.removeClass("btn-success btn-danger");
                        if (newStatus === "Sudah Lunas") {
                            $toggleStatusButton.addClass("btn-success");
                        } else {
                            $toggleStatusButton.addClass("btn-danger");
                        }
                        $toggleStatusButton.text(newStatus); // Ubah teks tampilan setelah perubahan status
                        // Redirect kembali ke halaman saat ini
                        window.location.href = '/invoice?page=' + currentPage;
                    },
                    error: function (xhr, status, error) {
                        // Tangani kesalahan jika terjadi
                    }
                });
            }
        });
    });
</script>



                                <script>
                                function confirmDelete() {
                                    return confirm("Apakah Anda yakin ingin menghapus invoice ini?");
                                }
                                </script>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div>
                        Total Belum Lunas: Rp {{ number_format($totalBelumLunas) }}
                    </div>
                    <div class="float-right">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link"
                                    href="{{ $invoice->url(1) }}">&lsaquo;&lsaquo;</a></li>

                            @php
                            $startPage = max(1, $invoice->currentPage() - 2);
                            $endPage = min($invoice->lastPage(), $invoice->currentPage() + 2);
                            @endphp

                            @if ($startPage > 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                             @foreach (range($startPage, $endPage) as $page)
                        @if ($page == $invoice->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                        <li class="page-item"><a class="page-link"
                                href="{{ $invoice->appends(['search' => request('search')])->url($page) }}">{{ $page }}</a>
                        </li>
                        @endif
                        @endforeach

                            @if ($endPage < $invoice->lastPage())
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                <li class="page-item"><a class="page-link"
                                        href="{{ $invoice->url($invoice->lastPage()) }}">&rsaquo;&rsaquo;</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>

 .action-buttons {
    display: flex;
    justify-content: space-around;
  }
  
  
.uppercase-text {
    
    text-transform: uppercase;
}
.btn-custom-small {
    padding: 7px 10px;
    /* Sesuaikan dengan ukuran yang Anda inginkan */
    font-size: 10px;
    /* Sesuaikan dengan ukuran font yang Anda inginkan */
}

.wider-column {
    width: 200px;
    /* Sesuaikan dengan lebar yang Anda inginkan */
}

.right {

    float: right;

}
</style>
@endsection