<?
include('view/action/formValid.php');

function Upload($file, $options) {
    if (isset($file['error']) && $file['error'] > 0)
    {
        $err = "Неможливо завантажити зображення";
        switch ($file['error'])
        {
            case 1: $err.= "Розмір файлу завеликий";break;
            case 2: $err.= "Файл завантажився частково";break;
            case 3: $err.= "Файл не завантажився";break;
        }
        return $err;
    }
    if ($file['size'] == 0 || filesize($file['tmp_name']) == 0){
        return 'Файл має за малий розмір';
    }
    if ($options['type'] && !in_array($file['type'], $options['type'])) {
        return 'Файл не є картинкою';
    }

    if (!move_uploaded_file($file['tmp_name'], $options['name'])){
        return 'Неможливо завантажити файл';
    }
    return '';
}

$errors = [];

$search = ['\'','"'];
$replace = ["\\'",'\"'];

function UploadPictr($filename){
    if(isset($_POST['addpublic']) || isset($_POST['editpublic'])){
        $err = Upload($_FILES['pictr'], [
        'type' => [
            'image/jpeg','image/jpg','image/png','image/jpeg2000','image/webp'
        ],
        'name' => 'images/publicpictrs/'.$filename
        ]);
    }

    if(isset($_POST['addnews']) || isset($_POST['editnews'])){
        $err = Upload($_FILES['pictr'], [
        'type' => [
            'image/jpeg','image/jpg','image/png','image/jpeg2000','image/webp'
        ],
        'name' => 'images/newspictrs/'.$filename
        ]);
    }
    if(!$err){
        return true;
    }
    else
        return false;
}


function UploadFile($filename){
    $err = Upload($_FILES['file'], [
    'type' => [
        'application/zip','application/x-rar','application/x-zip-compressed','application/octet-stream'
    ],
    'name' => 'images/files/'.$filename
    ]);
    if(!$err){
        return true;
    }
    else
        return false;
}


if (isset($_POST['addpublic'])) {
    $errors = PublicationValid();
    if (!$errors) {
        $errors = complete();
    }
    else{
        $Pictr = $_FILES['pictr']['name'];
        $tmpi = end(explode('.', $Pictr));

        $File = $_FILES['file']['name'];
        $tmpf = end(explode('.', $File));

        $_SESSION['errors'] = $errors;
        $_SESSION['post'] = $_POST;
        $_SESSION['post']['type'] = $_REQUEST['type'];

        if(!$tmpi){
            $_SESSION['errors']['pictr'] = 'Додайте зображення';
        }
       
        if(!$tmpf){
            $_SESSION['errors']['file'] = 'Додайте файл';
        }

        header("Location:".$_SESSION['last_link']);
        exit;
    }

    if(isset($_FILES)){
        $Pictr = $_FILES['pictr']['name'];
        $tmpi = end(explode('.', $Pictr));
        $Pictr = uniqid().'.'.$tmp;

        $File = $_FILES['file']['name'];
        $tmpf = end(explode('.', $File));
        $File = uniqid().'.'.$tmp;


        if(!$tmpi){
            $_SESSION['errors']['pictr'] = 'Додайте зображення';
        }
       
        if(!$tmpf){
            $_SESSION['errors']['file'] = 'Додайте файл';
        }

        if(!$tmpf || !$tmpi){
            header("Location:".$_SESSION['last_link']);
            exit;
        }

        $title = str_replace($search, $replace, $_POST['title']); 
        
        $disc = str_replace($search, $replace, $_POST['text']); 


        if(UploadPictr($Pictr) && UploadFile($File)){
            $sql="INSERT INTO publics(name,discription,image,file,version_type,version_id,theme,type,publisher) VALUES ('".$title."','".$disc."','".$Pictr."','".$File."',".$_POST['version_type'].",".$_POST['version'].",".$_POST['theme'].",".$_REQUEST['type'].",".$_SESSION['auth'].")";
            if($this->db->query($sql)){
                header("Location: /Game/");
                exit;
            }
            else{
                echo($sql);
            }
        }
        
    }

}

if (isset($_POST['addnews'])) {
    $errors = PublicationValid();
    if (!$errors) {
        $errors = complete();
    }
    else{
        $Pictr = $_FILES['pictr']['name'];
        $tmpi = end(explode('.', $Pictr));

        $_SESSION['errors'] = $errors;
        $_SESSION['post'] = $_POST;
        $_SESSION['post']['type'] = $_REQUEST['type'];

        if(!$tmpi){
            $_SESSION['errors']['pictr'] = 'Додайте зображення';
        }

        header("Location:".$_SESSION['last_link']);
        exit;
    }
    if(isset($_FILES)){
        $Pictr = $_FILES['pictr']['name'];
        $tmp = end(explode('.', $Pictr));
        $Pictr = uniqid().'.'.$tmp;

        $title = str_replace($search, $replace, $_POST['title']); 
        
        $disc = str_replace($search, $replace, $_POST['text']); 

        $sql='INSERT INTO news(name,discription,image,theme,version_type,publisher,status) VALUES ("'.$title.'","'.$disc.'"';

        if($_REQUEST['type'] == 1){

            if(!$tmp){
                $sql.=',"siteLogo.png"';
            }
            else{
               if(UploadPictr($Pictr)) 
                $sql.= ',"'.$Pictr.'"';
            }

            $sql.=',"'.$_REQUEST['type'].'",3,"'.$_SESSION['auth'].'","2")';

            if($this->db->query($sql)){
                header("Location: /Game/");
                exit;
            }
            else{
                echo($sql);
            }
        }
        if($_REQUEST['type'] == 2){
            if(UploadPictr($Pictr)){
                $sql="INSERT INTO news(name,discription,image,theme,version_type,publisher,status) VALUES ('".$title."','".$disc."','".$Pictr."',".$_REQUEST['type'].",".$_POST['version_type'].",".$_SESSION['auth'].",'2')";
                if($this->db->query($sql)){
                    header("Location: /Game/");
                    exit;
                }
                else{
                    echo($sql);
                }
            }
        }
    }
}


