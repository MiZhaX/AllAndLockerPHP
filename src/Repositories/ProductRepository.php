<?php 

namespace Repositories;
use Lib\BaseDatos;
use Models\Product;

use PDOException;
use PDO;

class ProductRepository{
    private BaseDatos $conexion;

    public function __construct() {
        $this->conexion = new BaseDatos();
    }

    // Obtener todos los productos
    public function getAllProducts():array {
        try{
            $select = $this->conexion->prepare("SELECT * FROM productos");
            $select->execute();
            $products = $select->fetchAll(PDO::FETCH_ASSOC);
            return $products;
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

    // Guardar un producto
    public function save(Product $product):bool {
        try{
            $insert = $this->conexion->prepare("INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES (:categoria_id, :nombre, :descripcion, :precio, :stock, :oferta, :fecha, :imagen)");

            $insert->bindValue(':categoria_id', $product->getCategory_id(), PDO::PARAM_INT);
            $insert->bindValue(':nombre', $product->getName(), PDO::PARAM_STR);
            $insert->bindValue(':descripcion', $product->getDescription(), PDO::PARAM_STR);
            $insert->bindValue(':precio', $product->getPrice(), PDO::PARAM_STR);
            $insert->bindValue(':stock', $product->getStock(), PDO::PARAM_STR);
            $insert->bindValue(':oferta', $product->getOferta(), PDO::PARAM_STR);
            $insert->bindValue(':fecha', $product->getDate(), PDO::PARAM_STR);
            $insert->bindValue(':imagen', $product->getImage(), PDO::PARAM_STR);
            
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

    // Obtener un producto por su ID
    public function getProductById(int $id):Product|bool {
        try{
            $query = $this->conexion->prepare("SELECT * FROM productos WHERE id = :id");
            $query->bindValue(":id", $id, PDO::PARAM_INT);
            $query->execute();
            $datos = $query->fetch(PDO::FETCH_ASSOC);

            if(!$datos){
                return false;
            } else {
                $usuario = Product::fromArray($datos);
                
                return $usuario;
            }

        }catch(PDOException $e){
            error_log("Error al obtener el producto: ".$e->getMessage());
            return false;
        }finally{
            if(isset($query)){
                $query->closeCursor();
            }
        }
    }

    // Obtener todos los productos de una categoría
    public function getProductByCategory(int $categoryId):array {
        try{
            $query = $this->conexion->prepare("SELECT * FROM productos WHERE categoria_id = :id");
            $query->bindValue(":id", $categoryId, PDO::PARAM_INT);
            $query->execute();
            $products = $query->fetchAll(PDO::FETCH_ASSOC);
            return $products;            
        }catch (PDOException $e){
            echo ("Error al obtener los productos: ".$e->getMessage());
            return [];
        }finally{
            if(isset($select)){
                $select->closeCursor();
            }
        }
    }

    // Actualizar un producto
    public function update(Product $product): bool {
        try {
            $update = $this->conexion->prepare("UPDATE productos SET categoria_id = :categoria_id, nombre = :nombre, descripcion = :descripcion, precio = :precio, stock = :stock, oferta = :oferta, fecha = :fecha, imagen = :imagen WHERE id = :id");

            $update->bindValue(':categoria_id', $product->getCategory_id(), PDO::PARAM_INT);
            $update->bindValue(':nombre', $product->getName(), PDO::PARAM_STR);
            $update->bindValue(':descripcion', $product->getDescription(), PDO::PARAM_STR);
            $update->bindValue(':precio', $product->getPrice(), PDO::PARAM_STR);
            $update->bindValue(':stock', $product->getStock(), PDO::PARAM_STR);
            $update->bindValue(':oferta', $product->getOferta(), PDO::PARAM_STR);
            $update->bindValue(':fecha', $product->getDate(), PDO::PARAM_STR);
            $update->bindValue(':imagen', $product->getImage(), PDO::PARAM_STR);
            $update->bindValue(':id', $product->getId(), PDO::PARAM_INT);

            $update->execute();
            return true;
        } catch (PDOException $e) {
            echo ("Error al actualizar el producto: " . $e->getMessage());
            return false;
        } finally {
            if (isset($update)) {
                $update->closeCursor();
            }
        }
    }

    // Borrar un producto
    public function delete(int $id): bool {
        try {
            $delete = $this->conexion->prepare("DELETE FROM productos WHERE id = :id");
            $delete->bindValue(":id", $id, PDO::PARAM_INT);
            $delete->execute();
            return true;
        } catch (PDOException $e) {
            echo ("Error al eliminar el producto: " . $e->getMessage());
            return false;
        } finally {
            if (isset($delete)) {
                $delete->closeCursor();
            }
        }
    }
}

