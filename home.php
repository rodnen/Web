<title>Головна</title>
<div class="wrapper">
	<div class="mainContent">
		<div class="content flex">
			<div class="allPublicsContent">
				<div class="flex">
					<div class="lastNews background background-shadow">
						<div class="title flex"><span>Останні новини сайта</span><span><a href="<?=$this->GetUrl('/news')?>"><span>Всі новини</span><i class='arrow-to-all bx bx-chevron-right'></i></a></span></div>
						<?
						$where = ' WHERE remove_status = "0" AND theme = 1 AND status = 2';
					    
					    $p = "SELECT * FROM news ".$where." ORDER BY news.id DESC LIMIT 0,4";


					    $publics = $this->db->queryRows($p);
					   
					    if ($publicts === false) {
					        echo 'Помилка в SELECT';
					    } else{
					        
					        echo('<div class="publics flex">');
					        foreach($publics as $row) {
					        	$month = intval(explode('-',$row['date'])[1]);
					        	$year = intval(explode('-',$row['date'])[0]);
					        	$day = intval(explode('-',$row['date'])[2]);


					        	$string = $row["name"];
					        	$username = '';
					        	if(strlen($string) > 42){
					        		
					        		$string = substr_replace($string, '...',40);
					        		
					        	}

					        	$u = "SELECT * FROM users WHERE id=".$row['publisher'];
					        	$user = $this->db->queryRows($u);
					        	if ($user === false) {
							        echo 'Ошибка в SELECT';
							        break;
							    }
							    foreach($user as $part){
							    	$username = $part['name'];
							    }

							    $a = $this->GetUrl("/user/profile?id=".$row['publisher']);

					        	echo('<div>
									<div class="content">
									<div>
									<a href="news-page?id='.$row['id'].'">
										'.$string.'
									</a>
									</div>
										<div class="discription flex">
											<a href="'.$a.'" style="color:inherit;"><i class="bx bxs-user"></i>'.$username.'</a>
											<span class="date">'.$day.' '.$months[$month-1].' '.$year.'р.'.'</div>
										</div>
									</div>');
					            $i++;
					        }
					        
					        echo('</div>');
					    }
					    ?>
					</div>
					<div class="lastNews background background-shadow">
						<div class="title flex"><span>Останні оновлення гри</span><span><a href="<?=$this->GetUrl('/news')?>"><span>Всі новини</span><i class='arrow-to-all bx bx-chevron-right'></i></a></span></div>
						<?
						$where = ' WHERE remove_status = "0" AND theme = 2 AND status = 2';
						
					    
					    $p = "SELECT * FROM news ".$where." ORDER BY news.id DESC LIMIT 0,4";

					    $publics = $this->db->queryRows($p);
					   
					    if ($publicts === false) {
					        echo 'Помилка в SELECT';
					    } else{
					        
					        echo('<div class="publics flex">');
					        foreach($publics as $row) {
					        	$month = intval(explode('-',$row['date'])[1]);
					        	$year = intval(explode('-',$row['date'])[0]);
					        	$day = intval(explode('-',$row['date'])[2]);

					        	$string = $row["discription"];
					        	$username = '';
					        	if(strlen($row["discription"]) > 70){
					        		
					        		$string = substr_replace($string, '...',67);
					        		
					        	}

					        	$u = "SELECT * FROM users WHERE id=".$row['publisher'];
					        	$user = $this->db->queryRows($u);
					        	if ($user === false) {
							        echo 'Ошибка в SELECT';
							        break;
							    }
							    foreach($user as $part){
							    	$username = $part['name'];
							    }

							    $a = $this->GetUrl("/user/profile?id=".$row['publisher']);

					        	echo('<div>
									<div class="content">
									<div>
									<a href="news-page?id='.$row['id'].'">
										'.$row['name'].'
									</a>
									</div>
										<div class="discription flex">
											<a href="'.$a.'" style="color:inherit;"><i class="bx bxs-user"></i>'.$username.'</a>
											<span class="date">'.$day.' '.$months[$month-1].' '.$year.'р.'.'</div>
										</div>
									</div>');
					            $i++;
					        }
					        
					        echo('</div>');
					    }
					    ?>
					</div>
				</div>
				<div class="NewPublics background background-shadow" >
					<div class="title flex"><span>Нові публікації</span><span><a href="<?=$this->GetUrl('/publics')?>"><span>Всі публікації</span><i class='arrow-to-all bx bx-chevron-right'></i></a></span></div>
						<div class="publics flex">
                            <div class="wrapper-center flex">
                            <?
                            $where = ' WHERE remove_status = "0" AND status = 2';

                            $sql = "SELECT * FROM publics".$where." ORDER BY publics.date DESC LIMIT 0,6";
                            $rows = $this->db->queryRows($sql);

                            $user = [];
                            foreach($rows as $row){
                                $u = "SELECT name,id FROM users WHERE id=".$row['publisher'];
                                $user = array_merge($user,$this->db->queryRows($u));
                            }
                            
                            $wait = new Publics($rows,$user,'publics');

                            $wait->show();

                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?include("view/rightPanel.php");?>
		</div>
	</div>
</div>