<?php
	$html ='<style> .btn-sm{margin-right: 5px; font-size: 12px;}</style>

	<h5 style="margin-bottom: 15px;">Асуудал [100]</h5>
			<div class="table-responsive">
			<table class="table">			
          <thead>
                            <tr>
                                <th class="text-center">№</th>
                                <th class="text-center">Нэр</th>                                
                       
                               
                                <th class="text-center" style="min-width: 150px;">Огноо</th>								
                            </tr>
                        </thead>
                        <tbody>';						
						
if (isset($_GET['p']) && !empty($_GET['p']))
{
  $isPlayer = true;
  $playerNAME = preg_replace('/[^A-Za-z0-9_]/', '', $_GET['p']);
  $sql = "SELECT * FROM asuudal WHERE player_name = '".$playerNAME."' ORDER BY id desc limit 150"; 
}
 else{
	 $sql = "SELECT * FROM asuudal ORDER BY id desc limit 150"; 
 }
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();

	foreach ($data as $row){
		$id = $row['ID'];
		$player_name = $row['player_name'];
		$asuudaltxt = $row['asuudaltxt'];
		$asuudalhariu = $row['asuudalhariu'];
		$created_at = $row['created_at'];
		$updated_at = $row['updated_at'];
		$status = $row['status'];
		
		$profileView ='
			<a  target="_blank" href="admin.php?admin=edit-member&username='.$player_name .'"  class="btn btn-sm btn-dark">Илгээгчийн мэдээлэл</button>';		
			
	if($status === 'Huleegdej baina'){
		$approveAction ='
		<button  onClick="OpenNewWindow('.$id .')"  class="btn btn-sm btn-primary">ХАРИУЛАХ</button>';		
		
    }
	else{
		$approveAction = '
		<button  onClick="OpenNewView('.$id .')"  class="btn btn-sm  btn-success">ХАРИУЛАХ ХАРАХ</button>';		
	}
	
	if($status == 'Shiidwerlesen'){
			$status = "<span class='badge badge-success'>Шийдвэрлэсэн </span>";
    }
	elseif($status == 'Huleegdej baina'){
		$status = "<span class='badge badge-info'> Хүлээгдэж байна </span>";
        }
	$rowHtml = '
			<tr class="intro-x">
			<td>'.$id.'</td>
			
			<td>
				<p class="topValue">
				'.$asuudaltxt.'
				
				</p>
				<div style="display: flex; justify-content: space-between;">
					<p  class="bottomValue">Илгээсэн: '.$created_at.'</p>
				<p  class="bottomValue">	Хариулсан: '.$updated_at.'</p></div>
			</td>
			<td>		
				<div class="topValue">
					<a target="_blank" href="admin.php?admin=edit-member&username='.$player_name .'">
					'.$player_name.'
				</a>
				</div>
				<div class="bottomValue" style="margin-top: 5px; border-top: 1px solid #343a40; padding-top: 5px;">
					'.$approveAction.'
				</div>
			</td>
		</tr>';
	$html .= $rowHtml;
    }
	//end for
    $html .='
		</tbody>
		</table>
		</div>';
	$opsTheme->addVariable('html', $html);
	echo $opsTheme->viewPage('admin-asuudal');