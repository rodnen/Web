<?
if(!isset($_SESSION['auth'])){header("Location: /Game");exit;}

	$sql = "SELECT * FROM favorite WHERE user_id =".$_SESSION['auth']." AND public_id = ".$_REQUEST['id']." AND public_type = ".$_REQUEST['type'];

	if ($this->db->queryRows($sql)) {
		$sql = "DELETE FROM favorite WHERE user_id =".$_SESSION['auth']." AND public_id = ".$_REQUEST['id']." AND public_type = ".$_REQUEST['type'];
		if($this->db->query($sql)){
			header("Location: ". $_SESSION['last_link']);
			exit;
		}	
	}
	else{
		$sql = "INSERT INTO favorite (`user_id`,`public_id`, `public_type`) VALUES(".$_SESSION['auth'].",".$_REQUEST['id'].",".$_REQUEST['type'].")";
		if($this->db->query($sql)){
			header("Location: ". $_SESSION['last_link']);
			exit;
		}	
	}
?>