<form  Method="POST" class="form-horizontal" enctype="multipart/form-data">
<fieldset>

<!-- Form Name -->
<legend>Форма регистрации пользователя</legend>

<?php 
	if (isset($user['id'])){
		$filename='photo/'.$user['id'].'.jpeg';
		if(file_exists($filename)){
			?>
			<img class="user-photo" src="<?= htmlspecialchars($filename)?>">
		<?
		}	  
	}
  ?>

<!-- Text input-->
<div class="form-group<?php if (isset($errors['name'])){
	echo ' has-error';
}?>">
  <label class="col-md-4 control-label" for="name">Имя пользователя</label>  
  <div class="col-md-4">
  <input id="name" 
  name="name" 
  placeholder="" 
  class="form-control input-md" 
  type="text"
  value="<?php if (isset($user['name'])){
	  echo htmlspecialchars($user['name']);
  }?>">
  <?php if (isset($errors['name'])){
	  foreach ($errors['name'] as $error){
		  echo '<div class="help-block">' . htmlspecialchars($error) . '</div>';
	  }
  }
  ?>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group<?php if (isset($errors['email'])){
	echo ' has-error';
}?>">
  <label class="col-md-4 control-label" for="email">E-mail</label>  
  <div class="col-md-4">
  <input id="email" 
  name="email"  
  placeholder=""
  class="form-control input-md" 
  type="text"
  value="<?php if (isset($user['email'])){
	  echo htmlspecialchars($user['email']);
  }?>">
  <?php if (isset($errors['email'])){
	  foreach ($errors['email'] as $error){
		  echo '<div class="help-block">' . htmlspecialchars($error) . '</div>';
	  }
  }
  ?>
    
  </div>
</div>

<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="photo">Фотография</label>
  <div class="col-md-4">
    <input id="photo" name="photo" class="input-file" type="file" accept="image/png">
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Сохранить</button>
  </div>
</div>

</fieldset>
</form>
