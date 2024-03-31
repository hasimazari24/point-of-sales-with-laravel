<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;
    protected $table = 'pembelian_detail'; //pilih tabel yg akan dikelola
    protected $primaryKey = 'id_pembelian_detail';
    protected $guarded = []; //pengecualian 

    //bikin relationship tabel dg eloquoent
    public function produk()
    {
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk'); //tiap pembelian detail dibikin has One
    }
}
