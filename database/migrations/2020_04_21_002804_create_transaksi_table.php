<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->increments("idTransaksi");
            $table->bigInteger("jumlah");
            $table->enum("transaksi", ["masuk", "keluar"]);
            $table->integer("idAnggota")->unsigned();
            $table->timestamps();

            $table->foreign("idAnggota")->references("idAnggota")->on("anggota")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
