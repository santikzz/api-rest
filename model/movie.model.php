<?php

require_once "./database/database.php";

class MovieModel
{

    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getMovies($order = null)
    {   
        // check if sorting order
        $sql_order = "";
        $order = strtoupper($order);
        if($order == "ASC"){
            $sql_order = "ORDER BY p.nombre ASC";
        }
        if($order == "DESC"){
            $sql_order = "ORDER BY p.nombre DESC";
        }

        $stmt = $this->db->prepare("SELECT p.id, p.nombre, p.autor, g.nombre AS 'genero', p.image FROM pelicula p
            LEFT JOIN genero g ON p.id_genero = g.id
            $sql_order
        ");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getMovie($id)
    {
        $stmt = $this->db->prepare("SELECT id, nombre, autor, id_genero, image FROM pelicula WHERE id = :id");
        $stmt->execute(["id" => $id]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function getMoviesGenre($genre_id)
    {
        $stmt = $this->db->prepare("SELECT p.id, p.nombre, p.autor, p.image FROM pelicula p
            LEFT JOIN genero g ON g.id = p.id_genero
            WHERE g.id = :genre_id
        ");
        $stmt->execute(["genre_id" => $genre_id]);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getGenre($id)
    {
        $stmt = $this->db->prepare("SELECT id, nombre FROM genero WHERE id = :id");
        $stmt->execute(["id" => $id]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function getGenreID($name)
    {
        $stmt = $this->db->prepare("SELECT id, nombre FROM genero WHERE nombre = :nombre");
        $stmt->execute(["nombre" => $name]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function getGenres($order = null)
    {

        $sql_order = "";
        $order = strtoupper($order);
        if($order == "ASC"){
            $sql_order = "ORDER BY nombre ASC";
        }
        if($order == "DESC"){
            $sql_order = "ORDER BY nombre DESC";
        }

        $stmt = $this->db->prepare("SELECT id, nombre FROM genero $sql_order");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function addMovie($title, $genre_id, $author, $image)
    {
        $stmt = $this->db->prepare("INSERT INTO `pelicula` (`nombre`, `id_genero`, `autor`, `image` ) VALUES (:nombre, :id_genero, :autor, :imageurl)");
        $stmt->execute(["nombre" => $title, "id_genero" => $genre_id, "autor" => $author, "imageurl" => $image]);
        return $this->db->lastInsertId();
    }

    public function addGenre($nombre)
    {
        $stmt = $this->db->prepare("INSERT INTO `genero` (`nombre`) VALUES (:nombre)");
        $stmt->execute(["nombre" => $nombre]);
        return $this->db->lastInsertId();
    }

    public function deleteGenre($id)
    {
        $stmt = $this->db->prepare("DELETE FROM `genero` WHERE `id` = :id");
        $stmt->execute(["id" => $id]);
    }
    public function deleteMovie($id)
    {
        $stmt = $this->db->prepare("DELETE FROM `pelicula` WHERE `id` = :id");
        $stmt->execute(["id" => $id]);
    }

    public function updateMovie($title, $genre_id, $author, $image, $id)
    {
        $stmt = $this->db->prepare("UPDATE `pelicula` SET `nombre` = :nombre, `id_genero` = :id_genero, `autor` = :autor, `image` = :imageurl WHERE `id` = :id ");
        $stmt->execute(["nombre" => $title, "id_genero" => $genre_id, "autor" => $author, "imageurl" => $image, "id" => $id]);
    }

    public function updateGenre($nombre, $id)
    {
        $stmt = $this->db->prepare("UPDATE `genero` SET `nombre` = :nombre WHERE `id` = :id");
        $stmt->execute(["nombre" => $nombre, "id" => $id]);
    }



}