<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_detail', function (Blueprint $table) {
            $table->increments('id_pembelian_detai;');
            $table->integer('id_pembelian');
            $table->integer('id_produk');
            $table->integer('harga_beli');
            $table->integer('jumlah');
            $table->integer('sub_totoal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian_detail');
    }
}
