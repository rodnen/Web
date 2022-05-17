<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
								<!--CSS-->
	<link rel="stylesheet" type="text/css" href="/Game/css/themes.css">
	<link rel="stylesheet" type="text/css" href="/Game/css/pc.css">
	<link rel="stylesheet" type="text/css" href="/Game/css/tablet.css">
	<link rel="stylesheet" type="text/css" href="/Game/css/phone.css">
	<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
	<link rel="shortcut icon" href="/Game/images/siteLogo.png" type="image/x-icon">
	<script type="text/javascript" src="/Game/js/DropingMenu.js"></script>
	<script type="text/javascript" src="/Game/js/ThemeSwitcher.js"></script>
	<script type="text/javascript" src="/Game/js/ajax.js"></script>
	<script type="text/javascript" src="/Game/js/Folders.js"></script>
</head>
<?if(isset($_SESSION['auth'])){
	echo('<script type="text/javascript">var mysession='.$_SESSION['auth'].'</script>');
}
else{
	echo('<script type="text/javascript">var mysession=0</script>');	
}
?>
<body>
	<div id="overlay" class="overlay hidden"></div>
	<div id="up"></div>
<header  class="fixed">
<div class="top flex" >
	<button id="showMenu" class="showUserMenu"><i id="showMenu" class='bx bx-menu'></i></button>
	<a href="<?=$this->GetUrl('/')?>">
	<div class="Logo flex">
		<?
		$imagepath ='///'.$_SERVER['HTTP_HOST'].'/Game/images/siteLogo.png';
		if(!file_exists($imagepath)){
			echo('<img src="'.$imagepath.'">');
		}

		$c = "SELECT COUNT(DISTINCT publics.id) as 'count' FROM publics WHERE remove_status = '0' AND status = 2";
        $count = $this->db->queryOne($c);

        if($count['count'] != 0){
			$sql = "SELECT MIN(cast(id as DECIMAL(9,0))) as min, MAX(cast(id as DECIMAL(9,0))) as max FROM publics";
			$MinMax = $this->db->queryOne($sql);

			$randomID = rand($MinMax['min'],$MinMax['max']);
			$sql = "SELECT * FROM publics WHERE publics.id = ".$randomID;
			$rows = $this->db->queryOne($sql);

			while(!isset($rows)){
				$randomID = rand($MinMax['min'],$MinMax['max']);
				$sql = "SELECT * FROM publics WHERE publics.id = ".$randomID;
				$rows = $this->db->queryOne($sql);							
			}	
		}
		$image = '///'.$_SERVER['HTTP_HOST'].'/Game/images/userIcons/'.$_SESSION['icon'];
		?>
		<div class="gradientLogo">MINE FORGE</div>
	</div>
	</a>
	<div class="flex menuList hideMenu">
		<button id="hideMenu" class="hideUserMenu" class="link"><i id="hideMenu" class='bx bx-x'></i></button>
		<a class="profileLogo"href="<?=$this->GetUrl("/user/profile?id=".$_SESSION['auth']);?>"><img src="<?echo($image);?>"></a>
		<button id="categories" onclick="Categories()" class="link">Категорії<i id="categories" class='bx bx-chevron-down'></i></button>
		<div class="categories background-drop background-shadow flex hidden" id="dropCategories">
			<a class="link" href="<?=$this->GetUrl('/mods')?>">Моди</a>
			<a class="link" href="<?=$this->GetUrl('/data-packs')?>">Дата-паки</a>
			<a class="link" href="<?=$this->GetUrl('/resource-packs')?>">Текстур-паки</a>
			<!--<a class="link" href="<?=$this->GetUrl('/title')?>">Скіни</a>-->
		</div>
		<button class="link" id="search" onclick="Search()"><i id="search" class='bx bx-search'></i>Пошук</button>
		
		<a class="link menulink" href="<?=$this->GetUrl('/news')?>">Новини</a>
		<a class="link menulink" href="<?=$this->GetUrl('/title?id='.$randomID)?>">Випадкове</a>
	</div>
	<div class="flex menuUser" style=" align-items: center;">
		<button id="changeTheme" class="link"><i class='bx bx-moon' ></i></button>
		<button class="link" id="search" onclick="Search()"><i id="search" class='bx bx-search'></i></button>
		<?if(isset($_SESSION['auth'])){
			echo('<button id="addpublic" class="link" onclick="AddPublic()"><i id="addp" class="bx bx-plus"></i></button>');
			?>
		<div class="addpublic background-drop background-shadow flex hidden" id="dropAdd">
			<a class="link" href="<?=$this->GetUrl("/add-news");?>"><i class='bx bxs-news'></i>Додати новину</a>
			<a class="link" href="<?=$this->GetUrl("/add-publics");?>"><i class='bx bx-bookmark-plus'></i>Додати публікацію</a>
			<?if($_SESSION['admin']==2){
				echo('<a class="link" href="'.$this->GetUrl("/waiting").'"><i class="bx bx-time"></i>Очікують публікації</a>');
				echo('<a class="link" href="'.$this->GetUrl("/removed").'"><i class="bx bx-trash"></i>Видалені публікації</a>');
			}?>
		</div>
			<?	
			echo('<button id="profile" onclick="Profile()"><img id="profile" src="'.$image.'"></button>');
		}else{
			$a = $this->GetUrl("/login");
			echo('<a href="'.$a.'">Увійти</a>');
		}?>
		<div class="profile background-drop background-shadow flex hidden" id="dropProfile">
			<a class="link" href="<?=$this->GetUrl("/user/profile?id=".$_SESSION['auth']);?>"><i class="bx bxs-user"></i>Профіль</a>
			<a class="link" href="<?=$this->GetUrl("/user/profile?id=".$_SESSION['auth']."&folder=6");?>"><i class="bx bxs-bookmark"></i>Закладки</a>
			<a class="link" href="<?=$this->GetUrl("/removed?id=".$_SESSION['auth']);?>"><i class="bx bxs-trash"></i>Мої видалені</a>
			<a class="link" href="<?=$this->GetUrl("/user/edit?id=".$_SESSION['auth']);?>"><i class="bx bxs-cog"></i>Налаштування</a>
			<a class="link" href="<?=$this->GetUrl('/action/logout');?>"><i class='bx bx-log-out'></i>Вийти</a>
		</div>
	</div>
</div>
</header>
	<div class="Searching-Menu hidden fixed" id="dropSearch">
		<div class="search flex flex">
			<div id="search" class="input flex"><i id="search" class='bx bx-search'></i><input  type="text" name="search" placeholder="Пошук" id="find"></div>	
		</div>
		<div class="Finded background flex hidden" id="finded">
			<div class="publics flex">
				<div class="wrapper-center flex" id="publics">
				</div>
			</div>
		</div>
	</div>
 <?$months =["січ.","лют.","бер.","кві.","трав.","чер.","лип.","сер.","вер.","жов.","лист.","груд."];?>