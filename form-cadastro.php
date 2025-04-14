<?php include 'header.php'; ?>

<div id="principal">
	<div class="form">
		<form action="valida-cadastro.php" method="post">

		<h3>ESCREVA SEU NOME OU APELIDO (COMO ESTÁ NO JOGO)</h3>

		<input type="text" name="nick" placeholder="SEU NICK">

		<input type="password" name="senha" placeholder="SUA SENHA">

		<select name="personagem">
		
				<option default>ESCOLHA SEU PERSONAGEM</option>
				<?php

				$consulta = $con->query('SELECT * FROM personagens ORDER BY nome'); 
				?>
					<?php while($personagens = $consulta->fetch(PDO::FETCH_ASSOC)){ ?>
						<option value="<?= $personagens['id']; ?>"><?= $personagens['nome']; ?></option>
				<?php } ?>
		</select>

		<h3>COLOQUE UMA CHAVE PIX PARA RECEBER O PREMIO</h3>
		<input type="text" name="pix" placeholder="SUA CHAVE PIX"> 

		<input type="submit" href="cadastrar-usuario.php" value="CADASTRAR">
		</form>
	</div>
</div>