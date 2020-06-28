@extends('layouts.parent')

@section('page')
    

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4 mx-5">
            <div class="card-header py-3">
                <a href="{{ url("/anggota") }}" class=""><i class="fa fa-arrow-left"></i></a>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Tentang Anggota ---- </h1>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-3">
                            <p>NIK</p>
                            <p>Kode Rekening</p>
                            <p>Nama</p>
                            <p>Saldo</p>
                            <p>Alamat</p>
                        </div>
                        <div class="col-9 bg-gray-200">
                            @foreach ($anggota as $item)
                                <p>: {{ $item->nik }}</p>
                                <p>: {{ $item->kodeRekening}}</p>
                                <p>: {{ $item->nama }}</p>
                                <p>: {{ $item->saldo }}</p>
                                <p>: {{ $item->alamat }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="float-right mt-3">
                    <button class="btn btn-outline-secondary">Edit</button>
                    <button class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this item?')">Hapus</button>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
                
@section('script')
    

    <!-- untuk format rupiah -->
    <script type="text/javascript">
        var rupiah = document.getElementById('rupiah');
        rupiah.addEventListener('keyup', function (e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah.value = formatRupiah(this.value, 'Rp. ');
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>
@endsection