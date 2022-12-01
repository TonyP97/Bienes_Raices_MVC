<?php

namespace Model;

class Admin extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password'];

    // Definir los atributos
    public $id;
    public $email;
    public $password;

    // Constructor
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar() {
        if(!$this->email) {
            self::$errores[] = "Debes añadir un email";
        }

        if(!$this->password) {
            self::$errores[] = "Debes añadir un password";
        }

        return self::$errores;
    }

    public function existeUsuario() {
        // Revisar si el usuario existe o no
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);

        // Verificar la cantidad de resultados
        if(!$resultado->num_rows) {
            self::$errores[] = "El usuario no existe";
            return;
        }

        // Verificar si el password es correcto o no
        return $resultado;
    }

    public function comprobarPassword(){
        // Revisar si el password es correcto o no
        $auth = $this->existeUsuario();

        if($auth) {
            // Verificar el password
            $usuario = $auth->fetch_object();

            $autenticado = password_verify($this->password, $usuario->password);

            if($autenticado) {
                // Autenticar al usuario
                $this->autenticar($usuario);
            } else {
                self::$errores[] = "Contraseña incorrecta";
            }
        }
    }

    public function autenticar() {
        session_start();

        // Llenar el arreglo de la sesión
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');
    }
}