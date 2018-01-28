<h1>LOGIN</h1>
<?php global $lang ?>
<form action="<?php echo $path ?>" method="post">
 <div class="form-group">
    <label><?php echo text('USERNAME') ?></label>
    <input type="text" class="form-control" name="USERNAME"
    placeholder="<?php echo text('TYPE_USERNAME') ?>">
  </div>
  <div class="form-group">
    <label><?php echo text('PASSWORD') ?></label>
    <input type="password" name="PASSWORD" class="form-control" placeholder="<?php echo text('PASSWORD')?>">
  </div>
  <button type="submit" class="btn btn-primary" name="submit" value="connect"><?php echo text('LOGIN') ?></button>
  <button type="submit" class="btn btn-primary" name="submit" value="forgot"><?php echo text('FORGOT_PASSWORD') ?></button>
</form>
