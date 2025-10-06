<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoMercancia extends Model
{
    use HasFactory, softDeletes;
    public $timestamps = false;

    protected $table = 'tipos_mercancias';

    protected $fillable = [
        'tipo',
    ];
}
