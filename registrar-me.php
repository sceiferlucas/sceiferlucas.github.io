<?php
session_start();
include 'conexao.php';

if (!isset($_GET['id'], $_SESSION['nome'], $_SESSION['personagem'])) {
    die("Erro: Dados insuficientes!");
}

$id = (int) $_GET['id']; // Garante que seja um número inteiro
$player = trim($_SESSION['nome']);
$personagem = trim($_SESSION['personagem']);

try {
    // Buscar os jogadores atuais no torneio
    $consulta = $con->prepare("SELECT players FROM torneio WHERE id = :id AND ativo = 1");
    $consulta->bindParam(':id', $id, PDO::PARAM_INT);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

    // Se o torneio não existir ou estiver inativo
    if (!$resultado) {
        die("Erro: Torneio não encontrado ou inativo.");
    }

    // Verifica se "players" já contém dados válidos
    $jogadores = (!empty($resultado['players']) && json_decode($resultado['players'], true) !== null) 
        ? json_decode($resultado['players'], true) 
        : [];

        // Verifica se o nome já está no array de jogadores
    foreach ($jogadores as $jogador) {
        if ($jogador['nome'] === $player) {
            $_SESSION['msg-fail'] = 'Você já está registrado!';
            $_SESSION['registrado'] = 1;
            header('location:index.php');
            exit;
        }
    }

    // Adiciona o novo jogador
    $jogadores[] = [
        'nome' => $player,
        'personagem' => $personagem
    ];

    // Converte o array atualizado para JSON
    $jsonJogadores = json_encode($jogadores, JSON_UNESCAPED_UNICODE);

    // Atualiza o banco de dados
    $inserir = $con->prepare("UPDATE torneio SET players = :players WHERE id = :id");
    $inserir->bindParam(':players', $jsonJogadores, PDO::PARAM_STR);
    $inserir->bindParam(':id', $id, PDO::PARAM_INT);
    $inserir->execute();

    $_SESSION['msg-success'] = 'Registrado com sucesso, Boa Sorte!';

 
    header('location:index.php');
    exit;
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}
