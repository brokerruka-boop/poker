<?php 
require('includes/inc_asuudal.php');

$addons->get_hooks(array(), array(

    'page'     => 'asuudal',
    'location'  => 'page_start'

));

if ( isset($message) && $message != '' )
{
	$opsTheme->addVariable('msg_text', $message);
	$opsTheme->addVariable('message',  $opsTheme->viewPart('myplayer-message'));
}

	$opsTheme->addVariable('ids', $id);
	$opsTheme->addVariable('created_ats', $created_at);
	$opsTheme->addVariable('statuss', $status);
	$opsTheme->addVariable('players', $plyrname);
	$opsTheme->addVariable('html', $html);

	include 'templates/header.php';
		echo $opsTheme->viewPage('asuudal');
	include 'templates/footer.php';
