<?php

namespace Controllers;

use Models\Order;
use Lib\Pages;
use Services\OrderService;

class OrderController
{
    private Pages $pages;
    private OrderService $orderService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->orderService = new OrderService();
    }

    public function purchaseForm()
    {
        if(isset($_SESSION['user'])){
            if ((isset($_SESSION['cart']) && count($_SESSION['cart']) > 0)) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->pages->render('Order/purchaseForm');
                }
            } else {
                $_SESSION['mensaje'] = "El carrito está vacío";
                header('Location: ' . BASE_URL .'viewCart');
            }
        } else {
            $_SESSION['mensaje'] = "Debes iniciar sesión primero";
            header('Location: ' . BASE_URL .'login');
        }
    }

    public function finishOrder()
    {
        if ((isset($_SESSION['cart']) && count($_SESSION['cart']) > 0)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($_POST['data']) {

                    $precioTotalCarrito = 0;
                    foreach ($_SESSION['cart'] as $product) {
                        $precioTotalCarrito += $product['precio_total'];
                    }

                    $order = new Order(
                        null,
                        $_SESSION['user']['id'],
                        $_POST['data']['provincia'],
                        $_POST['data']['localidad'],
                        $_POST['data']['direccion'],
                        $precioTotalCarrito,
                        'confirmado',
                        date('Y-m-d'),
                        date('H:i:s')
                    );

                    $order->sanitize();
                    if ($order->validate()) {
                        $this->orderService->addOrder($order);
                    }else{
                        $_SESSION['errors'] = $order->getErrores();
                        header('Location: '. BASE_URL .'purchaseForm');
                    }
                } else {
                    $_SESSION['errors'] = 'Error al obtener los datos de envío';
                }
            } else {
                $this->pages->render('Order/purchaseForm');
            }
        } else {
            $_SESSION['mensaje'] = "El carrito está vacío";
            header('Location: ' . BASE_URL);
        }
    }

    public function myOrders(){
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $orders = $this->orderService->getOrdersByUserId($userId);
            $this->pages->render('Order/myOrders', ['orders' => $orders]);
        } else {
            $_SESSION['mensaje'] = "Debes iniciar sesión primero";
            header('Location: ' . BASE_URL . 'login');
        }
    }
}
