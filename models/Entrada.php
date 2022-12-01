<?php

namespace Model;

class Entrada extends ActiveRecord {

    protected static $tabla = 'entradas';
    protected static $columnasDB = ['id', 'titulo', 'imagen', 'texto', 'fecha', 'autor'];

    public $id;
    public $titulo;
    public $imagen;
    public $texto;
    public $fecha;
    public $autor;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->texto = $args['texto'] ?? '';
        $this->fecha = $args['fecha'] ?? date('Y/m/d');
        $this->autor = $args['autor'] ?? '';
    }

    public function validar() {
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un título";
        }

        if (!$this->imagen) {
            self::$errores[] = "La imagen de la propiedad es obligatoria";
        }

        if (strlen($this->texto) < 50) {
            self::$errores[] = "El texto es obligatoria y debe tener al menos 50 caracteres";
        }

        if(strlen($this->autor) < 2) {
            self::$errores[] = "Debes añadir un autor y debe tener al menos 2 caracteres";
        }

        return self::$errores;
    }
}