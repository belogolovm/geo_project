<?php
include 'connect.php';

$mest=$_POST['mest'];
$numb_scv=$_POST['numb_scv'];

$res = pg_query($dbconn, "select status from scvazh where name_mest='{$mest}' and number_scv='{$numb_scv}';");

$status = pg_fetch_result($res, 0, 0);

if (($status!='Работает')&&($status!='Авария'))
{
$p=0;
$chislo_hod=0;
}
else
{
$p=rand(10, 100);
$chislo_hod=rand(10, 30);
}
echo 'Давл.: '; echo $p; echo ' атм.';
echo '<br>Числ.ход: '; echo '<center>'; echo $chislo_hod; echo '</center>ход/мин';
?>
