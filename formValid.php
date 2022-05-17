<?php
function NameValid($option){
    $errors = [];
    $name = htmlspecialchars($option);
    if (iconv_strlen($name)<2) {
        $errors['name'] = "Ім'я не може бути коротшим 2-х символів";
    }
    elseif (iconv_strlen($name)>30) {
         $errors['name'] = 'Максимальна довжина імені 30 символів';
    } 

    elseif (preg_match('/\s/i', $_POST['name'])) {
        $errors['name'] = 'В імені не повинно бути відступу';
    }
    
    return $errors;
   
}

function MailValid($option){
    $errors = [];
    if (preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $option)) {
        return $errors;
    }else{
        $errors['mail']="Пошта вказана не вірно";
        return $errors;
    }    
}
function PassValid($option1,$option2){
    $errors = [];
    if (isset($option1)) {
        if(isset($option2)){
            if ($option1 == $option2 && iconv_strlen($option1)>=8) {
                return $errors;
            }
            if($option1 != $option2){
                $errors['password'] = 'Паролі відрізняються';
            }
            if(iconv_strlen($option1)<8){
                $errors['password'] = 'Мінімальна довжина паролю 8 символів';
            }
        }
        else{
            if(iconv_strlen($option1)<8){
                $errors['password'] = 'Мінімальна довжина паролю 8 символів';
                return $errors;    
            }
            else{
                return $errors;        
            }
        }
        return $errors;
    }
}

function ChangePassValid($option1,$option2){
    $errors = [];
    if (isset($option1)) {
        if(isset($option2)){
            if ($option1 != $option2 && iconv_strlen($option2)>=8) {
                return $errors;
            }
            if($option1 == $option2){
                $errors['password'] = 'Паролі однакові';
            }
            if(iconv_strlen($option2) < 8  &&  iconv_strlen($option2) > 0){
                $errors['npassword'] = 'Мінімальна довжина нового паролю 8 символів';
            }
        }
        return $errors;
    }
}

function BioValid($option,$limit){
    $errors = [];
    if (isset($option)) {
        if(iconv_strlen($option) > $limit){
            $errors['bio']="Опис більше ".$limit." символів";
        }

        if(iconv_strlen($option) < 3){
            $errors['bio']="Опис менше 3-х символів";
        }
    }
        return $errors;
}

function TitleValid($option,$limit){
    $errors = [];
    if (isset($option)) {
        if(iconv_strlen($option) > $limit){
            $errors['title']="Назва більша ".$limit." символів";
        }

        if(iconv_strlen($option) < 3){
            $errors['title']="Назва менша 3-х символів";
        }
    }
        return $errors;
}

function SelectValid($option,$type){
    $errors = [];
    if (isset($option)) {
        switch($type){
            case 1:if($option == 0){$errors['theme'] = 'Оберіть пункт';}break;
            case 2:if($option == 0){$errors['version'] = 'Оберіть пункт';}break;
            case 3:if($option == 0){$errors['version_type'] = 'Оберіть пункт';}break;
            //case 4:if($option == 0){$errors[''] = 'Оберіть пункт';}break;

        }
    }
        return $errors;
}


function FilesValid($option,$type){
    $errors = [];
    if(strlen($option['pictr']['size']) == 0 || strlen($option['file']['size']) == 0){
        switch($type){
            case 1:if(strlen($option['pictr']['size']) == 0)$errors['pictr'] = 'Додайте зображення';break;
            case 2:if(strlen($option['file']['size']) == 0)$errors['file'] = 'Додайте файл';break;
        }
    }
        return $errors;
}


function RegisterValid(){
    $errors=[];
    $errors += NameValid($_POST['name']);
    $errors += MailValid($_POST['mail']);
    $errors += PassValid($_POST['password'],$_POST['rpassword']);

    return $errors;
}

function EditProfile(){
    $errors=[];
    $errors += NameValid($_SESSION['data'][0]);
    $errors += MailValid($_SESSION['data'][1]);
    $errors += BioValid($_SESSION['data'][2],50);
    if($_POST['password']){
        $errors+=ChangePassValid($_POST['password'],$_POST['newpassword']);
    }
    return $errors;
}

function PublicationValid(){
    $errors=[];
    $errors += TitleValid($_POST['title'],100);
    $errors += BioValid($_POST['text'],500);
    if (isset($_POST['theme'])) {
        $errors += SelectValid($_POST['theme'],1);
    }
    if (isset($_POST['version'])) {
        $errors += SelectValid($_POST['version'],2);
    }
    if (isset($_POST['version_type'])) {
        $errors += SelectValid($_POST['version_type'],3);
    }
    if (isset($_FILES['pictr'])) {
        $errors += FilesValid($_FILES,1);
    }
    if (isset($_FILES['file'])) {
        $errors += FilesValid($_FILES,2);
    }
    
   
    

    return $errors;
}

function complete() {

    return [];
}
