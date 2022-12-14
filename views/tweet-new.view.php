<h2>Nou truit</h2>
<form class="mb-4" method="post" action="tweet-new-process" enctype="multipart/form-data">
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