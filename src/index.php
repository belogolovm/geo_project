
<!DOCTYPE html>
<html>
    <head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<?php
	if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
echo '<link rel="stylesheet" href="style1.css">';	
else
	echo '<link rel="stylesheet" href="style.css">';
?>

        <title>Нефтяные месторождения</title>
		 
        <script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.2.3/jquery.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

      
<button id="showHideContent">Фильтр</button>
  
  
  <!-- Проверка пользователя и всплывающее окно-->
  
<?php
include "connect.php";

/////////////////////////// проверка пользователя

$ip =$_SERVER['REMOTE_ADDR'];

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
    else
    {
		//если все нормально - печатаем div 
		
	
echo '<div class="modal-overlay">';
echo '<div class="modal">';
   echo '<a class="close-modal">';
   echo '<svg viewBox="0 0 20 20">';
   echo '<path fill="#000000" d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z"></path>';
   echo '</svg>';
   echo '</a>'; // close modal 
       echo '<img src="images/mnemo.jpg" width="600" height="300" alt="" class="leftimg">';
	   echo '<div class="overlay_datch">';
       echo '<div class="datch">Расх:<br>Темп-ра:<br>Эл-пр:<br>Нефть:</div>';
	   
	   echo '<div class="overlay_datch2">';
       echo '<div class="datch2">W:<br>Таль-блок:</div>';
	   echo '</div>';
	   
	   echo '<div class="overlay_datch3">';
       echo '<div class="datch3">Нагрузка:</div>';
	   echo '</div>';
	   
	   	   echo '<div class="overlay_datch4">';
       echo '<div class="datch4">Давл.:<br>Числ.ход:</div>';
	   echo '</div>';
	   echo '</div>';
	
   echo '</div>'; 
   echo '</div>';
   echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js'></script>"; 
   
   // личный кабинет
   
   echo '<div class="modal-overlaykk">';
echo '<div class="modalkk">';
   echo '<a class="close-modal">';
  echo '<svg viewBox="0 0 20 20">';
  echo '<path fill="#000000" d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z"></path>';
  echo '</svg>';
   echo '</a>'; // close modal 
   echo '<div class="modal-contentkk">';
       echo '<center><b><font size="5" color=#008080 >Добро пожаловать в личный кабинет!</font></b><center>';
       echo '<hr><img src="images/noavatar.png" width="100" height="100" alt="" class="leftimg">';
        print "Рады приветствовать Вас, <b>".$userdata['name']."</b>!"; 
		echo '<center>';  echo '<br>Ваш логин: '; echo "<b>"; echo $userdata['user_login']; echo "</b>";
		echo '<br>Ваша компания: '; echo "<b>"; echo $userdata['company']; echo "</b>";
		echo '<br>Ваш e-mail: '; echo "<b>"; echo $userdata['email'];  echo '</b></center>'; 
		echo '<br><br><br><center>Если Вы заметили ошибку - пожалуйста, обратитесь к администратору: admin@test.com';
		echo '<hr><a style="color:#0000FF;" href="change_password.php">Сменить пароль</a><center></center>';
   echo '</div>'; // content
   echo '</div>';
   echo '</div>';
   echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js'></script>";
   
	     }
}
else
{
  //  print "alert('Включите куки');";
}


    ?>
	
	<script>
var elements = $('.modal-overlay, .modal');

function info(numb_scv)
{
	
    elements.addClass('active');
	window.setInterval(function(){
	//каждые 4 секунды если включен мониторинг (есть куки) запускать функцию datch_timer(если есть overlay3)	
 var monitoring_cookie = getCookie("monitoring");
 							var myCookie = getCookie("id");
	  if ((monitoring_cookie==null)&&(myCookie!=null))
	  {
	if ($('.overlay3').length > 0) 
datch_timer(numb_scv); 

	  }
}, 1000);
}

$('.close-modal').click(function(){
    elements.removeClass('active');
});

