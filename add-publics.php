<?if(!isset($_SESSION['auth'])){header("Location: /Game");exit;}?>
<title>Додати публікацію</title>
<div class="wrapper">
	<div class="mainContent">
		<div class="profileContent">
		<div class="leftMenu background background-shadow">
			<div class="list">
				<nav class="profileList">
				<div id="tabs">
							<?
							if(isset($_SESSION['data']))
								unset($_SESSION['data']);
								for($i=1;$i<4;$i++){
									if(isset($_REQUEST['folder'])){
										if($i == $_REQUEST['folder']){
											echo("<span class='activeFolder type flex'>");
										}
										else{
											echo("<span class='notactiveFolder type flex'>");
										}
									}
									else{
										if($i == 1){
											echo("<span class='activeFolder type flex'>");
										}
										else{
											echo("<span class='notactiveFolder type flex'>");
										}
									}
									
									
									switch($i){
										case 1:echo ("Мод</span>");break;
										case 2:echo ("Дата-пак</span>");break;
										case 3:echo ("Текстур-пак</span>");break;
										case 4:echo ("Скін</span>");break;
									}
								}
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

				$ptype = false;
				for($i=1;$i<4;$i++){
					if($_SESSION['post']['type'] == $i){
						$ptype = true;
					}
					else{
						$ptype = false;
					}

					switch($i){
						case 1:$sql = "SELECT name FROM mod_thematics";$names = $this->db->queryRows($sql);$t=" Модифікація";break;
						case 2:$sql = "SELECT name FROM mod_thematics";$names = $this->db->queryRows($sql);$t=" Дата-пак";break;
						case 3:$sql = "SELECT name FROM textures_thematics";$names = $this->db->queryRows($sql);$t=" Текстур-пак";break;
						case 4:$sql = "SELECT name FROM skin_thematics";$names = $this->db->queryRows($sql);$t=" Скін";break;
					}
					if(isset($_REQUEST['folder'])){
						if($i == $_REQUEST['folder'])
							echo('<div class="Fcontent show">');
						else
							echo('<div class="Fcontent hidden">');
					}
					else
						if($i == 1)
							echo('<div class="Fcontent show">');
						else
							echo('<div class="Fcontent hidden">');

						echo('<div class="publics flex">
								<form method="POST" action="'.$this->GetUrl("/action/uploadPublic?type=".$i).'" style="width:100%;height:inherit;" enctype="multipart/form-data">
								<div class="title title-padding flex"><span>'.$t.'</span></div>	
								<div class="AddPublic flex"> 

									<div class="addtext flex">
										<label class="labelTitle">Картинка</label>');if(isset($_SESSION['errors']['pictr']) && $ptype)echo ('<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['pictr']).'*</b></div>');

									echo('<label class="fileLabelImg labelImg"><input type="file" class="feedback__file addimage" name="pictr" multiple></label>
										<label class="labelTitle">Заголовок</label><input placeholder="Заголовок" name="title" value="');

										if($ptype) echo($_SESSION['post']['title']);

										echo('">');

										if(isset($_SESSION['errors']['title']) && $ptype){
											echo '<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['title']).'*</b></div>';
										}
										echo('<label class="labelTitle">Жанр</label><select name="theme"><option value="0">Оберіть пункт</option>');
										
										$j = 1;
										foreach($names as $row){
											if($_SESSION['post']['theme'] == $j && $ptype)
												echo('<option value='.$j.' selected>'.$row['name'].'</option>');
											else
												echo('<option value='.$j.'>'.$row['name'].'</option>');
											$j++;
										}

										echo('</select>');
										if(isset($_SESSION['errors']['theme']) && $ptype){
											echo '<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['theme']).'*</b></div>';
										}

										if($i<4){
											echo('<label class="labelTitle">Версія гри</label><select name="version_type"><option value="0">Оберіть пункт</option>');
											
											$j = 1;
											foreach($version_type as $row){
												if($_SESSION['post']['version_type'] == $j && $ptype)
													echo('<option value='.$j.' selected>'.$row['name'].'</option>');
												else
													echo('<option value='.$j.'>'.$row['name'].'</option>');
												$j++;
											}

											echo('</select>');
											if(isset($_SESSION['errors']['version_type']) && $ptype){
												echo '<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['version_type']).'*</b></div>';
											}
											echo('<label class="labelTitle">Версія</label>
												<select name="version"><option value="0">Оберіть пункт</option>');
											
											$j = $count['count'];
											foreach($versions as $row){
												if($_SESSION['post']['version'] == $j && $ptype)
													echo('<option value='.$j.' selected>'.$row['name'].'</option>');
												else
													echo('<option value='.$j.'>'.$row['name'].'</option>');
												$j--;
											}

											echo('</select>');
											if(isset($_SESSION['errors']['version']) && $ptype){
												echo '<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['version']).'*</b></div>';
											}
										}
										echo('<label class="labelTitle">Опис публікації</label>
										<textarea placeholder="Опис" name="text">');

										if($ptype) echo($_SESSION['post']['bio']);
										echo('</textarea>');

										if(isset($_SESSION['errors']['bio']) && $ptype){
											echo '<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['bio']).'*</b></div>';
										}
										echo('<label class="labelTitle">Файл</label>
										<label class="fileLabelFile labelFile"><input type="file" class="feedback__file addfile" name="file" multiple></label>');
										if(isset($_SESSION['errors']['file']) && $ptype)echo ('<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['file']).'*</b></div>');
										?>
									</div>
									<div class="SubmitAdding flex"><input type="submit" value="Підтвердити" name="addpublic"></div>
									</div>								
								</form>
							</div>
						</div>
					
				<?}unset($_SESSION['errors']);unset($_SESSION['post']);?>
			
	</div>
	</div>

</div>
</div>