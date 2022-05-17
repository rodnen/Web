<div class="wrapper">
    <div class="mainContent">
        <div class="content flex" style="justify-content:center;">
           <div class="publicPicture">
                <div class="NewPublics background background-shadow" >
                	<?
						if(isset($_REQUEST['id']) && !is_numeric($_REQUEST['id'])){
							header("Location: /Game/");
							exit;
						}
						
						$SQL = "SELECT * FROM publics WHERE id =".$_REQUEST['id'];

					    $publics = $this->db->queryOne($SQL);
						
						if(!isset($publics)){
							header("Location: /Game/");
							exit;
						}

						$inFavorite = false;

						$sql = "SELECT * FROM favorite WHERE user_id = ".$_SESSION['auth']." AND public_id = ".$_REQUEST['id']." AND public_type = ".$publics['pub_type'];

						if($this->db->queryRows($sql)){
							$inFavorite = true;
						}

						$sql = "SELECT name FROM versions WHERE id =".$publics['version_id'];
						$version = $this->db->queryRow($sql);

						$day = intval(explode('-',$publics['date'])[2]);
			            $month = intval(explode('-',$publics['date'])[1]);
			            $year = intval(explode('-',$publics['date'])[0]);
			            $a = "/Game/user/profile?id=".$publics['publisher'];

			            $u = "SELECT name FROM users WHERE id=".$publics['publisher'];
				        $name = $this->db->queryRow($u);



				        $isAuthor = false;
				        echo('<title>'.$publics['name'].'</title>');
				        
				        echo('<div class="title flex"><span>'.$publics['name'].'</span>');
						if(isset($_SESSION['auth'])){	
							if($publics['publisher'] == $_SESSION['auth'] || $_SESSION['admin'] == 2){
							echo('<div class="title-buttons"><a style="margin-right:10px;" href="'.$this->GetUrl('/editpublic?id='.$publics['id']).'"><span>Редагувати</span></a><a style="margin-right:10px;" href="'.$this->GetUrl('/action/remove?id='.$publics['id'].'&type='.$publics['pub_type']).'"><span>Видалити</span></a>');
							$isAuthor = true;
							}	

							if($inFavorite){
								echo('<a class="bookmark-for-title-active" title="Натисніть для видалення зі списку улюбленого" href="'.$this->GetUrl('/action/favorite?id='.$publics['id'].'&type='.$publics['pub_type']).'"><i class="bx bxs-bookmark" ></i></a></div>');	
								if($isAuthor){
									echo('</div>');
								}
							}
							else{
								echo('<a class="bookmark-for-title" title="Натисніть для додавання до списку улюбленого" href="'.$this->GetUrl('/action/favorite?id='.$publics['id'].'&type='.$publics['pub_type']).'"><i class="bx bxs-bookmark"></i></a></div>');
								
								if($isAuthor){
										echo('</div>');
									}
								}
						}

						else{
							echo('</div>');
						}

					?>
					
                  	<div class="picture">
                  		<img src="<?=$this->GetUrl('/images/publicpictrs/'.$publics['image']);?>">
                  		<div class="pinfo flex">
                  		 <a href="<?echo($a);?>"><i class="bx bxs-user"></i><?echo($name['name']);?></a><span class="date" ><?echo($day.$months[$month-1].$year.'р.');?></span></div>
                  	</div>
                  	<div class="discription title-padding"><?echo ($publics['discription']);?></div>
                  	
                       
                </div>
                </div>
                	<?
                		switch($publics['type']){
                			case 1:echo('<div class="rightPanel background background-shadow">
                <div class="title flex"><span>Інструкція по встановленню</span></div>
                <div class="instruction title-padding"><ul><li>Завантажте і встановіть <a href="https://files.minecraftforge.net/net/minecraftforge/forge/" target="_blank"><b>Minecraft Forge</b></a></li><li>Завантажте мод</li><li>Не розпаковуючи, скопіюйте або перемістіть в <b>.minecraft\mods</b></li><li>Насолоджуйтесь</li></ul>');break;
                			case 2:echo('<div class="rightPanel background background-shadow">
                <div class="title flex"><span>Інструкція по встановленню</span></div>
                <div class="instruction title-padding"><ul><li>Завантажте дата-пак</li><li>Перейдіть у папку <b>.minecraft\saves</b> та оберіть потрібний світ</li><li>Всередині знайдіть папку <b>datapacks</b> та перемістіть туди архів</li><li>Зайдіть у свій світ та напишіть в чат команду <b>/reload</b></li><li>Насолоджуйтесь</li></ul>');break;
                			case 3:echo('<div class="rightPanel background background-shadow">
                <div class="title flex"><span>Інструкція по встановленню</span></div>
                <div class="instruction title-padding"><ul><li>Завантажте ресурс-пак</li><li>Перейдіть у папку <b>.minecraft\resoucepacks</b></li><li>Запустіть гру на потрібній версії</li><li>В налаштуваннях увімкніть ресурспак</li><li>Насолоджуйтесь</li></ul>');break;
                			
                		}
                	?>
					</div> 
					<div class="title flex"><span>Завантаження</span></div>
					<a href="<?echo('/Game/images/files/'.$publics['file']);?>" class="download flex">
							<span>Завантажити для <?echo($version['name']);?></span>
							<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
  							<path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
  							<path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
							</svg>
						
					</a>      
        </div>
    </div>
    </div>
</div>