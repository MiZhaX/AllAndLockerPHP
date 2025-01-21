<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/main.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/principal.css">
    <script src="https://kit.fontawesome.com/c63f30e957.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <a id="boton-inicio" href="<?= BASE_URL ?>"><img src="<?= BASE_URL ?>public/img/logo.png" alt="logo" class="logo"></a>
        <?php if (isset($_SESSION['user'])): ?>
            <p>Bienvenido <?= $_SESSION['user']['nombre'] ?></p>
        <?php endif; ?>
        <ul class="navegacion">
            <li><a href="<?= BASE_URL ?>showAllProducts">Productos</a></li>
        </ul>
        <nav>
            <ul class="opciones">
                <?php if (isset($_SESSION['user'])): ?>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                        <li><a href="<?= BASE_URL ?>addProduct">Gestionar Productos</a></li>
                        <li><a href="<?= BASE_URL ?>adminCategory">Gestionar Categorías</a></li>
                    <?php endif; ?>
                    <li><a href="<?= BASE_URL ?>myOrders">Mis pedidos</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navegacion">
                <?php if (!isset($_SESSION['user'])): ?>
                    <li><a href="<?= BASE_URL ?>login"><i class="fa-solid fa-user fa-2xl"></i></a></li>
                    <li><a href="<?= BASE_URL ?>register"><i class="fa-solid fa-clipboard fa-2xl"></i></a></li>
                <?php else: ?>
                    <li><a href="<?= BASE_URL ?>logout"><i class="fa-solid fa-right-from-bracket fa-2xl"></i></a></li>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>viewCart" id="boton-carrito"><i class="fa-solid fa-cart-shopping fa-2xl"></i></a>
            </ul>
        </nav>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div id="notification" class="notification">
                <?= $_SESSION['mensaje']; ?>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', (event) => {
                    const notification = document.getElementById('notification');
                    if (notification) {
                        setTimeout(() => {
                            notification.classList.add('show');
                        }, 100); 
                        setTimeout(() => {
                            notification.style.display = 'none';
                        }, 5000); 
                    }
                });
            </script>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

    </header>