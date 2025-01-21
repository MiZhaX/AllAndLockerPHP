<?php

namespace Services;

use Repositories\CategoryRepository;
use Models\Category;

class CategoryService {
    private CategoryRepository $categoryRepository;
    private Category $product;

    public function __construct() {
        $this->categoryRepository = new CategoryRepository();
    }

    public function getAllCategories():array {
        return $this->categoryRepository->getAllCategories();
    }

    public function addProduct(Category $category):bool {
        return $this->categoryRepository->save($category);
    }
}