<?php 
	session_start();
	include 'conexao.php';

	// var_dump($_POST);
	// die();

	$nick = $_POST['nick'];
	$senha = $_POST['senha'];
	$personagem = $_POST['personagem'];
	$pix = $_POST['pix'];

	try{
		$inserir = $con->query("INSERT INTO players (nome, senha, personagem, nivel, pix) VALUES ('$nick', '$senha', '$personagem', 0, '$pix')");
		$_SESSION['msg-success'] = 'Cadastrado com Sucesso!';
		header('location:index.php');

	}catch(PDOException $e){

		echo $e->getMessage();
	}

	