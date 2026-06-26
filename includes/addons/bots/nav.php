<?php

function bots_header_nav_link ( $array = array() )
{
	return '<li class="nav-item"><a class="nav-link" href="admin.php?admin=bots">Bots</a>
	</li> <li class="nav-item"><a class="nav-link" href="admin.php?admin=asuudal">Асуудал</a>
	</li> <li class="nav-item"><a class="nav-link" href="admin.php?admin=tseneglelt">Цэнэглэлт</a>
	</li> <li class="nav-item"><a class="nav-link" href="admin.php?admin=tatalt">Таталт</a></li>
	<li class="nav-item"><a class="nav-link" href="admin.php?admin=members">Тоглогчид</a></li>
	<li class="nav-item"><a class="nav-link" href="admin.php?admin=addon-settings&id=rake">Шимтгэл</a></li>';
	
}


// Adding the hook to the sidebar
$addons->add_hook(array(

	'page'     => 'general',
	'location' => 'nav_start',
	'function' => 'bots_header_nav_link',

));
