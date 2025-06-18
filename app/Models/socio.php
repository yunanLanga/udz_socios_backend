<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class socio extends Model
{
    use HasFactory;

    protected $table = 'socios';

    protected $fillable = [
       'nome_completo',
       'endereco',
       'genero',
       'data_nasciemnto',
       'telefone',
       'telefone_opcional',
       'email',
       'nacionalidade',
       'tipo_documento_de_identificacao',
       'documento_de_identificacao',
       'categoria_socio',
       'valor_quota_anual',
       'valor_quota_contribuido',
       'estado_socio'
    ];

    public function qoutas()
    {
        return $this->hasMany(Qoutas::class, 'id_socio', 'id');
    }
}
