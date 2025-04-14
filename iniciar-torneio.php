<?php
include 'conexao.php';

$id_torneio = $_GET['id'];
$data = date('Y-m-d');

// Consulta os jogadores cadastrados no torneio
$consulta = $con->query("SELECT players FROM torneio WHERE id = '$id_torneio'");
$playersArray = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$playersArray || !isset($playersArray['players'])) {
    die("Erro: Nenhum jogador encontrado.");
}

// Decodifica o JSON dos jogadores
$players = json_decode($playersArray['players'], true);

if (count($players) < 2) {
    die("Jogadores insuficientes para criar partidas.");
}

// Embaralha os jogadores
shuffle($players);
$round = 1;

// Lista para armazenar os IDs das partidas criadas
$partidasAnteriores = [];

// Criar rodadas até restar apenas um jogador
while (count($players) > 1) {
    $nextRoundPlayers = [];
    $numMatches = ceil(count($players) / 2);
    $matchNumber = 1; // Número da partida dentro do round
    $partidasAtuais = []; // Armazena as partidas criadas neste round

    for ($i = 0; $i < $numMatches * 2; $i += 2) {
        if ($round == 1) {
            // Criar ID para os jogadores apenas na primeira rodada
            $id_player1 = isset($players[$i]) ? uniqid($i . '_', true) : null;
            $player1 = isset($players[$i]) ? $players[$i]['nome'] : "Vazio";
            $char1 = isset($players[$i]) ? $players[$i]['personagem'] : "Vazio";

            $id_player2 = isset($players[$i + 1]) ? uniqid($i + 1 . '_', true) : null;
            $player2 = isset($players[$i + 1]) ? $players[$i + 1]['nome'] : "Vazio";
            $char2 = isset($players[$i + 1]) ? $players[$i + 1]['personagem'] : "Vazio";
        } else {
            // Nos rounds seguintes, mantemos os IDs dos vencedores da rodada anterior
            $id_player1 = isset($players[$i]) ? $players[$i]['id'] : null;
            $player1 = null;
            $char1 = "Aguardando Partidas";

            $id_player2 = isset($players[$i + 1]) ? $players[$i + 1]['id'] : null;
            $player2 = null;
            $char2 = "Aguardando Partidas";
        }

        // Criar a partida no banco de dados
        $stmt = $con->prepare("INSERT INTO partidas (id_player1, player1, personagem1, id_player2, player2, personagem2, round, numero, torneio, data) 
                               VALUES (:id_player1, :player1, :char1, :id_player2, :player2, :char2, :round, :numero, :id_torneio, :data)");
        $stmt->bindParam(':id_player1', $id_player1);
        $stmt->bindParam(':player1', $player1);
        $stmt->bindParam(':char1', $char1);
        $stmt->bindParam(':id_player2', $id_player2);
        $stmt->bindParam(':player2', $player2);
        $stmt->bindParam(':char2', $char2);
        $stmt->bindParam(':round', $round);
        $stmt->bindParam(':numero', $matchNumber);
        $stmt->bindParam(':id_torneio', $id_torneio);
        $stmt->bindParam(':data', $data);
        $stmt->execute();

        // Pegar o ID da partida recém-criada
        $id_partida = $con->lastInsertId();
        $partidasAtuais[] = $id_partida; // Armazena ID da partida do round atual

        $matchNumber++; // Incrementa o número da partida

        // Armazena para vincular ao próximo round
        if (isset($players[$i])) {
            $nextRoundPlayers[] = ["id" => $id_partida]; // ID da partida, que servirá como referência no próximo round
        }
    }

    // Atualizar o campo `proxima_partida` do round anterior para apontar para as partidas do round atual
    if (!empty($partidasAnteriores)) {
        for ($j = 0; $j < count($partidasAnteriores); $j++) {
            if (isset($partidasAtuais[floor($j / 2)])) {
                $id_partida_atual = $partidasAtuais[floor($j / 2)];
                $stmt = $con->prepare("UPDATE partidas SET proxima_partida = :proxima WHERE id = :id");
                $stmt->bindParam(':proxima', $id_partida_atual);
                $stmt->bindParam(':id', $partidasAnteriores[$j]);
                $stmt->execute();
            }
        }
    }

    // Atualiza as partidas do round anterior
    $partidasAnteriores = $partidasAtuais;

    // Avança para a próxima rodada
    $players = $nextRoundPlayers;
    $round++;
}

$_SESSION['msg-success'] = 'Torneio iniciado! Todas as partidas foram criadas com os personagens.';
header('location:lista-torneios.php');
?>
