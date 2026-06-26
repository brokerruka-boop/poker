<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$title = (isset($title)) ? $title : TITLE;
$opsTheme->addVariable('title', $title);
$opsTheme->addVariable('site_title', TITLE);
$opsTheme->addVariable('menu_lobby', MENU_LOBBY);


$opsTheme->addVariable('day', date('d'));
$opsTheme->addVariable('month', date('m'));
$opsTheme->addVariable('year', date('Y'));

include 'sidebar.php';


if ($ADMIN == true)
	$opsTheme->addVariable('admin_nav', $opsTheme->viewPart('admin-nav'));


if ($ADMIN == true)
{
	$sql = "SELECT COUNT(*) as num FROM asuudal where status = 'Huleegdej baina'  ORDER BY id desc limit 100"; 
    $result  = $pdo->prepare($sql);
    $result ->execute();
    $data = $result->fetchColumn();
	$rowHtml = '<span>'.$data.'</span>';	
	$opsTheme->addVariable('asuudalcount', $rowHtml);
	
	
	$sql = "SELECT COUNT(*) as num FROM deposits where status = 'Huleegdej baina'  ORDER BY id desc limit 100"; 
    $resultdeposits  = $pdo->prepare($sql);
    $resultdeposits ->execute();
    $datadeposits = $resultdeposits->fetchColumn();
	$rowHtmldeposits = '<span>'.$datadeposits.'</span>';	
	$opsTheme->addVariable('tsenegleltcount', $rowHtmldeposits);
	
	$sqlT = "SELECT COUNT(*) as num FROM withdrawal where status = 'Huleegdej baina'  ORDER BY id desc limit 100"; 
    $resulttatalt  = $pdo->prepare($sqlT);
    $resulttatalt ->execute();
    $datatatalt = $resulttatalt->fetchColumn();
	$rowHtmltatalt = '<span>'.$datatatalt.'</span>';	
	$opsTheme->addVariable('tataltcount', $rowHtmltatalt);
	
	$memberCount = "SELECT COUNT(*) ID FROM players ORDER BY id desc limit 100"; 
    $memberCountResult  = $pdo->prepare($memberCount);
    $memberCountResult ->execute();
    $memberData = $memberCountResult->fetchAll();

		foreach ($memberData as $row){
			$id = $row['ID'];
		};

	$isSuper = "SELECT username, super FROM players WHERE username='" .$plyrname. "'"; 
    $isSuperResult  = $pdo->prepare($isSuper);
    $isSuperResult ->execute();
    $isSuperData = $isSuperResult->fetchAll();

		foreach ($isSuperData as $row){
			$uname = $row['username'];
			$super = $row['super'];
		};





	$htmlMember = '<span>'.$id.'</span>';	
	$opsTheme->addVariable('htmlMember', $htmlMember);
	
	$updateBadge   = '<span class="badge badge-pill badge-primary">!</span>';

	$addonNavLabel = ADMIN_MANAGE_ADDONS;
	if (ADDONUPDATEA !== '0')
		$addonNavLabel .= $updateBadge;

	$updatesNavLabel = 'Updates';
	if (UPDATEALERT !== '0')
		$updatesNavLabel .= $updateBadge;

// 	$logDropdowns = array('admin.php?admin=sitelog' => 'Сайтын бүртгэл');
	
	$logDropdownsTable = array(
		'admin.php?admin=room-1' => 'Ширээ - 1',
		'admin.php?admin=room-2' => 'Ширээ - 2',
		'admin.php?admin=room-3' => 'Ширээ - 3',
		'admin.php?admin=room-4' => 'Ширээ - 4',
		'admin.php?admin=room-5' => 'Ширээ - 5',
		'admin.php?admin=room-6' => '1 v 1 Өрөө',
		);	

	if ($super == 1) {	
	$logDropdownsTableCreate = array(
		'admin.php?admin=tables'    => 'Ширээ үүсгэх',
		'admin.php?admin=styles'    => 'Ширээний загвар',
		);

        $logDropdowns = array('admin.php?admin=sitelog' => 'Сайтын бүртгэл');

	$navArray = array(
		// 'admin.php?admin=asuudal'     => 'Асуудал',
		// 'admin.php?admin=tseneglelt'  => 'Цэнэглэлт',
		// 'admin.php?admin=tatalt'      => 'Таталт',
		// 'admin.php?admin=members'     => 'Тоглогчид',
// 		'admin.php?admin=addon-settings&id=rake'    => 'Шимтгэл',
			'tableCreate' => array(
			'label' => 'Ширээ',
			'dropdowns' => $logDropdownsTableCreate
		),
	

		'tableView' => array(
			'label' => 'Мод харах',
			'dropdowns' => $logDropdownsTable

		),
		
	
		'log'                       => array(
			'label' => 'Үйлдлийн бүртгэл',
			'dropdowns' => $logDropdowns
		),
		'admin.php?admin=settings'  => "Тохиргоо",
	
	);
};
	$logDropdowns = $addons->get_hooks(
		array(
			'content' => $logDropdowns
		),
		array(
			'page'        => 'general',
			'location'    => 'nav_log',
			'merge_array' => true
		)
	);
	$navArray['log']['dropdowns'] = $logDropdowns;
	$navArray = $addons->get_hooks(
		array(
			'content' => $navArray
		),
		array(
			'page'        => 'general',
			'location'    => 'nav_array'
		)
	);

	if (count($navArray['log']['dropdowns']) == 0)
		unset($navArray['log']);

	$navContent = $addons->get_hooks(
		array(
			'content' => ''
		),
		array(
			'page'     => 'general',
			'location'  => 'nav_start'
		)
	);

	foreach ($navArray as $navUrl => $navLabel)
	{
		$opsTheme->addVariable('nav_url', $navUrl);

		if (is_array($navLabel))
		{
			$dropdownArray = $navLabel;
			$dropdowns     = '';

			foreach ($dropdownArray['dropdowns'] as $ddUrl => $ddLabel)
			{
				$opsTheme->addVariable('dropdown', array(
					'url'   => $ddUrl,
					'label' => $ddLabel
				));
				$dropdowns .= $opsTheme->viewPart('nav-each-dropdown-each');
			}

			$opsTheme->addVariable('nav', array(
				'url'       => $navUrl,
				'label'     => $dropdownArray['label'],
				'dropdowns' => $dropdowns
			));
			$opsTheme->addVariable('nav_label', $dropdownArray['label']);

			$navContent .= $opsTheme->viewPart('nav-each-dropdown');
		}
		else
		{
			$opsTheme->addVariable('nav', array(
				'url'   => $navUrl,
				'label' => $navLabel
			));

			$opsTheme->addVariable('nav_label', $navLabel);
			$navContent .= $opsTheme->viewPart('nav-each');
		}
	}

	$navContent = $addons->get_hooks(
		array(
			'content' => $navContent
		),
		array(
			'page'     => 'general',
			'location'  => 'nav_content'
		)
	);
	$navContent .= $addons->get_hooks(
		array(
			'content' => ''
		),
		array(
			'page'     => 'general',
			'location'  => 'nav_end'
		)
	);

	$opsTheme->addVariable('nav_content', $navContent);
}

