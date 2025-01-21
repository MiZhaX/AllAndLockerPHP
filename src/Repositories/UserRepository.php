<?php 
namespace Repositories;
use Lib\BaseDatos;
use Models\User;

use PDOException;
use PDO;

class UserRepository{
    private BaseDatos $conexion;

    public function __construct() {
        $this->conexion = new BaseDatos();
    }

    public function save(User $user){
        try{
            $insert = $this->conexion->prepare("INSERT INTO usuarios (nombre, apellidos, email, password, rol) 
            VALUES(:nombre, :apellido, :email, :password, :rol)");

            $insert->bindValue(":nombre", $user->getNombre(), PDO::PARAM_STR);
            $insert->bindValue(":apellido", $user->getApellido(), PDO::PARAM_STR);
            $insert->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
            $insert->bindValue(":password", $user->getPassword(), PDO::PARAM_STR);
            $insert->bindValue(":rol", $user->getRole(), PDO::PARAM_STR);

            $insert->execute();
            return true;
        }catch(PDOException $e){
            error_log("Error al crear el usuario: ".$e->getMessage());
            return false;
        }finally{
            if(isset($insert)){
                $insert->closeCursor();
            }
        }
    }

    public function getUserByEmail(string $email):User|bool {
        try{
            $query = $this->conexion->prepare("SELECT * FROM usuarios WHERE email = :email");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->execute();

            $datos = $query->fetch(PDO::FETCH_ASSOC);

            if(!$datos){
                return false;
            } else {
                $usuario = User::fromArray($datos);
                
                return $usuario;
            }

        }catch(PDOException $e){
            error_log("Error al obtener el usuario: ".$e->getMessage());
            return false;
        }finally{
            if(isset($query)){
                $query->closeCursor();
            }
        }
    }
}

?>