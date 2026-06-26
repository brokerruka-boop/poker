<?php
function rake_fieldcheck()
{
	global $pdo;

	$check1 = $pdo->prepare("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_POKER . "' AND COLUMN_NAME = 'rake_comm_pc'");
	$check1->execute();

	if ($check1->rowCount() == 0)
		$pdo->exec("ALTER TABLE `" . DB_POKER . "` ADD `rake_comm_pc` VARCHAR(2) NOT NULL DEFAULT '0' AFTER `msg`;");

	$check2 = $pdo->prepare("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_POKER . "' AND COLUMN_NAME = 'rake_comm_cap'");
	$check2->execute();

	if ($check2->rowCount() == 0)
		$pdo->exec("ALTER TABLE `" . DB_POKER . "` ADD `rake_comm_cap` VARCHAR(6) NOT NULL DEFAULT '0' AFTER `rake_comm_pc`;");
}


function rakemod_createtable_input( $array = array() )
{
	rake_fieldcheck();

	if (RAKE_TYPE === "table")
	{
		global $opsTheme;

		$rake = array(
			'pc'  => '0',
			'cap' => '0',
		);
		$opsTheme->addVariable('rake', $rake);

		return $opsTheme->viewPart('admin-table-rake-pc', __DIR__);
	}

	return '';
}
$addons->add_hook(array(
	'page'     => 'admin/tables.php',
	'location' => 'input_block',
	'function' => 'rakemod_createtable_input',
));


function rakemod_edittable_input( $array = array() )
{
	rake_fieldcheck();

	if (RAKE_TYPE === "table")
	{
		global $opsTheme, $tabler;

		$rake = array(
			'pc'  => '0',
			'cap' => '0',
		);

		if (isset($tabler['rake_comm_pc']))
			$rake['pc'] = $tabler['rake_comm_pc'];

		if (isset($tabler['rake_comm_cap']))
			$rake['cap'] = $tabler['rake_comm_cap'];

		$opsTheme->addVariable('rake', $rake);

		return $opsTheme->viewPart('admin-table-rake-pc', __DIR__);
	}

	return '';
}
$addons->add_hook(array(
	'page'     => 'admin/edit-table.php',
	'location' => 'input_block',
	'function' => 'rakemod_edittable_input',
));


function rakemod_admin_createtable( $array = array() )
{
	rake_fieldcheck();
	$tableID = $array['content'];
	
	if (RAKE_TYPE !== "table")
		return false;

	global $pdo;
	$rakePc  = (isset($_POST['rake_comm_pc']))  ? ((int) $_POST['rake_comm_pc'])  : 0;
	$rakeCap = (isset($_POST['rake_comm_cap'])) ? ((int) $_POST['rake_comm_cap']) : 0;

	$pdo->query("UPDATE " . DB_POKER . " SET rake_comm_pc = '{$rakePc}', rake_comm_cap = '{$rakeCap}' WHERE gameID = {$tableID}");
	return true;
}
$addons->add_hook(array(
	'page'     => 'includes/inc_admin.php',
	'location' => 'after_create_table',
	'function' => 'rakemod_admin_createtable',
));
