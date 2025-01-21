<section id="register">
    <h2>Formulario para registrarse</h2>
    <form action="<?=BASE_URL?>register" method="POST" class="form">
        <label for="name">Nombre</label>
        <?php if (isset($_SESSION['errors']['nombre'])): ?>
            <p class="error"><?= $_SESSION['errors']['nombre'] ?></p>
        <?php endif; ?>
        <input type="text" name="data[nombre]" id="name">
        
        <label for="lastname">Apellido</label>
        <?php if (isset($_SESSION['errors']['apellido'])): ?>
            <p class="error"><?= $_SESSION['errors']['apellido'] ?></p>
        <?php endif; ?>
        <input type="text" name="data[apellido]" id="lastname">
        
        <label for="email">Email</label>
        <?php if (isset($_SESSION['errors']['email'])): ?>
            <p class="error"><?= $_SESSION['errors']['email'] ?></p>
        <?php endif; ?>
        <input type="email" name="data[email]" id="email">
        
        <label for="password">Contraseña</label>
        <?php if (isset($_SESSION['errors']['password'])): ?>
            <p class="error"><?= $_SESSION['errors']['password'] ?></p>
        <?php endif; ?>
        <input type="password" name="data[password]" id="password">
        
        <input type="submit" value="Registrarse">
    </form>
</section>
<style>
    #register {
        width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 8rem;
    }

    #register h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #register label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    #register input[type="text"],
    #register input[type="email"],
    #register input[type="password"] {
        width: 80%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    #register input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #28a745;
        border: none;
        border-radius: 5px;
        color: white;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
    }

    #register input[type="submit"]:hover {
        background-color: #218838;
    }

    .error {
        color: red;
        font-size: 14px;
        margin-bottom: 10px;
    }
</style>