if (isset($_POST['editpublic'])) {
    $errors = PublicationValid();
    if (!$errors) {
        $errors = complete();
    }
    else{
        $_SESSION['errors'] = $errors;
        $_SESSION['post'] = $_POST;
        $_SESSION['post']['type'] = $_REQUEST['type'];

        header("Location:".$_SESSION['last_link']);
        exit;
    }
    if(isset($_FILES)){
        $sql = "SELECT * FROM publics WHERE id = {$_REQUEST['id']}";
        $rows = $this->db->queryRow($sql);
      
        $Pictr = $_FILES['pictr']['name'];
        $tmpp = explode('.', $Pictr);
        $tmpp = end($tmpp);
        if($tmpp){
            $Pictr = uniqid().'.'.$tmpp;
            UploadPictr($Pictr);
        }

        $File = $_FILES['file']['name'];
        $tmpf = explode('.', $File);
        $tmpf = end($tmpf);
        if($tmpf){
            $File = uniqid().'.'.$tmpf;
            UploadFile($File);
        }
        

        $title = str_replace($search, $replace, $_POST['title']); 
        
        $disc = str_replace($search, $replace, $_POST['text']); 

        if($tmpp || $tmpf){

            $sql = "UPDATE publics SET name = '".$title."', discription = '".$disc."'";

            if($tmpp){
                unlink('../Game/images/publicpictrs/'.$rows['image']);
                $sql.=",image = '".$Pictr."'";
            }

            if($tmpf){
                unlink('../Game/images/files/'.$rows['file']);
                $sql.=",file = '".$File."'";
            }

            $sql.=",version_type = '".$_POST['version_type']."',version_id = '".$_POST['version']."',theme = '".$_POST['theme']."' WHERE id = ".$_REQUEST['id'];
           

            if($this->db->query($sql)){
                header("Location: /Game/");
                exit;
            }
            else{
                echo($sql);
            }
        }
        else{
            $sql = "UPDATE publics SET name = '".$title."', discription = '".$disc."',version_type = '".$_POST['version_type']."',version_id = '".$_POST['version']."',theme = '".$_POST['theme']."' WHERE id = ".$_REQUEST['id'];

            if($this->db->query($sql)){
                header("Location: /Game/");
                exit;
            }
            else{
                echo($sql);
            }  
        }
        
    }

}


if (isset($_POST['editnews'])) {
     $errors = PublicationValid();
    if (!$errors) {
        $errors = complete();
    }
    else{
        $_SESSION['errors'] = $errors;
        $_SESSION['post'] = $_POST;
        $_SESSION['post']['type'] = $_REQUEST['type'];

        header("Location:".$_SESSION['last_link']);
        exit;
    }
    if(isset($_FILES)){
        $sql = "SELECT * FROM news WHERE id = {$_REQUEST['id']}";
        $rows = $this->db->queryRow($sql);

        $Pictr = $_FILES['pictr']['name'];
        $tmp = end(explode('.', $Pictr));
        if($tmp){
            $Pictr = uniqid().'.'.$tmp;
            UploadPictr($Pictr);
        }
        
        $title = str_replace($search, $replace, $_POST['title']); 
        
        $disc = str_replace($search, $replace, $_POST['text']); 

       
        
        if($tmp){

            $sql = "UPDATE news SET name = '".$title."', discription = '".$disc."'";

            if($tmp){
                if($rows['image'] != 'siteLogo.png')
                    unlink('../Game/images/newspictrs/'.$rows['image']);
                $sql.=",image = '".$Pictr."'";
            }

            $add = '';
            if(isset($_POST['version_type'])){
                $add = ",version_type = ".$_POST['version_type'];
            }
            $sql .= $add." WHERE id = ".$_REQUEST['id'];

            if($this->db->query($sql)){
                header("Location: /Game/");
                exit;
            }
            else{
                echo($sql);
            }
        }
        else{
            $add = '';
            if(isset($_POST['version_type'])){
                $add = ",version_type = ".$_POST['version_type'];
            }
            $sql = "UPDATE news SET name = '".$title."', discription = '".$disc."'".$add." WHERE id = ".$_REQUEST['id'];

            if($this->db->query($sql)){
                header("Location: /Game/");
                exit;
            }
            else{
                echo($sql);
            }
        }
        
    }

}