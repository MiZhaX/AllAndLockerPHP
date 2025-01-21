<?php 
    namespace Controllers;
    use Lib\Pages;

    class ErrorController{
        // Mostrar página de error 404
        public static function error404(){
            $pages = new Pages();
            $pages->render('Error/error404', ['titulo' => 'Página no encontrada']);
        }
    }
?>