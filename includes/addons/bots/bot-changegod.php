<?php
function ops_bot_changegod($array = array())
{
	global $tpr, $pdo, $gameID, $hand, $lastmove, $time;
	$delay = $time - 3;

	if ($hand < 0)
		return false;

	if (! ($delay > $lastmove))
		return false;

	$botGod  = $tpr['botgod'];
	$nextGod = nextbotgod($botGod);

	if ($nextGod !== false)
	{
		$pdo->query("UPDATE " . DB_POKER . " SET botgod = {$nextGod} WHERE gameID = {$gameID}");
		return true;
	}

	return false;
}
$addons->add_hook(array(
	'page'     => 'includes/auto_move.php',
	'location' => 'tpr_variables',
	'function' => 'botgod_update_bot_timetag_sec',
));
