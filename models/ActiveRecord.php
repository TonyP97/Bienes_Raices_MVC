<?php

namespace Model;

class ActiveRecord {
    // Base de datos
    protected static $db;
    // Este arreglo de columnas nos permite identificar que columnas podemos actualizar
    protected static $columnasDB = [];
    protected static $tabla = '';

    // Errores
    protected static $errores = [];

    // Definir la conexion a la base de datos
    public static function setDB($database) {
        // self hace referencia a los atributos static
        self::$db = $database;
    }

    public function guardar() {
        if(!is_null($this->id)) {
            // Actualizar
            $this->actualizar();
        } else {
            // Crear
            $this->crear();
        }
    }

    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join (', ', array_keys($atributos));
        $query .= ") VALUES (' ";
        $query .= join ("', '", array_values($atributos));
        $query .= " ')";

        $resultado = self::$db->query($query);

        // Mensaje de exito o error
        if($resultado){
            // Redireccionar al usuario
            header('Location: /admin?resultado=1');
        }
    }

    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];

        foreach($atributos as $key => $value) {
            $valores[] = "{$key} = '{$value}'";
        }

        // Insertar en la base de datos
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join (', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado){
            // Redireccionar al usuario
            header('Location: /admin?resultado=2');
        }
    }

    // Eliminar el registro
    public function eliminar() {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado) {
            // Eliminar la imagen
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }
    }

    // Esta función va a iterar sobre las columnas de la DB y va a identificar y unir los valores de las columnas
    public function atributos() {
        $atributos = [];

        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') {
                continue;
            }
            $atributos[$columna] = $this->$columna;
        }

        return $atributos;
    }

    // Esta función va a iterar sobre los atributos y va a limpiarlos
    public function sanitizarAtributos() {
        $atributos = $this->atributos();

        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    // Subida de archivos
    public function setImagen($imagen) {
        // Eliminar la imagen previa
        if (!is_null( $this->id )) {
            $this->borrarImagen();
        }
        // Asignar al atributo de imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    // Eliminar el archivo
    public function borrarImagen() {
        // Comprobar que exista el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    // Validación
    public static function getErrores() {
        return static::$errores;
    }
    
    public function validar() {
        static::$errores = [];
        return static::$errores;
    }

    // Listado de todas las propiedades
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;

        // Consultar la base de datos
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Obtener determinado número de registros
    public static function get($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;

        // Consultar la base de datos
        $resultado = self::consultarSQL($query);

        return $resultado;
    }


    // Buscar una propiedad por su ID
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";

        // Consultar la base de datos
        $resultado = self::consultarSQL($query);

        return array_shift($resultado); // Devuelve el primer elemento del arreglo
    }

    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // Liberar la memoria
        $resultado->free();

        // Retornar los resultados
        return $array;

    }

    protected static function crearObjeto($registro) {
        $objeto = new static;  // static hace referencia a la clase que se está ejecutando

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Sincronizar el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar( $args = [] ) {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}