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
            <h2>Inici de sessió</h2>
            <form class="mt-2" method="post" action="register-process.php">
                <!--Nom-->
                <label for="name" class="form-label">Nom</label>
                <input id="usuario mb-2" class="form-control" <?php if(!empty($form["name"])):?>value="<?=$form["name"]?>"<?php endif;?> name="name" >
                <!--Nom d'usuari-->
                <label for="username" class="form-label"">Usuari</label>
                <input id="usuario mb-2" class="form-control" <?php if(!empty($form["username"])):?>value="<?=$form["username"]?>"<?php endif;?> name="username" >
                <!--Contrasenya-->
                <label for="password" class="form-label">Contrasenya</label>
                <input id="password" type="password" class="form-control mb-2" <?php if(!empty($form["password"])):?>value="<?=$form["password"]?>"<?php endif;?> name="password">
                <!--Contrasenya repetida-->
                <label for="repeated_password" class="form-label">Repeteix la contrasenya</label>
                <input id="repeated_password" type="password" class="form-control mb-2" <?php if(!empty($form["repeated_password"])):?>value="<?=$form["repeated_password"]?>"<?php endif;?> name="repeated_password">
                <!--Mostrat d'errors-->
                <?php if(!empty($register_error)): ?>
                    <?php foreach($register_error as $error): ?>
                        <p class="error"><?=$error?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
                <button class="btn btn-primary mt-3">Iniciar sessió</button>
            </form>
        </div>
        <div class="col-3 border"></div>
    </div>
</main>
</body>
</html>
