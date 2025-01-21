<section class="purchase-form">
    <h2>Formulario de Envío</h2>
    <form action="<?=BASE_URL?>finishOrder" method="POST">
        <label for="provincia">Provincia</label>
        <input type="text" name="data[provincia]" id="provincia">
        <?php if (isset($_SESSION['errors']['provincia'])): ?>
            <span class="error"><?= $errors['provincia'] ?></span>
        <?php endif; ?>
        <br><br>
        
        <label for="localidad">Localidad</label>
        <input type="text" name="data[localidad]" id="localidad">
        <?php if (isset($_SESSION['errors']['localidad'])): ?>
            <span class="error"><?= $errors['localidad'] ?></span>
        <?php endif; ?>
        <br><br>
        
        <label for="direccion">Dirección</label>
        <input type="text" name="data[direccion]" id="direccion">
        <?php if (isset($_SESSION['errors']['direccion'])): ?>
            <span class="error"><?= $errors['direccion'] ?></span>
        <?php endif; ?>
        <br><br>
        
        <button type="submit" class="btn-comprar">Confirmar Compra</button>
    </form>
</section>

<style>
    .purchase-form {
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
        margin-top: 7rem;
    }

    .purchase-form h2 {
        margin-bottom: 1.5rem;
    }

    .purchase-form label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    .purchase-form input[type="text"] {
        width: 100%;
        padding: 0.5rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btn-comprar {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 5px;
        background-color: #28a745;
        color: white;
        font-size: 1rem;
        cursor: pointer;
    }

    .btn-comprar:hover {
        background-color: #218838;
    }

    .error {
        color: red;
        font-size: 0.875rem;
    }
</style>