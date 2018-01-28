<?php global $lang ?>
<h1>Forgot your password</h1>
<br>
<form action="<?php echo $path ?>" method="post">
 <div class="form-group">
    <label for="email"><?php echo text('EMAIL') ?></label>
    <input type="email" class="form-control" name="EMAIL"
    placeholder="<?php echo text('ENTER_YOUR_EMAIL') ?>">
  </div>
  <button type="submit" class="btn btn-primary"><?php echo text('SEND_EMAIL') ?></button>

</form>
