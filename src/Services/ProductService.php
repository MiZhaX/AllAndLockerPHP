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

    public function getAllProducts():array {
        return $this->productRepository->getAllProducts();
    }

    public function getProductsByCategory(int $categoryID):array {
        return $this->productRepository->getProductByCategory($categoryID);
    }

    public function addProduct(Product $product):bool {
        return $this->productRepository->save($product);
    }

    public function getProductById(int $id):Product|bool {
        return $this->productRepository->getProductById($id);
    }

    public function updateProduct(Product $product): bool {
        return $this->productRepository->update($product);
    }

    public function deleteProduct(int $id): bool {
        return $this->productRepository->delete($id);
    }
}