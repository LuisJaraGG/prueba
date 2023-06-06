<?php

namespace App;

class Vendedor extends ActiveRecord
{

    protected static $tabla = 'vendedores';

    // Columnas de la db vendedores
    protected static $columnasDB = ['id', 'nombre', 'apellido'];

    public $id;
    public $nombre;
    public $apellido;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
    }
}
