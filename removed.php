<title>Видалені</title>
<div class="wrapper">
	<div class="mainContent">
		<div class="NewPublics background background-shadow">
					<div class="title flex"><span>Видалені публікації</span></div>
					<div class="publics flex"><div class="wrapper-center flex">
					<?
					$where = ' WHERE remove_status = "1"';

					if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
						if($_REQUEST['id'] == $_SESSION['auth']){
							$where .=" AND publisher=".$_SESSION['auth'];
						}
						else{
							header("Location: /Game/removed?id=".$_SESSION['auth']);
							exit();
						}
					}
					else if($_SESSION['admin'] != 2){
						header("Location: /Game/removed?id=".$_SESSION['auth']);
						exit();
					}

					$sql = "SELECT id,name,image,discription,likes,coments,publisher,date,pub_type,version_type FROM news ".$where." UNION ALL SELECT id,name,image,discription,likes,coments,publisher,date,pub_type,type FROM publics".$where." ORDER BY id DESC";
					$rows = $this->db->queryRows($sql);

					$NCount = $this->db->queryRow("SELECT COUNT(*) AS `count` FROM news".$where);

              		$PCount = $this->db->queryRow("SELECT COUNT(*) AS `count` FROM publics".$where);


					$user = [];
					foreach($rows as $row){
			            $u = "SELECT name,id FROM users WHERE id=".$row['publisher'];
			            $user = array_merge($user,$this->db->queryRows($u));
		        	}
 					
					$wait = new Publics($rows,$user,'removed');

					$wait->show();

					if($NCount['count'] == 0 && $PCount['count']== 0)
						echo('<div class="title-padding"><span>Публікацій немає</span></div>');
				    ?>
				</div>
			</div>
			</div></div>
	</div>
</div>