<table class="table table-dark table-hover">
    <tr>
        <th>Name</th>
        <td><?=$name?></td>
        <form method="post" action="edit-name.php">
            <td>
                <button type="submit" class="btn btn-primary">Editar</button>
            </td>
        </form>
    </tr>
    <tr>
        <th>Username</th>
        <td>@<?=$username?></td>
        <form method="post" action="edit-username.php">
            <td>
                <button type="submit" class="btn btn-primary">Editar</button>
            </td>
        </form>
    </tr>
    <tr>
        <th>Eliminar Usuari</th>
        <form method="post" action="delete-user.php">
            <td>
                <button type="submit" class="btn btn-primary">Eliminar</button>
            </td>
        </form>
    </tr>
</table>