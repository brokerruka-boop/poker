<?php
	if ($valid == false){
		header('Location: login.php');
	}
$html ='
	<H5 class="text-lg font-medium mr-auto">ЦЭНЭГЛЭЛТЫН ТҮҮХ</h5>
	<div class="table-responsive">
	<table class="table table-report">
		<thead>
			<tr>
				<th>Нэр</th>
				<th>Дүн</th>
				<th>Огноо</th>
				<th>Статус</th>
			</tr>
		</thead>
		<tbody>';
		
		$plyrname  = (isset($_SESSION['playername'])) ? addslashes($_SESSION['playername']) : '';
       
		$sql = "SELECT * FROM deposits WHERE player_name=:player_name ORDER BY id desc";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['player_name' => $plyrname]);
        $data = $stmt->fetchAll();
		
		$sqlDansniiDugaar = "SELECT players.username, players.dans FROM players WHERE username = '".$plyrname."' ";
			$stmtDANS = $pdo->prepare($sqlDansniiDugaar);
			$stmtDANS->execute();
			$dataDans = $stmtDANS->fetchAll();
			
			foreach ($dataDans as $rowDans) {
				  $dans = $rowDans['dans'];
			}
		
        foreach ($data as $row) {
            $id = $row['id'];
            $chipsAmount = transfer_from($row['amount']);
            $created_at = $row['created_at'];
            $updated_at = $row['updated_at'];
            $status = $row['status'];

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
				<td>
					<p class="topValue"><a href="" target="_blank">'.$plyrname.'</a></p>
					<p class="bottomValue">'.$dans.'</p>
				</td>
				<td>
					<span class="currency">'.$chipsAmount.'</span> ₮ 
				</td>
				<td>
					<p class="topValue">Илгээсэн: '.$created_at.'</p>
			        <p class="bottomValue">Шинэчилсэн: '.$updated_at.'</p>
				</td>
				<td>
					'.$status.'
				</td>
			</tr>';
			$html .= $rowHtml;
			}
         $html .='
		 </tbody>
		 </table>
		 </div>
		 ';
?>