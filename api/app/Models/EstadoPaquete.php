<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoPaquete extends Model
{
    use HasFactory, softDeletes;
    public $timestamps = false;

    protected $table = 'estados_paquetes';

    protected $fillable = [
        'estado',
    ];
}
