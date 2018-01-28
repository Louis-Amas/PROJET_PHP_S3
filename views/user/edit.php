<?php global $lang ?>
<form action="<?php echo $path ?>" method="post">

  <div class="form-group">
    <label for="email"><?php echo text('EMAIL') ?></label>
    <input type="email" class="form-control" readonly name="EMAIL" aria-describedby="emailHelp"
    placeholder="<?php echo text('TYPE_EMAIL') ?>" value="<?php echo $user->getEmail() ?>">
  </div>
 <div class="form-group">
    <label for="username"><?php echo text('USERNAME') ?></label>
    <input type="text" class="form-control" name="USERNAME"
    placeholder="<?php echo text('TYPE_USERNAME') ?>" value="<?php echo $user->getUsername() ?>">
  </div>
<div class="form-group">
    <label for="password"><?php echo text('OLD_PASSWORD') ?></label>
    <input type="password" name="OLDPASSWORD" class="form-control" placeholder="<?php echo text('OLD_PASSWORD')?>">
  </div>
  <div class="form-group">
    <label for="password"><?php echo text('PASSWORD') ?></label>
    <input type="password" name="PASSWORD" class="form-control" placeholder="<?php echo text('PASSWORD')?>">
  </div>
  <div class="form-group">
    <label for="repeatPassword"><?php echo text('REPEAT_PASSWORD') ?></label>
    <input type="password" name="confirmPassword" class="form-control" placeholder="<?php echo text('REPEAT_PASSWORD')?>">
  </div>

  <?php if (Util::can_acces("ADM")) {?>
  <div class="form-group">
    <label for "roleselect"><?php echo text('SELECT_A_ROLE:') ?></label>
    <select class="form-control" id="roleselect" name="ROLE">
      <?php foreach ($roles as $key => $value) {
        echo '<option value="'.$key.'"';
        if ($user->getType() == $key)
          echo 'selected';
        echo '>'.$value.'</option>';
      }?>
    </select>
  </div>
  <?php } ?>
  <button type="submit" class="btn btn-primary"><?php echo text('EDIT') ?></button>
</form>
