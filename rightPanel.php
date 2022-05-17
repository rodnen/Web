			 <div class="rightPanel background background-shadow">
	            <div class="title flex"><span>Випадкова публікація</span></div>
	            <div class="publics flex">
	                <div class="wrapper-center flex">
	                            <?
	                            $c = "SELECT COUNT(DISTINCT publics.id) as 'count' FROM publics WHERE remove_status = '0' AND status = 2";
                                $count = $this->db->queryRow($c);

                                if($count['count'] > 0){
		                            $sql = "SELECT MIN(cast(id as DECIMAL(9,0))) as min, MAX(cast(id as DECIMAL(9,0))) as max FROM publics WHERE remove_status = '0' AND status = 2";
									$MinMax = $this->db->queryOne($sql);

									$randomID = rand($MinMax['min'],$MinMax['max']);

	                                $where = ' WHERE remove_status = "0" AND id = '.$randomID." AND status = 2";
									$sql = "SELECT * FROM publics".$where;
	                                $rows = $this->db->queryOne($sql);
                              
	                                while(!isset($rows)){
	                                    $randomID = rand($MinMax['min'],$MinMax['max']);
	                                    $sql = "SELECT * FROM publics".$where;
	                                    $rows = $this->db->queryRows($sql);

	                                }
								        
				                    $where = ' WHERE remove_status = "0" AND id = '.$randomID." AND status = 2";

				                    $sql = "SELECT * FROM publics".$where." ORDER BY publics.date DESC";
				                    $rows = $this->db->queryRows($sql);

				                    $user = [];
				                    foreach($rows as $row){
				                        $u = "SELECT name,id FROM users WHERE id=".$row['publisher'];
				                        $user = array_merge($user,$this->db->queryRows($u));
				                    }
				                            
				                    $wait = new Publics($rows,$user,'random');

				                    $wait->show();
			                    }

			                    
	                            ?>  
	               </div>
				</div>
			</div>