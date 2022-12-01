<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES',  __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate(string $nombre, bool $inicio = false) {
    include TEMPLATES_URL . "/${nombre}.php";
}

function estaAutenticado(){
    session_start();
    // Solo el usuario logueado puede ver esta página
    if(!$_SESSION['login']) {
        header('Location: /');
    }
    
}

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function sanitizar($html) : string {
    $sanitizado = htmlspecialchars($html);
    return $sanitizado;
}

// Validación de tipo de contenido
function validarTipoContenido($tipo) {
    $tipos = ['vendedor', 'propiedad', 'entrada'];
    return in_array($tipo, $tipos);
}

// Muestra mensajes condicionales
function mostrarNotificacion(int $codigo) : string {
    $mensaje = '';

    switch($codigo) {
        case 1:
            $mensaje = 'Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado Correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }

    return $mensaje;
}

function validarORedireccionar(string $url) {
    // Validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if(!$id) {
        header("Location: ${url}");
    }

    return $id;
}