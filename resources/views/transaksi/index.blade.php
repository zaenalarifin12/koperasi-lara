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
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi</h6>
            <div>
                <button type="button" class="btn btn-success btn-sm shadow-sm" data-toggle="modal" data-target="#exampleModal">
                    Penabungan
                </button>

                {{-- modal penabungan --}}
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title text-success" id="exampleModalLabel">Penabungan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body" >
                            <form class="user" action="{{ url("/transaksi/nabung") }}" method="POST">
                                <div class="form-group">
                                    <input type="text"  class="form-control" name="kodeRekening" placeholder="nomor rekening">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="rupiah" class="form-control" name="jumlah" minlength="3" placeholder="jumlah uang">
                                </div>
                                <button class="btn btn-primary btn-user btn-block" type="submit">
                                    Tabung
                                </button>
                                @csrf
                            </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </div>
                </div>
                {{-- close modal tabungan --}}

                <button type="button" class="btn btn-primary btn-sm shadow-sm" data-toggle="modal" data-target="#exampleModal2">
                    Penarikan
                </button>

                {{--  --}}
                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title text-primary" id="exampleModalLabel">Penarikan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form class="user" action="{{ url("/transaksi/tarik") }}" method="POST">
                                <div class="form-group">
                                    <input type="text"  class="form-control" name="kodeRekening" placeholder="nomor rekening">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="rupiah2" class="form-control" name="jumlah" minlength="3" placeholder="jumlah uang">
                                </div>
                                <button class="btn btn-primary btn-user btn-block" type="submit">
                                    Tarik
                                </button>
                                @csrf
                            </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </div>
                </div>
                            

                {{--  --}}
            </div>
                
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Nomor</th>
                    <th>No Rekening</th>
                    <th>Nama</th>
                    <th>jumlah</th>
                    <th>Waktu</th>
                    <th>Jenis transaksi</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Nomor</th>
                    <th>No Rekening</th>
                    <th>Nama</th>
                    <th>jumlah</th>
                    <th>Waktu</th>
                    <th>Jenis transaksi</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($transaksi as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->kodeRekening }}</td>
                      <td>{{ $item->nama }}</td>
                      <td>{{ $item->jumlah }}</td>
                      <td>{{ $item->created_at }}</td>
                      <td>
                        @if ($item->transaksi == "masuk")
                          <p class="text-primary text-bold">{{$item->transaksi}}</p> 
                        @else
                          <p class="text-success text-bold">{{$item->transaksi}}</p> 
                        @endif
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

    <!-- untuk format rupiah -->
    <script type="text/javascript">
            
      var rupiah2 = document.getElementById('rupiah2');
      rupiah2.addEventListener('keyup', function(e){
          // tambahkan 'Rp.' pada saat form di ketik
          // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
          rupiah2.value = formatRupiah(this.value, 'Rp. ');
      });

      /* Fungsi formatRupiah */
      function formatRupiah(angka, prefix){
          var number_string = angka.replace(/[^,\d]/g, '').toString(),
          split   		= number_string.split(','),
          sisa     		= split[0].length % 3,
          rupiah2     		= split[0].substr(0, sisa),
          ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

          // tambahkan titik jika yang di input sudah menjadi angka ribuan
          if(ribuan){
              separator = sisa ? '.' : '';
              rupiah2 += separator + ribuan.join('.');
          }

          rupiah2 = split[1] != undefined ? rupiah2 + ',' + split[1] : rupiah2;
          return prefix == undefined ? rupiah2 : (rupiah2 ? 'Rp. ' + rupiah2 : '');
      }
  </script>

@endsection