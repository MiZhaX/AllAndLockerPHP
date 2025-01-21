<?php

namespace Services;

use Repositories\OrderRepository;
use Models\Order;

class OrderService {
    private OrderRepository $orderRepository;
    private Order $pedido;

    public function __construct() {
        $this->orderRepository = new OrderRepository();
    }

    // Guardar un pedido
    public function addOrder(Order $order):bool {
        return $this->orderRepository->save($order);
    }

    // Obtener el id del último pedido insertado
    public function lastInsertId():int {
        return $this->orderRepository->lastInsertId();
    }

    // Obtener todos los pedidos de un usuario
    public function getOrdersByUserId(int $orderId){
        return $this->orderRepository->getOrdersByUserId($orderId);
    }

    // Obtener un pedido por su id
    public function getOrderById(int $orderId){
        return $this->orderRepository->getOrderById($orderId);
    }
}