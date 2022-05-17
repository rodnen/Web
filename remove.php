<?
if(!isset($_SESSION['auth'])){header("Location: /Game");exit;}

if($_REQUEST['type'] == 1){
	$sql = "UPDATE news SET remove_status = '1' ,status=3 WHERE id = ".$_REQUEST['id'];
	if($this->db->query($sql)){
		header("Location: ". $_SESSION['last_link']);
		exit;
	}	
}

if($_REQUEST['type'] == 2){
	$sql = "UPDATE publics SET remove_status = '1',status=3 WHERE id = ".$_REQUEST['id'];
	if($this->db->query($sql)){
		header("Location: ". $_SESSION['last_link']);
		exit;
	}	
}

?>