<?php

namespace Controllers;

use MVC\Router;
use Model\Entrada;
use Intervention\Image\ImageManagerStatic as Image;

class EntradaController {
    public static function crear(Router $router) {

        $entrada = new Entrada;
        $errores = Entrada::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crear una nueva instancia
        $entrada = new Entrada($_POST['entrada']);

        // Crear carpeta
        if(!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }
        // Generar un nombre unico
        // md5 hashea
        // uniqid genera un id unico
        // rand genera un numero aleatorio
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

        // Setear la imagen
        // Realiza un resize a la imagen con intervention image
        if($_FILES['entrada']['tmp_name']['imagen']){
            $image = Image::make($_FILES['entrada']['tmp_name']['imagen'])->fit(800, 600);
            $entrada->setImagen($nombreImagen);
        }

        // Validar
        $errores = $entrada->validar();

        // Revisar que el arreglo de errores este vacio
        if(empty($errores)) {

            // Guarda la imagen en el servidor
            $image->save(CARPETA_IMAGENES . $nombreImagen);

            // Guardar en la base de datos
            $entrada -> guardar();

        }
        }

        $router->render('entradas/crear', [
            'entrada' => $entrada,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {
       
        $id = validarORedireccionar('/admin');

        $entrada = Entrada::find($id);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Asignar los atributos
            $args = $_POST['entrada'];
    
            $entrada->sincronizar($args);
    
            // Validar
            $errores = $entrada->validar();
    
            // Subida de archivos
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";
    
            if($_FILES['entrada']['tmp_name']['imagen']){
                $image = Image::make($_FILES['entrada']['tmp_name']['imagen'])->fit(800, 600);
                $entrada->setImagen($nombreImagen);
            }
    
            // Revisar que el arreglo de errores este vacio
            if(empty($errores)) {
                if($_FILES['entrada']['tmp_name']['imagen']){
                    // Almacenar la imagen
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
    
                $resultado = $entrada->guardar();
            }
        }

        $router->render('entradas/actualizar', [
            'entrada' => $entrada,
            'errores' => Entrada::getErrores()
        ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id) {
                $tipo = $_POST['tipo'];

                if(validarTipoContenido($tipo)) {
                    $entrada = Entrada::find($id);
                    $entrada->eliminar();
                }
            }
        }
    }
}