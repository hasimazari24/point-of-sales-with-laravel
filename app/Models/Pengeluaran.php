<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran'; //pilih tabel yg akan dikelola
    protected $primaryKey = 'id_pengeluaran';
    protected $guarded = []; //pengecualian 
}
