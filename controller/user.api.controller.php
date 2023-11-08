<?php

require_once './controller/api.controller.php';
require_once './helper/api.auth.helper.php';
require_once './model/user.model.php';

class UserAPIController extends APIController
{
    private $model;
    private $auth;

    function __construct()
    {
        parent::__construct();
        $this->model = new UserModel();
        $this->auth = new APIAuthHelper();
    }

    function getToken($params = [])
    {
        $basic = $this->auth->getAuthHeaders();
        
        if (empty($basic)) {
            $this->view->response(["error" => "authorization headers not found"], 401);
            return;
        }

        $basic = explode(" ", $basic);

        if ($basic[0] != "Basic") {
            $this->view->response(["error" => "invalid authorization headers"], 401);
            return;
        }

        $encoded_data = base64_decode($basic[1]);
        $encoded_data = explode(":", $encoded_data);

        $username = $encoded_data[0];
        $password = $encoded_data[1];

        $userdata = $this->model->getUser($username);

        if ($userdata->username === $username && password_verify($password, $userdata->password)) {
            $token = $this->auth->createJWTToken(["userid" => $userdata->id, "username" => $userdata->username, "isAdmin" => $userdata->isAdmin]);
            $this->view->response(["token" => $token], 200);
        } else {
            $this->view->response(["error" => "invalid username or password"], 0);
        }


    }
}

