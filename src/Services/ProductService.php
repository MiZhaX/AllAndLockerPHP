<?php

namespace Services;

use Repositories\ProductRepository;
use Models\Product;

class ProductService {
    private ProductRepository $productRepository;
    private Product $product;

    public function __construct() {
        $this->productRepository = new ProductRepository();
    }

    // Obtener todos los productos
    public function getAllProducts():array {
        return $this->productRepository->getAllProducts();
    }

    // Obtener todos los productos de una categoría
    public function getProductsByCategory(int $categoryID):array {
        return $this->productRepository->getProductByCategory($categoryID);
    }

    // Guardar un producto
    public function addProduct(Product $product):bool {
        return $this->productRepository->save($product);
    }

    // Obtener un producto por su id
    public function getProductById(int $id):Product|bool {
        return $this->productRepository->getProductById($id);
    }

    // Actualizar un producto
    public function updateProduct(Product $product): bool {
        return $this->productRepository->update($product);
    }

    // Eliminar un producto
    public function deleteProduct(int $id): bool {
        return $this->productRepository->delete($id);
    }
}