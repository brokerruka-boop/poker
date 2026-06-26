<?php
$pdo->exec("CREATE TABLE IF NOT EXISTS `rake_log` ( `ID` INT(11) NOT NULL AUTO_INCREMENT , `tableID` INT(11) NOT NULL DEFAULT '0' , `historyID` INT(11) NOT NULL DEFAULT '0' , `player` VARCHAR(12) NOT NULL DEFAULT '' , `commissioner` VARCHAR(12) NOT NULL DEFAULT '' , `commission` VARCHAR(10) NOT NULL DEFAULT '' , `agent` VARCHAR(12) NOT NULL DEFAULT '' , `agent_commission` VARCHAR(10) NOT NULL DEFAULT '' , `dated` DATETIME NOT NULL DEFAULT '2020-01-01 00:00:00' , `tsetting` TEXT NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB;");

$rakeCOMMPCcheck = $pdo->query("SELECT DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_POKER . "' AND COLUMN_NAME = 'rake_comm_pc'");
if ($rakeCOMMPCcheck->rowCount() === 0)
	$pdo->exec("ALTER TABLE " . DB_POKER . " ADD rake_comm_pc VARCHAR(2) NOT NULL DEFAULT '0' AFTER msg");

$rakeCOMMCAPcheck = $pdo->query("SELECT DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_POKER . "' AND COLUMN_NAME = 'rake_comm_cap'");
if ($rakeCOMMCAPcheck->rowCount() === 0)
	$pdo->exec("ALTER TABLE " . DB_POKER . " ADD rake_comm_cap VARCHAR(6) NOT NULL DEFAULT '0' AFTER rake_comm_pc");
