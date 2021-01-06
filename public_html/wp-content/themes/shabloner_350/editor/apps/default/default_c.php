<?php

// Проверка авторизации
//if(!isAuth()) redirect(WP_ADMIN_URL);

// Установлена ли тема
if(isInstalled()) redirect(HTTP_PATH.'/index.php?app=themes&act=show'); // Отправляем в редактор
else redirect(HTTP_PATH.'/index.php?app=install'); // Отправляем на установку

