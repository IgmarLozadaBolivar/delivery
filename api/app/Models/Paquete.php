<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paquete extends Model
{
    use HasFactory, softDeletes;
    public $timestamps = false;

    protected $fillable = [
        'camionero_id',
        'estado_id',
        'direccion',
    ];

    public function camionero(): BelongsTo
    {
        return $this->belongsTo(Camionero::class);
    }

    public function estadoPaquete(): BelongsTo
    {
        return $this->belongsTo(EstadoPaquete::class, 'estado_id');
    }
}
