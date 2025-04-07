<?php


$host="localhost";
$username="root";
$password="";
$dbname="plannel";

$conn= new mysqli($host,$username,$password,$dbname);

if($conn->connect_error){
    die("Error de conexión: ".$conn->connect_error);
}

?>