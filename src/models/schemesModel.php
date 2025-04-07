<?php

header("Content-Type:application/json");

include("../config/config.php");

$method = $_SERVER['REQUEST_METHOD'];

function createTask ($name, $responsible,$deadline,$priorities,$state){
    global $conn;
    $sql="INSERT INTO tareas (Nombre,Encargado,Fecha_limite,Prioridad,Estado) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare  ($sql);
    if ($stmt){
        $stmt->bind_param('sssii',$name, $responsible,$deadline,$priorities,$state);

        if ($stmt->execute()){
            echo json_encode(["response"=>"Tarea creada con éxito."]);
        }
        else{
            echo json_encode(["response"=>"No se ha podido crear la tarea."]);
        }
    }
    else {
        echo json_encode(["response"=>"Error al preparar la consulta: ".$conn->error]);
    }
}

function readTask() {
    global $conn;
    $sql = "SELECT  t.Nombre,t.Encargado,t.Fecha_limite, p.Nombre AS Prioridad, e.Nombre AS Estado FROM tareas t
    JOIN prioridades p ON Prioridad=p.Id
    JOIN estados e ON Estado=e.Id";
    $result = $conn->query($sql);
    $tareas = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tareas[] = $row;
        }
        echo json_encode($tareas);
    } else {
        echo json_encode(["message" => "No se encontraron tareas"]);
    }
}
//Hay que accordarse de poner en la base de datos en la tabla de tareas la clave ajena del id_proyecto
function updateTask($name, $responsible,$deadline,$priorities,$state) {
    global $conn;
    $sql = "UPDATE tareas SET name = ?, responsible = ?, priorities = ?, deadline = ?, state = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sssii", $name, $responsible,$deadline,$priorities,$state);
        

        if ($stmt->execute()) {
            echo json_encode(["response"=>"Tarea actualizada con éxito."]);
        } else {
            echo json_encode(["response"=>"No se ha podido actualizar la tarea."]);
        }
    } else {
        echo json_encode(["response"=>"Error al preparar la consulta: ".$conn->error]);
    }
    $stmt->close();
    $conn->close();
}


function deleteTask($id) {
    global $conn;
    $sql = "DELETE FROM tareas WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id); // `i` para un valor entero (eliminar esto despues de buscarlo para que no moleste)
        
        if ($stmt->execute()) {
            echo "La tarea fue eliminada con éxito.";
        } else {
            echo "No se ha encontrado ninguna tarea para eliminar.";
        }
    } else {
        echo json_encode(["response"=>"Error al preparar la consulta: ".$conn->error]);
    }
    $stmt->close();
    $conn->close();
}

?>