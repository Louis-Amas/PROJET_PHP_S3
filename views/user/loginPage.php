<?php global $lang ?>
<form action="<?php echo $path ?>" method="post">


 <div class="form-group">
    <label for="username"><?php echo $lang['USERNAME'] ?></label>
    <input type="text" class="form-control" name="USERNAME" 
    placeholder="<?php echo $lang['TYPEUSERNAME'] ?>">
  </div>
  <div class="form-group">
    <label for="password"><?php echo $lang['PASSWORD'] ?></label>
    <input type="password" name="PASSWORD" class="form-control" placeholder="<?php echo $lang['PASSWORD']?>">
  </div>
  <button type="submit" class="btn btn-primary"><?php echo $lang['LOGIN'] ?></button>
</form>