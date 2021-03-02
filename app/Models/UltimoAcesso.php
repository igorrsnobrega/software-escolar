<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UltimoAcesso extends Model
{
    use HasFactory;

    protected $table = 'ultimo_acesso';
    protected $primaryKey = 'controle_id';
}
