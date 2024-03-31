<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    //merepresentasikan database

    protected $table = 'kategori'; //pilih tabel yg akan dikelola
    protected $primaryKey = 'id_kategori';
    protected $guarded = []; //pengecualian 
}
