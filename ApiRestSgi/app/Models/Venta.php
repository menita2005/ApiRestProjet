<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'user_id',
        'v_venta', 'f_venta', 'producto_id', 'c_compra',
    ];

    protected $dates = ['f_venta'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Método para calcular el valor de la venta
    public function calculateValue()
    {
        return $this->producto->Precio * $this->c_compra;
    }
}

