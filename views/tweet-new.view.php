<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Tuiter: una grollera còpia de Twitter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"></head></head>
    <link rel="icon" href="../public/assets/corriol.png" />
<body>

<main class="border-top mt-4 border-4 border-primary container">
    <div class="row">
        <div class="col-2 border d-flex flex-column justify-content-between">
                <?php require __DIR__ . "/../partials/sidebar.php" ?>
        </div>
        <!--Ara el tuit no es mostra en aquesta pàgina, es mostra en l'index-->
        <div class="col-7 border p-4">
            <h2>Nou truit</h2>
            <form class="mb-4" method="post" action="tweet-new-process.php" enctype="multipart/form-data">
                <textarea class="form-control mb-2" name="tuitValue" placeholder="Què passa, @<?=$info["username"];?>?"></textarea>
                <input type="file" name="tuitFile" class="form-control mb-2" >
                <button class="btn btn-primary" type="submit">Tuiteja</button>
            </form>
            <?php if(!empty($errors)): ?>
            <?php if(!empty($errors)): ?>
                <div class="alert alert-danger mt-4" role="alert">
                    <?=$errors[0]?>
                </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="col-3 border"></div>
    </div>
</main>
</body>
</html>