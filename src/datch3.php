<?php
include 'connect.php';

$mest=$_POST['mest'];
$numb_scv=$_POST['numb_scv'];

$res = pg_query($dbconn, "select status from scvazh where name_mest='{$mest}' and number_scv='{$numb_scv}';");

$status = pg_fetch_result($res, 0, 0);

if (($status!='Работает')&&($status!='Авария'))
{
$nagr=0;
}
else
$nagr=rand(10, 100);

echo 'Нагрузка: '; echo '<center>'; echo $nagr; echo ' т.'; echo '</center>';
?>
