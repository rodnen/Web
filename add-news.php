<?if(!isset($_SESSION['auth'])){header("Location: /Game");exit;}?>
<title>Додати новину</title>
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
								for($i=1;$i<3;$i++){
									if(isset($_REQUEST['folder'])){
										if($i == $_REQUEST['type']){
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
										case 1:echo ("Новина сайта</span>");break;
										case 2:echo ("Новина про гру</span>");break;
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
				$ver = "SELECT * FROM version_type";
				$version_type = $this->db->queryRows($ver);

				$ptype = false;
				for($i=1;$i<3;$i++){
					if($_SESSION['post']['type'] == $i){
						$ptype = true;
					}
					else{
						$ptype = false;
					}

					switch($i){
						case 1:$t=" Новина про сайт";break;
						case 2:$t=" Новина про гру";break;
					}
					if($i==1)
						echo('<div class="Fcontent show">');
					else
						echo('<div class="Fcontent hidden">');

						echo('<div class="publics flex">
								<form method="POST" action="'.$this->GetUrl("/action/uploadPublic?type=".$i).'" enctype="multipart/form-data" style="width:100%;height:inherit;">
								<div class="title title-padding flex"><span>'.$t.'</span></div>	
								<div class="AddPublic flex"> 

									<div class="addtext flex">
										<label class="labelTitle">Картинка</label>');if(isset($_SESSION['errors']['pictr']) && $ptype)echo ('<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['pictr']).'*</b></div>');

										echo('<label class="fileLabelImg labelImg"><input name="pictr" type="file" class="feedback__file addimage"></label>
										<label class="labelTitle">Заголовок</label>
										<input placeholder="Заголовок" name="title" value="');

										if($ptype) echo($_SESSION['post']['title']);

										echo('">');

										if(isset($_SESSION['errors']['title']) && $ptype){
											echo '<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['title']).'*</b></div>';
										}
										if($i==2){
											echo('<label class="labelTitle">Версія гри</label>
												<select name="version_type"><option value="0">Оберіть пункт</option>');
											
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
										}
										echo('<label class="labelTitle">Опис публікації</label>
										<textarea placeholder="Опис" name="text">');
										if($ptype) echo($_SESSION['post']['bio']);
										echo('</textarea>');

										if(isset($_SESSION['errors']['bio']) && $ptype){
											echo '<div class="error-for-public flex"><b>'.htmlspecialchars($_SESSION['errors']['bio']).'*</b></div>';
										}	
										?>									
									</div>
									<div class="SubmitAdding flex"><input type="submit" value="Підтвердити" name="addnews"></div>
									</div>								
								</form>
							</div>
						</div>
					
				<?}unset($_SESSION['errors']);unset($_SESSION['post']);?>
	</div>
	</div>

</div>
</div>