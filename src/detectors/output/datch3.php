<?php
include '../../connect.php';

/// проверка пользователя

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
        print "Хм, что-то не получилось";
    }
    else
    {
		// если пользователь авторизован
$numb_scv=$_POST['numb_scv'];
$res = pg_query($dbconn, "select * from detectors.datch3_{$numb_scv} order by DATE desc limit 1;");
$nagr=pg_fetch_result($res, 0, 0);
$date1=pg_fetch_result($res, 0, 1);
echo '<font size="1" color="#1E90FF">';echo $date1; echo '</font><br>';
echo 'Нагрузка: '; echo '<center>'; echo $nagr; echo ' т.'; echo '</center>';
	}
}
?>
