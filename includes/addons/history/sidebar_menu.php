<?php
/**/

function add_sidebar_history($array = array())
{
    /*$html = '<a href="history.php" class="list-group-item">History</a>';
    return $html;*/

    $content = $array['content'];
    $content['history.php'] = 'Тоглолтын түүх';

    return $content;
}

$addons->add_hook(array(
    'page' => 'general',
    'location' => 'leftbar_array',
    'function' => 'add_sidebar_history'
));