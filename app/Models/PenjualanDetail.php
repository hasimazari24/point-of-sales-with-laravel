<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;
    protected $table = 'penjualan_detail'; //pilih tabel yg akan dikelola
    protected $primaryKey = 'id_penjualan_detail';
    protected $guarded = []; //pengecualian 

    //bikin relationship tabel dg eloquoent
    public function produk()
    {
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk'); //tiap pembelian detail dibikin has One
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'id_member', 'id_member'); //tiap pembelian detail dibikin has One
    }
}
