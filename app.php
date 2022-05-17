<?php
class App {
    public $db;
    public $config;

    public function GetUrl($url) {
        return $this->config['baseurl'].$url;
    }

    public function GetIp() {
      $keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR'
      ];
      foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
          $ip = trim(end(explode(',', $_SERVER[$key])));
          if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
          }
        }
      }
    }

    public function Run($config) {
        $this->config = $config;
        $this->db = new DB($config['db']);
        session_start();
        if (!$this->db->IsConnect()) {
            include('view/header.php');
            $error = $this->db->Error();
            include('view/errors.php');
            include('view/footer.php');
            return;
        }
        $action = false;
        $path = explode('?', $_SERVER['REQUEST_URI'])[0];   
        $path = str_replace('..', '', $path);
        $path = substr($path,strlen($config['basepath'])+1);
        if (!$path) $path = 'home';

        if(stristr($path, "action/") === FALSE){
            $file = "view/pages/".$path.".php";
            $action = false;
        }
        else{
           $file = "view/".$path.".php";
           $action = true;
        }

        if (is_file($file)) {

            if(stristr($_SERVER['HTTP_REFERER'], "action/") === FALSE)
                $_SESSION['last_link'] = $_SERVER['HTTP_REFERER'];
            if(!$action){
                include('view/header.php');
                include($file);
                include("view/footer.php");
            }
            else{
                include($file);
            }
        }

        else {
            include('view/header.php');
            $error ='<div class="flex notFound"><b>ОЙ!</b><span>Строрінку не знайдено</span><span>:(</span></div>';
            include('view/errors.php');
            include('view/footer.php');
        }
    }
}
