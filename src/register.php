<title>Регистрация пользователя</title>
<link rel="stylesheet" href="style_change.css">
<?php
include "connect.php";
$ip =$_SERVER['REMOTE_ADDR'];
echo '<a style="color:#0000FF;" href="index.php" style="float:left;">Вернуться на главную</a><br>';
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
   $query = pg_query($dbconn, "SELECT * from users WHERE user_id = '{$_COOKIE['id']}' LIMIT 1");
    $userdata = pg_fetch_assoc($query);

  if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
 or (($userdata['user_ip'] !== $ip)  and ($userdata['user_ip'] !== "0")))
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/");
        print "Пожалуйста, авторизуйтесь заново.";
		header("Location: index.php"); exit();
    }
}
	if ($userdata['user_login']!='admin') { print "<center>У вас нет прав для входа в систему!"; 	
	echo '<br><br><a href="index.php" style="float:center;">Открыть карту</a></center>'; exit(); }


// Страница регистрации нового пользователя
$login = $_POST['login'];
// Соединямся с БД
$dbconn= pg_connect("host=127.0.0.1 dbname=geobd user=geobd1 password=geobd1");

if(isset($_POST['submit']))
{
    $err = [];

    // проверям логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

    // проверяем, не сущестует ли пользователя с таким именем
    $query = pg_query($dbconn, "SELECT user_id FROM users WHERE user_login='{$login}'");
    if(pg_num_rows($query) > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }
	

			if($_POST['company']==null)
	       $company = null;
            else 
	 	 $company = $_POST['company'];
        if(empty($_POST['name']))
	 $name = 'Нет данных';
         if(empty($_POST['email']))
	 $email = 'Нет данных';
		if ($company!=null)
		{
 $query1 = pg_query($dbconn, "SELECT name FROM company WHERE name='{$company}'");

    if(pg_num_rows($query1) == 0)
    {
        $err[] = "Такой оранизации в базе данных нет";
    }
		}


	if($_POST['password']!=$_POST['password2'])
	{
	$err[] = "Новые пароли не совпадают";	
	}
	
    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {

        // Убераем лишние пробелы и делаем двойное хеширование
        $password = md5(md5(trim($_POST['password'])));
        if ($company!=null)
       pg_query($dbconn,"INSERT INTO users (user_login, user_password,company,name,email) values ('{$login}','{$password}','{$company}','{$name}','{$email}')");
	   else
	   pg_query($dbconn,"INSERT INTO users (user_login, user_password,name,email) values ('{$login}','{$password}','{$name}','{$email}')"); 
	   print "<center><br>Пользователь успешно зарегистрирован!</center>"; 	
	   

    }
    else
    {
        print "<b><center>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
		print "</center>";
    }
}

?>

<form method="POST">
<center><font color="white" size="3" face="Arial">Введите логин<center></font><br>
<input name="login" placeholder="Логин"  type="text" class="name" required />
<center><font color="white" size="3" face="Arial">Введите ФИО<center></font><br>
<input name="fio" placeholder="Фамилия Имя Отчество"  type="text" class="name" />
<center><font color="white" size="3" face="Arial">Введите организацию<center></font><br>
<input name="company" placeholder="Организация"  type="text" class="name" />
<center><font color="white" size="3" face="Arial">Введите e-mail<center></font><br>
<input name="email" placeholder="Электронная почта"  type="text" class="name" />
<center><font color="white" size="3" face="Arial">Пароль<center></font><br>
    <input name="password" placeholder="Новый пароль" class="name" type="password" required />
<center><font color="white" size="3" face="Arial">Введите пароль еще раз<center></font><br>
    <input name="password2" placeholder="Пароль еще раз" class="name" type="password" required />
    <input name="submit" class="btn" type="submit" value="Зарегистрировать" />
</form>