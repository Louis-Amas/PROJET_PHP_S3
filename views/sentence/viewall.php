<?php global $lang ?>

<div class="card card-body">
  <h5> Filters: </h5>
  <form method="post">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="true" name='ONLYMISSING' id="defaultCheck1">
      <label class="form-check-label" for="defaultCheck1">
        <?php echo text('SEE_ONLY_SENTENCES_WITH_MISSING_TRANSLATION') ?>
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="true" name='ONLYBASIC' id="defaultCheck1">
      <label class="form-check-label" for="defaultCheck1">
        <?php echo text('SEE_ONLY_BASIC_SENTENCES_(INTERNAL_TRANSLATION)') ?>
      </label>
    </div>
    <div class="form-group">
      <label><?php echo text('LANGUAGE_SELECTION') ?></label>
      <select multiple class="form-control" id="exampleFormControlSelect2" name ="LANGUAGESSELECTED[]">
        <?php
        foreach ($allLangs as $key => $lang) {
          echo '<option value="'.$lang->getLang().'">'.ucfirst($lang->getName()).'</option>';
        }
        ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary"><?php echo text('APPLY') ?></button>
  </form>
</div>


<table class="table table-hover table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <?php
      foreach ($listLangs as $index => $langVal) {
        echo '<th class="text-center" scope="col">'.ucfirst($langVal->getName()).'</th>';
      }
      ?>
      <th class="text-center" scope="col">
        <a class="btn btn-outline-success btn-sm" href="#" role="button" data-toggle="modal" data-target="#addLanguage"><?php echo text('ADD_A_NEW_LANGUAGE') ?></a>
      </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($listSentencesByID as $key => $value) { ?>
      <tr>
        <th scope="row"> <?php echo'<button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#addTranslation" data-id="'.$key.'">'.$key.'</button>' ;?></th>
        <?php foreach ($listLangs as $key1 => $lang) {
          $sentence = $value[$lang->getLang()];
          if (!is_null($sentence)){
            echo '<td> '.$sentence.'</td>';
          } else {
            echo '<td class="text-center"> <a class="btn btn-outline-primary" href="#" role="button" data-toggle="modal" data-target="#addTranslation" data-id="'.$key.'" data-lang="'.$lang.'">Add a translation</a></td>';
          }
        }?>
      </tr>
    <?php } ?>
    <tr class="bg-success">
      <th scope="row">  </th>
      <td class="text-center"  data-toggle="modal" data-target="#addSentence" colspan= <?php echo '"'.(count($listLangs) + 1).'"'?>> <button type="button" class="btn btn-dark"><?php echo text('ADD_A_NEW_SENTENCE') ?></button> </td>
    </tr>
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
        <p class="text-danger"><?php echo text('BE_SURE_THAT_THERE_IS_NO_AVAILABLE_TRANSLATION_FOR_THIS_SENTENCE_BEFORE_ADDING_A_NEW_ONE!') ?></p>
        <form action="<?php echo $path ?>" method="post">
          <div class="form-group">
            <select class="form-control" name="LANG">
              <?php foreach($listLangs as $lang) { ?>
                <option <?php if ($langS == $lang){echo 'selected';}?> value=<?=$lang->getLang()?>><?=$lang->getName()?></option>;
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="theSentence"><?php echo text('YOUR_SENTENCE') ?></label>
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
<!-- Modal form add a translation -->
<div class="modal fade" id="addTranslation" tabindex="-1" role="dialog" aria-labelledby="AddNewTranslation" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo text('ADD_A_NEW_TRANSLATION') ?><span id="badge" class="badge badge-info">ID</span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning"> <strong> Note: </strong><?php echo text('WARNING_ADD_TRANSLATION') ?> </div>
        <form action="<?php echo $path ?>" method="post" id='form'>
          <div class="form-group d-none">
            <label for="staticEmail" class="col-sm-2 col-form-label"><?php echo text('Sentence_ID') ?></label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control-plaintext" id="sentenceID" value="Sentence ID" name="SENTENCEID">
            </div>
          </div>
          <div class="form-group">
            <label><?php echo text('LANGUAGE') ?></label>
            <select id="LANGSELECT" class="form-control" name="LANG">
              <?php foreach($listLangs as $lang) { ?>
                <option <?php if ($langS == $lang){echo 'selected';}?> value=<?=$lang->getLang()?>><?=$lang->getName()?></option>;
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="theSentence"><?php echo text('YOUR_SENTENCE') ?></label>
            <textarea name="SENTENCE" class="form-control" id="theSentence" rows="3"></textarea>
          </div>
          <button type="summit" class="btn btn-primary"><?php echo text('ADD') ?></button>
          <button type="reset" class="btn btn-primary"><?php echo text('RESET') ?></button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo text('ABORT') ?></button>
      </div>
    </div>
  </div>
</div>

<script>
$('#addTranslation').on('shown.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('id') // Extract info from data-* attributes
  var lang = button.data('lang');
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-body input').val(recipient)
  modal.find('#LANGSELECT').val(lang)
  modal.find('.badge').text('ID: '+recipient)

})


</script>


<!-- Modal form add a new language  -->
<div class="modal fade" id="addLanguage" tabindex="-1" role="dialog" aria-labelledby="AddNewLanguage" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo text('ADD_A_NEW_LANGUAGE') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php if (Util::can_acces('ADM')) {?>
        <form action="<?php echo $path ?>" method="post">
          <div class="form-group">
            <label><?php echo text('THE_NEW_LANGUAGE_CODE:') ?></label>
            <textarea name="LANGUAGECODE" class="form-control" id="theLanguageCode" rows="1"></textarea>
          </div>
          <div class="form-group">
            <label><?php echo text('THE_NEW_LANGUAGE_NAME:') ?></label>
            <textarea name="LANGUAGENAME" class="form-control" id="theLanguageName" rows="1"></textarea>
          </div>
          <button type="summit" class="btn btn-primary"><?php echo text('ADD') ?></button>
        </form>
      <?php }else{?>
        <div class="alert alert-danger" role="alert">
          <?php echo text('YOU_MUST_BE_AN_ADMINISTRATOR_IN_ORDER_TO_ADD_A_LANGAGE') ?>
        </div>
      <?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo text('ABORT') ?></button>
      </div>
    </div>
  </div>
</div>
