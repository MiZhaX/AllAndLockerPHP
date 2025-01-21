<section class="carrito">
    <h2>Carrito de Compras</h2>
    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
        <table border="1" class="tabla">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio Unitario</th>
                    <th>Imagen</th>
                    <th>Cantidad</th>
                    <th>Precio Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $precioTotalCarrito = 0;
                foreach ($_SESSION['cart'] as $productId => $product): 
                    $precioTotalCarrito += $product['precio_total'];
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($product['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($product['precio']); ?></td>
                        <td><img src="<?= !empty($product['imagen']) ? $product['imagen'] : BASE_URL . 'public/img/imagen_articulo_por_defecto.jpg' ?>" alt="<?php echo htmlspecialchars($product['nombre']); ?>"></td>
                        <td class="cantidad">
                            <form action="<?=BASE_URL?>updateCartQuantity" method="POST" class="form-quantity">
                                <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                <button type="submit" name="action" value="decrease" class="btn-quantity">-</button>
                                <span><?php echo htmlspecialchars($product['quantity']); ?></span>
                                <button type="submit" name="action" value="increase" class="btn-quantity">+</button>
                            </form>
                        </td>
                        <td><?php echo htmlspecialchars($product['precio_total']); ?></td>
                        <td>
                            <form action="<?=BASE_URL?>removeFromCart" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                <button type="submit" class="btn-eliminar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="precio-total">
            <h3>Precio Total del Carrito: <?php echo htmlspecialchars($precioTotalCarrito); ?></h3>
        </div>
        <div class="botones">
            <form action="<?=BASE_URL?>emptyCart" method="POST">
                <button type="submit" class="btn-vaciar">Vaciar Carrito</button>
            </form>
            <form action="<?=BASE_URL?>purchaseForm" method="POST">
                <button type="submit" class="btn-comprar">Comprar</button>
            </form>
        </div>
    <?php else: ?>
        <p>No hay productos en el carrito.</p>
    <?php endif; ?>
</section>

<style>
    .carrito {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .tabla {
        border-collapse: collapse;
        text-align: center;
        width: 80%;
        margin: 0 auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .tabla thead {
        background-color: #f2f2f2;
    }
    .tabla th, .tabla td {
        padding: 15px;
        border: 1px solid #ddd;
    }
    .tabla th {
        background-color: var(--alt-color);
        color: white;
    }
    .tabla tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .tabla tr:hover {
        background-color: #f1f1f1;
    }
    img {
        width: 100px;
        height: 100px;
    }
    .botones {
        display: flex;
        flex-direction: row;
        gap: 20px;
        align-items: center;
    }
    .btn-vaciar, .btn-comprar, .btn-eliminar, .btn-quantity {
        padding: 10px 20px;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn-vaciar, .btn-comprar {
        margin-top: 20px;
    }
    .btn-vaciar {
        background-color: var(--main-color);
    }
    .btn-vaciar:hover {
        background-color: var(--alt-main-color);
    }
    .btn-comprar {
        background-color: var(--alt-color);
    }
    .btn-comprar:hover {
        background-color: var(--alt-alt-color);
    }
    .btn-eliminar {
        background-color: var(--main-color);
    }
    .btn-eliminar:hover {
        background-color: var(--alt-main-color);
    }
    .btn-quantity {
        background-color: var(--main-color);
    }
    .btn-quantity:hover {
        background-color: var(--alt-main-color);
    }
    .form-quantity {
        display: flex;
        align-items: center;
        gap: 10px;
        justify-content: center;
    }
    .precio-total {
        margin-top: 20px;
        font-size: 1.5rem;
        font-weight: bold;
    }
</style>
