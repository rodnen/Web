<div class="wrapper">
    <div class="mainContent">
        <div class="content flex" style="justify-content:center;">
           <div class="publicPicture flex">
                <div class="NewPublics background background-shadow" >
                	<?

                		if(isset($_REQUEST['id']) && !is_numeric($_REQUEST['id'])){
							header("Location: /Game/");
							exit;
						}
						
						$SQL = "SELECT * FROM news WHERE id =".$_REQUEST['id'];

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
							echo('<div class="title-buttons"><a style="margin-right:10px;" href="'.$this->GetUrl('/editnews?id='.$publics['id']).'"><span>Редагувати</span></a><a style="margin-right:10px;" href="'.$this->GetUrl('/action/remove?id='.$publics['id'].'&type='.$publics['pub_type']).'"><span>Видалити</span></a>');
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
                  		<img src="<?=$this->GetUrl('/images/newspictrs/'.$publics['image']);?>">
                  		<div class="pinfo flex">
                  		 <a href="<?echo($a);?>"><i class="bx bxs-user"></i><?echo($name['name']);?></a><span class="date" ><?echo($day.$months[$month-1].$year.'р.');?></span></div>
                  	</div>
                  	<div class="discription title-padding"><span><?echo ($publics['discription']);?></span></div>
                  	
                       
                </div>
                </div>
                
    </div>
    </div>
</div>