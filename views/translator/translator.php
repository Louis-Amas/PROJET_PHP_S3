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

<? if ($showModal) {?>
<div class="modal" id="premiumAsk" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> <? echo text('USER_ASK')?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><? echo text('USER_ASK_INFO')?>.</p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" href="/?controller=translator&action=askForTranslate" role="button"><? echo text('APPLY')?></a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><? echo text('ABORT')?></button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#premiumAsk').modal('show');
</script>
<? } ?>
