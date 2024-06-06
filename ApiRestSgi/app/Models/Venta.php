<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'ventas';

    protected $fillable = [
        'v_venta',
        'f_venta',
        'producto_id',
        'c_compra'
    ];
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
