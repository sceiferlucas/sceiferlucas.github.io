<?php 
	session_start();
	include 'conexao.php';

	$login = $_POST['nick'];

	$senha = $_POST['senha'];

	try {

		$consulta = $con->query("SELECT * FROM players WHERE nome = '$login' && senha = '$senha'");
		if ($consulta->rowCount() == 1) {

			$dados = $consulta->fetch(PDO::FETCH_ASSOC);

			$_SESSION['msg-success'] = 'Logado com sucesso!';
			$_SESSION['login'] = 1;
			$_SESSION['nome'] = $dados['nome'];
			$_SESSION['personagem'] = $dados['personagem'];

			if ($dados['id'] == 1) {

				$_SESSION['adm'] = 1;
				header('location:adm.php');
				exit;
			}


			header('location:index.php');
		}else{
			$_SESSION['msg-fail'] = 'Login ou Senha Incorretos!';

			header('location:form-login.php');
		}
	}catch (Exception $e) {
		echo 'Erro'. $e->getMessage();
	}

	