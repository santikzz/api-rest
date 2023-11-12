<?php

require_once "./controller/api.controller.php";
require_once "./model/movie.model.php";
require_once "./helper/api.auth.helper.php";

class MovieAPIController extends APIController
{

    private $model;
    private $auth;

    public function __construct()
    {
        parent::__construct();
        $this->model = new MovieModel();
        $this->auth = new APIAuthHelper();
    }

    public function isLoggedIn()
    {
        //USER CHECK
        $user = $this->auth->getCurrentUser();
        if (!$user) {
            $this->view->response(["error" => "unauthorized"], 401);
            return false;
        }
        if ($user->isAdmin != 1) {
            $this->view->response(["error" => "foribidden"], 403);
            return false;
        }
    }

    public function getMovies($params = [])
    {
        if (empty($params[":ID"])) { // GET ALL MOVIES

            $orderby = null;
            $order = null;
            $limit = null;
            $offset = null;

            if (isset($_GET["orderby"])){
                $orderby = $_GET["orderby"];
            }

            if (isset($_GET["order"])){
                $order = $_GET["order"];
            }

            if (isset($_GET["limit"])){
                $limit = $_GET["limit"];
            }

            if (isset($_GET["offset"])){
                $offset = $_GET["offset"];
            }


            $movies = $this->model->getMovies($orderby, $order, $limit, $offset);
            $this->view->response($movies, 200);

            return;


        } else { // GET MOVIE BY ID
            $id = $params[":ID"];
            $movie = $this->model->getMovie($id);
            if (!empty($movie)) {
                $this->view->response($movie, 200);
            } else {
                $this->view->response(["error" => "movie id: ($id) not found"], 404);
            }
            return;
        }

    }

    public function getByGenre($params = [])
    {
        if (empty($params[":GENRE"])) {
            $this->view->response(["error" => "missing parameters"], 404);

        } else {

            $genre = $params[":GENRE"];
            $genre_id = $this->model->getGenreID($genre);

            if ($genre_id) {

                $movie = $this->model->getMoviesGenre($genre_id->id);
                if (!empty($movie)) {
                    $this->view->response($movie, 200);
                }

            } else {
                $this->view->response(["error" => "genre ($genre) not found"], 404);
            }


        }

    }

    public function deleteMovie($params = [])
    {
        $id = $params[':ID'];
        $movie = $this->model->getMovie($id);

        if ($movie) {
            $this->model->deleteMovie($id);
            $this->view->response(["message" => "message':'movie $id deleted successfully"], 200);
        } else {
            $this->view->response(["error" => "movie $id not found"], 404);
        }

    }


    public function createMovie($params = [])
    {
        if(!$this->isLoggedIn()){
            return;
        }

        $data = $this->getData();

        $title = $data["title"];
        $author = $data["author"];
        $genre = $data["genre"];
        $image_url = $data["image_url"];

        if (empty($title) || empty($author) || empty($genre) || empty($image_url)) {
            $this->view->response(["error" => "missing parameters"], 400);

        } else {

            $genre_id = $this->model->getGenreID($genre);

            if ($genre_id) {

                $id = $this->model->addMovie($title, $genre_id->id, $author, $image_url);
                $movie = $this->model->getMovie($id);
                $this->view->response($movie, 200);

            } else {
                $this->view->response(["error" => "invalid genre $genre"], 400);
            }

        }

    }

    public function updateMovie($params = [])
    {
        if(!$this->isLoggedIn()){
            return;
        }

        $data = $this->getData();
        $id = $data["id"];

        $movie = $this->model->getMovie($id);
        if ($movie) {

            $title = $data["title"];
            $author = $data["author"];
            $genre = $data["genre"];
            $image_url = $data["image_url"];

            $genre_id = $this->model->getGenreID($genre);

            if ($genre_id) {

                $this->model->updateMovie($id, $title, $genre_id, $author, $image_url);
                $movie = $this->model->getMovie($id);
                $this->view->response($movie, 200);
            
            }else{
                $this->view->response(["error" => "invalid genre $genre"], 400);
                return;
            }

        } else {
            $this->view->response(["error" => "movie $id not found"], 404);
        }

    }

    public function getGenres($params = [])
    {
        // GET SORTING ORDER
        $order = null;
        if (isset($_GET["order"])) {
            $order = $_GET["order"];
        }

        $genres = $this->model->getGenres($order);
        if (!empty($genres)) {
            $this->view->response($genres, 200);
        } else {
            $this->view->response(["error" => "no genres found"], 404);
        }

    }


}