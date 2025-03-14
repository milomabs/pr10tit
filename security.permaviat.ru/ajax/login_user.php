<?php
	
	session_start();
	include("../settings/connect_datebase.php");
	include("../recaptcha/autoload.php");
	$secret = '6LcoOusqAAAAANOmgE3hXFajl-BuNT8jFv2VeEsN';
	
	$login = $_POST['login'];
	$password = $_POST['password'];
	
	// ищем пользователя
	$query_user = $mysqli->query("SELECT * FROM `users` WHERE `login`='".$login."' AND `password`= '".$password."';");
	if(isset($_POST['g-recaptcha-response'])){
		$recaptcha = new \ReCaptcha\ReCaptcha($secret);
		$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

		if ($resp->isSuccess()){
			echo "Ура ты авторизован ฅ^>⩊<^ฅ";

		}
		else echo "Не распознали пользователя (¬`‸´¬)";
	}else echo "Нет ответа от капчи (¬`‸´¬)";
	
	$id = -1;
	while($user_read = $query_user->fetch_row()) {
		$id = $user_read[0];
	}
	
	if($id != -1) {
		$_SESSION['user'] = $id;
	}
	echo md5(md5($id));
?>