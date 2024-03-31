<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RenameIdPembelianDetailColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pembelian_detail', function ($t) {
            DB::statement("ALTER TABLE `pembelian_detail` CHANGE `id_pembelian_detai;` `id_pembelian_detail` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembelian_detail', function (Blueprint $table) {
            //
        });
    }
}
