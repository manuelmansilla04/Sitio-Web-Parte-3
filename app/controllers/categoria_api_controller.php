<?php
    require_once './app/models/categorias.model.php';
    require_once './app/views/api_view.php';
    class CategoriaApiController {
    private $model;

    function __construct() {
        $this->model = new CategoriasModel();
    }

    public function getCategorias($req, $res) {
        $orden = null;
        $atributo = null;
        $filters = [];
        $offset = 0;
        $limit = 10;
        
        if (!empty(((array)$req->query))) {
            if (isset($req->query->nombre)) {
                $filters['nombre'] = $req->query->nombre;
            }
            if (isset($req->query->descripcion)) {
                $filters['descripcion'] = $req->query->descripcion;
            }
        }

        
        //ordenamiento
        if (isset($req->query->orden) && isset($req->query->atributo)) {
            //en caso de venir con mayusculas se transforma a min para evitar errores
            $orden = strtolower($req->query->orden);
            $atributo = strtolower($req->query->atributo); 
            $allowedAttrs = ['nombre','descripcion'];
            if (!in_array($atributo,$allowedAttrs)) {
                return $res->json("Atributo de ordenamiento erroneo", 400);
            }
            if ($orden !== 'asc' && $orden !== 'desc') {    
                return $res->json("Orden erroneo", 400);
            }
        }
        
        //paginado
        if (isset($req->query->page) && isset($req->query->limit)) {
            if (!is_numeric($req->query->page) && !is_numeric($req->query->limit)) {
                $res->json("los valores no son numericos", 400);
            }
            $offset = ((int)$req->query->page-1) * (int)$req->query->limit;
            $limit = $req->query->limit;
        }
            
        $categorias = $this->model->getCategorias($filters,$orden,$atributo,$offset,$limit);
            
        if (empty($categorias)) {
            return $res->json("No tenemos categorias que coincidan con tu búsqueda", 404);
        }
            
        return $res->json($categorias, 200);
    }

    // /api/categorias/:ID
    public function getCategoriaByID ($req, $res) {
        $id = $req->params->id;
        $categoria = $this->model->getCategoria($id);
        if (!$categoria) {
            return $res->json("La categoría que buscas no existe", 404);
        }
        return $res->json($categoria, 200);
    }

    //POST /api/categoria
    public function addCategoria ($req, $res){
        if (empty($req->body->nombre) || empty($req->body->descripcion) || empty($req->body->img)) {
            return $res->json('Error! Faltan campos obligatorios', 400);
        }
        
        $name = $req->body->nombre;
        $desc = $req->body->descripcion;
        $img = $req->body->img;

        $categoria = $this->model->insertCategoria($name, $desc, $img);

        if (!$categoria) {
            return $res->json('Error! No se pudo insertar la tarea', 500);
        }

        //la devuelvo junto con un mensaje que confirme el exito del post
        return $res->json("La categoria con el id=$categoria fue agregada con exito.", 201);
    }

    //PUT
    public function editCategoria($req, $res){
        $id = $req->params->id;
        if (empty($id)) {
            return $res->json("no existe la categoria", 404);
        }
        if (!isset($req->body)) {
            return $res->json("no existe el req", 400);
        }
        $categoria = $this->model->getCategoria($id);
        if (!$categoria) {
            return $res->json("no existe la categoria", 404);
        }
        
        if (empty($req->body->nombre) || empty($req->body->descripcion) || empty($req->body->img)) {
            return $res->json("hay algun/nos parametro/s vacio/s", 400);
        }
            
        $nombre = $req->body->nombre;
        $descripcion = $req->body->descripcion;
        $img = $req->body->img;

        $this->model->updateCategoria($id,$nombre,$descripcion,$img);
        $categoriaActualizada = $this->model->getCategoria($id);
        return $res->json($categoriaActualizada, 200);
    }
}

?>