<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetallePaquete extends Model
{
    use HasFactory, softDeletes;
    public $timestamps = false;

    protected $table = 'detalles_paquetes';

    protected $fillable = [
        'paquete_id',
        'tipo_mercancia_id',
        'dimension',
        'peso',
        'fecha_entrega',
    ];

    public function paquete(): BelongsTo
    {
        return $this->belongsTo(Paquete::class);
    }

    public function tipoMercancia(): BelongsTo
    {
        return $this->belongsTo(TipoMercancia::class);
    }

    protected function casts(): array
    {
        return [
            'fecha_entrega' => 'date',
        ];
    }
}
