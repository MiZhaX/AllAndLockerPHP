<?php

namespace Services;

use Repositories\OrderLineRepository;
use Models\OrderLine;

class OrderLineService {
    private OrderLineRepository $orderLineRepository;
    private OrderLine $orderLine;

    public function __construct() {
        $this->orderLineRepository = new OrderLineRepository();
    }

    public function addOrderLine(OrderLine $orderLine):bool {
        return $this->orderLineRepository->save($orderLine);
    }
}