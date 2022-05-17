<title>Не опубліковані</title>
<div class="wrapper">
	<div class="mainContent">
		<div class="NewPublics background background-shadow">
					<div class="title flex"><span>Не опубліковані публікації</span></div>
					<div class="publics flex"><div class="wrapper-center flex">
					<?
					$where = ' WHERE status = 1 OR status = 3';

					$sql = "SELECT * FROM publics".$where." ORDER BY publics.id DESC";
					$rows = $this->db->queryRows($sql);

					$c = $this->db->queryRow("SELECT COUNT(*) as 'count' FROM publics".$where." ORDER BY publics.id DESC");


					$user = [];
					foreach($rows as $row){
			            $u = "SELECT name,id FROM users WHERE id=".$row['publisher'];
			            $user = array_merge($user,$this->db->queryRows($u));
		        	}
 					
					$wait = new Publics($rows,$user,'waiting');

					$wait->show();

					if($c['count'] == 0)
						echo('<div class="title-padding"><span>Публікацій немає</span></div>');
				    ?>
				</div>
			</div>
			</div></div>
	</div>
</div>