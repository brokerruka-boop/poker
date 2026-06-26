<?php
function rake_nav_log($array = array())
{
    $content = $array['content'];

    if (! is_array($content))
    	return $content;

    $content['admin.php?admin=rakelogs'] = 'Rake';
    return $content;
}
$addons->add_hook(array(
	'page'     => 'general',
	'location' => 'nav_log',
	'function' => 'rake_nav_log',
));


function rake_nav_log_content($array = array())
{
	global $pdo, $opsTheme;
	$pagetag = $array['pagetag'];

	if ($pagetag !== 'rakelogs')
		return '';

	$agents = '';
	if (\OPSAddon::isActive('agents'))
	{
		$agentStm = $pdo->query("SELECT * FROM " . DB_PLAYERS . " WHERE is_agent = 1");
		while ($agent = $agentStm->fetch(PDO::FETCH_ASSOC))
		{
			$opsTheme->addVariable('option', array(
				'value' => $agent['username'],
				'label' => $agent['username']
			));
			$agents .= $opsTheme->viewPart('rake-select-opt', __DIR__);
		}
	}

	$players   = '';
	$playerStm = $pdo->query("SELECT * FROM " . DB_PLAYERS);
	while ($player = $playerStm->fetch(PDO::FETCH_ASSOC))
	{
		$opsTheme->addVariable('option', array(
			'value' => $player['username'],
			'label' => $player['username']
		));
		$players .= $opsTheme->viewPart('rake-select-opt', __DIR__);
	}

	$opsTheme->addVariable('filter', array(
		'agents'  => $agents,
		'players' => $players,
	));

	$sql        = "SELECT * FROM rake_log WHERE ID > 0";
	$targetPage = 'admin.php?admin=rakelogs';

	if (isset($_GET['agent']) && !empty($_GET['agent']))
	{
		$agent       = $_GET['agent'];
		$sql        .= " AND agent = '{$agent}'";
		$targetPage .= "&agent={$agent}";
	}

	if (isset($_GET['player']) && !empty($_GET['player']))
	{
		$player      = $_GET['player'];
		$sql        .= " AND player = '{$player}'";
		$targetPage .= "&player={$agent}";
	}

	if (isset($_GET['daterange']) && !empty($_GET['daterange']))
	{
		$daterange = $_GET['daterange'];
		$dr        = explode('-', $daterange);

		if (count($dr) == 2)
		{
			$startDate   = trim($dr[0]);
			$endDate     = trim($dr[1]);
			$sql        .= " AND dated BETWEEN '{$startDate}:00' AND '{$endDate}:59'";
			$targetPage .= "&daterange={$daterange}";
		}
	}

	$totalQ = $pdo->query(str_replace('*', 'COUNT(ID) AS num', $sql));
	$totalF = $totalQ->fetch(PDO::FETCH_ASSOC);
	$total  = $totalF['num'];

	$page = (isset($_GET['page'])) ? ((int) $_GET['page']) : 1;
	$page = ($page < 1) ? 1 : $page;

	$limit = 10;
	$start = ($page - 1) * $limit;

	$logView = '';
	$logs    = $pdo->query("{$sql} ORDER BY ID DESC LIMIT $start, $limit");
	while ($log = $logs->fetch(PDO::FETCH_ASSOC))
	{
		$opsTheme->addVariable('log', $log);

		$history = $log['historyID'];
		if (\OPSAddon::isActive('history'))
			$history = $opsTheme->viewPart('rake-history-btn', __DIR__);

		$log['history'] = $history;
		$opsTheme->addVariable('log', $log);
		$logView .= $opsTheme->viewPart('rake-admin-log-each', __DIR__);
	}

	$opsTheme->addVariable('logs', $logView);
	$opsTheme->addVariable('pagination', OPS_pagination(array(
		'page'       => $page,
		'start'      => $start,
		'limit'      => $limit,
		'total'      => $total,
		'adjacent'   => 3,
		'targetPage' => $targetPage
	)));
	return $opsTheme->viewPage('rake-admin-logs', __DIR__);
}
$addons->add_hook(array(
	'page'     => 'admin.php',
	'location' => 'admin_page',
	'function' => 'rake_nav_log_content',
));
