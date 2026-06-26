<?php
	$html .=
	
		'
		<b>Ширээ - 5  </b> / Газрын мод 
		<br>
		<br>
		<table>';

                require('includes/inc_lobby.php');
                
                $cardNumbers = array('A', 'K', 'Q', 'J');
                for ($i = 2; $i < 11; $i++)
                    $cardNumbers[] = $i;
                
                $hCards = array();
                foreach ($cardNumbers as $cNum)
                {
                    foreach (array('diamond', 'spade', 'heart', 'club') as $cType)
                    {
                    $ctS    = strtoupper(substr($cType, 0, 1));
                    $ccCode = $cNum . $ctS;
                
                    $hCards[ $ccCode ] = '<div class="poker__table-card poker__table-card-history poker__table-card--' . $cType . '">
                        <div class="poker__table-card-num">' . $cNum . '</div>
                        <div class="poker__table-card-mast"><span class="icon-mast_' . $cType . '"></span></div>
                    </div>';
                    }
                }
    
        
  
        $sql = "SELECT * FROM poker where gameID = 904";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        foreach ($data as $row) {
            // $card1 = $row['card1'];
            $card1 = $hCards[decrypt_card($row['card1'])];
            $card2 = $hCards[decrypt_card($row['card2'])];
            $card3 = $hCards[decrypt_card($row['card3'])];
            $card4 = $hCards[decrypt_card($row['card4'])];
            $card5 = $hCards[decrypt_card($row['card5'])];
    
    
            $rowHtml = '<tr><td>'.$card1.'</td><td>'.$card2.'</td><td>'.$card3.'</td><td>'.$card4.'</td><td>'.$card5.'</td></tr>';
            $html .= $rowHtml;
        }


        $html .= ' </table>';

