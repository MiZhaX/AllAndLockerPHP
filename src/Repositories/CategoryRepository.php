<?php 

namespace Repositories;
use Lib\BaseDatos;
use Models\Category;

use PDOException;
use PDO;

class CategoryRepository{
    private BaseDatos $conexion;

    public function __construct() {
        $this->conexion = new BaseDatos();
    }

    public function getAllCategories():array {
        try{
            $select = $this->conexion->prepare("SELECT * FROM categorias");
            $select->execute();
            $categories = $select->fetchAll(PDO::FETCH_ASSOC);
            return $categories;
        }
        catch (PDOException $e){
            echo ("Error al obtener los productos: ".$e->getMessage());
            return [];
        }finally{
            if(isset($select)){
                $select->closeCursor();
            }
        }
    }

    public function save(Category $category):bool {
        try{
            $insert = $this->conexion->prepare("INSERT INTO categorias (nombre) VALUES (:nombre)");

            $insert->bindValue(':nombre', $category->getName(), PDO::PARAM_STR);
            $insert->execute();
            return true;
        }
        catch (PDOException $e){
            echo ("Error al agregar un producto: ".$e->getMessage());
            return false;
        }finally{
            if(isset($insert)){
                $insert->closeCursor();
            }
        }
        
    }
}

