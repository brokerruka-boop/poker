<?php
/**/
function history_frontpage($array = array())
{
    $pagename = $array['page'];

    extract($GLOBALS);
    
    if ($pagename === 'history'){
        include 'history_frontpage.php';
	}
	if ($pagename === 'admin-history'){
        include 'history_frontpage-admin.php';
	}
	
	
	}
	
$addons->add_hook(array(
	'page'     => 'general',
	'location' => 'frontpage',
	'function' => 'history_frontpage',
));	