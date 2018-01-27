<?php global $lang ?>
<form action="<?php echo $path ?>" method="post">
  <div class="form-group row justify-content-around">
    <div>
      <div>
        <select class="form-control" id="lang1">
          <?php foreach($langs as $lang) { ?>
            <option><?=$lang?></option>;
          <?php } ?>
        </select>
      </div>
      <div>
        <textarea class="form-control" rows="5" id="comment"></textarea>
      </div>
    </div>
    <div class="align-self-center">
      <input type="submit" class="btn btn-info" value="Translate">
    </div>
    <div>
      <div>
        <select class="form-control" id="lang2">
          <?php foreach($langs as $lang) { ?>
            <option><?=$lang ?></option>;
          <?php } ?>
        </select>
      </div>
      <div>
        <textarea class="form-control" rows="5" id="comment" readonly></textarea>
      </div>
    </div>
  </div>
</form>