function datch_timer()
{
 //datch1='datch1_'+numb_scv1+'.php';
 $.ajax({
	   type: 'POST',
  url: '/detectors/output/datch1.php',
   data:  "mest="+mest+"&numb_scv="+numb_scv,
  success: function(data) {
    $('.datch').html(data);
  }
});

 $.ajax({
	   type: 'POST',
  url: '/detectors/output/datch2.php',
     data:  "mest="+mest+"&numb_scv="+numb_scv,
  success: function(data) {
    $('.datch2').html(data);
  }
});

 $.ajax({
	   type: 'POST',
  url: '/detectors/output/datch3.php',
     data:  "mest="+mest+"&numb_scv="+numb_scv,
  success: function(data) {
    $('.datch3').html(data);
  }
});

 $.ajax({
	   type: 'POST',
  url: '/detectors/output/datch4.php',
     data:  "mest="+mest+"&numb_scv="+numb_scv,
  success: function(data) {
    $('.datch4').html(data);
  }
});
  return 0;
 }

var elementskk = $('.modal-overlaykk, .modalkk');

function info1()
{
    elementskk.addClass('activekk');
}




$('.close-modal').click(function(){
    elementskk.removeClass('activekk');
});


function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min)) + min;
}

</script>

   <!--    -->


<!-- если залогинен - кнопку фильтра нажать автоматически -->
<?php 
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
	echo "<script type='text/javascript'> window.onload=function(){";
	echo 'document.getElementById("showHideContent").click();};</script>';
}
?>
<!--     -->
 
	  <style type="text/css">
        html, body, #map { width: 100%; height: 98%; padding: 0; margin: 0;   }
    </style>
        <script>
            var map,
			 myIcon,
            MydivIcon, i,arrMark=[],group=[],arrGran=[],group2=[],arrScv=[],group3=[];			
			
            DG.then(function () {
				

                map = DG.map('map', {
                    center: [49.999433, 35.16557990000001],
                    zoom: 3,
					minZoom: 2, 
                    worldCopyJump: true
                });
				
                myIcon = DG.icon({
                    iconUrl: 'marker2.ico',
                    iconSize: [35, 35]
                });	

               i=0;	q=0;qq=0;
			   
			   
<?php   
    if (isset($userdata['company']))
    $user_company=$userdata['company'];
	$state = pg_query($dbconn, "SELECT * from state");
			$state2=pg_num_rows($state);
		if (empty($_POST['id'])) $_POST['id']=0;
        /// если залогинился
		if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) 
		{
		     if ($_POST['id']==0) $result = pg_query($dbconn, "select * from neft t1 inner join neft_prin_company t2 
									     on t1.id=t2.id where t2.company='{$user_company}' order by t1.id"); 
		    if ( (int)$_POST['id']==0) $name = pg_query($dbconn, "SELECT name from neft t1 inner join neft_prin_company t2 on t2.id=t1.id
			                            where t1.koord is not null and t2.company='{$user_company}' order by t1.id");
			 if ( (int)$_POST['id']==0) $qcountry = pg_query($dbconn, "SELECT t1.id,string_agg(country, ', ')  
				 as country FROM neft_prin t1 inner join neft_prin_company t2 on t1.id=t2.id
                 where t2.company='{$user_company}' GROUP BY t1.id order by t1.id");
			if ( (int)$_POST['id']==0) $qcompany = pg_query($dbconn,"SELECT t2.id, string_agg(t2.company, ', ') 
			as company FROM v_neft_prin_comp t2 inner join neft t1 on t2.id=t1.id 
		    where t2.company LIKE '%{$user_company}%' GROUP BY t2.id order by t2.id;");
		}
		// если не залогинился 
										 else 				
										 {
											 if ($_POST['id']==0) $result = pg_query($dbconn, "SELECT * from neft where koord is not null order by id");  
else
for ($j=1;$j<=$state2;$j++) { if ( (int)$_POST['id']==$j)
				$result = pg_query($dbconn, "select t1.name,t1.koord,t1.year,t1.zapas,t1.opisanie, t1.id from neft t1 inner join neft_prin t2 on t1.id=t2.id 
			inner join state s1 on s1.country=t2.country
			where s1.id='{$j}' order by t1.id;"); 
									}
										 
										
									
								if ( (int)$_POST['id']==0) $name = pg_query($dbconn, "SELECT name from neft where koord is not null order by name;");  
									else
for ($j=1;$j<=$state2;$j++) { if ( (int)$_POST['id']==$j)
				$name = pg_query($dbconn, "select t1.name from neft t1 inner join neft_prin t2 on t1.id=t2.id 
			inner join state s1 on s1.country=t2.country
			where s1.id='{$j}' order by t1.id;"); 
									}			
									

if ( (int)$_POST['id']==0) $qcountry = pg_query($dbconn, "SELECT id, string_agg(country, ', ') as country FROM neft_prin GROUP BY id order by id");
else
for ($j=1;$j<=$state2;$j++) { if ( (int)$_POST['id']==$j)
				$qcountry = pg_query($dbconn, "SELECT t2.id, string_agg(t2.country, ', ') as country FROM neft_prin t2 inner join state s1 on s1.country=t2.country 
			where s1.id='{$j}' GROUP BY t2.id order by t2.id;");}
			
			
if ( (int)$_POST['id']==0) $qcompany = pg_query($dbconn," SELECT t2.id, string_agg(t2.company, ', ') as country FROM neft_prin_company t2 
inner join neft t1 on t2.id=t1.id GROUP BY t2.id order by t2.id;");		
else 
for ($j=1;$j<=$state2;$j++) { if ( (int)$_POST['id']==$j)
				$qcompany = pg_query($dbconn, "SELECT t2.id, string_agg(t2.company, ', ') as country FROM neft_prin_company t2 inner join neft t1 on t2.id=t1.id
 where t2.id='{$j}' GROUP BY t2.id order by t2.id;");}	

										 } ////////////// 
									

$arr = pg_fetch_all_columns($result, 1);
$arrname = pg_fetch_all_columns($result, 0);
$arrcountry = pg_fetch_all_columns($qcountry, 1);
$arryear = pg_fetch_all_columns($result, 2);
$arrzapas = pg_fetch_all_columns($result, 3);
$namer = pg_fetch_all_columns($name, 0);
$arrcompany=pg_fetch_all_columns($qcompany, 1);
			//маркеры
			for ($i=0;$i<count($arr);$i++)
			{ 
			echo "addmarker({coordinates:[";
			   echo $arr[$i];
			   echo "],";
			   echo "name:'";
			   echo $arrname[$i];
			   echo "',";
			   echo "country:'";
			   echo $arrcountry[$i];
			   echo "',";
			   echo "year:'";
			   echo $arryear[$i];
			   echo "',";
			   echo "company:'";
			   if (isset($arrcompany[$i]))
			   echo $arrcompany[$i];
			   echo "',";
			   echo "zapas:'";
			   echo $arrzapas[$i];
			   echo "'";
			echo "});";
			}
			
			
			/// границы и скважины
			
			/// если залогинился
		if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) 
		{
			if ($user_company!=null)
			{
	    	$res_scv = pg_query($dbconn, "select t1.name_mest,t1.koord,t1.number_scv,t1.status,t3.name,t3.email,v1.company,t1.radius from scvazh t1 inner join neft t2 on t1.name_mest=t2.name 
			inner join v_neft_prin_comp v1 on v1.id=t2.id inner join users t3 on t1.employee=t3.user_id
            where v1.company LIKE '%{$user_company}%'");
			$name_mest = pg_fetch_all_columns($res_scv, 0);
			$coord_scv = pg_fetch_all_columns($res_scv, 1);
			$numb_scv= pg_fetch_all_columns($res_scv, 2);
			$status= pg_fetch_all_columns($res_scv, 3);
			$name=pg_fetch_all_columns($res_scv, 4);
			$email=pg_fetch_all_columns($res_scv, 5);
			$radius=pg_fetch_all_columns($res_scv, 7);
			
  
	for ($i=0;$i<count($coord_scv);$i++)
			{ 
			echo "addscv({coordinates:["; echo $coord_scv[$i]; echo "],";
			   echo "name_mest:'"; echo $name_mest[$i]; echo "',";
			   echo "numb_scv:'"; echo $numb_scv[$i]; echo "',";
			   echo "status:'"; echo $status[$i]; echo "',";
			   echo "name:'"; echo $name[$i]; echo "',";
			   echo "email:'"; echo $email[$i]; echo "',";
			   echo "radius:"; echo $radius[$i];echo ",";
			   
              if ($status[$i]=='Работает')
			   {
				   $color='#00FF00';
				   $color2='brown';
			   }
			   if ($status[$i]=='Остановлена')
			   {
				   $color='#E6E6FA';
			       $color2='black';
			   }
			   if ($status[$i]=='Авария')
			   {
				   $color='#FFD700';
			       $color2='red';
			   }
			   echo "color:'"; echo $color; echo "',";
			   echo "color2:'"; echo $color2; echo "',";
			   echo "company:"; echo "'{$user_company}'"; 
			   echo "});";     
			}

		}	
		}
		// если не залогинился 
										 else 
										 {
			$gr = pg_query($dbconn, "SELECT * from neft");
			$gr2=pg_num_rows($gr);

			for ($i=1;$i<=$gr2;$i++)
			{
				if ( (int)$_POST['id']==0) $res1 = pg_query($dbconn, "select t1.id,t.gran from neft_granits t inner join neft t1 on t1.name=t.name where t1.id='{$i}' order by t1.id;"); 
				else
				for ($j=1;$j<=$state2;$j++) { if ( (int)$_POST['id']==$j)
				$res1 = pg_query($dbconn, "select t1.id,t.gran from neft_granits t inner join neft t1 on t1.name=t.name inner join neft_prin t2 on t2.id=t1.id 
			inner join state s1 on s1.country=t2.country where s1.id='{$j}' and t1.id='{$i}' order by t1.id;"); 
									}
									
                $arr1 = pg_fetch_all_columns($res1, 1);  
				if ($arr1!=null){
				   echo "addgranits({coordinates1:[";
                   for($j=0;$j<count($arr1);$j++)
			   {
			   echo "[";
			   echo $arr1[$j];
			   if ( ($j+1)!=count($arr1) ) 
			   {
				   echo "],";
			   }
			   else  { echo "]"; }
			   }
				   echo "]});";
			
			
			}
			}
										 } ///////////
			
			
										 for($i=0;$i<count($arrname);$i++)
											 if (!empty($_POST['nazv']))
if( (string)$_POST['nazv']==$arrname[$i])  
{
	           echo "find2({coordinates:[";
			   echo $arr[$i];
			   echo "],";
			   echo "name:'";
			   echo $arrname[$i];
			   echo "',";
			   echo "country:'";
			   echo $arrcountry[$i];
			   echo "',";
			   echo "year:'";
			   echo $arryear[$i];
			   echo "',";
			   echo "company:'";
			   if (isset($arrcompany[$i]))
			   echo $arrcompany[$i];
			   echo "',";
			   echo "zapas:'";
			   echo $arrzapas[$i];
			   echo "'";
			echo "});";
	
}	






?>
	//добавляет маркеры
			function addmarker(properties)
			{
				i++;
           arrMark[i]=DG.marker(properties.coordinates,{icon: myIcon}).addTo(map); 
		       group[i] = DG.featureGroup([arrMark[i]]);
               group[i].addTo(map);
				// при клике центр и зум по маркеру, вывод информации
                group[i].on('click', function(e) {
							var myCookie = getCookie("id");
                            if(myCookie!=null) 
				            map.setView([e.latlng.lat, e.latlng.lng],30);
						else
							map.setView([e.latlng.lat, e.latlng.lng],8);
							if (typeof div !=="undefined" && div!=="0"){ div.parentNode.removeChild(div);}		
					///при клике на маркер, если не залогинен - скрывать фильтр
					<?php
						if (empty($_COOKIE['id']) and empty($_COOKIE['hash']))
						{
                        	echo 'if ($(".overlay2").is(":hidden")) {';
	                        echo 'null  } else {  $(".overlay2").hide("slow"); }';	
						}	?>
							 div = document.createElement('div');
                             div.className = "overlay";
                             div.innerHTML =
							 '<b><font size=4>Название месторождения:</b> '+properties.name+'</font>'+					 
							 '<br><b><font size=4>Страна:</b>  '+properties.country+'</font>'+
							 '<br><b><font size=4>Год открытия: </b> '+properties.year+'</font>'+
							 '<br><b><font size=4>Координаты: </b> '+properties.coordinates+'</font>'+
							 '<br><b><font size=4>Операторы: </b> '+properties.company+'</font>'+
							 '<br><b><font size=4>Запасы: </b>  '+properties.zapas+' млрд. тонн нефти'+'</font>'+
						//	 '<br><center><img src="image/priobsk.jpg" alt="Приобское"></center>'+
						     '<br><br><center><input type="button" value="Скрыть информацию" onclick="removediv()"></center>';
                             document.body.appendChild(div);	
							  });
			}
			
	//DG.marker([59.93, 30.31],{icon: myIcon}).addTo(map).bindPopup('Вы кликнули по мне!');

		   //добавляет границы
						function addgranits(properties)
			{
				q++;
			arrGran[q]=DG.polygon([properties.coordinates1],{color: 'black'}).addTo(map);
			group2[q] = DG.featureGroup([arrGran[q]]);
			group2[q].addTo(map);		
            }
			
			
			
			 //добавляет скважины
						function addscv(properties)
			{
				qq++;
			arrScv[qq]=DG.circle(properties.coordinates,properties.radius, {color: properties.color2}).bindLabel('Скважина №'+properties.numb_scv).addTo(map);
			//DG.circle([properties.coordinates2], 200, {color: 'red'}).addTo(map);
			group3[qq] = DG.featureGroup([arrScv[qq]]);
			group3[qq].addTo(map);
			  group3[qq].on('click', function(e) {
                window.mest = properties.name_mest;
				window.numb_scv = properties.numb_scv;
                 window.t= 1;
				  map.setView([e.latlng.lat, e.latlng.lng],30);
				  							if (typeof div4 !=="undefined" && div4!=="0"){ div4.parentNode.removeChild(div4);}			
							 div4 = document.createElement('div4');
                             div4.className = "overlay3";
                             div4.innerHTML =
							 '<b><font size=4>Название месторождения:</b> '+properties.name_mest+'</font>'+					 
							 '<br><b><font size=4 >Скважина №: </b>  '+properties.numb_scv+'</font>'+
							 '<br><b><font size=4>Статус: </b><font color="'+properties.color+'">'+properties.status+'</font>'+
							 '<br><b><font size=4>Радиус: </b> '+properties.radius+' (м)</font>'+
							 '<br><b><font size=4>Координаты: </b> '+properties.coordinates+'</font>'+
							 '<br><b><font size=4>Ответственное лицо: </b> '+properties.name+'</font>'+
							 '<br><b><font size=4>E-mail: </b>  '+properties.email+''+'</font>'+
							 '<br><b><font size=4>Компания: </b>  '+properties.company+''+'</font>'+
							 '<br><hr><center><a href="javascript:info();" style="color: #00FFFF" id=#idd3>Показать состояние скважины</a></center>'+
						     '<br><center><input type="button" value="Скрыть информацию" onclick="removediv4()"></center>';
                             document.body.appendChild(div4);	
			  });  
			  
			  							
						//	DG.circle([54.98, 82.87], 200, {color: 'red'}).bindPopup('Я круг').bindLabel('Нажми на круг').addTo(map);
			
            }				 
			});

function removediv()
{
	if (typeof div !=="undefined"){ div.parentNode.removeChild(div); div="0";  	}	
}		
function removediv4()
{
	if (typeof div4!=="undefined"){ div4.parentNode.removeChild(div4); div4="0";
	              window['mest'] = null;
				  window['numb_scv'] = null;
				  window['t'] = null;
				  }	
}		

			function hideMarkers() {
				for (var ii = 1; ii <=i; ii++)
                group[ii].removeFrom(map);
            };
		
			
						function hideGran() {
				for (var ii = 1; ii <=q; ii++)
                group2[ii].removeFrom(map);
            };
			
						function hideScv() {
				for (var ii = 1; ii <=qq; ii++)
                group3[ii].removeFrom(map);
			};

function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        end = dc.length;
        }
    }
    // because unescape has been deprecated, replaced with decodeURI
    //return unescape(dc.substring(begin + prefix.length, end));
    return decodeURI(dc.substring(begin + prefix.length, end));
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
} 

function delete_cookie( name ) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

//функция включения и отключеняи мониторинга
function mon_on_off()
{
//если есть куки - удалить, если нет - поставить до 2099 года	  
 var monitoring_cookie = getCookie("monitoring");

	  if (monitoring_cookie==null) 
  {
		setCookie("monitoring", "1",2099, 01, 15 );	
		alert('Мониторинг отключен!');
  }
  else 
  {
			delete_cookie("monitoring");
				  alert('Мониторинг включен!');
  }

	  }	
				</script>  
										


							 
								
		<link rel="SHORTCUT ICON" href="favicon.ico" type="image/x-icon">	
</head>
 <body>
 <div class="results" style="display:none"></div>
 <center><b><font color="black" size="5" face="Gabriola">Карта нефтяных месторождений</font></b></center>
 <?php
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
	
echo '<center>&nbsp&nbsp';
echo '<a href="javascript:info1();">Информация об аккаунте</a>&nbsp&nbsp&nbsp&nbsp';
echo '<a style="color:#0000FF;" href="incident.php">Просмотреть инциденты</a>&nbsp&nbsp&nbsp&nbsp'; 
echo '<a style="color:#0000FF;" href="list.php">Вывести скважины списком</a>&nbsp&nbsp&nbsp&nbsp'; 
if (empty($_COOKIE['monitoring'])) 
{
echo '<a href="javascript:mon_on_off()"'; echo "onClick='this.innerHTML="; echo'="Отключить мониторинг" ? this.innerHTML="Включить мониторинг" : this.innerHTML'; echo '="Отключить мониторинг"'; echo"'>Отключить мониторинг</a>";
}
else
{
echo '<a href="javascript:mon_on_off()"'; echo "onClick='this.innerHTML="; echo'="Включить мониторинг" ? this.innerHTML="Отключить мониторинг" : this.innerHTML'; echo '="Включить мониторинг"'; echo"'>Включить мониторинг</a>";
}
if ($userdata['user_login']=='admin') echo '&nbsp&nbsp&nbsp&nbsp<a style="color:#0000FF;" href="register.php">Зарегистрировать пользователя</a>&nbsp&nbsp&nbsp&nbsp'; 
echo '<a href="logout.php" style="float:right; color:#0000FF;">Выйти</a>&nbsp&nbsp&nbsp&nbsp'; 
echo '&nbsp&nbsp&nbsp&nbsp&nbsp</center>'; 
}
else 
{
echo '<a href="login.php" style="float:right;">Авторизоваться</a>';	
echo '&nbsp';
}


 ?> 
 
 
<div id="map" > </div> 
<script>
							 div2 = document.createElement('div2');
                             div2.className = "overlay2";
                             div2.innerHTML =<?php							
							echo "'";
							echo '<center><form action="index.php" method="post">';
							echo '<center><b><font color="black" size="3" face="Arial">Фильтр</font></b></center><br>';
							if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) 
		                    {
							echo '<select name="id_login" id="idd2">';
							echo '<option disabled>Выберите месторождение</option>';
							echo'<option value="0">Все месторождения</option>';
							 for($i=0;$i<count($namer);$i++)
                            {
                           echo "<option>"; echo $namer[$i]; echo"</option>";
                             }
	                     	}
                            else
							{	
				     		echo '<select name="id" id="idd">';
							echo '<option disabled>Выберите страну</option>';
							echo '<option value="0">Все страны</option>';
                            echo '<option value="6">Алжир</option>';
                            echo '<option value="25">Бразилия</option>';
                            echo '<option value="34">Венесуэла</option>';
                            echo '<option value="61">Ирак</option>';
                            echo '<option value="62">Иран</option>';
                            echo '<option value="69">Казахстан</option>';
                            echo '<option value="73">Катар</option>';
                            echo '<option value="78">Китай</option>';
                            echo '<option value="85">Кувейт</option>';
							echo '<option value="91">Ливия</option>';
                            echo '<option value="106">Мексика</option>';
                            echo '<option value="122">ОАЭ</option>';
                            echo '<option value="134">Россия</option>';
                            echo '<option value="141">Саудовская Аравия</option>';
                            echo '<option value="154">Соединённые Штаты Америки</option>';
							}
						    echo '</select>';
						    echo '<br>';
							if (empty($_COOKIE['id']) and empty($_COOKIE['hash']))
                            echo '<br><input type=text placeholder="Введите название" autocomplete=off  list="neft" name=nazv id="idd2"><br><br>';
                            else
							{   echo '&nbsp';
								echo '<div class="find1"></div>';							
							}
						    echo'</form>'; 
						    echo "'"; ?>   
                             document.body.appendChild(div2);	
							 div3 = document.createElement('div3');
                             div3.className = "find";
                             div3.innerHTML =
							 '<center><form>'+
							 '<center><b><font color="black" size="3" face="Arial">Поиск</font></b></center>'+'<br>'+
'<input type=text placeholder="Введите название" autocomplete=off  list="neft" name=nazv><br><br><input type=submit value="Найти">'+
'</form>';                   document.body.appendChild(div3);	
							 </script>
 
 


<script>
$(document).ready(function(){
$('#idd').change(function(){
$.ajax({
  type: 'POST',
  url: 'show.php?action=sample2',
 data: "id="+$("#idd").val(),
  success: function(data){
	//$('.find').html(data);
	$('.results').html(data);
  }
  });


  }); 

  $('#idd2').change(function(){
$.ajax({
  type: 'POST',
  url: 'show2.php?action=sample2',
 data:  "nazv="+$("#idd2").val()+"&id="+$("#idd").val(),
  success: function(data){
//	$('.find').html(data);
	$('.results').html(data);
  }
  });
});


  
 var myCookie = getCookie("id");
 if(myCookie!=null) 
 {
    $('#idd2').change(function(){
$.ajax({
  type: 'POST',
  url: 'find.php?action=sample2',
 data:  "nazv="+$("#idd2").val(),
  success: function(data){
  $('.find1').html(data);
  }
  });
});




 }

 function monitor()
 {
	 if(typeof t== "undefined") t=null;
	if((typeof numb_scv!== "undefined")&&(numb_scv!==0))
	{
	 $.ajax({
  type: 'POST',
  url: 'monitoring.php?action=sample2',
  data:  "nazv="+mest+"&num_schv="+numb_scv+"&t="+t,
  success: function(data){
	$('.results').html(data);
  }
  }); 
  }
  else  
  	 $.ajax({
  type: 'POST',
  url: 'monitoring.php?action=sample2',
 data:  "nazv="+$("#idd2").val(),
  success: function(data){
	$('.results').html(data);
  }
  }); 
 }
 
 
window.setInterval(function(){
	//каждые 4 секунды если включен мониторинг (есть куки) запускать функцию monitor 
 var monitoring_cookie = getCookie("monitoring");
 							var myCookie = getCookie("id");
	  if ((monitoring_cookie==null)&&(myCookie!=null))
	  {
monitor();
	  }
}, 4000);

 
}); 




</script>
<script>
$(document).ready(function(){
$('#idd').change(function(){
$.ajax({
  type: 'POST',
  url: 'find.php?action=sample2',
 data: "id="+$("#idd").val(),
  success: function(data){
	$('.find').html(data);
	//$('.results').html(data);
  }
  });
});

});
</script>

		<script>
$(document).ready(function(){
  $("#showHideContent").click(function () {
	  
	  <!-- Если не залогинен, при нажатии на кнопку убирать инфу с месторождением -->
	  <?php 
if (empty($_COOKIE['id']) and empty($_COOKIE['hash']))
echo 'if (typeof div !=="undefined" && div!=="0"){ removediv(); }';
?>	
	  <!--    -->
	  
	  
	if ($(".overlay2").is(":hidden")) {
            $(".overlay2").show("slow");		
        }  else {
            $(".overlay2").hide("slow");
        }
		
    });
		
});
</script> 
</body> 
<!-- <center><b><font color="black" size="3" face="Gabriola">Разработчик: Белоголов Михаил. 2018 год.</font></b></center> -->
</html>
        
