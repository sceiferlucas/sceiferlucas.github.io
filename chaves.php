<?php 
include 'header.php';
?>
<div class="mae alinhamento-chave">
<?php

$id_torneio = $_GET['id'];

// Consulta para obter o maior número de rounds no torneio
$consulta3 = $con->query("SELECT MAX(round) AS max_round FROM partidas WHERE torneio = '$id_torneio'");
$round = $consulta3->fetch(PDO::FETCH_ASSOC);
$maxRound = (int) ($round['max_round'] ?? 0); // Força a conversão para inteiro

// Obtém as partidas do round 1
$consultaPools = $con->query("SELECT * FROM partidas WHERE torneio = '$id_torneio' AND round = 1");
$pools = $consultaPools->fetchAll(PDO::FETCH_ASSOC);
// var_dump($pools);
// die();
    if (empty($pools)) {
        echo '<h1>Nada ainda</h1';
        die();
    }
?>

<div class="main">
    <h1>Polls</h1>
    <?php foreach ($pools as $pool): ?>
  <div class="chave <?php echo ($pool['finalizado'] == 1) ? 'disabled' : ''; ?>">

    <a href="definir-vencedor.php?id_partida=<?php echo $pool['id'];?>&id_player=<?php echo $pool['id_player1'];?>&numero=<?php echo $pool['numero'];?>" 
       <?php echo ($pool['finalizado'] == 1) ? 'class="disabled-link"' : ''; ?>>

        <img src="icones/<?= htmlspecialchars(!empty($pool['player1']) ? $pool['personagem1'] : 'wo') . '.png'; ?>">

        <p <?php echo ($pool['winner'] == $pool['id_player1']) ? 'class="vencedor"' : 'class="perdedor"' ?>>
            <?= htmlspecialchars(!empty($pool['player1']) ? $pool['player1'] : 'Em aguardo') ?>
        </p>
    </a>  
     
    vs
     
    <a href="definir-vencedor.php?id_partida=<?php echo $pool['id'];?>&id_player=<?php echo $pool['id_player2']; ?>&numero=<?php echo $pool['numero'];?>" 
       <?php echo ($pool['finalizado'] == 1) ? 'class="disabled-link"' : ''; ?>>
       
        <p <?php echo ($pool['winner'] == $pool['id_player2']) ? 'class="vencedor"' : 'class="perdedor"' ?>>
            <?= htmlspecialchars(!empty($pool['player2']) ? $pool['player2'] : 'Em aguardo') ?>
        </p>
        
        <img src="icones/<?= htmlspecialchars(!empty($pool['player2']) ? $pool['personagem2'] : 'wo') . '.png'; ?>">
    </a>
</div>


    <?php endforeach; ?>
</div>

<?php 
// Gera dinamicamente todas as rodadas, incluindo semifinal e final
for ($roundNum = 2; $roundNum <= $maxRound; $roundNum++): 
    $consulta2 = $con->query("SELECT * FROM partidas WHERE torneio = '$id_torneio' AND round = $roundNum");
    $partidas = $consulta2->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($partidas);
    // die();
?>
    <div class="main">
        <h2>
            <?php 
                if ($roundNum == $maxRound - 1) {
                    echo "Semifinal";
                } elseif ($roundNum == $maxRound) {
                    echo "Final";
                } else {
                    echo "Rodada " . $roundNum;
                }
            ?>
        </h2>
        <?php foreach ($partidas as $partida): ?>

            <div class="chave <?php echo ($partida['finalizado'] == 1) ? 'disabled' : ''; ?>">
            <a href="definir-vencedor.php?id_partida=<?php echo $partida['id'];?>&id_player=<?php echo $partida['id_player1'];?>&numero=<?php echo $partida['numero'];?>" 
               <?php echo ($partida['finalizado'] == 1) ? 'class="disabled-link"' : ''; ?>>
                <img src="icones/<?= htmlspecialchars(!empty($partida['personagem1']) ? $partida['personagem1'] : 'wo') . '.png'; ?>">
                <p <?php echo ($partida['winner'] == $partida['id_player1']) ? 'class="vencedor"' : 'class="perdedor"' ?>><?= htmlspecialchars(!empty($partida['player1']) ? $partida['player1'] : 'Em aguardo') ?></p>
            </a>  
     
    vs
     
    <a href="definir-vencedor.php?id_partida=<?php echo $partida['id'];?>&id_player=<?php echo $partida['id_player2']; ?>&numero=<?php echo $partida['numero'];?>" 
       <?php echo ($partida['finalizado'] == 1) ? 'class="disabled-link"' : ''; ?>>
        <p <?php echo ($partida['winner'] == $partida['id_player2']) ? 'class="vencedor"' : 'class="perdedor"' ?>><?= htmlspecialchars(!empty($partida['player2']) ? $partida['player2'] : 'Em aguardo') ?></p> 
        <img src="icones/<?= htmlspecialchars(!empty($partida['personagem2']) ? $partida['personagem2'] : 'wo') . '.png'; ?>">
    </a>
</div>
           
        <?php endforeach; ?>
    </div>
<?php endfor; ?>

<?php 
// Busca o vencedor do torneio no banco de dados (última partida do maior round)
$consultaWinner = $con->query("SELECT winner FROM partidas WHERE torneio = '$id_torneio' AND round = $maxRound LIMIT 1");
$winnerRow = $consultaWinner->fetch(PDO::FETCH_ASSOC);
$winner = $winnerRow['winner'] ?? null;

?>

<?php if ($winner): ?>
    <?php $consultaCampeao = $con->query("SELECT * FROM partidas WHERE round = '$maxRound' AND torneio = '$id_torneio' AND numero = 1");
    $campeao = $consultaCampeao->fetch(PDO::FETCH_ASSOC);

    if ($winner == $campeao['id_player1']) {
         $nomeCampeao = $campeao['player1'];
         $personagemCampeao = $campeao['personagem1'];
     }else{
        $nomeCampeao = $campeao['player2'];
         $personagemCampeao = $campeao['personagem2'];
     }
    // var_dump($campeao);
    // die();
    ?>
    <div class="main bloco-vitoria">
        <h2>Vencedor</h2>
        <div class="chave" id="chave-vitoria">
            <img src="icones/<?php echo $personagemCampeao; ?>.png">
            <p class="vencedor"><?= htmlspecialchars($nomeCampeao) ?>
            
        </div>
    </div>
<?php endif; ?>

</div>
