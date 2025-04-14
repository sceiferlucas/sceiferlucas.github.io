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

// Criar rodadas até restar apenas um jogador
while (count($players) > 1) {
    $nextRoundPlayers = [];
    $numMatches = ceil(count($players) / 2);
    $matchNumber = 1; // Número da partida dentro do round

    for ($i = 0; $i < $numMatches * 2; $i += 2) {
        // Para a primeira rodada, cria os IDs dos jogadores
        if ($round == 1) {
            if (isset($players[$i])) {
                $id_player1 = uniqid($i . '_', true); // Cria ID no Round 1
                $player1 = $players[$i]['nome'];
                $char1 = $players[$i]['personagem'];
            } else {
                $id_player1 = null;
                $player1 = "Vazio";
                $char1 = "Vazio";
            }

            if (isset($players[$i + 1])) {
                $id_player2 = uniqid($i + 1 . '_', true); // Cria ID no Round 1
                $player2 = $players[$i + 1]['nome'];
                $char2 = $players[$i + 1]['personagem'];
            } else {
                $id_player2 = null;
                $player2 = "Vazio";
                $char2 = "Vazio";
            }
        } else {
            // Nos rounds seguintes, não cria ID para os jogadores ainda
            $id_player1 = isset($players[$i]) ? $players[$i]['id'] : null;
            $player1 = isset($players[$i]) ? $players[$i]['nome'] : "Vazio";
            $char1 = isset($players[$i]) ? $players[$i]['personagem'] : "Vazio";

            $id_player2 = isset($players[$i + 1]) ? $players[$i + 1]['id'] : null;
            $player2 = isset($players[$i + 1]) ? $players[$i + 1]['nome'] : "Vazio";
            $char2 = isset($players[$i + 1]) ? $players[$i + 1]['personagem'] : "Vazio";
        }

        // Inserir partida no banco de dados com os IDs, personagens e número da partida no round
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

        $matchNumber++; // Incrementa o número da partida dentro do round

        // ✅ Nos rounds seguintes, os jogadores não recebem um novo ID
        if (isset($players[$i])) {
            $nextRoundPlayers[] = [
                "id" => isset($players[$i]['id']) ? $players[$i]['id'] : null, // Mantém o ID dos jogadores do Round 1
                "nome" => null,
                "personagem" => null
            ];
        }
    }

    // Avança para a próxima rodada
    $players = $nextRoundPlayers;
    $round++;
}

$_SESSION['msg-success'] = 'Torneio iniciado! Todas as partidas foram criadas com os personagens.';
header('location:lista-torneios.php');
?>
