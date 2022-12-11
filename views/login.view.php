<div>
    <h2>Inici de sessió</h2>
    <form class="mb-4" method="post" action="login-process.php">
        <label for="usuario" class="form-label"">Usuari</label>
        <input id="usuario mb-2" class="form-control" <?php if(!empty($info)):?>value="<?=$info?>"<?php endif;?> name="username" >
        <label for="password" class="form-label">Contrasenya</label>
        <input id="password" type="password" class="form-control mb-2" <?php if(!empty($info["password"])):?>value="<?=$info["password"]?>"<?php endif;?> name="password">
        <!--Mostrat d'errors-->
        <?php if(!empty($errors)): ?>
            <div class="alert alert-danger mt-4" role="alert">
                <?=$errors[0]?>
            </div>
        <?php endif; ?>
        <button class="btn btn-primary">Iniciar sessió</button>
    </form>
</div>