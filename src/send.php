<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer library files
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

include "connect.php";

	$incident = pg_query($dbconn, "select t1.name_mest,t1.number_scv,t1.status,t2.user_login,t2.email,t1.mail from scvazh t1 inner join users t2 on t1.employee=t2.user_id where t1.status='Остановлена' 
or t1.status='Авария' order by number_scv");
			
			$kol_incident=pg_num_rows($incident);
			
if ($kol_incident>0)
{	
$mest = pg_fetch_all_columns($incident, 0);
$num_scv = pg_fetch_all_columns($incident, 1);
$status = pg_fetch_all_columns($incident, 2);
$user = pg_fetch_all_columns($incident, 3);
$m = pg_fetch_all_columns($incident, 5);


//проверяем все записи
			for ($i=0;$i<$kol_incident;$i++)
			{
				// если в строке mail не равно 1 (не отправлено) - отправляем сообщение и заносим в таблицу юзера инцидент
      if ($m[$i]!=1)
		  {		
echo "kek";
	  // дата и время инцидента
	   date_default_timezone_set('Russia/Moscow');
       $date = date("Y-m-d H:i:s");
	  //создать схему инцидентов если не существует
	    pg_query($dbconn,"Create schema if not exists incidents;"); 
		//создать таблицу юзера в схеме индицентов если не существует
		pg_query($dbconn,"CREATE TABLE if not exists incidents.".$user[$i]."
        (
         name_mest character varying(30) NOT NULL,
         number_scv bigint NOT NULL,
         status character varying(30) NOT NULL,
         date timestamp(10) without time zone NOT NULL,
         CONSTRAINT name FOREIGN KEY (name_mest)
         REFERENCES public.neft (name) MATCH SIMPLE
         ON UPDATE NO ACTION
         ON DELETE NO ACTION
         )
         WITH (
         OIDS = FALSE
         );"); 
		 //занести в таблицу
		 pg_query($dbconn,"insert into incidents.".$user[$i]." values('{$mest[$i]}','{$num_scv[$i]}','{$status[$i]}','{$date}');");    
		 
    //настройки письма
    $message = file_get_contents('sample.html'); 
    $message = str_replace('%num_scv%', $num_scv[$i], $message); 
    $message = str_replace('%mest%', $mest[$i], $message); 
	$message = str_replace('%status%', $status[$i], $message); 
	
$mail = new PHPMailer;
$mail->CharSet = 'utf-8';
$mail->SMTPKeepAlive = true;   
$mail->Mailer = "smtp"; // don't change the quotes!
$mail->isSMTP();
$mail->Host     = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'test.maps.neft@gmail.com';
$mail->Password = 'Qwerty555%s';
$mail->SMTPSecure = 'tls';
$mail->Port     = 587;

$mail->setFrom('test.maps.neft@gmail.com', 'MAPS-NEFT.RU');
$mail->addAddress('belani2006.10@gmail.com');

$mail->Subject = 'Инцидент по скважине';
$mail->MsgHTML($message);
$mail->isHTML(true);
//$mail->SMTPDebug = 2;
$mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

if(!$mail->send()){
    echo 'Сообщение не отправлено.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}else{
    echo 'Сообщение успешно отправлено';
    pg_query($dbconn,"UPDATE scvazh SET mail = '1' WHERE number_scv='{$num_scv[$i]}';");
}

}
}
}

?>

