<?php
	$sql = "SELECT COUNT(*) as num FROM asuudal where status = 'Huleegdej baina'  ORDER BY id desc limit 100"; 

    $result  = $pdo->prepare($sql);
    $result ->execute();
    $data = $result->fetchColumn();

	$rowHtml = '<span>'.$data.'</span>';
	$html .= $rowHtml;

	$opsTheme->addVariable('html', $html);
	echo $opsTheme->viewPage('admin-asuudal-count');