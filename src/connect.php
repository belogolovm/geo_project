
			<?php    
			
			 $dbconn = pg_connect("host=pgpool dbname=geobd user=geobd1 password=geobd1");
  if (!$dbconn)
{
 echo "Нет соединения с базой данных\n";
 exit;
}
			?>
