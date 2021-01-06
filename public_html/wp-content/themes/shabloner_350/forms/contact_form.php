<?php

error_reporting(0);

$emails = file('../emails.txt');

// несколько получателей
$to = str_replace(array("\n", "\r", "\t", " "), "", implode(',', $emails)); // обратите внимание на запятую

// тема письма
$subject = 'Новая заявка с сайта '.$_SERVER['HTTP_HOST'].' ('.date('H:i d.m.Y').')';

// текст письма
$message = '';

foreach($_POST['data'] as $key => $val)
{
	$message .= '<p>'.str_replace(array('name', 'phone', 'email'), array('Имя', 'Телефон', 'E-mail'), $key).': <strong>'.$val.'</strong></p>'."\n";
}
foreach($_POST['d'] as $key => $val)
{
	$message .= '<p>'.str_replace("\r", '<br>', $val).'</p>'."\n";
}
$message .= '<p>--<br><em>Письмо автоматически сформировано сайтом <strong>'.$_SERVER['HTTP_HOST'].'</strong> отвечать на него не нужно</em></p>';

// Для отправки HTML-письма должен быть установлен заголовок Content-type
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

// Дополнительные заголовки
//$headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
$headers .= 'From: '.$_SERVER['HTTP_HOST'].' <noreply@'.$_SERVER['HTTP_HOST'].'>';

// Отправляем
mail($to, $subject, $message, $headers);

/*$f = fopen('text.txt', 'w');
fwrite($f, $to."\n\n".$subject."\n\n".$message);
fclose($f);*/

echo 'OK';

?>