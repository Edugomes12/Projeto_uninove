<?php
include 'config.php';

$placa = strtoupper(trim($_POST['placa']));

//Busca o carro pela placa
$sql = "SELECT id, vaga_id FROM carros WHERE placa = '$placa' LIMIT 1";
$resultado = $conn->query($sql);

if($resultado->num_rows == 0) {
    echo "<p style= 'color:red'> Nenhum carro encontrado com essa placa.</p>";
    echo "<a href= saida.php> Voltar </a>";
    exit;
}

$carro = $resultado->fetch_assoc();
$vaga_id = $carro['vaga_id'];

//Apaga o carro
$conn->query("DELETE FROM carros WHERE id = {$carro['id']}");

//Libera a vaga
$conn->query("UPDATE vagas SET status = 'livre' WHERE id = $vaga_id");

echo "<p style 'color:green'> Vaga liberada com sucesso!</p>";
echo "<a href='vagas.php'> Voltar para a situação do estacionamnento</a>";
 ?>