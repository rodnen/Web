<?
function UploadFile($file, $options) {
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

function UpdateUserIcon($filename){
    $err = UploadFile($_FILES['uIcon'], [
    'type' => [
        'image/jpeg','image/jpg','image/png','image/jpeg2000','image/webp'
    ],
    'name' => 'images/userIcons/'.$filename
    ]);

   if(!$err){
        $where = " WHERE id = ".$_REQUEST['id'];
        $sql = "UPDATE users SET icon = '".$filename."'".$where;
        
        return $sql;
    }
}


function UpdateUserHeader($filename){
    $err = UploadFile($_FILES['uHeader'], [
    'type' => [
        'image/jpeg','image/jpg','image/png','image/jpeg2000','image/webp'
    ],
    'name' => 'images/userIcons/'.$filename
    ]);

   if(!$err){
        $where = " WHERE id = ".$_REQUEST['id'];
        $sql = "UPDATE users SET headerpictr = '".$filename."'".$where;
        
        return $sql;
       
    }
}


if (isset($_POST['edit'])) {
    $sql = "SELECT * FROM users WHERE id = {$_REQUEST['id']}";
    $rows = $this->db->queryRow($sql);

    if(!isset($_SESSION['data'])){
        $_SESSION['data'] = array();
    }
    else{
        unset($_SESSION['data']);
        $_SESSION['data'] = array();
    }
        $_SESSION['data'][]=str_replace($search, $replace, $_POST['name']); 
        $_SESSION['data'][]=str_replace($search, $replace, $_POST['mail']); 
        $_SESSION['data'][]=str_replace($search, $replace, $_POST['bio']); 

    if(isset($_FILES)){
        $UserIcon = $_FILES['uIcon']['name'];
        $tmp = end(explode('.', $UserIcon));
        $uIcon = uniqid().'.'.$tmp;

        $UserHeader = $_FILES['uHeader']['name'];
        $tmp = end(explode('.', $UserHeader));
        $uHeader = uniqid().'.'.$tmp;

    
        if (isset($_FILES['uIcon'])) {
            if($this->db->query(UpdateUserIcon($uIcon))){
                if($rows['icon'] != 'baseicon.jpg')
                unlink('../Game/images/userIcons/'.$rows['icon']);
                $_SESSION['icon']=$uIcon;
            }
            else{
                echo(UpdateUserIcon($uIcon));
            }
        }
        if(isset($_FILES['uHeader'])){
           if($this->db->query(UpdateUserHeader($uHeader))){
                if($rows['headerpictr'] != 'DefaultHeader.jpg')
                    unlink('../Game/images/userIcons/'.$rows['headerpictr']);
            }
            else{
                echo(UpdateUserHeader($uHeader));
            }
        }

        else{
            echo(UpdateUserIcon($uIcon));
            echo(UpdateUserHeader($uHeader));
        }
        header("Location: /Game/user/edit?id=".$_SESSION['auth']);
        exit;
    }

    else{
        header("Location: /Game/user/edit?id=".$_SESSION['auth']);
        exit;
    }
}