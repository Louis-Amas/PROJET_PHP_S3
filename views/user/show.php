<?php global $lang ?>
<form action="<?php echo $path ?>" method="post">
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo $user->getEmail()?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="staticText" class="col-sm-2 col-form-label"><?php echo text('USERNAME') ?>
    </label>
    <div class="col-sm-10">
      <input type="text" readonly class="form-control" id="username" value="<?php echo $user->getUsername() ?>
      ">
    </div>
  </div>
  <button type="submit" class="btn btn-primary"><?php echo 'Edit' ?></button>

</form>
