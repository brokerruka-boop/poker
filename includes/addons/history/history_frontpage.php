<?php 
require('includes/inc_lobby.php');
include 'templates/header.php';

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

$tbl_name="history";  //your table name
// How many adjacent pages should be shown on each side?
$adjacents = 1;
/*
First get total number of rows in data table.
If you have a WHERE clause in your query, make sure you mirror it here.
*/

$playa = $plyrname;
$isPlayer = false;

if (isset($_GET['player']) && !empty($_GET['player']))
{
  $isPlayer = true;
  $playa = preg_replace('/[^A-Za-z0-9_]/', '', $_GET['player']);
}

$query = "SELECT COUNT(*) as num FROM $tbl_name  WHERE (p1name = '".$playa."') OR (p2name = '".$playa."') OR (p3name = '".$playa."') OR (p4name = '".$playa."') OR (p5name = '".$playa."') OR (p6name = '".$playa."') OR (p7name = '".$playa."') OR (p8name = '".$playa."') OR (p9name = '".$playa."') OR (p10name = '".$playa."')";

if ($ADMIN == true && $isPlayer == false)
  $query = "SELECT COUNT(*) as num FROM $tbl_name";


$total_query = $pdo->prepare($query); $total_query->execute();
$total_pages = $total_query->fetch(PDO::FETCH_ASSOC);
$total_pages = $total_pages['num'];

/* Setup vars for query. */
$targetpage = ($isPlayer) ? "history.php?player={$playa}" : "history.php?go";   //your file name  (the name of this file)
$limit = 10;  //how many items to show per page
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
if($page)
$start = ($page - 1) * $limit;      //first item to display on this page
else
$start = 0; //if no page var is given, set start to 0
/* Get data. */



    

$plq = "select * FROM history WHERE (p1name = '".$playa."') OR (p2name = '".$playa."') OR (p3name = '".$playa."') OR (p4name = '".$playa."') OR (p5name = '".$playa."') OR (p6name = '".$playa."') OR (p7name = '".$playa."') OR (p8name = '".$playa."') OR (p9name = '".$playa."') OR (p10name = '".$playa."') order by date desc LIMIT $start, $limit";

if ($ADMIN == true && $isPlayer == false){             
    $plq = "select * FROM history order by date desc LIMIT $start, $limit";
}



$result = $pdo->prepare($sql); $result->execute();


/* Setup page vars for display. */
if ($page == 0) $page = 1;          //if no page var is given, default to 1.
$prev = $page - 1;//previous page is page - 1
$next = $page + 1;//next page is page + 1
$lastpage = ceil($total_pages/$limit);    //lastpage is = total pages / items per page, rounded up.
$lpm1 = $lastpage - 1;            //last page minus 1

