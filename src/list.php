        <title>Нефтяные месторождения</title>
		   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.2.3/jquery.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<?php
include "connect.php";
$ip =$_SERVER['REMOTE_ADDR'];
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
	echo '<div class="list">';
	   $query = pg_query($dbconn, "SELECT * from users WHERE user_id = '{$_COOKIE['id']}' LIMIT 1");
    $userdata = pg_fetch_assoc($query);
	 $user_company=$userdata['company'];
	    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
 or (($userdata['user_ip'] !== $ip)  and ($userdata['user_ip'] !== "0")))
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/");
        print "ERROR";
		exit;
	}
	 
	        echo '<a href="logout.php" style="float:right;">Выйти</a>'; 
		echo '<a href="index.php" style="float:left;">Открыть карту</a><br>';
		  $query = "select t1.name_mest,t1.number_scv,t1.koord,t1.status,t2.name,t1.radius from scvazh t1 inner join users t2 on t1.employee=t2.user_id
where t1.company='{$user_company}' order by t1.status; ";
  $res = pg_query( $query ); 
  echo '<link rel="stylesheet" href="style_table.css" type="text/css"  />';
  echo '<center><table class="simple-little-table"'; echo "cellspacing='0'>"; // start a table tag in the HTML
  echo '<tr><th>Месторождение</th><th>Номер скважины</th><th>Координаты</th><th>Статус</th><th>Ответственное лицо</th><th>Радиус</th></tr>'; 
  while ( $item = pg_fetch_array( $res ) ) 
  { 
	 echo '<tr>'; 
    echo '<td>'.$item['name_mest'].'</td>'; 
    echo '<td>'.$item['number_scv'].'</td>'; 
    echo '<td>'.$item['koord'].'</td>'; 
	if ($item['status']=='Авария')
	echo '<td><font color="red">'.$item['status'].'</td>'; 
	if ($item['status']=='Остановлена')
	echo '<td><font color="black">'.$item['status'].'</td>'; 
	if ($item['status']=='Работает')
	echo '<td><font color="green">'.$item['status'].'</td>'; 

	echo '<td>'.$item['name'].'</td>';
    echo '<td>'.$item['radius'].'</td>'; 	
    echo '</tr>'; 
  } 
  echo '</table></center>'; 
  echo '</div>';
	}
else
{
	header("Location: login.php"); exit();
}	
?>
<script>
$(document).ready(function(){
var user_company = "<?php echo $user_company ?>";
window.setInterval(function(){
 $.ajax({
	   type: 'POST',
  url: 'list_back.php',
   data:  "company="+user_company,
  success: function(data) {
    $('.list').html(data);
 }
});
}, 4000);
});
</script>
