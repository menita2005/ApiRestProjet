<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';

    protected $fillable = [
        'id',
        'user_id',
        'NombreP',
        'Descripcion',
        'Precio',
        'stock',
        'categoria_id',
        'proveedor_id'
    ];
    // Definir la relación con Categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
}
