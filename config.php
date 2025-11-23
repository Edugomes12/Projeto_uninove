<?php
$host = "localhost";
$usuario = "root";
$senha = "1234@";
$banco = "estacionamento";

$conn = new mysqli($host, $usuario, $senha, $banco);

//checa erros de conexao
if($conn->connect_error){
    die("Falha na conexao: " . $conn->connect_error);
}

?>