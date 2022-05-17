<?
if(!isset($_SESSION['auth'])){header("Location: /Game");exit;}
$sql = "UPDATE publics SET status = 3 WHERE id = ".$_REQUEST['id'];
if($this->db->query($sql)){
	header("Location: ". $_SESSION['last_link']);
	exit;
}
?>