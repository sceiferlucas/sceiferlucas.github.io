<?php
session_start(); // Iniciar sessão para exibir mensagens
include 'conexao.php';

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$pote = $_POST['pote'];
$data = date('Y/m/d');
$inscricao = $_POST['inscricao'];
$formato = $_POST['formato'];

// Verifica se um arquivo foi enviado
if (isset($_FILES['tumb']) && $_FILES['tumb']['error'] == 0) {
    
    $arquivo = $_FILES['tumb'];
    $nomeOriginal = basename($arquivo['name']);
    $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

    // Extensões permitidas
    $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($extensao, $extensoesPermitidas)) {

        // Gera um nome único para evitar conflitos
        $novoNome = uniqid() . "." . $extensao;
        $pastaDestino = "uploads/";

        // Criar a pasta caso não exista
        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0755, true);
        }

        // Move o arquivo para a pasta
        if (move_uploaded_file($arquivo['tmp_name'], $pastaDestino . $novoNome)) {
            
            // Agora insere os dados no banco de dados
            try {
                $inserir = $con->query("INSERT INTO torneio (
                    nome,
                    tumb,
                    descricao,
                    pote,
                    data_inicio,
                    inscricao,
                    formato,
                    registro,
                    ativo
                ) VALUES (
                    '$nome',
                    '$novoNome',  -- Aqui estava faltando uma vírgula no seu código original
                    '$descricao',
                    '$pote',
                    '$data',
                    '$inscricao',
                    '$formato',
                    1,
                    1
                )");

                $_SESSION['msg-success'] = 'Torneio cadastrado com sucesso!';
                header('location:index.php');
                exit(); // Finaliza o script após o redirecionamento
            } catch (Exception $e) {
                echo 'Erro ao cadastrar: ' . $e->getMessage();
            }
        } else {
            echo "Erro ao mover o arquivo.";
        }
    } else {
        echo "Formato inválido. Apenas JPG, JPEG, PNG e GIF são permitidos.";
    }
} else {
    echo "Nenhuma imagem foi enviada ou ocorreu um erro no upload.";
}
?>
