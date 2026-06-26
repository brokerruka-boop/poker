<?php

function limitplayers_maxtableplayers ( $array = array() )
{
	global $tabler;
	$GLOBALS['maxtableplayers'] = $tabler['tplayers'];
}


// Adding the hook to the sidebar
$addons->add_hook(array(

	'page'     => 'includes/live_games.php',
	'location' => 'after_gameid_var',
	'function' => 'limitplayers_maxtableplayers',

));
