<?php
/**/
function automove_loghistory()
{
	global $pdo, $gameID;
    $history      = $pdo->prepare("select * from " . DB_POKER . " where gameID = " . $gameID);
    $history->execute();
    $histories = $history->fetch(PDO::FETCH_ASSOC);
    
    $date = date('Y-m-d H:i:s');
    $datez = date('Y-m-d');
    $year = date('Y');
    $month = date('m');
    $day = date('d');
    
    $result = $pdo->exec("INSERT INTO history SET tablename = '" . $histories['tablename'] . "', pot = '" . $histories['pot'] . "', card1 = '" . $histories['card1'] . "', card2 = '" . $histories['card2'] . "', card3 = '" . $histories['card3'] . "', card4 = '" . $histories['card4'] . "', card5 = '" . $histories['card5'] . "', p1name = '" . $histories['p1name'] . "', p2name = '" . $histories['p2name'] . "', p3name = '" . $histories['p3name'] . "', p4name = '" . $histories['p4name'] . "', p5name = '" . $histories['p5name'] . "', p6name = '" . $histories['p6name'] . "', p7name = '" . $histories['p7name'] . "', p8name = '" . $histories['p8name'] . "', p9name = '" . $histories['p9name'] . "', p10name = '" . $histories['p10name'] . "',  p1pot = '" . $histories['p1pot'] . "', p2pot = '" . $histories['p2pot'] . "', p3pot = '" . $histories['p3pot'] . "', p4pot = '" . $histories['p4pot'] . "',p5pot = '" . $histories['p5pot'] . "',p6pot = '" . $histories['p6pot'] . "', p7pot = '" . $histories['p7pot'] . "', p8pot = '" . $histories['p8pot'] . "', p9pot = '" . $histories['p9pot'] . "',p10pot = '" . $histories['p10pot'] . "',p1bet = '" . $histories['p1bet'] . "',p2bet = '" . $histories['p2bet'] . "',p3bet = '" . $histories['p3bet'] . "',p4bet = '" . $histories['p4bet'] . "',p5bet = '" . $histories['p5bet'] . "',p6bet = '" . $histories['p6bet'] . "',p7bet = '" . $histories['p7bet'] . "',p8bet = '" . $histories['p8bet'] . "',p9bet = '" . $histories['p9bet'] . "',p10bet = '" . $histories['p10bet'] . "', msg = '" . $histories['msg'] . "', date = '" . $date . "', datez = '" . $datez . "', year = '" . $year . "', month = '" . $month . "', day = '" . $day . "', gameid = '" . $gameID . "',p1card1 = '" . $histories['p1card1'] . "',p1card2 = '" . $histories['p1card2'] . "',p2card1 = '" . $histories['p2card1'] . "',p2card2 = '" . $histories['p2card2'] . "', p3card1 = '" . $histories['p3card1'] . "',p3card2 = '" . $histories['p3card2'] . "',p4card1 = '" . $histories['p4card1'] . "',p4card2 = '" . $histories['p4card2'] . "',p5card1 = '" . $histories['p5card1'] . "',p5card2 = '" . $histories['p5card2'] . "',p6card1 = '" . $histories['p6card1'] . "',p6card2 = '" . $histories['p6card2'] . "',p7card1 = '" . $histories['p7card1'] . "',p7card2 = '" . $histories['p7card2'] . "',p8card1 = '" . $histories['p8card1'] . "',p8card2 = '" . $histories['p8card2'] . "',p9card1 = '" . $histories['p9card1'] . "',p9card2 = '" . $histories['p9card2'] . "',p10card1 = '" . $histories['p10card1'] . "',p10card2 = '" . $histories['p10card2'] . "' ");
    
}
$addons->add_hook(array(

	'page'     => 'includes/auto_move.php',
	'location' => 'hand_14',
	'function' => 'automove_loghistory',

));