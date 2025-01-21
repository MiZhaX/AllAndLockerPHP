<?php 

namespace Repositories;
use Lib\BaseDatos;
use Models\Order;

use PDOException;
use PDO;

class OrderRepository {
    private BaseDatos $conexion;

    public function __construct() {
        $this->conexion = new BaseDatos();
    }

    // Guardar un pedido
    public function save(Order $pedido): bool {
        try {
            $insert = $this->conexion->prepare("INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES (:usuario_id, :provincia, :localidad, :direccion, :coste, :estado, :fecha, :hora)");

            $insert->bindValue(':usuario_id', $pedido->getUsuarioId(), PDO::PARAM_INT);
            $insert->bindValue(':provincia', $pedido->getProvincia(), PDO::PARAM_STR);
            $insert->bindValue(':localidad', $pedido->getLocalidad(), PDO::PARAM_STR);
            $insert->bindValue(':direccion', $pedido->getDireccion(), PDO::PARAM_STR);
            $insert->bindValue(':coste', $pedido->getCoste(), PDO::PARAM_STR);
            $insert->bindValue(':estado', $pedido->getEstado(), PDO::PARAM_STR);
            $insert->bindValue(':fecha', $pedido->getFecha(), PDO::PARAM_STR);
            $insert->bindValue(':hora', $pedido->getHora(), PDO::PARAM_STR);

            $insert->execute();

            $_SESSION['ultimoId'] = $this->lastInsertId();
            return true;
        } catch (PDOException $e) {
            echo ("Error al agregar un pedido: " . $e->getMessage());
            return false;
        } finally {
            if (isset($insert)) {
                $insert->closeCursor();
            }
        }
    }

    // Obtener el ID del último pedido insertado
    public function lastInsertId(): int
    {
        return $this->conexion->lastInsertId();
    }

    // Obtener todos los pedidos de un usuario
    public function getOrdersByUserID(int $userID): array {
        try {
            $query = $this->conexion->prepare("SELECT * FROM pedidos WHERE usuario_id = :usuario_id");
            $query->bindValue(':usuario_id', $userID, PDO::PARAM_INT);
            $query->execute();

            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo ("Error al obtener pedidos por usuario: " . $e->getMessage());
            return [];
        } finally {
            if (isset($query)) {
                $query->closeCursor();
            }
        }
    }

    public function getOrderById(int $orderId): ?array {
        try {
            $query = $this->conexion->prepare("SELECT * FROM pedidos WHERE id = :id");
            $query->bindValue(':id', $orderId, PDO::PARAM_INT);
            $query->execute();

            $order = $query->fetch(PDO::FETCH_ASSOC);
            return $order;
        } catch (PDOException $e) {
            echo ("Error al obtener el pedido por ID: " . $e->getMessage());
            return null;
        } finally {
            if (isset($query)) {
                $query->closeCursor();
            }
        }
    }
}