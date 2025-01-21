<?php

namespace Controllers;

use Exception;
use Lib\Pages;
use Models\User;
use Services\UserService;

class AuthController
{
    private Pages $pages;
    private UserService $userService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->userService = new UserService();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['data']) {
                try {
                    $usuario = $this->userService->getUserbyEmail($_POST['data']['email']);

                    if ($usuario && password_verify($_POST['data']['password'], $usuario->getPassword())) {
                        $user = $usuario->toArray();
                        $_SESSION['user'] = $user;

                        if ($usuario->getRole() == 'admin') {
                            $_SESSION['role'] = $usuario->getRole();
                        }

                        $_SESSION['mensaje'] = 'Usuario logueado con éxito';
                        header('Location: ' . BASE_URL);
                        exit();
                    } else {
                        $_SESSION['register'] = 'fail';
                        $_SESSION['errors'] = 'Usuario o contraseña incorrectos';
                        $_SESSION['mensaje'] = 'Inicio de sesión incorrecto';
                        header('Location: ' . BASE_URL . 'login');
                    }
                } catch (Exception $e) {
                    $_SESSION['register'] = 'fail';
                    $_SESSION['errors'] = 'Error al iniciar sesión';
                    echo $e->getMessage();
                }
            }
        } else {
            $this->pages->render('Auth/login');
        }
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();

        header('Location: ' . BASE_URL);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['data']) {
                $usuario = User::fromArray($_POST['data']);

                if ($usuario->validate()) {
                    $pass = password_hash($usuario->getPassword(), PASSWORD_BCRYPT, ['cost' => 5]);
                    $usuario->setPassword($pass);

                    try {
                        $this->userService->save($usuario);
                        $_SESSION['mensaje'] = 'Usuario registrado con exito';
                        header('Location: '. BASE_URL .'login');
                    } catch (Exception $e) {
                        $_SESSION['register'] = 'fail';
                        $_SESSION['mensaje'] = 'Error al registrar el usuario';
                        header('Location: '. BASE_URL .'register');
                    }
                } else {
                    $_SESSION['register'] = 'fail';
                    $_SESSION['errors'] = $usuario->getErrores();
                    header('Location: '. BASE_URL .'register');
                }
            } else {
                $_SESSION['register'] = 'fail'; 
            }
        } else {
            $this->pages->render('Auth/registro');
        }
    }
}
