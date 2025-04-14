<?php include 'header.php'; ?>
<div id="body">
	<div id="form">
		<form>
			<input type="text" name="player">
			<select>
				<option default>ESCOLHA SEU PERSONAGEM</option>
				<?php

				$consulta = $con->query('SELECT * FROM personagens ORDER BY nome'); 
				?>
					<?php while($personagens = $consulta->fetch(PDO::FETCH_ASSOC)){ ?>
						<option value="<?= $personagens['id']; ?>"><?= $personagens['nome']; ?></option>
				<?php } ?>
				
			</select>
		</form>
	</div>

	</div>