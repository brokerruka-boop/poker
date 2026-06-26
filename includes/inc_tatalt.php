
<?php

if ($valid == false)
{
    header('Location: login.php');
}

$html ='<H5 class="text-lg font-medium mr-auto">ТАТАЛЫН  ТҮҮХ</h5>
                   <div class="table-responsive intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
			<table class="table table-report sm:mt-2">
			
                            <thead>
                                <tr>
                              
                                <th>Нэр</th>
                                <th>Дүн</th>
                                <th>Огноо</th>
                                <th>Төлөв</th>
                               
                                </tr>
                            </thead>
                            <tbody>';
                            $plyrname  = (isset($_SESSION['playername'])) ? addslashes($_SESSION['playername']) : '';
                            $sql = "SELECT * FROM withdrawal WHERE player_name=:player_name ORDER BY id desc";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute(['player_name' => $plyrname]);
                            $data = $stmt->fetchAll();
                            foreach ($data as $row) {
                                $id = $row['id'];
                                $chipsAmount = transfer_from($row['tatsandvn']);
                                $created_at = $row['created_at'];
                                $updated_at = $row['updated_at'];
                                $status = $row['status'];
                                $dansniner = $row['dansniner'];
                                $dansnidugaar = $row['dansnidugaar'];
                                $bankname = $row['bankname'];
								
								
								if($status == 'Zuwshuursun'){
			$status = "<span class='badge badge-success'>ЗӨВШӨӨРСӨН </span>";
        }
		elseif($status == 'Huleegdej baina'){
			$status = "<span class='badge badge-info'>ХҮЛЭЭГДЭЖ БАЙНА </span>";
        }
		elseif($status == 'Tatgalzsan'){
			$status = "<span class='badge badge-danger'>ТАТГАЛЗСАН  </span>";
        }
								
                                $rowHtml = '<tr><td>
								
			<p class="topValue"><a href="" target="_blank" class="font-medium whitespace-no-wrap">'.$plyrname.'</a> </p>
          <p class="bottomValue">'.$dansniner.'</p>
			
			
							</td><td>
							
				<p class="topValue"><span class="currency">'.$chipsAmount.'</span> ₮</p>
				
				
			        <p class="bottomValue">'.$dansnidugaar.'</p>
			        <p class="bottomValue">'.$bankname.'</p>
							
							</td><td>
							
							
						<p class="topValue">Илгээсэн: '.$created_at.' </p>
			        <p class="bottomValue">Шинэчилсэн: '.$updated_at.'</p>
					
					
							</td><td>'.$status.'</td></tr>';
                                $html .= $rowHtml;
                            }
                            $html .=
                        '</tbody>
                    </table>
                </div>
      
		
		
		';


?>