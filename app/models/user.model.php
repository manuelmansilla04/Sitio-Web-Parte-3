<?php

class UserModel {
    private $db;

    function __construct() {
        // 1. abro conexión con la DB
        $this->db = new PDO('mysql:host=localhost;dbname=base_aromatica;charset=utf8', 'root', '');
    }

    public function get($id) {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE ID = ?');
        $query->execute([$id]);
        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }

    public function getByUser($user) {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE user_name = ?');
        $query->execute([$user]);
        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }
    
    public function getAll() {
        // 2. ejecuto la consulta SQL (SELECT * FROM tareas)
        $query = $this->db->prepare('SELECT * FROM usuarios');
        $query->execute();

        // 3. obtengo los resultados de la consulta
        $users = $query->fetchAll(PDO::FETCH_OBJ);

        return $users;
    }

    function insert($name, $password) {
        $query = $this->db->prepare("INSERT INTO usuarios(user_name, password) VALUES(?,?)");
        $query->execute([$name, $password]);

        // var_dump($query->errorInfo());

        return $this->db->lastInsertId();
    }
}
