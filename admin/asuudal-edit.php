<?php
$tableq   = $pdo->prepare("select * from asuudal WHERE ID = '{$_GET['pp']}'");
$tableq->execute();
$asuudal   = $tableq->fetch(PDO::FETCH_ASSOC);


$opsTheme->addVariable('asuudal', $asuudal);

echo $opsTheme->viewPage('admin-asuudal-edit');
?>