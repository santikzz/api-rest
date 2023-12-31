<?php

require_once "./view/api.view.php";

abstract class APIController{
    protected $view;
    private $data;

    protected function __construct(){
        $this->view = new APIView();
        $this->data = file_get_contents("php://input");
    }

    protected function getData(){
        parse_str($this->data, $data);
        return $data;
    }

}