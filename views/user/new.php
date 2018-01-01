<?php global $lang ?>
<form action="<?php echo $path ?>" method="post">

  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" name="EMAIL" aria-describedby="emailHelp" 
    placeholder="<?php echo $lang['TYPEEMAIL'] ?>">
  </div>
 <div class="form-group">
    <label for="username"><?php echo $lang['USERNAME'] ?></label>
    <input type="text" class="form-control" name="USERNAME" 
    placeholder="<?php echo $lang['TYPEUSERNAME'] ?>">
  </div>
  <div class="form-group">
    <label for="password"><?php echo $lang['PASSWORD'] ?></label>
    <input type="password" name="PASSWORD" class="form-control" placeholder="<?php echo $lang['PASSWORD']?>">
  </div>
  <div class="form-group">
    <label for="repeatPassword"><?php echo $lang['REPEATPASSWORD'] ?></label>
    <input type="password" name="confirmPassword" class="form-control" placeholder="<?php echo $lang['REPEATPASSWORD']?>">
  </div>
  <button type="submit" class="btn btn-primary"><?php echo $lang['SIGNIN'] ?></button>
</form>