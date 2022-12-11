<h2>Canvi de nom d'usuari del compter</h2>
<form class="mb-4" method="post" action="confirm-update-username.php">
    <label for="usuario" class="form-label"">Usuari Actual</label>
    <input id="usuario mb-2" class="form-control" value="<?=$username?>" name="actual_name" readonly>

    <label for="new_username" class="form-label mt-2">Nou Nom</label>
    <input id="new_name" type="text" class="form-control mb-2" name="new_username">
    <!--Mostrat d'errors-->
    <?php if(!empty($errors)): ?>
        <?php foreach($errors as $error): ?>
            <div class="alert alert-danger mt-4" role="alert">
                <?=$error?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary mt-2">Actualitzar nom</button>
</form>