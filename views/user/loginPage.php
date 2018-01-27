<h1>LOGIN</h1>
<?php global $lang ?>
<form action="<?php echo $path ?>" method="post">
 <div class="form-group">
    <label><?php echo $lang['USERNAME'] ?></label>
    <input type="text" class="form-control" name="USERNAME"
    placeholder="<?php echo $lang['TYPE_USERNAME'] ?>">
  </div>
  <div class="form-group">
    <label><?php echo $lang['PASSWORD'] ?></label>
    <input type="password" name="PASSWORD" class="form-control" placeholder="<?php echo $lang['PASSWORD']?>">
  </div>
  <button type="submit" class="btn btn-primary" name="submit" value="connect"><?php echo $lang['LOGIN'] ?></button>
  <button type="submit" class="btn btn-primary" name="submit" value="forgot"> Forgot Password </button>
</form>
