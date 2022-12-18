<table class="table table-dark table-hover">
    <tr>
        <th>Name</th>
        <td><?=$name?></td>
        <form method="post" action="/profile/edit-name">
            <td>
                <button type="submit" class="btn btn-primary">Editar</button>
            </td>
        </form>
    </tr>
    <tr>
        <th>Username</th>
        <td>@<?=$username?></td>
        <form method="post" action="/profile/edit-username">
            <td>
                <button type="submit" class="btn btn-primary">Editar</button>
            </td>
        </form>
    </tr>
    <tr>
        <th>Eliminar Usuari</th>
        <td></td>
        <form method="post" action="/profile/delete-user">
            <td>
                <button type="submit" class="btn btn-primary">Eliminar</button>
            </td>
        </form>
    </tr>
</table>