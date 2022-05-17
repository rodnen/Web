<title>Налаштування</title>
<?
if($_REQUEST['id'] != $_SESSION['auth']){header("Location: /Game/user/profile?id=".$_SESSION['auth']);exit;}
include("view/action/formValid.php");

if (isset($_SESSION['data'])) {

    $errors = EditProfile();
    if (!$errors) {
        $errors = complete();
    }
}

if (isset($_POST['changepass'])) {

    $errors = EditProfile();
    if (!$errors) {
        $errors = complete();
    }
}
$complete = [];
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
    if (isset($_SESSION['data']) && $rowscount > 0 && !$errors) {    
        foreach($rows as $row){
            if ($_SESSION['data'][1] == $row['mail'] && $_SESSION['auth'] != $row['id']){
	            $errors['mail'] = "Такий користувач вже існує";
	        }
	       	else{
	       		$where = " WHERE id=".$_SESSION['auth'];

			    $sql = "UPDATE users SET name = '".$_SESSION['data'][0]."', mail = '".$_SESSION['data'][1]."',bio = '".$_SESSION['data'][2]."'".$where;

			    if($this->db->query($sql)){
				    header("Location: /Game/user/profile?id=".$_SESSION['auth']);
	                exit;
	            }
	            else{
	            	echo($sql);
	            }
			}
	    }
	}

	if(isset($_POST['changepass']) && !isset($errors['password'])){
		foreach($rows as $row){
            if($row['id'] == $_SESSION['auth']){
            	if(md5(md5($row['salt'].'tophashthatucanthack'. $_POST['password'])) == $row['password']){
            		if(isset($_POST['newpassword']) && strlen($_POST['newpassword']) >= 8){
			            $salt = '';
			            $password = $_POST['newpassword'];

			            for ($i=0; $i < 15 ; $i++) { 
							$salt.= chr(rand(65,97));
						}

						$hashpass = md5(md5($salt.'tophashthatucanthack'.$password));
						$where = " WHERE id=".$_SESSION['auth'];
						$sql = "UPDATE users SET password = '".$hashpass."', salt = '".$salt."'".$where;

						if (!$this->db->query($sql)) {
							$errors['db'] = "Не вдалося оновити пароль";
							echo($sql);
						}
						else{
							$complete['password'] = "Пароль успішно змінено";
							echo("salt = ");		
							echo(strlen($salt));	
						}
					}	
					else{
						$errors['npassword']="Новий пароль не введено";
					}
				}
				else{
					$errors['password'] = "Пароль не вірний";
					echo("row = ");	
					echo(strlen($row['salt']));
				}
	        }
	    }
	} 
}
?>
<div id="hidelay" class="overlay hidden"></div>
 <div id="dropForm" class="hidden">
 	
		<?php
		if(isset($complete['password']) && !isset($errors['password']) && !isset($errors['npassword']))
			echo '<div id="errors" class="complete flex centered-axis-x super-litle-centered-axis-y">';

			if (isset($complete['password'])) {
				echo ($complete['password']);
			}

		if(isset($errors['npassword']) || isset($errors['password']) || isset($errors['db'])) 
			echo '<div id="errors" class="error flex centered-axis-x super-litle-centered-axis-y">'; 
		else 
			echo("<div id='errors' class='NoError centered-axis-x'>");

				if (isset($errors['db'])) {
				    echo $errors['db'];
				}
				elseif (isset($errors['password'])) {
				    echo $errors['password'];
				}
				elseif (isset($errors['npassword'])) {
				    echo $errors['npassword'];
				}
			?>
	</div>
	<form method='post'class="login background flex centered-axis-x litle-centered-axis-y">
		<div class="back" id="back"><i class='bx bx-arrow-back'></i></div>
		<div class="userLogin flex"><i class='bx bxs-lock' ></i><input type="password" name="password" placeholder="Пароль">
		</div>
		<div class="userLogin flex"><i class='bx bxs-lock' ></i><input type="password" name="newpassword"placeholder="Новий пароль">
		</div>
		<div class="userButtons flex"><input id="complete" type="submit" name="changepass" value="Змінити пароль"></div>
	</form>
