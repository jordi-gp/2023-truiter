<h2>Inici de sessió</h2>
<form class="mt-2" method="post" action="register-process">
    <!--Nom-->
    <label for="name" class="form-label">Nom</label>
    <input id="usuario mb-2" class="form-control" <?php if(!empty($info_form["name"])):?>value="<?=$info_form["name"]?>"<?php endif;?> name="name" >
    <!--Nom d'usuari-->
    <label for="username" class="form-label"">Usuari</label>
    <input id="usuario mb-2" class="form-control" <?php if(!empty($info_form["username"])):?>value="<?=$info_form["username"]?>"<?php endif;?> name="username" >
    <!--Contrasenya-->
    <label for="password" class="form-label">Contrasenya</label>
    <input id="password" type="password" class="form-control mb-2" <?php if(!empty($info_form["password"])):?>value="<?=$info_form["password"]?>"<?php endif;?> name="password">
    <!--Contrasenya repetida-->
    <label for="repeated_password" class="form-label">Repeteix la contrasenya</label>
    <input id="repeated_password" type="password" class="form-control mb-2" <?php if(!empty($info_form["repeated_password"])):?>value="<?=$info_form["repeated_password"]?>"<?php endif;?> name="repeated_password">
    <!--Mostrat d'errors-->
    <?php if(!empty($register_errors)): ?>
        <div class="alert alert-danger mt-4" role="alert">
            <?=$register_errors[0]?>
        </div>
    <?php endif; ?>
    <button class="btn btn-primary mt-3">Iniciar sessió</button>
</form>
