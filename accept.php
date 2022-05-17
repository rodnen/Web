<?
if(!isset($_SESSION['auth'])){header("Location: /Game");exit;}

if($_REQUEST['type'] == 1){
	$sql = "UPDATE news SET status = 2, remove_status = 0 WHERE id = ".$_REQUEST['id'];
	if($this->db->query($sql)){
		header("Location: ". $_SESSION['last_link']);
		exit;
	}
}

if($_REQUEST['type'] == 2){
	$sql = "UPDATE publics SET status = 2, remove_status = 0 WHERE id = ".$_REQUEST['id'];
	if($this->db->query($sql)){
		header("Location: ". $_SESSION['last_link']);
		exit;
	}	
}

?>