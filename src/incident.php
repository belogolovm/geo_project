        <title>Нефтяные месторождения</title>
		   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.2.3/jquery.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<?php
include "connect.php";
$ip =$_SERVER['REMOTE_ADDR'];
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
	    $query = pg_query($dbconn, "SELECT * from users WHERE user_id = '{$_COOKIE['id']}' LIMIT 1");
    $userdata = pg_fetch_assoc($query);
		    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
 or (($userdata['user_ip'] !== $ip)  and ($userdata['user_ip'] !== "0")))
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/");
        print "ERROR";
		exit;
	}
}
	if ( !isset( $_GET["action"] ) ) $_GET["action"] = "showlist";  
switch ( $_GET["action"] ) 
{ 
  case "showlist":    // Список всех записей в таблице БД
    show_list(); break; 
  case "delete":      // Удалить запись в таблице БД
    delete_item(); break;
  default: 
    show_list(); 
}


// Функция выводит список всех записей в таблице БД
function show_list() 
{
	echo '<div class="incident">';  	
		        echo '<a href="logout.php" style="float:right;">Выйти</a>'; 
		echo '<a href="index.php" style="float:left;">Открыть карту</a><br>';	
 include "connect.php";
 	
 $query1 = pg_query($dbconn, "SELECT * from users WHERE user_id = '{$_COOKIE['id']}' LIMIT 1");
    $userdata = pg_fetch_assoc($query1);
$user_login=$userdata['user_login'];
  $query = "SELECT * FROM incidents.".$user_login." order by date desc ";
  $res = pg_query( $query ); 
  echo '<link rel="stylesheet" href="style_table.css" type="text/css"  />';
  echo '<center><table class="simple-little-table"'; echo "cellspacing='0'>"; // start a table tag in the HTML
  echo '<tr><th>Месторождение</th><th>Номер скважины</th><th>Статус</th><th>Дата</th><th>Удл.</th></tr>'; 
  while ( $item = pg_fetch_array( $res ) ) 
  { 
    echo '<tr>'; 
    echo '<td>'.$item['name_mest'].'</td>'; 
    echo '<td>'.$item['number_scv'].'</td>'; 
	if ($item['status']=='Авария')
	echo '<td><font color="red">'.$item['status'].'</td>'; 
	if ($item['status']=='Остановлена')
	echo '<td><font color="black">'.$item['status'].'</td>'; 
	if ($item['status']=='Работает')
	echo '<td><font color="green">'.$item['status'].'</td>'; 
	echo '<td>'.$item['date'].'</td>'; 
    echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=delete&name_mest='.$item['name_mest'].'&number_scv='.$item['number_scv'].'&date='.$item['date'].'">Удл.</a></td>'; 
    echo '</tr>'; 
  } 
  echo '</table></center>'; 
   echo '</div>';

  }

 function delete_item() 
{ 
 include "connect.php";
 $query1 = pg_query($dbconn, "SELECT * from users WHERE user_id = '{$_COOKIE['id']}' LIMIT 1");
    $userdata = pg_fetch_assoc($query1);
$user_login=$userdata['user_login'];

  $name_mest=$_GET['name_mest'];
  $number_scv=$_GET['number_scv'];
  $date=$_GET['date'];
  $query = "DELETE FROM incidents.".$user_login." WHERE name_mest='{$name_mest}' and number_scv='{$number_scv}' and date='{$date}'"; 
  pg_query ( $query ); 
  header( 'Location: '.$_SERVER['PHP_SELF'] );
  die();
} 
	
	
?>

<script>
$(document).ready(function(){
var user_login = "<?php echo $userdata['user_login'] ?>";
window.setInterval(function(){
 $.ajax({
	   type: 'POST',
  url: 'inc_back.php',
   data:  "login="+user_login,
  success: function(data) {
    $('.incident').html(data);
 }
});
}, 4000);
});
</script>