
<h1><?php echo text('MAIN_TEXT_0') ?></h1>
<p>
	<?php echo text('MAIN_TEXT_1');
	echo text('MAIN_TEXT_2');
	echo text('MAIN_TEXT_3');
	echo text('MAIN_TEXT_4');
	?>
</p>

<h3> <? echo text('LANGUAGE_SELECTION') ?> </h3>
<form class = "form-inline" action ="#" method="post">
	<div class="form-row">
		<div class="form-group">
			<select name="LANGSELECT" class="form-control form-control-sm">
				<?php foreach ($allLangs as $key => $value) {
					if ($value->getLang() != 'basic') {?>
						<option value="<?echo $value->getLang();?>" > <? echo ucfirst($value->getName()) ?></option>
					<?php }} ?>
				</select>
			</div>
				<input type="submit" class="btn btn-info btn-sm" value="<?echo text('APPLY')?>">

		</div>
	</form>
