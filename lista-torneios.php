<?php 
	include 'header.php';
?>

	<div class="main center">
		<?php $consulta = $con->query("SELECT * FROM torneio WHERE ativo = 1");
			if ($consulta->rowCount()>0): ?>
				<table>
			<thead>
				<tr>
					<th>#ID</th>
					<th>NOME</th>
					<th>DATA</th>
					<th>TUMB</th>
					<th>DATA INICIO</th>
					<th colspan="3">OPÇÕES</th>
				</tr>
			</thead>
			<?php while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)): ?> 
					<tbody>

				<tr>
					<td><?= $resultado['id']; ?></td>
					<td><?= $resultado['nome']; ?></td>
					<td><?= $resultado['data_inicio']; ?></td>
					<td><?= $resultado['tumb']; ?></td>
					<td><?= $resultado['data_inicio']; ?></td>
					<td><a class="button-table azul" href="iniciar-torneio.php?id=<?= $resultado['id'];?>">Iniciar</a></td>
					<td><a class="button-table roxo" href="chaves.php?id=<?= $resultado['id'];?>">Ver</a></td>
					<td><a class="button-table vermelho" href="excluir-torneio.php?id=<?= $resultado['id'];?>">Excluir</a></td>
					<td><a class="button-table verde" href="finalizar-torneio.php?id=<?= $resultado['id'];?>">Finalizar</a></td>
				</tr>
			</tbody>
		</table>
				<?php endwhile ?>
					<?php else: ?>
						<h2>Nenhum torneio Ativo</h2>
				<?php endif ?>		
			
	</div>
