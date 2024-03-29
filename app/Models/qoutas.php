<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qoutas extends Model
{
    use HasFactory;

    protected $table = 'qoutas';

    protected $fillable = [
       'valor_contribuido',
       'data_pagamento',
       'nome_socio',
       'id_socio'
    ];
}