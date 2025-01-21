<?php if (isset($mensaje)): ?>
    <p><?=$mensaje?></p>
<?php endif;?>
<section id="login">
    <h2>Iniciar Sesión</h2>
    <form action="<?=BASE_URL?>login" method="POST" class="form">
        <label for="email">Email</label>
        <input type="email" name="data[email]" id="email">
        <label for="password">Contraseña</label>
        <input type="password" name="data[password]" id="password">
        <input type="submit" value="Iniciar Sesión">
    </form>
</section>
<style>
    #login {
        width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 7rem;
    }
    #login h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    #login label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form{
        display: flex;
        flex-direction: column;
        align-items: center ;
    }

    #login input[type="email"],
    #login input[type="password"] {
        width: 80%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }
    #login input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        border: none;
        border-radius: 3px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        font-weight: bold;
    }
    #login input[type="submit"]:hover {
        background-color: #0056b3;
    }
    p {
        color: red;
        text-align: center;
    }
</style>