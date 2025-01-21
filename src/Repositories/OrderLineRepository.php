<?php 

namespace Repositories;
use Lib\BaseDatos;
use Models\OrderLine;

use PDOException;
use PDO;

class OrderLineRepository {
    private BaseDatos $conexion;

    public function __construct() {
        $this->conexion = new BaseDatos();
    }

    // Guardar una línea de pedido
    public function save(OrderLine $orderLine): bool {
        try {
            $insert = $this->conexion->prepare("INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) VALUES (:pedido_id, :producto_id, :unidades)");
            $insert->bindValue(':pedido_id', $orderLine->getPedidoId(), PDO::PARAM_INT);
            $insert->bindValue(':producto_id', $orderLine->getProductoId(), PDO::PARAM_INT);
            $insert->bindValue(':unidades', $orderLine->getUnidades(), PDO::PARAM_INT);

            $insert->execute();
            return true;
        } catch (PDOException $e) {
            echo ("Error al agregar una línea en el pedido: " . $e->getMessage());
            return false;
        } finally {
            if (isset($insert)) {
                $insert->closeCursor();
            }
        }
    }
}