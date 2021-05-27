<?php
   function isSiteAvailible($url) {

    // Проверка правильности URL
    if(!filter_var($url, FILTER_VALIDATE_URL)){
      return false;
    }

    // Инициализация cURL
    $curlInit = curl_init($url);

    // Установка параметров запроса
    curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
    curl_setopt($curlInit,CURLOPT_HEADER,true);
    curl_setopt($curlInit,CURLOPT_NOBODY,true);
    curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

    // Получение ответа
    $response = curl_exec($curlInit);

    // закрываем CURL
    curl_close($curlInit);

    return $response ? true : false;
  }

  $URL = 'http://185.97.165.119:6893';

  if(isSiteAvailible($URL)){
    echo 'Сайт доступен.';
  }else{
    echo 'Сайт недоступен.';
  }

?> 
