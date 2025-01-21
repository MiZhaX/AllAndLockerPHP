<?php

namespace Controllers;

use Exception;
use Models\OrderLine;
use Lib\Pages;
use Lib\PHPMail;
use Lib\PDF;
use Services\OrderLineService;
use Services\OrderService;

class OrderLineController
{
    private Pages $pages;
    private PHPMail $phpMail;
    private PDF $pdf;
    private OrderLineService $orderLineService;
    private OrderService $orderService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->phpMail = new PHPMail();
        $this->pdf = new PDF();
        $this->orderLineService = new OrderLineService();
        $this->orderService = new OrderService();
    }

    public function finishOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
            $orderId = $_SESSION['ultimoId'];
            try {
                foreach ($cart as $product) {
                    $orderLine = new OrderLine(
                        null,
                        $orderId,
                        $product['id'],
                        $product['quantity']
                    );

                    $orderLine->sanitize();
                    if ($orderLine->validate()) {
                        $this->orderLineService->addOrderLine($orderLine);
                    } else {
                        $_SESSION['mensaje'] = "Algo fallo en el proceso";
                        header('Location: ' . BASE_URL . 'viewCart');
                    }
                }

                $pedido = $this->orderService->getOrderById($_SESSION['ultimoId']);

                $archivoPDF = $this->pdf->generarPDF($pedido);

                $asunto = "Pedido de All&Locker";
                $mensaje = "<p>Gracias por realizar una pedido con nosotros. Aquí tienes el resumen de tu pedido:</p>";
                $mensaje .= "<ul>";
                foreach ($_SESSION['cart'] as $product) {
                    $mensaje .= "<li>{$product['nombre']} - Cantidad: {$product['quantity']} - Precio Total: {$product['precio_total']}€</li>";
                }
                $mensaje .= "</ul>";
                $mensaje .= "<p>¡Gracias por confiar en nosotros!</p>";

                $this->phpMail->enviarCorreo($_SESSION['user']['email'], $asunto, $mensaje, $archivoPDF);

                $_SESSION['mensaje'] = "Pedido realizado con exito";
                $_SESSION['cart'] = [];
                header('Location: ' . BASE_URL);
            } catch (Exception $e) {
                $_SESSION['errors'] = 'Error al procesar el pedido';
                echo $e->getMessage();
            }
        } else {
            $_SESSION['errors'] = 'Carrito no proporcionado';
            header('Location: ' . BASE_URL . 'viewCart');
        }
    }
}
