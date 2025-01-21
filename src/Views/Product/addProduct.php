<link rel="stylesheet" href="<?= BASE_URL ?>public/css/principal.css">
<section id="gestionar-productos">

    <div class="tabla-productos">
        <?php if (count($products)): ?>
            <table border="1" class="tabla">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                        <th>ID Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['nombre'] ?></td>
                            <td><?= $product['descripcion'] ?></td>
                            <td><?= $product['precio'] ?></td>
                            <td><?= $product['stock'] ?></td>
                            <td><img src="<?= !empty($product['imagen']) ? $product['imagen'] : BASE_URL . 'public/img/imagen_articulo_por_defecto.jpg' ?>" alt="<?= $product['nombre'] ?>"></td>
                            <td>
                                <?php
                                foreach ($categories as $category) {
                                    if ($category['id'] == $product['categoria_id']) {
                                        echo $category['nombre'];
                                        break;
                                    }
                                }
                                ?>
                            </td></td>
                            <td>
                                <button onclick="editProduct(<?= htmlspecialchars(json_encode($product)) ?>)" class="editarProducto">Editar</button>
                            <form action="<?= BASE_URL ?>deleteProduct" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                <button type="submit" class="botonEliminar">Eliminar</button>
                            </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <span>No hay productos</span>
        <?php endif; ?>
    </div>
    <div class="agregar-producto">
        <h2 id="form-title">Agregar nuevo producto</h2>
        <form id="product-form" action="<?= BASE_URL ?>addProduct" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="data[id]" id="product-id">
            <label for="name">Nombre *</label>
            <?php if (isset($_SESSION['errors']['nombre'])): ?>
            <span class="error"><?= $_SESSION['errors']['nombre'] ?></span>
            <?php endif; ?>
            <input type="text" name="data[nombre]" id="name"> <br><br>
            
            <label for="description">Descripción *</label>
            <?php if (isset($_SESSION['errors']['descripcion'])): ?>
            <span class="error"><?= $_SESSION['errors']['descripcion'] ?></span>
            <?php endif; ?>
            <textarea name="data[descripcion]" id="description"></textarea> <br><br>
            
            <label for="price">Precio *</label>
            <?php if (isset($_SESSION['errors']['precio'])): ?>
            <span class="error"><?= $_SESSION['errors']['precio'] ?></span>
            <?php endif; ?>
            <input type="number" name="data[precio]" id="price"> <br><br>
            
            <label for="stock">Stock *</label>
            <?php if (isset($_SESSION['errors']['stock'])): ?>
            <span class="error"><?= $_SESSION['errors']['stock'] ?></span>
            <?php endif; ?>
            <input type="number" name="data[stock]" id="stock"> <br><br>

            <label for="oferta">Oferta (%)</label>
            <?php if (isset($_SESSION['errors']['oferta'])): ?>
            <span class="error"><?= $_SESSION['errors']['oferta'] ?></span>
            <?php endif; ?>
            <input type="text" name="data[oferta]" id="oferta"> <br><br>
            
            <label for="image">Imagen</label>
            <?php if (isset($_SESSION['errors']['imagen'])): ?>
            <span class="error"><?= $_SESSION['errors']['imagen'] ?></span>
            <?php endif; ?>
            <input type="text" name="data[imagen]" id="image"> <br><br>
            
            <label for="category_id">ID Categoría *</label>
            <?php if (isset($_SESSION['errors']['categoria_id'])): ?>
            <span class="error"><?= $_SESSION['errors']['categoria_id'] ?></span>
            <?php endif; ?>
            <select name="data[categoria_id]" id="category_id">
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= $category['nombre'] ?></option>
            <?php endforeach; ?>
            </select> <br><br>
            
            <button type="submit">Guardar Producto</button>
        </form>
        <?php unset($_SESSION['errors']);?>
    </div>
</section>

<script>
    function editProduct(product) {
        fillForm(product);
        document.getElementById('product-form').scrollIntoView({
            behavior: 'smooth'
        });
    }

    function fillForm(product) {
        document.getElementById('form-title').innerText = 'Modificar producto';
        document.getElementById('product-id').value = product.id;
        document.getElementById('name').value = product.nombre;
        document.getElementById('description').value = product.descripcion;
        document.getElementById('price').value = product.precio;
        document.getElementById('stock').value = product.stock;
        document.getElementById('image').value = product.imagen;
        document.getElementById('category_id').value = product.categoria_id;
        document.getElementById('product-form').action = '<?= BASE_URL ?>editProduct';
    }
</script>

<style>
    .tabla-productos {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin-bottom: 5rem;
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

    .tabla th,
    .tabla td {
        padding: 15px;
        border: 1px solid #ddd;
    }

    .tabla th {
        background-color: #4CAF50;
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
    }

    .agregar-producto {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 50%;
        margin: 0 auto;
        padding: 2rem;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
        margin-top: 2rem;
    }

    .agregar-producto h2 {
        margin-bottom: 1.5rem;
    }

    .agregar-producto label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    .agregar-producto input[type="text"],
    .agregar-producto input[type="number"],
    .agregar-producto textarea,
    .agregar-producto select {
        width: 100%;
        padding: 0.5rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .agregar-producto button {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 5px;
        background-color: #28a745;
        color: white;
        font-size: 1rem;
        cursor: pointer;
    }

    .agregar-producto button:hover {
        background-color: #218838;
    }

    .editarProducto,
    .botonEliminar {
        padding: 10px 20px;
        color: white;
        border: none;
        text-decoration: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: medium;
    }

    .editarProducto {
        background-color: #ffc107;
    }

    .editarProducto:hover {
        background-color: #e0a800;
    }

    .botonEliminar {
        background-color: #dc3545;
    }

    .botonEliminar:hover {
        background-color: #c82333;
    }

    .error {
        color: red;
        font-size: 0.9rem;
        margin-top: -0.5rem;
        margin-bottom: 0.5rem;
        display: block;
    }
</style>