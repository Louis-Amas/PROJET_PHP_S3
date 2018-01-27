<?php global $lang ?>
<table class="table table-hover table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <?php
        foreach ($listLangs as $key => $value) {
          echo '<th class="text-center" scope="col">'.ucfirst($value->getName()).'</th>';
        }
      ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($listSentencesByID as $key => $value) { ?>
      <tr>
        <th scope="row"> <?php echo $key ;?></th>
        <?php foreach ($listLangs as $key => $lang) {
          $sentence = $value[$lang->getLang()];
          if (!is_null($sentence)){
            echo '<td> '.$sentence.'</td>';
          } else {
            echo '<td class="text-center"> <a class="btn btn-primary" href="#" role="button">Add a translation</a></td>';
          }
        }?>
      </tr>
    <?php } ?>
      <tr class="bg-success">
        <th scope="row">  </th>
        <td class="text-center"  data-toggle="modal" data-target="#addSentence" colspan= <?php echo '"'.count($listLangs).'"'?>> <button type="button" class="btn btn-dark">Add a new sentence</button> </td>
      </tr>
  </tbody>
</table>

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
