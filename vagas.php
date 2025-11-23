<?php
include 'config.php';

$total_vagas = 50; // Número total de vagas

$sql = "SELECT COUNT(*) AS ocupadas FROM vagas WHERE status = 'ocupada'";
$resultado = $conn->query($sql);
$row = $resultado->fetch_assoc();

$vagas_ocupadas = $row['ocupadas'];
$vagas_disponiveis = $total_vagas - $vagas_ocupadas;

echo "<h2> Situação do Estacionamento </h2>";

if($vagas_disponiveis > 0){
    echo "<p style='color: green;'> Há vagas disponíveis! 🟢</p>";
    echo "<p> Vagas livres: <strong>$vagas_disponiveis</strong></p>";

    echo "<br><a href='ocupar_vaga.php' style='
        display:inline-block;
        padding:10px 15px;
        background-color:green;
        color:white;
        text-decoration:none;
        border-radius:5px;
        '>Ocupar vaga</a>";

    echo "<br><br><a href='saida.php' style='
        display:inline-block;
        padding:10px 15px;
        background-color:blue;
        color:white;
        text-decoration:none;
        border-radius:5px; '>Retirar Meu Carro</a>";

} else {
    echo "<p style='color: red;'> Estacionamento lotado! 🔴</p>";
    echo "<br><a href='saida.php' style='
        display:inline-block;
        padding:10px 15px;
        background-color:blue;
        color:white;
        text-decoration:none;
        border-radius:5px; '>Retirar Meu Carro</a>";
}


$conn->close();
?>