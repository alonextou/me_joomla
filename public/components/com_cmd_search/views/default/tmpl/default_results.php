<?php foreach ($this->response['results'] as $result) { ?>
<div class="result">

	<?php $source = $result['_source']; ?>

	<?php if(!empty($source['flags'])) { ?>
	<div class="flags">
		<?php foreach ($source['flags'] as $flag) { ?>
			<!-- TODO: change URL to default search menu item param -->
			<a href="<?php echo JRoute::_('/search?flags='.$flag); ?>">
				<span class="topic <?php echo strtolower(preg_replace('/\s+/', '-', $flag)); ?>">
					<?php echo $flag; ?>
				</span>
			</a>
		<?php } ?>
	</div>
	<?php } ?>

	<h3 class="title">
		<a href="index.php?option=com_cmd_search&view=result&id=<?php echo $source['id']; ?>">
			<?php echo $source['title']; ?>
		</a>
	</h3>

	<div class="tags">
		<?php if(!empty($source['topics'])) { ?>
		<div class="topics">
			<?php foreach ($source['topics'] as $topic) { ?>
				<span class="tag">
					<!-- TODO: change URL to default search menu item param -->
					<a href="<?php echo JRoute::_('/search?topics='.$topic); ?>" class="label">
						<?php echo $topic; ?>
					</a>
				</span>
			<?php } ?>
		</div>
		<?php } ?>

		<?php if(!empty($source['asset-types'])) { ?>
		<div class="types">
			<?php foreach ($source['asset-types'] as $type) { ?>
				<span class="type">
					<!-- TODO: change URL to default search menu item param -->
					<a href="<?php echo JRoute::_('/search?types='.$type); ?>" class="label label-info">
						<?php echo $type; ?>
					</a>
				</span>
			<?php } ?>
		</div>
		<?php } ?>
	</div>

	<?php if(!empty($source['introtext'])) { ?>
		<div class="introtext">
			<p><?php echo $source['introtext']; ?></p>
		</div>
	<?php } ?>

</div>
<?php } ?>