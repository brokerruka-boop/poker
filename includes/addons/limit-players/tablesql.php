<?php

function tablesql_content( $array = array() )
{
	$content = $array['content'];

	if (! isset($_POST['tplayers'])) return $content;

	$tplayers = addslashes($_POST['tplayers']);
	$content .= ", tplayers = '$tplayers'";

	return $content;
}


// Adding the hook to the sidebar
$addons->add_hook(array(

	'page'     => 'includes/inc_admin.php',
	'location' => 'create_table_sql',
	'function' => 'tablesql_content',

));
