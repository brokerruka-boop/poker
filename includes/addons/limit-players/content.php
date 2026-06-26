<?php
function limitplayers_content( $array = array() )
{
	global $tableplayers;
	$html = $array['content'];

	if (! isset($array['index']) || !$array['index'])
		return $html;

	$index = $array['index'];
	$availSeats = array(
		1  => array(10),
		2  => array(1, 6),
		3  => array(5, 6, 7),
		4  => array(4, 5, 7, 8),
		5  => array(4, 5, 6, 7, 8),
		6  => array(3, 4, 5, 7, 8, 9),
		7  => array(3, 4, 5, 6, 7, 8, 9),
		8  => array(2, 3, 4, 5, 7, 8, 9, 10),
		9  => array(2, 3, 4, 5, 6, 7, 8, 9, 10),
		10 => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10)
	);
	$tableplayers = (isset($tableplayers) && isset($availSeats[(int) $tableplayers])) ? (int) $tableplayers : 10;

	if (! in_array($index, $availSeats[$tableplayers]))
	{
		$match   = 'class="player"';
		$replace = $match . ' style="display: none;"';
		$html = str_ireplace($match, $replace, $html);
	}

	return $html;
}


// Adding the hook to the sidebar
$addons->add_hook(array(
	'page'     => 'poker.php',
	'location' => 'each_seat',
	'function' => 'limitplayers_content',
));
