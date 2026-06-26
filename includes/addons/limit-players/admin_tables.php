<?php

function limitplayers_admin_tables( $array = array() )
{
	global $tabler;
	
	$html = 'Table Players:     
    <select name="tplayers" class="form-control">';
        
        for ($i = 1; $i < 11; $i++)
        {
        	$selectedAttr = ($tabler['tplayers'] == $i) ? 'selected' : '';

			$html .= '<option value="' . $i . '" ' . $selectedAttr . '>
				' . $i . '
			</option>';
        }

    $html .= '</select><br>';

    return $html;
}


// Adding the hook to the sidebar
$addons->add_hook(array(

	'page'     => 'admin/tables.php',
	'location' => 'input_block',
	'function' => 'limitplayers_admin_tables',

));
