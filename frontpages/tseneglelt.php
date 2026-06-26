<?php 
require('includes/inc_tseneglelt.php');

$addons->get_hooks(array(), array(

    'page'     => 'tseneglelt.php',
    'location'  => 'page_start'

));

$opsTheme->addVariable('ids', $id);
$opsTheme->addVariable('chips', $chipsAmount);
$opsTheme->addVariable('created_ats', $created_at);
$opsTheme->addVariable('statuss', $status);
$opsTheme->addVariable('players', $plyrname);
$opsTheme->addVariable('html', $html);

include 'templates/header.php';


echo $opsTheme->viewPage('tseneglelt');


include 'templates/footer.php';
?>