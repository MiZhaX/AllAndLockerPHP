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

    public function addOrder(Order $order):bool {
        return $this->orderRepository->save($order);
    }

    public function lastInsertId():int {
        return $this->orderRepository->lastInsertId();
    }

    public function getOrdersByUserId(int $orderId){
        return $this->orderRepository->getOrdersByUserId($orderId);
    }

    public function getOrderById(int $orderId){
        return $this->orderRepository->getOrderById($orderId);
    }
}