<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model{
    use SoftDeletes;
    protected $fillable = [
        'nombre',
        'barra',
        'cantidadAlmacen',
        'cantidadSucursal1',
        'cantidadSucursal2',
        'cantidadSucursal3',
        'cantidadSucursal4',
        'costo',
        'precioAntes',
        'precio',
        'porcentaje',
        //'utilidad',
        'activo',
        'unidad',
        'registroSanitario',
        'paisOrigen',
        'nombreComun',
        'composicion',
        'marca',
        'distribuidora',
        'imagen',
        //'color',
        'descripcion',
        'categoria',
        'subcategoria'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $appends = [
        'stock',
    ];
    public function getStockAttribute(){
        return $this->cantidadAlmacen + $this->cantidadSucursal1 + $this->cantidadSucursal2 + $this->cantidadSucursal3 + $this->cantidadSucursal4;
    }
}
