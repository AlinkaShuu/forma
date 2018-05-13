﻿<html>
	<head>
	<title>Регистрация пользователя</title>
		<script
			  src="http://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</head>
	<body>
	<?Php
	
	if (count($_POST)){
		//данные формы введены
		$errors=checkForm($_POST);
		if (count($errors)==0){
			echo '<div class="alert alert-success" role="alert">Сохранено</div>';
		}else {
			require 'form.php';
		}
	}else {
		require 'form.php';
	}
	 function checkForm ($data){
		$result=[];
		if (trim($data['username']) == ''){
			$result['username']='Поле обязательно для заполнения!';
		}
		if (trim($data['email']) == ''){
			$result['email']='Поле обязательно для заполнения!';
		}
		return $result;
	 }
	?>	
	</body>