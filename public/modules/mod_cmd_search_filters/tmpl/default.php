<?php
	$input = JRequest::get();
	$oldInput = $input['oldInput'];
	//$topics = ['Android', 'Windows 8', 'Tools'];
	//$extensions = ['mp4', 'jpg', 'pdf'];
	//var_dump($facetFilters);

?>
<div class="gss-menu-filters">
	<h3>Filter By:</h3>

	<form id="cmd-search-filters" method="POST" action="">
	
	<?php foreach($facetFilters as $facet => $filters){ ?>
	<fieldset>
		<legend><?php echo $facet; ?></legend>
		<?php foreach($filters as $value){ ?>
			<?php if(!in_array($value, $oldInput['tags'])){ ?>
				<?php $facet = strtolower(preg_replace('/\s+/', '-', $facet)); ?>
				<label><input name="<?php echo $facet; ?>[]" type="checkbox" value="<?php echo $value; ?>"
					<?php echo in_array($value, $oldInput[$facet]) ? 'checked' : ''; ?>
				>
					<?php echo $value; ?>
				</label>
			<?php } ?>
		<?php } ?>
	</fieldset>

	<?php } ?>

	<button id="cmd-search-submit" type="submit">Update</button>

	</form>
</div>