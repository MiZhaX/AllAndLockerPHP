<?php

namespace Controllers;

use Exception;
use Models\Order;
use Models\OrderLine;
use Lib\Pages;
use Lib\PHPMail;
use Lib\PDF;
use Services\OrderLineService;
use Services\ProductService;
use Services\OrderService;

class OrderController
{
    private Pages $pages;
    private PHPMail $phpMail;
    private PDF $pdf;
    private OrderLineService $orderLineService;
    private ProductService $productService;
    private OrderService $orderService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->phpMail = new PHPMail();
        $this->pdf = new PDF();
        $this->orderLineService = new OrderLineService();
        $this->productService = new ProductService();
        $this->orderService = new OrderService();
    }

    public function purchaseForm()
    {
        if (isset($_SESSION['user'])) {
            if ((isset($_SESSION['cart']) && count($_SESSION['cart']) > 0)) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Mostrar formulario de compra
                    $this->pages->render('Order/purchaseForm');
                }
            } else {
                $_SESSION['mensaje'] = "El carrito está vacío";
                header('Location: ' . BASE_URL . 'viewCart');
            }
        } else {
            $_SESSION['mensaje'] = "Debes iniciar sesión primero";
            header('Location: ' . BASE_URL . 'login');
        }
    }

    public function finishOrder()
    {
        // Verificar si el carrito tiene productos
        if ((isset($_SESSION['cart']) && count($_SESSION['cart']) > 0)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($_POST['data']) {
                    $precioTotalCarrito = 0;
                    // Calcular el precio total del carrito
                    foreach ($_SESSION['cart'] as $product) {
                        $precioTotalCarrito += $product['precio_total'];
                    }

                    // Crear una nueva orden
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

                    // Sanitizar y validar la orden
                    $order->sanitize();
                    if ($order->validate()) {
                        $this->orderService->addOrder($order);
                    } else {
                        $_SESSION['errors'] = $order->getErrores();
                        $this->pages->render('Order/purchaseForm');
                        exit();
                    }
                } else {
                    $_SESSION['errors'] = 'Error al obtener los datos de envío';
                }
                
                $cart = $_SESSION['cart'];
                $orderId = $_SESSION['ultimoId'];
                try {
                    // Procesar cada producto en el carrito
                    foreach ($cart as $product) {
                        // Obtener el producto por su ID
                        $producto = $this->productService->getProductById($product['id']);
                        if ($producto) {
                            // Actualizar el stock del producto
                            $newStock = $producto->getStock() - $product['quantity'];
                            if ($newStock >= 0) {
                                $producto->setStock($newStock);
                                $this->productService->updateProduct($producto);
                            } else {
                                $_SESSION['errors'] = 'Stock insuficiente para el producto: ' . $producto->getName();
                                header('Location: ' . BASE_URL . 'viewCart');
                                return;
                            }
                        } else {
                            $_SESSION['errors'] = 'Producto no encontrado';
                            header('Location: ' . BASE_URL . 'viewCart');
                            return;
                        }

                        // Crear una nueva línea de pedido
                        $orderLine = new OrderLine(
                            null,
                            $orderId,
                            $product['id'],
                            $product['quantity']
                        );

                        // Sanitizar y validar la línea de pedido
                        $orderLine->sanitize();
                        if ($orderLine->validate()) {
                            $this->orderLineService->addOrderLine($orderLine);
                        } else {
                            $_SESSION['mensaje'] = "Algo fallo en el proceso";
                            header('Location: ' . BASE_URL . 'viewCart');
                        }
                    }

                    // Obtener el pedido recién creado
                    $pedido = $this->orderService->getOrderById($_SESSION['ultimoId']);

                    // Generar el archivo PDF del pedido
                    $archivoPDF = $this->pdf->generarPDF($pedido);

                    // Preparar el correo electrónico
                    $asunto = "Pedido de All&Locker";
                    $mensaje = "<p>Gracias por realizar una pedido con nosotros. Aquí tienes el resumen de tu pedido:</p>";
                    $mensaje .= "<ul>";
                    foreach ($_SESSION['cart'] as $product) {
                        $mensaje .= "<li>{$product['nombre']} - Cantidad: {$product['quantity']} - Precio Total: {$product['precio_total']}€</li>";
                    }
                    $mensaje .= "</ul>";
                    $mensaje .= "<p>¡Gracias por confiar en nosotros!</p>";

                    // Enviar el correo electrónico con el PDF adjunto
                    $this->phpMail->enviarCorreo($_SESSION['user']['email'], $asunto, $mensaje, $archivoPDF);

                    // Limpiar el carrito y redirigir al usuario
                    $_SESSION['mensaje'] = "Pedido realizado con exito";
                    $_SESSION['cart'] = [];
                    header('Location: ' . BASE_URL);
                } catch (Exception $e) {
                    $_SESSION['errors'] = 'Error al procesar el pedido';
                    echo $e->getMessage();
                }
            } else {
                // Mostrar el formulario de compra si no es una solicitud POST
                $this->pages->render('Order/purchaseForm');
            }
        } else {
            // Redirigir si el carrito está vacío
            $_SESSION['mensaje'] = "El carrito está vacío";
            header('Location: ' . BASE_URL);
        }
    }

    public function myOrders()
    {
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $orders = $this->orderService->getOrdersByUserId($userId);
            // Mostrar vista de mis pedidos
            $this->pages->render('Order/myOrders', ['orders' => $orders]);
        } else {
            $_SESSION['mensaje'] = "Debes iniciar sesión primero";
            header('Location: ' . BASE_URL . 'login');
        }
    }
}
