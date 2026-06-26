<?php
	$html ='<style>.btn-sm{margin-right: 5px; font-size: 12px;}</style>
	<h5 style="margin-bottom: 15px;">Мөнгө татах хүсэлтүүд [100]</h5>
			<div class="table-responsive">
			<table class="table table-report sm:mt-2">			
                        <thead>
                            <tr>
                 <th>№</th>
                 <th>Тоглогч</th>
                 <th>Банк</th>
                 <th>Мөнгөн дүн</th>              
                 <th>Төлөв </th>
                 <th>Огноо </th>
             </tr>
         </thead>
         <tbody>';
		 
		 					
if (isset($_GET['p']) && !empty($_GET['p']))
{
  $isPlayer = true;
  $playerNAME = preg_replace('/[^A-Za-z0-9_]/', '', $_GET['p']);
  $sql = "SELECT * FROM withdrawal WHERE player_name = '".$playerNAME."' ORDER BY id desc limit 100"; 
}
 else{
	 $sql = "SELECT * FROM withdrawal ORDER BY id desc limit 100"; 
 }
 
   
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();

    foreach ($data as $row) {
		
        $id = $row['ID'];
        $player_name = $row['player_name'];
        $amount = $row['tatsandvn'];
        $dansdugaar = $row['dansniidugaar'];
        $dansname = $row['dansniiner'];
        $status = $row['status'];
        $created_at = $row['created_at'];
        $updated_at = $row['updated_at'];
				
		$sqlDans = "SELECT players.username, players.bankname FROM players WHERE username = '".$player_name."'";
		$stmtDANS = $pdo->prepare($sqlDans);
		$stmtDANS->execute();
		$dataDans = $stmtDANS->fetchAll();
		foreach ($dataDans as $rowDans){
			$bankname = $rowDans['bankname'];
			
		}
		
		$sqlMungu = "SELECT stats.player, stats.winpot FROM stats WHERE player = '".$player_name."'";
		$stmtMungu = $pdo->prepare($sqlMungu);
		$stmtMungu->execute();
		$dataMungu= $stmtMungu->fetchAll();
		foreach ($dataMungu as $rowMungu){
			$odoobgaaMungu = $rowMungu['winpot'];
		}
				
		if ($status === 'Huleegdej baina') {
			$status = '';
            $approveAction ='
				<form method="post" action="admin.php?admin=tatalt" style="display: inline;">
                    <input type="hidden" name="action" value="withdrawal_approve">
                    <input type="hidden" name="withdrawal_id" value="'.$id.'">
                    <button type="submit" class="btn btn-sm btn-primary">ИЛГЭЭХ </button>
                </form>';
			$denyAction ='
			<form method="post" action="admin.php?admin=deny-withdrawal" style="display: inline;">
                    <input type="hidden" name="action" value="deny-withdrawal">
                    <input type="hidden" name="withdrawal_id" value="' . $id . '">
                    <button type="submit" class="btn btn-sm btn-danger"> ТАТГАЛЗАХ</button>
			</form>';	
        }else {
			$approveAction = '';
			$denyAction = '';
        }
		if($status == 'Zuwshuursun'){
			$status = "<span class='badge badge-success'>ЗӨВШӨӨРСӨН </span>";
        }
		elseif($status == 'Huleegdej baina'){
			$status = "<span class='badge badge-info'>ХҮЛЭЭГДЭЖ БАЙНА </span>";
        }
		elseif($status == 'Tatgalzsan'){
			$status = "<span class='badge badge-danger'>ТАТГАЛЗСАН  </span>";
        }
		$rowHtml = '
			<tr>
				<td>'.$id.'</td>				
				<td>					
					<div class="topValue">'.$player_name.'<a href="admin.php?admin=edit-member&username='.$player_name.'" target="_blank"> <img class="eye" src="themes/bs4/images/eye.png"></a></div>
					<div class="bottomValue" style="margin-top: 5px; border-top: 1px solid #343a40; padding-top: 5px;">'.$mobile.'</div>
				</td>				
				<td>
				    <div class="topValue">'.$bankname.'</div>
					<div class="topValue">'.$dansdugaar.'</div>
					<div class="bottomValue" style="margin-top: 5px; border-top: 1px solid #343a40; padding-top: 5px;">'.$dansname.'</div>
					
					
				</td>
				<td>					
					<div class="topValue" style="display: flex; justify-content: space-between;">Хүсэлт илгээсэн: <span class="badge badge-info currency" style="font-weight: 400; font-size: 14px;">'.$amount.'</span></div>
					<div class="bottomValue" style="display: flex; justify-content: space-between; margin-top: 5px; border-top: 1px solid #343a40; padding-top: 5px;">Яг одоо байгаа: <span class="badge badge-info currency" style="font-weight: 400; font-size: 14px; background-color: #0e4c38; ">'.$odoobgaaMungu.'</span></div>
				</td>
				<td>
					'.$status.$approveAction.$denyAction.'
				</td>
				<td>					
					<div class="topValue">Илгээсэн: '.$created_at.'</div>
					<div class="bottomValue" style="margin-top: 5px; border-top: 1px solid #343a40; padding-top: 5px;">Шинэчилсэн: '.$updated_at.'</div>
				</td>
			</tr>';
    $html .= $rowHtml;
    }
    $html .='
		</tbody>
		</table>
		</div>';
	$opsTheme->addVariable('html', $html);
	echo $opsTheme->viewPage('admin-tatalt');
?>
