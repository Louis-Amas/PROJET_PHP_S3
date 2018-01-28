<?php global $lang ?>

<div class="card card-body">
  <h5> Filters: </h5>
  <form method="post">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="true" name='ONLYMISSING' id="defaultCheck1">
      <label class="form-check-label" for="defaultCheck1">
        See only sentences with missing translation
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="true" name='ONLYBASIC' id="defaultCheck1">
      <label class="form-check-label" for="defaultCheck1">
        See only 'Basic' sentences (internal translation)
      </label>
    </div>
    <div class="form-group">
      <label>Language selection</label>
      <select multiple class="form-control" id="exampleFormControlSelect2" name ="LANGUAGESSELECTED[]">
        <?php
        foreach ($allLangs as $key => $lang) {
          echo '<option value="'.$lang->getLang().'">'.ucfirst($lang->getName()).'</option>';
        }
        ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Apply</button>
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
        <a class="btn btn-outline-success btn-sm" href="#" role="button" data-toggle="modal" data-target="#addLanguage">Add a new language</a>
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
      <td class="text-center"  data-toggle="modal" data-target="#addSentence" colspan= <?php echo '"'.(count($listLangs) + 1).'"'?>> <button type="button" class="btn btn-dark">Add a new sentence</button> </td>
    </tr>
  </tbody>
</table>
<!-- Modal form add a new sentence  -->
<div class="modal fade" id="addSentence" tabindex="-1" role="dialog" aria-labelledby="AddNewSentence" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add a new sentence</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-danger">Be sure that there is no available translation for this sentence before adding a new one!</p>
        <form action="<?php echo $path ?>" method="post">
          <div class="form-group">
            <select class="form-control" name="LANG">
              <?php foreach($listLangs as $lang) { ?>
                <option <?php if ($langS == $lang){echo 'selected';}?> value=<?=$lang->getLang()?>><?=$lang->getName()?></option>;
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="theSentence">Your sentence</label>
            <textarea name="SENTENCE" class="form-control" id="theSentence" rows="3"></textarea>
          </div>
          <button type="summit" class="btn btn-primary">Add</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Abort</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal form add a translation -->
<div class="modal fade" id="addTranslation" tabindex="-1" role="dialog" aria-labelledby="AddNewTranslation" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add a new translation <span id="badge" class="badge badge-info">ID</span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning"> <strong> Note: </strong> Editing the 'basic' language can break the site! Please do not edit it if you don't know what are you doing !</div>
        <form action="<?php echo $path ?>" method="post" id='form'>
          <div class="form-group d-none">
            <label for="staticEmail" class="col-sm-2 col-form-label">Sentence ID</label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control-plaintext" id="sentenceID" value="Sentence ID" name="SENTENCEID">
            </div>
          </div>
          <div class="form-group">
            <label>Language</label>
            <select id="LANGSELECT" class="form-control" name="LANG">
              <?php foreach($listLangs as $lang) { ?>
                <option <?php if ($langS == $lang){echo 'selected';}?> value=<?=$lang->getLang()?>><?=$lang->getName()?></option>;
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="theSentence">Your sentence</label>
            <textarea name="SENTENCE" class="form-control" id="theSentence" rows="3"></textarea>
          </div>
          <button type="summit" class="btn btn-primary">Add</button>
          <button type="reset" class="btn btn-primary">Reset</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Abort</button>
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
        <h5 class="modal-title" id="exampleModalLongTitle">Add a new langage</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php if (Util::can_acces('ADM')) {?>
        <form action="<?php echo $path ?>" method="post">
          <div class="form-group">
            <label>The new language code:</label>
            <textarea name="LANGUAGECODE" class="form-control" id="theLanguageCode" rows="1"></textarea>
          </div>
          <div class="form-group">
            <label>The new language name:</label>
            <textarea name="LANGUAGENAME" class="form-control" id="theLanguageName" rows="1"></textarea>
          </div>
          <button type="summit" class="btn btn-primary">Add</button>
        </form>
      <?php }else{?>
        <div class="alert alert-danger" role="alert">
          You must be an administrator in order to add a langage
        </div>
      <?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Abort</button>
      </div>
    </div>
  </div>
</div>
