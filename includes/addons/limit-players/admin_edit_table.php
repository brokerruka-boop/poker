<?php

function limitplayers_edit_table( $array = array() )
{
	global $tabler;

	$html = 'Table Players:     
    <select name="tplayers" class="form-control">';
        
        for ($i = 1; $i < 11; $i++)
        { 
        	$selectAttr = ($tabler['tplayers'] == $i) ? 'selected' : '';

	        $html .= '<option value="' . $i . '" ' . $selectAttr . '>
	            ' . $i . '
	        </option>';
        }

    $html .= '</select><br>';

    return $html;
}


// Adding the hook to the sidebar
$addons->add_hook(array(

	'page'     => 'admin/edit-table.php',
	'location' => 'input_block',
	'function' => 'limitplayers_edit_table',

));
