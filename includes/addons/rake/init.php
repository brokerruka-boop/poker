<?php

function rake_log_insert($array = array())
{
	global $pdo, $gameID;
	extract($array);

    if (empty($commissioner) || $commission == 0)
        return false;

    $fiveSecondsAgo = date('Y-m-d H:i:s', (time() - 5));
    $check          = $pdo->query("SELECT * FROM rake_log WHERE tableID = $tableID AND player = '$player' AND dated > '{$fiveSecondsAgo}'");

    if ($check->rowCount() > 0)
        return false;

    if ($historyID == 0 && \OPSAddon::isActive('history'))
    {
        $historyS = $pdo->query("SELECT id FROM history WHERE gameid = {$gameID} ORDER BY id DESC LIMIT 1");

        if ($historyS->rowCount() === 1)
        {
            $history   = $historyS->fetch(PDO::FETCH_ASSOC);
            $historyID = $history['id'];
        }
    }

    $commission = transfer_from($commission);

    if ($agent_commission > 0)
        $agent_commission = transfer_from($agent_commission);

    $pdo->query("INSERT INTO rake_log (tableID, historyID, player, commissioner, commission, agent, agent_commission, dated, tsetting) VALUES ($tableID, $historyID, '$player', '$commissioner', '$commission', '$agent', '$agent_commission', '" . date('Y-m-d H:i:s') . "', '$setting')");
}

require 'raketables.php';
require 'rake-winpot.php';
require 'rake-distpot.php';
require 'allin_leave.php';
require 'rake_table_inputs.php';
require 'rake_nav_log.php';
