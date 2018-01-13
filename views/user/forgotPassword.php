<?php global $lang ?>
<h1>Forgot your password</h1>
<br>
<form action="<?php echo $path ?>" method="post">
 <div class="form-group">
    <label for="email">Email</label>
    <input type="text" class="form-control" name="EMAIL"
    placeholder="Enter your email">
  </div>
  <button type="submit" class="btn btn-primary">Send email</button>

</form>
