<?php
$prbQ = $pdo->query("SELECT DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_POKER . "' AND COLUMN_NAME = 'tplayers'");
if ($prbQ->rowCount() === 0)
	$pdo->exec("ALTER TABLE " . DB_POKER . " ADD COLUMN tplayers VARCHAR(255) DEFAULT '10' AFTER tablestyle");
