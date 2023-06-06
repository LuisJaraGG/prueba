<?php

namespace App;

class Propiedad extends ActiveRecord
{
    protected static $tabla = 'propiedades';
    // Columnas de la db propiedades
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $idvendedor;
    public $creado;


    public function __construct($args = [])
    {
        // En caso no este es un string vacio
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->idvendedor = $args['idvendedor'] ?? '';
        $this->creado = date('Y/m/d');
    }
    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = 'Debes añadir un titulo';
        }

        if (!$this->precio) {
            self::$errores[] = 'Debes añadir un precio';
        }

        if (strlen($this->descripcion) < 50) {
            self::$errores[] = 'Debes añadir una descripcion 50 caracteres';
        }

        if (!$this->habitaciones) {
            self::$errores[] = 'EL numero e habitaciones es obligatorio';
        }

        if (!$this->wc) {
            self::$errores[] = 'Debes añadir un numero de wc';
        }

        if (!$this->estacionamiento) {
            self::$errores[] = 'Debes añadir un numero de estacionamiento';
        }

        if (!$this->imagen) {
            self::$errores[] = 'Debes añadir una imagen';
        }

        return static::$errores;
    }
}
