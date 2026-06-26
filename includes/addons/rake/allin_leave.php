<?php

function rakemod_allinleavebet( $array = array() )
{
    global $pdo;
    $winpot = $array['content'];
    
    if (!defined('RAKE_COMMISSION') || !defined('RAKE_COMMISSION_EACHHAND') || !defined('RAKE_COMMISSION_USER'))
        return $winpot;
    
    if (RAKE_COMMISSION_EACHHAND != "yes")
	    return $winpot;
	
	$percentage = RAKE_COMMISSION / 100;
	$commission = floor ($winpot * $percentage);
    $result     = $pdo->exec("update " . DB_STATS . " set winpot = winpot + $commission where player = '" . RAKE_COMMISSION_USER . "'");

    return ($winpot - $commission);
}

$addons->add_hook(array(

	'page'     => 'includes/inc_poker.php',
	'location' => 'allin_leave_bet_var',
	'function' => 'rakemod_allinleavebet',

));