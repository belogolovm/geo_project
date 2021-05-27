			<?php    
			
			 $dbconn = pg_connect("host=127.0.0.1 dbname=geobd user=geobd1 password=geobd1");
  if (!$dbconn)
{
 echo "Нет соединения с базой данных\n";
 exit;
}
			?>
