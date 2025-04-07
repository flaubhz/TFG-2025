<?php
header("Content-Type: application/json");

include("../config/config.php");
include("../models/projectsModel.php");

// Iniciamos la sesión para leer las variables de sesión (configuradas previamente en auth-api)
session_start();

// Verificamos que efectivamente el ID se ha cargado, si no, enviamos un mensaje de error
if (!isset($_SESSION["Id"])) {
    echo json_encode(["success" => false, "message" => "Identificador no detectado."]);
    exit; // Terminamos la ejecución aquí si no hay sesión activa
} else {
    $ownerId = $_SESSION["Id"];  // En caso de que haya cargamos el valor del ID para usarlo e identificar al usuario propietario
}

// Verificamos si el parámetro id está presente en la URL
if (isset($_GET["id"])) {
    $projectId = $_GET["id"];
} else {
    $projectId = null;
}

$method = $_SERVER["REQUEST_METHOD"];
$data = json_decode(file_get_contents('php://input'), true); // Obtenemos los datos en formato JSON de la solicitud

switch ($method) {
    case "POST":
        // Creamos un nuevo proyecto
        if (isset($data["name"])) {
            createProject($data["name"], $ownerId); // Llamamos a la función para crear el proyecto
        } else {
            echo json_encode(["response" => "Faltan parámetros: nombre del proyecto."]);
        }
        break;

    case "GET":
        // Leemos los proyectos del usuario
        if (isset($ownerId) && $ownerId !== null) {
            readProject($ownerId);  // Llamamos a la función para leer los proyectos de este usuario
        } else {
            echo json_encode(["response" => "No se ha proporcionado el ID del Usuario en GET."]);
        }
        break;

    case "PUT":
        // Actualizamos un proyecto existente
        if ($projectId !== null && isset($data["name"])) {
            updateProject($projectId, $data["name"]); // Llamamos a la función para actualizar el proyecto
        } else {
            echo json_encode(["response" => "Faltan parámetros: 'id' y 'name' son obligatorios en PUT."]);
        }
        break;

    case "DELETE":
        // Eliminamos un proyecto
        if ($projectId !== null) {
            deleteProject($projectId);  // Llamamos a la función para eliminar el proyecto
        } else {
            echo json_encode(["response" => "No se ha proporcionado el ID del proyecto en DELETE."]);
        }
        break;

    default:
        // Si el método no es válido, respondemos con error
        echo json_encode(["response" => "Método no permitido."]);
        break;
}
?>
