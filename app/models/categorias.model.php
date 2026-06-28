<?php 

require_once './app/models/model.php';

class CategoriasModel extends Model {
    
    function __construct() {
        parent::__construct();
    }

    function getCategoria ($id) {
        $query = $this->db->prepare('SELECT * FROM categorias WHERE id_categoria=?');
        $query->execute([$id]);
        $categoria = $query->fetch(PDO::FETCH_OBJ);
        return $categoria;
    }
    
    function insertCategoria ($name, $desc, $img) {
        $query = $this->db->prepare('INSERT INTO `categorias` (`nombre`, `descripcion`,`img`) VALUES (?,?,?)');
        $query->execute([$name, $desc, $img]);
        $id = $this->db->lastInsertId();  //pido el id del ultimo insert para poder devolverlo
        return $id;
    }

    function updateCategoria ($id, $name, $desc, $img) {
        $query = $this->db->prepare('UPDATE `categorias` SET nombre = ?, descripcion = ?, img = ? WHERE id_categoria = ?');
        $query->execute([$name, $desc, $img, $id]);
    }

    function deleteCategoria ($id) {
        $query = $this->db->prepare('DELETE FROM `categorias` WHERE id_categoria=?');
        $query->execute([$id]);
    }

    function getCategoriaByName ($name) {
        $query = $this->db->prepare('SELECT * FROM categorias WHERE nombre LIKE ?');
        $query->execute(['%'.$name.'%']);
        $categoria = $query->fetch(PDO::FETCH_OBJ);
        return $categoria;
    }
           
    function getCategorias($filters = [], $orden = '', $atributo = '', $offset = '', $limit = '') {
        $params = [];
        $sql = "SELECT * FROM categorias ";
        $conditions = [];
        foreach ($filters as $filter => $value) {
            if ($filter == 'nombre' || $filter == 'descripcion') {
                $conditions[] = "$filter LIKE ?";
                $params[] = '%' . $value . '%';
            }
        }
        if (!empty($conditions)) {
            $sql .= "WHERE " . implode(" AND ", $conditions) . " ";
        }
        
        if ($orden != null && $atributo != null){
            $sql.= " ORDER BY $atributo $orden";
        }

        //paginado
        if ($limit != null && $limit > 0 && is_numeric($offset)) {
            $sql.= " LIMIT $limit Offset $offset";
        }
        
        $query = $this->db->prepare($sql);
        $query->execute($params);
        $categorias = $query->fetchAll(PDO::FETCH_OBJ);
        return $categorias;
    }

}
