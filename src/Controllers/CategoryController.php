<?php

namespace Controllers;

use Exception;
use Models\Category;
use Lib\Pages;
use Services\CategoryService;

class CategoryController
{
    private Pages $pages;
    private CategoryService $categoryService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->categoryService = new CategoryService();
    }

    public function adminCategory(){
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
            $categories = $this->categoryService->getAllCategories();

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                if($_POST['data']){
                    $category = Category::fromArray($_POST['data']);
                    // Validar categoría
                    if($category->validate()){
                        try {                 
                            // Añadir categoría
                            if($this->categoryService->addProduct($category)){
                                $_SESSION['mensaje'] = 'Categoría añadida';
                                header('Location: ' . BASE_URL . 'adminCategory');
                            }
                        }
                        catch (Exception $e) {
                            $_SESSION['errors'] = $category->getErrores();
                            header('Location: ' . BASE_URL . 'adminCategory');
                        }
                    } else {
                        $_SESSION['errors'] = $category->getErrores();
                        header('Location: ' . BASE_URL . 'adminCategory');
                    }
                } else {
                    $_SESSION['errors'] = 'Error al agregar producto';
                }
            } else {
                // Mostrar vista de administración de categorías
                $this->pages->render('Category/adminCategory', ['categories' => $categories]);
            }
        } else{
            $_SESSION['mensaje'] = "Inicia sesión primero";
            header('Location: ' . BASE_URL);
        }
    }
}