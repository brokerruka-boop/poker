<?php
// addon hook for before sidebar
$sidebar = $addons->get_hooks(array(), array(
	'page'     => 'general',
	'location'  => 'leftbar_before'
));

$sidebarArray = array('index.php' => MENU_HOME);

if ($valid == false && MEMMOD == 0)
	$sidebarArray['login.php'] = MENU_LOGIN;

if ($valid == false)
	$sidebarArray['create.php'] = MENU_CREATE;

if ($valid == true)
{
	$sidebarArray['lobby.php'] = MENU_LOBBY;
	//$sidebarArray['rankings.php'] = MENU_RANKINGS;
	$sidebarArray['myplayer.php'] = MENU_MYPLAYER;
}

$sidebarArray['tseneglelt.php'] = 'Цэнэглэлтийн түүх';
$sidebarArray['tatalt.php'] = 'Таталтын түүх';
$sidebarArray['asuudal.php'] = 'Асуудал илгээх';
$sidebarArray = $addons->get_hooks(
	array(
		'content' => $sidebarArray
	),
	array(
		'page'        => 'general',
		'location'    => 'leftbar_array',
		'merge_array' => true
	)
);


//$sidebarArray['rules.php'] = 'Poker Rules';
//$sidebarArray['faq.php']   = 'FAQ';

if ($valid == true)
	$sidebarArray['logout.php'] = 'Гарах';


if ($ADMIN == true)
	$sidebarArray['admin.php'] = '<span class="btn btn-success btn-sm btn-block">Админ</span>';



$sidebarArray = $addons->get_hooks(
	array(
		'content' => $sidebarArray
	),
	array(
		'page'     => 'general',
		'location' => 'leftbar_final_array',
	)
);


$sidebarContent = '';
foreach ($sidebarArray as $sidebarUrl => $sidebarLabel)
{
	$opsTheme->addVariable('sb_menu_url',   $sidebarUrl);
	$opsTheme->addVariable('sb_menu_label', $sidebarLabel);

	$sidebarContent .= $opsTheme->viewPart('sidebar-each');
}
// addon hook for sidebar content
$sidebarContent = $addons->get_hooks(
	array(
		'content' => $sidebarContent
	),
	array(
		'page'     => 'general',
		'location'  => 'leftbar_content'
	)
);
$opsTheme->addVariable('sidebar_content',   $sidebarContent);

$sidebar .= $opsTheme->viewPage('sidebar');

// addon hook for after sidebar
$sidebar .= $addons->get_hooks(array(), array(
	'page'     => 'general',
	'location'  => 'leftbar_after'
));

$opsTheme->addVariable('sidebar', $sidebar);
?>