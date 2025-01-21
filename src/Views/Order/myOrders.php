<section class="mis-pedidos">
    <h2>Mis Pedidos</h2>
    <?php if (isset($orders) && count($orders) > 0): ?>
        <table border="1" class="tabla">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Provincia</th>
                    <th>Localidad</th>
                    <th>Dirección</th>
                    <th>Coste</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['id']); ?></td>
                        <td><?php echo htmlspecialchars($order['provincia']); ?></td>
                        <td><?php echo htmlspecialchars($order['localidad']); ?></td>
                        <td><?php echo htmlspecialchars($order['direccion']); ?></td>
                        <td><?php echo htmlspecialchars($order['coste']); ?></td>
                        <td><?php echo htmlspecialchars($order['estado']); ?></td>
                        <td><?php echo htmlspecialchars($order['fecha']); ?></td>
                        <td><?php echo htmlspecialchars($order['hora']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes pedidos realizados.</p>
    <?php endif; ?>
</section>

<style>
    .mis-pedidos {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 80%;
        margin: 0 auto;
        padding: 2rem;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
        margin-top: 7rem;
    }

    .mis-pedidos h2 {
        margin-bottom: 1.5rem;
    }

    .tabla {
        border-collapse: collapse;
        text-align: center;
        width: 100%;
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
        background-color: var(--alt-color);
        color: white;
    }

    .tabla tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .tabla tr:hover {
        background-color: #f1f1f1;
    }
</style>
