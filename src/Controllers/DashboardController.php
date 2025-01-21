<?php 
    namespace Controllers;

    use Lib\Pages;

    class DashboardController{
        private Pages $pages;

        public function __construct() {
            $this->pages = new Pages();
        }
        
        // Mostrar landing page
        public function index(){
            $this->pages->render('Layout/principal');
        }
    }
?>