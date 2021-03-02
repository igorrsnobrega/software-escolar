<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuloEquipamento extends Model
{
    use HasFactory;

    protected $table = 'modulos_equip';
    protected $primaryKey = 'controle_id';
}
