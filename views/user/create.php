<?php global $lang ?>
<form action="<?php echo $path ?>" method="post">

  <div class="form-group">
    <label for="email"><?php echo text('EMAIL') ?></label>
    <input type="email" class="form-control" name="EMAIL" aria-describedby="emailHelp"
    placeholder="<?php echo text('TYPE_EMAIL') ?>">
  </div>
 <div class="form-group">
    <label for="username"><?php echo text('USERNAME') ?></label>
    <input id="username" type="text" class="form-control" name="USERNAME"
    placeholder="<?php echo text('TYPE_USERNAME') ?>">
  </div>
  <div class="form-group">
    <label for="password"><?php echo text('PASSWORD') ?></label>
    <input type="password" name="PASSWORD" class="form-control" placeholder="<?php echo text('PASSWORD')?>">
  </div>
  <div class="form-group">
    <label for="repeatPassword"><?php echo text('REPEAT_PASSWORD') ?></label>
    <input type="password" name="confirmPassword" class="form-control" placeholder="<?php echo text('REPEAT_PASSWORD')?>">
  </div>
  <div class="g-recaptcha" data-sitekey="6LeTWUAUAAAAAOKeDLX9-aGn3j6a9vNsBAPvCVZI"></div>
  <button type="submit" class="btn btn-primary"><?php echo text('SIGNIN') ?></button>
</form>
