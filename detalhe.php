<?php include 'header.php';
			$id_torneio = $_GET['id'];
			// var_dump($_SESSION);
			// die();

			$consulta = $con->query("SELECT * FROM torneio WHERE id = '$id_torneio' && ativo = 1");
			if ($consulta->rowCount()>0) {
				$torneio = $consulta->fetch(PDO::FETCH_ASSOC);
			 ?>

					<div id="principal">
					<h1><?= $torneio['nome']; ?></h1>

					<div id="tumb">
						<img src="uploads/<?= $torneio['tumb']; ?>">
					</div>
					<div class="descricao">
						<h2>Sobre:</h2>
						<p><?= $torneio['descricao']; ?> <br>
					</div>
					<div class="descricao">
						<h3>Taxa de inscrição: <?= $torneio['inscricao']; ?> R$</h3>
					</div>
					<div class="descricao">
						<h3>Premio: <?= $torneio['pote']; ?> R$</h3>
					</div>
					<div class="descricao">
						<h3>Formato: <?php if ($torneio['formato'] == 0): ?>
							Eliminação Unica (Mata mata)
						<?php endif ?>
							
							<?php if ($torneio['formato'] == 1): ?>
								Eliminação Dupla (Repescagem)
							<?php endif ?>
						</h3>
					</div>
					
					<div class="descricao">
						<h3>Data: <?= $torneio['data_inicio'];?></h3>
					</div>
					<?php if ($torneio['registro'] == 1): ?>

    <?php if (isset($_SESSION['login']) && $_SESSION['login'] == 1): ?>

        <?php if (!isset($_SESSION['registrado']) || $_SESSION['registrado'] != 1): ?>
            <a href="registrar-me.php?id=<?= $id_torneio; ?>">ME REGISTRAR</a>
        <?php else: ?>
            <a href="chaves.php?id=<?= $id_torneio; ?>">VER TORNEIO EM ANDAMENTO</a>
        <?php endif; ?>

    <?php else: ?>

        <h2>FAÇA O LOGIN PARA SE REGISTRAR</h2>

    <?php endif; ?>

<?php else: ?>

    <p>Nenhum torneio ativo no momento</p>

<?php endif; ?>

						<?php }else{
							echo "Nenhum torneio ativo no momento";
						 } ?>
 

	