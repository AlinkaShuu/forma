<html>
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
	require 'vendor/autoload.php'; // подключение композера
		
	$dbparams= require('db.php'); // вызов файла с данными к БД
		$db= new PDO(
			$dbparams['connection'],
			$dbparams['username'],
			$dbparams['password']
		); // установка подключение к БД
	
	
	
	if (count($_POST)>0){ // проверка ввода данных
		
		
		Valitron\Validator::addRule (   //создаем правило проверки (вывод статического метода для класса)
			'unique',  //обозначаем правило
			function($field, $value, array $params) use ($db) { //проверка для конкретного параметра (email);  use ($db)-замыкание области
				$sql= "
				SELECT Count(*) count  
				FROM users
				WHERE email= :email  
			"; // извлекли количество записей и обозначали поле, которое будем проверять
			$query= $db->prepare($sql);  //создали объект запроса (заготовка для запроса)
			$result = $query->execute(['email' => $value]);   // заполняет плейсходер значением (:email) value от пользователя (но не изменяет БД)
			$record = $query->fetch();		//извлекает одну  запись из результата запроса	и возвращает в виде массива
			return $record['count']==0;			//проверяем количество результирующих записей с folse (0)
			}, // проверили, есть ли 
			'Пользователь с таким e-mail уже зарегистрирован!'
		);
		
		$validator=new Valitron\Validator($_POST); //создали объект валидатора и проверяем данные пользователя, переданые методом POST
		/* $validator->rule (
			'unique',   //проверка на уникальность (подкрепляем наше правило, заданное выше)
			'email'
		); */
		
		$validator->rule(
			'required',     // поле непустое
			['name','email']   // какие поля проверяем
		)->message('Поле обязательно для заполнения!');
		
		$validator->rule(  // проверка на соответствие email
			'email',  	 // название валидатора
			'email'  	 //название полоя в форме
		)->message('Неверный формат e-mail!');  
		
		if ($validator->validate()){	//если проверки выполнены								
			if (isset ($_GET['id'])){
				$sql="
					UPDATE `users`
					SET 
						`name` = :name,
						`email` = :email
					WHERE `id` = :id	
				";
			} else {				
				$sql= "
					INSERT INTO `users` 
					(`name`, `email`) 
					VALUES 
					(:name, :email)
				"; // запрос на заполнение полей БД 
			}
			$query= $db->prepare($sql);
			$params = [
				'name' => $_POST['name'],
				'email' => $_POST['email']
			];
			if (isset($_GET['id'])){
				$params['id'] = $_GET['id'];
			}
			$result = $query->execute($params);
			// проверка выполненимя результата запроса
			
			if ($result) {
				$id=$db->lastInsertId();
				if(isset($_FILES['photo'])){
					if ($_FILES['photo']['error']==0){
						$tmpName=$_FILES['photo']['tmp_name'];
						if ($_FILES['photo']['type']=='image/jpeg'){
							move_uploaded_file($tmpName, "photo/$id.jpg");
					} else {
						echo 'Неизвестный формат файла!';
					}
				}
			}
				echo '<div class="alert alert-success" role="alert">Готово!</div>';
			} else {
				var_dump($query->errorInfo()); //вывод информации об ошибке
			}
			
			
			//выполнение действия формы
			
		}else {
			$errors=$validator->errors();  //запрашиваем список ошибок
			$user=$_POST;
			require 'form.php';    //вызываем файл и смотрим ошибки (они там прописаны)
		}
	 } else {
		 if (isset ($_GET['id'])){
			 //Загрузка из БД
			 $sql= 'SELECT * FROM Users
					WHERE id = :id';				
			$query= $db->prepare($sql);
			$query->execute(['id'=> $_GET['id']]);
			$user = $query->fetch();
			if ($user) {
				require 'form.php';
			} else {
				require 'notfound.php';			
			} 
		}else {
			 require 'form.php';
			 //отображение пустой формы
			}				 
		}	
	?>	
	</body>