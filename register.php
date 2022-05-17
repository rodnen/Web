<title>Реєстрація</title>
<?
include('view/action/formValid.php');

$errors = [];
if (isset($_POST['registrate'])) {

    $errors = RegisterValid();
    if (!$errors) {
        $errors = complete();
    }

}

$sql = "SELECT * FROM users";
$rows = $this->db->queryRows($sql);
$rowscount = 0;
if ($rows === false) {
	$errors['db'] = 'Помилка в SELECT';
} else{
	if (isset($_POST['registrate']) && !$errors) {
		$salt = '';	
		$name = $_POST['name'];
		$mail = $_POST['mail'];
		$password = $_POST['password'];
					
		for ($i=0; $i < 15 ; $i++) { 
			$salt.= chr(rand(65,97));
		}
		$hashpass = md5(md5($salt.'tophashthatucanthack'.$password));
		
		$c = $this->db->queryOne("SELECT COUNT(*) as 'count' FROM `users`");
   		if ($c) {   
        	$rowscount = $c['count'];
    	}
    	
    	$uCreated = false;
		foreach($rows as $row){
		   if ($_POST['mail'] == $row['mail'] && $rowscount > 0){
		        $errors['mail'] = ' Користувач вже існує ';
		        $uCreated = true;
				break;
			}	
		}	    	
		
		if (!$uCreated) {
			//echo($mail);
			
			//echo(email_exists($mail));
			$sql = "INSERT INTO `users` (`name`,`mail`, `password`,`salt`,`ip`) VALUES('".$name."','".$mail."','".$hashpass."','".$salt."','".$this->GetIp()."')";

			$rows = $this->db->queryRows($sql);
				if ($rows === false) {
					$errors['db'] = "Не вдалося створити користувача";
				}

				else{
					$sql = "SELECT * FROM `users` WHERE `users`.`mail` ='".$mail."'";
					$users = $this->db->queryRows($sql);
						
					if ($users === false) {
					    $errors['db'] = $sql.'  Помилка SELECT';
					} 
					else{
						foreach($users as $user){
							if($user['mail'] == $mail){
								$_SESSION['auth'] = $user['id'];
								$_SESSION['admin'] = 1;
								$_SESSION['icon'] = $user['icon'];
							}
						}
					   	
					   	Header('Location: ' . $this->GetUrl('/home'));
						exit;
					}
				}
		
		}
	}
	else{
		$errors['user'] = 'Заповніть поля';
	}
}		
?>
<div class="wrapper">
	<div class="mainContent">
		<div id="errors" 
		<?php 
		if(isset($errors['name']) || isset($errors['mail']) || isset($errors['password']) || isset($errors['db'])) 
			echo 'class="error-for-login error-shadow flex"'; 
		else 
			echo("class='NoError'")?>>

			<?php
				if (isset($errors['db'])) {
				    echo $errors['db'];
				}
				elseif (isset($errors['user']) && count($errors)>3) {
				    echo $errors['user'];
				}
				elseif (isset($errors['name'])) {
				    echo $errors['name'];
				}
				elseif (isset($errors['mail'])) {
				    echo $errors['mail'];
				}
				elseif (isset($errors['password'])) {
					echo $errors['password'];
				}
				elseif (isset($errors['repeatpassword'])) {
				    echo $errors['repeatpassword'];
				}
			?>
	</div>
		<form class="login background background-shadow flex " method="post">
	
			<div class="userLogin flex"><i class='bx bxs-user' ></i><input  name="name" placeholder="Ім'я користувача"<?
			if (isset($_POST['name'])) {
					echo("value = '".$_POST["name"]."'");
				}
			?>>
			</div>
			<div class="userLogin flex"><i class='bx bx-envelope'></i><input name="mail" placeholder="Пошта"<?
			if (isset($_POST['mail'])) {
					echo("value = '".$_POST["mail"]."'");
				}?>>
			</div>
			<div class="userLogin flex"><i class='bx bxs-lock' ></i><input type="password" name="password"placeholder="Пароль"<?
			if (isset($_POST['password'])) {
					echo("value = '".$_POST["password"]."'");
				}?>>
			</div>
			<div class="userLogin flex"><i class='bx bxs-lock' ></i><input type="password" name="rpassword"placeholder="Повтор паролю" 
			<?if (isset($_POST['rpassword'])) {
				echo("value = '".$_POST["rpassword"]."'");
			}?>>
			</div>
			<div class="userButtons flex"><input id="complete" type="submit" name="registrate" value="зареєструватися"></div>
</form>
<div class="else flex">вже маєте аккаунт, <a href="<?=$this->GetUrl("/login")?>"><b> увійти</b></a></div>
</div>
</div>