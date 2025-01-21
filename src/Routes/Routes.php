<?php 
namespace Routes;

use Lib\Router;
use Controllers\ErrorController;
use Controllers\DashboardController;
use Controllers\AuthController;
use Controllers\ProductController;
use Controllers\CategoryController;
use Controllers\CarritoController;
use Controllers\OrderController;

class Routes{
    public static function index(){
        Router::add('GET', '/', function(){
            (new DashboardController())->index();
        });

        Router::add('GET', '/register', function(){
            (new AuthController())->register();
        });

        Router::add('POST', '/register', function(){
            (new AuthController())->register();
        });

        Router::add('GET', '/login', function(){
            (new AuthController())->login();
        });
        
        Router::add('POST', '/login', function(){
            (new AuthController())->login();
        });

        Router::add('GET', '/logout', function(){
            (new AuthController())->logout();
        });

        Router::add('GET', '/showAllProducts', function(){
            (new ProductController())->showAllProducts();
        });

        Router::add('POST', '/filterProducts', function(){
            (new ProductController())->filterProducts();
        });

        Router::add('GET', '/addProduct', function(){
            (new ProductController())->addProduct();
        });

        Router::add('POST', '/addProduct', function(){
            (new ProductController())->addProduct();
        });

        Router::add('POST', '/editProduct', function(){
            (new ProductController())->editProduct();
        });

        Router::add('POST', '/deleteProduct', function(){
            (new ProductController())->deleteProduct();
        });

        Router::add('GET', '/adminCategory', function(){
            (new CategoryController())->adminCategory();
        });

        Router::add('POST', '/adminCategory', function(){
            (new CategoryController())->adminCategory();
        });

        Router::add('GET', '/viewCart', function(){
            (new CarritoController())->viewCart();
        });

        Router::add('POST', '/addToCart', function(){
            (new CarritoController())->addToCart();
        });

        Router::add('POST', '/emptyCart', function(){
            (new CarritoController())->emptyCart();
        });
        
        Router::add('POST', '/purchaseForm', function(){
            (new OrderController())->purchaseForm();
        });

        Router::add('POST', '/finishOrder', function(){
            (new OrderController())->finishOrder();
        });

        Router::add('GET', '/myOrders', function(){
            (new OrderController())->myOrders();
        });

        Router::add('POST', '/removeFromCart', function(){
            (new CarritoController())->removeFromCart();
        });

        Router::add('POST', '/updateCartQuantity', function(){
            (new CarritoController())->updateCartQuantity();
        });

        Router::add('GET', '/not-found', function(){
            ErrorController::error404();
        });

        Router::dispatch();
    }
}

?>