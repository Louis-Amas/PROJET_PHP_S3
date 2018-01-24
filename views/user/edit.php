<?php global $lang ?>
<form action="<?php echo $path ?>" method="post">

  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" readonly name="EMAIL" aria-describedby="emailHelp"
    placeholder="<?php echo $lang['TYPE_EMAIL'] ?>" value="<?php echo $user->getEmail() ?>">
  </div>
 <div class="form-group">
    <label for="username"><?php echo $lang['USERNAME'] ?></label>
    <input type="text" class="form-control" name="USERNAME"
    placeholder="<?php echo $lang['TYPE_USERNAME'] ?>" value="<?php echo $user->getUsername() ?>">
  </div>
<div class="form-group">
    <label for="password"><?php echo $lang['OLD_PASSWORD'] ?></label>
    <input type="password" name="OLDPASSWORD" class="form-control" placeholder="<?php echo $lang['OLD_PASSWORD']?>">
  </div>
  <div class="form-group">
    <label for="password"><?php echo $lang['PASSWORD'] ?></label>
    <input type="password" name="PASSWORD" class="form-control" placeholder="<?php echo $lang['PASSWORD']?>">
  </div>
  <div class="form-group">
    <label for="repeatPassword"><?php echo $lang['REPEAT_PASSWORD'] ?></label>
    <input type="password" name="confirmPassword" class="form-control" placeholder="<?php echo $lang['REPEAT_PASSWORD']?>">
  </div>

  <?php if (Util::can_acces("ADM")) {?>
  <div class="form-group">
    <label for "roleselect"> Select a role: </label>
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
  <button type="submit" class="btn btn-primary"><?php echo 'Edit' ?></button>
</form>
