<!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Invoice App</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('lghani-fit.png') }}" height="15px">
    <link rel="stylesheet" href="style.css"> <!-- Referensi ke file CSS tunggal -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
      .navbar-right .dropdown-toggle {
        white-space: nowrap;
        /* Mencegah pemisahan ke bawah */
        overflow: hidden;
        /* Menghilangkan teks yang tidak muat */
        text-overflow: ellipsis;
        /* Menampilkan tanda elipsis jika terpotong */
        max-width: 200px;
        /* Atur lebar maksimum yang sesuai */
      }

      .mb-15 {
        margin-bottom: 15px;
      }
    </style>
    <script type="text/javascript">
      // function formatRupiah(angka, prefix){
      function formatRupiah(angka){
        var number_string = String(angka).replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa  = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);
       
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }
       
        // rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        // return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');

        return rupiah;
      }
    </script>
  </head>

  <body>
  <div class="container" style="font-family: 'poppins', sans-serif;">
      <div class="col-md-12">
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="{{route('home')}}">
              <div class="text-center">
                <img src="{{ asset('lghani-fit.png') }}" alt="" height="25px">
              </div>
            </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="font-family: 'poppins', sans-serif;">
              <ul class="nav navbar-nav navbar-left">
              
                <li class="nav-item">
                  <a href="{{ url('/customer') }}" class="nav-link">Pelanggan</a>
                </li>

                <li class="nav-item">
                  <a href="{{ url('/passenger') }}" class="nav-link">Penumpang</a>
                </li>

              </ul>
              <ul class="nav navbar-nav navbar">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ticketing<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="{{ url('/airline') }}"><i class="fas fa-plane"></i> Maskapai</a></li>
                    <li><a href="{{ route('invoice.create') }}"><i class="fas fa-file-invoice"></i> Buat Invoice</a></li>
                    <li><a href="{{ route('invoice.index') }}"><i class="fas fa-file"></i> Invoice Ticketing</a></li>
                    <li role="separator" class="divider"></li>
                  </ul>
                </li>
              </ul>
              <ul class="nav navbar-nav navbar">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hotel <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="{{ url('/hotel') }}"><i class="fas fa-hotel"></i> Hotel</a></li>
                    <li><a href="{{ url('/room') }}"><i class="fas fa-bed"></i> Kamar Hotel</a></li>
                    <li><a href="{{ url('/hotel-voucher') }}"><i class="fas fa-gift"></i> Vocher Hotel</a></li>
                    <li><a href="{{ url('/hotel-invoice') }}"><i class="fas fa-file"></i> Invoice Hotel</a></li>
                    <li role="separator" class="divider"></li>
                  </ul>
                </li>
              </ul>
              
              <ul class="nav navbar-nav navbar">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Laporan<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    @if (auth()->user()->role == "Owner")
                    <li><a href="{{ url('/report') }}"><i class="fas fa-plane"></i> Laporan Ticketing</a></li>
                    <li><a href="{{ url('/report/hotel') }}"><i class="fas fa-hotel"></i> Laporan Hotel</a></li>
                    <li><a href="{{ url('/report/piutang') }}"><i class="fas fa-archive"></i> Laporan Piutang</a></li>
                    @endif
                    <li role="separator" class="divider"></li>
                  </ul>
                </li>
              </ul>

              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> {{Auth::user()->name}} <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a><i class="fa fa-user"></i>&nbsp;<b>{{Auth::user()->role}}</b></a></li>
                    @if (auth()->user()->role == "Owner")
                    <li><a href="{{route('register')}}"><i class="fas fa-plus"></i> Tambah Akun</a></li>
                    @endif
                    <li role="separator" class="divider"></li>
                    <li><a href="{{route('actionlogout')}}"><i class="fa fa-power-off"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
        @yield('konten')
      </div>
    </div>
    </div>
  </body>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
</html>