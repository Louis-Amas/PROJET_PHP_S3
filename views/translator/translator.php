<?php global $lang ?>
<?php $information = "{}";
if ($_GET['information']) {
  $information = $_GET['information'];
} ?>
<script>
$( document ).ready(function() {
  var informations = JSON.parse('<?= $information?>');
  if (informations.begin && informations.translated) {
    $('select[name="LANGS"]').val(informations.begin.language);
    $('select[name="LANGT"]').val(informations.translated.language);
    $('textarea[name="SENTENCE"]').val(informations.begin.sentence);
    $('textarea[name="TRANSLATED"]').val(informations.translated.sentence);
  }
});
</script>
<form action="<?= $path ?>" method="post">
  <div class="form-row">
    <div class="col">
      <select class="form-control" name="LANGS">
        <?php foreach($langs as $lang) { ?>
          <option><?=$lang?></option>;
        <?php } ?>
      </select>
    </div>
    <div class="col-x-4">
      <input type="submit" class="btn btn-info" value="Translate">
    </div>
    <div class="col">
      <select class="form-control" name="LANGT">
        <?php foreach($langs as $lang) { ?>
          <option><?=$lang?></option>;
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-row">
    <div class="col">
      <textarea class="form-control" style="resize: none;" rows="5" name="SENTENCE"></textarea>
    </div>
    <div class="col">
      <textarea class="form-control" style="resize: none;" rows="5" name="TRANSLATED" readonly></textarea>
    </div>
  </div>
</form>
