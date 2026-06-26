<?php

function limitplayers_chipslog( $array = array() )
{
	global $chipslogaddon, $plyrname, $winpot, $gameID;

	if ($chipslogaddon == 'active')
	{
		$result = chipslog($plyrname, time(), '+' . $winpot, 'UIDTEST', 'Leave Table', 'Confirmed', 'GameID:' . $gameID);
	}
}


// Adding the hook to the sidebar
$addons->add_hook(array(

	'page'     => 'includes/inc_poker.php',
	'location' => 'if_player_exists',
	'function' => 'limitplayers_chipslog',

));
