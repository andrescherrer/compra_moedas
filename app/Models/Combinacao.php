<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Combinacao extends Model
{
    protected $table = 'combinacoes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'codigo',
        'codigo_moeda_base',
        'descricao'
    ];
}
