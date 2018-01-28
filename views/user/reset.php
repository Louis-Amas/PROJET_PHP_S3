<?php global $lang ?>
<form action="<?php echo $path ?>" method="post">

  <div class="form-group">
    <label for="email"><?php echo text('EMAIL') ?></label>
    <input type="email" class="form-control" readonly name="EMAIL" aria-describedby="emailHelp"
    placeholder="<?php echo text('TYPE_EMAIL') ?>" value="<?php echo $user->getEmail() ?>">
  </div>
 <div class="form-group">
    <label for="username"><?php echo text('USERNAME') ?></label>
    <input type="text" readonly class="form-control" name="USERNAME"
    placeholder="<?php echo text('TYPE_USERNAME') ?>" value="<?php echo $user->getUsername() ?>">
  </div>
  <div class="form-group">
    <label for="password"><?php echo text('PASSWORD') ?></label>
    <input type="password" name="PASSWORD" class="form-control" placeholder="<?php echo text('PASSWORD')?>">
  </div>
  <div class="form-group">
    <label for="repeatPassword"><?php echo text('REPEAT_PASSWORD') ?></label>
    <input type="password" name="confirmPassword" class="form-control" placeholder="<?php echo text('REPEAT_PASSWORD')?>">
  </div>
  <button type="submit" class="btn btn-primary"><?php echo text('SIGNIN') ?></button>
</form>
