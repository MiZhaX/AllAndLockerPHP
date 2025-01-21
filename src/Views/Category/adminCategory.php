<link rel="stylesheet" href="<?=BASE_URL?>public/css/principal.css">
<section id="gestionar-categorias">
    <div class="tabla-categorias">
        <?php if(count($categories)): ?>
            <table border="1" class="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($categories as $category): ?>
                        <tr>
                            <td><?=$category['id']?></td>
                            <td><?=$category['nombre']?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else:?>
            <span>No hay categorías</span>
        <?php endif;?>
    </div>
    <div class="agregar-categoria">
        <h2>Agregar nueva categoría</h2>
        <form action="<?=BASE_URL?>adminCategory" method="POST" class="form">
            <label for="name">Nombre</label>
            <?php if (isset($_SESSION['errors']['name'])): ?>
                <span class="error"><?= $_SESSION['errors']['name']; ?></span><br>
            <?php endif; ?>
            <input type="text" name="data[name]" id="name"> <br><br> 
            <button type="submit">Agregar Categoría</button>
        </form>
    </div>
</section>

<style>
    .form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .error {
        color: red;
        font-size: 0.875rem;
    }
    .tabla-categorias{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin-bottom: 5rem;
    }
    .tabla{
        border-collapse: collapse;
        text-align: center;
        width: 80%;
        margin: 0 auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .tabla thead{
        background-color: #f2f2f2;
    }
    .tabla th, .tabla td{
        padding: 15px;
        border: 1px solid #ddd;
    }
    .tabla th{
        background-color: var(--alt-color);
        color: white;
    }
    .tabla tr:nth-child(even){
        background-color: #f9f9f9;
    }
    .tabla tr:hover{
        background-color: #f1f1f1;
    }
    .agregar-categoria{
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
    }
    .agregar-categoria h2{
        margin-bottom: 1.5rem;
    }
    .agregar-categoria label{
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }
    .agregar-categoria input[type="text"]{
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .agregar-categoria button{
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 5px;
        background-color: var(--main-color);
        color: white;
        font-size: 1rem;
        cursor: pointer;
    }
    .agregar-categoria button:hover{
        background-color: var(--alt-main-color);
    }
</style>