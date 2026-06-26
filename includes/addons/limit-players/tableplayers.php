<?php

function limitplayers_tableplayers( $array = array() )
{
	global $x, $maxtableplayers;
	return $x . '/' . $maxtableplayers;
}


// Adding the hook to the sidebar
$addons->add_hook(array(

	'page'     => 'includes/live_games.php',
	'location' => 'tableplayers_var',
	'function' => 'limitplayers_tableplayers',

));