</div></div>

<div class="wrapper">
	<div class="profileContent flex justify-center">
		<div class="leftMenu background background-shadow flex justify-center ">
			<div class="list">
					<nav class="profileList">
						<div id="tabs">
							<?
							echo('<a href="'.$_SESSION['last_link'].'" class="notactiveFolder">Назад</a>');
							?>
							<div class="changePas">
							  <button id="dropbtn" class="dropbtn" style="text-align: left;">Змінити пароль</button>
							</div>
						</div>
					</nav>
				</div>
			</div>
				<div class="list"></div>

		<div class="foldersContent">
			<div class="Fcontent show">
				<div class="publics flex">
		<?
		if($_REQUEST['id'] == $_SESSION['auth'] && stristr($_SERVER['REQUEST_URI'], "user/")){
			if (!empty($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
			    $filter = "users.id=".$_REQUEST['id'];
			}

			$where = ' WHERE ';

			if ($filter) {
			    $where .= $filter;
			}

			if(stristr($_SERVER['REQUEST_URI'], '&')){
				$pos = strpos($_SERVER['REQUEST_URI'], '&');
				$CurentLink = substr($_SERVER['REQUEST_URI'], 0, $pos);
			}
			else{
				$CurentLink = $_SERVER['REQUEST_URI'];
			}


			$sql = "SELECT * FROM users".$where;
			$row = $this->db->queryRow($sql);



			?>
			<form method='post' style="width:100%;height:inherit;" action='<?=$this->GetUrl("/action/updatePictr")?>?id=<?echo($_REQUEST['id']);?>' enctype='multipart/form-data'>
				<div class="title title-padding flex"><span>Редагування профілю</span></div>
			<div class='editProfile flex'><div class='flex ChangeIcon'><div class='Icon'>
			<?
			echo('<label class="feedback__label flex"><input type="file" class="feedback__file" name="uIcon" id="Icon"><i class="bx bxs-image-add" ></i></label>');
			echo("</div>
						
				<label class='userIcon Icon' style='background-image: url(../images/userIcons/".$row['icon'].");background-size:cover;background-position:center;'></label>
				</div>");
			echo("<div class='flex ChangeIcon'><div class='Icon'>
				<label class='feedback__label flex'><i class='bx bxs-image-add' ><input type='file' class='feedback__file' name='uHeader' id='Header'></i></label></div>
				<label class='userHeader HeaderPictr' style='background-image: url(../images/userIcons/".$row['headerpictr'].");background-size:cover;background-position:center;'></label>	
				</div>");


			for ($i=0; $i < 3; $i++) {
				$data = '';
				$type = ''; 
				switch($i){
					case 0:	if(isset($_SESSION['data'][$i])){$data = $_SESSION['data'][$i];} else{$data = $row['name'];} $data.='"></div>'; $type = '<div class="Input"><input type="" name="name" placeholder="Введіть нове ім\'я" value="'; break;
					case 1: if(isset($_SESSION['data'][$i])){$data = $_SESSION['data'][$i];}else{$data = $row['mail'];} $data.='"></div>'; $type = '<div class="Input"><input type="" name="mail" placeholder="Введіть нову пошту"value="'; break;
					case 2: if(isset($_SESSION['data'][$i])){$data = $_SESSION['data'][$i];}else{$data = $row['bio'];}$data.='</textarea></div>'; $type = '<div class="Input"><textarea type="" name="bio" placeholder="Опишіть себе" >'; break;
				}

				if(isset($errors['name']) && $i == 0) 
					echo '<div class="error-for-else flex">'.htmlspecialchars($errors['name']).'</div>';

				if(isset($errors['mail']) && $i == 1) 
					echo '<div class="error-for-else flex">'.htmlspecialchars($errors['mail']).'</div>';

				if(isset($errors['bio']) && $i == 2) 
					echo '<div class="error-for-else flex">'.htmlspecialchars($errors['bio']).'</div>';

				echo($type.$data);
			}
		}
		?>
		</div><div class="SubmitAdding flex"><input type="submit" value="Зберегти" name="edit"></div></div>
		</form>
		</div>
	</div>
</div>
