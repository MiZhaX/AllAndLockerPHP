<section class="filtrar">
    <form action="<?=BASE_URL?>filterProducts" method="POST">
        <select name="category">
            <option value="ALL">Selecciona una categoría</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['id']); ?>">
                    <?php echo htmlspecialchars($category['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn-filtrar">FILTRAR</button>
    </form>
</section>
<section class="lista-productos">
    <?php if(count($products) == 0): ?>
        <h2>No hay productos para esta categoría</h2>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="<?= !empty($product['imagen']) ? $product['imagen'] : BASE_URL . 'public/img/imagen_articulo_por_defecto.jpg' ?>" alt="<?php echo htmlspecialchars($product['nombre']); ?>">
                <h2><?php echo htmlspecialchars($product['nombre']); ?></h2>
                <p class="price">Precio: $<?php echo htmlspecialchars($product['precio']); ?></p>
                <p class="description"><?php echo htmlspecialchars($product['descripcion']); ?></p>
                <form action="<?=BASE_URL?>addToCart" method="POST">
                    <input type="hidden" name="product_id" value="<?=(int)$product['id']?>">
                    <button type="submit" class="btn-comprar">Comprar</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>
<style>
    .filtrar {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .filtrar form {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filtrar select {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
    }

    .btn-filtrar {
        padding: 10px 20px;
        background-color: var(--alt-color);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-filtrar:hover {
        background-color: var(--alt-alt-color);
    }
    .lista-productos {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 1rem;
        justify-content: center;
    }
    .product {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 250px;
        text-align: center;
    }
    .product img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 15px;
    }
    .product h2 {
        font-size: 1.2rem;
        margin-bottom: 10px;
    }
    .product .price {
        font-size: 1rem;
        color: #28a745;
        margin-bottom: 10px;
    }
    .product .description {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 15px;
    }
    .btn-comprar {
        padding: 10px 20px;
        background-color: var(--main-color);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .btn-comprar:hover {
        background-color: var(--alt-color);
    }
</style>