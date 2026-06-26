<?php
function history_general_head_end($value='')
{
	return '<link rel="stylesheet" href="includes/addons/history/css/cards.css?t=2">';
}
$addons->add_hook(array(
	'page'     => 'general',
	'location' => 'head_end',
	'function' => 'history_general_head_end',
));
