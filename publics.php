<title>Публікації</title>
<div class="wrapper">
    <div class="mainContent">
        <div class="content flex" style="justify-content:center;">
           <div style="width:760px;">
            
            <div class="NewPublics background background-shadow" >
                <div class="title flex"><span>Версія</span></div>
                <div style="margin:auto; width: 95%;">
              <?
              $selectedVersion;
              $versions = "SELECT * FROM versions ORDER BY id DESC";
              $rows = $this->db->queryRows($versions);
                
                if(isset($_REQUEST['type'])){
                    $link = '?type='.$_REQUEST['type'].'&version=';
                }

                else{
                    $link = '?version=';    
                }

                if(!isset($_REQUEST['version']) || $_REQUEST['version'] == 'All'){
                    echo('<a href="'.$link.'All" class="title-padding thematic-active">Все</a>');
                }
                else{
                   echo('<a href="'.$link.'All" class="title-padding thematic">Все</a>');
                }
              
                foreach($rows as $row){

                    if($_REQUEST['version'] == $row['name']){
                        echo('<a href="'.$link.$row['name'].'"class="title-padding thematic-active">'.$row['name'].'</a>'); 
                        $selectedVersion =  $row['id'];
                    }
                    else{
                        echo('<a href="'.$link.$row['name'].'"class="title-padding thematic">'.$row['name'].'</a>');
                    }
                }

            ?>
            </div>
             </div>
                <div class="NewPublics background background-shadow" >
                    <div class="title flex"><span>Публікації</span></div>
                        <div class="publics flex"><div class="wrapper-center flex">
                        <?
                        $where = ' WHERE remove_status = "0"';
                        $params = [];

                        if (!empty($_REQUEST['type']) && is_numeric($_REQUEST['type'])) {
                            $where .=" AND theme = ".$_REQUEST['type'];
                            $params['type'] = $_REQUEST['type'];
                        }
                        if (!empty($_REQUEST['version']) && stristr($_REQUEST['version'], "1.")){
                            $where .=" AND version_id = ".$selectedVersion;
                            $params['version'] = $_REQUEST['version'];
                        }
                                
                        $page = 1;
                        if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) && $_REQUEST['page']>=1) {
                           $page=$_REQUEST['page'];
                        }
                        $limit = 12;
                        $rowscount = 0;
                        
                        $c = $this->db->queryOne("SELECT COUNT(*) as 'count' FROM `publics`".$where);
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
                            
                            $sql = "SELECT * FROM publics".$where." ORDER BY id DESC";
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
                                
                                $wait = new Publics($rows,$user,'publics');

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
                    <?
                    if($rowscount > 0)
                        echo '<div id="pagination" class="pagination flex">'.$pag->show().'</div>';?>
                </div>
                </div>
        <?include("view/rightPanel.php");?>
        </div>
     </div>
</div>