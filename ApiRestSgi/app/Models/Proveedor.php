<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedors';

    protected $fillable = [
        'id',
        'user_id',        
        'Nombre',
        'telefono',
        'Direccion',
        'Correo'
    ];
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
