<!-- use a facet helper method to get all facets! from config file or param -->

<?php 
	$topics = ['Android', 'Windows 8', 'Tools'];
	$extensions = ['mp4', 'jpg', 'pdf'];
?>

<fieldset>
	<label>Types</label>
	<?php foreach($topics as $topic){ ?>
		<?php if(!in_array($topic, $this->oldInput['tags'])){ ?>
			<label><input name="topics[]" type="checkbox" value="<?php echo $topic; ?>"
				<?php echo in_array($topic, $this->oldInput['topics']) ? 'checked' : ''; ?>
			>
				<?php echo $topic; ?>
			</label>
		<?php } ?>
	<?php } ?>
</fieldset>

<hr>
 
<fieldset>
	<label>Extensions</label>
	<?php foreach($extensions as $extension){ ?>
		<?php if(!in_array($extension, $this->oldInput['tags'])){ ?>
			<label><input name="extensions[]" type="checkbox" value="<?php echo $extension; ?>"
				<?php echo in_array($extension, $this->oldInput['extensions']) ? 'checked' : ''; ?>
			>
				<?php echo $extension; ?>
			</label>
		<?php } ?>
	<?php } ?>
</fieldset>