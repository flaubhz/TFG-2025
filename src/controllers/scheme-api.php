<?php

    header("Content-Type:application/json");

    include("../config/config.php");

    include("../models/schemesModel.php");

    $method = $_SERVER['REQUEST_METHOD'];

    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($_GET["id"])) {
        $taskId = $_GET["id"];
    } else {
        $taskId = null;
    }
    
    
        switch ($method){

            case "POST":
                $name = $data["name"];
                $responsible = $data["responsible"];
                $deadline = $data["deadline"];
                $priorities = $data["priorities"];
                $state = $data["state"];
                createTask($name, $responsible,$deadline,$priorities,$state);
                break;
                
            case "GET":
                if($taskId !=="null"){

                readTask($taskId);
            }
                else{
                    echo json_encode(["response"=>"No se ha cargado el Id de la tarea en GET."]);
                }
                    break;
                case "PUT":
                    
                    if($taskId !=="null"){
                    $name=$data["name"];
                    $responsible= $data["responsible"];
                    $priorities= $data["priorities"];
                    $deadline= $data["deadline"];
                    $state= $data["state"];
                    updateTask($taskId,$name, $responsible,$deadline,$priorities,$state);
                }
                    else{
                        echo json_encode(["response"=>"No se ha cargado el Id de la tarea en PUT."]);
                    }
                    break;

                case "DELETE":
                    if($taskId !=="null"){

                    deleteTask($taskId);
                }
                    else{
                        echo json_encode(["response"=>"No se ha cargado el Id de la tarea en DELETE."]);
                    }
                    break;
        }
    
    



?>