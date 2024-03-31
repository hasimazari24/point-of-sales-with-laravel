<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'member'; //pilih tabel yg akan dikelola
    protected $primaryKey = 'id_member';
    protected $guarded = []; //pengecualian 
}
