<?php

function logout()
{
	global $db;
	if($_SESSION['user_id']) $db->where("user_id", $_SESSION['user_id'])->where("hash", $_COOKIE['session'])->delete("sessions");
	session_destroy();
	setcookie("session", "", -1, '/');
	setcookie("user_id", "", -1, '/');
}

