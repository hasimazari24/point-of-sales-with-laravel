<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    //merepresentasikan database

    protected $table = 'produk'; //pilih tabel yg akan dikelola
    protected $primaryKey = 'id_produk';
    protected $guarded = []; //pengecualian 

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'id_kategori',
        'merk',
        'harga_beli',
        'harga_jual',
        'diskon',
        'stok'
    ];
}
