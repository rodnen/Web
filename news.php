<title>Новини</title>
<div class="wrapper">
    <div class="mainContent">
    	 <div class="content flex" style="justify-content:center;">
           <div style="width:760px;">
           	<div class="NewPublics background background-shadow" >
                <div class="title flex"><span>Тематика</span></div>
                <div style="margin:auto; width: 95%;">
            <?$themes = "SELECT * FROM news_thematics";
              $rows = $this->db->queryRows($themes);

              $version = "SELECT * FROM version_type";
              $ver = $this->db->queryRows($version);
                
                
                if(!isset($_REQUEST['type']) && !isset($_REQUEST['version'])){
                    echo('<a href="?" class="title-padding thematic-active">Все</a>');
                }
                else{
                   echo('<a href="?" class="title-padding thematic">Все</a>');
                }
              
              foreach($rows as $row){
                if($_REQUEST['type'] == $row['id']){
                    echo('<a href="?type='.$row['id'].'"class="title-padding thematic-active">'.$row['name'].'</a>');    
                }
                else{
                    echo('<a href="?type='.$row['id'].'"class="title-padding thematic">'.$row['name'].'</a>');
                }
              }

              foreach($ver as $row){
              	if($row['id'] < 3){
	                if($_REQUEST['version'] == $row['id']){
	                    echo('<a href="?version='.$row['id'].'"class="title-padding thematic-active">'.$row['name'].'</a>');    
	                }
	                else{
	                    echo('<a href="?version='.$row['id'].'"class="title-padding thematic">'.$row['name'].'</a>');
	                }
	            }
              }
            ?>
            </div>
             </div>
	       		<div class="NewPublics background background-shadow">
	                <div class="title flex"><span>Новини</span></div>
	                    <div class="publics flex"><div class="wrapper-center flex">
	                    <?
	                    $where = ' WHERE remove_status = "0" AND status = 2';
	                    $params = [];

						if (!empty($_REQUEST['type']) && is_numeric($_REQUEST['type'])) {
							$where .=" AND theme = ".$_REQUEST['type'];
							$params['type'] = $_REQUEST['type'];
						}

						if (!empty($_REQUEST['version']) && is_numeric($_REQUEST['version'])) {
							$where .=" AND version_type = ".$_REQUEST['version'];
							$params['version'] = $_REQUEST['version'];
						}
								
						$page = 1;
						if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) && $_REQUEST['page']>=1) {
						   $page=$_REQUEST['page'];
						}
						$limit = 12;
						$rowscount = 0;
						
						$c = $this->db->queryOne("SELECT COUNT(*) as 'count' FROM `news`".$where);
						if ($c) {   
						    $rowscount = $c['count'];
						}

						if($rowscount > 0){
							$pag = new Pagination([
								'rows' => $rowscount,
								'limit' => $limit,
								'limitPages' => 5,
								'page' => $page,
								'params' => $params
							]);
									    
							$first = $pag->GetFirstRow();
							$last = $pag->GetPages();     
							
							$sql = "SELECT * FROM news".$where." ORDER BY news.id DESC";
							$sql .= " LIMIT " . $first . ", ". $pag->GetLimit();
		                    $rows = $this->db->queryRows($sql);

		                    if ($rows === false) {
								echo $sql;
								echo '  Помилка SELECT';
							} else{
								
							

			                    $user = [];
			                    foreach($rows as $row){
			                        $u = "SELECT name,id FROM users WHERE id=".$row['publisher'];
			                        $user = array_merge($user,$this->db->queryRows($u));
			                    }
			                    
			                    $wait = new Publics($rows,$user,'news');

			                    $wait->show();

			                    $i = $pag->GetFirstRow();
								
		                    }
		                }
		                else{
		                	echo('<div class="title-padding"><span>Публікацій немає</span></div>');
		                }

						
	                    ?>
	                </div>
	            	</div>
	            	<?if($rowscount > 0)
	            		echo '<div id="pagination" class="pagination flex">'.$pag->show().'</div>';?>
	            </div>


        </div>
        <?include("view/rightPanel.php");?>
        </div>
    </div>
</div>