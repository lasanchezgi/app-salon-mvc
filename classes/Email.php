<?php
    namespace Classes;
    use PHPMailer\PHPMailer\PHPMailer;

    class Email {
        public $email;
        public $nombre;
        public $token;

        public function __construct($email, $nombre, $token)
        {
            $this->email = $email;
            $this->nombre = $nombre;
            $this->token = $token;   
        }

        public function enviarConfirmacion() {
            // Crear el objeto de email
            $mail = new PHPMailer();
            // Protocolo de envios de email
            $mail->isSMTP();
            // Atributos de Mailtrap
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '96e4a64d61af4b';
            $mail->Password = '46524a3b5d2a77';

            // Desde donde se envia
            $mail->setFrom('cuentas@appsalon.com');
            $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
            $mail->Subject = 'Confirma tu cuenta';

            // Declarar uso del HTML
            $mail->isHTML(TRUE);
            $mail->CharSet = 'UTF-8';

            // Contenido del email
            $contenido = '<html>';
            $contenido .= "<p><strong>¡Hola " . $this->nombre .  "!</strong> Has creado tu cuenta en App Salón, solo debes confirmarla presionando el siguiente enlace</p>";
            $contenido .= "<p>Presiona aquí: <a href='http://localhost:5000/confirmar-cuenta?token=" . $this->token . "'>Confirmar cuenta</a>";        
            $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
            $contenido .= '</html>';
            $mail->Body = $contenido;

            // Enviar email
            $mail->send();
        }

        public function enviarInstrucciones() {
            // Crear el objeto de email
            $mail = new PHPMailer();
            // Protocolo de envios de email
            $mail->isSMTP();
            // Atributos de Mailtrap
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '96e4a64d61af4b';
            $mail->Password = '46524a3b5d2a77';

            // Desde donde se envia
            $mail->setFrom('cuentas@appsalon.com');
            $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
            $mail->Subject = 'Restablece tu password';

            // Declarar uso del HTML
            $mail->isHTML(TRUE);
            $mail->CharSet = 'UTF-8';

            // Contenido del email
            $contenido = '<html>';
            $contenido .= "<p><strong>¡Hola " . $this->nombre .  "!</strong> Has solicitado re-establecer tu password, sigue el siguiente enlace para hacerlo.</p>";
            $contenido .= "<p>Presiona aquí: <a href='http://localhost:5000/recuperar?token=" . $this->token . "'>Restablecer password.</a>";        
            $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
            $contenido .= '</html>';
            $mail->Body = $contenido;

            // Enviar email
            $mail->send();
        }
    }