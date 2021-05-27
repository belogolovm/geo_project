<?php
include 'connect.php';
$mest=$_POST['mest'];
$numb_scv=$_POST['numb_scv'];


$res = pg_query($dbconn, "select status from scvazh where name_mest='{$mest}' and number_scv='{$numb_scv}';");

$status = pg_fetch_result($res, 0, 0);

if ($status=='Авария')
{
$rash=rand(0, 1);
$rash=$rash/5;
$temp=rand(80, 120);
$elpr=0;
$gaz=rand(0, 5);
}
if ($status=='Остановлена')
{
$rash=0;
$temp=0;
$elpr=0;
$gaz=0;
}

if ($status=='Работает')
{
$rash=rand(3, 20);
$temp=rand(20, 40);
$elpr=rand(1, 3);
$gaz=rand(30, 100);
}

echo 'Расх.:'; echo $rash; echo ' л/c'; 
if ($temp>79)
{
echo '<br><span style="background-color:red">Темп-ра:'; echo $temp; echo "</span>";
}
else
{
echo '<br>Темп-ра:'; echo $temp; 
}
if (($elpr<1)&&($status!='Остановлена'))
{
	echo '<br><span style="background-color:red">Эл-пр:'; echo $elpr; echo "</span>";
}
else
{
echo '<br>Эл-пр:'; echo $elpr;
}
echo '<br>Нефть:'; echo $gaz; echo '%';	

?>

