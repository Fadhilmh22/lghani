@extends('master')

@section('konten')

<div class="container" style="font-family: 'poppins', sans-serif;">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title">Hotel Invoice</h3>
                        </div>

                        <div class="col-md-7 mb-15">
                            <a href="{{ url('/hotel-invoice/new') }}" class="btn btn-primary btn-sm">Tambah Data
                                Invoice</a>
                        </div>
                        <div class="col-md-5 mb-15 text-right">
                            <form action="{{ route('hotelinvoice.index') }}" method="GET" class="form-inline">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari Nama Booker" name="search"
                                        value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                        <tr class="text-center">
                            <th>No</th>
                            <th>Invoice ID</th>
                            <th>Voucher No</th>
                            <th>Issued Date</th>
                            <th>Due Date Payment</th>
                            <th>Booking By</th>
                            <th>Issued By</th>
                            <th>Action</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        @endphp
                        @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->invoiceno }}</td>
                            <td>{{ $invoice->voucherno }}</td>
                            <td>{{ $invoice->created_at }}</td>
                            <td>{{ $invoice->hotel_due_date }}</td>
                            
                            
                            <td>{{ !empty($invoice->customer) ? $invoice->customer->gender : "" }}.
                                {{ !empty($invoice->customer) ? $invoice->customer->booker : "" }}</td>
                            <td>{{ $invoice->issued_by }}</td>
                            <td>
                                <form action="{{ url('/hotel-invoice/' . $invoice->id . '/delete') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div style="display: inline-flex;">

                                        @if(empty($invoice->voucherno))
                                        <a href="javascript:void(0)" class="btn btn-primary btn-xs" disabled>Print</a>
                                        <a href="javascript:void(0)" class="btn btn-primary btn-xs" disabled>Disc</a>

                                        <a href="{{ url('/hotel-voucher/new?bid=' . $invoice->id) }}"
                                            class="btn btn-info btn-xs" style="margin-left: 1px;">Voucher</a>
                                        @else
                                        <a href="{{ route('hotelinvoice.print', $invoice->id) }}"
                                            class="btn btn-primary btn-xs">Print</a>
                                        <span style="margin-left: 1px;"></span> <!-- Tambahkan jarak di sini -->
                                        <a href="{{ route('hotelinvoice.printdisc', $invoice->id) }}"
                                            class="btn btn-primary btn-xs">Disc</a>
                                        <a href="{{ url('/hotel-voucher/invoice/' . $invoice->id . '/print') }}"
                                            class="btn btn-info btn-xs" style="margin-left: 1px;">Voucher</a>
                                        @endif
                                        <a href="{{ url('/hotel-invoice/' . $invoice->id) }}"
                                            class="btn btn-warning btn-xs" style="margin-left: 1px;">Edit</a>
                                        <button class="btn btn-danger btn-xs" onclick="return confirmDelete()"
                                            style="margin-left: 1px;">Hapus</button>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <form method="Post" action="{{ route('hotelinvoice.ubah-status', $invoice->id) }}">
                                    @csrf
                                    @method('Post')
                                    <button
                                        class="toggleStatus btn {{ $invoice->status_pembayaran === 'Sudah Lunas' ? 'btn-success btn-xs' : 'btn-danger btn-xs' }}"
                                        data-invoice-id="{{ $invoice->id }}">
                                        {{ $invoice->status_pembayaran }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <script>
                        $(document).ready(function() {
                        $(".toggleStatus").each(function(index) {
                            var $toggleStatusButton = $(this);
                            var invoiceId = $toggleStatusButton.data('invoice-id');
                            var currentStatus = $toggleStatusButton.text();

                           $toggleStatusButton.click(function () {
                                                var newStatus = (currentStatus === "Belum Lunas") ? "Sudah Lunas" : "Belum Lunas";
                                                updatePaymentStatus(newStatus);
                                                
                                                window.location.href = currentUrl;

                                            });

                                // Menggunakan window.location.href untuk meredirect ke halaman saat ini
                                window.location.href = '/update-payment-status/' +
                                    invoiceId +
                                    '?status=' + newStatus +
                                    '&page={{ $invoices->currentPage() }}&search={{ request('
                                search ') }}';
                            });

                            // Kirim status pembayaran ke server menggunakan AJAX
                            $.ajax({
                                url: '/update-payment-status/' +
                                    invoiceId,
                                method: 'POST',
                                data: {
                                    status: newStatus,
                                    page: {
                                        {
                                            $invoices - > currentPage()
                                        }
                                    },
                                    search: '{{ request('
                                    search ') }}'

                                },
                                success: function(response) {
                                    // Tindakan apa pun yang perlu dilakukan setelah berhasil
                                    $toggleStatusButton.removeClass(
                                        "btn-success btn-danger"
                                    );
                                    if (newStatus ===
                                        "Sudah Lunas") {
                                        $toggleStatusButton
                                            .addClass(
                                                "btn-success");
                                    } else {
                                        $toggleStatusButton
                                            .addClass("btn-danger");
                                    }
                                    $toggleStatusButton.text(
                                        newStatus
                                    ); // Ubah teks tampilan setelah perubahan status
                                },
                                error: function(xhr, status, error) {
                                    // Tangani kesalahan jika terjadi
                                }
                            });
                        });
                        });
                        });
                        </script>
                        <script>
                        function confirmDelete() {
                            return confirm("Apakah Anda yakin ingin menghapus data invoice ini?");
                        }
                        </script>

                        @empty
                        <tr>
                            <td class="text-center" colspan="12">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Tampilkan Tombol Pagination -->
                <div class="float-right">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="{{ $invoices->url(1) }}">&lsaquo;&lsaquo;</a>
                        </li>

                        @php
                        $startPage = max(1, $invoices->currentPage() - 2);
                        $endPage = min($invoices->lastPage(), $invoices->currentPage() + 2);
                        @endphp

                        @if ($startPage > 1)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif

                        @foreach (range($startPage, $endPage) as $page)
                        @if ($page == $invoices->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                        <li class="page-item"><a class="page-link"
                                href="{{ $invoices->appends(['search' => request('search')])->url($page) }}">{{ $page }}</a>
                        </li>
                        @endif
                        @endforeach

                        @if ($endPage < $invoices->lastPage())
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            <li class="page-item"><a class="page-link"
                                    href="{{ $invoices->url($invoices->lastPage()) }}">&rsaquo;&rsaquo;</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection