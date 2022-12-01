<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController {
    
    public static function crear(Router $router) {

        $errores = Vendedor::getErrores();

        $vendedor = new Vendedor;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crear una nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);
        
            // Validar
            $errores = $vendedor->validar();
        
            // Revisar que el arreglo de errores esté vacío
            if(empty($errores)) {
                $vendedor->guardar();
            }
        }        

        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }
    
    public static function actualizar(Router $router) {
        
        $id = validarORedireccionar('/admin');

        $vendedor = Vendedor::find($id);

        $errores = Vendedor::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            // Asignar los atributos
            $args = $_POST['vendedor'];
            $vendedor->sincronizar($args);
        
            // Validar
            $errores = $vendedor->validar();
        
            // Revisar que el arreglo de errores esté vacío
            if(empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/actualizar', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }
    
    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id) {
                $tipo = $_POST['tipo'];
    
                if(validarTipoContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
    
}