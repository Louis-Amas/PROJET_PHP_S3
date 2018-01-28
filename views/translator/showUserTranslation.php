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
