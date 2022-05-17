<?if(!isset($_SESSION['auth'])){header("Location: /Game");exit;}?>
<div class="wrapper">
	<div class="mainContent">
		<div class="profileContent">
		<div class="leftMenu background background-shadow">
			<div class="list">
				<nav class="profileList">
				<div id="tabs">
							<?
							$SQL = "SELECT * FROM publics WHERE id =".$_REQUEST['id'];

						    $publics = $this->db->queryOne($SQL);
				
							if(isset($_REQUEST['id']) && !is_numeric($_REQUEST['id'])){
								header("Location: /Game/");
								exit;
							}

							if(!isset($publics)){
								header("Location: /Game/");
								exit;
							}

							if(isset($_SESSION['data']))
								unset($_SESSION['data']);
								echo('<title>Редагування '.$publics['name'].'</title>');
								echo("<a href='".$_SESSION['last_link']."' class='notactiveFolder flex'>Назад</a>");
							?>
						</div>
					</nav>
			</div>
		</div>
		<div class="foldersContent">
				<?
				$ver = "SELECT * FROM versions ORDER BY id DESC";
				$versions = $this->db->queryRows($ver);
 				
 				$c = "SELECT COUNT(DISTINCT versions.id) as 'count' FROM versions";
                $count = $this->db->queryRow($c);

				$ver = "SELECT * FROM version_type";
				$version_type = $this->db->queryRows($ver);

				switch($publics['type']){
						case 1:$sql = "SELECT name FROM mod_thematics";$names = $this->db->queryRows($sql);$t=" Модифікація";break;
						case 2:$sql = "SELECT name FROM mod_thematics";$names = $this->db->queryRows($sql);$t=" Дата-пак";break;
						case 3:$sql = "SELECT name FROM textures_thematics";$names = $this->db->queryRows($sql);$t=" Текстур-пак";break;
					}
					
						echo('<div class="Fcontent show">');

						echo('<div class="publics flex">
								<form method="POST" action="'.$this->GetUrl("/action/uploadPublic?id=".$_REQUEST['id']).'" style="width:100%;height:inherit;" enctype="multipart/form-data">
								<div class="title title-padding flex"><span>Редагування публікації</span></div>	
								<div class="AddPublic flex"> 

									<div class="addtext flex">
										<label class="labelTitle">Картинка</label>');

									if(isset($_SESSION['errors']['pictr']))echo ('<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['pictr']).'*</b></div>');

										echo('<label class="fileLabelImg labelImg" style="background-image: url(images/publicpictrs/'.$publics['image'].');background-size:cover;background-position:center;)"><input type="file" class="feedback__file addimage" name="pictr"></label>
										<label class="labelTitle">Заголовок</label><input placeholder="Заголовок" name="title" value="'.$publics['name'].'">');
										if(isset($_SESSION['errors']['title'])){
											echo '<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['title']).'*</b></div>';
										}
										echo('<label class="labelTitle">Жанр</label>
										<select name="theme"><option value="0">Оберіть пункт</option>');
										$j = 1;
										foreach($names as $row){
											if($j == $publics['theme']){
												echo('<option value='.$j.' selected>'.$row['name'].'</option>');	
											}
											else
												echo('<option value='.$j.'>'.$row['name'].'</option>');
											$j++;
										}

										echo('</select>');
											if(isset($_SESSION['errors']['theme'])){
												echo '<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['theme']).'*</b></div>';
											}
											echo('<label class="labelTitle">Версія гри</label>
												<select name="version_type"><option value="0">Оберіть пункт</option>');
											
											$j = 1;
											foreach($version_type as $row){
												if($j == $publics['version_type']){
												echo('<option value='.$j.' selected>'.$row['name'].'</option>');	
												}
												else
												echo('<option value='.$j.'>'.$row['name'].'</option>');
												$j++;
											}

											echo('</select>');
											if(isset($_SESSION['errors']['version_type'])){
												echo '<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['version_type']).'*</b></div>';
											}
											echo('<label class="labelTitle">Версія</label>
												<select name="version"><option value="0">Оберіть пункт</option>');
											
											$j = $count['count'];
											foreach($versions as $row){
												if($j == $publics['version_id']){
												echo('<option value='.$j.' selected>'.$row['name'].'</option>');	
												}
												else
												echo('<option value='.$j.'>'.$row['name'].'</option>');
												$j--;
											}

											echo('</select>');
											if(isset($_SESSION['errors']['version']) && $ptype){
												echo '<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['version']).'*</b></div>';
											}
										echo('<label class="labelTitle">Опис публікації</label>
										<textarea placeholder="Опис" name="text">'.$publics['discription'].'</textarea>');
										if(isset($_SESSION['errors']['bio'])){
											echo '<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['bio']).'*</b></div>';
										}
										echo('<label class="labelTitle">Файл</label>
										<label class="fileLabelFile labelFile"><input type="file" class="feedback__file addfile" name="file" value="'.$_FILES['file'].'"></label>
										
									</div>
									<div class="SubmitAdding flex"><input type="submit" value="Підтвердити" name="editpublic"></div>
									</div>								
								</form>
							</div>
						</div>');
					
				unset($_SESSION['errors']);unset($_SESSION['post']);?>
	</div>
	</div>

</div>
</div>