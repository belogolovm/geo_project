<?php
   if(isset($_COOKIE['id'])):
        setcookie('id', '', time()-7000000, '/');
    endif;
	
	   if(isset($_COOKIE['hash'])):
        setcookie('hash', '', time()-7000000, '/');
    endif;
	
header('Location: index.php');
exit;
?>
