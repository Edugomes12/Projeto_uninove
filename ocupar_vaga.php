<?php
include 'config.php';

$mensagem = '';

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $placa = strtoupper(trim($_POST['placa']));
    $modelo = trim($_POST['modelo']);
    $cor = trim($_POST['cor']);

    $sql_check = "SELECT id FROM carros WHERE placa = '$placa'";
    $resultado_check = $conn->query($sql_check);

   // Verifica duplicidade de placa
    if($resultado_check->num_rows > 0) {
        $mensagem = "<div class='alert alert-danger'>🚫 Este carro já está ocupando uma vaga!</div>";
    } else {
        $sql_vaga = "SELECT id FROM vagas WHERE status = 'livre' LIMIT 1";
        $resultado_vaga = $conn->query($sql_vaga);

        if($resultado_vaga->num_rows > 0) { 
            $vaga = $resultado_vaga->fetch_assoc();
            $vaga_id = $vaga['id'];

            $sql_carro = "INSERT INTO carros (placa, modelo, cor, vaga_id)
                          VALUES ('$placa', '$modelo', '$cor', $vaga_id)";

            if($conn->query($sql_carro)) {
                $conn->query("UPDATE vagas SET status = 'ocupada' WHERE id = $vaga_id");   
                $mensagem = "<div class='alert alert-success'>✅ Carro <strong>$placa</strong> estacionado na vaga <strong>$vaga_id</strong>.</div>"; 
            } else {
                $mensagem = "<div class='alert alert-danger'>🚫 Erro ao ocupar a vaga: " . $conn->error . "</div>";
            }
        } else {
            $mensagem = "<div class='alert alert-warning'>⚠️ Não há vagas livres disponíveis no momento.</div>";
        }
    } 
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Carro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background-color: #9EC6F4;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .shape{
            position: absolute;
            width: 300px;
            height: 300px;
            border-color: #3E64C5;
            border-style: solid;
            border-width: 60px;
            z-index: -1;
        }

        .top-right {
            top: 0;
            right: 0;
            border-bottom: none;
            border-left: none;
        }

        .bottom-left {
            bottom: 0;
            left: 0;
            border-top: none;
            border-right: none;
        }

        .card-custom {
            background-color: #D9D9D9;
            border: 2px solid #000;
            border-radius: 20px;
            padding: 40px;
            width: 400px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2); 
            text-align: center;
        }

        .title-badge {
            background-color: #3E64C5;
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 1.4rem;
            font-weight: bold;
            border: 2px solid #000;
            display: inline-block;
            margin-bottom: 30px;
        }

        .input-custom {
            background-color: #D9D9D9;
            border: 1px solid #000;
            border-radius: 25px;
            padding: 10px 20px;
            margin-bottom: 15px;
        }

        .input-custom::placeholder {
            color: #777;
        }

        .btn-custom {
            background-color: #3E64C5;
            color: white;
            border: 1px solid #000;
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: bold;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background-color: #557ce0ff;
            border: 1px solid #000;
            color: white;
            cursor: pointer;
        }

        .btn-back{
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #555;
            border: 1px solid #555;
            padding: 8px 25px;
            border-radius: 20px;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .btn-back:hover {
            background-color: #555;
            color: #fff;
            border-color: #555;
            cursor: pointer;
        }
        
    </style>
</head>
<body>
    <div class="shape top-right"></div>
    <div class="shape bottom-left"></div>

    <div class="card-custom">
        <div class="title-badge">
            Cadastro Carro
        </div>

        <?php if(!empty($mensagem)) echo $mensagem; ?>

        <form method="POST">
            <input type="text" name="modelo" class="form-control input-custom" placeholder="Modelo do Carro" required>
            <input type="text" name="placa" class="form-control input-custom" placeholder="Placa do Carro" required>
            <input type="text" name="cor" class="form-control input-custom" placeholder="Cor do Carro" required>
            <button type="submit" class="btn btn-custom">Cadastrar</button>
        </form>

        <br>
        <a href="vagas.php" class="btn-back">Voltar</a>
    </div>
</body>
</html>