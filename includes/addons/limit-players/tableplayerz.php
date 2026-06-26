<?php

function tableplayerz_content( $array = array() )
{
	global $pdo, $gameID;

	$sql = "SELECT tplayers FROM " . DB_POKER . " WHERE gameID = " . $gameID;
	$tq  = $pdo->prepare($sql);
	$tq->execute();
	$tr  = $tq->fetch(PDO::FETCH_ASSOC);
    
    if (isset($tr['tplayers']))
    {
        $tableplayerz = $tr['tplayers'];
	    $GLOBALS['tableplayers'] = $tableplayerz;
    }
    
    return true;
}


// Adding the hook to the sidebar
$addons->add_hook(array(

	'page'     => 'includes/inc_poker.php',
	'location' => 'after_tablestyle_var',
	'function' => 'tableplayerz_content',

));