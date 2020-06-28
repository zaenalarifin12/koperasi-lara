<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anggota = DB::select("SELECT * FROM anggota");
        
        return view("anggota.index", ["anggota" => $anggota]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $nik             = $request->nik;
        $kodeRekening    = $request->kodeRekening;
        $nama            = $request->nama;
        $alamat          = $request->alamat;
        $saldo = (int) filter_var($request->saldo, FILTER_SANITIZE_NUMBER_INT);
        DB::insert("INSERT INTO anggota 
        
        (nik,
        kodeRekening,
        nama,
        alamat,
        saldo)
         VALUES (
            '$nik',
            '$kodeRekening',
            '$nama',
            '$alamat',
            $saldo
        )");

        return redirect("/anggota")->with("msg", "anggota berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $anggota = DB::select("SELECT * FROM anggota WHERE idAnggota = ?", [$id]);
        
        return view("anggota.show", ["anggota" => $anggota]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $anggota = DB::select("SELECT * FROM anggota WHERE idAnggota = ?", [$id]);
        if($anggota != null)
            DB::delete("DELETE FROM anggota WHERE idAnggota = ?", [$id]);

        return redirect("/anggota")->with("msg", "anggota berhasil dihapus");
    }
}
