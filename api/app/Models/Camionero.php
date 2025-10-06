<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Camionero extends Model
{
    use HasFactory, softDeletes;
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'documento',
        'fecha_nacimiento',
        'licencia',
    ];

    public function camiones(): BelongsToMany
    {
        return $this->belongsToMany(Camion::class, 'camioneros_camiones');
    }

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
        ];
    }
}
