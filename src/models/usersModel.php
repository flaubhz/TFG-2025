<?php
require_once '../config/config.php';

function login($mail, $pass) {
    global $conn;

    // Consulta SQL preparada para evitar inyecciones en la que extraemos el correo , posteriormente verificamos la contraseña asociada
    $sql = "SELECT * FROM usuarios WHERE Correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($pass === $user['Contraseña']) {
            return [
                "success" => true,
                "message" => "Hola".$user["Nombre"],
                "Nombre" => $user["Nombre"],
                "Id" => $user["Id"],
                "Correo" => $user["Correo"],
            ];
        } else { //En caso de fallar la verificación de contraseña pasamos que el success es false y el mensaje de contraseña Incorrecta
            return [
                "success" => false,
                "message" => "Contraseña incorrecta"
            ];
        }
            } else {
                // Si el usuario no es correcto mandamos este mensaje de error
                return [
                    "success" => false,
                    "message" => "Usuario incorrecto"
                ];
            }
        }
?>
