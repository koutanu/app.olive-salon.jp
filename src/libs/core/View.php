<?php

class View
{

    function __construct()
    {
    }

    /**
     * 
     * @param string $class Class file name
     * @param string $method Action method name
     * @param string $title Title
     */
    public function render($class, $method, $title, $name = '')
    {
        $this->class = $class; //クラス名-Class name
        $this->method = $method; //メソッド名-Method name
        $this->title = $title; //タイトル-Title
        $this->j_class = $name; //日本語クラス名-Japanese class name
        // $this->sidemenu = file_get_contents(VIEWS . 'sidemenu.php');
        //$this->links = Menu::getLinks();
        if ($method == 'refer') {
            $limit = 30;
            $expires = gmdate("D, d M Y H:i:s", time() + $limit) . " GMT";
            header("Expires: $expires");
            header("Pragma: cache");
            header("Cache-Control: max-age= $limit");
        }
        switch ($class) {
            case 'login':
                require VIEWS . 'head.php';
                require VIEWS . 'header_omit_wrapper.php';
                if ($class != 'failure') {
                    require VIEWS . $class . '/' . $method . '.php';
                } else {
                    require VIEWS . 'failure/index.php';
                }
                require VIEWS . 'footer_omit_wrapper.php';
                break;
            default:
                require VIEWS . 'head.php';
                require VIEWS . 'header.php';
                require VIEWS . 'sidemenu.php';
                if ($class != 'failure') {
                    require VIEWS . $class . '/' . $method . '.php';
                } else {
                    require VIEWS . 'failure/index.php';
                }
                require VIEWS . 'footer.php';
                break;
        }
    }

    public function failure($class, $title, $name = '')
    {
        $this->class = $class; //クラス名-Class name
        $this->title = $title; //タイトル-Title
        $this->j_class = $name; //日本語クラス名-Japanese class name
        //$this->links = Menu::getLinks();
        switch ($class) {
            default:
                require VIEWS . 'head.php';
                require VIEWS . 'header.php';
                require VIEWS . 'failure/index.php';
                require VIEWS . 'footer.php';
                break;
        }
    }
}
