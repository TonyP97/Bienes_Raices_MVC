<?php

namespace MVC;

class Router {
    
    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn) {
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas() {

        session_start();

        $auth = $_SESSION['login'] ?? null;

        // Arreglo de rutas protegidas
        $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar', '/entradas/crear', '/entradas/actualizar', '/entradas/eliminar'];

        $urlActual = $_SERVER['REQUEST_URI'] === '' ? '/' : $_SERVER['REQUEST_URI'];
        $metodo = $_SERVER['REQUEST_METHOD'];

        if($metodo === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        // Proteger rutas
        if(in_array($urlActual, $rutas_protegidas) && !$auth) {
            header('Location: /');
        }

        if($fn) {
            // Llamar la funcion que se encuentra en la ruta
            call_user_func($fn, $this);
        } else {
            echo "No existe la ruta";
        }
    }

    // Muestra una vista
    public function render($view, $datos = []) {

        foreach($datos as $key => $value) {
            $$key = $value; // $$key = $datos['propiedad']
        }

        ob_start();
        // include __DIR__ . "/views/$view.php";
        include "app/views/$view.php";

        $contenido = ob_get_clean();

        include "views/layout.php";
    }
        
}