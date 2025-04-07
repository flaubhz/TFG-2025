<?php

header("Content-Type:application/json");


$method = $_SERVER["REQUEST_METHOD"];

function createProject($name, $ownerId) {
    global $conn;
    $sql = "INSERT INTO proyectos (Nombre, Id_Creador) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $name, $ownerId);
        if ($stmt->execute()) {
            echo json_encode(["response" => "Proyecto añadido con éxito."]);
        } else {
            echo json_encode(["response" => "Error al añadir el proyecto: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["response" => "Error al preparar la consulta: " . $conn->error]);
    }
}

function readProject($ownerId) {
    global $conn;
    $sql = "SELECT Id, Nombre FROM proyectos WHERE Id_Creador = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $ownerId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $projects = [];

            while ($row = $result->fetch_assoc()) {
                $projects[] = $row;
            }

            if (count($projects) > 0) {
                echo json_encode($projects);
            } else {
                echo json_encode(["message" => "No hay proyectos disponibles."]);
            }
        } else {
            echo json_encode(["response" => "Error al ejecutar la consulta: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["response" => "Error al preparar la consulta: " . $conn->error]);
    }
}

function updateProject($id, $name) {
    global $conn;
    $sql = "UPDATE proyectos SET Nombre = ? WHERE Id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $name, $id);
        if ($stmt->execute()) {
            echo json_encode(["response" => "Proyecto actualizado con éxito."]);
        } else {
            echo json_encode(["response" => "Error al actualizar el proyecto: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["response" => "Error al preparar la consulta: " . $conn->error]);
    }
}

function deleteProject($id) {
    global $conn;
    $sql = "DELETE FROM proyectos WHERE Id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(["response" => "Proyecto eliminado con éxito."]);
        } else {
            echo json_encode(["response" => "Error al eliminar el proyecto: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["response" => "Error al preparar la consulta: " . $conn->error]);
    }
}

?>
