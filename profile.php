<?
if(empty($_REQUEST['id'])){
	$_REQUEST['id'] = $_SESSION['auth'];
}
if (!empty($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
	$sql = "SELECT * FROM users WHERE id =".$_REQUEST['id'];
	$row = $this->db->queryOne($sql);

	if ($row === NULL) {
		if(isset($_SESSION['auth'])){
		    header("Location: /Game/user/profile?id=".$_SESSION['auth']);
			exit;
		}
		else{
			header("Location: /Game");
			exit;
		}
	}
	else{
		$filter = "id =".$_REQUEST['id']; 
	}
}
else{
	header("Location: /Game");
	exit;
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
$rows = $this->db->queryRows($sql);

if ($rows === false) {
   echo $sql." Помилка SELECT";
}
else{
	foreach($rows as $row) {
		?>
		<title>Сторінка <?echo($row['name']);?></title>
		<div class="wrapper">
			<?
			echo('<div class="headerPictr flex"><img src="../images/userIcons/'.$row["headerpictr"].'"></div>');
			?>
				<div class="profileContent">
					<div class="leftMenu background background-shadow">
					<div class="profileInfo">
		<?
		echo("<div class='profile'><div class='profileIcon'><img src='../images/userIcons/".$row['icon']."'></div>");
		echo("<div class='username'>".$row['name']."</div></div>");
		echo("<div class='bio'>".$row['bio']."</div>");
	}
}
?><!--<div class="toDo"><a href="">Додати в друзі</a><a href="">Заблокувати</a><a href="">Забанити</a></div>-->
				</div>
				<div class="list">
					<nav class="profileList">
						<div id="tabs">
							<?
							if(isset($_SESSION['data']))
								unset($_SESSION['data']);
							if($_SESSION['auth'] == $_REQUEST['id']){
								for($i=1;$i<7;$i++){
									if(isset($_REQUEST['folder'])){
										if($i == $_REQUEST['folder']){
											echo("<span class='activeFolder folder flex'>");
										}
										else{
											echo("<span class='notactiveFolder folder flex'>");
										}
									}
									else{
										if($i == 1){
											echo("<span class='activeFolder folder flex'>");
										}
										else{
											echo("<span class='notactiveFolder folder flex'>");
										}
									}
									
									
									switch($i){
										case 1:echo ("Всі<span class='countOfPublics'>0</span></span>");break;
										case 2:echo ("Опубліковані<span class='countOfPublics'>0</span></span>");break;
										case 3:echo ("Очікують<span class='countOfPublics'>0</span></span>");break;
										case 4:echo ("Відхилені<span class='countOfPublics'>0</span></span>");break;
										case 5:echo ("Друзі<span class='countOfPublics'>0</span></span>");break;
										case 6:echo ("Улюблені<span class='countOfPublics'>0</span></span>");break;
										
									}
								}
								$a = $this->GetUrl("/user/edit?id=".$_SESSION['auth']);
								echo ("<a class='notactiveFolder' href='".$a."'>Налаштування</a>");
								$a = $this->GetUrl("/action/logout");
								echo ("<a class='Bad' href='".$a."'>Вийти</a>");
							}
							else{
								?>
								<span class='activeFolder folder flex'>Публікації<span class='countOfPublics'>0</span></span>
								<span class='notactiveFolder folder flex'>Друзі<span class='countOfPublics'>0</span></span>
								<?if(isset($_SESSION['auth'])){
									echo('<a class="Good" href="">Додати в друзі</a>
									<!--<a class="Bad" href="">Видалити з друзів</a>-->
									<a class="Bad" href="">Заблокувати</a>
									<!--<a class="Good" href="">Розблокувати</a>-->');
									if($_SESSION['admin'] == 2){
										echo('<a class="Bad" href="">Забанити</a><!--<a class="Bad" href="">Розбанити</a>-->');
									}
								}
							
							}
							?>
						</div>
					</nav>
				</div>
			</div>
			<?if($_SESSION['auth'] == $_REQUEST['id']){
				for($i=0;$i<6;$i++){
					if($i == ($_REQUEST['folder']-1) || (!isset($_REQUEST['folder']) && $i==0))
						echo('<div class="foldersContent show"><div class="publics flex"><div class="wrapper-center flex"></div></div></div>');

					else
						echo('<div class="foldersContent hidden"><div class="publics flex"><div class="wrapper-center flex"></div></div></div>');
				}
			}
			else{
			for($i=0;$i<1;$i++){
					if($i == ($_REQUEST['folder']-1) || (!isset($_REQUEST['folder']) && $i==0))
						echo('<div class="foldersContent show"><div class="publics flex"><div class="wrapper-center flex"></div></div></div>');
					else
						echo('<div class="foldersContent hidden"><div class="publics flex"><div class="wrapper-center flex"></div></div></div>');
				}
			}?>
			

	</div>
</div>