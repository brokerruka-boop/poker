<?php
	if ($valid == false){
		header('Location: login.php');
	}
	

$html ='<table class="table table-report" style="padding: 0px;"><tbody>';
		
		$plyrname  = (isset($_SESSION['playername'])) ? addslashes($_SESSION['playername']) : '';
       
		$sql = "SELECT * FROM asuudal WHERE player_name=:player_name ORDER BY id desc";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['player_name' => $plyrname]);
        $data = $stmt->fetchAll();
		

        foreach ($data as $row) {
            $id = $row['id'];
            $asuudaltxt = $row['asuudaltxt'];
            $asuudalhariu = $row['asuudalhariu'];
            $created_at = $row['created_at'];
            $updated_at = $row['updated_at'];
            $status = $row['status'];

		if($status == 'Shiidwerlesen'){
			$status = "<span class='badge badge-success'>Шийдвэрлэсэн </span>";
        }
		elseif($status == 'Huleegdej baina'){
			$status = "<span class='badge badge-info'>ХҮЛЭЭГДЭЖ БАЙНА </span>";
        }
		$rowHtml = '
			<tr>
				<td>'.$asuudaltxt.'
				
				
				<br>
			        <p class="bottomValue" style="text-align: right;">
					Илгээсэн: '.$created_at.'<br>
					Хариулсан: '.$updated_at.'<br>
					'.$status.'
					</p>
				</td></tr>';
			
			$html .= $rowHtml;
			
			if($asuudalhariu == "0"){}
			else{
			$hariu = '
			
				<tr class="hariu">
					<td>'.$asuudalhariu.'</td>
				</tr>';
			$html .= $hariu;
			}
			
			}
			
         $html .='
		 </tbody>
		 </table>
		 
		 ';
		 
		 
$time = time();
$action = (isset($_POST['action'])) ? addslashes($_POST['action']) : '';

$asuudaltxt = (isset($_POST['asuudaltxt'])) ? addslashes($_POST['asuudaltxt']) : '';

if ($action == 'asuudal' && $plyrname != '')
{
	$player_name  = (isset($_SESSION['playername'])) ? addslashes($_SESSION['playername']) : '';
    $sql = "SELECT asuudal.status, asuudal.player_name FROM asuudal WHERE player_name=:player_name ORDER BY ID DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['player_name' => $player_name]);
    $data = $stmt->fetchAll();
    foreach ($data as $row) {
        $status = $row['status'];
    }
	
    if($status != 'Huleegdej baina'){
		date_default_timezone_set('GMT+8');
		$nowTimeThis= date('Y/m/d H:i');
        $status = 'Huleegdej baina';
        $sql = "INSERT INTO asuudal (player_name, asuudaltxt, status, created_at) VALUES ('".$player_name."', '".$asuudaltxt."','".$status."', '".$nowTimeThis."')";
        $pdo->exec($sql);
		$message = "Хүсэлт амжилттай илгээгдлээ.";
	}
	else{
		$error = true;
		$message = "Асуудал илгээсэн байна, шийдэгдэх хүртэл түр хүлээнэ үү!";
	}
	

}