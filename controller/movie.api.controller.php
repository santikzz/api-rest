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

    public function getMovies($params = [])
    {
        // USER CHECK
        $user = $this->auth->getCurrentUser();
        if (!$user) {
            $this->view->response(["error" => "unauthorized"], 401);
            return;
        }
        if ($user->isAdmin != 1) {
            $this->view->response(["error" => "foribidden"], 403);
            return;
        }

        if (empty($params[":ID"])) { // GET ALL MOVIES

            // GET SORTING ORDER
            $order = null;
            if(isset($_GET["order"])){
                $order = $_GET["order"];
            }

            $movies = $this->model->getMovies($order);
            $this->view->response($movies, 200);

            return;
        
       
        }else{ // GET MOVIE BY ID
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

        $user = $this->auth->getCurrentUser();
        if (!$user) {
            $this->view->response(["error" => "unauthorized"], 401);
            return;
        }

        if ($user->isAdmin != 1) {
            $this->view->response(["error" => "foribidden"], 403);
            return;
        }

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
            $this->view->reponse(["message" => "message':'movie $id deleted successfully"], 200);
        } else {
            $this->view->response(["error" => "movie $id not found"], 404);
        }

    }


    public function createMovie($params = [])
    {

        $body = $_POST;

        $title = $body["title"];
        $author = $body["author"];
        $genre = $body["genre"];
        $image_url = $body["image_url"];

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
        $id = $params[":ID"];
        $movie = $this->model->getMovie($id);

        if ($movie) {
            $data = $this->getData();
            $title = $data->title;
            $author = $data->author;
            $genre_id = $data->genre_id;
            $image_url = $data->image_url;

            $this->model->updateMovie($id, $title, $genre_id, $author, $image_url);

            $this->view->response(["message" => "message':'movie $id updated successfully"], 200);
        } else {
            $this->view->response(["error" => "movie $id not found"], 404);
        }
    }

    public function getGenres($params = [])
    {

        $user = $this->auth->getCurrentUser();
        if (!$user) {
            $this->view->response(["error" => "unauthorized"], 401);
            return;
        }
        if ($user->isAdmin != 1) {
            $this->view->response(["error" => "foribidden"], 403);
            return;
        }

        // GET SORTING ORDER
        $order = null;
        if(isset($_GET["order"])){
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