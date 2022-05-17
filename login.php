<title>Авторизація</title>
<?
include("view/action/formValid.php");
$errors = [];

if (isset($_POST['auth'])) {

    $errors = MailValid($_POST['mail']);
    if (!$errors) {
        $errors = complete();
    }

} 

$rowscount = 0;
$c = $this->db->queryOne("SELECT COUNT(*) as 'count' FROM `users`");
if($c){
    $rowscount = $c['count'];
}

$sql = "SELECT * FROM users";
$rows = $this->db->queryRows($sql);
if ($rows === false) {
	$errors['db'] = "Помилка в SELECT";
} 
else{
    if (isset($_POST['auth']) && $rowscount > 0) { 
    $iter = 0;   
        foreach($rows as $row){
            if ($_POST['mail'] == $row['mail']){
	            if(md5(md5($row['salt'].'tophashthatucanthack'. $_POST['password'])) == $row['password']){
	                $_SESSION['auth'] = $row['id'];
	                $_SESSION['admin'] = $row['status'];
	                $_SESSION['icon'] = $row['icon'];

	                $ChangeIp = "UPDATE users SET ip = '".$this->GetIp()."' WHERE id = ".$_SESSION['auth'];
	                $this->db->query($ChangeIp);
	                Header('Location: ' . $this->GetUrl('/home'));
	                exit;
	            }
	            else{
	            	echo(md5(md5($row['salt'].'tophashthatucanthack'. $_POST['password'])));
	            	$errors['password'] = "Пароль не вірний";
	            }
	        }
	        else if($_POST['mail'] != $row['mail'] && $iter == $rowscount){
	            $errors['mail'] = "Такого користувача немає";
	    	}
	    	$iter++;

	    } 
    }
    if($rowscount == 0){
    	$errors['mail'] = "Список користувачів пустий";
    }
}
?>
<div class="wrapper">
	<div class="mainContent">
		<div id="errors" 
		<?php 
		if(isset($errors['mail']) || isset($errors['password']) || isset($errors['db'])) 
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
		<form class="login background background-shadow flex" method="post">
			<div class="userLogin flex"><i class='bx bxs-user' ></i><input type="login" name="mail" placeholder="Логін"<?
			if (isset($_POST['mail'])) {
					echo("value = '".$_POST["mail"]."'");
				}
			?>>
			</div>
			<div class="userLogin flex"><i class='bx bxs-lock' ></i><input type="password" name="password"placeholder="Пароль"<?
			if (isset($_POST['password'])) {
					echo("value = '".$_POST["password"]."'");
				}?>>
			</div>
			<div class="userButtons flex"><input id="complete" type="submit" name="auth" value="УВійти"></div>
		</form>
		<div class="else flex">немає аккаунта, <a href="<?=$this->GetUrl("/register")?>"><b> створити аккаунт</b></a></div>
	</div>
</div>