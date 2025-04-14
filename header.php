<?php
	session_start();
	include 'conexao.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	
	<title>DOJO FAROFA</title>
</head>
<body>
	<header>
		<h1>DOJO FAROFA TOURNAMENT</h1>
	</header>
	<div id="menu">
		<?php 
		if (isset($_SESSION['login']) && $_SESSION['login'] == 1) {?>
			<p><?php echo 'Olá '.$_SESSION['nome']; ?></p> <a href="sair.php">Deslogar</a>
			<?php if (isset($_SESSION['adm']) && $_SESSION['adm'] == 1): ?>
				<p><a href="adm.php">Adiministração</a>
			<?php endif ?>
		<?php }else{?>
			<a href="form-login.php">Login</a> <a href="form-cadastro.php">Cadastre-se</a>		 
		<?php }?>
		
	</div>

	<?php 

		 if (isset($_SESSION['msg-success'])) {
			echo '<h2 class="msg-success">'.$_SESSION['msg-success'].'</h2>';
			unset($_SESSION['msg-success']);
		}

		if (isset($_SESSION['msg-fail'])) {
			echo '<h2 class="msg-fail">'.$_SESSION['msg-fail'].'</h2>';
			unset($_SESSION['msg-fail']);
		}

	 ?>