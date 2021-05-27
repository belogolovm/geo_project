<title>Нефтяные месторождения</title>
<link rel="stylesheet" href="style_change.css">
<?php
// Страница регистрации нового пользователя
$ip =$_SERVER['REMOTE_ADDR'];
$dbconn= pg_connect("host=127.0.0.1 dbname=pgpool user=geobd1 password=geobd1");

echo '<a style="color:#0000FF;" href="index.php" style="float:left;">Вернуться на главную</a><br>';

if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
   $query = pg_query($dbconn, "SELECT * from users WHERE user_id = '{$_COOKIE['id']}' LIMIT 1");
    $userdata = pg_fetch_assoc($query);
	
	
$user_hash=$userdata['user_hash'];


  if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
 or (($userdata['user_ip'] !== $ip)  and ($userdata['user_ip'] !== "0")))
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/"); 
        print "Пожалуйста, повторите авторизацию<br>";
   }
    else
    {
$login = $userdata['user_login'];;
	}
}
else
{
header("Location: login.php");
exit();
}


$password = md5(md5(trim($_POST['password'])));
$querypass = pg_query($dbconn, "select user_password from users where user_login='{$login}'");
$passbd = pg_fetch_result($querypass, 0, 0);
if(isset($_POST['submit']))
{
    $err = [];

	
	if($password!=$passbd)
	{
	$err[] = "Старый пароль введен неверно!";	
	}
	
		if($_POST['new_password']!=$_POST['new_password2'])
	{
	$err[] = "Новые пароли не совпадают";	
	}

	
    if(strlen($_POST['new_password']) < 4)
    {
        $err[] = "Пароль должен быть не меньше 4-х символов";
    }
	
    // Если нет ошибок, то обновляем в БД пароль
    if(count($err) == 0)
    {        // Убераем лишние пробелы и делаем двойное хеширование
        $new_password = md5(md5(trim($_POST['new_password'])));
       pg_query($dbconn,"UPDATE users SET user_password = '{$new_password}' WHERE user_login = '{$login}'");	   
       print "<center><b>Пароль успешно изменен!</b><br><br></center>"; 
    }
    else
    {
        print "<center><b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
		print "</center><br>";
    }
}

?>

<form method="POST">
<center><font color="white" size="3" face="Arial">Введите текущий пароль<center></font><br>
<input name="password" placeholder="Текущий пароль"  type="password" class="name" required />
<center><font color="white" size="3" face="Arial">Введите новый пароль<center></font><br>
    <input name="new_password" placeholder="Новый пароль" class="name" type="password" required />
<center><font color="white" size="3" face="Arial">Введите новый пароль еще раз<center></font><br>
    <input name="new_password2" placeholder="Новый пароль еще раз" class="name" type="password" required />
    <input name="submit" class="btn" type="submit" value="Изменить" />
</form>
