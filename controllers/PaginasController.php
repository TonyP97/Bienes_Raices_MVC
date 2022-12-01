<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;
use Model\Propiedad;
use Model\Entrada;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index( Router $router ) {
    
        $propiedades = Propiedad::get(3);
        $inicio = true;
        $entradas = Entrada::get(2);

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio,
            'entradas' => $entradas
        ]);
    }
    public static function nosotros( Router $router ) {
        
        $router->render('paginas/nosotros');
    }
    public static function propiedades( Router $router ) {
    
        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad( Router $router) {
        
        $id = validarORedireccionar('/propiedades');

        $propiedad = Propiedad::find($id);
        $vendedor = Vendedor::find($propiedad->vendedores_id);
        
        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad,
            'vendedor' => $vendedor
        ]);
    }
    public static function blog( Router $router ) {
    
        $entradas = Entrada::all();

        $router->render('paginas/blog', [
            'entradas' => $entradas
        ]);

    }
    public static function entrada( Router $router ) {
        
        $id = validarORedireccionar('/blog');

        $entrada = Entrada::find($id);

        $router->render('paginas/entrada', [
            'entrada' => $entrada
        ]);
    
    }
    public static function contacto( Router $router ) {

        $mensaje = null;
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto'];



            // Crear una instancia de PHPMailer
            $mail = new PHPMailer();

            // Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '3c0ed5d0ea8b4b';
            $mail->Password = '70f5f095f28735';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            // Configurar el contenido del email
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un nuevo mensaje';

            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . '</p>';
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . '</p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo'] . '</p>';
            $contenido .= '<p>Precio o Presupuesto: $' . $respuestas['precio'] . '</p>';

            // Enviar de forma condicional algunos campos
            if($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p>Eligió ser contactado por teléfono</p>';
                $contenido .= '<p>Telefono: ' . $respuestas['telefono'] . '</p>';
                $contenido .= '<p>Fecha: ' . $respuestas['fecha'] . '</p>';
                $contenido .= '<p>Hora: ' . $respuestas['hora'] . '</p>';
            } else {
                $contenido .= '<p>Eligió ser contactado por email: </p>';
                $contenido .= '<p>Email: ' . $respuestas['email'] . '</p>';
            }
            $contenido .= '</html>';

            $mail->Body = $contenido;

            $mail->AltBody = 'Este es el contenido del mensaje en texto plano';
            $mail->AltBody .= '  Nombre: ' . $respuestas['nombre'];
            $mail->AltBody .= '  Telefono: ' . $respuestas['telefono'];
            $mail->AltBody .= '  Mensaje: ' . $respuestas['mensaje'];
            $mail->AltBody .= '  Vende o Compra: ' . $respuestas['tipo'];
            $mail->AltBody .= '  Precio o Presupuesto: $' . $respuestas['precio'];
            $mail->AltBody .= '  Como desea ser contactado: ' . $respuestas['contacto'];
            $mail->AltBody .= '  Fecha: ' . $respuestas['fecha'];
            $mail->AltBody .= '  Hora: ' . $respuestas['hora'];

            // Enviar el email
            if($mail->send()) {
                $mensaje = 'Mensaje enviado correctamente';
            } else {
                $mensaje = 'El mensaje no se pudo enviar';
            }
        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    
    }
}