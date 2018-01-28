<?php global $lang ?>
<form action="<?= $path ?>" method="post">
  <div class="form-row">
    <div class="col">
      <select class="form-control" name="LANGS">
        <?php foreach($langs as $lang) { ?>
          <option <?php if ($langS == $lang){echo 'selected';}?> value=<?=$lang->getLang()?>><?=$lang->getName()?></option>;
        <?php } ?>
      </select>
    </div>
    <div class="col-x-4">
      <input type="submit" class="btn btn-info" value="<?php echo text('TRANSLATE') ?>">
    </div>
    <div class="col">
      <select class="form-control" name="LANGT" data-live-search="true">
        <?php foreach($langs as $lang) { ?>
          <option  <?php if ($langT == $lang){echo 'selected';} ?> value=<?=$lang->getLang()?>><?=$lang->getName()?></option>;
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-row">
    <div class="col">
      <textarea class="form-control" style="resize: none;" rows="5" name="SENTENCE"><?php echo $sentenceS ?></textarea>
    </div>
    <div class="col">
      <textarea class="form-control" style="resize: none;" rows="5" name="TRANSLATED" readonly><?php echo $translated; ?></textarea>
    </div>
  </div>
</form>
