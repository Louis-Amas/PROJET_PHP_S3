<h3> <? echo text(MY_ASK) ?> </h3>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col"> <?php echo text('USER'); ?></th>
      <th scope="col"><?php echo text('SENTENCE')?></th>
      <th scope="col"><?php echo text('LANG_FROM')?></th>
      <th scope="col"><?php echo text('LANG_ASKED')?></th>
      <th scope="col"><?php echo text('STATUS')?></th>
    </tr>
  </thead>
  <tbody>
    <?
    foreach ($listAsk as $key => $value) { ?>
    <tr>
      <th scope="row"><? echo $value->getId() ?></th>
      <td><? echo User::findById($value->getAuthor())->getUsername() ?></td>
      <td><? echo $value->getSentence() ?></td>
      <td><? echo Lang::findByAcro($value->getLangs())->getName() ?></td>
      <td><? echo Lang::findByAcro($value->getLangd())->getName()?></td>
      <td><? echo $value->getStatus() ?></td>
    </tr>
  <? } ?>
  </tbody>
</table>
<? if (Util::can_acces('TRA')) {?>
<h3> <? echo text(ALL_ASK) ?> </h3>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">
        Action
      </th>
      <th scope="col"> <?php echo text('USER'); ?></th>
      <th scope="col"><?php echo text('SENTENCE')?></th>
      <th scope="col"><?php echo text('LANG_FROM')?></th>
      <th scope="col"><?php echo text('LANG_ASKED')?></th>
      <th scope="col"><?php echo text('STATUS')?></th>
    </tr>
  </thead>
  <tbody>
    <?
    foreach ($listAll as $key => $value) { ?>
    <tr>
      <th scope="row"><? echo $value->getId() ?>
        <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#addSentence" data-langOr="<? echo $value->getLangs() ?>" data-langDest="<? echo $value->getLangd() ?>"> <? echo text('ADD_A_NEW_SENTENCE') ?></button>
      </th>
      <td><? echo User::findById($value->getAuthor())->getUsername() ?></td>
      <td><? echo $value->getSentence() ?></td>
      <td><? echo Lang::findByAcro($value->getLangs())->getName() ?></td>
      <td><? echo Lang::findByAcro($value->getLangd())->getName()?></td>
      <td><? echo $value->getStatus()?></td>
    </tr>
  <? } ?>
  </tbody>
</table>


<!-- Modal form add a new sentence  -->
<div class="modal fade" id="addSentence" tabindex="-1" role="dialog" aria-labelledby="AddNewSentence" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo text('ADD_A_NEW_SENTENCE') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-danger"><?php echo text('WARNING_ADDING_TRAD') ?></p>
        <form action="#" method="post">
          <div class="form-group">
            <input readonly id='langFrom' name=langFrom value="<?php echo text('LANG_FROM') ?>"> </input>
            <textarea name="SENTENCE" class="form-control" id="theSentence" rows="3"></textarea>
          </div>
          <div class="form-group">
            <input readonly id='langTo' name=langTo value="<?php echo text('LANG_ASKED') ?>" ></input>
            <textarea name="SENTENCE" class="form-control" id="theSentence" rows="3"></textarea>
          </div>

          <button type="summit" class="btn btn-primary"><?php echo text('ADD') ?></button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo text('ABORT') ?></button>
      </div>
    </div>
  </div>
</div>

<script>
$('#addSentence').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('id') // Extract info from data-* attributes
  var langTO = button.data('langDest');
  var langFROM = button.data('langOr');
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('#langFrom').val(langFROM)
  modal.find('#langTo').val(langTO)
})
</script>
<? } ?>
