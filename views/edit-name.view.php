<h2>Canvi del nom del compter</h2>
<form class="mb-4" method="post" action="confirm-update-name.php">
    <label for="usuario" class="form-label"">Nom Actual</label>
    <input id="usuario mb-2" class="form-control" value="<?=$name?>" name="actual_name" readonly>

    <label for="new_name" class="form-label mt-2">Nou Nom</label>
    <input id="new_name" type="text" class="form-control mb-2" name="new_name">
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