<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = DB::select("SELECT * FROM transaksi INNER JOIN anggota ON transaksi.idAnggota = anggota.idAnggota");
        
        return view("transaksi.index", ["transaksi" => $transaksi]);
    }

    // ================ TABUNGAN ===================
    public function nabung(Request $request)
    {
        // cari id berdasarkan nomor rekening
        $rekening = $request->kodeRekening;        
        $idAnggota = DB::select("SELECT idAnggota, saldo FROM anggota WHERE kodeRekening = ?", [$rekening]);
        
        $id     = $idAnggota[0]->idAnggota;
        $saldo  = $idAnggota[0]->saldo;
        if($id == null) 
            return redirect("/transaksi")->with("err", "nomor rekening belum terdaftar");
            
        $jumlah = (int) filter_var($request->jumlah, FILTER_SANITIZE_NUMBER_INT);
        
        $a = DB::insert("INSERT INTO transaksi ( jumlah, transaksi, idAnggota ) VALUES ( $jumlah, 'masuk', $id )");
        
        // edit saldonya
        $hasil = $saldo + $jumlah;
        $idAnggota = DB::select("UPDATE anggota SET saldo = :hasil WHERE idAnggota = :id ", ["hasil" => $hasil, "id" => $id]);
        

        return redirect("/transaksi")->with("msg", "saldo berhasil ditambahkan");
    }

    // =============== PENARIKAN ===================
    public function tarik(Request $request)
    {
        // cari id berdasarkan nomor rekening
        $rekening = $request->kodeRekening;        
        $idAnggota = DB::select("SELECT idAnggota, saldo FROM anggota WHERE kodeRekening = ?", [$rekening]);
        
        $id     = $idAnggota[0]->idAnggota;
        $saldo  = $idAnggota[0]->saldo;
        $jumlah = (int) filter_var($request->jumlah, FILTER_SANITIZE_NUMBER_INT);

        if($id == null) 
            return redirect("/transaksi")->with("err", "nomor rekening belum terdaftar");
        
        // edit saldonya
        $hasil = $saldo - $jumlah;
        if($hasil < 0)
            return redirect("/transaksi")->with("err", "jumlah melebihi saldo yang dimiliki");
        
        DB::insert("INSERT INTO transaksi ( jumlah, transaksi, idAnggota ) VALUES ( $jumlah, 'keluar', $id )");
        DB::select("UPDATE anggota SET saldo = :hasil WHERE idAnggota = :id ", ["hasil" => $hasil, "id" => $id]);

        return redirect("/transaksi")->with("msg", "saldo berhasil ditarik");
    }
}