// User 1
$html .='
     
           
                <table style="width: 60%; margin-top: 20px;">
                <thead>
                    <tr>
                        <th>Тоглогч </th>
                        <th>Суудлын дугаар</th>
                        <th>Мод 1</th>
                        <th>Мод 2</th>
                    </tr>
                </thead>
                <tbody>';

                require('includes/inc_lobby.php');
                
                $cardNumbers = array('A', 'K', 'Q', 'J');
                for ($i = 2; $i < 11; $i++)
                    $cardNumbers[] = $i;
                
                $hCards = array();
                foreach ($cardNumbers as $cNum)
                {
                    foreach (array('diamond', 'spade', 'heart', 'club') as $cType)
                    {
                    $ctS    = strtoupper(substr($cType, 0, 1));
                    $ccCode = $cNum . $ctS;
                
                    $hCards[ $ccCode ] = '<div class="poker__table-card poker__table-card-history poker__table-card--' . $cType . '">
                        <div class="poker__table-card-num">' . $cNum . '</div>
                        <div class="poker__table-card-mast"><span class="icon-mast_' . $cType . '"></span></div>
                    </div>';
                    }
                }
    
       
        
        $sql1 = "SELECT * FROM poker Where gameID = 5";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute();
        $data1 = $stmt1->fetchAll();
        foreach ($data1 as $row1) {
            // $card1 = $row['card1'];
			
			
			if($row1['p1name'] == NULL){ $displayNone1 = 'style="display: none;"'; }
			if($row1['p2name'] == NULL){ $displayNone2 = 'style="display: none;"'; }
			if($row1['p3name'] == NULL){ $displayNone3 = 'style="display: none;"'; }
			if($row1['p4name'] == NULL){ $displayNone4 = 'style="display: none;"'; }
			if($row1['p5name'] == NULL){ $displayNone5 = 'style="display: none;"'; }
			if($row1['p6name'] == NULL){ $displayNone6 = 'style="display: none;"'; }
			if($row1['p7name'] == NULL){ $displayNone7 = 'style="display: none;"'; }
			if($row1['p8name'] == NULL){ $displayNone8 = 'style="display: none;"'; }
			if($row1['p9name'] == NULL){ $displayNone9 = 'style="display: none;"'; }
			if($row1['p10name'] == NULL){ $displayNone10 = 'style="display: none;"'; }
			
            $p1name = $row1['p1name'];
            $p1card1 = $hCards[decrypt_card($row1['p1card1'])];
            $p1card2 = $hCards[decrypt_card($row1['p1card2'])];
            // $p1card1 = $hCards[decrypt_card($row1["p{$pi}card1"])];

            $p2name = $row1['p2name'];
            $p2card1 = $hCards[decrypt_card($row1['p2card1'])];
            $p2card2 = $hCards[decrypt_card($row1['p2card2'])];
            
            $p3name = $row1['p3name'];
            $p3card1 = $hCards[decrypt_card($row1['p3card1'])];
            $p3card2 = $hCards[decrypt_card($row1['p3card2'])];

            $p4name = $row1['p4name'];
            $p4card1 = $hCards[decrypt_card($row1['p4card1'])];
            $p4card2 = $hCards[decrypt_card($row1['p4card2'])];

            $p5name = $row1['p5name'];
            $p5card1 = $hCards[decrypt_card($row1['p5card1'])];
            $p5card2 = $hCards[decrypt_card($row1['p5card2'])];

            $p6name = $row1['p6name'];
            $p6card1 = $hCards[decrypt_card($row1['p6card1'])];
            $p6card2 = $hCards[decrypt_card($row1['p6card2'])];

            $p7name = $row1['p7name'];
            $p7card1 = $hCards[decrypt_card($row1['p7card1'])];
            $p7card2 = $hCards[decrypt_card($row1['p7card2'])];

            $p8name = $row1['p8name'];
            $p8card1 = $hCards[decrypt_card($row1['p8card1'])];
            $p8card2 = $hCards[decrypt_card($row1['p8card2'])];

            $p9name = $row1['p9name'];
            $p9card1 = $hCards[decrypt_card($row1['p9card1'])];
            $p9card2 = $hCards[decrypt_card($row1['p9card2'])];

            $p10name = $row1['p10name'];
            $p10card1 = $hCards[decrypt_card($row1['p10card1'])];
            $p10card2 = $hCards[decrypt_card($row1['p10card2'])];
    
    
            $rowHtml = '
			<tr '.$displayNone1.'>
				<td style="color:#fff;">'.$p1name.'</td>
				<td>1</td>
				<td>'.$p1card1.'</td>
				<td>'.$p1card2.'</td>
			</tr> 
			
			<tr '.$displayNone2.'>
				<td style="color:#fff;">'.$p2name.'</td>
				<td>2</td>
				<td>'.$p2card1.'</td>
				<td>'.$p2card2.'</td>
			</tr> 
			<tr '.$displayNone3.'>
				<td style="color:#fff;">'.$p3name.'</td>
				<td>3</td>
				<td>'.$p3card1.'</td>
				<td>'.$p3card2.'</td>
			</tr> 
			
			<tr '.$displayNone4.'>
				<td style="color:#fff;">'.$p4name.'</td>
				<td>4</td>
				<td>'.$p4card1.'</td>
				<td>'.$p4card2.'</td>
			</tr> 
			<tr '.$displayNone5.'>
				<td style="color:#fff;">'.$p5name.'</td><td>5</td>
				<td>'.$p5card1.'</td>
				<td>'.$p5card2.'</td>
			</tr> 
			
			<tr '.$displayNone5.'>
				<td style="color:#fff;">'.$p6name.'</td><td>6</td>
				<td>'.$p6card1.'</td>
				<td>'.$p6card2.'</td>
			</tr> 
			

			<tr '.$displayNone7.'>
				<td style="color:#fff;">'.$p7name.'</td><td>7</td>
				<td>'.$p7card1.'</td>
				<td>'.$p7card2.'</td>
			</tr> 
			
			<tr '.$displayNone8.'>
				<td style="color:#fff;">'.$p8name.'</td><td>8</td>
				<td>'.$p8card1.'</td>
				<td>'.$p8card2.'</td>
			</tr> 
			

			<tr '.$displayNone9.'>
				<td style="color:#fff;">'.$p9name.'</td><td>9</td>
				<td>'.$p9card1.'</td>
				<td>'.$p9card2.'</td>
			</tr> 
			
			<tr '.$displayNone10.'>
				<td style="color:#fff;">'.$p10name.'</td><td>10</td>
				<td>'.$p10card1.'</td>
				<td>'.$p10card2.'</td>
			</tr> 
			

			
			
			';
          


		  $html .= $rowHtml;
        }


        $html .=
        '</tbody>
                </table>
                </div>';


    $opsTheme->addVariable('html', $html);
    echo $opsTheme->viewPage('admin-card1');


?>
