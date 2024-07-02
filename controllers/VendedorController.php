<?php

namespace Controllers;
use MVC\Router;
use Model\Vendedor;

class VendedorController {
    public static function crear(Router $router) {
        
        $errores = Vendedor::getErrores();

        $vendedor = new Vendedor;

        // Ejecutar el código despues de que el usuario envie el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Crear una nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);

            // Validar quye no hayan campos vacios
            $errores = $vendedor->validar();

            // No hay errores
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

        $errores = Vendedor::getErrores();
        $id = validarORedireccionar('/admin');

        // Obtener datos del vendedor a actualizar
        $vendedor = Vendedor::find($id);

        // Ejecutar el código despues de que el usuario envie el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar los vlaores
            $args = $_POST['vendedor'];

            // SIncronizar el objeto en memoria de lo que el user escribe
            $vendedor->sincronizar($args);

            // Errores
            $errores = $vendedor->validar();

            // Guardar los datos
            if(!$errores) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/actualizar', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }
    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST' ) {

            // Valida el id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id) {
                // Valida el tipo a eliminar
                $tipo = $_POST['tipo'];

                if(validarTipoContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}