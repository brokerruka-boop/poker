<?php
	$html ='<style> .btn-sm{margin-right: 5px; font-size: 12px;}</style>

	<h5 style="margin-bottom: 15px;">Цэнэглэх хүсэлтүүд [100]</h5>
			<div class="table-responsive">
			<table class="table table-report sm:mt-2">			
                        <thead>
                            <tr>
                                <th class="text-center">№</th>
                                <th class="text-center">Нэр</th>                                
                                <th class="text-center">Дүн</th>
                                <th class="text-center">Төлөв</th>
                                <th class="text-center">Огноо</th>								
                            </tr>
                        </thead>
                        <tbody>';						
						
if (isset($_GET['p']) && !empty($_GET['p']))
{
  $isPlayer = true;
  $playerNAME = preg_replace('/[^A-Za-z0-9_]/', '', $_GET['p']);
  $sql = "SELECT * FROM deposits WHERE player_name = '".$playerNAME."' ORDER BY id desc limit 100"; 
}
 else{
	 $sql = "SELECT * FROM deposits ORDER BY id desc limit 100"; 
 }
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();

foreach ($data as $row){
	$id = $row['ID'];
	$player_name = $row['player_name'];
	$amount = $row['amount'];
	$status = $row['status'];
	$created_at = $row['created_at'];
	$updated_at = $row['updated_at'];
	
	$sqlDans = "SELECT players.username, players.dans FROM players WHERE username = '".$player_name."'";
		$stmtDANS = $pdo->prepare($sqlDans);
		$stmtDANS->execute();
		$dataDans = $stmtDANS->fetchAll();
		foreach ($dataDans as $rowDans){
			$dans = $rowDans['dans'];
		}
	if($status === 'Huleegdej baina'){
		$approveAction ='
		<form method="post" action="?admin=tseneglelt" style="display: inline;">
			<input type="hidden" name="action" value="deposit_approve">
			<input type="hidden" name="deposit_id" value="' . $id . '">
			<button type="submit" class="btn btn-sm btn-primary">ЗӨВШӨӨРӨХ</button>
		</form>';
		$denyAction ='
		<form method="post" action="admin.php?admin=deny-deposit" style="display: inline;">
			<input type="hidden" name="action" value="deny-deposit">
			<input type="hidden" name="deposit_id" value="' . $id . '">
			<button type="submit" class="btn btn-sm btn-danger">  ТАТГАЛЗАХ</button>
		</form>';
		
	$status = "";
        }
	else{
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
		<tr class="intro-x">
			<td>'.$id.'</td>
			<td>
				<p class="topValue">'.$player_name.'</p>
				<p class="bottomValue">'.$dans.'</p>
			</td>
			<td>
				<span class="currency">'.$amount.'</span> ₩
			</td>
			<td>
				'.$status.''.$approveAction.$denyAction.'
			</td>
			<td>
				<p class="topValue"><a href="">Илгээсэн: '.$created_at.'</a></p>
				<p class="bottomValue">Шинэчилсэн: '.$updated_at.'</p>
			</td>
			</tr>';
	$html .= $rowHtml;
    }
	//end for
    $html .='
		</tbody>
		</table>
		</div>';
	
	$allMoney = $pdo->query('select sum(winpot) from stats')->fetchColumn(); 
	$allMoneySef = $pdo->query('select sum(sefdvn) from stats')->fetchColumn(); 

	$opsTheme->addVariable('html', $html);
	$opsTheme->addVariable('allMoney', $allMoney);
	$opsTheme->addVariable('allMoneySef', $allMoneySef);
	echo $opsTheme->viewPage('admin-tseneglelt');
	
	

