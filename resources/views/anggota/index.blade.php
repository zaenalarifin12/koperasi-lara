@extends('layouts.parent')


@section('css')
  <link href="{{ asset("assets/vendor/datatables/dataTables.bootstrap4.min.css")}}" rel="stylesheet">
@endsection
@section("page")
       <!-- Begin Page Content -->
       <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-inline-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Anggota</h6>
            <button type="button" class="btn btn-primary btn-sm shadow-sm" data-toggle="modal" data-target="#exampleModal">
                Tambah Anggota
            </button>
                
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form class="user" method="POST" action="{{ url("/anggota") }}">
                            <div class="form-group">
                                <input type="number" class="form-control" name="nik" minlength="16" maxlength="16" placeholder="nik">
                            </div>
                            <div class="form-group">
                                <input type="number"  class="form-control" name="kodeRekening" placeholder="kode rekening">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" minlength="5" name="nama" placeholder="nama">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" minlength="10" name="alamat" placeholder="alamat">
                            </div>
                            <div class="form-group">
                                <input type="text" id="rupiah" class="form-control" name="saldo" placeholder="saldo">
                            </div>
                            <button class="btn btn-primary btn-user btn-block" type="submit">
                                Daftarkan
                            </button>
                            @csrf
                        </form>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
                </div>
            </div>


          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Nomor</th>
                    <th>No Rekening</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Saldo</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Nomor</th>
                    <th>No Rekening</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Saldo</th>
                    <th>Aksi</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($anggota as $item)
                    <tr>
                        <td>{{ $loop->iteration}}</td>
                        <td>{{$item->kodeRekening}}</td>
                        <td>{{$item->nik}}</td>
                        <td>{{$item->nama}}</td>
                        <td>{{$item->saldo}}</td>
                        <td>
                          <a href="{{ url("/anggota/$item->idAnggota", ) }}" class="btn btn-primary btn-sm">Lihat</a>
                          <form action="{{ url("/anggota/{$item->idAnggota}") }}" method="post" class="d-inline">
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            @csrf
                            @method("DELETE")
                          </form>
                        </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->
@endsection


@section('script')
  <!-- Page level plugins -->
  <script src={{ asset("assets/vendor/datatables/jquery.dataTables.min.js")}}></script>
  <script src={{ asset("assets/vendor/datatables/dataTables.bootstrap4.min.js")}}></script>

  <!-- Page level custom scripts -->
  <script src={{ asset("assets/js/demo/datatables-demo.js")}}></script>


    <!-- untuk format rupiah -->
    <script type="text/javascript">
            
        var rupiah = document.getElementById('rupiah');
        rupiah.addEventListener('keyup', function(e){
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah.value = formatRupiah(this.value, 'Rp. ');
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix){
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>
@endsection