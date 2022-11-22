<!DOCTYPE html>
<html lang="ca">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"></head>
<link rel="icon" href="../assets/corriol.png" />
<style>
    .error {
        font-weight: bold;
        color: red;
    }
</style>
</head>
<body>
<main class="border-top mt-4 border-4 border-primary container">
    <div class="row">
        <div class="col-2 border d-flex flex-column justify-content-between">
            <?php require "partials/sidebar.php" ?>
        </div>
        <div class="col-7 border p-4">
            <h2>Canvi de nom d'usuari del compter</h2>
            <form class="mb-4" method="post" action="confirm-update-username.php">
                <label for="usuario" class="form-label"">Usuari Actual</label>
                <input id="usuario mb-2" class="form-control" value="<?=$user_info['username']?>" name="actual_name" readonly>

                <label for="new_username" class="form-label mt-2">Nou Nom</label>
                <input id="new_name" type="text" class="form-control mb-2" name="new_username">
                <!--Mostrat d'errors-->
                <?php if(!empty($errors)): ?>
                    <?php foreach($errors as $error): ?>
                        <p class="error"><?=$error?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary mt-2">Actualitzar nom</button>
            </form>
        </div>
        <div class="col-3 border"></div>
    </div>
</main>
</body>
</html>
