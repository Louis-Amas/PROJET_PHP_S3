<form action="<?php  echo $path ?>" method="post">
    <div class="form-row"> 
        <div class="form-group">     
            <label for="langs"> Lang source </label>   
            <select class="form-control" name="LANGS">
                <?php foreach($langs as $lang) { ?>
                <option value=<?= $lang->getLang()?>> <?=$lang->getName()?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">  
            <label for="LANGD">Langue destination</label>
            <select class="form-control" name="LANGD">
                <?php foreach($langs as $lang) { ?>
                <option value=<?= $lang->getLang()?>> <?=$lang->getName()?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-row">
        <textarea class="form-control" style="resize: none;" rows="5" name="SENTENCE"></textarea>
    </div>
    <div class="form-row">
      <input type="submit" class="btn btn-info" value="Ask for traduction">
    </div>
</form>