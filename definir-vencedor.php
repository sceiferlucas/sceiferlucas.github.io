<?php 

	session_start();
	include 'conexao.php';

	$winner = $_GET['id_player'];

	$numero_partida = $_GET['numero'];
	$id_partida = $_GET['id_partida'];

	$consulta = $con->query("SELECT * FROM partidas WHERE id = '$id_partida'");
	$partida = $consulta->fetch(PDO::FETCH_ASSOC);

	$id_torneio = $partida['torneio'];

	$proxima_partida = $partida['proxima_partida'];

	try {

		$inserir = $con->query("UPDATE partidas SET winner = '$winner', finalizado = 1 WHERE numero = '$numero_partida' AND id = '$id_partida'");

		$busca_vencedor = $con->query("SELECT winner FROM partidas WHERE id = '$id_partida'");
		$vencedor = $busca_vencedor->fetch();

		$consulta1 = $con->query("SELECT id_player1, id_player2, player1, player2, personagem1, personagem2 FROM partidas WHERE id_player1 = '$winner' OR id_player2 = '$winner'");
		$dados1 = $consulta1->fetch(PDO::FETCH_ASSOC);

		if ($dados1['id_player1'] == $winner) {
	    // O vencedor é player1, então busca no campo player1
		    $nome_vencedor = $dados1['player1'];
		    $personagem_vencedor = $dados1['personagem1'];
		} elseif ($dados1['id_player2'] == $winner) {
		    // O vencedor é player2, então busca no campo player2
		    $nome_vencedor = $dados1['player2'];
		    $personagem_vencedor = $dados1['personagem2'];
		} else {
		    $nome_vencedor = null;  // Caso não encontre
		}

		$nome_vencedor;

		//buscar informações da proxima partida para saber em qual campo vai inserir o player vencedor

		$proxima = $con->query("SELECT * FROM partidas WHERE id = '$proxima_partida' AND round > 1");

		$dados = $proxima->fetch(PDO::FETCH_ASSOC);
		// var_dump($dados);
		// die();

		$player = empty($dados['player1']) ? 'player1' : 'player2';
		if ($player === 'player1') {
			$campo_personagem = 'personagem1';
		}else{
			$campo_personagem = 'personagem2';
		}
		// var_dump($player);
		// die();
		$id = $dados['id'];

		$inserir = $con->query("UPDATE partidas SET $player = '$nome_vencedor', $campo_personagem = '$personagem_vencedor' WHERE id = '$id'");

		$_SESSION['msg-success'] = 'vencedor definido com Sucesso!';

		header("location:chaves.php?id=$id_torneio");

	} catch (Exception $e) {
		echo 'Erro '.$e->getMessage();
	}

	
