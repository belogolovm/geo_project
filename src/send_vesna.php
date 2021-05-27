<?php
echo !extension_loaded('openssl')?"Not Available":"Available";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer library files
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

include "connect.php";


    $servers = pg_query($dbconn, "select * from public.servers order by name");
    $kol_servers=pg_num_rows($servers);

//загоняем в массивы сервера из бд 	
$name= pg_fetch_all_columns($servers, 0);
$ip= pg_fetch_all_columns($servers, 1);
$port = pg_fetch_all_columns($servers, 2);
$status=pg_fetch_all_columns($servers, 3);
$mail_bd=pg_fetch_all_columns($servers, 4);

function repeat_connect($ip,$port,$status,$name,$mail_bd,$i)
{
	include "connect.php";
	sleep(5);
	$fp = @fsockopen($ip[$i],$port[$i],$errno,$errstr,5);
	        if ($fp) { 
		//echo 'Порт '.$port[$i].' открыт на вашем сервере!'; 
		fclose($fp); 
			}
			else {
				repeat_connect2($ip,$port,$status,$name,$mail_bd,$i);
			}
}
function repeat_connect2($ip,$port,$status,$name,$mail_bd,$i)
{
	include "connect.php";
	sleep(5);
	$fp = @fsockopen($ip[$i],$port[$i],$errno,$errstr,5);
	        if ($fp) { 
		//echo 'Порт '.$port[$i].' открыт на вашем сервере!'; 
		fclose($fp); 
			}
			else {	
	if ($status[$i]!='0')    
{	
pg_query($dbconn,"UPDATE servers SET status ='0' WHERE ip='{$ip[$i]}' and port='{$port[$i]}';");
  
   //настройки письма
   
    $status_name='отключено';
    $message = file_get_contents('sample_vesna.html'); 
    $message = str_replace('%name%', $name[$i], $message); 
    $message = str_replace('%ip%', $ip[$i], $message); 
    $message = str_replace('%port%', $port[$i], $message); 
    $message = str_replace('%status_name%', $status_name, $message); 
	
$mail = new PHPMailer;
$mail->CharSet = 'utf-8';
$mail->isSMTP();
$mail->Host     = 'smtp.yandex.ru';
$mail->SMTPAuth = true;
$mail->Username = 'monitoring.vesna@yandex.ru';
$mail->Password = 'Qwerty555%s';
$mail->SMTPSecure = 'ssl';
$mail->Port     = 465;


$mail->setFrom('monitoring.vesna@yandex.ru', 'ООО Весна'); 

$mail->addAddress('koi_2003@mail.ru');
$mail->addAddress('belani2006.10@gmail.com');

$mail->Subject = 'Не отвечает устройство';
$mail->MsgHTML($message);
$mail->isHTML(true);
			  
			if(!$mail->send()){
                         // echo 'Сообщение не отправлено.';
   		          //echo 'Mailer Error: ' . $mail->ErrorInfo;
    pg_query($dbconn,"UPDATE servers SET mail=0 WHERE ip='{$ip[$i]}' and port='{$port[$i]}';");
}  else{
    //echo 'Сообщение успешно отправлено';
    pg_query($dbconn,"UPDATE servers SET mail=1 WHERE ip='{$ip[$i]}' and port='{$port[$i]}';");   
} 
}

}
}

if(!function_exists('fsockopen'))
                { echo 'fsockopen не работает!'; return; }

//По циклу тестируем

			for ($i=0;$i<$kol_servers;$i++){        
//Соединяемся
        $fp = @fsockopen($ip[$i],$port[$i],$errno,$errstr,5);
        //Если удачное соединение
        if ($fp) { 
		//echo 'Порт '.$port[$i].' открыт на вашем сервере!'; 
		fclose($fp); 
						if ($status[$i]!='1') 
						{							
pg_query($dbconn,"UPDATE servers SET status ='1' WHERE ip='{$ip[$i]}' and port='{$port[$i]}';");  
$status_name='включено';

    $message = file_get_contents('sample_vesna.html'); 
    $message = str_replace('%name%', $name[$i], $message); 
    $message = str_replace('%ip%', $ip[$i], $message); 
    $message = str_replace('%port%', $port[$i], $message); 
    $message = str_replace('%status_name%', $status_name, $message); 
	
$mail = new PHPMailer;
$mail->CharSet = 'utf-8';
$mail->isSMTP();
$mail->Host     = 'smtp.yandex.ru';
$mail->SMTPAuth = true;
$mail->Username = 'monitoring.vesna@yandex.ru';
$mail->Password = 'Qwerty555%s';
$mail->SMTPSecure = 'ssl';
$mail->Port     = 465;


$mail->setFrom('monitoring.vesna@yandex.ru', 'ООО Весна'); 

$mail->addAddress('koi_2003@mail.ru');
$mail->addAddress('belani2006.10@gmail.com');

$mail->Subject = 'Устройство доступно';
$mail->MsgHTML($message);
$mail->isHTML(true);						
                        if(!$mail->send()){
                         // echo 'Сообщение не отправлено.';
                          //echo 'Mailer Error: ' . $mail->ErrorInfo;
    pg_query($dbconn,"UPDATE servers SET mail=0 WHERE ip='{$ip[$i]}' and port='{$port[$i]}';");
}  else{
    //echo 'Сообщение успешно отправлено';
    pg_query($dbconn,"UPDATE servers SET mail=1 WHERE ip='{$ip[$i]}' and port='{$port[$i]}';");
}

}
}
//Если неудачное соединение
else{
	          //echo 'Порт '.$port[$i].' не открыт на вашем сервере!';
 if ($status[$i]!='0')
repeat_connect($ip,$port,$status,$name,$mail_bd,$i);
}
			}


?>

