<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="icon" href="../assets/corriol.png" />
    <title>Perfil</title>
</head>
<body>
<main class="mt-4 container">
    <div class="row">
        <div class="position-fixed col-2 d-flex flex-column justify-content-between h-75">
            <?php require "partials/sidebar.php" ?>
        </div>
        <div class="offset-2 col-6 border-start border-end border-1 p-4">
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
        </div>
        <div class="col-4"></div>
    </div>
</main>
</body>
</html>