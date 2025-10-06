<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Camion extends Model
{
    use HasFactory, softDeletes;
    public $timestamps = false;

    protected $table = 'camiones';

    protected $fillable = [
        'marca',
        'modelo',
        'placa',
    ];

    public function camioneros(): BelongsToMany
    {
        return $this->belongsToMany(Camionero::class, 'camioneros_camiones');
    }

}
