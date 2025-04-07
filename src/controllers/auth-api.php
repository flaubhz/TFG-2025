<?php
include_once("../config/config.php");
include("../models/usersModel.php");
session_start();
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);


switch ($method) {
    case "POST":
        if (isset($data["mail"]) && isset($data["pass"])) { //El $pass falla porque desde el JS le envío passwd(corregido)
            $mail = $data["mail"];
            $pass = $data["pass"];
            

            // Esta variable llama a la función que creamos en el modelo y le pasamos los parametros para validar usuario
            $loginResult = login($mail, $pass);

            // Procesamos el resultado y preparamos el JSON con JSON encode para enviarlo al JS de verificacion (importante revisar rutas)
            if ($loginResult["success"] == true){
                $loginResult["redirect_url"]="../views/projects.html";
                $_SESSION["Id"] = $loginResult["Id"];  //NO FUNCIONA
                $_SESSION["Nombre"] = $loginResult["Nombre"]; //NO FUNCIONA
                $_SESSION["Correo"] = $data["mail"]; //NO FUNCIONA
                echo json_encode($loginResult);
                exit;
            }
            else {
                // Si el login no funciona, devolvemos el mensaje de error del modelo (revisar rutas y comprobar hasta que capa llegamos)
                echo json_encode($loginResult);
            }
        } else {
            // Si faltan parámetros en la solicitud enviamos mensaje de error desde el controlador (arreglar el tema de pass)
            echo json_encode([
                "success" => false,
                "message" => "Datos de login faltantes"
            ]);
        }
        break;

    case "GET":
        // EL case get lo utilizamos para cerrar sesión (importante redireccionar al usuario a login.html)
        if (isset($_GET['logout'])) {
            session_start();
            $_SESSION["Nombre"] = null;
            $_SESSION["Correo"] = null;
            session_destroy();
            echo json_encode([
                "success" => true,
                "message" => "Sesión cerrada correctamente",
                "redirect_url" => "../views/login.html"
            ]);
        }
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Método no permitido",
        ]);
}
?>
