<?php

namespace Controllers;

use Exception;
use Models\Product;
use Lib\Pages;
use Services\CategoryService;
use Services\ProductService;

class ProductController
{
    private Pages $pages;
    private ProductService $productService;
    private CategoryService $categoryService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->productService = new ProductService();
        $this->categoryService = new CategoryService();
    }

    public function showAllProducts()
    {
        try {
            $products = $this->productService->getAllProducts();
            $categories = $this->categoryService->getAllCategories();
            $this->pages->render('Product/allProducts', ['products' => $products, 'categories' => $categories]);
        } catch (Exception $e) {
            $_SESSION['errors'] = 'Error al mostrar productos';
            echo $e->getMessage();
        }
    }

    public function addProduct()
    {
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
            $products = $this->productService->getAllProducts();
            $categories = $this->categoryService->getAllCategories();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($_POST['data']) {
                    $product = Product::fromArray($_POST['data']);
                    
                    $product->sanitize();
                    if ($product->validate()) {
                        try {
                            if ($this->productService->addProduct($product)) {
                                $_SESSION['mensaje'] = 'Producto añadido';
                                header('Location: ' . BASE_URL . 'addProduct');
                            } else {
                                echo 'Error al agregar producto';
                            }
                        } catch (Exception $e) {
                            $_SESSION['errors'] = 'Error al agregar producto';
                            echo $e->getMessage();
                        }
                    } else {
                        $_SESSION['errors'] = $product->getErrores();
                        header('Location: ' . BASE_URL . 'addProduct');
                    }
                } else {
                    $_SESSION['errors'] = 'Error al agregar producto';
                }
            } else {
                $this->pages->render('Product/addProduct', ['products' => $products, 'categories' => $categories]);
            }
        } else {
            $_SESSION['mensaje'] = "Inicia sesión primero";
            header('Location: ' . BASE_URL);
        }
        
    }

    public function editProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
            $product = Product::fromArray($_POST['data']);
            if ($product->validate()) {
                try {
                    if ($this->productService->updateProduct($product)) {
                        $_SESSION['mensaje'] = 'Producto actualizado';
                        header('Location: ' . BASE_URL . 'addProduct');
                    } else {
                        echo 'Error al actualizar producto';
                    }
                } catch (Exception $e) {
                    $_SESSION['errors'] = 'Error al actualizar producto';
                    echo $e->getMessage();
                }
            } else {
                $_SESSION['errors'] = $product->getErrores();
            }
        } else {
            $_SESSION['errors'] = 'Error al actualizar producto';
        }
    }

    public function deleteProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $productId = (int)$_POST['id'];
            try {
                if ($this->productService->deleteProduct($productId)) {
                    $_SESSION['mensaje'] = 'Producto eliminado';
                } else {
                    $_SESSION['errors'] = 'Error al eliminar producto';
                }
            } catch (Exception $e) {
                $_SESSION['errors'] = 'Error al eliminar producto';
                echo $e->getMessage();
            }
        } else {
            $_SESSION['errors'] = 'ID de producto no proporcionado';
        }
        header('Location: ' . BASE_URL . 'addProduct');
    }

    public function filterProducts()
    {
        $products = $this->productService->getAllProducts();
        $categories = $this->categoryService->getAllCategories();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['category']) {
                if($_POST['category'] == 'ALL'){
                    $this->pages->render('Product/allProducts', ['products' => $products, 'categories' => $categories]);
                } else{
                    $products = $this->productService->getProductsByCategory($_POST['category']);
                    $this->pages->render('Product/allProducts', ['products' => $products, 'categories' => $categories]);
                }
            } else {
                $_SESSION['errors'] = 'Error al obtener categoría';
            }
        } else {
            $this->pages->render('Product/addProduct', ['products' => $products, 'categories' => $categories]);
        }
    }

    public function orderProducts()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
            try {
                foreach ($cart as $item) {
                    $product = $this->productService->getProductById($item['id']);
                    if ($product) {
                        $newStock = $product->getStock() - $item['quantity'];
                        if ($newStock >= 0) {
                            $product->setStock($newStock);
                            $this->productService->updateProduct($product);
                        } else {
                            $_SESSION['errors'] = 'Stock insuficiente para el producto: ' . $product->getName();
                            header('Location: ' . BASE_URL . 'viewCart');
                            return;
                        }
                    } else {
                        $_SESSION['errors'] = 'Producto no encontrado';
                        header('Location: ' . BASE_URL . 'viewCart');
                        return;
                    }
                }
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
