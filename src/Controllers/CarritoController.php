<?php

namespace Controllers;

use Exception;
use Models\Product;
use Lib\Pages;
use Services\ProductService;

class CarritoController
{
    private Pages $pages;
    private ProductService $productService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->productService = new ProductService();
    }

    public function viewCart(){
        $this->pages->render('Carrito/viewCart');
    }

    public function addToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $productId = (int)$_POST['product_id'];
            $product = $this->productService->getProductById($productId);
            
            if ($product) {
                if($product->getStock() == 0){
                    $_SESSION['mensaje'] = 'No hay más stock del producto';
                } else {
                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = [];
                    }
                    if (isset($_SESSION['cart'][$productId])) {
                        if($product->getStock() <= $_SESSION['cart'][$productId]['quantity']){
                            $_SESSION['mensaje'] = 'No hay más stock del producto';
                            header('Location: ' . BASE_URL . 'viewCart');
                        } else{
                            $_SESSION['cart'][$productId]['quantity']++;
                            $_SESSION['cart'][$productId]['precio_total'] = $_SESSION['cart'][$productId]['quantity'] * $product->getPrice();
                            $_SESSION['mensaje'] = 'Producto añadido al carrito';
                        }
                    } else {
                        $_SESSION['cart'][$productId] = $product->toArray();
                        $_SESSION['cart'][$productId]['quantity'] = 1;
                        $_SESSION['cart'][$productId]['precio_total'] = $product->getPrice();
                        $_SESSION['mensaje'] = 'Producto añadido al carrito';
                    }
                }   
            } else {
                $_SESSION['mensaje'] = 'Producto no encontrado';
            }
        }
        header('Location: ' . BASE_URL . 'showAllProducts');
    }

    public function removeFromCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $productId = (int)$_POST['product_id'];
            if (isset($_SESSION['cart'][$productId])) {
                unset($_SESSION['cart'][$productId]);
                $_SESSION['mensaje'] = 'Producto eliminado del carrito';
            } else {
                $_SESSION['mensaje'] = 'Producto no encontrado en el carrito';
            }
        }
        header('Location: ' . BASE_URL . 'viewCart');
    }

    public function emptyCart()
    {
        $_SESSION['cart'] = [];
        $_SESSION['mensaje'] = "Carrito vaciado";
        header('Location: ' . BASE_URL . 'viewCart');
    }

    public function updateCartQuantity()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['action'])) {
            $productId = (int)$_POST['product_id'];
            $product = $this->productService->getProductById($productId);
            $action = $_POST['action'];

            if (isset($_SESSION['cart'][$productId])) {
                if($product->getStock() == 0){
                    $_SESSION['mensaje'] = 'No hay más stock del producto';
                } else {
                    if ($action === 'increase') {
                        if($product->getStock() <= $_SESSION['cart'][$productId]['quantity']){
                            $_SESSION['mensaje'] = 'No hay más stock del producto';
                            header('Location: ' . BASE_URL . 'viewCart');
                        } else{
                            $_SESSION['cart'][$productId]['quantity']++;
                            $_SESSION['cart'][$productId]['precio_total'] = $_SESSION['cart'][$productId]['quantity'] * $product->getPrice();
                        }
                    } elseif ($action === 'decrease' && $_SESSION['cart'][$productId]['quantity'] > 1) {
                        $_SESSION['cart'][$productId]['quantity']--;
                        $_SESSION['cart'][$productId]['precio_total'] = $_SESSION['cart'][$productId]['quantity'] * $product->getPrice();
                    }
                }
            }
        }
        header('Location: ' . BASE_URL . 'viewCart');
    }
}