<?php include 'header.php'; ?>

<div id="principal">
	<div class="form">
		<form action="valida-torneio.php" method="post" enctype="multipart/form-data">

		<h3>ESCREVA O NOME DO TORNEIO</h3>

		<input type="text" name="nome" placeholder="NOME DO TORNEIO">

		<h3>ESCOLHA UMA ARTE PARA A TUMB</h3>

		<input type="file" name="tumb" accept="image/*" id="fileInput" >

		 <img id="preview" src="" alt="Pré-visualização" style="max-width: 300px; display: none;">

		<h3>DESCREVA RAPIDAMENTE O TORNEIO</h3>

		<textarea name="descricao" style="width:80%; min-height: 200px;">
			
		</textarea>

		<input type="text" name="pote" placeholder="QUAL O POTE">

		<input type="text" name="inscricao" placeholder="TAXA DE INSCRIÇÃO">

		<select name="formato">
			<option>Eliminação Unica</option>
			<option>Eliminação Dupla</option>
		</select>

		<input type="submit" href="cadastrar-usuario.php" value="CADASTRAR">
		</form>
	</div>
</div>
<script src="image-preview.js"></script>