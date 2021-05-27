<?php
include 'connect.php';

$mest=$_POST['mest'];
$numb_scv=$_POST['numb_scv'];

$res = pg_query($dbconn, "select status from scvazh where name_mest='{$mest}' and number_scv='{$numb_scv}';");

$status = pg_fetch_result($res, 0, 0);

if (($status!='Работает')&&($status!='Авария'))
{
$w=0;
$tal=0;
}
else
{
$w=rand(100, 200);
$tal=rand(10, 20);
}

echo 'W: '; echo $w; 
echo '<br>Таль-блок: '; echo $tal;
?>
