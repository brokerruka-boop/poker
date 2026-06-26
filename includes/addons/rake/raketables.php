<?php

function rakemod_definitions( $array = array() )
{
    $percentage     = (int) \OPSAddon::getSetting( 'rake', 'commission_percentage' );
	$cap            = (int) \OPSAddon::getSetting( 'rake', 'commission_cap' );
	$commissioner   = \OPSAddon::getSetting( 'rake', 'commissioner_user' );
    $commissionWhen = \OPSAddon::getSetting( 'rake', 'commission_eachhand' );
	$rakeType       = \OPSAddon::getSetting( 'rake', 'rake_type' );

    if (! $cap)
        $cap = 0;
    
    if (! defined('RAKE_TYPE'))
        define('RAKE_TYPE',                $rakeType); // type of rake

    if (! defined('RAKE_COMMISSION'))
        define('RAKE_COMMISSION',          $percentage); // the percentage of rake you want to collect

    if (! defined('RAKE_COMMISSION_CAP'))
        define('RAKE_COMMISSION_CAP',      $cap); // the cap amount of rake you want to collect
    
    if (! defined('RAKE_COMMISSION_USER'))
        define('RAKE_COMMISSION_USER',     $commissioner); // the account that the rake should be assigned to
    
    if (! defined('RAKE_COMMISSION_EACHHAND'))
        define('RAKE_COMMISSION_EACHHAND', $commissionWhen);
}

// Adding the hook to the sidebar
$addons->add_hook(array(
	'page'     => 'includes/gen_inc.php',
	'location' => 'start',
	'function' => 'rakemod_definitions',
));

$addons->add_hook(array(
	'page'     => 'includes/sec_inc.php',
	'location' => 'start',
	'function' => 'rakemod_definitions',
));