/*
Now we apply our rules and draw the pagination object.
We're actually saving the code to a variable in case we want to draw it more than once.
*/
$pagination = "";
if($lastpage > 1)
{
  $pagination .= "
  
<nav>
  <ul class=\"pagination\"> 
  
  ";
  //previous button
  if ($page > 1)
  $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$prev\"><a class=\"page-link\"><span aria-hidden=\"true\">&laquo;</span></a></li>";
  else
  $pagination.= "<li class=\"page-item\"><a class=\"page-link\"><span aria-hidden=\"true\">&laquo;</span></li>";
  
  //pages
  if ($lastpage < 7 + ($adjacents * 2)) //not enough pages to bother breaking it up
  {
    for ($counter = 1; $counter <= $lastpage; $counter++)
    {
      if ($counter == $page)
      $pagination.= "<li class=\"page-item active\"><a class=\"page-link\"><span>$counter</span></a></li>";
      else
      $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$counter\">$counter</a></li>";
    }
  }
  elseif($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
  {
    //close to beginning; only hide later pages
    if($page < 1 + ($adjacents * 2))
    {
      for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
      {
        if ($counter == $page)
        $pagination.= "<li class=\"page-item active\"><span>$counter</span></li>";
        else
        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$counter\">$counter</a></li>";
      }
      $pagination.= "";
      $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$lpm1\">$lpm1</a></li>";
      $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$lastpage\">$lastpage</a></li>";
    }
    //in middle; hide some front and some back
    elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    {
      $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=1\">1</a></li>";
      $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=2\">2</a></li>";
      $pagination.= "";
      for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
      {
        if ($counter == $page)
        $pagination.= "<li class=\"page-item active\"><span>$counter</span></li>";
        else
        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$counter\">$counter</a></li>";
      }
      $pagination.= "";
      $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$lpm1\">$lpm1</a></li>";
      $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$lastpage\">$lastpage</a></li>";
    }
    //close to end; only hide early pages
    else
    {
      $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=1\">1</a></li>";
      $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=2\">2</a></li>";
      $pagination.= "";
      for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
      {
        if ($counter == $page)
        $pagination.= "<li class=\"page-item active\"><a class=\"page-link\"><span>$counter</span></a></li>";
        else
        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$counter\">$counter</a></li>";
      }
    }
  }
  
  //next button
  if ($page < $counter - 1)
  $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$next\"><span aria-hidden=\"true\">&raquo;</span></a></li>";
  else
  $pagination.= "<li class=\"page-item\"><a class=\"page-link\"><span aria-hidden=\"true\">&raquo;</span></a></li>";
  $pagination.= "
  
  </ul>
</nav>  
  
  ";
}
$opsTheme->addVariable('pagination',  $pagination);
$opsTheme->addVariable('page',        $page);
$opsTheme->addVariable('total_pages', $total_pages);


$dir = (isset($_GET['dir'])) ? addslashes($_GET['dir']) : 'asc';
$col = (isset($_GET['col'])) ? addslashes($_GET['col']) : DB_PLAYERS.'.username';

$rows = '';
$result1 = $pdo->prepare($plq);
$result1->execute();
$i = 1;
$histories = array();
while ($plr = $result1->fetch(PDO::FETCH_ASSOC))
{
  $histories[]     = $plr['id'];
  $plr['index']    = $i;
  $plr['msg']      = ucfirst(stripslashes($plr['msg']));
  $plr['potmoney'] = money($plr['pot']);

  for ($pi = 1; $pi < 11; $pi++)
  {
    $plr["p{$pi}potmoney"] = money($plr["p{$pi}pot"]);

    if (substr($plr["p{$pi}bet"], 0, 1) == 'F')
    {
      $plrbetnum             = (int) str_replace('F', '', $plr["p{$pi}bet"]);
      $plr["p{$pi}betmoney"] = money($plrbetnum) . ' (Folded)';
    }
    else
      $plr["p{$pi}betmoney"] = money($plr["p{$pi}bet"]);
  }


  $plr['card1'] = $hCards[decrypt_card($plr['card1'])];
  $plr['card2'] = $hCards[decrypt_card($plr['card2'])];
  $plr['card3'] = $hCards[decrypt_card($plr['card3'])];
  $plr['card4'] = $hCards[decrypt_card($plr['card4'])];
  $plr['card5'] = $hCards[decrypt_card($plr['card5'])];


  $hands = '';
  for ($pi = 1; $pi < 11; $pi++)
  {
    $pname = $plr["p{$pi}name"];
    $pcard1 = $hCards[decrypt_card($plr["p{$pi}card1"])];
    $pcard2 = $hCards[decrypt_card($plr["p{$pi}card2"])];
    $ppot = $plr["p{$pi}pot"];
    $pbet = $plr["p{$pi}bet"];

    $ppotmoney = $plr["p{$pi}potmoney"];
    $pbetmoney = $plr["p{$pi}betmoney"];

    $opsTheme->addVariable('pname',     $pname);
    $opsTheme->addVariable('pcard1',    $pcard1);
    $opsTheme->addVariable('pcard2',    $pcard2);
    $opsTheme->addVariable('ppot',      $ppot);
    $opsTheme->addVariable('pbet',      $pbet);
    $opsTheme->addVariable('ppotmoney', $ppotmoney);
    $opsTheme->addVariable('pbetmoney', $pbetmoney);

    if (strlen($pname) > 0)
      $hands .= $opsTheme->viewPart('history-hands', __DIR__);
  }

  $plr['hands'] = $hands;
  $opsTheme->addVariable('history', $plr);

  $modal = $opsTheme->viewPart('history-modal', __DIR__);
  $plr['modal'] = $modal;
  $opsTheme->addVariable('history', $plr);

  $rows .= $opsTheme->viewPart('history-row', __DIR__);

  $i++;
}
$opsTheme->addVariable('rows', $rows);

if (isset($_GET['hand']))
{
  $modal   = '';
  $handId  = (int) $_GET['hand'];
  
  if (! in_array($handId, $histories))
  {
    $handStm = $pdo->query("SELECT * FROM history WHERE id = {$handId}");
    
    if ($handStm->rowCount() == 1)
    {
      $plr = $handStm->fetch(PDO::FETCH_ASSOC);

      $plr['msg']      = ucfirst(stripslashes($plr['msg']));
      $plr['potmoney'] = money($plr['pot']);

      for ($pi = 1; $pi < 11; $pi++)
      {
        $plr["p{$pi}potmoney"] = money($plr["p{$pi}pot"]);

        if (substr($plr["p{$pi}bet"], 0, 1) == 'F')
        {
          $plrbetnum             = (int) str_replace('F', '', $plr["p{$pi}bet"]);
          $plr["p{$pi}betmoney"] = money($plrbetnum) . ' (Folded)';
        }
        else
          $plr["p{$pi}betmoney"] = money($plr["p{$pi}bet"]);
      }


      $plr['card1'] = $hCards[decrypt_card($plr['card1'])];
      $plr['card2'] = $hCards[decrypt_card($plr['card2'])];
      $plr['card3'] = $hCards[decrypt_card($plr['card3'])];
      $plr['card4'] = $hCards[decrypt_card($plr['card4'])];
      $plr['card5'] = $hCards[decrypt_card($plr['card5'])];


      $hands = '';
      for ($pi = 1; $pi < 11; $pi++)
      {
        $pname = $plr["p{$pi}name"];
        $pcard1 = $hCards[decrypt_card($plr["p{$pi}card1"])];
        $pcard2 = $hCards[decrypt_card($plr["p{$pi}card2"])];
        $ppot = $plr["p{$pi}pot"];
        $pbet = $plr["p{$pi}bet"];

        $ppotmoney = $plr["p{$pi}potmoney"];
        $pbetmoney = $plr["p{$pi}betmoney"];

        $opsTheme->addVariable('pname',     $pname);
        $opsTheme->addVariable('pcard1',    $pcard1);
        $opsTheme->addVariable('pcard2',    $pcard2);
        $opsTheme->addVariable('ppot',      $ppot);
        $opsTheme->addVariable('pbet',      $pbet);
        $opsTheme->addVariable('ppotmoney', $ppotmoney);
        $opsTheme->addVariable('pbetmoney', $pbetmoney);

        if (strlen($pname) > 0)
          $hands .= $opsTheme->viewPart('history-hands', __DIR__);
      }

      $plr['hands'] = $hands;
      $opsTheme->addVariable('history', $plr);

      $modal = $opsTheme->viewPart('history-modal', __DIR__);
    }
  }

  $opsTheme->addVariable('hand', array(
    'id'    => $handId,
    'modal' => $modal,
  ));
}

echo $opsTheme->viewPage('history', __DIR__);

include 'templates/footer.php';
?>