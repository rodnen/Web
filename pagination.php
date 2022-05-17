<?php
class Pagination
{
    private $options = [];
    public function __construct($options) {
        $this->options = $options;
    }

    public function GetPages() {
        $pages = 0;
        if ($this->options['rows'] > 0) {
            $pages = ceil($this->options['rows']/ $this->options['limit']) ;
        }
        return $pages;
    }

    public function GetFirstRow() {
        return ($this->GetPage() - 1) * $this->GetLimit();
    }

    public function GetLimit() {
        return $this->options['limit'];
    }

    public function GetPage() {
        if ($this->GetPages() < 1) return 1;
        if ($this->options['page'] > $this->GetPages()) {
            return $this->GetPages();
        }
        return $this->options['page'];
    }


    public function BuildParams() {
        if (!isset($this->options['params']) || !$this->options['params']) {
            return '';
        }
        return http_build_query($this->options['params']);
    }
    public function show()
    {
        $page = $this->GetPage(); //200
        $pages = $this->GetPages();
        $limitPages = $this->options['limitPages'];
        $str = '';
        $first = $page - (int)($limitPages / 2);
        if ($first < 1) $first = 1;
        $last = $first + $limitPages - 1;
        $next = $page + 1;
        $pre = $page -1;
        $n = "<i class='bx bx-chevron-right'></i>";
        $p = "<i class='bx bx-chevron-left'></i>";
        $arrow_l="<i class='bx bx-chevrons-left'></i>";
        $arrow_r="<i class='bx bx-chevrons-right'></i>";

        if ($last > $pages) {
            $last = $pages;
            $first = $last - $limitPages + 1;
            if ($first < 1) $first = 1;
        }
        if($page>1){
            $str ="<a href=?page=1&" .$this->BuildParams().">".$arrow_l."</a>"."<a href=?page={$pre}&" .$this->BuildParams().">".$p."</a>";
        }
        
        for($i=$first; $i <= $last; $i++) {
            if ($i == $page) {
                $str .= "<a id='active' class='active' href='?page={$i}&".$this->BuildParams()."'>{$i}</a>";
            } else {
                $str .= "<a href='?page={$i}&".$this->BuildParams()."'>{$i}</a>";
            }
        }
        if ($last != $page) {
            $str .="<a href=?page={$next}&" .$this->BuildParams().">".$n."</a>"." <a href=?page={$pages}&" .$this->BuildParams().">".$arrow_r."</a>";
        }
        return $str;
    }
}