/**/
$head_start_tag_addons = $addons->get_hooks(array(), array(
	'page'     => 'general',
	'location'  => 'head_start'
));
$head_end_tag_addons = $addons->get_hooks(array(), array(
	'page'     => 'general',
	'location'  => 'head_end'
));
$body_start_tag_addons = $addons->get_hooks(array(), array(
	'page'     => 'general',
	'location'  => 'body_start'
));
/**/

$themeInit = 'themes/' . THEME . '/init.php';
if (file_exists($themeInit))
	include $themeInit;

/**/
$styles   = $opsTheme->getCss();
$headerJs = $opsTheme->getJs('header');
$footerJs = $opsTheme->getJs('footer');

$opsTheme->addVariable('styles', $styles);
$opsTheme->addVariable('scripts', array(
	'styles' => $styles,
	'css'    => $styles,
	'js'     => array(
		'header' => $headerJs,
		'footer' => $footerJs
	),
	'header' => $headerJs,
	'footer' => $footerJs,
));

/**/

$hpc = $opsTheme->viewPage('header');

$jsPokerScript = '<script src="js/poker.php?t=' . date('YmdHi') . '"></script><script type="text/javascript">function open_game(gameId){window.location.href = "lobby.php?gameID=" + gameId;}</script>';

$hpc = str_ireplace('<head>', "<head>{$head_start_tag_addons}", $hpc);
$hpc = str_ireplace('</head>', "{$jsPokerScript}{$head_end_tag_addons}</head>", $hpc);
$hpc = str_ireplace('<body>', "<body>{$body_start_tag_addons}", $hpc);

echo $hpc;
?>