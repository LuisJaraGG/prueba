<?php

namespace App;

class ActiveRecord
{
    // PATRON DE ACTIVE RECORD => CREA UNA CLASE QUE REPRESENTA UNA TABLA DE LA BASE DE DATOS!


    // Base de datos
    // Es estatico porque no requiere crearlo una y otra ves
    protected static $db;
    protected static $columnasDB = [];

    protected static $tabla = '';

    // Errores
    protected static $errores = [];

    // Definir la conexion a la basew de datos
    public static function setDB($database)
    {
        // accedemos al atributo estatico con self
        self::$db = $database;
    }

    public function guardar()
    {
        if (!is_null($this->id)) {
            // actualizar
            $this->actualizar();
        } else {
            // creando
            $this->crear();
        }
    }

    public function crear()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtr();
        $propiedades = join(', ', array_keys($atributos));
        $valores = join("', '", array_values($atributos));

        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= $propiedades . ") VALUES ('";
        $query .= $valores . "')";

        $resultado =  self::$db->query($query);

        if ($resultado) {
            // redireccionar al usuario con header
            header('Location:/bienesraices_POO/admin?resultado=1');
        }
    }

    public function actualizar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtr();

        $valores = array();
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= "LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado) {
            // redireccionar al usuario con header
            header('Location:/bienesraices_POO/admin?resultado=2');
        }
    }

    public function eliminar()
    {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado) {

            $this->borrarImagen();

            header('Location: /bienesraices_POO/admin?resultado=3');
        }
    }

    //Subida de archivos
    public function setImagen($imagen)
    {
        // Elimina la imagen previa
        if (!is_null($this->id)) {
            $this->borrarImagen();
        }
        // Asignar imagen nueva
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    // elimina el archivo

    public function borrarImagen()
    {
        // comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    // Identificar y unir los atributos de la DB
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $col) {
            if ($col === 'id') continue;
            $atributos[$col] = $this->$col;
        }
        return $atributos;
    }

    public function sanitizarAtr()
    {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    // Validacion
    public static function getErrores()
    {
        // return self::$errores;
        return static::$errores;
    }

    public function validar()
    {
        // return self::$errores;

        static::$errores = [];
        return static::$errores;
    }

    //    Obtener todas las propiedades
    public static function all()
    {
        //Static obtiene el nombre del atributo en este caso $tabla de las hijas
        $query = "SELECT * FROM " . static::$tabla;

        $resultado =  self::consultarSQL($query);

        return $resultado;
    }

    //Buscar por id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";

        $resultado =  self::consultarSQL($query);

        //array_shift() extrae el primer elemento de un array
        return array_shift($resultado);
    }

    public static function consultarSQL($query)
    {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        //Iterar los resultados
        $array = [];

        // Static porque el crear objetos sera heredado en la clase hija y creara el obj con los atributos de la clse hija
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjetos($registro);
        }

        //Liberar la memoria
        $resultado->free();

        //Retornar los resultados
        return $array;
    }

    protected static function crearObjetos($result)
    {
        //Creando un objeto en base a tus atributos
        // $obj = new self; self hace referencia a la clase actual

        //Creando un objeto en base a sus atributos de la  hija
        $obj = new static; //static hace referencia a la clase hija
        foreach ($result as $key => $value) {
            if (property_exists($obj, $key)) {
                $obj->$key = $value;
            }
        }
        return $obj;
    }

    // sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = [])
    {
        foreach ($args as $key  => $value) {
            // this hace referencia a la instancia actual del objeto
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
