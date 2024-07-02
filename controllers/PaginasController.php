<?php 

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router) {

        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }
    public static function nosotros(Router $router) {

        $router->render('paginas/nosotros');

    }
    public static function propiedades(Router $router) {

        $propiedades = Propiedad::all();

        $router -> render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);

    }
    public static function propiedad(Router $router) {

        $id = validarORedireccionar('/propiedades');

        // Buscar la propiedad por su id
        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);

    }
    public static function blog(Router $router) {


        $router->render('paginas/blog');
    }
    public static function entrada(router $router) {

        $router->render('paginas/entrada');

    }
    public static function contacto(Router $router) {

        $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $respuestas = $_POST['contacto'];

            // Crear una instancia de PHPMailer
            $mail = new PHPMailer();

            // Configurar SMTP
            $mail->isSMTP();
            $mail->Host ='sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'd488a2ae9d0fda';
            $mail->Password = '85e2b1550530ee';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            // Configurar el contenido del mail
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un Nuevo Mensaje';

            // habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Definir el contenido
            $contenido = '<html>';
            $contenido .= ' <p>Tienes un nuevo mensaje de ' . $respuestas['nombre'] . ' </p>';
            // Enviar de forma condicional algunos campos
            if($respuestas['contacto'] === 'telefono') {
                $contenido .= ' <p>Solicitando contacto al telefono: ' . $respuestas['telefono'] . ' </p>';
                $contenido .= ' <p>En la fecha de contacto  ' . $respuestas['fecha'] . '</p>';
                $contenido .= ' <p>Sobre las:  ' . $respuestas['hora'] . 'h</p>';
            } else {
                $contenido .= ' <p>Solicitando contacto al email: ' . $respuestas['email'] . ' </p>';
            }
            $contenido .= ' <p>Le escribe lo siguiente:  ' . $respuestas['mensaje'] . '</p>';
            $contenido .= ' <p>Vende o Compra:  ' . $respuestas['tipo'] . '</p>';
            $contenido .= ' <p>Precio o Presupuesto:  ' . $respuestas['precio'] . '€</p>';
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML';

            // Enviar el email
            if($mail->send()) {
                $mensaje = "Mensaje enviado Correctamente";
            } else  {
                $mensaje = "El mensaje no se pudo enviar...";
            }
            


        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }


}