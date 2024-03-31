<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier'; //pilih tabel yg akan dikelola
    protected $primaryKey = 'id_supplier';
    protected $guarded = []; //pengecualian 
}
