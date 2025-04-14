<?php 

include 'conexao.php';

	$id_torneio = $_GET['id'];
	try {
		$delete = $con->query("DELETE FROM torneio WHERE id = '$id_torneio'");
		$delete_partidas = $con->query("DELETE FROM partidas WHERE torneio = '$id_torneio'");
		$_SESSION['msg-success'] = 'Torneio Excluido com Sucesso!';
		header('location:lista-torneios.php');
	} catch (Exception $e) {
		echo 'Erro '.$e->getMessage();
	}
	