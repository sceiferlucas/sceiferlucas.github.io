<?php 
	include 'conexao.php';

	$id_torneio = $_GET['id'];
	$data = date('Y/m/d');



	try{
		$finaliza = $con->query("UPDATE torneio SET data_fim = '$data', ativo = 0 WHERE id = '$id_torneio'");
		$_SESSION['msg-success'] = 'Torneio Finalizado com Sucesso!';
		header('location:lista-torneios.php');
	}catch(PDOException $e){
		echo 'Erro '.$e->getMessage();
	}
	