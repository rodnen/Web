<?
/*ПРИКРУТИТЬ ЗАПРОСЫ*/
if ($this->db->IsConnect()) {
       $where = ' WHERE remove_status = "0"';
       $from = 0;
       $limit = 8;
       $page = 1;
              

       if (isset($_REQUEST['find'])) {
              $whereNews = $where.' AND news.name  Like "%'.$_REQUEST['find'].'%"';
              $wherePublics = $where.' AND publics.name  Like "%'.$_REQUEST['find'].'%"';


              $JSONrows =$this->db->queryRows("SELECT id,name,image,discription,likes,coments,publisher,date,pub_type FROM news ".$whereNews."  UNION ALL SELECT id,name,image,discription,likes,coments,publisher,date,pub_type FROM publics".$wherePublics." ORDER BY date DESC LIMIT ".$from." , ".$limit);
              
              $res = json_encode($JSONrows);
              echo($res);      
       }

       if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) && $_REQUEST['page']>=1) {
              $from = $limit * ($_REQUEST['page']-1);
              $page = $_REQUEST['page'];
       }
       /*ВСІ ПУБЛІКАЦІЇ*/
       if (is_numeric($_REQUEST['folder']) && $_REQUEST['folder'] == 1){

              $whereNews = $where.' AND news.publisher='.$_REQUEST['id'];
              $wherePublics = $where.' AND publics.publisher='.$_REQUEST['id'];

              $JSONrows =$this->db->queryRows("SELECT id,name,image,discription,likes,coments,publisher,date,pub_type FROM news ".$whereNews."  UNION ALL SELECT id,name,image,discription,likes,coments,publisher,date,pub_type FROM publics".$wherePublics." ORDER BY date DESC LIMIT ".$from." , ".$limit);
              $NCount = $this->db->queryRow("SELECT COUNT(*) AS `count` FROM news".$whereNews);

              $PCount = $this->db->queryRow("SELECT COUNT(*) AS `count` FROM publics ".$wherePublics);
                     
              $arr[0]['count'] = $NCount['count'] + $PCount['count'];

              $finalArr = [];
              foreach($JSONrows as $k => $v){
                     $finalArr [] = array_merge($JSONrows[$k], (array)$arr[$k]);
              }

              $res = json_encode($finalArr);
              echo($res); 
       }

       if (is_numeric($_REQUEST['folder']) && $_REQUEST['folder'] == 2 && $_REQUEST['id'] == $_SESSION['auth']){

              $whereNews = $where.' AND news.publisher='.$_REQUEST['id'].' AND news.status = 2';
              $wherePublics = $where.' AND publics.publisher='.$_REQUEST['id'].' AND publics.status = 2';

              $JSONrows =$this->db->queryRows("SELECT id,name,image,discription,likes,coments,publisher,date,pub_type FROM news ".$whereNews."  UNION ALL SELECT id,name,image,discription,likes,coments,publisher,date,pub_type FROM publics".$wherePublics." ORDER BY date DESC LIMIT ".$from." , ".$limit);
              $NCount = $this->db->queryRow("SELECT COUNT(*) AS `count` FROM news".$whereNews);

              $PCount = $this->db->queryRow("SELECT COUNT(*) AS `count` FROM publics ".$wherePublics);
                     
              $arr[0]['count'] = $NCount['count'] + $PCount['count'];

              $finalArr = [];
              foreach($JSONrows as $k => $v){
                     $finalArr [] = array_merge($JSONrows[$k], (array)$arr[$k]);
              }

              $res = json_encode($finalArr);
              echo($res);
       }
       else{

       }
       /*ОЧІКУЮТЬ ПІДТВЕРДЖЕННЯ*/
       if (is_numeric($_REQUEST['folder']) && $_REQUEST['folder'] == 3){

              $whereNews = $where.' AND news.publisher='.$_REQUEST['id'].' AND news.status = 1';
              $wherePublics = $where.' AND publics.publisher='.$_REQUEST['id'].' AND publics.status = 1';

              $JSONrows =$this->db->queryRows("SELECT id,name,image,discription,likes,coments,publisher,date,pub_type FROM news ".$whereNews."  UNION ALL SELECT id,name,image,discription,likes,coments,publisher,date,pub_type FROM publics".$wherePublics." ORDER BY date DESC LIMIT ".$from." , ".$limit);
             $NCount = $this->db->queryRow("SELECT COUNT(*) AS `count` FROM news".$whereNews);

              $PCount = $this->db->queryRow("SELECT COUNT(*) AS `count` FROM publics ".$wherePublics);
                     
              $arr[0]['count'] = $NCount['count'] + $PCount['count'];

              $finalArr = [];
              foreach($JSONrows as $k => $v){
                     $finalArr [] = array_merge($JSONrows[$k], (array)$arr[$k]);
              }

              $res = json_encode($finalArr);
              echo($res); 
       }

       if (is_numeric($_REQUEST['folder']) && $_REQUEST['folder'] == 4){

              $whereNews = $where.' AND news.publisher='.$_REQUEST['id'].' AND news.status = 3';
              $wherePublics = $where.' AND publics.publisher='.$_REQUEST['id'].' AND publics.status = 3';

              $JSONrows =$this->db->queryRows("SELECT id,name,image,discription,likes,coments,publisher,date,pub_type FROM news ".$whereNews."  UNION ALL SELECT id,name,image,discription,likes,coments,publisher,date,pub_type FROM publics".$wherePublics." ORDER BY date DESC LIMIT ".$from." , ".$limit);
              $NCount = $this->db->queryRow("SELECT COUNT(*) AS `count` FROM news".$whereNews);

              $PCount = $this->db->queryRow("SELECT COUNT(*) AS `count` FROM publics ".$wherePublics);
                     
              $arr[0]['count'] = $NCount['count'] + $PCount['count'];

              $finalArr = [];
              foreach($JSONrows as $k => $v){
                     $finalArr [] = array_merge($JSONrows[$k], (array)$arr[$k]);
              }

              $res = json_encode($finalArr);
              echo($res); 
       }

       if (is_numeric($_REQUEST['folder']) && $_REQUEST['folder'] == 5){


              $JSONrows =$this->db->queryRows("SELECT * FROM friends WHERE friend_one = ".$_REQUEST['id']." OR friend_two = ".$_REQUEST['id']." AND status = 1 ORDER BY created DESC LIMIT ".$from." , ".$limit);
              $count = $this->db->queryRow("SELECT COUNT(*) AS 'count' FROM friends WHERE friend_one = ".$_REQUEST['id']." OR friend_two = ".$_REQUEST['id']." AND status = 1");
                     

              $finalArr = [];
              foreach($JSONrows as $k => $v){
                     $finalArr [] = array_merge($JSONrows[$k], (array)$count[$k]);
              }

              $res = json_encode($finalArr);
              echo($res); 
       }

       if (is_numeric($_REQUEST['folder']) && $_REQUEST['folder'] == 6){

              $favorite =$this->db->queryRows("SELECT * FROM favorite WHERE user_id = ".$_REQUEST['id']." ORDER BY id DESC LIMIT ".$from." , ".$limit);
              $count = $this->db->queryRow("SELECT COUNT(*) AS 'count' FROM favorite WHERE user_id = ".$_REQUEST['id']);

              $i = 0;
              foreach($favorite as $row){
                     if ($row['public_type'] == 1) {
                            $JSONrows[$i]=$this->db->queryRow("SELECT id,image,name,discription,likes,coments,pub_type,date FROM news WHERE id = ".$row['public_id']); 
                     }
                     else{
                            $JSONrows[$i]=$this->db->queryRow("SELECT id,image,name,discription,likes,coments,pub_type,date FROM publics WHERE id = ".$row['public_id']); 
                            
                     }
                     $i++;
              }

              $JSONrows[0]['count'] = $count['count'];

              $res = json_encode($JSONrows);
              echo($res);
       }
}
?>